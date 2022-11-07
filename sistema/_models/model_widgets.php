<?php

Class model_widgets extends model{

	public function lista(){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM widgets order by id desc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = strip_tags($data->titulo);
			
			$n++;
		}

		return $lista;
	}
	
}