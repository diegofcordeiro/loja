<?php

Class model_paginas extends model{
    
    public function conteudo($codigo){
    	
		$db = new mysql();
		$exec = $db->executar("select * from paginas WHERE codigo='$codigo' ");
		$data = $exec->fetch_object();
		
		if(isset($data->conteudo)){
			$conteudo = $data->conteudo;
		} else {
			$conteudo = '';
		}
		
		return $conteudo;
    }

    public function conteudo_url($codigo){
    		
		$db = new mysql();
		$exec = $db->executar("select * from paginas WHERE url='$codigo' ");
		$data = $exec->fetch_object();
		
		$retorno = array();

		if(isset($data->conteudo)){
			$retorno['conteudo'] = $data->conteudo;
			$retorno['titulo'] = $data->titulo;
			$retorno['url'] = $data->url;
		}
		
		return $retorno;
    }

}