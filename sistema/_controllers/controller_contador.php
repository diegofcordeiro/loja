<?php

class contador extends controller {
	
	protected $_modulo_nome = "Contadores";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(109);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$contador = new model_contador();
		$dados['grupos'] = $contador->lista_grupos();

		$grupo = $this->get('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}

		$dados['grupo_selecionado'] = $grupo;
		$dados['lista'] = $contador->lista($grupo);

		$this->view('contador', $dados);
	}

	public function ordem(){
		
		$grupo = $this->post('grupo');
		$list = $_POST['list'];

		if($grupo AND $list){

			$output = array();
			parse_str($list, $output);
			$ordem = implode(',', $output['item']);

			$db = new mysql();
			$db->apagar("contador_ordem", " grupo='$grupo' ");

			$db = new mysql();
			$db->inserir("contador_ordem", array(
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
		
		$contador = new model_contador();
		$dados['grupos'] = $contador->lista_grupos();

		$this->view('contador.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');
		$valor = $this->post('valor');
		
		$this->valida($titulo);
		$this->valida($grupo);
		$this->valida($valor);
		
		$codigo = $this->gera_codigo();
		
		$db = new mysql();
		$db->inserir("contador", array(
			"codigo"=>"$codigo",
			"grupo"=>"$grupo",
			"titulo"=>"$titulo",
			"valor"=>"$valor"
		));

		$ultid = $db->ultimo_id();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM contador_ordem WHERE grupo='$grupo' order by id desc limit 1");
		$data = $exec->fetch_object();

		if(isset($data->data)){
			$novaordem = $data->data.",".$ultid;
		} else {
			$novaordem = $ultid;
		}

		$db = new mysql();
		$db->inserir("contador_ordem", array(
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
		$exec = $db->Executar("SELECT * FROM contador where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$this->view('contador.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$valor = $this->post('valor');
		$conteudo = $this->post_htm('conteudo');
		
		$this->valida($codigo);
		$this->valida($titulo);
		
		$db = new mysql();
		$db->alterar("contador", array(
			"titulo"=>"$titulo",
			"conteudo"=>"$conteudo",
			"valor"=>"$valor"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM contador ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){ 
				
				if($data->imagem){
					unlink('../arquivos/img_contador/'.$data->imagem); 
				}
				
				$conexao = new mysql();
				$conexao->apagar("contador", " codigo='$data->codigo' ");
				
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
		$contador = new model_contador();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_contador/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				$db = new mysql();
				$db->alterar("contador", array(
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
			$exec = $db->Executar("SELECT * FROM contador WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_contador/'.$data->imagem);
			}
			//grava banco
			$db = new mysql();
			$db->alterar("contador", array(
				"imagem"=>""
			), " codigo='$codigo' ");
			
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}


	// grupos


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$contador = new model_contador();
		
		$dados['grupos'] = $contador->lista_grupos();
		
		$this->view('contador.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('contador.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$contador = new model_contador();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('contador_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,			 
			'itens_por_linha'=>'4'
		));
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "contador";
		$titulo_pagina = "Contadores - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);


		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$contador = new model_contador();

		$codigo = $this->get('codigo');

		$dados['data'] = $contador->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('contador.grupos.alterar', $dados);
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
		$db->alterar("contador_grupos", array(
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
		$titulo_pagina = "Contadores - $titulo";
		$tipo = "contador";
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
		$contador = new model_contador();

		foreach ($contador->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('contador_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('contador', " grupo='".$value['codigo']."' ");
				
				$db = new mysql();
				$db->apagar('contador_ordem', " grupo='".$value['codigo']."' ");
				
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