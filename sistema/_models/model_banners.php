<?php

Class model_banners extends model{

	public function lista($grupo){
    	
    	$lista = array();

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM banners_ordem WHERE codigo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$n = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM banners WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['imagem'] = $data->imagem;			 
					
				$n++;
				}
			}
		}
	  	
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM banners where codigo='$codigo' ");
		return $exec->fetch_object();
    }

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_imagem($imagem, $codigo){ 

		$db = new mysql();
		$db->alterar('banners', array(
			'imagem'=>$imagem
		), " codigo='$codigo' " );
		
	}

	///////////////////////////////////////////////////////////////////////////
	//	 
	
	public function apaga_banner($codigo){ 
		
		$db = new mysql();
		$db->apagar('banners', " codigo='$codigo' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function ordem($grupo){ 
    	$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM banners_ordem WHERE codigo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_ordem($ordem, $codigo){
		
		$db = new mysql();
		$db->apagar("banners_ordem", " codigo='$codigo' ");
 		
 		$db = new mysql();
		$db->inserir("banners_ordem", array(
			"codigo"=>$codigo,
			"data"=>$ordem
		));

	}
	
	///////////////////////////////////////////////////////////////////////////
	// GRUPOS

	public function lista_grupos(){
 		
 		$categorias = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM banners_grupos order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$categorias[$i]['id'] = $data->id;
			$categorias[$i]['codigo'] = $data->codigo;
			$categorias[$i]['titulo'] = $data->titulo;
			$categorias[$i]['bloqueio'] = $data->bloqueio;

		$i++;
		}
		return $categorias;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_grupo($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM banners_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
    }
	
}