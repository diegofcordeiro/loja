<?php

require_once("../_system/mysql.php");
require_once("../../_config.php");

define("SERVIDOR", $config['SERVIDOR']);
define("USUARIO", $config['USUARIO']);
define("SENHA", $config['SENHA']);
define("BANCO", $config['BANCO']);

function get($string) {
	$string = str_replace(array("<", ">", "\\", "?", "#"), "", $_GET[$string]);
	$string = strip_tags($string);
	$string = (get_magic_quotes_gpc()) ? $string : addslashes($string);
	$string = ($string == null ? 'inicial' : $string);
	$string = trim($string);
	return $string;
}

$arquivo = "mercadopago.log";
function  geralog($arquivo, $texto){

	$data = date('d-m-y');
	$hora = date('H:i:s');
	//Nome do arquivo:
	$arquivo = "../arquivos/logs/$arquivo";
	//Texto a ser impresso no log:
	$texto = " \n [$data][$hora] > ".utf8_decode($texto)." \n";
	$manipular = fopen("$arquivo", "a+b");
	fwrite($manipular, $texto);
	fclose($manipular);
}


// parte do mercado pago

$id = get('id');
$tipo = get('topic');

// config pagamento
$db = new mysql();
$exec = $db->executar("SELECT * FROM pagamento where id='8' ");
$data_pagamentos = $exec->fetch_object();

require_once('vendor/autoload.php');

MercadoPago\SDK::setAccessToken("$data_pagamentos->mercadopago_access_token");
MercadoPago\SDK::setClientId("$data_pagamentos->mercadopago_client_id");
MercadoPago\SDK::setClientSecret("$data_pagamentos->mercadopago_client_secret");


if($id AND $tipo){

	geralog($arquivo, "1- Novo Retorno de dados - ID: $id, tipo: $tipo");

	$merchant_order = null;
	switch($tipo){
		case "payment":
		$payment = MercadoPago\Payment::find_by_id($id);

		$merchant_order = MercadoPago\MerchantOrder::find_by_id($id);
		break;

		case "plan":
		$plan = MercadoPago\Plan.find_by_id($id);
		break;

		case "subscription":
		$plan = MercadoPago\Subscription.find_by_id($id);
		break;

		case "invoice":
		$plan = MercadoPago\Invoice.find_by_id($id);
		break;

		case "merchant_order":
		$merchant_order = MercadoPago\MerchantOrder::find_by_id($id);
		break;
	}


	$paid_amount = 0;
	if ($payment->status == 'approved'){
		$paid_amount += $payment->transaction_amount;
	}

	// print_r($payment);

	if($paid_amount >= $payment->transaction_amount){
        if ($merchant_order->shipments > 0) { // The merchant_order has shipments
        	if($merchant_order->shipments[0]->status == "ready_to_ship") {
        		print_r("Totally paid. Print the label and release your item.");
        	}
        } else {

        	print_r("Totally paid. Release your item.<br>");
			
        	$id_pedido = $payment->external_reference;
        	$ext_email = $payment->payer->email;
        	$ext_val = $payment->transaction_amount;

        	if($id_pedido){

        		$db = new mysql();
        		$exec = $db->executar("SELECT * FROM pedido_loja where codigo='$id_pedido' AND status<'4' ");				
        		if($exec->num_rows == 1){

        			$data_pedido = $exec->fetch_object();

        			if($data_pedido->id){

        				$db = new mysql();
        				$db->alterar("pedido_loja",  array(
        					"valor_pago"=>$data_pedido->valor_total,
        					"status"=>4
        				), " codigo='$id_pedido' ");
        				
        				geralog($arquivo, "2- Pagamento aprovado Pedido: $id_pedido");
        				
        			} else {
        				geralog($arquivo, "3- Pedido não encontrado: $id_pedido");
        			}
        		} else {


        			$db = new mysql();
        			$exec = $db->executar("SELECT * FROM imoveis_pedidos where codigo='$id_pedido' AND status<'2' ");				
        			if($exec->num_rows == 1){

        				$data_pedido = $exec->fetch_object();

        				if($data_pedido->id){

        					$db = new mysql();
        					$db->alterar("imoveis_pedidos",  array(
        						"status"=>2
        					), " codigo='$id_pedido' ");

        					geralog($arquivo, "2- Pagamento aprovado Pedido: $id_pedido");

        				} else {
        					geralog($arquivo, "3- Pedido não encontrado: $id_pedido");
        				}
        				
        			} else {

        				$db = new mysql();
        				$exec = $db->executar("SELECT * FROM classificados_pedidos where codigo='$id_pedido' AND status<'2' ");               
        				if($exec->num_rows == 1){

        					$data_pedido = $exec->fetch_object();

        					if($data_pedido->id){

        						$db = new mysql();
        						$db->alterar("classificados_pedidos",  array(
        							"status"=>2
        						), " codigo='$id_pedido' ");

        						geralog($arquivo, "2- Pagamento aprovado Pedido: $id_pedido");

        					} else {
        						geralog($arquivo, "3- Pedido não encontrado: $id_pedido");
        					}

        				} else {
        					geralog($arquivo, "4- Erro no pedido talvez ja esteja aprovado: $id_pedido");
        				}

        			}

        		}
        	} else {
        		geralog($arquivo, "5- Pedido não encontrado");
        	}

        }
    } else {
    	print_r("Not paid yet. Do not release your item.");
    }

} 