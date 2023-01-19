<?php

Class model_planos extends model{

	public function lista(){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM planos ");

		while($value = $exec->fetch_object()){
			$lista[$n]['id'] = $value->id;
			$lista[$n]['titulo'] = strip_tags($value->titulo);
			$lista[$n]['price'] = 'R$ '.number_format($value->price, 2, '.', '');
			$lista[$n]['intervalo'] = $value->intervalo;
			$lista[$n]['status'] = $value->status;
			$n++;
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM planos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	///////////////////////////////////////////////////////////
	//

	public function ordem($grupo){ 
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM planos_ordem ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	public function itens($codigo){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM planos_itens WHERE codigo='$codigo' order by id asc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['titulo'] = $data->titulo;

			if($data->tipo == 1){ 
				$lista[$n]['tipo'] = "Incluso"; 
			} else {
				$lista[$n]['tipo'] = "Não Incluso";
			}

			$n++;
		}
		
		return $lista;
	}
	

	///////////////////////////////////////////////////////////////////////////
	// GRUPOS

	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM planos_grupos order by titulo asc");		
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
		$exec = $db->executar("SELECT * FROM planos_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
}