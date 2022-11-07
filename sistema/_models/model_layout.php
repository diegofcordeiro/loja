<?php

Class model_layout extends model{


	public function lista_itens(){
		
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_itens order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo; 
			$lista[$n]['tipo'] = $data->tipo;

			$n++;
		}

		return $lista;
	}


	////////////////////////////////////////////////////////////
	// para alteração dentro dos modulos

	public function adicionar_pagina($codigo, $titulo, $tipo){
		$db = new mysql();
		$db->inserir("layout_itens", array(
			"codigo"=>$codigo,
			"tipo"=>$tipo,
			"titulo"=>$titulo
		));
	}
	public function altera_paginas($codigo, $titulo){ 
		$db = new mysql();
		$db->alterar("layout_itens", array(
			"titulo"=>$titulo
		), " codigo='".$codigo."' ");
	}

	public function apagar_pagina($codigo){
		$db = new mysql();
		$db->apagar("layout_itens", " codigo='$codigo' ");
	}


	// cores


	public function adiciona_cores($tipo, $pagina){

		$conexao = new mysql();
		$coisas_cores = $conexao->Executar("SELECT * FROM layout_itens_cores WHERE tipo='$tipo' order by titulo asc ");
		while($data_cores = $coisas_cores->fetch_object()){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM layout_itens_cores_sel WHERE tipo='$tipo' AND item_codigo='$pagina' AND cor_id='$data_cores->id' ");
			if($coisas->num_rows == 0){

				$db = new mysql();
				$db->inserir("layout_itens_cores_sel", array(
					"item_codigo"=>$pagina,
					"tipo"=>$tipo,
					"cor_id"=>$data_cores->id,
					"titulo"=>$data_cores->titulo,
					"cor"=>$data_cores->cor
				));

			}		
		}
	}

	public function lista_cores($pagina){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas_cores = $conexao->Executar("SELECT * FROM layout_itens_cores_sel WHERE item_codigo='$pagina' ");
		while($data_cores = $coisas_cores->fetch_object()){

			$lista[$n]['id'] = $data_cores->id;
			$lista[$n]['titulo'] = $data_cores->titulo;
			$lista[$n]['cor'] = $data_cores->cor;

			$n++;
		}

		return $lista;
	}

	public function apagar_cores($item){
		$db = new mysql();
		$db->apagar("layout_itens_cores_sel", " item_codigo='$item' ");
	}


	public function lista_botoes(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes ORDER BY id asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$n++;
		}

		return $lista;
	}


	public function lista_css(){

		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_css ORDER BY id asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['classe'] = $data->classe;
			$n++;
		}
		
		return $lista;
	}


}