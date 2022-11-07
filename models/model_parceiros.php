<?php

Class model_parceiros extends model{
	
	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM parceiros_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);

		$lista = array();
		$n = 0;		

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM parceiros order by RAND() ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['imagem'] = PASTA_CLIENTE.'img_parceiros/'.$data->imagem;
			$lista[$n]['endereco'] = $data->endereco;
			
			$n++;
		}
		$retorno['lista'] = $lista;

		return $retorno;
	}

}