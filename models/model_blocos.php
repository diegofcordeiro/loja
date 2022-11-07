<?php

Class model_blocos extends model{
	
	public function carregar($codigo){
		
		$retorno = array();
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM blocos WHERE codigo='$codigo' ");
		return $coisas->fetch_object();
		
	}
}