<?php

class fotos extends controller {
	
	protected $_modulo_nome = "Galeria de Fotos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(83);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$categoria = $this->get('categoria');
		$dados['categoria'] = $categoria;
		
		$fotos = new model_fotos();		
		$dados['lista_categorias'] = $fotos->lista_categorias($categoria);
		
		//echo "<pre>"; print_r($dados['lista_categorias']); echo "</pre>"; exit;
		
		if(!$categoria){
			if(isset($dados['lista_categorias'][0]['codigo'])){
				$categoria = $dados['lista_categorias'][0]['codigo'];
			} else {
				$categoria = false;
			}
		}
		
		$dados['lista'] = $fotos->lista($categoria);
		
		$this->view('fotos', $dados);
	}

	public function ordem(){

		$list = $_POST['list'];
		$categoria = $this->post('categoria');

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$db->inserir("fotos_ordem", array(
			"categoria"=>"$categoria",
			"data"=>"$ordem"
		));

	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$categoria = $this->get('categoria');
		$dados['categoria'] = $categoria;

 		//categorias
		$categorias = new model_fotos();
		$dados['lista_categorias'] = $categorias->lista_categorias($categoria);
		
		$this->view('fotos.novo', $dados);
	}

	public function novo_grv(){
		
		$categoria = $this->post('categoria');
		$titulo = $this->post('titulo');
		$previa = $this->post_htm('previa');
		$conteudo = $this->post_htm('conteudo');
		
		$this->valida($titulo);
		$this->valida($categoria);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("fotos", array(
			"codigo"=>"$codigo",
			"categoria"=>"$categoria",
			"titulo"=>"$titulo",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo"
		));

		$ultid = $db->ultimo_id();

	 	//ordem
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_ordem where categoria='$categoria' order by id desc limit 1");
		$data = $exec->fetch_object();

		if(isset($data->data)){
			$novaordem = $data->data.",".$ultid;
		} else {
			$novaordem = $ultid;
		}

		$db = new mysql();
		$db->inserir("fotos_ordem", array(
			"categoria"=>"$categoria",
			"data"=>"$novaordem"
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
		$exec = $db->Executar("SELECT * FROM fotos where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
 		//imagens
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM fotos_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		$n = 0;
		$imagens = array();
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data); 

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM fotos_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();                                

				if(isset($data_img->imagem)){

					$conexao = new mysql();
					$coisas_leg = $conexao->Executar("SELECT * FROM fotos_imagem_legenda WHERE id_img='$value' ");
					$data_leg = $coisas_leg->fetch_object();

					if(isset($data_leg->legenda)){
						$imagens[$n]['legenda'] = $data_leg->legenda;
					} else {
						$imagens[$n]['legenda'] = "";
					}

					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE.'img_fotos_p/'.$codigo.'/'.$data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE.'img_fotos_g/'.$codigo.'/'.$data_img->imagem;

					$n++;
				}
			}
		}
		$dados['imagens'] = $imagens;       

		$this->view('fotos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$previa = $this->post_htm('previa'); 
		$conteudo = $this->post_htm('conteudo'); 
		
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("fotos", array(
			"titulo"=>"$titulo",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_imagem(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM fotos_imagem where id='$id' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_fotos_g/'.$codigo.'/'.$data->imagem);
				unlink('../arquivos/img_fotos_p/'.$codigo.'/'.$data->imagem);
			}

			$conexao = new mysql();
			$conexao->apagar("fotos_imagem", " id='$id' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function ordenar_imagem(){
		
		$codigo = $this->post('codigo');
		$list = $_POST['list'];
		
		$this->valida($codigo);
		$this->valida($list);

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$db->inserir("fotos_imagem_ordem", array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));

	}

	public function legenda(){
		
		$dados['_base'] = $this->base();

		$id = $this->get('id');
		$codigo = $this->get('codigo');

		$dados['codigo'] = $codigo;
		$dados['id'] = $id;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$dados['legenda'] = $data->legenda;
		} else {
			$dados['legenda'] = '';
		}

		$this->view('fotos.legenda', $dados);
	}

	public function legenda_grv(){
		
		$id = $this->post('id');
		$legenda = $this->post('legenda');
		$codigo = $this->post('codigo');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$db = new mysql();
			$db->alterar("fotos_imagem_legenda", array(
				"legenda"=>"$legenda"
			), " id='$data->id' ");
		} else {
			$db = new mysql();
			$db->inserir("fotos_imagem_legenda", array(
				"id_img"=>"$id",
				"legenda"=>"$legenda"
			));
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM fotos ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){

				$db = new mysql();
				$exec_img = $db->executar("SELECT * FROM fotos_imagem where codigo='$data->codigo' ");
				while($data_img = $exec_img->fetch_object()){

					if($data_img->imagem){
						unlink('../arquivos/img_fotos_g/'.$data->codigo.'/'.$data_img->imagem);
						unlink('../arquivos/img_fotos_p/'.$data->codigo.'/'.$data_img->imagem);
					}
					
				}
				
				$categoria = $data->categoria;
				
				$conexao = new mysql();
				$conexao->apagar("fotos_imagem", " codigo='$data->codigo' ");

				$conexao = new mysql();
				$conexao->apagar("fotos", " codigo='$data->codigo' ");
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial/categoria/'.$categoria);
		
	}

	public function categorias(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";
		
		$fotos = new model_fotos();
		$dados['lista'] = $fotos->lista_categorias(); 

		$this->view('fotos.categorias', $dados);
	}

	public function nova_categoria(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova categoria";

		$fotos = new model_fotos();		
		$dados['grupos'] = $fotos->lista_grupos();

		$this->view('fotos.categorias.nova', $dados);
	}

	public function nova_categoria_grv(){
		
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');

		$this->valida($grupo);
		$this->valida($titulo);

		$codigo = $this->gera_codigo();
		
		$db = new mysql();
		$db->inserir("fotos_categorias", array(
			"codigo"=>$codigo,
			"titulo"=>$titulo,
			"grupo"=>$grupo
		));
		
		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}

	public function alterar_categoria(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar categoria";

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$codigo = $this->get('codigo');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_categorias WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/categorias');
		}

		$fotos = new model_fotos();		
		$dados['grupos'] = $fotos->lista_grupos();

		$this->view('fotos.categorias.alterar', $dados);
		
	}	

	public function alterar_categoria_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$grupo = $this->post('grupo');

		$this->valida($grupo);
		$this->valida($codigo);
		$this->valida($titulo);
		
		$db = new mysql();
		$db->alterar("fotos_categorias", array(
			"titulo"=>"$titulo",
			"grupo"=>"$grupo"
		), " codigo='$codigo' ");
		
		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	} 

	public function apagar_categorias(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM fotos_categorias ");
		while($data = $exec->fetch_object()){			
			if($this->post('apagar_'.$data->id) == 1){			 
				
				$conexao = new mysql();
				$conexao->apagar("fotos_categorias", " id='$data->id' ");
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/categorias');
	}
	
	public function upload(){
		
		//carrega normal
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');
		$dados['codigo'] = $codigo;

		$this->view('enviar_imagens', $dados);
	}
	

	public function imagem_redimencionada(){

		$codigo = $this->post('codigo');
		
		//pasta onde vai ser salvo os arquivos
		$pasta = "fotos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";

		//confere e cria pasta se necessario
		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}
		
		//carrega model de gestao de imagens
		$img = new model_arquivos_imagens();
		
		// Recuperando imagem em base64
		// Exemplo: data:image/png;base64,AAAFBfj42Pj4
		$imagem = $this->post_htm('imagem');
		$nome_original = $this->post('nomeimagem');
		
		$nome_foto  = $img->trata_nome($nome_original);
		$extensao = $img->extensao($nome_original);
		
		// Separando tipo dos dados da imagem
		// $tipo: data:image/png
		// $dados: base64,AAAFBfj42Pj4
		list($tipo, $dados) = explode(';', $imagem);
		
		// Isolando apenas o tipo da imagem
		// $tipo: image/png
		list(, $tipo) = explode(':', $tipo);
		
		// Isolando apenas os dados da imagem
		// $dados: AAAFBfj42Pj4
		list(, $dados) = explode(',', $dados);

		// Convertendo base64 para imagem
		$dados = base64_decode($dados);

		// Gerando nome aleatório para a imagem
		$nome = md5(uniqid(time()));

		// Salvando imagem em disco
		if(file_put_contents($diretorio_g.$nome_foto, $dados)) {			

			//confere e se jpg reduz a miniatura
			if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

				copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

				// foto grande
				$largura_g = 1200;
				$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);

				// foto minuatura
				$largura_p = 300;
				$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
				
				//redimenciona
				$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);
				$img->jpg($diretorio_p.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto);

			} else {

				//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
				copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

			}


				//definições de mascara
			$fotos = new model_fotos();
			$cod_mascara = $fotos->carrega_mascara();
			if($cod_mascara){
				$mascara = new model_mascara();
				$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
			}


				//grava banco
			$db = new mysql();
			$db->inserir("fotos_imagem", array(
				"codigo"=>"$codigo",
				"imagem"=>"$nome_foto"
			));	
			$ultid = $db->ultimo_id();

				//ordem
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM fotos_imagem_ordem where codigo='$codigo' order by id desc limit 1");
			$data = $exec->fetch_object();

			if(isset($data->data)){
				$novaordem = $data->data.",".$ultid;
			} else {
				$novaordem = $ultid;
			}

			$db = new mysql();
			$db->inserir("fotos_imagem_ordem", array(
				"codigo"=>"$codigo",
				"data"=>"$novaordem"
			));

		}

	}

	public function imagem_manual(){

		$arquivo = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$codigo = $this->get('codigo');		

		$nome_original = $_FILES['arquivo']['name'];

		//definições de pasta
		$pasta = "fotos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";
		
		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}
		
		$img = new model_arquivos_imagens();

		if($tmp_name) {

			$nome_foto  = $img->trata_nome($nome_original);
			$extensao = $img->extensao($nome_original);
			
			if(copy($tmp_name, $diretorio_g.$nome_foto)){
				
				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					
					// foto grande
					$largura_g = 1200;
					$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);
					$img->jpg($diretorio_p.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto);
					
				} else {
					
					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					
				} 
				

				//definições de mascara
				$fotos = new model_fotos();
				$cod_mascara = $fotos->carrega_mascara();
				if($cod_mascara){
					$mascara = new model_mascara();
					$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
				}


				//grava banco
				$db = new mysql();
				$db->inserir("fotos_imagem", array(
					"codigo"=>"$codigo",
					"imagem"=>"$nome_foto"
				));
				$ultid = $db->ultimo_id();
				
				//ordem
				$db = new mysql();
				$exec = $db->executar("SELECT * FROM fotos_imagem_ordem where codigo='$codigo' order by id desc limit 1");
				$data = $exec->fetch_object();
				
				if(isset($data->data)){
					$novaordem = $data->data.",".$ultid;
				} else {
					$novaordem = $ultid;
				}
				
				$db = new mysql();
				$db->inserir("fotos_imagem_ordem", array(
					"codigo"=>"$codigo",
					"data"=>"$novaordem"
				));

			} else {
				$this->msg('Erro ao gravar imagem!');				
			}
			
			$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
		}
		
	}


	// mascara Marca dgua

	public function mascara(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Marca d'água"; 		 

		$mascaras = new model_mascara();
		$fotos = new model_fotos();

		$mascara = $fotos->carrega_mascara();
		$dados['lista'] = $mascaras->lista($mascara);
		
		$this->view('fotos.mascara', $dados);
	}	

	public function mascara_grv(){
		
		$codigo = $this->post('codigo');
		
		$fotos = new model_fotos();
		$fotos->altera_mascara($codigo);

		$this->irpara(DOMINIO.$this->_controller.'/mascara');
	}



	// GRUPOS PAGINAS

	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$fotos = new model_fotos();
		
		$dados['grupos'] = $fotos->lista_grupos();
		
		$this->view('fotos.grupos', $dados);
	}

	public function grupos_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('fotos.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 
		$formato = $this->post('formato');
		$ordem = $this->post('ordem');

		$this->valida($titulo);
		$this->valida($formato);

		// Instancia
		$fotos = new model_fotos();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('fotos_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,
			'formato'=>$formato,
			'ordem'=>$ordem
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "fotos";
		$titulo_pagina = "Galeria de Fotos - $titulo";
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

		$fotos = new model_fotos();
		$dados['data'] = $fotos->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('fotos.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$mostrar_categorias = $this->post('mostrar_categorias');
		$formato = $this->post('formato');
		$ordem = $this->post('ordem');
		$itens_por_linha = $this->post('itens_por_linha');
		$max_itens = $this->post('max_itens');
		$tipo_menu = $this->post('tipo_menu');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($formato);
		
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
		$db->alterar("fotos_grupos", array(
			'titulo'=>$titulo,
			'formato'=>$formato,
			'ordem'=>$ordem,
			'mostrar_titulo'=>$mostrar_titulo,
			'mostrar_categorias'=>$mostrar_categorias,
			'itens_por_linha'=>$itens_por_linha,
			'max_itens'=>$max_itens,
			'tipo_menu'=>$tipo_menu,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$tipo = "fotos";
		$titulo_pagina = "Galeria de Fotos - $titulo";
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
		$fotos = new model_fotos();

		foreach ($fotos->lista_grupos() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == $value['codigo']){
				
				$db = new mysql();
				$db->apagar('fotos_grupos', " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar('fotos', " grupo='".$value['codigo']."' ");
				
				$db = new mysql();
				$db->apagar('fotos_ordem', " grupo='".$value['codigo']."' ");
				
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