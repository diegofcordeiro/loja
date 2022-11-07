<?php

Class model_redes_sociais extends model{

	/////////////////////////////////////////////////////////////////////////////
	//

	private $tab_principal = "rede_social";
	private $tab_ordem = "rede_social_ordem";
	
	///////////////////////////////////////////////////////////////////////////
	//

    public function lista(){
    		
    	$lista = array();
    	
		$ordem = $this->ordem();
		if($ordem){

			$order = explode(',', $ordem);

			$n = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM ".$this->tab_principal." WHERE id='$value' ");
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
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." where codigo='$codigo' ");
		return $exec->fetch_object();
    }

	public function ordem(){
    	$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM ".$this->tab_ordem." ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

}