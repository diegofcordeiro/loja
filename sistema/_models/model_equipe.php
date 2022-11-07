<?php

Class model_equipe extends model{

	public function lista($grupo){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM equipe_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM equipe WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					
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
		$exec = $db->executar("SELECT * FROM equipe where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function carrega_link($id){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM equipe_links where id='$id' ");
		return $exec->fetch_object();
	}
	
	///////////////////////////////////////////////////////////
	//

	public function ordem($grupo){ 
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM equipe_ordem ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	public function lista_links($codigo){

		$retorno = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM equipe_links WHERE codigo='$codigo' order by titulo asc");		
		while($data = $exec->fetch_object()) {
			
			$retorno[$i]['id'] = $data->id;
			$retorno[$i]['titulo'] = $data->titulo;		 
			$retorno[$i]['link'] = $data->link;

			$i++;
		}
		return $retorno;
	}
	
	///////////////////////////////////////////////////////////////////////////
	// GRUPOS

	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM equipe_grupos order by titulo asc");		
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
		$exec = $db->executar("SELECT * FROM equipe_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
}