<?php

Class model_postagens extends model{
	
    public $limit = 1000; //itens por pagina
    public $busca = '-';
    public $categoria = 0; 
    public $imagens = false;
	public $ordem = ''; // 'rand' para randomico ou em branco para data desc
	
	public function lista(){
		
    	//define variaveis
		$limit = $this->limit;
		$busca = $this->busca;
		$categoria = $this->categoria; 
		$ordem = $this->ordem;

		//retorno 
		$dados = array();
		
    	//FILTROS
		$query = "SELECT * FROM noticia ";
		
		//se tiver busca ignora tudo e faz a busca
		if($busca != "-"){
			$query = "SELECT * FROM noticia WHERE titulo LIKE '%$busca%' OR previa LIKE '%$busca%' ";
		} else {
			//se selecionou a categoria tem prioridade sobre
			if($categoria != 0){
				$query = "SELECT * FROM noticia WHERE categoria='$categoria' ";
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
		$dados['numitems'] = $numitems;

		$noticias = array();
		$mes = new model_datas();

		//ordena e limita aos itens da pagina
		if($ordem == 'rand'){
			$query .= " ORDER BY RAND() LIMIT $limit";
		} else {
			$query .= " ORDER BY data desc LIMIT $limit";
		}

		$conexao = new mysql();
		$coisas_noticias = $conexao->Executar($query);
		$n = 0;
		while($data_noticias = $coisas_noticias->fetch_object()){

			//verfica se vai listar imagens
			if($this->imagens){

				$imagens = $this->imagens($data_noticias->codigo);

				$noticias[$n]['imagem'] = $imagens['principal'];
				$noticias[$n]['imagens'] = $imagens['lista'];
				
			}

			//verifica nome do categorias
			$conexao = new mysql();
			$coisas_noticias_cat = $conexao->Executar("SELECT titulo FROM noticia_categorias WHERE codigo='$data_noticias->categoria'");
			$data_noticias_cat = $coisas_noticias_cat->fetch_object();

			if(isset($data_noticias_cat->titulo)){
				$noticias[$n]['categoria'] = $data_noticias_cat->titulo;
				$noticias[$n]['categoria_codigo'] = $data_noticias->categoria;
			} else {
				$noticias[$n]['categoria'] = "";
				$noticias[$n]['categoria_codigo'] = 0;
			}
 
			
			//restante
			$noticias[$n]['id'] = $data_noticias->id;
			$noticias[$n]['codigo'] = $data_noticias->codigo;
			$noticias[$n]['titulo'] = $data_noticias->titulo;
			$noticias[$n]['previa'] = $data_noticias->previa;
			$noticias[$n]['data'] = date('d', $data_noticias->data)." ".$mes->mes($data_noticias->data, 2)." ".date('Y', $data_noticias->data);
			$noticias[$n]['data_cod'] = $data_noticias->data;			 

			$n++;
		}
		$dados['noticias'] = $noticias;

		//retorna para a pagina a array com todos as informações
		return $dados;
	}

	public function imagens($codigo){

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM noticia_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		$n = 0;
		$dados = array();
		$imagens = array();
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data); 

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM noticia_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();                                

				if(isset($data_img->imagem)){

					if($n == 0){
						$dados['principal'] = PASTA_CLIENTE.'img_postagens_g/'.$codigo.'/'.$data_img->imagem;
					}

					$conexao = new mysql();
					$coisas_leg = $conexao->Executar("SELECT * FROM noticia_imagem_legenda WHERE id_img='$value' ");
					$data_leg = $coisas_leg->fetch_object();

					if(isset($data_leg->legenda)){
						$imagens[$n]['legenda'] = $data_leg->legenda;
					} else {
						$imagens[$n]['legenda'] = "";
					}

					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE.'img_postagens_p/'.$codigo.'/'.$data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE.'img_postagens_g/'.$codigo.'/'.$data_img->imagem;

					$n++;
				}
			}
		}
		$dados['lista'] = $imagens;
		return $dados;
	}

	public function categorias(){ 

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_categorias order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$i++;
		}
		return $lista;
	}

	public function autores(){ 

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_autores order by nome asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['nome'] = $data->nome;

			$i++;
		}
		return $lista;
	}
	

 	///////////////////////////////////////////////////////////////////////////
	// GRUPOS


	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_grupos order by titulo asc");		
		while($data = $exec->fetch_object()) {
			
			$categorias[$i]['id'] = $data->id;
			$categorias[$i]['codigo'] = $data->codigo;
			$categorias[$i]['titulo'] = strip_tags($data->titulo);
			
			$i++;
		}
		return $categorias;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_grupo($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
}