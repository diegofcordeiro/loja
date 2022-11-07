<?php

class cadastro_fone extends controller {
	
	protected $_modulo_nome = "Cadastro de Telefones";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(91);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$cadastro_fone = new model_cadastro_fone();		
		$dados['grupos'] = $cadastro_fone->lista_grupos();

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
		$dados['lista'] = $cadastro_fone->lista($grupo);
		
		$this->view('cadastro.fone', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$cadastro_fone = new model_cadastro_fone();		
		$dados['grupos'] = $cadastro_fone->lista_grupos();

		$grupo = $this->get('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}
		
		$dados['grupo_selecionado'] = $grupo;

		$this->view('cadastro.fone.novo', $dados);
	}

	public function novo_grv(){
		
		$nome = $this->post('nome');
		$fone = $this->post('fone');
		$grupo = $this->post('grupo');

		$this->valida($nome);
		$this->valida($fone);
		$this->valida($grupo);
		
		// intancia
		$cadastro = new model_cadastro_fone();

		if(!$cadastro->confere($fone, $grupo)){

			$this->msg('Telefone já cadastrado!');
			$this->volta(1);

		} else {

			$cadastro->adiciona(array(
				$nome,
				$fone,
				$grupo
			));

			$this->irpara(DOMINIO.$this->_controller);
		}
	}
	
	public function apagar_varios(){
		
		$grupo = $this->get('grupo');

		$this->valida($grupo);

		// intancia
		$cadastro = new model_cadastro_fone();

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


		$cadastro_fone = new model_cadastro_fone();		
		$dados['grupos'] = $cadastro_fone->lista_grupos();

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

			foreach ($cadastro_fone->lista($grupo) as $key => $value) {		 
				$lista_exportada .= $value['fone'].$separador;
			}

			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.fone.exportar', $dados);
	}


	public function grupos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$cadastro_fone = new model_cadastro_fone();

		$dados['grupos'] = $cadastro_fone->lista_grupos();

		$this->view('cadastro.fone.grupos', $dados);
	}

	public function grupos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('cadastro.fone.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo');
		$descricao = "RECEBA TODAS NOSSAS OFERTAS EXCLUSIVAS"; 

		$this->valida($titulo);

		// Instancia
		$cadastro_fone = new model_cadastro_fone();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('cadastro_fone_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,
			'descricao'=>$descricao
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "cadastro_fone";
		$titulo_pagina = "Cadastro Telefone - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

		$codigo = $this->get('codigo');

		if(!$codigo){
			echo "Item inválido!";
			exit;
		}

		$cadastro_fone = new model_cadastro_fone();
		$dados['data'] = $cadastro_fone->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('cadastro.fone.grupos.alterar', $dados);
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
		$db->alterar("cadastro_fone_grupos", array(
			'titulo'=>$titulo,
			'descricao'=>$descricao,
			'botao_codigo'=>$botao,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
				
		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$tipo = "cadastro_fone";
		$titulo_pagina = "Cadastro Telefone - $titulo";
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
		$cadastro_fone = new model_cadastro_fone();

		foreach ($cadastro_fone->lista_grupos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == $value['codigo']){

				$db = new mysql();
				$db->apagar('cadastro_fone_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('cadastro_fone', " grupo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('cadastro_fone_ordem', " grupo='".$value['codigo']."' ");
				
				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

}