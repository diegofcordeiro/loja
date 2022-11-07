<?php

class equipe extends controller {
	
	protected $_modulo_nome = "Equipe";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(111);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$equipe = new model_equipe();
		$dados['grupos'] = $equipe->lista_grupos();

		$grupo = $this->get('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}

		$dados['grupo_selecionado'] = $grupo;
		$dados['lista'] = $equipe->lista($grupo);

		$this->view('equipe', $dados);
	}

	public function ordem(){
		
		$grupo = $this->post('grupo');
		$list = $_POST['list'];

		if($grupo AND $list){

			$output = array();
			parse_str($list, $output);
			$ordem = implode(',', $output['item']);

			$db = new mysql();
			$db->apagar("equipe_ordem", " grupo='$grupo' ");

			$db = new mysql();
			$db->inserir("equipe_ordem", array(
				"grupo"=>$grupo,
				"data"=>$ordem
			));

		}
	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";
		
		$dados['aba_selecionada'] = "dados";
		
		$equipe = new model_equipe();
		$dados['grupos'] = $equipe->lista_grupos();

		$this->view('equipe.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');

		$this->valida($titulo);
		$this->valida($grupo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("equipe", array(
			"codigo"=>"$codigo",
			"grupo"=>"$grupo",
			"titulo"=>"$titulo"
		));

		$ultid = $db->ultimo_id();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM equipe_ordem WHERE grupo='$grupo' order by id desc limit 1");
		$data = $exec->fetch_object();

		if(isset($data->data)){
			$novaordem = $data->data.",".$ultid;
		} else {
			$novaordem = $ultid;
		}

		$db = new mysql();
		$db->inserir("equipe_ordem", array(
			"grupo"=>$grupo,
			"data"=>$novaordem
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/imagem/codigo/'.$codigo);
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
		$exec = $db->Executar("SELECT * FROM equipe where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$equipe = new model_equipe();
		$dados['lista_links'] = $equipe->lista_links($codigo);

		$this->view('equipe.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$conteudo = $this->post_htm('conteudo');
		
		$this->valida($codigo);
		$this->valida($titulo);
		
		$db = new mysql();
		$db->alterar("equipe", array(
			"titulo"=>"$titulo",
			"conteudo"=>"$conteudo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}
	
	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM equipe ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){ 
				
				if($data->imagem){
					unlink('../arquivos/img_equipe/'.$data->imagem); 
				}
				
				$conexao = new mysql();
				$conexao->apagar("equipe", " codigo='$data->codigo' ");
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial');		
	}

	public function imagem(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		
		// Instancia
		$equipe = new model_equipe();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_equipe/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				$db = new mysql();
				$db->alterar("equipe", array(
					"imagem"=>"$nome_arquivo"
				), " codigo='$codigo' ");
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');

			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
				
			}

		}
		
	}

	public function apagar_imagem(){
		
		$codigo = $this->get('codigo');
		
		if($codigo){
			
			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM equipe WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_equipe/'.$data->imagem);
			}
			//grava banco
			$db = new mysql();
			$db->alterar("equipe", array(
				"imagem"=>""
			), " codigo='$codigo' ");
			
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}


	public function links_novo(){

		$dados['_base'] = $this->base();
		
		$dados['codigo'] = $this->get('codigo');
		
		$this->view('equipe.links.novo', $dados);
	}

	public function links_novo_grv(){

		$titulo = $this->post('titulo');
		$link = $this->post_htm('link');
		$codigo = $this->post('codigo');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($link);

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();

		$diretorio = "../arquivos/img_equipe/";
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				$db = new mysql();
				$db->inserir("equipe_links", array(
					"codigo"=>"$codigo",
					"titulo"=>"$titulo",
					"ico"=>"$nome_arquivo",
					"link"=>"$link"
				));

				$this->msg('Cadastrado com sucesso!');

			} else {
				$this->msg('Erro ao copiar arquivo!');
			}

			$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/links');	
		}
	}

	public function links_apagar(){

		$id = $this->get('id');
		
		if($id){
			
			$equipe = new model_equipe();
			$data = $equipe->carrega_link($id);

			if($data->codigo){
				
				unlink('../arquivos/img_equipe/'.$data->ico);
				
				$codigo = $data->codigo;
				
				$db = new mysql();
				$db->apagar("equipe_links"," id='".$id."' ");
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/links');	
	}


	// grupos


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$equipe = new model_equipe();
		
		$dados['grupos'] = $equipe->lista_grupos();
		
		$this->view('equipe.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('equipe.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$equipe = new model_equipe();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('equipe_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,			 
			'itens_por_linha'=>'4'
		));
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "equipe";
		$titulo_pagina = "Equipe - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);


		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$equipe = new model_equipe();

		$codigo = $this->get('codigo');

		$dados['data'] = $equipe->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('equipe.grupos.alterar', $dados);
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
		$db->alterar("equipe_grupos", array(
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
		$titulo_pgaina = "Equipe - $titulo";
		$tipo = "equipe";
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
		$equipe = new model_equipe();

		foreach ($equipe->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('equipe_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('equipe', " grupo='".$value['codigo']."' ");
				
				$db = new mysql();
				$db->apagar('equipe_ordem', " grupo='".$value['codigo']."' ");
				
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