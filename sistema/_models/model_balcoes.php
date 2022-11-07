<?php

Class model_balcoes extends model{
	
	public function lista($uf = null){

		$lista = array();
		$i = 0;

		$db = new mysql();

		if($uf){
			$exec = $db->executar("SELECT * FROM balcoes WHERE uf='$uf' order by id asc");
		} else {
			$exec = $db->executar("SELECT * FROM balcoes order by id asc");
		}

		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['uf'] = $data->uf;

			$i++;
		}

		return $lista;
	}
	
	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM balcoes where codigo='$codigo' ");
		return $exec->fetch_object();
	}

}