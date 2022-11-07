<?php

class cupom extends controller {
	
	protected $_modulo_nome = "Cupom de Desconto";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(77);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		// instancia
		$cupom = new model_cupom();
		
		$dados['lista'] = $cupom->lista();
		
		$this->view('cupom', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Novo";

 		$dados['aba_selecionada'] = "dados"; 

		$this->view('cupom.novo', $dados);
	}

	public function novo_grv(){

		// Instancia
		$cupom = new model_cupom();
		$valores = new model_valores();

		$titulo = $this->post('titulo');
		$tipo = $this->post('tipo');
		$desconto_fixo = $valores->trata_valor_banco($this->post('desconto_fixo'));
		$desconto_porc = $this->post('desconto_porc');
		$cadastro = $this->post('cadastro');
		$prefixo = $this->post('prefixo');
		$valor_minimo = $valores->trata_valor_banco($this->post('valor_minimo'));
		 	
		
		$this->valida($titulo);
 		
		$codigo = $this->gera_codigo();				 

		$cupom->adiciona(array(
			$codigo,
			$titulo,
			$tipo,
			$desconto_fixo,
			$desconto_porc,
			$cadastro,
			$prefixo,
			$valor_minimo
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Alterar";
 		
 		$codigo = $this->get('codigo');
 		
 		$aba = $this->get('aba');
 		if($aba){
 			$dados['aba_selecionada'] = $aba;
 		} else {
 			$dados['aba_selecionada'] = 'dados';
 		}

 		// instancia
		$cupom = new model_cupom();
		$valores = new model_valores();

 		$dados['data'] = $cupom->carrega($codigo); 		
 		$dados['desconto_fixo'] = $valores->trata_valor($dados['data']->desconto_fixo);
 		$dados['valor_minimo'] = $valores->trata_valor($dados['data']->valor_minimo);
 		
 		$dados['cupons'] = $cupom->cupons($codigo);

		$this->view('cupom.alterar', $dados);
	}

	public function alterar_grv(){		
		 
		// Instancia
		$cupom = new model_cupom();
		$valores = new model_valores();

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$tipo = $this->post('tipo');
		$desconto_fixo = $valores->trata_valor_banco($this->post('desconto_fixo'));
		$desconto_porc = $this->post('desconto_porc');
		$cadastro = $this->post('cadastro');
		$prefixo = $this->post('prefixo');
		$valor_minimo = $valores->trata_valor_banco($this->post('valor_minimo'));

		$this->valida($titulo); 		 
 		
		$cupom->alterar(array(
			$titulo,
			$tipo,
			$desconto_fixo,
			$desconto_porc,
			$cadastro,
			$prefixo,
			$valor_minimo
		), $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){

		// instancia
		$cupom = new model_cupom();

		foreach ($cupom->lista() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == 1){				
				$cupom->apagar($value['codigo']);
			}

		}

		$this->irpara(DOMINIO.$this->_controller);		
	}

	public function novo_cupom(){

		$cupom = new model_cupom();

		$codigo = $this->get('codigo');				

		if($codigo){

			$cupom_codigo = $cupom->gera_cupom_semrepetir();
 			
 			// adiciona prefixo se tiver
 			$data = $cupom->carrega($codigo);			
			if($data->prefixo){
				$cupom_codigo = $data->prefixo.$cupom_codigo;
			}

			$cupom->adiciona_cupom(array(
				$codigo,
				$cupom_codigo,
				'0'
			));

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/cupons');	
	}

	public function apagar_cupom(){
		
		$codigo = $this->get('codigo');

		// instancia
		$cupom = new model_cupom();
		
		foreach ($cupom->cupons($codigo) as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == 1){				
				$cupom->apagar_cupom($value['id']);
			}

		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/cupons');		
	}

}