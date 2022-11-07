<?php

Class model_videos extends model{

	public function lista($categoria){
		
		$lista = array();
		$n = 0;

		if($categoria){ 

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM videos WHERE categoria='$categoria' order by id desc ");
			while($data = $coisas->fetch_object()){

				$lista[$n]['id'] = $data->id;
				$lista[$n]['codigo'] = $data->codigo;
				$lista[$n]['titulo'] = $data->titulo;

				$n++;
			}
		}

		return $lista;
	}

	public function lista_categorias(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM videos_categorias order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}


	///////////////////////////////////////////////////////////////////////////
	// GRUPOS

	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM videos_grupos order by titulo asc");		
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
		$exec = $db->executar("SELECT * FROM videos_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}

}