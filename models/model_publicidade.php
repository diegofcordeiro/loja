<?php

Class model_publicidade extends model{

	public function lista($grupo){

		$lista = array();

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM publicidade_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$n = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM publicidade WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo; 
					$lista[$n]['imagens'] = $this->banners($data->codigo);

					$n++;
				}
			}
		}

		return $lista;
	}
	
	public function banners($bloco){
		
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM publicidade_banners WHERE bloco='$bloco' ORDER BY id desc");
		while($data = $exec->fetch_object()){
			
			$lista[$n]['id'] = $data->id; 
			$lista[$n]['imagem'] = PASTA_CLIENTE.'img_banners/'.$data->imagem; 
			$lista[$n]['endereco'] = $data->endereco; 

			$n++;
		}

		return $lista;
	}

	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM publicidade where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function ordem($grupo){ 
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM publicidade_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	public function altera_ordem($ordem, $grupo){

		$db = new mysql();
		$db->apagar("publicidade_ordem", " grupo='$grupo' ");

		$db = new mysql();
		$db->inserir("publicidade_ordem", array(
			"grupo"=>"$grupo",
			"data"=>"$ordem"
		));
	}

}