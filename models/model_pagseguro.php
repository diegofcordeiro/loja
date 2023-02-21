<?php

Class model_pagseguro extends model{
	
    public function parcelamento( $valor ){
    	
    	$valores = new model_valores();
    	
		//numero máximo de parcelas
		$parcelas = 10;
		$valor_minimo = 5.00;
		$valor_parcela = $valor;
		
		//calculo parcelas
		$parcelas_1 = $valores->trata_valor_calculo($valor * 1.00000);
		$parcelas_2 = $valores->trata_valor_calculo($valor * 0.52255);
		$parcelas_3 = $valores->trata_valor_calculo($valor * 0.35347);
		$parcelas_4 = $valores->trata_valor_calculo($valor * 0.26898);
		$parcelas_5 = $valores->trata_valor_calculo($valor * 0.21830);
		$parcelas_6 = $valores->trata_valor_calculo($valor * 0.18453);
		$parcelas_7 = $valores->trata_valor_calculo($valor * 0.16044);
		$parcelas_8 = $valores->trata_valor_calculo($valor * 0.14240);
		$parcelas_9 = $valores->trata_valor_calculo($valor * 0.12838);
		$parcelas_10 = $valores->trata_valor_calculo($valor * 0.11717);
		$parcelas_11 = $valores->trata_valor_calculo($valor * 0.10802);
		$parcelas_12 = $valor * 0.10040;
		
		if($parcelas_1 > $valor_minimo){
			$valor_parcela = $parcelas_1;
			$parcelas = 1;

			if($parcelas_2 > $valor_minimo){
				$valor_parcela = $parcelas_2;
				$parcelas = 2;

				if($parcelas_3 > $valor_minimo){
					$valor_parcela = $parcelas_3;
					$parcelas = 3;

					if($parcelas_4 > $valor_minimo){
						$valor_parcela = $parcelas_4;
						$parcelas = 4;

						if($parcelas_5 > $valor_minimo){
							$valor_parcela = $parcelas_5;
							$parcelas = 5;

							if($parcelas_6 > $valor_minimo){
								$valor_parcela = $parcelas_6;
								$parcelas = 6;

								if($parcelas_7 > $valor_minimo){
									$valor_parcela = $parcelas_7;
									$parcelas = 7;

									if($parcelas_8 > $valor_minimo){
										$valor_parcela = $parcelas_8;
										$parcelas = 8;

										if($parcelas_9 > $valor_minimo){
											$valor_parcela = $parcelas_9;
											$parcelas = 9;

											if($parcelas_10 > $valor_minimo){
												$valor_parcela = $parcelas_10;
												$parcelas = 10;

												if($parcelas_11 > $valor_minimo){
													$valor_parcela = $parcelas_11;
													$parcelas = 11;

													if($parcelas_12 > $valor_minimo){
														$valor_parcela = $parcelas_12;
														$parcelas = 12;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$valor_parcelado = $valor_parcela;

		//retorna texto
		return $parcelas."x de R$ ".$valores->trata_valor($valor_parcelado)." com PagSeguro";
	}


	////////////////////////////////////////////////////////////////////////////////////
	// pagamento antiga api pagseguro ( para funcionar deve liberar o pagaemnto em formato html no painel do pagseguro)
	public function pagamento_html($pedido){
		
		$valores = new model_valores();

		// dados de configuração pagseguro
		$conexao = new mysql();
		$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='1' ");
		$data_pagamento = $coisas_pagamento->fetch_object(); 

		// dados do pedido
		$conexao = new mysql();
		$coisas_pedido = $conexao->Executar("SELECT * FROM pedido_loja WHERE codigo='$pedido' ");
		$data_pedido = $coisas_pedido->fetch_object(); 

		// dados do cadastro
		$model_cadastro = new model_cadastro();
		$data_dados = $model_cadastro->dados_usuario($data_pedido->cadastro);

		// email pagseguro
		$email_pagseguro = $data_pagamento->email_pagseguro;

		// converte valores para pagseguro
		$valor_tratado = str_replace(".", "", $valores->trata_valor($data_pedido->valor_total));
		$valor_tratado = str_replace(",", ".", $valor_tratado);
		$descricao = "Pedido $data_pedido->id";

		$retorno = '
		<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta charset="utf-8">
			</head>

			<body>
			<form name="auto_enviar" id="auto_enviar" method="post" action="'.URL_PAGSEGURO.'/v2/checkout/payment.html" >

				        <!-- Campos obrigatórios -->  
				        <input type="hidden" name="receiverEmail" value="'.$email_pagseguro.'">  
				        <input type="hidden" name="currency" value="BRL">

				        <input type="hidden" name="itemId1" value="0001">  
				        <input type="hidden" name="itemDescription1" value="'.$descricao.'">  
				        <input type="hidden" name="itemAmount1" value="'.$valor_tratado.'">
				        <input type="hidden" name="itemQuantity1" value="1">

				        <input type="hidden" name="reference" value="'.$data_pedido->codigo.'" >

				        <input type="hidden" name="senderName" value="">
				        <input type="hidden" name="senderEmail" value="'.$data_dados->email.'">

				<div style="font-size:16px; color:#666 padding-bottom:10px;">caso você não seja redirecionado automaticamente, clique no botão abaixo!</div>

				<div><input type="image" name="submit" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif" alt="Pague com PagSeguro"></div>

			</form>

			<script>
				var myForm = document.getElementById("auto_enviar");
				myForm.submit();
			</script>
			    	
			</body>
		</html>
		';

		echo $retorno;
		exit;
	}


	////////////////////////////////////////////////////////////////////////////////////
	// nova api pagseguro
	public function pagamento($pedido, $cadastro, $descricao, $valor_total){

		$retorno = array();
		$retorno['erro'] = 2;
		$retorno['erro_msg'] = '';
		$retorno['code'] = '';

		$valores = new model_valores();

		// dados de configuração pagseguro
		$conexao = new mysql();
		$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='1' ");
		$data_pagamento = $coisas_pagamento->fetch_object();		 

		// dados do cadastro
		$model_cadastro = new model_cadastro(); 
		if($data_dados = $model_cadastro->dados_usuario($cadastro)){

			// email pagseguro
			$email_pagseguro = $data_pagamento->email_pagseguro;

			// converte valores para pagseguro
			$valor_tratado = str_replace(".", "", $valores->trata_valor($valor_total));
			$valor_tratado = str_replace(",", ".", $valor_tratado);			 

			// dadps
			if($data_dados->tipo == 'F'){
				$nome = $data_dados->fisica_nome;
				$documento = $data_dados->fisica_nome;
				$documento_tipo = "CPF";
			} else {
				$nome = $data_dados->juridica_razao; 
				$documento = $data_dados->juridica_cnpj; 
				$documento_tipo = "CNPJ";
			}

			$telefone_limpo = str_replace(array("(", ")", " ", "-", "."), "", $data_dados->telefone);
			$ddd = substr($telefone_limpo, 0, 2);
			$fone = substr($telefone_limpo, 2);

			$data = array();

			$data['token'] = $data_pagamento->token_retorno_pagseguro;
			$data['email'] = $email_pagseguro;
			$data['currency'] = 'BRL';
			$data['reference'] = $pedido;

			$data['itemId1'] = '0001';
			$data['itemQuantity1'] = '1';
			$data['itemDescription1'] = $descricao;
			$data['itemAmount1'] = $valor_tratado;

			$data['senderName'] = $nome;
			$data['senderAreaCode'] = $ddd;
			$data['senderPhone'] = $fone;
			$data['senderEmail'] = $data_dados->email;

			$data['shippingType'] = 3;
			$data['shippingAddressStreet'] = $data_dados->endereco;
			$data['shippingAddressNumber'] = $data_dados->numero;
			$data['shippingAddressComplement'] = $data_dados->complemento;
			$data['shippingAddressDistrict'] = $data_dados->bairro;
			$data['shippingAddressPostalCode'] = str_replace(array(" ", "-", "."), "", $data_dados->cep);
			$data['shippingAddressCity'] = $data_dados->cidade;
			$data['shippingAddressState'] = $data_dados->estado;
			$data['shippingAddressCountry'] = 'BRA';
			
			$url = WS_URL_PAGSEGURO.'v2/checkout';
			$data = http_build_query($data);
			$curl = curl_init($url);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			$xml = curl_exec($curl);		
			curl_close($curl);
			$xml = simplexml_load_string($xml);
			echo '<pre>'; print_r($xml); exit;
			if($xml != 'Unauthorized'){

				if(count($xml->error) > 0){
					$retorno['erro'] = 1;
					$retorno['erro_msg'] = $xml->error->message;
					$retorno['code'] = '';
				} else {
					$retorno['erro'] = 0;
					$retorno['erro_msg'] = '';
					$retorno['code'] = $xml->code;
				}
				
			} else {
				$retorno['erro'] = 1;
				$retorno['erro_msg'] = 'Pagamento não autorizado!';
				$retorno['code'] = '';
			}
			
		} else {
			$retorno['erro'] = 1;
			$retorno['erro_msg'] = 'Faça o login e tente novamente!';
			$retorno['code'] = '';
		}
		
		return $retorno;
	}
	
    
}