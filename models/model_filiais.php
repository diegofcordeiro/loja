<?php

Class model_filiais extends model{

	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM filiais_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);

		$lista = array();
		$n = 0;	

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM filiais_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM filiais WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$imagens = $this->imagens($data->codigo);
					$lista[$n]['imagem'] = $imagens['imagem_principal'];

					$n++;
				}
			}
		}

		$retorno['lista'] = $lista;
		
		return $retorno;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM filiais where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	///////////////////////////////////////////////////////////
	//

	public function ordem($grupo){ 
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM filiais_ordem ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	public function imagens($codigo){

		//pega imagens
		$imagens = array();
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM filiais_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			$ii = 0;
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT id, imagem FROM filiais_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();

				if(isset($data_img->imagem)){					 
					
					if($ii == 0){
						$dados['imagem_principal'] = PASTA_CLIENTE."img_filiais_g/".$codigo."/".$data_img->imagem;
					}
					
					$imagens[$ii]['id'] = $data_img->id;
					$imagens[$ii]['imagem_g'] = PASTA_CLIENTE."img_filiais_g/".$codigo."/".$data_img->imagem;
					$imagens[$ii]['imagem_p'] = PASTA_CLIENTE."img_filiais_p/".$codigo."/".$data_img->imagem;
					
					$ii++;
				}

			}
		}
		$dados['imagens'] = $imagens;
		
		return $dados;
	}
	
}