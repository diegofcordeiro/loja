<?php

Class model_logo extends model{
    
    public function imagem(){
 		
		$db = new mysql();
		$exec = $db->executar("SELECT logo FROM adm_config where id='1' ");
		$data = $exec->fetch_object();
		
		if($data->logo){
			return PASTA_CLIENTE.'img_logo/'.$data->logo; 
		} else {
			return LAYOUT."img/logo.png"; 
		}        
    }
	
}