<?php

Class model_conteudos_blocos extends model{
	
	public function carregar($codigo){

		$retorno = array();

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($codigo);
				
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM conteudos_blocos WHERE codigo='$codigo' ");
		$data = $coisas->fetch_object();
		$retorno['data_grupo'] = $data; 
		
		$retorno['id'] = $data->id;
		$retorno['codigo'] = $data->codigo;
		$retorno['tipo'] = $data->tipo;
		$retorno['titulo'] = $data->titulo;
		$retorno['imagem'] = $data->imagem;
		$retorno['posicao'] = $data->posicao;
		$retorno['descricao'] = $data->conteudo;
		$retorno['mostrar_titulo'] = $data->mostrar_titulo;
		
		$retorno['imagem_fundo'] = $data->imagem_fundo;
		$retorno['imagem_fundo_tipo'] = $data->imagem_fundo_tipo;

		$retorno['margem'] = $data->margem; 

		$retorno['botao_codigo1'] = $data->botao_codigo1; 
		$retorno['botao_codigo2'] = $data->botao_codigo2; 

		if($data->botao_codigo1){

			if($data->endereco_padrao1){
				$retorno['endereco1'] = DOMINIO.$data->endereco_padrao1;
			} else {
				$retorno['endereco1'] = $data->endereco1;
			}		 

			$retorno['botao1'] = $layout->carrega_botao($data->botao_codigo1, $retorno['endereco1'], false);

		} else {
			$retorno['botao1'] = '';
			$retorno['endereco1'] = ''; 
		}

		if($data->botao_codigo2){

			if($data->endereco_padrao2){
				$retorno['endereco2'] = DOMINIO.$data->endereco_padrao2;
			} else {
				$retorno['endereco2'] = $data->endereco2;
			}

			$retorno['botao2'] = $layout->carrega_botao($data->botao_codigo2, $retorno['endereco2'], false);

		} else {
			$retorno['botao2'] = '';
			$retorno['endereco2'] = ''; 
		}
		


		return $retorno;
	}
}