<?php

Class model_rastreamento extends model{

	public function lista(){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM rastreamento order by id desc ");
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
		$exec = $conexao->Executar("SELECT * FROM rastreamento_ordem ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	public function lista_objetos(){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM rastreamento_objetos order by id desc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['data'] = date('d/m/Y', $data->data);
			$lista[$n]['ref'] = $data->ref;			
			$lista[$n]['origem'] = $data->origem;			
			$lista[$n]['destino'] = $data->destino;			
			$n++;
		}

		return $lista;
	}

	public function lista_objetos_itens($codigo){
		
		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM rastreamento_objetos_itens WHERE codigo='$codigo' order by id asc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['data'] = date('d/m/Y H:i', $data->data);
			$lista[$n]['descricao'] = $data->descricao;

			$n++;
		}
		
		return $lista;
	}
	
}