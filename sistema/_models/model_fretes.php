<?php

Class model_fretes extends model{

	/////////////////////////////////////////////////////////////////////////////
	//	

	private $tab_principal = "frete";

	///////////////////////////////////////////////////////////////////////////
	//
	
    public function lista(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo_exibicao;

		$i++;
		}
	  	
		return $lista;
	}
	
	///////////////////////////////////////////////////////////////////////////
	//
	
	public function carrega($id){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." where id='$id' ");
		return $exec->fetch_object();
    }
    
}