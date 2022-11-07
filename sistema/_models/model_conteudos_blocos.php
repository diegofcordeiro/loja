<?php

Class model_conteudos_blocos extends model{

	public function lista(){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM conteudos_blocos order by id desc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = strip_tags($data->titulo);
			$lista[$n]['imagem'] = $data->imagem;
			$lista[$n]['imagem_fundo'] = $data->imagem_fundo;
			
			$n++;
		}

		return $lista;
	}

	public function ordem(){ 
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM conteudos_blocos_ordem ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}
	
}