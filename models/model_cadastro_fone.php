<?php

Class model_cadastro_fone extends model{
	
	public function carregar($codigo){
		
		$retorno = array();
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM cadastro_fone_grupos WHERE codigo='$codigo' ");
		$data = $coisas->fetch_object();
		
		$retorno['data_grupo'] = $data;
		
		$retorno['id'] = $data->id;
		$retorno['codigo'] = $data->codigo;
		$retorno['titulo'] = $data->titulo;
		$retorno['descricao'] = $data->descricao;
		
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($codigo);
		$retorno['botao'] = $layout->carrega_botao($data->botao_codigo, " aquivaiolink ", true);
		
		return $retorno;
	}
}