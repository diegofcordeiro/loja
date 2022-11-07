<?php

class widgets extends controller {
	
	protected $_modulo_nome = "Widgets";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(118);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$widgets = new model_widgets();
		$dados['lista'] = $widgets->lista();	
		
		$this->view('widgets', $dados);
	}	

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$this->view('widgets.novo', $dados);
	}
	
	public function novo_grv(){
		
		$titulo = $this->post('titulo'); 
		
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("widgets", array(
			"codigo"=>$codigo,
			"titulo"=>$titulo,
			"mostrar_titulo"=>0
		));
		
		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$tipo = "widgets";
		$titulo_pagina = "Widgets - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

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
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM widgets WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('widgets.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$id = $this->post('id');
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo'); 
		$mostrar_titulo = $this->post('mostrar_titulo');
		$descricao = base64_encode(htmlspecialchars($_POST['descricao']));
		
		$enquadramento = $this->post('enquadramento');

		$this->valida($codigo);
		$this->valida($id);
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
		$db->alterar("widgets", array(
			"titulo"=>$titulo,
			"mostrar_titulo"=>$mostrar_titulo,
			"conteudo"=>$descricao,
			"enquadramento"=>$enquadramento,
			"classes"=>$lista_css_tratada,
			"classes_img"=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		// layout
		$titulo = strip_tags($titulo);
		
		$layout = new model_layout();
		$titulo_pagina = "Widgets - $titulo";
		$tipo = "widgets";
		$layout->altera_paginas($codigo, $titulo_pagina);
		$layout->adiciona_cores($tipo, $codigo);

		$cores = $layout->lista_cores($codigo);
		foreach ($cores as $key => $value) {
			$cor_nova = $this->post('cor_'.$value['id']);
			if($cor_nova){
				$db = new mysql();
				$db->alterar("layout_itens_cores_sel", array(
					'cor'=>$cor_nova
				), " id='".$value['id']."' ");
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){

		$widgets = new model_widgets();

		foreach ($widgets->lista() as $key => $value) {			 

			if($this->post('apagar_'.$value['id']) == $value['codigo']){

				$db = new mysql();
				$db->apagar("widgets", " id='".$value['id']."' ");

				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}

		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial');
	}
}