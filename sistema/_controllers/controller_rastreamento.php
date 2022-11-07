<?php

class rastreamento extends controller {
	
	protected $_modulo_nome = "Rastreamento";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(131);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$rastreamento = new model_rastreamento();
		$dados['lista'] = $rastreamento->lista_objetos();	
		
		$this->view('rastreamento', $dados);
	}


	public function objetos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";
		
		$dados['aba_selecionada'] = "dados";
		
		$this->view('rastreamento.objetos.novo', $dados);
	}
	
	public function objetos_novo_grv(){
		
		$ref = $this->post('ref');
		$origem = $this->post('origem');
		$destino = $this->post('destino');

		$this->valida($ref);
		$this->valida($origem);
		$this->valida($destino);

		$codigo = $this->gera_codigo();
		$time = time();

		$db = new mysql();
		$db->inserir("rastreamento_objetos", array(
			"codigo"=>$codigo,
			"ref"=>$ref,
			"data"=>$time,
			"origem"=>$origem,
			"destino"=>$destino
		));

		$this->irpara(DOMINIO.$this->_controller.'/objetos_alterar/codigo/'.$codigo);
	}

	public function objetos_alterar(){

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
		$exec = $db->executar("SELECT * FROM rastreamento_objetos WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$rastreamento = new model_rastreamento();
		$dados['lista'] = $rastreamento->lista_objetos_itens($codigo);	

		$this->view('rastreamento.objetos.alterar', $dados);
	}

	public function objetos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$origem = $this->post('origem');
		$destino = $this->post('destino');
		$status = $this->post('status');
		$ref = $this->post('ref');
		$volumes = $this->post('volumes');
		
		$this->valida($codigo);
		$this->valida($ref); 
		
		$db = new mysql();
		$db->alterar("rastreamento_objetos", array(
			"ref"=>$ref,
			"origem"=>$origem,
			"destino"=>$destino,
			"status"=>$status,
			"volumes"=>$volumes
		), " codigo='".$codigo."' ");

		$this->irpara(DOMINIO.$this->_controller.'/objetos_alterar/codigo/'.$codigo);		
	}

	public function objetos_novo_item(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";
		
		$codigo = $this->get('codigo');
		$dados['codigo'] = $codigo;

		$this->view('rastreamento.objetos.itens.novo', $dados);
	}
	
	public function objetos_novo_item_grv(){
		
		$codigo = $this->post('codigo');
		$descricao = $this->post('descricao');

		$this->valida($codigo);
		$this->valida($descricao);

		$time = time();

		$db = new mysql();
		$db->inserir("rastreamento_objetos_itens", array(
			"codigo"=>$codigo,
			"data"=>$time,
			"descricao"=>$descricao
		));

		$this->irpara(DOMINIO.$this->_controller.'/objetos_alterar/codigo/'.$codigo.'/aba/itens');
	}


	public function objetos_alterar_item(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		
		$codigo = $this->get('codigo');
		$item = $this->get('item');
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM rastreamento_objetos_itens WHERE id='$item' ");
		$dados['data'] = $exec->fetch_object();
		
		$this->view('rastreamento.objetos.itens.alterar', $dados);
	}

	public function objetos_alterar_item_grv(){

		$codigo = $this->post('codigo');
		$item = $this->post('item');
		$descricao = $this->post('descricao'); 
		
		$this->valida($codigo);
		$this->valida($item); 
		
		$db = new mysql();
		$db->alterar("rastreamento_objetos_itens", array(
			"descricao"=>$descricao
		), " id='".$item."' ");

		$this->irpara(DOMINIO.$this->_controller.'/objetos_alterar/codigo/'.$codigo.'/aba/itens');	
	}


	public function objetos_apagar_item(){

		$codigo = $this->get('codigo');
		$item = $this->get('item');

		if($codigo AND $item){ 

			$db = new mysql();
			$db->apagar("rastreamento_objetos_itens", " id='".$item."' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/objetos_alterar/codigo/'.$codigo.'/aba/itens');	
	}

	
	public function objetos_apagar(){
		
		$rastreamento = new model_rastreamento();
		
		foreach ($rastreamento->lista_objetos() as $key => $value) {			 

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("rastreamento_objetos", " id='".$value['id']."' ");

				$db = new mysql();
				$db->apagar("rastreamento_objetos_itens", " codigo='".$value['codigo']."' ");
				
			}

		}

		$this->irpara(DOMINIO.$this->_controller.'/');
	}
	

	public function objetos_anexo(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$rastreamento = new model_rastreamento();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_rastreamento/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){				 

				$db = new mysql();
				$db->alterar("rastreamento_objetos", array(
					"anexo"=>"$nome_arquivo"
				), " codigo='$codigo' ");

				$this->irpara(DOMINIO.$this->_controller.'/objetos_alterar/codigo/'.$codigo.'/aba/anexo');

			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/objetos_alterar/codigo/".$codigo."/aba/anexo");

			}

		}		

	}


	public function objetos_anexo_apagar(){
		
		// Instancia
		$rastreamento = new model_rastreamento();
		
		$codigo = $this->get('codigo');
		
		if($codigo){
			
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM rastreamento_objetos WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();
			
			if($data->anexo){
				unlink('../arquivos/img_rastreamento/'.$data->anexo);
			}
			
			$db = new mysql();
			$db->alterar("rastreamento_objetos", array(
				"anexo"=>""
			), " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller."/objetos_alterar/codigo/".$codigo."/aba/anexo");
	}




	/////////////////////////////////////////////////////////////////////////




	public function grupos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos/Páginas";

		// Instancia
		$rastreamento = new model_rastreamento();
		$dados['lista'] = $rastreamento->lista();	

		$this->view('rastreamento.grupos', $dados);
	}	

	public function novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('rastreamento.novo', $dados);
	}

	public function novo_grv(){

		$titulo = $this->post_htm('titulo');
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("rastreamento", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"posicao"=>1
		));

		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$tipo = "rastreamento";
		$titulo_pagina = "Rastreamento - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

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
		$exec = $db->executar("SELECT * FROM rastreamento WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		

		$this->view('rastreamento.alterar', $dados);
	}

	public function alterar_grv(){

		$id = $this->post('id');
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$tipo = $this->post('tipo');
		$posicao = $this->post('posicao');
		$descricao = $this->post_htm('descricao');
		$botao_titulo = $this->post('botao_titulo');
		$imagem_fundo_tipo = $this->post('imagem_fundo_tipo');
		$botao = $this->post('botao');

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
		$db->alterar("rastreamento", array(
			"titulo"=>$titulo,
			"mostrar_titulo"=>$mostrar_titulo, 
			"conteudo"=>$descricao,
			"posicao"=>$posicao,
			"botao_titulo"=>$botao_titulo,
			"imagem_fundo_tipo"=>$imagem_fundo_tipo,
			"botao_codigo"=>$botao,
			"classes"=>$lista_css_tratada,
			"classes_img"=>$lista_css_img_tratada
		), " codigo='".$codigo."' ");
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$titulo_pagina = "Rastreamento - $titulo";
		$tipo = "rastreamento";
		$layout->altera_paginas($codigo, $titulo_pagina);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function cores_grv(){

		$id = $this->post('id');
		$codigo = $this->post('codigo');

		$this->valida($codigo);
		$this->valida($id);

		$layout = new model_layout();
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

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/cores');		
	}

	public function imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$rastreamento = new model_rastreamento();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_rastreamento/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					$largura_g = 1200;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);

					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g , $diretorio.$nome_arquivo);
				}

				$db = new mysql();
				$db->alterar("rastreamento", array(
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

		// Instancia
		$rastreamento = new model_rastreamento();

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM rastreamento WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_rastreamento/'.$data->imagem);
			}

			$db = new mysql();
			$db->alterar("rastreamento", array(
				"imagem"=>""
			), " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function imagem_fundo(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$rastreamento = new model_rastreamento();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_rastreamento/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					$largura_g = 1600;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);

					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g , $diretorio.$nome_arquivo);
				}

				$db = new mysql();
				$db->alterar("rastreamento", array(
					"imagem_fundo"=>"$nome_arquivo"
				), " codigo='$codigo' ");

				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem_fundo');

			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem_fundo");

			}

		}

	}

	public function apagar_imagem_fundo(){

		// Instancia
		$rastreamento = new model_rastreamento();

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM rastreamento WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem_fundo){
				unlink('../arquivos/img_rastreamento/'.$data->imagem_fundo);
			}

			$db = new mysql();
			$db->alterar("rastreamento", array(
				"imagem_fundo"=>""
			), " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){

		$rastreamento = new model_rastreamento();

		foreach ($rastreamento->lista() as $key => $value) {			 

			if($this->post('apagar_'.$value['id']) == 1){

				if($value['imagem']){
					unlink('../arquivos/img_rastreamento/'.$value['imagem']);
				}

				if($value['imagem_fundo']){
					unlink('../arquivos/img_rastreamento/'.$value['imagem_fundo']);
				}

				$db = new mysql();
				$db->apagar("rastreamento", " id='".$value['id']."' ");


				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}

		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');
	}
}