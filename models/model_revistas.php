<?php

Class model_revistas extends model{
	
	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM revistajornal_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);


		$lista = array();
		$n = 0;


		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM revistajornal ORDER by edicao desc ");
		while($data = $exec->fetch_object()){

			$conexao = new mysql();
			$exec2 = $conexao->Executar("SELECT * FROM revistajornal_grupos_sel WHERE codigo='$data->codigo' AND grupo='$grupo' ");
			if($exec2->num_rows != 0){

				$conexao = new mysql();
				$exec3 = $conexao->Executar("SELECT * FROM revistajornal_imagem WHERE codigo='$data->codigo' AND pagina='1' ");
				if($exec3->num_rows != 0){
					
					$data3 = $exec3->fetch_object();
					
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['edicao'] = $data->edicao;

					$lista[$n]['imagem'] = PASTA_CLIENTE.'img_revistajornal_p/'.$data3->imagem;

					$n++;
				}
			}
		}
		
		$retorno['lista'] = $lista;
		
		return $retorno;
	}

	public function imagens($codigo){


	}

}