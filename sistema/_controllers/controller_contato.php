<?php

class contato extends controller {
	
	protected $_modulo_nome = "Formulários";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(126);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$contato = new model_contato();
		$dados['grupos'] = $contato->lista_grupos();

		$grupo = $this->get('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}

		$dados['grupo_selecionado'] = $grupo;
		$dados['lista'] = $contato->lista($grupo);

		$this->view('contato', $dados);
	}

	public function ordem(){
		
		$grupo = $this->post('grupo');
		$list = $_POST['list'];

		if($grupo AND $list){

			$output = array();
			parse_str($list, $output);
			$ordem = implode(',', $output['item']);

			$db = new mysql();
			$db->apagar("contato_ordem", " grupo='$grupo' ");

			$db = new mysql();
			$db->inserir("contato_ordem", array(
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
		
		$contato = new model_contato();
		$dados['grupos'] = $contato->lista_grupos();

		$this->view('contato.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');
		$email = $this->post('email');
		
		$this->valida($titulo);
		$this->valida($grupo);
		$this->valida($email);
		
		$codigo = $this->gera_codigo();
		
		$db = new mysql();
		$db->inserir("contato", array(
			"codigo"=>"$codigo",
			"grupo"=>"$grupo",
			"titulo"=>"$titulo",
			"email"=>"$email"
		));

		$ultid = $db->ultimo_id();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM contato_ordem WHERE grupo='$grupo' order by id desc limit 1");
		$data = $exec->fetch_object();

		if(isset($data->data)){
			$novaordem = $data->data.",".$ultid;
		} else {
			$novaordem = $ultid;
		}

		$db = new mysql();
		$db->inserir("contato_ordem", array(
			"grupo"=>$grupo,
			"data"=>$novaordem
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
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
		$exec = $db->Executar("SELECT * FROM contato where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$this->view('contato.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$email = $this->post('email'); 
		
		$this->valida($codigo);
		$this->valida($titulo);
		
		$db = new mysql();
		$db->alterar("contato", array(
			"titulo"=>"$titulo",
			"email"=>"$email"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM contato ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){			 
				
				$conexao = new mysql();
				$conexao->apagar("contato", " codigo='$data->codigo' ");
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial');		
	}

	
	// grupos


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$contato = new model_contato();
		
		$dados['grupos'] = $contato->lista_grupos();
		
		$this->view('contato.grupos', $dados);
	}
	
	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";
		
		$this->view('contato.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);
		
		// Instancia
		$contato = new model_contato();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('contato_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,			 
			'tipo_envio'=>'todos'
		));
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "contato";
		$titulo_pagina = "Contato - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);


		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$contato = new model_contato();

		$codigo = $this->get('codigo');

		$dados['data'] = $contato->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('contato.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$tipo_envio = $this->post('tipo_envio');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$itens_por_linha = $this->post('itens_por_linha');
		$descricao = $this->post_htm('descricao'); 
		$botao = $this->post('botao');

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
		$db->alterar("contato_grupos", array(
			'titulo'=>$titulo,
			'mostrar_titulo'=>$mostrar_titulo,
			'tipo_envio'=>$tipo_envio,
			'descricao'=>$descricao,
			'botao_codigo'=>$botao,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		
		// layout
		
		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pagina = "Contato - $titulo";
		$tipo = "contato";
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
		$contato = new model_contato();

		foreach ($contato->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('contato_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('contato', " grupo='".$value['codigo']."' ");
				
				$db = new mysql();
				$db->apagar('contato_ordem', " grupo='".$value['codigo']."' ");
				
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