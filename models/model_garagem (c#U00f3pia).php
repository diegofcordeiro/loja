<?php

Class model_garagem extends model{

	public $numlinks = 10; //total de paginas mostradas na paginação
	public $busca = '';
	public $tipo = '';
	public $categoria = '';
	public $marca = '';
	public $modelo = '';
	public $combustivel = '';
	public $transmissao = '';
	public $cor = '';
	public $motor = '';
	public $valor_min = 0;
	public $valor_max = 0;
	public $ano_fab = '';
	public $ano_mod = '';
	public $startitem = 0;
	public $startpage = 1;
	public $endpage = '';
	public $reven = 1;
	public $ordem = 0;
	public $controller_name = "";
	public $id_var = '';

	public function lista($grupo){
		
		$valores = new model_valores();

		$retorno = array();
		
		// grupos
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM garagem_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;


		// lista imagens fundo
		$imagens_fundo = array();
		$imgf = 0;
		$conexao = new mysql(); 
		$exec = $conexao->Executar("SELECT * FROM garagem_grupos_imagens WHERE codigo='$grupo' ORDER by RAND() ");
		while($data_grupo_img = $exec->fetch_object()){
			$imagens_fundo[$imgf]['id'] = $data_grupo_img->id;
			$imagens_fundo[$imgf]['imagem'] = PASTA_CLIENTE.'img_garagem_grupos/'.$data_grupo_img->imagem;
			$imgf++;
		}
		$retorno['imagens_fundo'] = $imagens_fundo;


		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);

    	//define variaveis
		$perpage = $data_grupo->itens_por_pagina;
		$numlinks = $this->numlinks;
		$busca = $this->busca;
		
		$tipo = $this->tipo;
		$categoria = $this->categoria;
		$marca = $this->marca;
		$modelo = $this->modelo;
		$combustivel = $this->combustivel;
		$transmissao = $this->transmissao;
		$cor = $this->cor;
		$motor = $this->motor;
		
		$ano_fab = $this->ano_fab;
		$ano_mod = $this->ano_mod;

		$valor_min = $this->valor_min;
		$valor_max = $this->valor_max;


		$startitem = $this->startitem;
		$startpage = $this->startpage;
		$endpage = $this->endpage;
		$reven = $this->reven; 
		$ordem = $this->ordem;
		$controller_name = $this->controller_name;
		$id_var = $this->id_var;
		
		$retorno['tipo_selecionada'] = $tipo;
		$retorno['categoria_selecionada'] = $categoria;
		$retorno['marca_selecionada'] = $marca;
		$retorno['modelo_selecionada'] = $modelo;
		$retorno['combustivel_selecionada'] = $combustivel;
		$retorno['transmissao_selecionada'] = $transmissao;
		$retorno['cor_selecionada'] = $cor;
		$retorno['motor_selecionada'] = $motor;

		$retorno['ordem_selecionado'] = $ordem;

		$retorno['valor_max'] = $valor_max;
		$retorno['valor_max_tratado'] = 0;
		$retorno['valor_max_tratado_busca'] = 0;

		$retorno['valor_min'] = $valor_min;
		$retorno['valor_min_tratado'] = 0;
		$retorno['valor_min_tratado_busca'] = 0;

		$retorno['ano_fab_selecionada'] = $ano_fab;
		$retorno['ano_mod_selecionada'] = $ano_mod;

		// se for lista carregar filtros
		if( ($data_grupo->tipo == 1) OR ($data_grupo->tipo == 4) ){
			
			$retorno['categorias'] = $this->lista_categorias(); 
			$retorno['marcas'] = $this->lista_marcas();
			$retorno['modelos'] = $this->lista_modelos();
			$retorno['combustiveis'] = $this->lista_combustiveis();
			$retorno['cambios'] = $this->lista_cambios();
			$retorno['coresveiculo'] = $this->lista_corveiculo();
			$retorno['motores'] = $this->lista_motores();

		}

		if( ($data_grupo->tipo == 2) OR ($data_grupo->tipo == 3) ){
			
			$tipo = $data_grupo->novo_usado;

		}

		//FILTROS		 

		//se tiver busca ignora tudo e faz a busca
		if($busca){
			$query = "SELECT * FROM garagem WHERE status='1' AND (ref LIKE '%$busca%' OR titulo LIKE '%$busca%') ";
		} else {

			$query = "SELECT * FROM garagem WHERE status='1' ";

			if($tipo){
				$query .= " AND tipo='$tipo' ";
			}

			if($categoria){
				$query .= " AND categoria_cod='$categoria' ";
			}

			if($marca){
				$query .= " AND marca_cod='$marca' ";
			}

			if($modelo){
				$query .= " AND modelo_cod='$modelo' ";
			}
			
			if($combustivel){
				$query .= " AND combustivel_cod='$combustivel' ";
			}

			if($transmissao){
				$query .= " AND transmissao_cod='$transmissao' ";
			}

			if($cor){
				$query .= " AND cor_cod='$cor' ";
			}

			if($motor){
				$query .= " AND motor_cod='$motor' ";
			}

			if($valor_min != 0){
				$query .= " AND valor>='$valor_min' ";
			}

			if($valor_max != 0){

				if($valor_max < 225000){
					$query .= " AND valor<='$valor_max' ";
				}

			}

			if($ano_fab){
				$query .= " AND ano_fab='$ano_fab' ";
			}

			if($ano_mod){
				$query .= " AND ano_modelo='$ano_mod' ";
			}

		}

		//faz a busca no banco e retorno numero de itens para paginação
		$conexao = new mysql();
		$coisas_garagems = $conexao->Executar($query);
		if($coisas_garagems->num_rows) {
			$numitems = $coisas_garagems->num_rows;
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

		$garagems = array();
		$n = 0;

		//ordena e limita aos itens da pagina

		if(!$ordem){
			$query .= " ORDER BY id desc LIMIT $startitem, $perpage";
			$ordem = 0;
		} else {
			if($ordem == 0){
				$query .= " ORDER BY id desc LIMIT $startitem, $perpage"; 
			}
			if($ordem == 1){
				$query .= " ORDER BY titulo asc LIMIT $startitem, $perpage"; 
			}
			if($ordem == 2){
				$query .= " ORDER BY valor desc LIMIT $startitem, $perpage"; 
			}
			if($ordem == 3){
				$query .= " ORDER BY valor asc LIMIT $startitem, $perpage"; 
			}
		}

		$retorno['ordem'] = $ordem;

		$conexao = new mysql();
		$coisas_garagems = $conexao->Executar($query);
		while($data_garagems = $coisas_garagems->fetch_object()){

			//seta imagem como não existente
			$imagem = "";

			//confere se tem imagem ordenada
			$conexao = new mysql();
			$coisas_ordem = $conexao->Executar("SELECT * FROM garagem_imagem_ordem WHERE codigo='$data_garagems->codigo' ORDER BY id desc limit 1");
			$data_ordem = $coisas_ordem->fetch_object();

			//se tiver ordem segue o baile
			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$ii = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas_img = $conexao->Executar("SELECT imagem FROM garagem_imagem WHERE id='$value'");
					$data_img = $coisas_img->fetch_object();

					//pega primeira imagem da ordem e coloca na variavel
					if( ($ii == 0) AND (isset($data_img->imagem)) ){

						$imagem = PASTA_CLIENTE."img_veiculos_g/".$data_garagems->codigo."/".$data_img->imagem;

						$ii++;
					}
				}
			}

			$garagems[$n]['imagem'] = $imagem;

			$garagems[$n]['categoria_codigo'] = $data_garagems->categoria_cod;
			$garagems[$n]['categoria_titulo'] = $data_garagems->categoria_nome;

			$garagems[$n]['valor'] = $valores->trata_valor($data_garagems->valor);
			$garagems[$n]['ref'] = $data_garagems->ref;

			$garagems[$n]['id'] = $data_garagems->id;
			$garagems[$n]['codigo'] = $data_garagems->codigo;

			$garagems[$n]['titulo'] = $data_garagems->titulo; 
			$garagems[$n]['ano_fab'] = $data_garagems->ano_fab; 
			$garagems[$n]['ano_mod'] = $data_garagems->ano_modelo; 
			$garagems[$n]['combustivel'] = $data_garagems->combustivel_nome; 
			$garagems[$n]['km'] = $data_garagems->km; 
			$garagems[$n]['tituloparaurl'] = $this->trata_url_titulo($data_garagems->titulo); 


			$n++;
		}
		$retorno['lista'] = $garagems;

		//lista paginação
		$paginacao = "<ul class='pagination'>";

		if($numpages > 1) { 
			if($startpage > 1) {

				$prevstartpage = $startpage - $numlinks;
				$prevstartitem = $prevstartpage - 1;
				$prevendpage = $startpage - 1;

				$link = DOMINIO.$controller_name.'/inicial/gara_cat/'.$categoria.'/gara_marca/'.$marca.'/gara_modelo/'.$modelo.'/gara_combustivel/'.$combustivel.'/gara_transmissao/'.$transmissao.'/gara_cor/'.$cor.'/gara_motor/'.$motor.'/gara_val_max/'.$valor_max.'/gara_val_min/'.$valor_min.'/gara_ordem/'.$ordem.'/gara_ref/'.$busca.'/';

				$link .= "startitem_".$id_var."/$prevstartitem/startpage_".$id_var."/$prevstartpage/endpage_".$id_var."/$prevendpage/reven_".$id_var."/$prevstartpage/#section-garagem-".$id_var;

			}




			for($n = $startpage; $n <= $endpage; $n++) {

				$nextstartitem = ($n - 1) * $perpage;

				if($n != $reven) {

					$link = DOMINIO.$controller_name.'/inicial/gara_cat/'.$categoria.'/gara_marca/'.$marca.'/gara_modelo/'.$modelo.'/gara_combustivel/'.$combustivel.'/gara_transmissao/'.$transmissao.'/gara_cor/'.$cor.'/gara_motor/'.$motor.'/gara_val_max/'.$valor_max.'/gara_val_min/'.$valor_min.'/gara_ordem/'.$ordem.'/gara_ref/'.$busca.'/';

					$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$startpage/endpage_".$id_var."/$endpage/reven_".$id_var."/$n/#section-garagem-".$id_var;
					$paginacao .= "<li><a href='$link' >&nbsp;$n&nbsp;</a></li>";

				} else {
					$paginacao .= "<li><a href='#section-garagem-".$id_var."' class='active' >&nbsp;$n&nbsp;</a></li>";
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

				$link = DOMINIO.$controller_name.'/inicial/gara_cat/'.$categoria.'/gara_marca/'.$marca.'/gara_modelo/'.$modelo.'/gara_combustivel/'.$combustivel.'/gara_transmissao/'.$transmissao.'/gara_cor/'.$cor.'/gara_motor/'.$motor.'/gara_val_max/'.$valor_max.'/gara_val_min/'.$valor_min.'/gara_ordem/'.$ordem.'/gara_ref/'.$busca.'/';

				$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$nextstartpage/endpage_".$id_var."/$nextendpage/reven_".$id_var."/$nextstartpage/#section-garagem-".$id_var;

			}
		}
		$paginacao .= "</ul>";

		$retorno['paginacao'] = $paginacao;


		//retorna para a pagina a array com todos as informações
		return $retorno;
	}

	//trata nome para url
	public function url_title($titulo){

		//remove caracteres indesejados
		$titulo_tratado = str_replace(array("?", ",", ".", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$"), "", $titulo);
		//coloca ifen para separar palavras
		$titulo_tratado = str_replace(array(" ", "_", "+"), "-", $titulo_tratado);
		//certifica que não tem ifens repetidos
		$titulo_tratado = preg_replace('/(.)\1+/', '$1', $titulo_tratado);		 

		return $titulo_tratado;
	}


	public function trata_url_titulo($string){
		$string = $this->remove_acentos($string);
		return $this->url_title($string, '-', TRUE);
	}
	
	public function remove_acentos($string){
		$procurar    = array('À','Á','Ã','Â','É','Ê','Í','Ó','Õ','Ô','Ú','Ü','Ç','à','á','ã','â','é','ê','í','ó','õ','ô','ú','ü','ç');
		$substituir  = array('a','a','a','a','e','r','i','o','o','o','u','u','c','a','a','a','a','e','e','i','o','o','o','u','u','c');
		return str_replace($procurar, $substituir, $string);
	}


	public function lista_categorias(){

    	//lista categorias para lateral
		$categorias = array();
		$conexao = new mysql();
		$coisas_categorias = $conexao->Executar("SELECT * FROM garagem_categorias order by titulo asc");
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
		$coisas_categorias = $conexao->Executar("SELECT titulo FROM garagem_categorias where codigo='$codigo' ");
		$data_categorias = $coisas_categorias->fetch_object();

		return $data_categorias->titulo;
	}	 

	public function imagens($codigo){

		//pega imagens
		$imagens = array();
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM garagem_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$ii = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT id, imagem FROM garagem_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();

				if(isset($data_img->imagem)){

					//carrega legenda se tiver
					$conexao = new mysql();
					$coisas_leg = $conexao->Executar("SELECT legenda FROM garagem_imagem_legenda WHERE id_img='$data_img->id'");
					$data_leg = $coisas_leg->fetch_object();
					if(isset($data_leg->legenda)){
						$imagens[$ii]['legenda'] = $data_leg->legenda;
					} else {
						$imagens[$ii]['legenda'] = '';
					}

					$imagens[$ii]['id'] = $data_img->id;
					$imagens[$ii]['imagem'] = $data_img->imagem;
					$imagens[$ii]['imagem_g'] = PASTA_CLIENTE."img_veiculos_g/".$codigo."/".$data_img->imagem;
					$imagens[$ii]['imagem_p'] = PASTA_CLIENTE."img_veiculos_p/".$codigo."/".$data_img->imagem;

					$ii++;
				}

			}
		}
		return $imagens;
	}
	
	
	public function similares($codigo, $categoria_cod){
		
		$valores = new model_valores();
		
		$garagems = array();
		$n = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem WHERE status='1' AND categoria_cod='$categoria_cod' AND codigo!='$codigo' order by codigo desc limit 9");

		while($data_garagems = $exec->fetch_object()) {

			$imagem = "";

			//confere se tem imagem ordenada
			$conexao = new mysql();
			$coisas_ordem = $conexao->Executar("SELECT * FROM garagem_imagem_ordem WHERE codigo='$data_garagems->codigo' ORDER BY id desc limit 1");
			$data_ordem = $coisas_ordem->fetch_object();

			//se tiver ordem segue o baile
			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$ii = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas_img = $conexao->Executar("SELECT imagem FROM garagem_imagem WHERE id='$value'");
					$data_img = $coisas_img->fetch_object();

					//pega primeira imagem da ordem e coloca na variavel
					if( ($ii == 0) AND (isset($data_img->imagem)) ){

						$imagem = PASTA_CLIENTE."img_veiculos_g/".$data_garagems->codigo."/".$data_img->imagem;

						$ii++;
					}
				}
			}

			$garagems[$n]['imagem'] = $imagem;

			$garagems[$n]['categoria_codigo'] = $data_garagems->categoria_cod;
			$garagems[$n]['categoria_titulo'] = $data_garagems->categoria_nome;

			$garagems[$n]['valor'] = $valores->trata_valor($data_garagems->valor);			 
			$garagems[$n]['ref'] = $data_garagems->ref;

			$garagems[$n]['id'] = $data_garagems->id;
			$garagems[$n]['codigo'] = $data_garagems->codigo;
			$garagems[$n]['titulo'] = $data_garagems->titulo; 

			$n++;
		}

		return $garagems;
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
		$coisas = $conexao->Executar("SELECT * FROM garagem_opcionais order by titulo asc");
		while($data = $coisas->fetch_object()){
			$conexao = new mysql();
			$coisas2 = $conexao->Executar("SELECT * FROM garagem_opcionais_sel WHERE codigo='$codigo' AND opcional='$data->codigo' ");
			if($coisas2->num_rows != 0){

				$lista[$n]['id'] = $data->id;
				$lista[$n]['codigo'] = $data->codigo;
				$lista[$n]['titulo'] = $data->titulo;
				$n++;
			}
		}

		return $lista;
	}

	public function ordem_imagens($codigo){

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM garagem_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		if(isset($data_ordem->data)){
			return $data_ordem->data; 
		} else {
			return false;
		}
	}

	public function lista_marcas(){

		$retorno = array();
		$n = 0;

		$conexao = new mysql();
		$consulta = $conexao->Executar("SELECT * FROM garagem_marcas order by titulo asc");
		while($data = $consulta->fetch_object()){ 

			$retorno[$n]['codigo'] = $data->codigo;			 
			$retorno[$n]['titulo'] = $data->titulo; 

			$n++;
		}		

		return $retorno;
	}

	public function lista_modelos(){

		$retorno = array();
		$n = 0;

		$conexao = new mysql();
		$consulta = $conexao->Executar("SELECT * FROM garagem_modelos order by titulo asc");
		while($data = $consulta->fetch_object()){ 

			$retorno[$n]['codigo'] = $data->codigo;			 
			$retorno[$n]['titulo'] = $data->titulo; 

			$n++;
		}		

		return $retorno;
	}


	public function lista_combustiveis(){

		$retorno = array();
		$n = 0;

		$conexao = new mysql();
		$consulta = $conexao->Executar("SELECT * FROM garagem_combustivel order by titulo asc");
		while($data = $consulta->fetch_object()){ 

			$retorno[$n]['codigo'] = $data->codigo;			 
			$retorno[$n]['titulo'] = $data->titulo; 

			$n++;
		}		

		return $retorno;
	}

	public function lista_cambios(){

		$retorno = array();
		$n = 0;

		$conexao = new mysql();
		$consulta = $conexao->Executar("SELECT * FROM garagem_transmissao order by titulo asc");
		while($data = $consulta->fetch_object()){ 

			$retorno[$n]['codigo'] = $data->codigo;			 
			$retorno[$n]['titulo'] = $data->titulo; 

			$n++;
		}		

		return $retorno;
	}

	public function lista_corveiculo(){

		$retorno = array();
		$n = 0;

		$conexao = new mysql();
		$consulta = $conexao->Executar("SELECT * FROM garagem_cores order by titulo asc");
		while($data = $consulta->fetch_object()){ 

			$retorno[$n]['codigo'] = $data->codigo;			 
			$retorno[$n]['titulo'] = $data->titulo; 

			$n++;
		}		

		return $retorno;
	}

	public function lista_motores(){

		$retorno = array();
		$n = 0;

		$conexao = new mysql();
		$consulta = $conexao->Executar("SELECT * FROM garagem_motor order by titulo asc");
		while($data = $consulta->fetch_object()){ 

			$retorno[$n]['codigo'] = $data->codigo;			 
			$retorno[$n]['titulo'] = $data->titulo; 

			$n++;
		}		
		
		return $retorno;
	}
	
}