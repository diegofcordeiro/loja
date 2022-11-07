<?php

class audios extends controller {
	
	protected $_modulo_nome = "Galeria de Áudios";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(142);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$audios = new model_audios();		
		$dados['lista_categorias'] = $audios->lista_categorias();

		$categoria = $this->get('categoria');
		if(!$categoria){
			if(isset($dados['lista_categorias'][0]['codigo'])){
				$categoria = $dados['lista_categorias'][0]['codigo'];
			} else {
				$categoria = 0;
			}
		}

		$dados['categoria_selecionada'] = $categoria;
		
		$dados['lista'] = $audios->lista($categoria);
		
		$this->view('audios', $dados);
	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$audios = new model_audios();		
		$dados['lista_categorias'] = $audios->lista_categorias();
		
		$categoria = $this->get('categoria');
		if(!$categoria){
			if(isset($dados['lista_categorias'][0]['codigo'])){
				$categoria = $dados['lista_categorias'][0]['codigo'];
			} else {
				$categoria = 0;
			}
		}
		$dados['categoria_selecionada'] = $categoria;
		
		$this->view('audios.novo', $dados);
	}

	public function novo_grv(){
		
		$categoria = $this->post('categoria');
		$titulo = $this->post('titulo');
		$tempo = $this->post('tempo');
		$status = $this->post('status');
		$previa = $this->post_htm('previa');
		
		$this->valida($titulo);
		$this->valida($categoria);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("audios", array(
			"codigo"=>$codigo,
			"categoria"=>$categoria,
			"titulo"=>$titulo,
			"previa"=>$previa,
			"tempo"=>$tempo,
			"status"=>$status
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
		$exec = $db->Executar("SELECT * FROM audios where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$audios = new model_audios();		
		$dados['lista_categorias'] = $audios->lista_categorias();

		$this->view('audios.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$tempo = $this->post('tempo');
		$status = $this->post('status');
		$categoria = $this->post('categoria');
		$previa = $this->post_htm('previa');
		
		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("audios", array(
			"titulo"=>$titulo,
			"categoria"=>$categoria,
			"previa"=>$previa,
			"tempo"=>$tempo,
			"status"=>$status
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM audios ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == $data->codigo){

				$categoria = $data->categoria;
				
				$conexao = new mysql();
				$conexao->apagar("audios", " codigo='$data->codigo' ");
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial/categoria/'.$categoria);
		
	}

	public function categorias(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";
		
		$audios = new model_audios();
		$dados['lista'] = $audios->lista_categorias(); 

		$this->view('audios.categorias', $dados);
	}

	public function nova_categoria(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova categoria";

		$audios = new model_audios();
		$dados['grupos'] = $audios->lista_grupos();

		$this->view('audios.categorias.nova', $dados);
	}

	public function nova_categoria_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');		
		
		$this->valida($grupo);
		$this->valida($titulo);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("audios_categorias", array(
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
		$exec = $db->executar("SELECT * FROM audios_categorias WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/categorias');
		}
		
		$audios = new model_audios();
		$dados['grupos'] = $audios->lista_grupos();
		
		$this->view('audios.categorias.alterar', $dados);
	}
	
	public function alterar_categoria_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($grupo);

		$db = new mysql();
		$db->alterar("audios_categorias", array(
			"titulo"=>"$titulo",
			"grupo"=>"$grupo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}

	public function apagar_categorias(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM audios_categorias ");
		while($data = $exec->fetch_object()){			
			if($this->post('apagar_'.$data->id) == 1){			 
				
				$conexao = new mysql();
				$conexao->apagar("audios_categorias", " id='$data->id' ");
				
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
		$audios = new model_audios();
		
		$dados['grupos'] = $audios->lista_grupos();
		
		$this->view('audios.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('audios.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$audios = new model_audios();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('audios_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,			 
			'itens_por_linha'=>'1'
		));
		
		// layout

		$titulo = strip_tags($titulo);
		
		$layout = new model_layout();
		$tipo = "audios";
		$titulo_pagina = "Áudios - $titulo";
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
		$audios = new model_audios();
		$dados['data'] = $audios->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('audios.grupos.alterar', $dados);
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
		$db->alterar("audios_grupos", array(
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
		$titulo_pgaina = "Áudios - $titulo";
		$tipo = "audios";
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
		$audios = new model_audios();

		foreach ($audios->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('audios_grupos', " codigo='".$value['codigo']."' ");

				
				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function arquivo(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		
		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/audios/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				$db = new mysql();
				$db->alterar('audios', array(
					'arquivo'=>$nome_arquivo
				), " codigo='$codigo' " );
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/arquivo');
				
			} else {
				
				$this->msg('Erro ao gravar arquivo!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/arquivo");
				
			}

		}
		
	}
	
	public function apagar_arquivo(){


		$codigo = $this->get('codigo');
		
		if($codigo){

			$model_audios = new model_audios();
			$data = $model_audios->carrega($codigo);

			if($data->arquivo){
				unlink('../arquivos/audios/'.$data->arquivo);
			}

			$db = new mysql();
			$db->alterar('audios', array(
				'arquivo'=>''
			), " codigo='$codigo' " );

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/arquivo');
	}

	public function imagem(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia]
		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_audios/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					//redimenciona					
					$arquivo->jpg($diretorio.$nome_arquivo, 2500 , 2500, $diretorio.$nome_arquivo);
					
				}
				
				$db = new mysql();
				$db->alterar('audios', array(
					'imagem'=>$nome_arquivo
				), " codigo='$codigo' " );
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
				
			}

		}
		
	}
	
	public function apagar_imagem(){
		
		// Instancia
		$audios = new model_audios();
		
		$codigo = $this->get('codigo');
		
		if($codigo){
			
			$data = $audios->carrega($codigo);
			
			if($data->imagem){
				unlink('../arquivos/img_audios/'.$data->imagem);
			}
			
			$db = new mysql();
			$db->alterar('audios', array(
				'imagem'=>''
			), " codigo='$codigo' " );

		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}
	
//termina classe
}