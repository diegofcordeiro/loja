<?php

class depoimentos extends controller {
	
	protected $_modulo_nome = "Depoimentos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(82);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$aba = $this->get('aba');

		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'aguardando';
		}

		//intancia
		$depoimentos = new model_depoimentos();	 
		$dados['grupos'] = $depoimentos->lista_grupos();

		$grupo = $this->get('grupo');
		if($grupo){
			$lista = $depoimentos->lista($grupo);
		} else {
			$lista = $depoimentos->lista();
			$grupo = '0';
		}

		$dados['aguardando'] = $lista['aguardando'];
		$dados['aprovados'] = $lista['aprovados'];		
		$dados['grupo_selecionado'] = $grupo;

		$this->view('depoimentos', $dados);
	}
	
	public function novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$depoimentos = new model_depoimentos();
		$dados['grupos'] = $depoimentos->lista_grupos();

		$this->view('depoimentos.novo', $dados);
	}

	public function novo_grv(){
		
		$grupo = $this->post('grupo');
		$nome = $this->post('nome');
		$email = $this->post('email');
		$cidade = $this->post('cidade');
		$empresa = $this->post('empresa');
		$conteudo = $this->post('conteudo');

		$this->valida($grupo);
		$this->valida($nome);
		$this->valida($conteudo); 

		$time = time();
		
		$db = new mysql();
		$db->inserir("depoimentos", array(
			'grupo'=>$grupo,
			'data'=>$time,
			'nome'=>$nome,
			'email'=>$email,
			'cidade'=>$cidade,
			'empresa'=>$empresa,
			'conteudo'=>$conteudo,
			'bloqueio'=>"2"
		));

		$this->irpara(DOMINIO.$this->_controller);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

 		//intancia
		$depoimentos = new model_depoimentos();

		$id = $this->get('id');

		$dados['data'] = $depoimentos->carregar($id);
		$dados['grupos'] = $depoimentos->lista_grupos();

		$this->view('depoimentos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$id = $this->post('id');		 
		$nome = $this->post('nome');
		$email = $this->post('email');
		$cidade = $this->post('cidade');
		$empresa = $this->post('empresa');
		$conteudo = $this->post('conteudo');
		$bloqueio = $this->post('bloqueio');

		$this->valida($id);
		$this->valida($nome);
		$this->valida($conteudo);

		$db = new mysql();
		$db->alterar("depoimentos", array(
			'nome'=>$nome,
			'email'=>$email,
			'cidade'=>$cidade,
			'empresa'=>$empresa,
			'conteudo'=>$conteudo,
			'bloqueio'=>$bloqueio
		), " id='".$id."' ");

		$this->irpara(DOMINIO.$this->_controller);		
	}

	public function apagar(){
		
		$id = $this->get('id');
		
		$this->valida($id);
		
		//intancia
		$depoimentos = new model_depoimentos();
		$data = $depoimentos->carregar($id);
		
		if($data->imagem){
			unlink('../arquivos/img_depoimentos/'.$data->imagem);
		}
		
		// executa
		$db = new mysql();
		$db->apagar("depoimentos", " id='".$id."' ");

		$this->irpara(DOMINIO.$this->_controller);		
	}

	public function imagem(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Imagem";

 		//intancia
		$depoimentos = new model_depoimentos();

		$id = $this->get('id');

		$dados['data'] = $depoimentos->carregar($id);

		$this->view('depoimentos.imagem', $dados);
	}

	public function alterar_imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		
		$depoimentos = new model_depoimentos();		

		$id = $this->post('id');
		$this->valida($id);

		$diretorio = "../arquivos/img_depoimentos/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					$largura_g = 800;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);
					//redimenciona
					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g , $diretorio.$nome_arquivo);
					
				}

				$db = new mysql();
				$db->alterar("depoimentos", array(
					"imagem"=>$nome_arquivo
				), " id='".$id."' ");

				$this->irpara(DOMINIO.$this->_controller.'/imagem/id/'.$id);
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller.'/imagem/id/'.$id);
				
			}

		}
		
	}

	public function apagar_imagem(){
		
		// Instancia
		$depoimentos = new model_depoimentos();

		$id = $this->get('id');
		
		if($id){

			$data = $depoimentos->carregar($id);

			if($data->imagem){
				unlink('../arquivos/img_depoimentos/'.$data->imagem);
			}

			//grava banco
			$db = new mysql();
			$db->alterar("depoimentos", array(
				"imagem"=>""
			), " id='".$id."' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/imagem/id/'.$id);
	}


	// grupos


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$depoimentos = new model_depoimentos();
		
		$dados['grupos'] = $depoimentos->lista_grupos();
		
		$this->view('depoimentos.grupos', $dados);
	}
	
	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";
		
		$this->view('depoimentos.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$depoimentos = new model_depoimentos();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('depoimentos_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo
		));
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "depoimentos";
		$titulo_pagina = "Depoimentos - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$depoimentos = new model_depoimentos();

		$codigo = $this->get('codigo');

		$dados['data'] = $depoimentos->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('depoimentos.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$descricao = $this->post_htm('descricao'); 
		$mostrar_titulo = $this->post('mostrar_titulo');
		$botao_codigo = $this->post('botao_codigo');
		$botao_codigo_env_dep = $this->post('botao_codigo_env_dep');
		
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
		$db->alterar("depoimentos_grupos", array(
			'titulo'=>$titulo,
			'descricao'=>$descricao,
			'mostrar_titulo'=>$mostrar_titulo,
			'botao_codigo'=>$botao_codigo,
			'botao_codigo_env_dep'=>$botao_codigo_env_dep,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pagina = "Depoimentos - $titulo";
		$tipo = "depoimentos";
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
		$depoimentos = new model_depoimentos();

		foreach ($depoimentos->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('depoimentos_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('depoimentos', " grupo='".$value['codigo']."' ");
				
				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

}