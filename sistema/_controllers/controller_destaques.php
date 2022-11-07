<?php

class destaques extends controller {
	
	protected $_modulo_nome = "Destaques";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(128);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$destaques = new model_destaques();
		
		$grupo = $this->get('grupo');
		
		$dados['grupos'] = $destaques->lista_grupos($grupo);
		
		if(!$grupo){
			$grupo = $dados['grupos'][0]['codigo'];
		}
		$dados['grupo_selecionado'] = $grupo;
		$dados['lista'] = $destaques->lista($grupo);
		
		$this->view('destaques', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados"; 	 	 

 		// Instancia
		$destaques = new model_destaques();

		$grupo = $this->get('grupo');
		$dados['grupo_selecionado'] = $grupo;
		$dados['grupos'] = $destaques->lista_grupos($grupo);

		$this->view('destaques.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');
		$endereco = $this->post_htm('endereco');

		$this->valida($titulo);
		$this->valida($grupo);
		
		// Instancia
		$destaques = new model_destaques();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('destaques', array(
			'codigo'	=>$codigo,
			'grupo'		=>$grupo,
			'titulo'	=>$titulo,
			'endereco'	=>$endereco
		));
		$ultid = $db->ultimo_id();
		
		$ordem = $destaques->ordem($grupo);

		if($ordem){
			$novaordem = $ordem.",".$ultid;
		} else {
			$novaordem = $ultid;
		}
		$destaques->altera_ordem($novaordem, $grupo);

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
		$destaques = new model_destaques(); 		
		
		$dados['data'] = $destaques->carrega($codigo);		
		$dados['grupos'] = $destaques->lista_grupos($dados['data']->grupo);
		
		$this->view('destaques.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$grupo_produtos = $this->post('grupo_produtos');
		$endereco = $this->post_htm('endereco');

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar('destaques', array(
			'titulo'	=>$titulo,
			'endereco'	=>$endereco
		), " codigo='$codigo' " );

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$destaques = new model_destaques();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_destaques/";

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
				$destaques->altera_imagem($nome_arquivo, $codigo);
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
				
			}

		}
		
	}

	public function apagar_imagem(){
		
		// Instancia
		$destaques = new model_destaques();

		$codigo = $this->get('codigo');
		
		if($codigo){

			$data = $destaques->carrega($codigo);

			if($data->imagem){
				unlink('../arquivos/img_destaques/'.$data->imagem);
			}
			//grava banco
			$destaques->altera_imagem("", $codigo);

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){
		
		// Instancia
		$destaques = new model_destaques();
		
		$grupo = $this->get('grupo');
		
		foreach ($destaques->lista($grupo) as $key => $value) {			 
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				if($value['imagem']){
					unlink('../arquivos/img_destaques/'.$value['imagem']);
				}
				
				$destaques->apaga_destaques($value['codigo']);
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial/grupo/'.$grupo);
		
	}
	
	// ORDEM

	public function ordem(){

		// Instancia
		$destaques = new model_destaques();
		
		$codigo = $this->post('grupo');
		$list = $_POST['list'];
		
		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$destaques->altera_ordem($ordem, $codigo);

	}


	// grupos

	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$destaques = new model_destaques();
		
		$dados['grupos'] = $destaques->lista_grupos();
		
		$this->view('destaques.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('destaques.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$destaques = new model_destaques();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('destaques_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo
		));
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "destaques";
		$titulo_pagina = "Destaques - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$destaques = new model_destaques();

		$codigo = $this->get('codigo');

		$dados['data'] = $destaques->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('destaques.grupos.alterar', $dados);
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
		$db->alterar("destaques_grupos", array(
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
		$tipo = "destaques";
		$titulo_pgaina = "Destaques - $titulo";
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
		$destaques = new model_destaques();

		foreach ($destaques->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				if($value['bloqueio'] == 0){

					$db = new mysql();
					$db->apagar('destaques_grupos', " codigo='".$value['codigo']."' ");

					$db = new mysql();
					$db->apagar('destaques', " grupo='".$value['codigo']."' ");

					$db = new mysql();
					$db->apagar('destaques_ordem', " grupo='".$value['codigo']."' ");
					
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