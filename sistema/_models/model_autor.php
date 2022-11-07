<?php

Class model_autor extends model{
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// tabelas

	private $tab_autores			= "autor";
	private $tab_imagem 			= "curso_imagem";

 	// LISTA
	
	public function lista(){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_autores." order by nome asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['nome'] = $data->nome;
			$lista[$i]['documento'] = $data->documento;
			$lista[$i]['telefone'] = $data->telefone;
			$lista[$i]['email'] = $data->email;
			$i++;
		}
		return $lista;
	}	
	public function autor_by_id($id){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_autores." WHERE id = ".$id);
		return $exec->fetch_object();
	}

	public function apagar($id){
	
		$db = new mysql();
		$db->apagar($this->tab_autores, " id='".$id."' ");
	}

	public function add_autor($data){
        // echo'<pre>';print_r($data);exit;
        $db = new mysql();
        $db->inserir('autor', array(
					"nome"=>$data[0],
					"documento"=>$data[2],
					"telefone"=>$data[3],
					"email"=>$data[1]
				));
    }
    
}