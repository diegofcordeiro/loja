<?php

Class model_filiais extends model{

	public function lista($grupo){
			
			$lista = array();
			
			$conexao = new mysql();
			$exec = $conexao->Executar("SELECT * FROM filiais_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
			$data_ordem = $exec->fetch_object();
			
			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$n = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM filiais WHERE id='$value' ");
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
	// GRUPOS

	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM filiais_grupos order by titulo asc");		
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
		$exec = $db->executar("SELECT * FROM filiais_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
}