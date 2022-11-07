<?php

Class model_pedidos_classificados extends model{

	public function utilizados($codigo){
			
		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos_utilizacoes where pedido='$codigo' order by id desc"); 
		while($data = $exec->fetch_object()) { 
			$lista[$i]['id'] = $data->id; 
			$lista[$i]['data'] = date('d/m/y H:i', $data->data);
			$lista[$i]['anuncio'] = $data->anuncio;
			$lista[$i]['ref'] = $data->anuncio_ref;

			$i++;
		}
		
		return $lista;
	}
	
	public function lista_incompletos(){

		$cadastro = new model_cadastros();
		
		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos where status='0' order by id desc"); 
		while($data = $exec->fetch_object()) { 
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['data'] = date('d/m/y H:i', $data->data);
			$lista[$i]['data_int'] = $data->data;

			if( $data->cadastro ){
				if($cadastro_data = $cadastro->carrega($data->cadastro)){
					$lista[$i]['email'] = $cadastro_data->email;
				} else {
					$lista[$i]['email'] = '';
				}
			} else {
				$lista[$i]['email'] = '';
			}
			
			$i++;
		}
		
		return $lista;
	}
	
	public function lista_aguardando(){
		
		// intancia
		$valores = new model_valores();
		$cadastro = new model_cadastros();

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos where status='1' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) { 

			$cadastro_data = $cadastro->carrega($data->cadastro);

			if( isset($cadastro_data->email) ){

				$lista[$i]['id'] = $data->id;
				$lista[$i]['codigo'] = $data->codigo;
				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['valor'] = $valores->trata_valor($data->plano_valor); 
				$lista[$i]['email'] = $cadastro_data->email;

				if($cadastro_data->tipo == 'F'){
					$lista[$i]['nome'] = $cadastro_data->fisica_nome;
				} else {
					$lista[$i]['nome'] = $cadastro_data->juridica_nome;
				}

				$i++;
			}
		}

		return $lista;
	}
	
	public function lista_aprovados(){
		
		// intancia
		$valores = new model_valores();
		$cadastro = new model_cadastros();
		
		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos where status='2' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) { 

			$cadastro_data = $cadastro->carrega($data->cadastro);

			if( isset($cadastro_data->email) ){
				
				$lista[$i]['id'] = $data->id;
				$lista[$i]['codigo'] = $data->codigo;
				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['valor'] = $valores->trata_valor($data->plano_valor); 
				$lista[$i]['email'] = $cadastro_data->email;
				
				if($cadastro_data->tipo == 'F'){
					$lista[$i]['nome'] = $cadastro_data->fisica_nome;
				} else {
					$lista[$i]['nome'] = $cadastro_data->juridica_nome;
				}

				$i++;
			}
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	///////////////////////////////////////////////////////////////////////////
	//

}