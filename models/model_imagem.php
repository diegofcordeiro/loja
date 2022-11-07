<?php

Class model_imagem extends model{
    
    public function codigo($codigo){
    	
    	$return = '';

		$db = new mysql();
		$exec = $db->executar("select * from imagem where codigo='$codigo' ");
		$data = $exec->fetch_object();

		if($data->imagem){
			$return = PASTA_CLIENTE.'imagens/'.$data->imagem;
		}
		
		return $return;
    }

    public function lista($codigo){
    	
    	$lista = array();
    	$n = 0;
    	
    	$db = new mysql();
		$exec = $db->executar("select * from imagem_itens where codigo='$codigo' order by id desc ");
		while($data = $exec->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['imagem'] = PASTA_CLIENTE.'imagens/'.$data->imagem;
			$n++;
			
		}
		
		return $lista;
    }
    
}