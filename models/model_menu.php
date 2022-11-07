<?php
Class model_menu extends model{
	
	public function lista(){

		$lista = $this->pega_lista(0);
		$retorno = $this->gera_menu($lista);
		
		//echo "<pre>"; print_r($retorno); echo "</pre>"; exit;

		return $retorno;
	}

	public function pega_lista($id){

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_menu_ordem WHERE id_pai='$id' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){
			$retorno = explode(',', $data_ordem->data);
		} else {
			$retorno = array();
		}

		return $retorno;
	}

	public function gera_menu($order){
		
		$lista = array();

		$n = 0;
		foreach($order as $key => $value){
			
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM layout_menu WHERE id='$value' ");
			$data = $coisas->fetch_object();
			
			if(isset($data->titulo)){
				if($data->visivel == 0){
					
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['controller'] = "";
					$lista[$n]['url'] = $data->endereco;
					$lista[$n]['categoria'] = $data->categoria;
					
					
					$array = explode('http', $data->endereco);
					if(count($array) > 1){
						$lista[$n]['destino'] = $data->endereco;
					} else {
						$lista[$n]['destino'] = DOMINIO.$data->endereco;

						if($data->categoria){
							$lista[$n]['destino'] .= '/prod_categoria/'.$data->categoria;
						}
						
						$array_control = explode('/', $data->endereco);
						$lista[$n]['controller'] = $array_control[0];
					}
					
					
					$lista[$n]['imagem'] = $data->imagem;
					$lista[$n]['banner'] = $data->banner;
					
					$array_sub = $this->pega_lista($value);
					$lista[$n]['submenu'] = $this->gera_menu($array_sub);
					
					$n++;
				}
			}
		}
		
		return $lista;
	}
	
	
	
	/// rodape


	public function lista_rodape(){
		
		$lista = $this->pega_lista_rodape(0);
		$retorno = $this->gera_menu_rodape($lista);
		
		//echo "<pre>"; print_r($retorno); echo "</pre>"; exit;

		return $retorno;
	}
	
	public function pega_lista_rodape($id){
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_menu_rodape_ordem WHERE id_pai='$id' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		
		if(isset($data_ordem->data)){
			$retorno = explode(',', $data_ordem->data);
		} else {
			$retorno = array();
		}
		
		return $retorno;
	}

	public function gera_menu_rodape($order){

		$lista = array();

		$n = 0;
		foreach($order as $key => $value){
			
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM layout_menu_rodape WHERE id='$value' ");
			$data = $coisas->fetch_object();
			
			if(isset($data->titulo)){
				if($data->visivel == 0){

					$array = explode('http', $data->endereco);
					$numero = count($array);
					
					$lista[$n]['titulo'] = $data->titulo;
					$array_control = explode('/', $data->endereco);
					$lista[$n]['controller'] = $array_control[0];
					$lista[$n]['url'] = $data->endereco;
					
					if($numero > 1){
						$lista[$n]['destino'] = $data->endereco;
					} else {
						$lista[$n]['destino'] = DOMINIO.$data->endereco;
					}
					
					$array_sub = $this->pega_lista_rodape($value);
					$lista[$n]['submenu'] = $this->gera_menu_rodape($array_sub);
					
					$n++;
				}
			}
		}
		
		return $lista;
	}

}