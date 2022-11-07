<?php

Class model_classificados extends model{

	public $numlinks = 10; //total de paginas mostradas na paginação
	public $busca = '-';
	public $categoria = 0; 
	public $cidade = 0;
	public $bairro = 0; 
	public $valor_min = 0;
	public $valor_max = 0;
	public $startitem = 0;
	public $startpage = 1;
	public $endpage = '';
	public $reven = 1;
	public $ordem = 0;
	public $controller_name = "";
	public $id_var = '';
	public $opcoes = array();

	public function lista($grupo){
		
		$valores = new model_valores();

		$retorno = array();
		
		// grupos
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM classificados_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;
		$retorno['categorias'] = $this->lista_categorias();
		$retorno['opcoes'] = $this->lista_opcoes();

		// lista imagens fundo
		$imagens_fundo = array();
		$imgf = 0;
		$conexao = new mysql(); 
		$exec = $conexao->Executar("SELECT * FROM classificados_grupos_imagens WHERE codigo='$grupo' ORDER by RAND() ");
		while($data_grupo_img = $exec->fetch_object()){
			$imagens_fundo[$imgf]['id'] = $data_grupo_img->id;
			$imagens_fundo[$imgf]['imagem'] = PASTA_CLIENTE.'img_classificados_grupos/'.$data_grupo_img->imagem;
			$imgf++;
		}
		$retorno['imagens_fundo'] = $imagens_fundo;


		// lista imagens fundo
		$categorias = array();
		$cat_n = 0;

		$time = time();

		$conexao = new mysql(); 
		$exec = $conexao->Executar("SELECT * FROM classificados_categorias WHERE ativo='1'  ");
		while($data_cat = $exec->fetch_object()){
			$categorias[$cat_n]['codigo'] = $data_cat->codigo;
			$categorias[$cat_n]['titulo'] = $data_cat->titulo;
			
			$cat_n++;
		}
		$retorno['categorias'] = $categorias;
		
		
		// lista imagens fundo
		$cidades = array();
		$cidades_n = 0;
		$cidade_base = "";

		$conexao = new mysql(); 
		$exec = $conexao->Executar("SELECT * FROM classificados_cidades ");
		while($data_cid = $exec->fetch_object()){
			$cidades[$cidades_n]['codigo'] = $data_cid->codigo;
			$cidades[$cidades_n]['cidade'] = $data_cid->cidade;
			$cidades[$cidades_n]['estado'] = $data_cid->estado;
			if($data_cid->principal == 1){
				$cidade_base = $data_cid->codigo;
			}			
			$cidades_n++;
		}
		$retorno['cidades'] = $cidades;
		$retorno['cidade_base'] = $cidade_base;


		// marcados
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);

    	//define variaveis
		$perpage = $data_grupo->itens_por_pagina;
		$numlinks = $this->numlinks;
		$busca = $this->busca;
		$categoria = $this->categoria;		 
		$cidade = $this->cidade;
		$bairro = $this->bairro; 
		$valor_min = $this->valor_min;
		$valor_max = $this->valor_max;
		$startitem = $this->startitem;
		$startpage = $this->startpage;
		$endpage = $this->endpage;
		$reven = $this->reven; 
		$ordem = $this->ordem;
		$controller_name = $this->controller_name;
		$id_var = $this->id_var;
		$opcoes = $this->opcoes;
 		
		if($cidade == 0){
			// $cidade = $cidade_base;
		}


		$retorno['categoria_selecionada'] = $categoria;
		$retorno['cidade_selecionada'] = $cidade;
		$retorno['bairro_selecionado'] = $bairro;
		$retorno['ordem_selecionado'] = $ordem;
		$retorno['opcoes_selecionadas'] = $opcoes;

		$retorno['valor_max'] = $valor_max;
		$retorno['valor_max_tratado'] = 0;
		$retorno['valor_max_tratado_busca'] = 0;

		$retorno['valor_min'] = $valor_min;
		$retorno['valor_min_tratado'] = 0;
		$retorno['valor_min_tratado_busca'] = 0;
		

		// tipo lista
		if( ($data_grupo->tipo == 1) OR ($data_grupo->tipo == 2) ){

			//se tiver busca ignora tudo e faz a busca
			if($busca != "-"){
				$query = "SELECT * FROM classificados WHERE ( status='1' OR anuncio_vencimento>='$time' ) AND (titulo LIKE '%$busca%' OR descricao LIKE '%$busca%' ) ";
			} else {

				$query = "SELECT * FROM classificados WHERE ( status='1' OR anuncio_vencimento>='$time' ) ";

				if(count($opcoes) != 0){

					$query = "SELECT DISTINCT classificados.* FROM classificados INNER JOIN classificados_opcoes_sel ON classificados.codigo=classificados_opcoes_sel.codigo WHERE ( classificados.status='1' OR classificados.anuncio_vencimento>='$time' ) ";

					$query .= " AND (";

					foreach ($opcoes as $key => $value) {
						
						$query .= " classificados_opcoes_sel.opcional='".$value."' OR ";

					}
					$query = substr($query, 0, strlen($query)-3);

					$query .= " ) ";

				}


				if($categoria != 0){
					$query .= " AND classificados.categoria_id='$categoria' ";
				}

				if($cidade != 0){
					$query .= " AND classificados.cidade_id='$cidade' ";
				}

				if($bairro != 0){
					$query .= " AND classificados.bairro_id='$bairro' ";
				}

				if($valor_min != 0){
					$query .= " AND classificados.valor>='$valor_min' ";
				}

				if($valor_max != 0){
					$query .= " AND classificados.valor<='$valor_max' ";
				}


			}

			//faz a busca no banco e retorno numero de itens para paginação
			$conexao = new mysql();
			$coisas_classificadoss = $conexao->Executar($query);
			if($coisas_classificadoss->num_rows) {
				$numitems = $coisas_classificadoss->num_rows;
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
						
			$classificadoss = array();
			$mes = new model_data();


		//ordena e limita aos itens da pagina


			if(!$ordem){
				$query .= " ORDER BY classificados.id desc LIMIT $startitem, $perpage";
				$ordem = 0;
			} else {
				if($ordem == 0){
					$query .= " ORDER BY classificados.id desc LIMIT $startitem, $perpage"; 
				}
				if($ordem == 1){
					$query .= " ORDER BY classificados.id asc LIMIT $startitem, $perpage"; 
				}
				if($ordem == 2){
					$query .= " ORDER BY classificados.valor desc LIMIT $startitem, $perpage"; 
				}
				if($ordem == 3){
					$query .= " ORDER BY classificados.valor asc LIMIT $startitem, $perpage"; 
				}
			}


			$retorno['ordem'] = $ordem;


			$conexao = new mysql();
			$coisas_classificadoss = $conexao->Executar($query);
			$n = 0;
			while($data_classificadoss = $coisas_classificadoss->fetch_object()){

			//seta imagem como não existente
				$imagem = "";

			//confere se tem imagem ordenada
				$conexao = new mysql();
				$coisas_ordem = $conexao->Executar("SELECT * FROM classificados_imagem_ordem WHERE codigo='$data_classificadoss->codigo' ORDER BY id desc limit 1");
				$data_ordem = $coisas_ordem->fetch_object();

			//se tiver ordem segue o baile
				if(isset($data_ordem->data)){

					$order = explode(',', $data_ordem->data);

					$ii = 0;
					foreach($order as $key => $value){

						$conexao = new mysql();
						$coisas_img = $conexao->Executar("SELECT imagem FROM classificados_imagem WHERE id='$value'");
						$data_img = $coisas_img->fetch_object();

					//pega primeira imagem da ordem e coloca na variavel
						if( ($ii == 0) AND (isset($data_img->imagem)) ){

							$imagem = PASTA_CLIENTE."img_classificados_g/".$data_classificadoss->codigo."/".$data_img->imagem;

							$ii++;
						}
					}
				}

				$classificadoss[$n]['imagem'] = $imagem;

			//verifica nome do categoria
				$conexao = new mysql();
				$coisas_classificadoss_cat = $conexao->Executar("SELECT titulo FROM classificados_categorias WHERE codigo='$data_classificadoss->categoria_id'");
				$data_classificadoss_cat = $coisas_classificadoss_cat->fetch_object();

				$classificadoss[$n]['categoria_codigo'] = $data_classificadoss->categoria_id;
				$classificadoss[$n]['categoria_titulo'] = $data_classificadoss->categoria_titulo;

				$classificadoss[$n]['valor'] = $valores->trata_valor($data_classificadoss->valor);			 

				$classificadoss[$n]['id'] = $data_classificadoss->id;
				$classificadoss[$n]['codigo'] = $data_classificadoss->codigo;
				$classificadoss[$n]['titulo'] = $data_classificadoss->titulo; 

				$classificadoss[$n]['cidade'] = $data_classificadoss->cidade; 
				$classificadoss[$n]['bairro'] = $data_classificadoss->bairro;
				$classificadoss[$n]['uf'] = $data_classificadoss->uf;

				$n++;
			}
			$retorno['lista'] = $classificadoss;

			$complemento = "";
			foreach ($opcoes as $key_op2 => $value_op2) {
				$complemento .= "cla_op_".$value_op2."/1/";
			}


		//lista paginação
			$paginacao = "<ul class='pagination'>";

			if($numpages > 1) { 
				if($startpage > 1) {

					$prevstartpage = $startpage - $numlinks;
					$prevstartitem = $prevstartpage - 1;
					$prevendpage = $startpage - 1;


					$link = DOMINIO.$controller_name.'/inicial/cla_cat/'.$categoria.'/cla_cidade/'.$cidade.'/cla_bairro/'.$bairro.'/cla_val_max/'.$valor_max.'/cla_val_min/'.$valor_min.'/cla_ordem/'.$ordem.'/cla_ref/'.$busca.'/'.$complemento;

					$link .= "startitem_".$id_var."/$prevstartitem/startpage_".$id_var."/$prevstartpage/endpage_".$id_var."/$prevendpage/reven_".$id_var."/$prevstartpage/#section-classificados-".$id_var;

				}

				for($n = $startpage; $n <= $endpage; $n++) {

					$nextstartitem = ($n - 1) * $perpage;

					if($n != $reven) {

						$link = DOMINIO.$controller_name.'/inicial/cla_cat/'.$categoria.'/cla_cidade/'.$cidade.'/cla_bairro/'.$bairro.'/cla_val_max/'.$valor_max.'/cla_val_min/'.$valor_min.'/cla_ordem/'.$ordem.'/cla_ref/'.$busca.'/'.$complemento;

						$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$startpage/endpage_".$id_var."/$endpage/reven_".$id_var."/$n/#section-classificados-".$id_var;
						$paginacao .= "<li><a href='$link' >&nbsp;$n&nbsp;</a></li>";

					} else {
						$paginacao .= "<li><a href='#section-classificados-".$id_var."' class='active' >&nbsp;$n&nbsp;</a></li>";
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

					$link = DOMINIO.$controller_name.'/inicial/cla_cat/'.$categoria.'/cla_cidade/'.$cidade.'/cla_bairro/'.$bairro.'/cla_val_max/'.$valor_max.'/cla_val_min/'.$valor_min.'/cla_ordem/'.$ordem.'/cla_ref/'.$busca.'/'.$complemento;

					$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$nextstartpage/endpage_".$id_var."/$nextendpage/reven_".$id_var."/$nextstartpage/#section-classificados-".$id_var;

				}
			}
			$paginacao .= "</ul>";

			$retorno['paginacao'] = $paginacao;

		}

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
		$coisas_categorias = $conexao->Executar("SELECT * FROM classificados_categorias order by titulo asc");
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
		$coisas_categorias = $conexao->Executar("SELECT titulo FROM classificados_categorias where codigo='$codigo' ");
		$data_categorias = $coisas_categorias->fetch_object();

		return $data_categorias->titulo;
	}	 

	public function imagens($codigo){

		//pega imagens
		$imagens = array();
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM classificados_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$ii = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT id, imagem FROM classificados_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();

				if(isset($data_img->imagem)){

					$imagens[$ii]['id'] = $data_img->id;
					$imagens[$ii]['imagem'] = $data_img->imagem;
					$imagens[$ii]['imagem_g'] = PASTA_CLIENTE."img_classificados_g/".$codigo."/".$data_img->imagem;
					$imagens[$ii]['imagem_p'] = PASTA_CLIENTE."img_classificados_p/".$codigo."/".$data_img->imagem;

					$ii++;
				}

			}
		}
		return $imagens;
	}


	public function similares($codigo, $categoria_id){

		$valores = new model_valores();
		$time = time();

		$classificadoss = array();
		$n = 0;
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados WHERE ( status='1' OR anuncio_vencimento>='$time' ) AND categoria_id='$categoria_id' AND codigo!='$codigo' order by codigo desc limit 9");
		
		while($data_classificadoss = $exec->fetch_object()) {
			
			$imagem = "";

			//confere se tem imagem ordenada
			$conexao = new mysql();
			$coisas_ordem = $conexao->Executar("SELECT * FROM classificados_imagem_ordem WHERE codigo='$data_classificadoss->codigo' ORDER BY id desc limit 1");
			$data_ordem = $coisas_ordem->fetch_object();
			
			//se tiver ordem segue o baile
			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$ii = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas_img = $conexao->Executar("SELECT imagem FROM classificados_imagem WHERE id='$value'");
					$data_img = $coisas_img->fetch_object();

					//pega primeira imagem da ordem e coloca na variavel
					if( ($ii == 0) AND (isset($data_img->imagem)) ){

						$imagem = PASTA_CLIENTE."img_classificados_g/".$data_classificadoss->codigo."/".$data_img->imagem;

						$ii++;
					}
				}
			}

			$classificadoss[$n]['imagem'] = $imagem;

			//verifica nome do categoria
			$conexao = new mysql();
			$coisas_classificadoss_cat = $conexao->Executar("SELECT titulo FROM classificados_categorias WHERE codigo='$data_classificadoss->categoria_id'");
			$data_classificadoss_cat = $coisas_classificadoss_cat->fetch_object();

			$classificadoss[$n]['categoria_codigo'] = $data_classificadoss->categoria_id;
			$classificadoss[$n]['categoria_titulo'] = $data_classificadoss->categoria_titulo;

			$classificadoss[$n]['valor'] = $valores->trata_valor($data_classificadoss->valor);
			$classificadoss[$n]['ref'] = $data_classificadoss->cod_interno;


			$classificadoss[$n]['id'] = $data_classificadoss->id;
			$classificadoss[$n]['codigo'] = $data_classificadoss->codigo;
			$classificadoss[$n]['titulo'] = $data_classificadoss->titulo; 

			$classificadoss[$n]['cidade'] = $data_classificadoss->cidade; 
			$classificadoss[$n]['bairro'] = $data_classificadoss->bairro;
			$classificadoss[$n]['uf'] = $data_classificadoss->uf;
			
			$n++;
		}
		
		return $classificadoss;
	}
	
	protected function limita_texto($var, $limite){
		if (strlen($var) > $limite)	{
			$var = substr($var, 0, $limite);
			$var = trim($var) . "...";
		}		
		return $var;
	}

	public function opcoes($codigo = null){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_opcoes order by titulo asc");
		while($data = $coisas->fetch_object()){
			$conexao = new mysql();
			$coisas2 = $conexao->Executar("SELECT * FROM classificados_opcoes_sel WHERE codigo='$codigo' AND opcional='$data->codigo' ");
			if($coisas2->num_rows != 0){

				$lista[$n]['id'] = $data->id;
				$lista[$n]['codigo'] = $data->codigo;
				$lista[$n]['titulo'] = $data->titulo;
				$n++;
			}
		}

		return $lista;
	}

	public function tipos(){
		
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_tipos order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			
			$i++;
		}
		
		return $lista;
	}

	public function lista_cidades(){
		
		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_cidades order by cidade asc"); 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['estado'] = $data->estado;
			
			if($data->principal == 1){
				$lista[$i]['principal'] = 'Sim';
			} else {
				$lista[$i]['principal'] = '';
			}
			
			$i++;
		}

		return $lista;
	}

	public function ordem_imagens($codigo){
		
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM classificados_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		
		if(isset($data_ordem->data)){
			return $data_ordem->data; 
		} else {
			return false;
		}
	}


	public function lista_anuncios($cadastro){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados WHERE cadastro='$cadastro' order by id desc");
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['vencimento'] = $data->anuncio_vencimento;
			
			$n++;

		}

		return $lista;
	}

	public function lista_opcoes(){

		$lista = array();
		$n = 0;

		$marcadores = $this->lista_opcoes_marcadores();

		foreach ($marcadores as $key => $value) {

			$lista[$n]['id'] = $value['id'];
			$lista[$n]['marc_codigo'] = $value['codigo'];
			$lista[$n]['marc_titulo'] = $value['titulo'];

			$sublista = array();
			$n_sub = 0;

			$conexao = new mysql();		 
			$coisas = $conexao->Executar("SELECT * FROM classificados_opcoes WHERE marcador='".$value['codigo']."' order by titulo asc");
			while($data = $coisas->fetch_object()){

				$sublista[$n_sub]['id'] = $data->id;
				$sublista[$n_sub]['codigo'] = $data->codigo;
				$sublista[$n_sub]['titulo'] = $data->titulo;				 

				$n_sub++;
			}

			$lista[$n]['opcoes'] = $sublista;
			$n++;
		}

		return $lista;
	}

	public function lista_opcoes_marcadores(){

		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_opcoes_marcadores order by titulo asc");
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;			 
			
			$n++;
		}
		
		return $lista;
	}

	public function lista_videos($codigo){

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_videos WHERE codigo='$codigo' order by titulo asc"); 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo; 
			$lista[$i]['incorporacao'] = $data->incorporacao; 

			$i++;
		}
		
		return $lista;
	}

	public function favoritos($codigo){
		
		$valores = new model_valores();

		$classificadoss = array();
		$n = 0;
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados INNER JOIN classificados_favoritos ON classificados.codigo=classificados_favoritos.codigo 
			WHERE  classificados.status='1' AND classificados_favoritos.sessao='$codigo' ");
		
		while($data_classificadoss = $exec->fetch_object()) {
			
			$imagem = "";

			//confere se tem imagem ordenada
			$conexao = new mysql();
			$coisas_ordem = $conexao->Executar("SELECT * FROM classificados_imagem_ordem WHERE codigo='$data_classificadoss->codigo' ORDER BY id desc limit 1");
			$data_ordem = $coisas_ordem->fetch_object();
			
			//se tiver ordem segue o baile
			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$ii = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas_img = $conexao->Executar("SELECT imagem FROM classificados_imagem WHERE id='$value'");
					$data_img = $coisas_img->fetch_object();

					//pega primeira imagem da ordem e coloca na variavel
					if( ($ii == 0) AND (isset($data_img->imagem)) ){

						$imagem = PASTA_CLIENTE."img_classificados_g/".$data_classificadoss->codigo."/".$data_img->imagem;

						$ii++;
					}
				}
			}

			$classificadoss[$n]['imagem'] = $imagem;

			//verifica nome do categoria
			$conexao = new mysql();
			$coisas_classificadoss_cat = $conexao->Executar("SELECT titulo FROM classificados_categorias WHERE codigo='$data_classificadoss->categoria_id'");
			$data_classificadoss_cat = $coisas_classificadoss_cat->fetch_object();

			$classificadoss[$n]['categoria_codigo'] = $data_classificadoss->categoria_id;
			$classificadoss[$n]['categoria_titulo'] = $data_classificadoss->categoria_titulo;

			$classificadoss[$n]['valor'] = $valores->trata_valor($data_classificadoss->valor);
			$classificadoss[$n]['ref'] = $data_classificadoss->cod_interno;

			$classificadoss[$n]['id'] = $data_classificadoss->id;
			$classificadoss[$n]['codigo'] = $data_classificadoss->codigo;
			$classificadoss[$n]['titulo'] = $data_classificadoss->titulo; 

			$classificadoss[$n]['cidade'] = $data_classificadoss->cidade; 
			$classificadoss[$n]['bairro'] = $data_classificadoss->bairro;
			$classificadoss[$n]['uf'] = $data_classificadoss->uf;
			
			$n++;
		}
		
		return $classificadoss;
	}

}