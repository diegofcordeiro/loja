<?php

class revistas extends controller {
	
	protected $_modulo_nome = "Revistas/Jornais";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(105);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$edicoes = new model_revistajornal();
		$dados['lista'] = $edicoes->lista();

		$this->view('revistajornal', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();

		$edicoes = new model_revistajornal();
		$dados['formatos'] = $edicoes->formatos();

		$this->view('revistajornal.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$edicao = $this->post('edicao');
		$previa = $this->post('previa');
		$formato = $this->post('formato');
		$paginas = $this->post('paginas');

		$this->valida($titulo);
		$this->valida($edicao); 
		$this->valida($formato);
		$this->valida($paginas);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("revistajornal", array(
			"codigo"=>"$codigo",
			"formato"=>"$formato",
			"paginas"=>"$paginas",
			"titulo"=>"$titulo",
			"previa"=>"$previa",
			"edicao"=>"$edicao"
		));
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/imagem/codigo/'.$codigo);
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
		$exec = $db->Executar("SELECT * FROM revistajornal where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$revistajornal = new model_revistajornal();
		$dados['formatos'] = $revistajornal->formatos();
		$dados['imagens'] = $revistajornal->imagens($codigo);
		$grupos = $revistajornal->lista_grupos();

		$grupos_marcados = array();
		$n = 0;
		foreach ($grupos as $key => $value) {
			
			$grupos_marcados[$n]['id'] = $value['id'];
			$grupos_marcados[$n]['codigo'] = $value['codigo'];
			$grupos_marcados[$n]['titulo'] = $value['titulo'];

			$db = new mysql();
			$coisas = $db->executar("SELECT * FROM revistajornal_grupos_sel WHERE codigo='$codigo' AND grupo='".$value['codigo']."' ");
			if($coisas->num_rows != 0){
				$grupos_marcados[$n]['checked'] = true;
			} else {
				$grupos_marcados[$n]['checked'] = false;
			}

			$n++;
		}
		$dados['grupos_marcados'] = $grupos_marcados;


		$this->view('revistajornal.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$edicao = $this->post('edicao');
		$previa = $this->post('previa');
		$formato = $this->post('formato');
		$paginas = $this->post('paginas');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($formato);
		$this->valida($paginas);

		$db = new mysql();
		$db->alterar("revistajornal", array(
			"formato"=>"$formato",
			"paginas"=>"$paginas",
			"titulo"=>"$titulo",
			"edicao"=>"$edicao",
			"previa"=>"$previa"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function alterar_destaques(){

		$codigo = $this->post('codigo');

		if($codigo){

			function marcado_desmarcado($grupo, $item){
				$db = new mysql();
				$coisas = $db->executar("SELECT * FROM revistajornal_grupos_sel WHERE codigo='$item' AND grupo='$grupo' ");
				if($coisas->num_rows != 0){
					return true;
				} else {
					return false;
				}
			}
			
			$revistajornal = new model_revistajornal();
			$grupos = $revistajornal->lista_grupos();
			
			foreach ($grupos as $key => $value) {
				
				if($this->post('grupo_'.$value['id']) == '1'){
					if(!marcado_desmarcado($value['codigo'], $codigo)){
						// adiciona
						$db = new mysql();
						$db->inserir("revistajornal_grupos_sel", array(
							"codigo"=>$codigo,
							"grupo"=>$value['codigo']
						));
					}
				} else {
					if(marcado_desmarcado($value['codigo'], $codigo)){
						//remove
						$db = new mysql();
						$db->apagar("revistajornal_grupos_sel", " codigo='$codigo' AND grupo='".$value['codigo']."' ");
					}
				}

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/destaques');
	}

	public function imagem(){

		$codigo = $this->get('codigo');
		$pagina = $this->get('pagina');

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$this->valida($codigo);
		$this->valida($pagina);
		$this->valida($tmp_name);

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$revistajornal = new model_revistajornal();		

		$codigo = $this->get('codigo');

		$diretorio_g = "../arquivos/img_revistajornal_g/";
		$diretorio_p = "../arquivos/img_revistajornal_p/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio_g.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					$data = $revistajornal->carrega($codigo);
					$data_formato = $revistajornal->carrega_formato($data->formato);

					//calcula a altura
					$largura_g = $data_formato->grande_largura;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio_g.$nome_arquivo, $largura_g);

					//redimenciona
					$arquivo->jpg($diretorio_g.$nome_arquivo, $largura_g , $altura_g , $diretorio_g.$nome_arquivo);

					//calcula a altura
					$largura_p = $data_formato->pequena_largura;
					$altura_p =  $data_formato->pequena_altura;

					//redimenciona
					$arquivo->jpg($diretorio_g.$nome_arquivo, $largura_p , $altura_p , $diretorio_p.$nome_arquivo);

				} else {
					copy($diretorio_g.$nome_arquivo, $diretorio_p.$nome_arquivo);
				}

				//grava banco
				$db = new mysql();
				$db->inserir("revistajornal_imagem", array(
					"codigo"=>"$codigo",
					"pagina"=>"$pagina",
					"imagem"=>"$nome_arquivo"
				));

				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem#pagina_'.$pagina);
			
			} else {
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem#pagina_".$pagina);
			}
		}		
	}

	public function apagar_imagem(){

		$codigo = $this->get('codigo');
		$pagina = $this->get('pagina');

		if($pagina AND $codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM revistajornal_imagem where codigo='$codigo' AND pagina='$pagina' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_revistajornal_g/'.$data->imagem);
				unlink('../arquivos/img_revistajornal_p/'.$data->imagem);
			}

			$conexao = new mysql();
			$conexao->apagar("revistajornal_imagem", " codigo='$codigo' AND pagina='$pagina' ");
		} else {
			$this->msg('Ocorreu um erro!');
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM revistajornal ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$db = new mysql();
				$exec_img = $db->executar("SELECT * FROM revistajornal_imagem where codigo='$data->codigo' ");
				while($data_img = $exec_img->fetch_object()){
					if($data_img->imagem){
						unlink('../arquivos/img_revistajornal_g/'.$data_img->imagem);
						unlink('../arquivos/img_revistajornal_p/'.$data_img->imagem);
					}
				}

				$conexao = new mysql();
				$conexao->apagar("revistajornal_imagem", " codigo='$data->codigo' ");

				$conexao = new mysql();
				$conexao->apagar("revistajornal", " codigo='$data->codigo' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}

	/////////////////////////////////////////////////////////////

	public function formatos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Formatos";

		$revistajornal = new model_revistajornal();		 
		$dados['lista'] = $revistajornal->formatos();

		$this->view('revistajornal.formatos', $dados);
	}

	public function formatos_novo(){

		$dados['_base'] = $this->base();

		$this->view('revistajornal.formatos.novo', $dados);
	}

	public function formatos_novo_grv(){

		$titulo = $this->post('titulo');
		$grande_largura = $this->post('grande_largura');
		$grande_altura = $this->post('grande_altura');
		$pequena_largura = $this->post('pequena_largura');
		$pequena_altura = $this->post('pequena_altura');

		$this->valida($titulo);
		$this->valida($grande_largura);
		$this->valida($grande_altura);
		$this->valida($pequena_largura);
		$this->valida($pequena_altura);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("revistajornal_formatos", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"pequena_largura"=>"$pequena_largura",
			"pequena_altura"=>"$pequena_altura",
			"grande_largura"=>"$grande_largura",
			"grande_altura"=>"$grande_altura"			 
		));

		$this->irpara(DOMINIO.$this->_controller.'/formatos');
	}

	public function formatos_alterar(){

		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');

		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM revistajornal_formatos WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/formatos');
		}

		$this->view('revistajornal.formatos.alterar', $dados);
	}

	public function formatos_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$grande_largura = $this->post('grande_largura');
		$grande_altura = $this->post('grande_altura');
		$pequena_largura = $this->post('pequena_largura');
		$pequena_altura = $this->post('pequena_altura');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($grande_largura);
		$this->valida($grande_altura);
		$this->valida($pequena_largura);
		$this->valida($pequena_altura);

		$db = new mysql();
		$db->alterar("revistajornal_formatos", array(
			"titulo"=>"$titulo",
			"pequena_largura"=>"$pequena_largura",
			"pequena_altura"=>"$pequena_altura",
			"grande_largura"=>"$grande_largura",
			"grande_altura"=>"$grande_altura"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/formatos');	
	}

	public function formatos_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM revistajornal_formatos ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("revistajornal_formatos", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/formatos');
	}


	// grupos


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$revistajornal = new model_revistajornal();
		
		$dados['grupos'] = $revistajornal->lista_grupos();
		
		$this->view('revistajornal.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('revistajornal.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$revistajornal = new model_revistajornal();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('revistajornal_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,			 
			'itens_por_linha'=>'4'
		));
		
		// layout
		
		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$tipo = "revistajornal";
		$titulo_pagina = "Revistas/Jornal - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);


		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$revistajornal = new model_revistajornal();

		$codigo = $this->get('codigo');

		$dados['data'] = $revistajornal->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('revistajornal.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$itens_por_linha = $this->post('itens_por_linha');
		$descricao = $this->post_htm('descricao'); 
		
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
		$db->alterar("revistajornal_grupos", array(
			'titulo'=>$titulo,
			'mostrar_titulo'=>$mostrar_titulo,
			'itens_por_linha'=>$itens_por_linha,
			'descricao'=>$descricao,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		

		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pgaina = "Revistas/Jornal - $titulo";
		$tipo = "revistajornal";
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
		$revistajornal = new model_revistajornal();

		foreach ($revistajornal->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('revistajornal_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('revistajornal', " grupo='".$value['codigo']."' ");
				
				$db = new mysql();
				$db->apagar('revistajornal_ordem', " grupo='".$value['codigo']."' ");
				
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