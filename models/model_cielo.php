<?php

use CieloLink\API\Environment;
use CieloLink\API\CieloLink;
use CieloLink\API\Payment;
use CieloLink\API\Shipping;
use CieloLink\API\Recurrent;

require_once 'vendor3/autoload.php';

Class model_cielo extends model{
	
	public function pagamento($pedido, $cadastro, $descricao, $valor_total){

		$retorno = array();
		$retorno['erro'] = 2;
		$retorno['erro_msg'] = '';
		$retorno['code'] = '';
		
		$valores = new model_valores();
		
		// dados de configuração
		$conexao = new mysql();
		$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='6' ");
		$data_pagamento = $coisas_pagamento->fetch_object();
		
		// dados do cadastro
		$model_cadastro = new model_cadastro(); 
		
		if($data_dados = $model_cadastro->carregar($cadastro)){
			
			// converte valores
			$valor_tratado = str_replace(".", "", $valores->trata_valor($valor_total));
			$valor_tratado = str_replace(",", ".", $valor_tratado);

			$cep_tratado = str_replace("-", "", $data_dados->cep);

			$clientId      = $data_pagamento->cielo_clientId;
			$clientSecret  = $data_pagamento->cielo_clientSecret;
			$environment    = Environment::production();

			$cieloLink = new CieloLink($clientId, $clientSecret, $environment);
			
			$payment = new Payment();
			$payment->setType(Payment::TYPE_RECURRENT);
			$payment->setName($descricao);
			$payment->setExpirationDate("2037-06-19");
			$payment->setDescription($descricao);
			$payment->setPrice($valor_tratado);
			$payment->setShowDescription(true);
			$payment->setSoftDescriptor($pedido);
			
			$payment->shipping()
			->setName($data_dados->fisica_nome)
			->setOriginZipCode($cep_tratado)
			->setPrice(0)
			->setType(Shipping::TYPE_WITHOUT_SHIPPING);
			
			$payment->recurrent()
			->setEndDate("2030-01-27")
			->setInterval(Recurrent::TYPE_MONTHLY);
			echo '<pre>';
			print_r($payment);
			exit;
			$responsePayment = $cieloLink->create($payment);
			
			$redirectURL = $responsePayment->getshortUrl();
			$code = $responsePayment->getId();
			
			if($redirectURL){
				
				$retorno['erro'] = 0;
				$retorno['erro_msg'] = '';
				$retorno['code'] = $code;
				$retorno['endereco'] = $redirectURL;

			} else {

				$retorno['erro'] = 1;
				$retorno['erro_msg'] = 'Erro ao concluir requisição!';
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