<?php

Class model_cep extends model{
    
    public function retorno($cep){ 
    	
    	$cep_destino = str_replace(array("-", " "), "", $cep);
    	$url = "https://nuvemserv.com.br/cep/index.php?cep=$cep_destino";
    	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);
		$json_array = json_decode($result, true);
		
	    return $json_array;  
    }
}