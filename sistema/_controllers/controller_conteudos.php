<?php

class conteudos extends controller {
	
	protected $_modulo_nome = "Conteúdos";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(29);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$conteudos = new model_conteudos();		 
		$dados['lista'] = $conteudos->lista();
		
		$this->view('conteudos', $dados);
	}
	
	public function novo(){ 
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('conteudos.novo', $dados);
	}

	public function novo_grv(){		 

		$titulo = $this->post('titulo');
		$conteudo = $this->post_htm('conteudo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("conteudos", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"conteudo"=>"$conteudo",
			"bloqueio"=>"0"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');
		
		$dados['aba_selecionada'] = "dados"; 		 

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM conteudos where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$this->view('conteudos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$conteudo = $this->post_htm('conteudo'); 

		$this->valida($codigo);
		$this->valida($titulo);
		
		$db = new mysql();
		$db->alterar("conteudos", array(
			"titulo"=>"$titulo",
			"conteudo"=>"$conteudo"
		), " codigo='$codigo' ");
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM conteudos WHERE bloqueio='0' ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == $data->codigo){				
				
				$conexao = new mysql();
				$conexao->apagar("conteudos", " id='$data->id' ");
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller);		
	}

}