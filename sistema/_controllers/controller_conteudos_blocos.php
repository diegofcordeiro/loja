<?php

class conteudos_blocos extends controller {
	
	protected $_modulo_nome = "Conteúdos em blocos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(121);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$conteudos_blocos = new model_conteudos_blocos();
		$dados['lista'] = $conteudos_blocos->lista();	
		
		$this->view('conteudos_blocos', $dados);
	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";
		
		$dados['aba_selecionada'] = "dados";
		
		$this->view('conteudos_blocos.novo', $dados);
	}
	
	public function novo_grv(){
		
		$titulo = $this->post_htm('titulo');
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("conteudos_blocos", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"posicao"=>1
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "conteudos_blocos";
		$titulo_pagina = "Conteúdos em blocos - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores('blocos', $codigo);

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
		$exec = $db->executar("SELECT * FROM conteudos_blocos WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();
		
		$destinos = array();
		$n = 0;

		$db = new mysql();
		$exec_des = $db->executar("SELECT * FROM layout_paginas order by titulo asc");
		while($data_des = $exec_des->fetch_object()){

			$destinos[$n]['titulo'] = $data_des->titulo;
			$destinos[$n]['chave'] = $data_des->chave;

			$n++;
		}
		$dados['destinos'] = $destinos;
		
		$this->view('conteudos_blocos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$id = $this->post('id');
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$tipo = $this->post('tipo');
		$posicao = $this->post('posicao');
		$descricao = $this->post_htm('descricao'); 
		$imagem_fundo_tipo = $this->post('imagem_fundo_tipo');
		
		$endereco1 = $this->post_htm('endereco1'); 
		$endereco_padrao1 = $this->post('endereco_padrao1');
		$endereco2 = $this->post_htm('endereco2'); 
		$endereco_padrao2 = $this->post('endereco_padrao2');
		
		$margem = $this->post('margem');
		$botao1 = $this->post('botao1');
		$botao2 = $this->post('botao2');

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
		$db->alterar("conteudos_blocos", array(
			"titulo"=>$titulo,
			"mostrar_titulo"=>$mostrar_titulo,
			"tipo"=>$tipo,
			"conteudo"=>$descricao,
			"posicao"=>$posicao,
			"endereco_padrao1"=>$endereco_padrao1,
			"endereco_padrao2"=>$endereco_padrao2,
			"endereco1"=>$endereco1, 
			"endereco2"=>$endereco2, 
			"imagem_fundo_tipo"=>$imagem_fundo_tipo,
			"botao_codigo1"=>$botao1,
			"botao_codigo2"=>$botao2,
			"margem"=>$margem,
			"classes"=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='".$codigo."' ");
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$titulo_pagina = "Conteúdos em blocos - $titulo";
		$tipo = "conteudos_blocos";
		$layout->altera_paginas($codigo, $titulo_pagina);
		$layout->adiciona_cores('blocos', $codigo);
		
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
		
		$layout = new model_layout();
		$layout->adiciona_cores('blocos', $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/cores');		
	}

	public function imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$conteudos_blocos = new model_conteudos_blocos();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_conteudos_blocos/";

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
				$db->alterar("conteudos_blocos", array(
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
		$conteudos_blocos = new model_conteudos_blocos();

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM conteudos_blocos WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_conteudos_blocos/'.$data->imagem);
			}

			$db = new mysql();
			$db->alterar("conteudos_blocos", array(
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
		$conteudos_blocos = new model_conteudos_blocos();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_conteudos_blocos/";

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
				$db->alterar("conteudos_blocos", array(
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
		$conteudos_blocos = new model_conteudos_blocos();

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM conteudos_blocos WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem_fundo){
				unlink('../arquivos/img_conteudos_blocos/'.$data->imagem_fundo);
			}

			$db = new mysql();
			$db->alterar("conteudos_blocos", array(
				"imagem_fundo"=>""
			), " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){

		$conteudos_blocos = new model_conteudos_blocos();

		foreach ($conteudos_blocos->lista() as $key => $value) {			 

			if($this->post('apagar_'.$value['id']) == 1){

				if($value['imagem']){
					unlink('../arquivos/img_conteudos_blocos/'.$value['imagem']);
				}

				if($value['imagem_fundo']){
					unlink('../arquivos/img_conteudos_blocos/'.$value['imagem_fundo']);
				}

				$db = new mysql();
				$db->apagar("conteudos_blocos", " id='".$value['id']."' ");

				
				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}

		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial');
	}
}