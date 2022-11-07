<?php

Class model_topos extends model{

	public function lista($codigo){
		
		$retorno = array();		 

		$conexao = new mysql();
		$exec_topo = $conexao->Executar("SELECT * FROM layout_topos WHERE codigo='$codigo' ");
		$retorno['data_topo'] = $exec_topo->fetch_object();
		
		// cores 
		$cores = array();

		$db = new mysql();
		$exec_cores = $db->executar("select * FROM layout_topos_cores_sel WHERE topo_codigo='$codigo' AND topo_modelo='".$retorno['data_topo']->modelo."' and status = 1 order by id asc");
		while($data_cores = $exec_cores->fetch_object()){
			$cores[ $data_cores->cor_id ] = $data_cores->cor;
		}
		$retorno['cores']['lista'] = $cores;
		
		
		// cores detalhes
		$cores = array();
		$n = 0;
		
		$db = new mysql();
		$exec_cores = $db->executar("select * FROM layout_topos_cores_sel WHERE topo_codigo='$codigo' AND topo_modelo='".$retorno['data_topo']->modelo."' and status = 1 order by id asc");
		while($data_cores = $exec_cores->fetch_object()){
			$cores[$n]['tipo'] = "topo ". $retorno['data_topo']->modelo;
			$cores[$n]['id'] = $data_cores->cor_id;
			$cores[$n]['titulo'] = $data_cores->titulo;
			$cores[$n]['cor'] = $data_cores->cor;
			$n++;	
		}
		$retorno['cores']['detalhes'] = $cores;
		
		
		// menu
		$lista = $this->menu_pega_lista($codigo, 0);
		$retorno['menu'] = $this->menu_gerar($codigo, $lista);

		// icones
		$retorno['icones'] = $this->icones($codigo);

		// botoes
		$retorno['botoes'] = $this->botoes($codigo);


		return $retorno;
	}

	public function menu_pega_lista($topo, $id){

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_menu_ordem WHERE topo_codigo='$topo' AND id_pai='$id' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){
			$retorno = explode(',', $data_ordem->data);
		} else {
			$retorno = array();
		}

		return $retorno;
	}

	public function menu_gerar($topo, $order){
		
		$lista = array();

		$n = 0;
		foreach($order as $key => $value){
			
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM layout_menu WHERE id='$value' AND topo_codigo='$topo' ");
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
							$lista[$n]['destino'] .= '/inicial/prod_categoria/'.$data->categoria;
						}
						
						$array_control = explode('/', $data->endereco);
						$lista[$n]['controller'] = $array_control[0];
					}
					
					$lista[$n]['imagem'] = $data->imagem;
					$lista[$n]['icone'] = $data->icone;
					
					$array_sub = $this->menu_pega_lista($topo, $value);
					$lista[$n]['submenu'] = $this->menu_gerar($topo, $array_sub);
					
					$n++;
				}
			}
		}
		
		return $lista;
	}

	public function icones($codigo){		
		
		$n = 0;
		$lista = array(); 

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM 	layout_topos_icones_ordem WHERE topo_codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();		 
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM layout_topos_icones WHERE id='$value' AND topo_codigo='$codigo' AND ativo='1' ");
				$data = $coisas->fetch_object();                                

				if(isset($data->id)){

					$lista[$n]['id'] = $data->id;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['icone'] = $data->icone;
					$lista[$n]['destino'] = $data->endereco;

					$n++;
				}
			}
		}

		return $lista;
	}

	public function botoes($codigo){		
		
		$n = 0;
		$lista = array(); 

		$layout = new model_layout();

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM 	layout_topos_botoes_ordem WHERE topo_codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();		 
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM layout_topos_botoes WHERE id='$value' AND topo_codigo='$codigo' AND ativo='1' ");
				$data = $coisas->fetch_object();                                
				
				if(isset($data->id)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['botao_codigo'] = $data->botao_codigo;
					$lista[$n]['destino'] = $data->endereco;
					$lista[$n]['botao'] = $layout->carrega_botao($data->botao_codigo, $data->endereco, false); 
					
					$n++;
				}
			}
		}

		return $lista;
	}

}