<?php

Class model_conteudos extends model{
	
    public function lista(){
    	
    	$lista = array();
    	$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM conteudos ORDER BY titulo asc");		 
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['bloqueio'] = $data->bloqueio;
			
		$n++;
		}
	  	
		return $lista;
	}
	
}