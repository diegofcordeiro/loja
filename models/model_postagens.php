<?php

Class model_postagens extends model{

	public $numlinks = 10; //total de paginas mostradas na paginação
	public $busca = '-';
	public $categoria = 0;
	public $startitem = 0;
	public $startpage = 1;
	public $endpage = '';
	public $reven = 1;
	public $ordem = ''; // 'rand' para randomico ou em branco para data desc
	public $controller_name = "";
	public $id_var = '';

	public function lista($grupo){
		
		$retorno = array();
		
		// grupos
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM noticia_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;
		$retorno['categorias'] = $this->lista_categorias();;
		

		// marcados
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
		$retorno['botao'] = $layout->carrega_botao($data_grupo->botao_codigo, " aquivaiolink ", true);
		
    	//define variaveis
		$perpage = $data_grupo->itens_por_pagina;
		$numlinks = $this->numlinks;
		$busca = $this->busca;
		$categoria = $this->categoria;
		$startitem = $this->startitem;
		$startpage = $this->startpage;
		$endpage = $this->endpage;
		$reven = $this->reven; 
		$ordem = $this->ordem;
		$controller_name = $this->controller_name;
		$id_var = $this->id_var;

		$retorno['categoria_selecionada'] = $this->categoria;

		
		if($data_grupo->marcados == 1){

			//FILTROS 

			$query = "SELECT * FROM noticia INNER JOIN noticia_grupos_sel ON noticia.codigo=noticia_grupos_sel.noticia 
			WHERE noticia_grupos_sel.grupo='$grupo' ";
			
			if($categoria != 0){
				$query .= "AND noticia.categoria='$categoria' ";
			}
			if($data_grupo->categoria  != 0){
				$query .= "AND noticia.categoria='$data_grupo->categoria' ";
			}

		} else {
			
			//FILTROS
			$query = "SELECT * FROM noticia ";

			//se tiver busca ignora tudo e faz a busca
			if($busca != "-"){
				$query = "SELECT * FROM noticia WHERE titulo LIKE '%$busca%' OR previa LIKE '%$busca%' ";
			} else {
			//se selecionou a categoria tem prioridade sobre o destaque
				if($categoria != 0){
					$query = "SELECT * FROM noticia WHERE categoria='$categoria' ";
				}
				if($data_grupo->categoria  != 0){
					$query .= " AND categoria='$data_grupo->categoria' ";
				}
			}
			


		}


	//faz a busca no banco e retorno numero de itens para paginação
		$conexao = new mysql();
		$coisas_noticias = $conexao->Executar($query);
		if($coisas_noticias->num_rows) {
			$numitems = $coisas_noticias->num_rows;
		} else {
			$numitems = 0;
		}
		$retorno['numitems'] = $numitems;
		

		//calcula paginação
		if($numitems > 0) {
			$numpages = ceil($numitems / $perpage); 
			if($startitem + $perpage > $numitems) { $enditem = $numitems; } else { $enditem = $startitem + $perpage; }
			if(!$startpage) { $startpage = 1; }
			if(!$endpage) { 
				if($numpages > $numlinks) { $endpage = $numlinks; } else { $endpage = $numpages; }
			}
		} else {
			$numpages = 0;
		}

		$noticias = array();
		$mes = new model_data();

		//ordena e limita aos itens da pagina
		if($ordem == 'rand'){
			$query .= " ORDER BY RAND() LIMIT $startitem, $perpage";
		} else {
			$query .= " ORDER BY data desc LIMIT $startitem, $perpage";
		}
		
		$conexao = new mysql();
		$coisas_noticias = $conexao->Executar($query);
		$n = 0;
		while($data_noticias = $coisas_noticias->fetch_object()){

			//seta imagem como não existente
			$imagem = "";

			//confere se tem imagem ordenada
			$conexao = new mysql();
			$coisas_ordem = $conexao->Executar("SELECT * FROM noticia_imagem_ordem WHERE codigo='$data_noticias->codigo' ORDER BY id desc limit 1");
			$data_ordem = $coisas_ordem->fetch_object();
			
			//se tiver ordem segue o baile
			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$ii = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas_img = $conexao->Executar("SELECT imagem FROM noticia_imagem WHERE id='$value'");
					$data_img = $coisas_img->fetch_object();

					//pega primeira imagem da ordem e coloca na variavel
					if( ($ii == 0) AND (isset($data_img->imagem)) ){

						$imagem = PASTA_CLIENTE."img_postagens_g/".$data_noticias->codigo."/".$data_img->imagem;

						$ii++;
					}
				}
			}

			$noticias[$n]['imagem'] = $imagem;
			
			//verifica nome do categoria
			$conexao = new mysql();
			$coisas_noticias_cat = $conexao->Executar("SELECT titulo FROM noticia_categorias WHERE codigo='$data_noticias->categoria'");
			$data_noticias_cat = $coisas_noticias_cat->fetch_object();
			
			$noticias[$n]['categoria'] = $data_noticias_cat->titulo;
			$noticias[$n]['categoria_codigo'] = $data_noticias->categoria;

			//autor se tiver
			if($data_noticias->autor){

				$conexao = new mysql();
				$coisas_not_autor = $conexao->Executar("SELECT nome FROM noticia_autores WHERE codigo='$data_noticias->autor'");
				$data_not_autor = $coisas_not_autor->fetch_object();

				if($data_not_autor->nome){
					$noticias[$n]['autor'] = $data_not_autor->nome;
				} else {
					$noticias[$n]['autor'] = "";
				}

			} else {
				$noticias[$n]['autor'] = "";
			}

			//restante
			$noticias[$n]['id'] = $data_noticias->id;
			$noticias[$n]['codigo'] = $data_noticias->codigo;
			$noticias[$n]['titulo'] = $data_noticias->titulo;
			$noticias[$n]['previa'] = $data_noticias->previa;
			$noticias[$n]['conteudo'] = $data_noticias->conteudo; 
			$noticias[$n]['data'] = date('d', $data_noticias->data)." ".$mes->mes($data_noticias->data, 2)." ".date('Y', $data_noticias->data);
			$noticias[$n]['data_cod'] = $data_noticias->data;			
			$noticias[$n]['endereco'] = $data_noticias->amigavel;

			$n++;
		}
		$retorno['lista'] = $noticias;
		
		//lista paginação
		$paginacao = "<ul class='pagination'>";

		if($numpages > 1) { 
			if($startpage > 1) {

				$prevstartpage = $startpage - $numlinks;
				$prevstartitem = $prevstartpage - 1;
				$prevendpage = $startpage - 1;

				$link = DOMINIO.$controller_name."/inicial/categoria_".$id_var."/$categoria/busca_".$id_var."/$busca/";
				$link .= "startitem_".$id_var."/$prevstartitem/startpage_".$id_var."/$prevstartpage/endpage_".$id_var."/$prevendpage/reven_".$id_var."/$prevstartpage/#section-postagens-".$id_var;

			}
			
			for($n = $startpage; $n <= $endpage; $n++) {

				$nextstartitem = ($n - 1) * $perpage;

				if($n != $reven) {

					$link = DOMINIO.$controller_name."/inicial/categoria_".$id_var."/$categoria/busca_".$id_var."/$busca/";
					$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$startpage/endpage_".$id_var."/$endpage/reven_".$id_var."/$n/#section-postagens-".$id_var;
					$paginacao .= "<li><a href='$link' >&nbsp;$n&nbsp;</a></li>";

				} else {
					$paginacao .= "<li><a href='#section-postagens-".$id_var."' class='active' >&nbsp;$n&nbsp;</a></li>";
				}
			}

			if($endpage < $numpages) {

				$nextstartpage = $endpage + 1;

				if(($endpage + $numlinks) < $numpages) { 
					$nextendpage = $endpage + $numlinks; 
				} else {
					$nextendpage = $numpages;
				}

				$nextstartitem = ($n - 1) * $perpage;

				$link = DOMINIO.$controller_name."/inicial/categoria_".$id_var."/$categoria/busca_".$id_var."/$busca/";
				$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$nextstartpage/endpage_".$id_var."/$nextendpage/reven_".$id_var."/$nextstartpage/#section-postagens-".$id_var;

			}
		}
		$paginacao .= "</ul>";

		$retorno['paginacao'] = $paginacao;


		//retorna para a pagina a array com todos as informações
		return $retorno;
	}

	//trata nome para url
	public function trata_url_titulo($titulo){

		//remove acentos
		$titulo_tratado = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $titulo);

		//remove caracteres indesejados
		$titulo_tratado = str_replace(array("?", ",", ".", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$"), "", $titulo_tratado);
		//coloca ifen para separar palavras
		$titulo_tratado = str_replace(array(" ", "_", "+"), "-", $titulo_tratado);
		//certifica que não tem ifens repetidos
		$titulo_tratado = preg_replace('/(.)\1+/', '$1', $titulo_tratado);		 

		return $titulo_tratado;
	}


	public function lista_categorias(){

    	//lista categorias para lateral
		$categorias = array();
		$conexao = new mysql();
		$coisas_categorias = $conexao->Executar("SELECT * FROM noticia_categorias order by titulo asc");
		$n = 0;
		while($data_categorias = $coisas_categorias->fetch_object()){ 

			$categorias[$n]['codigo'] = $data_categorias->codigo;			 
			$categorias[$n]['titulo'] = $data_categorias->titulo; 

			$n++;
		}		

		//retorna para a pagina a array com todos as informações
		return $categorias;
	}

	public function titulo_categoria($codigo){

		$conexao = new mysql();
		$coisas_categorias = $conexao->Executar("SELECT titulo FROM noticia_categorias where codigo='$codigo' ");
		$data_categorias = $coisas_categorias->fetch_object();

		return $data_categorias->titulo;
	}

	public function carrega_postagem($id){
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM noticia where amigavel='$id' ");
		return $coisas->fetch_object();
		
	}

	public function autor_postagem($codigo){

		$conexao = new mysql();
		$coisas_not_autor = $conexao->Executar("SELECT * FROM noticia_autores WHERE codigo='".$codigo."' ");
		$data = $coisas_not_autor->fetch_object();

		return $data->nome;		
	}

	public function imagens($codigo){

		//pega imagens
		$imagens = array();
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM noticia_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$ii = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT id, imagem FROM noticia_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();

				if(isset($data_img->imagem)){

					//carrega legenda se tiver
					$conexao = new mysql();
					$coisas_leg = $conexao->Executar("SELECT legenda FROM noticia_imagem_legenda WHERE id_img='$data_img->id'");
					$data_leg = $coisas_leg->fetch_object();
					if(isset($data_leg->legenda)){
						$imagens[$ii]['legenda'] = $data_leg->legenda;
					} else {
						$imagens[$ii]['legenda'] = '';
					}
					
					$imagens[$ii]['id'] = $data_img->id;
					$imagens[$ii]['imagem'] = $data_img->imagem;
					$imagens[$ii]['imagem_g'] = PASTA_CLIENTE."img_postagens_g/".$codigo."/".$data_img->imagem;
					$imagens[$ii]['imagem_p'] = PASTA_CLIENTE."img_postagens_p/".$codigo."/".$data_img->imagem;
					
					$ii++;
				}

			}
		}
		return $imagens;
	}




}