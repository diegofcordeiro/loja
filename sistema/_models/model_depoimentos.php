<?php

Class model_depoimentos extends model{

	public function lista($grupo = null){

		$dados = array();
		$aguardando = array();
		$aprovados = array();

		$db = new mysql();
		if($grupo){
			$exec = $db->executar("SELECT * FROM depoimentos WHERE grupo='$grupo' order by id desc");
		} else {
			$exec = $db->executar("SELECT * FROM depoimentos order by id desc");
		}
		$i1 = 0;
		$i2 = 0;
		while($data = $exec->fetch_object()) {
			
			if($data->bloqueio == 2){

				$aprovados[$i1]['id'] = $data->id;
				$aprovados[$i1]['data'] = date('d/m/Y', $data->data);
				$aprovados[$i1]['nome'] = $data->nome;
				$aprovados[$i1]['email'] = $data->email;
				$aprovados[$i1]['cidade'] = $data->cidade;
				$aprovados[$i1]['empresa'] = $data->empresa;
				if($data->imagem){
					$aprovados[$i1]['imagem'] = PASTA_CLIENTE.'img_depoimentos/'.$data->imagem;
				} else {
					$aprovados[$i1]['imagem'] = "";
				}
				$aprovados[$i1]['conteudo'] = $data->conteudo;
				
				$i1++;
			} else {
				
				$aguardando[$i2]['id'] = $data->id;
				$aguardando[$i2]['data'] = date('d/m/Y', $data->data);
				$aguardando[$i2]['nome'] = $data->nome;
				$aguardando[$i2]['email'] = $data->email;
				$aguardando[$i2]['cidade'] = $data->cidade;
				$aguardando[$i2]['empresa'] = $data->empresa;
				if($data->imagem){
					$aguardando[$i2]['imagem'] = PASTA_CLIENTE.'img_depoimentos/'.$data->imagem;
				} else {
					$aguardando[$i2]['imagem'] = "";
				}
				$aguardando[$i2]['conteudo'] = $data->conteudo;

				$i2++;
			}
		}

		$dados['aguardando'] = $aguardando;
		$dados['aprovados'] = $aprovados;

		return $dados;
	}
	
	///////////////////////////////////////////////////////////////////////////
	//
	
	public function carregar($id){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM depoimentos where id='$id' ");
		return $exec->fetch_object();
	}

    ///////////////////////////////////////////////////////////////////////////
	// GRUPOS

	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM depoimentos_grupos order by titulo asc");		
		while($data = $exec->fetch_object()) {
			
			$categorias[$i]['id'] = $data->id;
			$categorias[$i]['codigo'] = $data->codigo;
			$categorias[$i]['titulo'] = strip_tags($data->titulo);
			
			$i++;
		}
		return $categorias;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_grupo($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM depoimentos_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}

}