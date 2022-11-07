<?php

class cadastro_email extends controller {
	
	protected $_modulo_nome = "Cadastro de E-mails";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(70);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$cadastro_email = new model_cadastro_email();		
		$dados['grupos'] = $cadastro_email->lista_grupos();

		$grupo = $this->get('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}

		$dados['grupo_selecionado'] = $grupo;

		// intancia 
		$dados['lista'] = $cadastro_email->lista($grupo);
		
		$this->view('cadastro.email', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$cadastro_email = new model_cadastro_email();		
		$dados['grupos'] = $cadastro_email->lista_grupos();

		$grupo = $this->get('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}

		$dados['grupo_selecionado'] = $grupo;

		$this->view('cadastro.email.novo', $dados);
	}

	public function novo_grv(){
		
		$nome = $this->post('nome');
		$email = $this->post('email');
		$grupo = $this->post('grupo');

		$this->valida($nome);
		$this->valida($email);
		$this->valida($grupo);

		$valida = new model_valida();
		if(!$valida->email($email)){
			$this->msg('Email inválido!');
			$this->volta(1);
		}

		// intancia
		$cadastro = new model_cadastro_email();

		if(!$cadastro->confere($email, $grupo)){

			$this->msg('E-mail já cadastrado!');
			$this->volta(1);

		} else {

			$cadastro->adiciona(array(
				$nome,
				$email,
				$grupo
			));

			$this->irpara(DOMINIO.$this->_controller);
		}
	}
	
	public function apagar_varios(){
		
		$grupo = $this->get('grupo');

		$this->valida($grupo);

		// intancia
		$cadastro = new model_cadastro_email();

		foreach ($cadastro->lista($grupo) as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['id']){
				
				$cadastro->apagar($value['id']);
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}
	
	public function exportar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Exportar";
		
		$dados['mostrar_lista'] = false;


		$cadastro_email = new model_cadastro_email();		
		$dados['grupos'] = $cadastro_email->lista_grupos();

		$grupo = $this->post('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}
		$formato = $this->post('formato');

		$dados['grupo_selecionado'] = $grupo;
		$dados['formato'] = $formato;

		if($formato AND $grupo){

			$dados['mostrar_lista'] = true;

			if($formato == 1){
				$separador = ';';
			} else {
				$separador = ',';
			}

			$lista_exportada = '';

			foreach ($cadastro_email->lista($grupo) as $key => $value) {		 
				$lista_exportada .= $value['email'].$separador;
			}

			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.email.exportar', $dados);
	}


	public function grupos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$cadastro_email = new model_cadastro_email();

		$dados['grupos'] = $cadastro_email->lista_grupos();

		$this->view('cadastro.email.grupos', $dados);
	}

	public function grupos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('cadastro.email.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo');
		$descricao = "RECEBA TODAS NOSSAS OFERTAS EXCLUSIVAS POR E-MAIL";

		$this->valida($titulo);

		// Instancia
		$cadastro_email = new model_cadastro_email();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('cadastro_email_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,
			'descricao'=>$descricao
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "cadastro_email";
		$titulo_pagina = "Cadastro E-mail - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$cadastro_email = new model_cadastro_email();

		$codigo = $this->get('codigo');

		$dados['data'] = $cadastro_email->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();

		$this->view('cadastro.email.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$descricao = $this->post_htm('descricao');
		$botao = $this->post('botao');
		
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
		$db->alterar("cadastro_email_grupos", array(
			'titulo'=>$titulo,
			'descricao'=>$descricao,
			'botao_codigo'=>$botao,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");


		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pagina = "Cadastro E-mail - $titulo";
		$tipo = "cadastro_email";
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

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_apagar(){

		// Instancia
		$cadastro_email = new model_cadastro_email();

		foreach ($cadastro_email->lista_grupos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == $value['codigo']){

				$db = new mysql();
				$db->apagar('cadastro_email_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('cadastro_email', " grupo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('cadastro_email_ordem', " grupo='".$value['codigo']."' ");

				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}



}