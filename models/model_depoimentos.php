<?php

Class model_depoimentos extends model{
	
	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM depoimentos_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
    	$retorno['botao'] = $layout->carrega_botao($data_grupo->botao_codigo, " aquivaiolink ", true);
    	$retorno['botao2'] = $layout->carrega_botao($data_grupo->botao_codigo_env_dep, " aquivaiolink ", true);
    	
		$lista = array();
		$n = 0;
		
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM depoimentos WHERE bloqueio='2' order by id desc ");
		while($data = $exec->fetch_object()) {
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['data'] = date('d/m/Y', $data->data);
			$lista[$n]['nome'] = $data->nome;
			$lista[$n]['email'] = $data->email;
			$lista[$n]['cidade'] = $data->cidade;
			$lista[$n]['conteudo'] = $data->conteudo;
			
			if($data->imagem){
				$lista[$n]['imagem'] = PASTA_CLIENTE.'img_depoimentos/'.$data->imagem;
			} else {
				$lista[$n]['imagem'] = "";
			}
			
			$n++; 
		}

		$retorno['lista'] = $lista;

		return $retorno;
	}
	
	///////////////////////////////////////////////////////////////////////////
	//
	
	public function carrega($id){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM depoimentos where id='$id' ");
		return $exec->fetch_object();
    }

}