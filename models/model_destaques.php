<?php
Class model_destaques extends model{

	public function lista($grupo){
		
		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM destaques_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM destaques_ordem WHERE codigo='$grupo' ORDER BY id desc limit 1");		
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM destaques WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->imagem)){
					
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['imagem'] = PASTA_CLIENTE.'img_destaques/'.$data->imagem;
					
					if($data->endereco){
						$lista[$n]['link'] = $data->endereco;
					} else {
						$lista[$n]['link'] = false;
					}

					$n++;
				}
				
			}
		}		
		$retorno['lista'] = $lista;
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);

		return $retorno;
	}


}