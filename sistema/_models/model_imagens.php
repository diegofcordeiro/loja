<?php

Class model_imagens extends model{

    public function lista(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM imagem order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {			 
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo; 
			$lista[$i]['imagem'] = $data->imagem;

			$i++;
		}
	  	
		return $lista;
	}

	public function enviadas(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM imagem_enviadas order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {			 
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo; 
			$lista[$i]['imagem'] = $data->imagem;
			
			$i++;
		}
	  	
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM imagem where codigo='$codigo' ");
		return $exec->fetch_object();
    }

    ///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona($vars){
 		
		// executa
		$db = new mysql();
		$db->inserir("imagem", array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1]
		));

	}

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_titulo($titulo, $codigo){

		$dados = array(
			'titulo'=>$titulo
		);
		// executa
		$db = new mysql();
		$db->alterar("imagem", $dados, " codigo='".$codigo."' ");

	}

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_imagem($imagem, $codigo){

		$dados = array(
			'imagem'=>$imagem
		);
		// executa
		$db = new mysql();
		$db->alterar("imagem", $dados, " codigo='".$codigo."' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar($codigo){
		
		// executa
		$db = new mysql();
		$db->apagar("imagem", " codigo='".$codigo."' ");
		
	}
		
}