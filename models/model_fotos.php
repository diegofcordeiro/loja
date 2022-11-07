<?php

Class model_fotos extends model{

	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM fotos_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
		
		// categoria				
		$categorias = $this->categorias($grupo);
		$retorno['categorias'] = $categorias;

		// lista
		$lista = array();
		$n = 0;

		if($data_grupo->mostrar_categorias == 0){
			
			if($data_grupo->formato == 'imagens'){

				foreach ($categorias as $key => $value) {

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM fotos WHERE categoria='".$value['codigo']."' ");
					while($data = $coisas->fetch_object()){
						$imagens = $this->imagens($data->codigo);
						foreach ($imagens['lista'] as $key2 => $value2) {							
							$lista[$n] = $value2['imagem_g'];
							$n++;
						}
					}

				}

				shuffle($lista);

			} else {

				foreach ($categorias as $key => $value) {
					
					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM fotos WHERE categoria='".$value['codigo']."' ");
					while($data = $coisas->fetch_object()){

						$lista[$n]['id'] = $data->id;
						$lista[$n]['codigo'] = $data->codigo;
						$lista[$n]['titulo'] = $data->titulo;
						$lista[$n]['previa'] = $data->previa;
						$imagens = $this->imagens($data->codigo);
						$lista[$n]['imagem'] = $imagens['principal'];

						$n++;
					}
				}
			}

		}

		// echo "<pre>"; print_r($lista); echo "</pre>"; exit;

		$retorno['lista'] = $lista;
		
		return $retorno;
	}
	
	public function categorias($grupo){
		
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM fotos_categorias WHERE grupo='$grupo' order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}
	
	public function imagens($codigo){
		
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM fotos_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		$n = 0;
		$dados = array();
		$imagens = array();
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data); 

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM fotos_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();                                

				if(isset($data_img->imagem)){

					$conexao = new mysql();
					$coisas_leg = $conexao->Executar("SELECT * FROM fotos_imagem_legenda WHERE id_img='$data_img->id' ");
					$data_leg = $coisas_leg->fetch_object();

					if(isset($data_leg->legenda)){
						$imagens[$n]['legenda'] = $data_leg->legenda;
					} else {
						$imagens[$n]['legenda'] = "";
					}

					if($n == 0){
						$dados['principal'] = PASTA_CLIENTE.'img_fotos_g/'.$codigo.'/'.$data_img->imagem;
					}	            

					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE.'img_fotos_p/'.$codigo.'/'.$data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE.'img_fotos_g/'.$codigo.'/'.$data_img->imagem;

					$n++;
				}
			}
		}
		$dados['lista'] = $imagens;
		
		return $dados;
	}

	public function carregar($codigo){
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM fotos WHERE codigo='$codigo' order by titulo asc");
		
		return $coisas->fetch_object();
	}
}