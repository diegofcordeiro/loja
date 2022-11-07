<?php

class videos extends controller {
	
	protected $_modulo_nome = "Galeria de Vídeos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(119);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$videos = new model_videos();		
		$dados['lista_categorias'] = $videos->lista_categorias();

		$categoria = $this->get('categoria');
		if(!$categoria){
			if(isset($dados['lista_categorias'][0]['codigo'])){
				$categoria = $dados['lista_categorias'][0]['codigo'];
			} else {
				$categoria = 0;
			}
		}

		$dados['categoria_selecionada'] = $categoria;
		
		$dados['lista'] = $videos->lista($categoria);
		
		$this->view('videos', $dados);
	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$videos = new model_videos();		
		$dados['lista_categorias'] = $videos->lista_categorias();
		
		$categoria = $this->get('categoria');
		if(!$categoria){
			if(isset($dados['lista_categorias'][0]['codigo'])){
				$categoria = $dados['lista_categorias'][0]['codigo'];
			} else {
				$categoria = 0;
			}
		}
		$dados['categoria_selecionada'] = $categoria;
		
		$this->view('videos.novo', $dados);
	}

	public function novo_grv(){
		
		$categoria = $this->post('categoria');
		$titulo = $this->post('titulo');
		$previa = $this->post_htm('previa');
		$conteudo = $this->post_htm('conteudo');
		
		$this->valida($titulo);
		$this->valida($categoria);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("videos", array(
			"codigo"=>"$codigo",
			"categoria"=>"$categoria",
			"titulo"=>"$titulo",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		$this->valida($codigo);

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM videos where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$videos = new model_videos();		
		$dados['lista_categorias'] = $videos->lista_categorias();

		$this->view('videos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$categoria = $this->post('categoria');
		$previa = $this->post_htm('previa'); 
		$conteudo = $this->post_htm('conteudo'); 
		
		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("videos", array(
			"titulo"=>"$titulo",
			"categoria"=>"$categoria",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM videos ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == $data->codigo){

				$categoria = $data->categoria;
				
				$conexao = new mysql();
				$conexao->apagar("videos", " codigo='$data->codigo' ");
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial/categoria/'.$categoria);
		
	}

	public function categorias(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";
		
		$videos = new model_videos();
		$dados['lista'] = $videos->lista_categorias(); 

		$this->view('videos.categorias', $dados);
	}

	public function nova_categoria(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova categoria";

		$videos = new model_videos();
		$dados['grupos'] = $videos->lista_grupos();

		$this->view('videos.categorias.nova', $dados);
	}

	public function nova_categoria_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');		
		
		$this->valida($grupo);
		$this->valida($titulo);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("videos_categorias", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"grupo"=>"$grupo"
		));
		
		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}

	public function alterar_categoria(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar categoria";

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$codigo = $this->get('codigo');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM videos_categorias WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/categorias');
		}
		
		$videos = new model_videos();
		$dados['grupos'] = $videos->lista_grupos();
		
		$this->view('videos.categorias.alterar', $dados);
	}
	
	public function alterar_categoria_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($grupo);

		$db = new mysql();
		$db->alterar("videos_categorias", array(
			"titulo"=>"$titulo",
			"grupo"=>"$grupo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}

	public function apagar_categorias(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM videos_categorias ");
		while($data = $exec->fetch_object()){			
			if($this->post('apagar_'.$data->id) == 1){			 
				
				$conexao = new mysql();
				$conexao->apagar("videos_categorias", " id='$data->id' ");
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/categorias');
	}


	// grupos 


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$videos = new model_videos();
		
		$dados['grupos'] = $videos->lista_grupos();
		
		$this->view('videos.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('videos.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$videos = new model_videos();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('videos_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,			 
			'itens_por_linha'=>'1'
		));
		
		// layout

		$titulo = strip_tags($titulo);
		
		$layout = new model_layout();
		$tipo = "videos";
		$titulo_pagina = "Vídeos - $titulo";
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

		// Instancia
		$videos = new model_videos();
		$dados['data'] = $videos->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('videos.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$itens_por_linha = $this->post('itens_por_linha');
		$mostrar_categorias = $this->post('mostrar_categorias'); 
		$mostrar_titulo_video = $this->post('mostrar_titulo_video'); 
		$tipo_menu = $this->post('tipo_menu');

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
		$db->alterar("videos_grupos", array(
			'titulo'=>$titulo,
			'mostrar_titulo'=>$mostrar_titulo,
			'itens_por_linha'=>$itens_por_linha,
			'mostrar_categorias'=>$mostrar_categorias,
			'mostrar_titulo_video'=>$mostrar_titulo_video,
			'tipo_menu'=>$tipo_menu,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		

		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pgaina = "Vídeos - $titulo";
		$tipo = "videos";
		$layout->altera_paginas($codigo, $titulo_pgaina);
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
		$videos = new model_videos();

		foreach ($videos->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('videos_grupos', " codigo='".$value['codigo']."' ");

				
				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}
	
//termina classe
}