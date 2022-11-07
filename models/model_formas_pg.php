<?php

Class model_formas_pg extends model{     
 	
 	public function lista($id = null){

 		$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM pagamento WHERE ativo='0' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['estado'] = $data->estado;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['selected'] = false;
			
			if(!$id){
				if($i == 0){
					$lista[$i]['selected'] = true;
				}
			} else {
				if($id == $data->id){
					$lista[$i]['selected'] = true;
				}
			}
			
		$i++;
		}

		return $lista;
	}
 	
}