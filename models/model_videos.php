<?php

Class model_videos extends model{

	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM videos_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);

		$lista = array();
		$n = 0;

		$categorias = $this->categorias($grupo);
		$retorno['categorias'] = $categorias;

		if($data_grupo->mostrar_categorias == 0){

			foreach ($categorias as $key => $value) {
				
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM videos WHERE categoria='".$value['codigo']."' ");
				while($data = $coisas->fetch_object()){

					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['previa'] = $data->previa;
					$lista[$n]['conteudo'] = $data->conteudo;

					$n++;
				}
			}

		} else {




		}

		$retorno['lista'] = $lista;
		
		return $retorno;
	}
	
	public function categorias($grupo){
		
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM videos_categorias WHERE grupo='$grupo' order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}
	
}