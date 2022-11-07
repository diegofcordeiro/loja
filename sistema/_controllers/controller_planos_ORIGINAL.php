<?php

class planos extends controller {
	
	protected $_modulo_nome = "Planos";

	public function init(){
		$this->autenticacao();
		// $this->nivel_acesso(108);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$planos = new model_planos();
		$dados['grupos'] = $planos->lista_grupos();

		$grupo = $this->get('grupo');
		if(!$grupo){
			if(isset($dados['grupos'][0]['codigo'])){
				$grupo = $dados['grupos'][0]['codigo'];
			} else {
				$grupo = 0;
			}
		}

		$dados['grupo_selecionado'] = $grupo;
		$dados['lista'] = $planos->lista($grupo);

		$this->view('planos', $dados);
	}

	public function ordem(){
		
		$grupo = $this->post('grupo');
		$list = $_POST['list'];

		if($grupo AND $list){

			$output = array();
			parse_str($list, $output);
			$ordem = implode(',', $output['item']);

			$db = new mysql();
			$db->apagar("planos_ordem", " grupo='$grupo' ");

			$db = new mysql();
			$db->inserir("planos_ordem", array(
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
		
		$planos = new model_planos();
		$dados['grupos'] = $planos->lista_grupos();

		$this->view('planos.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');

		$this->valida($titulo);
		$this->valida($grupo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("planos", array(
			"codigo"=>"$codigo",
			"grupo"=>"$grupo",
			"titulo"=>"$titulo"
		));

		$ultid = $db->ultimo_id();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM planos_ordem WHERE grupo='$grupo' order by id desc limit 1");
		$data = $exec->fetch_object();

		if(isset($data->data)){
			$novaordem = $data->data.",".$ultid;
		} else {
			$novaordem = $ultid;
		}

		$db = new mysql();
		$db->inserir("planos_ordem", array(
			"grupo"=>$grupo,
			"data"=>$novaordem
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/dados/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";
		
		$codigo = $this->get('codigo');
		if(!$codigo){
			$this->msg('Item invalido');
			$this->volta(1);
			exit;
		}
		
		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM planos where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);

		// Instancia
		$planos = new model_planos();
		$dados['itens'] = $planos->itens($codigo);

		$this->view('planos.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$valor = $this->post('valor');
		$endereco = $this->post_htm('endereco');
		$tipo = $this->post('tipo');
			
		$this->valida($codigo);
		$this->valida($valor);
		$this->valida($titulo); 

		$valores = new model_valores();
		$valor_tratado = $valores->trata_valor_banco($valor);
		
		$db = new mysql();
		$db->alterar("planos", array(
			"titulo"=>$titulo,
			"valor"=>$valor_tratado,
			"endereco"=>$endereco,
			"tipo"=>$tipo
		), " codigo='$codigo' ");
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM planos ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == $data->codigo){ 			 
				
				$conexao = new mysql();
				$conexao->apagar("planos", " codigo='$data->codigo' ");
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial');		
	}

	public function item_novo(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$tipo = $this->post('tipo');

		$this->valida($titulo);
		$this->valida($codigo); 

		$db = new mysql();
		$db->inserir("planos_itens", array(
			"codigo"=>$codigo,
			"titulo"=>$titulo,
			"tipo"=>$tipo
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/itens/codigo/'.$codigo);
	}

	public function item_apagar(){

		$codigo = $this->get('codigo');
		$id = $this->get('id');
		
		$this->valida($id);
		$this->valida($codigo); 

		$db = new mysql();
		$db->apagar("planos_itens", " id='$id' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/itens/codigo/'.$codigo);
	}
	


	public function imagem_fundo(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$blocos = new model_blocos();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/imagens/";

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
				$db->alterar("planos", array(
					"img_fundo"=>"$nome_arquivo"
				), " codigo='$codigo' ");

				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem_fundo');

			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem_fundo");

			}

		}

	}

	public function apagar_imagem_fundo(){

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM planos WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->img_fundo){
				unlink('../arquivos/imagens/'.$data->img_fundo);
			}

			$db = new mysql();
			$db->alterar("planos", array(
				"img_fundo"=>""
			), " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem_fundo');
	}


	// grupos


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$planos = new model_planos();
		
		$dados['grupos'] = $planos->lista_grupos();
		
		$this->view('planos.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('planos.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);	
		
		// Instancia
		$planos = new model_planos();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('planos_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,
			'itens_por_linha'=>3
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "planos";
		$titulo_pagina = "Planos - $titulo";
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

		$planos = new model_planos();
		$dados['data'] = $planos->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('planos.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$descricao = $this->post_htm('descricao');
		$itens_por_linha = $this->post('itens_por_linha');
		$mostrar_titulo = $this->post('mostrar_titulo'); 
		$botao = $this->post('botao');

		$plano_titulo = $this->post('plano_titulo');
		$plano_itens = $this->post('plano_itens');
		$plano_valor = $this->post('plano_valor');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($itens_por_linha);
		
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
		$db->alterar("planos_grupos", array(
			'titulo'=>$titulo,
			'mostrar_titulo'=>$mostrar_titulo,
			'itens_por_linha'=>$itens_por_linha,
			'descricao'=>$descricao,
			'botao_codigo'=>$botao,
			'plano_titulo'=>$plano_titulo,
			'plano_itens'=>$plano_itens,
			'plano_valor'=>$plano_valor,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		
		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$tipo = "planos";
		$titulo_pagina = "Planos - $titulo";
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
		$planos = new model_planos();

		foreach ($planos->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('planos_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('planos', " grupo='".$value['codigo']."' ");
				
				$db = new mysql();
				$db->apagar('planos_ordem', " grupo='".$value['codigo']."' ");
				
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