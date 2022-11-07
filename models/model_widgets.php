<?php

Class model_widgets extends model{
	
	public function carregar($codigo){
		
		$retorno = array();
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM widgets WHERE codigo='$codigo' ");
		$data_grupo = $coisas->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;
		 
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($codigo);
		
		return $retorno;
	}
}