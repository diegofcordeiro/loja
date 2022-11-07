<?php

Class model_topos extends model{

	public function lista(){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_topos order by id desc ");
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
		$coisas = $conexao->Executar("SELECT * FROM layout_topos_modelos order by id asc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}
	

	public function adiciona_cores($modelo, $topo){

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_topos_cores_sel WHERE topo_modelo='$modelo' AND topo_codigo='$topo' ");
		if($coisas->num_rows == 0){

			$conexao = new mysql();
			$coisas2 = $conexao->Executar("SELECT * FROM layout_topos_cores WHERE topo_modelo='$modelo' order by titulo asc ");
			while($data2 = $coisas2->fetch_object()){
				$db = new mysql();
				$db->inserir("layout_topos_cores_sel", array(
					"topo_codigo"=>$topo,
					"topo_modelo"=>$modelo,
					"cor_id"=>$data2->id,
					"titulo"=>$data2->titulo,
					"cor"=>$data2->cor
				));
			}		
		}
	}
	
}