<?php

Class model_mercadopago extends model{
	

	////////////////////////////////////////////////////////////////////////////////////
	// nova api 
	public function pagamento($pedido, $cadastro, $descricao, $valor_total){

		$retorno = array();
		$retorno['erro'] = 2;
		$retorno['erro_msg'] = '';
		$retorno['code'] = '';
		
		$valores = new model_valores();
		
		// dados de configuração
		$conexao = new mysql();
		$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='3' ");
		$data_pagamento = $coisas_pagamento->fetch_object();
		
		// dados do cadastro
		$model_cadastro = new model_cadastro(); 
		if($data_dados = $model_cadastro->carrega($cadastro)){

			// converte valores
			$valor_tratado = str_replace(".", "", $valores->trata_valor($valor_total));
			$valor_tratado = str_replace(",", ".", $valor_tratado);
			
			// api mercado pago
			require_once("_api/mercadopago/mercadopago.php");

			$mp = new MP($data_pagamento->mercadopago_client_id, $data_pagamento->mercadopago_client_secret);
			
			$enderecopedido = DOMINIO."index/pedidos_detalhes/codigo/".$pedido;

			$preference_data = array(				 
				"external_reference"=>$pedido,
				"items" => array(
					array(
						"title" =>$descricao,
						"quantity"=>(int)'1',
						"currency_id"=>"BRL", // Available currencies at: https://api.mercadopago.com/currencies
						"unit_price"=>(double)$valor_tratado
					)
				),
				"back_urls"  => array(
					"success" => "$enderecopedido",
					"failure" => "$enderecopedido",
					"pending" => "$enderecopedido"
				)
			);
			
			$preference = $mp->create_preference($preference_data);

			if( ($preference['status'] == '201') OR ($preference['status'] == '200') ){
				$retorno['erro'] = 0;
				$retorno['erro_msg'] = '';
				$retorno['code'] = $preference['response']['id'];
				$retorno['endereco'] = $preference['response']['init_point'];
			} else {
				$retorno['erro'] = 1;
				$retorno['code'] = '';
				$retorno['erro_msg'] = print_r($preference['response']);
			}
			
		} else {
			$retorno['erro'] = 1;
			$retorno['erro_msg'] = 'Faça o login e tente novamente!';
			$retorno['code'] = '';
		}
		
		return $retorno;
	}
	

}