<?php

Class model_produtos extends model{

	public $numlinks = 10; //total de paginas mostradas na paginação
	public $busca = '-';
	public $categoria = 0;
	public $marca = 0;
	public $startitem = 0;
	public $startpage = 1;
	public $endpage = '';
	public $reven = 1;
	public $ordem = '';
	public $controller_name = "";
	public $id_var = '';

	public function lista($grupo){
		
		$valores = new model_valores();

		$retorno = array();
		
		// grupos
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM produto_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;
		$retorno['categorias'] = $this->lista_categorias();

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
		$retorno['botao'] = $layout->carrega_botao($data_grupo->botao_codigo, " aquivaiolink ", true);
		
    	//define variaveis
		$perpage = $data_grupo->itens_por_pagina;
		$numlinks = $this->numlinks;
		$busca = $this->busca;		 
		$marca = $this->marca;
		$startitem = $this->startitem;
		$startpage = $this->startpage;
		$endpage = $this->endpage;
		$reven = $this->reven; 
		$ordem = $this->ordem;
		$controller_name = $this->controller_name;
		$id_var = $this->id_var;

		
		$categoria = $this->categoria; 

		if($data_grupo->categoria != 0){
			$categoria = $data_grupo->categoria;
		}
		
		$retorno['categoria_selecionada'] = $categoria;
		
		
		//FILTROS 	

		if($data_grupo->marcados == 1){
			
			$query = "SELECT DISTINCT produto.* FROM produto INNER JOIN produto_grupos_sel ON produto.codigo=produto_grupos_sel.produto 
			WHERE produto_grupos_sel.grupo='$grupo' AND produto.esconder='0' AND ";

		} else {

			$query = "SELECT DISTINCT produto.* FROM produto WHERE produto.esconder='0' AND ";
			
		}


		if($categoria != 0){

		    //lista todas as possibilidades de conexao entre produto e categoria
			$conexao = new mysql();
			$coisas_busca_cat = $conexao->Executar("SELECT * FROM produto_categoria_sel where categoria_codigo='$categoria' ");
			if($coisas_busca_cat->num_rows != 0){
				$query .= " ( ";
				while($data_busca_cat = $coisas_busca_cat->fetch_object()){
					$query .= " produto.codigo='".$data_busca_cat->produto_codigo."' OR ";
				}
				$query = substr($query, 0, strlen($query)-3);
				$query .= " ) AND ";
			} else {
		      //caso não tenha nenhum produto na categoria essa parada corrige para não listar todos os produtos
				$query .= " ( produto.codigo='0' ) AND ";
			}

		}


		if($marca){

			$query .= " produto.marca='$marca' AND "; 

		}
		$retorno['marca_selecionada'] = $marca;
		
		// buscar
		if($busca){
			if($busca != '-'){
				$query .= " ( titulo LIKE '%$busca%' OR ref LIKE '%$busca%' ) AND ";
			}
		}
		
		//elimina sobra da query
		$query = substr($query, 0, strlen($query)-4);
		
		
		//faz a busca no banco e retorno numero de itens para paginação
		$conexao = new mysql();
		$coisas_produtos = $conexao->Executar($query);
		if($coisas_produtos->num_rows) {
			$numitems = $coisas_produtos->num_rows;
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


		//ordena e limita aos itens da pagina
		if(!$ordem){
			$query .= " ORDER BY produto.id desc LIMIT $startitem, $perpage";
			$ordem = 4;
		} else {
			if($ordem == 'rand'){
				$query .= " ORDER BY RAND() LIMIT $startitem, $perpage";
			} else {
				//Ordenar por maior valor
				if($ordem == 1){
					$query .= " ORDER BY produto.valor desc LIMIT $startitem, $perpage"; 
				}
				//Ordenar por menor valor
				if($ordem == 2){
					$query .= " ORDER BY  produto.valor asc LIMIT $startitem, $perpage"; 
				}
				//Ordenar por titulo
				if($ordem == 3){
					$query .= " ORDER BY  produto.titulo asc LIMIT $startitem, $perpage"; 
				}
				//Ordenar por recentes
				if($ordem == 4){
					$query .= " ORDER BY produto.id desc LIMIT $startitem, $perpage"; 
				}
			}
		}
		$retorno['ordem'] = $ordem;

		$produtos = array(); 
		$n = 0;

		// echo $query; exit;

		$conexao = new mysql();
		$coisas_produtos = $conexao->Executar($query);		 
		while($data_produtos = $coisas_produtos->fetch_object()){

			//seta imagem como não existente
			$imagem = "";

			//confere se tem imagem ordenada
			$conexao = new mysql();
			$coisas_ordem = $conexao->Executar("SELECT * FROM produto_imagem_ordem WHERE codigo='$data_produtos->codigo' ORDER BY id desc limit 1");
			$data_ordem = $coisas_ordem->fetch_object();

			//se tiver ordem segue o baile
			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$ii = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas_img = $conexao->Executar("SELECT imagem FROM produto_imagem WHERE id='$value'");
					$data_img = $coisas_img->fetch_object();

					//pega primeira imagem da ordem e coloca na variavel
					if( ($ii == 0) AND (isset($data_img->imagem)) ){

						$imagem = PASTA_CLIENTE."img_produtos_g/".$data_produtos->codigo."/".$data_img->imagem;

						$ii++;
					}
				}
			}

			$produtos[$n]['imagem'] = $imagem;

			$produtos[$n]['id'] = $data_produtos->id;
			$produtos[$n]['codigo'] = $data_produtos->codigo;
			$produtos[$n]['ref'] = $data_produtos->ref;
			$produtos[$n]['titulo'] = $this->limita_texto($data_produtos->titulo, 55);
			$produtos[$n]['previa'] = $data_produtos->previa;
			$produtos[$n]['descricao'] = $data_produtos->descricao;
			$produtos[$n]['sobconsulta'] = $data_produtos->sobconsulta; 
			// estoque geral 
			if($data_produtos->semestoque == 1){
				$produtos[$n]['disponivel'] = true;
			} else {
				$produtos[$n]['disponivel'] = $this->estoque_geral($data_produtos->codigo);
			}

			// valor desconto

			if($data_produtos->valor_falso > 0){
				$calc = $data_produtos->valor_falso - $data_produtos->valor;
				$porc = round(( $calc * 100 ) / $data_produtos->valor_falso);
			} else {
				$porc = 0;
			}

			$produtos[$n]['esconder_valor'] = $data_produtos->esconder_valor;
			$produtos[$n]['valor'] = $valores->trata_valor($data_produtos->valor);
			$produtos[$n]['valor_falso'] = $valores->trata_valor($data_produtos->valor_falso);
			$produtos[$n]['desconto'] = $porc;


			$n++;
		}

		$retorno['lista'] = $produtos;

		//lista paginação
		$paginacao = "<ul class='pagination'>";

		if($numpages > 1) { 
			if($startpage > 1) {

				$prevstartpage = $startpage - $numlinks;
				$prevstartitem = $prevstartpage - 1;
				$prevendpage = $startpage - 1;

				$link = DOMINIO.$controller_name."/inicial/categoria_".$id_var."/$categoria/busca/$busca/";
				$link .= "startitem_".$id_var."/$prevstartitem/startpage_".$id_var."/$prevstartpage/endpage_".$id_var."/$prevendpage/reven_".$id_var."/$prevstartpage/#section-produtos-".$id_var;

			}

			for($n = $startpage; $n <= $endpage; $n++) {

				$nextstartitem = ($n - 1) * $perpage;

				if($n != $reven) {

					$link = DOMINIO.$controller_name."/inicial/categoria_".$id_var."/$categoria/busca/$busca/";
					$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$startpage/endpage_".$id_var."/$endpage/reven_".$id_var."/$n/#section-produtos-".$id_var;
					$paginacao .= "<li><a href='$link' >&nbsp;$n&nbsp;</a></li>";

				} else {
					$paginacao .= "<li><a href='#section-produtos-".$id_var."' class='active' >&nbsp;$n&nbsp;</a></li>";
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

				$link = DOMINIO.$controller_name."/inicial/categoria_".$id_var."/$categoria/busca/$busca/";
				$link .= "startitem_".$id_var."/$nextstartitem/startpage_".$id_var."/$nextstartpage/endpage_".$id_var."/$nextendpage/reven_".$id_var."/$nextstartpage/#section-produtos-".$id_var;

			}
		}
		$paginacao .= "</ul>";

		$retorno['paginacao'] = $paginacao;


		//retorna para a pagina a array com todos as informações
		return $retorno;
	}

	public function lista_categorias(){ 

		$lista = $this->montaCategorias(0);
		
        // echo "<pre>"; print_r($lista); echo "</pre>"; exit;

		return $lista;
	}
	
	public function montaCategorias($id_pai){

		$i = 0;
		$lista = array();

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM produto_categoria_ordem WHERE id_pai='$id_pai' ORDER BY id desc limit 1");
		$data = $exec->fetch_object();

		if(isset($data->data)){

			$order = explode(',', $data->data);
			foreach($order as $key => $value){

				$db = new mysql();
				$exec = $db->Executar("SELECT * FROM produto_categoria WHERE id='$value' ");
				$data = $exec->fetch_object();

				if(isset($data->titulo)){

					$lista[$i]['id'] = $value;
					$lista[$i]['id_pai'] = $id_pai;
					$lista[$i]['codigo'] = $data->codigo;
					$lista[$i]['titulo'] = $data->titulo;
					$lista[$i]['cor_fundo'] = $data->cor_fundo;
					$lista[$i]['cor_texto'] = $data->cor_texto;
					$lista[$i]['subcategorias'] = $this->montaCategorias($value);
					
					$i++;
				}
			}
		}
		return $lista;
	}

	public function lista_autor(){

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM autor ");
			$i = 0;
			// echo'<pre>';print_r($data->nome);exit;
			while($data = $exec->fetch_object()){

				$lista[$i]['id'] = $data->id;
				$lista[$i]['nome'] = $data->nome;
				$i++;
			}
		return $lista;
	}

	public function lista_canal(){

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM canal ");
			$i = 0;
			// echo'<pre>';print_r($data->nome);exit;
			while($data = $exec->fetch_object()){

				$lista[$i]['id'] = $data->id_canal;
				$lista[$i]['nome'] = $data->nm_canal;
				$i++;
			}
		return $lista;
	}

	public function titulo_categoria($codigo){

		$conexao = new mysql();
		$coisas_categorias = $conexao->Executar("SELECT titulo FROM produto_categoria where codigo='$codigo' ");
		$data_categorias = $coisas_categorias->fetch_object();

		return $data_categorias->titulo;
	} 
	public function imagens($codigo){

		//pega imagens
		$imagens = array();
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM produto_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$ii = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT id, imagem FROM produto_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();

				if(isset($data_img->imagem)){					 

					if($ii == 0){
						$dados['imagem_principal'] = PASTA_CLIENTE."img_produtos_g/".$codigo."/".$data_img->imagem;
					}

					$imagens[$ii]['id'] = $data_img->id;
					$imagens[$ii]['imagem_g'] = PASTA_CLIENTE."img_produtos_g/".$codigo."/".$data_img->imagem;
					$imagens[$ii]['imagem_p'] = PASTA_CLIENTE."img_produtos_p/".$codigo."/".$data_img->imagem;

					$ii++;
				}

			}
		}
		$dados['imagens'] = $imagens;

		return $dados;
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

	public function limita_texto($var, $limite){
		// Se o texto for maior que o limite, ele corta o texto e adiciona 3 pontinhos.

		if (strlen($var) > $limite)	{
			$var = substr($var, 0, $limite);
			$var = trim($var) . "...";
		}

		return $var;
	}

	public function restricao_produto($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT msg_restrito FROM produto WHERE codigo='$codigo' ");
		return $exec->fetch_object()->msg_restrito;
	}

	public function carrega_produto_codigo($codigo){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function carrega_categoria($codigo){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_categoria WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function carrega_produto($id){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto WHERE id='$id' ");
		return $exec->fetch_object();
	}

	public function tamanhos($codigo){

		$valores = new model_valores();

		$linhas = array();
		$i = 0;

		$conexao = new mysql();
		$coisas_det = $conexao->Executar("SELECT * FROM produto_tamanho_sel where produto_codigo='$codigo' ");
		while($data_det = $coisas_det->fetch_object()){

			$conexao = new mysql();
			$data_det2 = $conexao->Executar("SELECT * FROM produto_tamanho where codigo='$data_det->tamanho_codigo' ")->fetch_object();

			if(isset($data_det2->id)){

				$linhas[$i]['id'] = $data_det2->id;
				$linhas[$i]['codigo'] = $data_det2->codigo;
				$linhas[$i]['titulo'] = $data_det2->titulo;
				$linhas[$i]['valor'] = $data_det->valor;
				$linhas[$i]['valor_tratado'] = $valores->trata_valor($data_det->valor);

				$i++;
			}

		}

		return $linhas;
	}

	public function cores($codigo){

		$valores = new model_valores();

		$linhas = array();
		$i = 0;

		$conexao = new mysql();
		$coisas_det = $conexao->Executar("SELECT * FROM produto_cor_sel where produto_codigo='$codigo' ");
		while($data_det = $coisas_det->fetch_object()){

			$conexao = new mysql();
			$data_det2 = $conexao->Executar("SELECT * FROM produto_cor where codigo='$data_det->cor_codigo' ")->fetch_object();

			if(isset($data_det2->id)){

				$linhas[$i]['id'] = $data_det2->id;
				$linhas[$i]['codigo'] = $data_det2->codigo;
				$linhas[$i]['titulo'] = $data_det2->titulo;
				$linhas[$i]['valor'] = $data_det->valor;
				$linhas[$i]['valor_tratado'] = $valores->trata_valor($data_det->valor);

				$i++;
			}

		}

		return $linhas;
	}

	public function variacoes($codigo){

		$valores = new model_valores();

		$linhas = array();
		$i = 0;

		$conexao = new mysql();
		$coisas_det = $conexao->Executar("SELECT * FROM produto_variacao_sel where produto_codigo='$codigo' ");
		while($data_det = $coisas_det->fetch_object()){

			$conexao = new mysql();
			$data_det2 = $conexao->Executar("SELECT * FROM produto_variacao where codigo='$data_det->variacao_codigo' ")->fetch_object();

			if(isset($data_det2->id)){

				$linhas[$i]['id'] = $data_det2->id;
				$linhas[$i]['codigo'] = $data_det2->codigo;
				$linhas[$i]['titulo'] = $data_det2->titulo;
				$linhas[$i]['valor'] = $data_det->valor;
				$linhas[$i]['valor_tratado'] = $valores->trata_valor($data_det->valor);

				$i++;
			}

		}

		return $linhas;
	}

	public function estoque_quantidade($produto, $tamanho = "-", $cor = "-", $variacao = "-"){

		if($tamanho == 0){ $tamanho = "-"; }
		if($cor == 0){ $cor = "-"; }
		if($variacao == 0){ $variacao = "-"; }

		$db = new mysql();
		$exec = $db->executar("SELECT quantidade FROM produto_estoque where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$data = $exec->fetch_object();

		if(isset($data->quantidade)){
			return $data->quantidade;
		} else {
			return 0;
		}

	}

	public function baixa_estoque($pedido){		
		if($pedido){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT id FROM pedido_loja WHERE codigo='$pedido' ");
			$data = $coisas->fetch_object();

			$id_pedido = $data->id;

			// confere produtos
			$conexao = new mysql();
			$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='".$pedido."' ");
			if($coisas_carrinho->num_rows != 0){
				while($data_carrinho = $coisas_carrinho->fetch_object()){

					$this->altera_estoque($data_carrinho->produto, $data_carrinho->tamanho, $data_carrinho->cor, $data_carrinho->variacao, $data_carrinho->quantidade, $id_pedido);

					$db = new mysql();
					$db->alterar("pedido_loja_carrinho", array(
						"reserva_estoque"=>1
					), " id='$data_carrinho->id' ");

				}
			}
		}
	}

	public function estoque_geral($codigo){

		$total = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT quantidade FROM produto_estoque where produto='$codigo' ");
		while($data = $exec->fetch_object()) {
			$total = $total + $data->quantidade;
		}

		if($total > 0){
			return true;
		} else {
			return false;
		}
	}

	public function altera_estoque($produto, $tamanho, $cor, $variacao, $quantidade, $id_pedido){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_estoque where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");

		if($exec->num_rows != 0){

			$data_estoque = $exec->fetch_object();

			if($data_estoque->quantidade > 0){

				$novaquantidade = $data_estoque->quantidade - $quantidade;

				$desc_registro = "Registro Automatico - Removido $quantidade item(s) - Reserva Pedido $id_pedido ";
				$time = time();

				// registra alteracao
				$db = new mysql();
				$db->inserir('produto_estoque_registro', array(
					"registro"=>$data_estoque->registro,
					"data"=>$time,
					"quant"=>$quantidade,
					"quant_anterior"=>$data_estoque->quantidade,
					"quant_final"=>$novaquantidade,
					"descricao"=>$desc_registro
				));

				$db = new mysql();
				$db->alterar("produto_estoque", array(
					"quantidade"=>"$novaquantidade"
				), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");

			}
		}

	}

	public function acabamentos(){

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_acabamentos order by titulo asc");
		while($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$i++;
		}
		return $lista;
	}

	public function modelos_gratis_categorias(){

		$lista = array();
		$i = 0;

		$db = new mysql(); 
		$exec = $db->executar("SELECT * FROM produto_modelos_categorias order by titulo asc");
		while($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$i++;
		}
		return $lista;
	}
	
	public function add_estoque_auto($produto, $tamanho, $cor, $variacao, $quant, $descricao){
		
		$db = new mysql();
		$exec = $db->executar("SELECT id, registro, quantidade FROM produto_estoque where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$linhas = $exec->num_rows;
		
		if($linhas != 0){
			
			$data = $exec->fetch_object();
			$quant_anterior = $data->quantidade;
			$registro = $data->registro;
			
			$quantidade = $quant_anterior + $quant;			 
			
			$db = new mysql();
			$db->alterar("produto_estoque", array(
				"quantidade"=>"$quantidade"
			), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
			
			$time = time();
			
			// registra alteracao
			$db = new mysql();
			$db->inserir("produto_estoque_registro", array(
				"registro"=>"$registro",
				"data"=>"$time",
				"quant"=>"$quant",
				"quant_anterior"=>"$quant_anterior",
				"quant_final"=>"$quantidade",
				"descricao"=>"$descricao"
			));
			
		}
	}

	public function gabaritos($produto){

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_gabaritos WHERE produto='$produto' order by titulo asc"); 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['link'] = $data->link;
			$lista[$i]['ico'] = PASTA_CLIENTE.'img_produtos_gabaritos/'.$data->ico;

			$i++;
		}
		
		return $lista;
	}	

}