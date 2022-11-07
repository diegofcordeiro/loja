<?php
//
//$mascara->aplicar($codigo_mascara, $caminho_imagem);
//
Class model_mascara{

	private $tab_mascara = "marcadagua";

	public function lista($codigo = null){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_mascara." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			if($data->posicao == 1){
				$lista[$i]['posicao'] = "Centro";
			}
			if($data->posicao == 2){
				$lista[$i]['posicao'] = "Canto esquerdo superior";
			}
			if($data->posicao == 3){
				$lista[$i]['posicao'] = "Canto direito superior";
			}
			if($data->posicao == 4){
				$lista[$i]['posicao'] = "Canto esquerdo inferior";
			}
			if($data->posicao == 5){
				$lista[$i]['posicao'] = "Canto direito inferior";
			}

			if($data->preencher == 0){
				$lista[$i]['preencher'] = "Não";
			} else {
				$lista[$i]['preencher'] = "Sim";
			}

			$lista[$i]['imagem'] = PASTA_CLIENTE.'img_mascaras/'.$data->imagem;
			$lista[$i]['imagem_nome'] = $data->imagem;

			if($data->codigo == $codigo){
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}

		$i++;
		}

		return $lista;
	}

	public function aplicar($codigo, $imagem) {

		$conexao = new mysql();
		$coisas_mascara = $conexao->Executar("SELECT * FROM ".$this->tab_mascara." where codigo='$codigo' ");
		$data_mascara = $coisas_mascara->fetch_object();

		//preencher a imagem
		if($data_mascara->preencher == 1){
			
			$source = imagecreatefromjpeg($imagem);
			$imagex = imagesx($source);
			$imagey = imagesy($source);

			$original = imagecreatefromjpeg($imagem);
			$mascara = imagecreatefrompng("_views/img/mascara_pontilhados.png");
			imagecopy($original, $mascara, 0, 0, 0, 0, $imagex, $imagey);
			imagejpeg($original, $imagem, 100);
			
		}
		
		//mascara imagem
		if(isset($data_mascara->imagem)){
			
			$logo = "../arquivos/img_mascaras/$data_mascara->imagem";
			
			$source = imagecreatefromjpeg($imagem);
			$imagex = imagesx($source);
			$imagey = imagesy($source);

			$source_logo = imagecreatefrompng($logo);
			$imagex_logo = imagesx($source_logo);
			$imagey_logo = imagesy($source_logo);
			
			//centro
			if($data_mascara->posicao == 1){
				$ponto_lateral = ($imagex/2)-($imagex_logo/2);
				$ponto_altura = ($imagey/2)-($imagey_logo/2);

				imagecopyresampled($source, $source_logo, $ponto_lateral, $ponto_altura, 0, 0, $imagex_logo, $imagey_logo, $imagex_logo, $imagey_logo);
			}

			//Canto esquerdo superior
			if($data_mascara->posicao == 2){
				imagecopyresampled($source, $source_logo, 10, 10, 0, 0, $imagex_logo, $imagey_logo, $imagex_logo, $imagey_logo);
			}
			
			//Canto direito superior
			if($data_mascara->posicao == 3){
				$ponto_lateral = ($imagex-$imagex_logo)-10;
				$ponto_altura = 10;
				imagecopyresampled($source, $source_logo, $ponto_lateral, $ponto_altura, 0, 0, $imagex_logo, $imagey_logo, $imagex_logo, $imagey_logo);
			}
			
			//Canto esquerdo inferior
			if($data_mascara->posicao == 4){
				$ponto_lateral = 10;
				$ponto_altura = ($imagey-$imagey_logo)-10;

				imagecopyresampled($source, $source_logo, $ponto_lateral, $ponto_altura, 0, 0, $imagex_logo, $imagey_logo, $imagex_logo, $imagey_logo);
			}
			
			//Canto direito inferior
			if($data_mascara->posicao == 5){
				$ponto_lateral = ($imagex-$imagex_logo)-10;
				$ponto_altura = ($imagey-$imagey_logo)-10;

				imagecopyresampled($source, $source_logo, $ponto_lateral, $ponto_altura, 0, 0, $imagex_logo, $imagey_logo, $imagex_logo, $imagey_logo);
			}
			
			imagejpeg($source, $imagem, 100);
		}

	}

	public function carrega($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_mascara." where codigo='$codigo' ");
		return $exec->fetch_object();
    }

    public function adiciona($vars){ 

		// executa
		$db = new mysql();
		$db->inserir($this->tab_mascara, array(
			'codigo'	=>$vars[0],
			'titulo'	=>$vars[1],
			'imagem'	=>$vars[2],
			'posicao'	=>$vars[3],
			'preencher'	=>$vars[4]
		));
	}
 	
 	public function altera($vars, $codigo){

		$dados = array(
			'titulo'	=>$vars[0],
			'posicao'	=>$vars[1],
			'preencher'	=>$vars[2]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_mascara, $dados, " codigo='".$codigo."' ");
	}

	public function apagar($codigo){

		// executa
		$db = new mysql();
		$db->apagar($this->tab_mascara, " codigo='".$codigo."' ");
	}

}