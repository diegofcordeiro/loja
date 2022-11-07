<?php

Class model_cupom extends model{
    
    public function gera_cupom_promo($promocao){

    	$codigo_cupom = $this->novo_cupom($promocao);

		$conexao = new mysql();
		$conexao->inserir("cupom_lista", array(
			"codigo"=>"$promocao",
			"cupom"=>"$codigo_cupom",
			"utilizado"=>"0"
		));

		return $codigo_cupom;
	}
	
	public function novo_cupom($promocao){
		
		function gera_cupom_semrepetir(){
			
			$cupom = gera_cupom();

			//confere se existe no banco
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT id FROM cupom_lista where cupom='$cupom' ");
			$linhas = $coisas->num_rows;

			if($linhas == 0){
				return $cupom;
			} else {
				return gera_cupom_semrepetir();
			}
		}

		function gera_cupom(){
			
			$numero_caracteres = 10;
			$simbols = '0A1S2D3F4G5H6J7K8L9QWERT0YUIOPZXCVBNM0'; 

			$numerodeitens = strlen($simbols);
			$return = "";

			for($i=1; $i<=$numero_caracteres; ++$i){

				$LMgetup = $simbols[mt_rand(1, $numerodeitens)-1];
				$return .= $LMgetup;

			} 
			return $return; 
		}
		
		return gera_cupom_semrepetir();
	}


	public function confere_cupom_pedido($pedido, $cupom){

		$conexao = new mysql();
		$coisas_cupom = $conexao->Executar("SELECT * FROM cupom_lista where cupom='$cupom' ");
		$data_cupom = $coisas_cupom->fetch_object();

		if(isset($data_cupom->codigo)){

			$conexao = new mysql();
			$coisas_promo = $conexao->Executar("SELECT * FROM cupom WHERE codigo='$data_cupom->codigo' ");
			$data_promo = $coisas_promo->fetch_object();
			
			if(!isset($data_promo->id)){
				
				//remove cupom
				$conexao = new mysql();
				$conexao->alterar("pedido_loja", array(
					"cupom"=>"",
					"cupom_promocao"=>"",
					"cupom_desconto_fixo"=>"0",
					"cupom_desconto_porc"=>"0"
				), " codigo='$pedido' ");
				
				return "erro";
				exit;
			}
			
			// confere se é unico ou pode ser usado varias vezes
			if($data_promo->tipo == 0){
				if($data_cupom->utilizado != 0){

					$conexao = new mysql();
					$coisas_ped = $conexao->Executar("SELECT * FROM pedido_loja where codigo='$pedido' ");
					$data_ped = $coisas_ped->fetch_object();

					if($cupom != $data_ped->cupom){
						//remove cupom
						$conexao = new mysql();
						$conexao->alterar("pedido_loja", array(
							"cupom"=>"",
							"cupom_promocao"=>"",
							"cupom_desconto_fixo"=>"0",
							"cupom_desconto_porc"=>"0"
						), " codigo='$pedido' ");

						return "erro";
						exit;
					}
				}
			}

			$utilizado = $data_cupom->utilizado+1;
			
			//marca cupom como usado
			$conexao = new mysql();
			$conexao->alterar("cupom_lista", array(
				"utilizado"=>"$utilizado"
			), " id='$data_cupom->id' ");

			return "ok";
			exit;

		} else {

			//remove cupom
			$conexao = new mysql();
			$conexao->alterar("pedido_loja", array(
				"cupom"=>"",
				"cupom_promocao"=>"",
				"cupom_desconto_fixo"=>"0",
				"cupom_desconto_porc"=>"0"
			), " codigo='$pedido' ");
			
			return "erro";
			exit;
		}

	}

}