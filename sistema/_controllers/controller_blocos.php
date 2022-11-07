<?php

class blocos extends controller {
	
	protected $_modulo_nome = "Blocos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(139);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$blocos = new model_blocos();
		$dados['lista'] = $blocos->lista();	
		
		$this->view('blocos', $dados);
	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";
		
		$dados['aba_selecionada'] = "dados";
		
		$this->view('blocos.novo', $dados);
	}
	
	public function novo_grv(){
		
		$titulo = $this->post_htm('titulo');
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("blocos", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "blocos";
		$titulo_pagina = "Blocos de Conteudos - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/dados/codigo/'.$codigo);
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

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM blocos WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$layout = new model_layout();
		$dados['lista_css'] = $layout->lista_css();
		$itens = $layout->lista_itens(1);

		
		$modulositens = array();
		$n = 0;
		foreach ($itens as $key => $value) {
			if($value['tipo'] != 'bloco'){
				$modulositens[$n]['codigo'] = $value['codigo'];
				$modulositens[$n]['titulo'] = $value['titulo'];

				$n++;
			}
		}
		$dados['modulos_itens'] = $modulositens;


		$this->view('blocos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$id = $this->post('id');
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo'); 
		$full = $this->post('full');
		$colunas = $this->post('colunas');

		$this->valida($codigo);
		$this->valida($titulo);

		if(isset($_POST['lista_css'])){
			$lista_css = $_POST['lista_css'];
			$lista_css_tratada = implode(' ', $lista_css);
		} else {
			$lista_css_tratada = "";
		}

		if(isset($_POST['lista_css_img'])){
			$lista_css_img = $_POST['lista_css_img'];
			$lista_css_img_tratada = implode(' ', $lista_css_img);
		} else {
			$lista_css_img_tratada = "";
		}

		$db = new mysql();
		$db->alterar("blocos", array(
			"titulo"=>$titulo,
			"full"=>$full,
			"colunas"=>$colunas,
			"classes"=>$lista_css_tratada,
			"classes_img"=>$lista_css_img_tratada
		), " codigo='".$codigo."' ");
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$titulo_pagina = "Blocos de Conteudos - $titulo";
		$tipo = "blocos";
		$layout->altera_paginas($codigo, $titulo_pagina);
		$layout->adiciona_cores($tipo, $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function modulos_grv(){

		$codigo = $this->post('codigo');

		$coluna1 = $this->post('coluna1');
		$coluna2 = $this->post('coluna2');
		$coluna3 = $this->post('coluna3');
		$coluna4 = $this->post('coluna4');
		$coluna5 = $this->post('coluna5');
		$coluna6 = $this->post('coluna6');
		$coluna7 = $this->post('coluna7');
		$coluna8 = $this->post('coluna8');
		$coluna9 = $this->post('coluna9');
		$coluna10 = $this->post('coluna10');
		$coluna11 = $this->post('coluna11');
		$coluna12 = $this->post('coluna12');

		$this->valida($codigo);
		
		$db = new mysql();
		$db->alterar("blocos", array(
			"coluna1"=>$coluna1,
			"coluna2"=>$coluna2,
			"coluna3"=>$coluna3,
			"coluna4"=>$coluna4,
			"coluna5"=>$coluna5,
			"coluna6"=>$coluna6,
			"coluna7"=>$coluna7,
			"coluna8"=>$coluna8,
			"coluna9"=>$coluna9,
			"coluna10"=>$coluna10,
			"coluna11"=>$coluna11,
			"coluna12"=>$coluna12
		), " codigo='".$codigo."' ");
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/modulos');		
	}

	public function apagar_varios(){

		$layout = new model_layout(); 

		$blocos = new model_blocos();

		foreach ($blocos->lista() as $key => $value) {			 

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("blocos", " id='".$value['id']."' ");

				// layout				 
				$layout->apagar_pagina($value['codigo']);
			}

		}	

		$this->irpara(DOMINIO.$this->_controller.'/inicial');
	}

}