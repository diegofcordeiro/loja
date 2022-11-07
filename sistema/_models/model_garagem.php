<?php

Class model_garagem extends model{

	public function lista(){
		
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['ref'] = $data->ref;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['tipo'] = $data->tipo;
			
			$n++;
		}
		
		return $lista;
	}
	
	public function categorias(){
		
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_categorias order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}

	public function cores(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_cores order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}
		
		return $lista;
	}

	public function marcas(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_marcas order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}
		
		return $lista;
	}

	public function modelos(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_modelos order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$conexao = new mysql();
			$coisas_marca = $conexao->Executar("SELECT titulo FROM garagem_marcas WHERE codigo='$data->marca' ");
			$data_marca = $coisas_marca->fetch_object();

			$lista[$n]['marca'] = $data_marca->titulo;

			$n++;
		}

		return $lista;
	}

	public function combustivel(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_combustivel order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}

	public function transmissao(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_transmissao order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}

	public function motor(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_motor order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			
			$n++;
		}

		return $lista;
	}

	public function opcionais(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_opcionais order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}
	
	public function opcionais_selecionados($codigo){
		
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM garagem_opcionais order by titulo asc");
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$conexao = new mysql();
			$coisas2 = $conexao->Executar("SELECT * FROM garagem_opcionais_sel WHERE codigo='$codigo' AND opcional='$data->codigo' ");
			if($coisas2->num_rows == 0){
				$lista[$n]['check'] = false;
			} else {
				$lista[$n]['check'] = true;
			}
			
			$n++;
		}

		return $lista;
	}

	public function imagens($codigo){
		
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM garagem_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		
		$n = 0;
		$dados = array();
		$imagens = array();
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data); 
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM garagem_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();                                

				if(isset($data_img->imagem)){

					if($n == 0){
						$dados['principal'] = PASTA_CLIENTE.'img_veiculos_g/'.$codigo.'/'.$data_img->imagem;
					}


					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE.'img_veiculos_p/'.$codigo.'/'.$data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE.'img_veiculos_g/'.$codigo.'/'.$data_img->imagem;

					$n++;
				}
			}
		}
		$dados['lista'] = $imagens;
		return $dados;
	}



	///////////////////////////////////////////////////////////////////////////
	// GRUPOS
	

	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_grupos order by titulo asc");		
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
		$exec = $db->executar("SELECT * FROM garagem_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	public function carrega_grupo_img($codigo){
		
		$lista = array();
		$i = 0;
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_grupos_imagens WHERE codigo='$codigo' ");		
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['imagem'] = $data->imagem;		 
			
			$i++;
		}
		
		return $lista;
	}


}