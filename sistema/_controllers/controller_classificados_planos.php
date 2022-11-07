<?php

class classificados_planos extends controller {
	
	protected $_modulo_nome = "Planos de Divulgação";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(136);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
			
		$planos = new model_classificados_planos(); 
		$dados['lista'] = $planos->lista();

		$this->view('classificados_planos', $dados);
	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";
		
		$dados['aba_selecionada'] = "dados";
		
		$this->view('classificados_planos.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("classificados_planos", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/dados/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";
		
		$codigo = $this->get('codigo');
		if(!$codigo){
			$this->msg('Item invalido');
			$this->volta(1);
			exit;
		}
		
		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM classificados_planos where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);

		$this->view('classificados_planos.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$valor = $this->post('valor');
		$meses = $this->post('meses');
		$dias = $this->post('dias');
		$limite = $this->post('limite');
		
		$this->valida($codigo);
		$this->valida($valor);
		$this->valida($titulo); 
		$this->valida($limite);

		$valores = new model_valores();
		$valor_tratado = $valores->trata_valor_banco($valor);

		$db = new mysql();
		$db->alterar("classificados_planos", array(
			"titulo"=>$titulo,
			"valor"=>$valor_tratado,
			"meses"=>$meses,
			"dias"=>$dias,
			"limite"=>$limite
		), " codigo='$codigo' AND id!=1 ");
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}
	
	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM classificados_planos ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == $data->codigo){ 			 
				
				$conexao = new mysql();
				$conexao->apagar("classificados_planos", " codigo='$data->codigo' AND id!=1 ");
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial');		
	}

	public function gratis(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM classificados_planos where id='1' ");
		$dados['data'] = $exec->fetch_object();
		
		$this->view('classificados_planos.gratis', $dados);
	}
	
	public function gratis_grv(){
		
		$meses = $this->post('meses');
		$dias = $this->post('dias');
		$limite = $this->post('limite');

		$db = new mysql();
		$db->alterar("classificados_planos", array(
			"meses"=>$meses,
			"dias"=>$dias,
			"limite"=>$limite
		), " id='1' ");
		
		$this->irpara(DOMINIO.$this->_controller);		
	}
	
//termina classe
}