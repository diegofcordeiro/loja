<?php

Class model_rodapes extends model{

	public function lista($codigo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec_rodape = $conexao->Executar("SELECT * FROM layout_rodapes WHERE codigo='$codigo' ");
		$retorno['data_rodape'] = $exec_rodape->fetch_object();
		
		// cores
		$cores = array();

		$db = new mysql();
		$exec_cores = $db->executar("select * FROM layout_rodapes_cores_sel WHERE rodape_codigo='$codigo' AND rodape_modelo='".$retorno['data_rodape']->modelo."' order by id asc");
		while($data_cores = $exec_cores->fetch_object()){
			$cores[ $data_cores->cor_id ] = $data_cores->cor;			
		}
		
		$retorno['cores']['lista'] = $cores; 

		// detalhes cores
		$cores = array();
		$n = 0;

		$db = new mysql();
		$exec_cores = $db->executar("select * FROM layout_rodapes_cores_sel WHERE rodape_codigo='$codigo' AND rodape_modelo='".$retorno['data_rodape']->modelo."' order by id asc");
		while($data_cores = $exec_cores->fetch_object()){
			$cores[$n]['tipo'] = "rodape ". $retorno['data_rodape']->modelo;
			$cores[$n]['id'] = $data_cores->cor_id;
			$cores[$n]['titulo'] = $data_cores->titulo;
			$cores[$n]['cor'] = $data_cores->cor;
			$n++;	
		}
		$retorno['cores']['detalhes'] = $cores;
		
		
		// menu
		$lista = $this->menu_pega_lista($codigo, 0);
		$retorno['menu'] = $this->menu_gerar($codigo, $lista);
		
		if($retorno['data_rodape']->botao_aviso){
			$layout = new model_layout();			
			$botao_aviso = $layout->carrega_botao($retorno['data_rodape']->botao_aviso, " onClick='aceitar_cokies();' ", true);
		} else {
			$botao_aviso = "";
		}
		$retorno['botao_aviso'] = $botao_aviso;
		
		return $retorno;
	}

	public function menu_pega_lista($rodape, $id){

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_menu_rodape_ordem WHERE rodape_codigo='$rodape' AND id_pai='$id' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){
			$retorno = explode(',', $data_ordem->data);
		} else {
			$retorno = array();
		}

		return $retorno;
	}

	public function menu_gerar($rodape, $order){
		
		$lista = array();

		$n = 0;
		foreach($order as $key => $value){
			
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM layout_menu_rodape WHERE id='$value' AND rodape_codigo='$rodape' ");
			$data = $coisas->fetch_object();

			if(isset($data->titulo)){
				if($data->visivel == 0){
					
					$array = explode('http', $data->endereco);
					$numero = count($array);
					
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$array_control = explode('/', $data->endereco);
					$lista[$n]['controller'] = $array_control[0];
					$lista[$n]['url'] = $data->endereco; 

					$array = explode('http', $data->endereco);
					$numero = count($array);

					if($numero > 1){
						$lista[$n]['destino'] = $data->endereco;
					} else {
						$lista[$n]['destino'] = DOMINIO.$data->endereco;
					}
					
					$array_sub = $this->menu_pega_lista($rodape, $value);
					$lista[$n]['submenu'] = $this->menu_gerar($rodape, $array_sub);
					
					$n++;
				}
			}
		}
		
		return $lista;
	}

}