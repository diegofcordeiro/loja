<?php

class formas_pagamento extends controller {
	
	protected $_modulo_nome = "Formas de Pagamento";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(75);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		// instancia
		$pagamento = new model_formas_pagamento();
		
		$dados['lista'] = $pagamento->lista();
		
		$this->view('formas_pagamento', $dados);
	}
	
	public function novo(){

		$dados['_base'] = $this->base();

		$estados_cidades = new model_estados_cidades();
		$dados['estados'] = $estados_cidades->lista_estados();

		$this->view('formas_pagamento.novo', $dados);
	}
	
	public function novo_grv(){

		$dados['_base'] = $this->base();

		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		if($estado AND $cidade){

			$db = new mysql();
			$db->inserir('pagamento', array(
				'titulo'=>'Condicional',
				'desconto_fixo'=>0,
				'desconto_porc'=>0,
				'cidade'=>$cidade,
				'estado'=>$estado
			));

		} else {
			$this->msg('Selecione o estado e cidade!');
			$this->volta(1);
		}

		$this->irpara(DOMINIO.$this->_controller);
	}

	public function apagar(){

		$dados['_base'] = $this->base();

		$id = $this->get('id');
		if($id){
			$db = new mysql();
			$db->apagar('pagamento', " id='$id' AND id>'10' ");
		}
		
		$this->irpara(DOMINIO.$this->_controller);
	}

	public function alterar(){
		
		$dados['_base'] = $this->base();

		$id = $this->get('id');

 		// instancia
		$pagamento = new model_formas_pagamento();
		$valores = new model_valores();

		$dados['data'] = $pagamento->carrega($id);
		$dados['id'] = $id;
		$data = $dados['data'];
		
		if($id == 1){
			$dados['endereco_retorno'] = DOMINIO.'retorno/pagseguro/';
			$dados['endereco_finalizacao'] = str_replace("sistema/", "", DOMINIO).'pedido_concluido/pagseguro/';
		}
		if($id == 4){
			$dados['endereco_retorno_paypal'] = DOMINIO.'retorno/paypal/'; 
		}

		$dados['desconto_porc'] = $data->desconto_porc;
		$dados['desconto_fixo'] = $valores->trata_valor($data->desconto_fixo);	
		
		$estados_cidades = new model_estados_cidades();
		$dados['estados'] = $estados_cidades->lista_estados();

		$this->view('formas_pagamento.detalhes', $dados);
	}

	public function alterar_grv(){
		
		$valores = new model_valores();

		$id = $this->post('id'); 
		$this->valida($id);

		$ativo = $this->post('ativo');
		$email_pagseguro = $this->post('email_pagseguro');
		$token_retorno_pagseguro = $this->post('token_retorno_pagseguro');

		$desconto_fixo = $this->post('desconto_fixo');
		$desconto_fixo = $valores->trata_valor_banco($desconto_fixo);		
		$desconto_porc = $this->post('desconto_porc');

		$deposito_dados = $this->post('deposito_dados');

		$mercadopago_client_id = $this->post('mercadopago_client_id');
		$mercadopago_client_secret = $this->post('mercadopago_client_secret');

		$mercadopago_public_key = $this->post('mercadopago_public_key');
		$mercadopago_access_token = $this->post('mercadopago_access_token');
		
		$vindi_key = $this->post('vindi_key');
		$vindi_url = $_POST['vindi_url'];


		$paypal_conta = $this->post_htm('paypal_conta');
		$paypal_clienteid = $this->post_htm('paypal_clienteid');
		$paypal_clientesecret = $this->post_htm('paypal_clientesecret');

		$cielo_clientId = $this->post_htm('cielo_clientId');
		$cielo_clientSecret = $this->post_htm('cielo_clientSecret');

		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		


		if($id == 1){

			$db = new mysql();
			if($ativo == 0){
				$db->alterar("pagamento", array(
					"ativo"=>1
				), " id in(2,3,4,5,6,8)");
			}
			$db->alterar("pagamento", array( 
				"ativo"=>$ativo,
				"email_pagseguro"=>$email_pagseguro,
				"token_retorno_pagseguro"=>$token_retorno_pagseguro
			), " id='$id' ");

		}

		if($id == 2){

			$db = new mysql();
			if($ativo == 0){
				$db->alterar("pagamento", array(
					"ativo"=>1
				), " id in(1,3,4,5,6,8)");
			}
			$db->alterar("pagamento", array(
				"desconto_fixo"=>$desconto_fixo,
				"desconto_porc"=>$desconto_porc,
				"ativo"=>$ativo,
				"deposito_dados"=>$deposito_dados
			), " id='$id' ");

		}
		
		if( ($id == 3) OR ($id == 8) ){
			
			$db = new mysql();
			if($ativo == 0){
				$db->alterar("pagamento", array(
					"ativo"=>1
				), " id in(1,2,4,5,8)");
			}
			$db->alterar("pagamento", array(				 
				"ativo"=>$ativo,
				"mercadopago_client_id"=>$mercadopago_client_id,
				"mercadopago_client_secret"=>$mercadopago_client_secret,
				"mercadopago_public_key"=>$mercadopago_public_key,
				"mercadopago_access_token"=>$mercadopago_access_token
			), " id='$id' ");

		}

		if($id == 4){

			$db = new mysql();
			if($ativo == 0){
				$db->alterar("pagamento", array(
					"ativo"=>1
				), " id in(1,2,3,5,6,8)");
			}
			$db->alterar("pagamento", array(
				"desconto_fixo"=>$desconto_fixo,
				"desconto_porc"=>$desconto_porc,
				"ativo"=>$ativo,
				"paypal_conta"=>$paypal_conta,
				"paypal_clienteid"=>$paypal_clienteid,
				"paypal_clientesecret"=>$paypal_clientesecret
			), " id='$id' ");

		}

		if($id == 5){
			// print_r($ativo);exit;
			$db = new mysql();
			if($ativo == 0){
				$db->alterar("pagamento", array(
					"ativo"=>1
				), " id in(1,2,3,4,6,8)");
			}
			$db->alterar("pagamento", array(
				"ativo"=>$ativo,
				"vindi_url"=>$vindi_url,
				"vindi_key"=>$vindi_key
			), " id='$id' ");

		}

		if($id == 6){

			$db = new mysql();
			if($ativo == 0){
				$db->alterar("pagamento", array(
					"ativo"=>1
				), " id in(1,2,3,4,5,8)");
			}
			$db->alterar("pagamento", array(
				"ativo"=>$ativo,
				"cielo_clientId"=>$cielo_clientId,
				"cielo_clientSecret"=>$cielo_clientSecret
			), " id='$id' ");

		}
		
		if($id > 6){

			$db = new mysql();
			$db->alterar("pagamento", array(
				"ativo"=>$ativo,
				"estado"=>$estado,
				"cidade"=>$cidade
			), " id='$id' ");

		}
		
		$this->irpara(DOMINIO.$this->_controller);		
	}


	public function cidades(){

		$dados['_base'] = $this->base();

		$estados_cidades = new model_estados_cidades();

		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		$dados['cidades'] = $estados_cidades->lista_cidades($estado, $cidade);

		//carrega view e envia dados para a tela
		$this->view('cidades', $dados);
	}


}