<?php

class textos extends controller {
	
	protected $_modulo_nome = "Textos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(88);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$textos = new model_textos();
		$dados['lista'] = $textos->lista();
		
		$this->view('textos', $dados);
	}
	
	public function novo(){ 
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('textos.novo', $dados);
	}

	public function novo_grv(){		 

		$titulo = $this->post('titulo');
		$conteudo = $this->post_htm('conteudo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("textos", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"conteudo"=>"$conteudo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		$dados['aba_selecionada'] = "dados";
		
		$dados['acesso_alterar_titulo'] = true;

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM textos where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('textos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$conteudo = $this->post_htm('conteudo');

		$this->valida($codigo);
		
		$db = new mysql();
		$db->alterar("textos", array(
			"conteudo"=>"$conteudo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

}