<?php

Class model_contador extends model{
	

	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM contador_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM contador_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM contador WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['valor'] = $data->valor;
					
					if($data->imagem){
						$lista[$n]['imagem'] = PASTA_CLIENTE.'img_contador/'.$data->imagem;
					} else {
						$lista[$n]['imagem'] = false;
					}
					
					$n++;
				}
			}
		}		
		$retorno['lista'] = $lista;
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
  				
		return $retorno;
	}
			
}