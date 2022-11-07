<?php

Class model_cadastro extends model{

	public function carregar($codigo){

		$retorno = array();
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM cadastro_grupos WHERE codigo='$codigo' ");
		$retorno['data_grupo'] = $coisas->fetch_object();
		
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($codigo);
		$retorno['botao'] = $layout->carrega_botao($retorno['data_grupo']->botao_codigo, " aquivaiolink ", true);
		
		return $retorno;
	}	
	
	public function dados_usuario($codigo){
		
		$conexao = new mysql();
		$coisas_dados = $conexao->Executar("SELECT * FROM cadastro WHERE codigo='$codigo' ");
		if($coisas_dados->num_rows == 1){
			return $coisas_dados->fetch_object();
		} else {
			return false;
		}
		
	}

}