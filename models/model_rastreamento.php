<?php

Class model_rastreamento extends model{
	
	public function carregar($codigo){
		
		$retorno = array();
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM rastreamento WHERE codigo='$codigo' ");
		$data = $coisas->fetch_object();

		$retorno['id'] = $data->id;
		$retorno['codigo'] = $data->codigo;
		$retorno['tipo'] = $data->tipo;
		$retorno['titulo'] = $data->titulo;
		$retorno['imagem'] = $data->imagem;
		$retorno['posicao'] = $data->posicao;
		$retorno['descricao'] = $data->conteudo;
		$retorno['mostrar_titulo'] = $data->mostrar_titulo;
		$retorno['botao_titulo'] = $data->botao_titulo;
				
		$retorno['imagem_fundo'] = $data->imagem_fundo;
		$retorno['imagem_fundo_tipo'] = $data->imagem_fundo_tipo;
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($codigo);
		$retorno['botao'] = $layout->carrega_botao($data->botao_codigo, " aquivaiolink ", true);
		
		return $retorno;
	}
}