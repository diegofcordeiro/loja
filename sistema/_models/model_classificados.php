<?php

Class model_classificados extends model{

	public function lista(){

		$valores = new model_valores();
		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados order by titulo asc"); 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo; 
			$lista[$i]['categoria_titulo'] = $data->categoria_titulo;

			if($data->status == 1){
				$lista[$i]['status'] = 'Ativo';
			} else {
				$lista[$i]['status'] = 'Inativo';
			}
			
			$i++;
		}
		
		return $lista;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function lista_cidades($codigo = null){
		
		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_cidades order by cidade asc"); 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['estado'] = $data->estado;
			
			if($codigo == $data->codigo){
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}
			
			if($data->principal == 1){
				$lista[$i]['principal'] = 'Sim';
			} else {
				$lista[$i]['principal'] = '';
			}
			
			$i++;
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function lista_bairros($cidade, $estado){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_bairros WHERE cidade='$cidade' AND estado='$estado' order by bairro asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['bairro'] = $data->bairro;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['estado'] = $data->estado;
			
			$i++;
		}

		return $lista;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function lista_bairros_all(){
		
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_bairros order by bairro asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['bairro'] = $data->bairro;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['estado'] = $data->estado;
			
			$i++;
		}
		
		return $lista;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function videos($codigo){

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_videos WHERE codigo='$codigo' order by titulo asc"); 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo; 

			$i++;
		}
		
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function lista_tipos($codigo = null){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_tipos order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			if($codigo == $data->codigo){
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}
			
			$i++;
		}
		
		return $lista;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function lista_opcoes($codigo, $selecionado = null){

		$lista = array();
		$n = 0;

		if($codigo != 0){

			$conexao = new mysql();		 
			$coisas = $conexao->Executar("SELECT * FROM classificados_opcoes WHERE marcador='$codigo' order by titulo asc");
			while($data = $coisas->fetch_object()){

				$lista[$n]['id'] = $data->id;
				$lista[$n]['codigo'] = $data->codigo;
				$lista[$n]['titulo'] = $data->titulo;

				$conexao = new mysql();
				$coisas2 = $conexao->Executar("SELECT * FROM classificados_opcoes_sel WHERE codigo='$selecionado' AND opcional='$data->codigo' ");
				if($coisas2->num_rows == 0){
					$lista[$n]['selected'] = false;
				} else {
					$lista[$n]['selected'] = true;
				}

				$n++;
			}
			
		} else {

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

					$conexao = new mysql();
					$coisas2 = $conexao->Executar("SELECT * FROM classificados_opcoes_sel WHERE codigo='$selecionado' AND opcional='$data->codigo' ");
					if($coisas2->num_rows == 0){
						$sublista[$n_sub]['selected'] = false;
					} else {
						$sublista[$n_sub]['selected'] = true;
					}

					$n_sub++;
				}

				$lista[$n]['opcoes'] = $sublista;
				$n++;
			}
			
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
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function lista_categorias($codigo = null){
		
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_categorias order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			if($codigo == $data->codigo){
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}
			
			if($data->ativo == 1){
				$lista[$i]['ativo'] = true;
			} else {
				$lista[$i]['ativo'] = false;
			}
			
			$i++;
		}
		
		return $lista;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// IMAGENS
	
	public function lista_imagens($codigo){
		
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM classificados_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		
		$n = 0;
		$dados = array();
		$imagens = array();
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data); 
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM classificados_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();                                
				
				if(isset($data_img->imagem)){
					
					if($n == 0){
						$dados['principal'] = PASTA_CLIENTE.'img_classificados_g/'.$codigo.'/'.$data_img->imagem;
					}
					
					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem'] = $data_img->imagem;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE.'img_classificados_p/'.$codigo.'/'.$data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE.'img_classificados_g/'.$codigo.'/'.$data_img->imagem;
					
					$n++;
				}
			}
		}
		
		return $imagens;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function adiciona_imagem($vars){ 
		
		$db = new mysql();
		$db->inserir("classificados_imagem", array(
			"codigo"	=>$vars[0],
			"imagem"	=>$vars[1]
		));
		$ultid = $db->ultimo_id();
		
		return $ultid;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

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
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function salva_ordem_imagem($codigo, $ordem){ 
		
		$db = new mysql();
		$db->inserir("classificados_imagem_ordem", array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function seleciona_imagem($id){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_imagem WHERE id='$id' ");
		return $exec->fetch_object();
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MASCARA IMAGEM
	
	public function carrega_mascara(){
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_marcadagua WHERE id='1' ");
		$data_masc = $exec->fetch_object();
		return $data_masc->codigo;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_mascara($codigo){
		
		$db = new mysql();
		$db->alterar("classificados_marcadagua", array(			 
			"codigo"	=>$codigo
		), " id='1' " );

	}


	///////////////////////////////////////////////////////////////////////////
	// GRUPOS


	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_grupos order by titulo asc");		
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
		$exec = $db->executar("SELECT * FROM classificados_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	public function carrega_grupo_img($codigo){
		
		$lista = array();
		$i = 0;
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_grupos_imagens WHERE codigo='$codigo' ");		
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['imagem'] = $data->imagem;		 
			
			$i++;
		}
		
		return $lista;
	}

}