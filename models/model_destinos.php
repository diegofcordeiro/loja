<?php

Class model_destinos extends model{
    
    public function lista(){
    	
    	$lista = array();

		$db = new mysql();
		$exec = $db->executar("select * from contato order by titulo asc");
		$n = 0;
		while($data = $exec->fetch_object()){
			
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['email'] = $data->email;
			
		$n++;
		}
		
		return $lista;
    }

     public function codigo($codigo){
    	
    	$retorno = '';

		$db = new mysql();
		$exec = $db->executar("select * from contato where codigo='$codigo' ");
		$data = $exec->fetch_object();

		if(isset($data->email)){
			$retorno = $data->email;
		}

		return $retorno;
    }
    

}