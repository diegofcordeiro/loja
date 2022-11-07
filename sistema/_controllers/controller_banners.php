<?php

class banners extends controller {
	
	protected $_modulo_nome = "Banners";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(44);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$banners = new model_banners();
		
		$grupo = $this->get('grupo');
		
		$dados['grupos'] = $banners->lista_grupos($grupo);
		
		if(!$grupo){
			$grupo = $dados['grupos'][0]['codigo'];
		}
		$dados['grupo_selecionado'] = $grupo;
		$dados['lista'] = $banners->lista($grupo);
		
		$this->view('banners', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados"; 	 	 

 		// Instancia
		$banners = new model_banners();

		$grupo = $this->get('grupo');
		$dados['grupo_selecionado'] = $grupo;
		$dados['grupos'] = $banners->lista_grupos($grupo);

		$this->view('banners.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');
		$endereco = $this->post_htm('endereco');
		$texto = $this->post_html('texto'); 
		
		$this->valida($titulo);
		$this->valida($grupo);
		
		// Instancia
		$banners = new model_banners();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('banners', array(
			'codigo'	=>$codigo,
			'grupo'		=>$grupo,
			'titulo'	=>$titulo,
			'endereco'	=>$endereco,
			'texto'	=>$texto
		));
		$ultid = $db->ultimo_id();
		
		$ordem = $banners->ordem($grupo);

		if($ordem){
			$novaordem = $ordem.",".$ultid;
		} else {
			$novaordem = $ultid;
		}
		$banners->altera_ordem($novaordem, $grupo);

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

 		// Instancia
		$banners = new model_banners(); 		
		
		$dados['data'] = $banners->carrega($codigo);		
		$dados['grupos'] = $banners->lista_grupos($dados['data']->grupo);
		
		$layout = new model_layout();
		$dados['botoes'] = $layout->lista_botoes();

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

		$this->view('banners.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$grupo_produtos = $this->post('grupo_produtos');
		$endereco = $this->post_htm('endereco');
		$texto = $this->post_html('texto'); 

		$endereco_padrao = $this->post_htm('endereco_padrao');
		$botao_codigo = $this->post('botao_codigo');
		$botao_alinhamento = $this->post('botao_alinhamento');
		
		$this->valida($codigo);
		$this->valida($titulo);

		if($endereco_padrao){
			$endereco = $endereco_padrao;
		}

		$db = new mysql();
		$db->alterar('banners', array(
			'titulo'	=>$titulo,
			'endereco'	=>$endereco,
			'texto'	=>$texto,
			'botao_codigo'=>$botao_codigo,
			'botao_alinhamento'=>$botao_alinhamento
		), " codigo='$codigo' " );

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function imagem(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$banners = new model_banners();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_banners/";

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
				
				//grava banco
				$banners->altera_imagem($nome_arquivo, $codigo);
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
				
			}

		}
		
	}

	public function apagar_imagem(){
		
		// Instancia
		$banners = new model_banners();

		$codigo = $this->get('codigo');
		
		if($codigo){

			$data = $banners->carrega($codigo);

			if($data->imagem){
				unlink('../arquivos/img_banners/'.$data->imagem);
			}
			//grava banco
			$banners->altera_imagem("", $codigo);

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){
		
		// Instancia
		$banners = new model_banners();
		
		$grupo = $this->get('grupo');
		
		foreach ($banners->lista($grupo) as $key => $value) {			 
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				if($value['imagem']){
					unlink('../arquivos/img_banners/'.$value['imagem']);
				}
				
				$banners->apaga_banner($value['codigo']);
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial/grupo/'.$grupo);
		
	}
	
	// ORDEM

	public function ordem(){

		// Instancia
		$banners = new model_banners();
		
		$codigo = $this->post('grupo');
		$list = $_POST['list'];
		
		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$banners->altera_ordem($ordem, $codigo);

	}


	// grupos

	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$banners = new model_banners();		
		$dados['grupos'] = $banners->lista_grupos();
		
		$this->view('banners.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('banners.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$banner = new model_banners();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('banners_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo
		));

		// layout
		$layout = new model_layout();
		$tipo = "banner";
		$titulo_pagina = "Banners - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";
		
 		// Instancia
		$banner = new model_banners();

		$codigo = $this->get('codigo');

		$dados['data'] = $banner->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$this->view('banners.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

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
		$db->alterar("banners_grupos", array(
			'titulo'=>$titulo,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");

		
		// layout
		$layout = new model_layout();
		$tipo = "banner";
		$titulo_pagina = "Banners - $titulo";
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
		$banner = new model_banners();

		foreach ($banner->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				if($value['bloqueio'] == 0){

					$db = new mysql();
					$db->apagar('banners_grupos', " codigo='".$value['codigo']."' ");

					$db = new mysql();
					$db->apagar('banner', " grupo='".$value['codigo']."' ");

					$db = new mysql();
					$db->apagar('banners_ordem', " grupo='".$value['codigo']."' ");
					
					// layout
					$layout = new model_layout(); 
					$layout->apagar_pagina($value['codigo']);
					$layout->apagar_cores($value['codigo']);
					
				}
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

}