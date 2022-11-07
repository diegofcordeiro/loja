<?php

Class model_rodapes extends model{

	public function lista(){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_rodapes order by id desc ");
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
		$coisas = $conexao->Executar("SELECT * FROM layout_rodapes_modelos order by id asc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}
	

	public function adiciona_cores($modelo, $rodape){
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_rodapes_cores WHERE rodape_modelo='$modelo' order by titulo asc ");
		while($data = $coisas->fetch_object()){
			
			$conexao = new mysql();
			$coisas2 = $conexao->Executar("SELECT * FROM layout_rodapes_cores_sel WHERE rodape_modelo='$modelo' AND rodape_codigo='$rodape' AND cor_id='$data->id' ");
			if($coisas2->num_rows == 0){

				$db = new mysql();
				$db->inserir("layout_rodapes_cores_sel", array(
					"rodape_codigo"=>$rodape,
					"rodape_modelo"=>$modelo,
					"cor_id"=>$data->id,
					"titulo"=>$data->titulo,
					"cor"=>$data->cor
				));
				
			}
		}

	}

}