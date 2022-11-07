<?php

Class model_fotos extends model{

	public function lista($categoria = null){
		
		$lista = array();
		
		if($categoria){
			
			$conexao = new mysql();
			$exec = $conexao->Executar("SELECT * FROM fotos_ordem where categoria='$categoria' ORDER BY id desc limit 1");
			$data_ordem = $exec->fetch_object();

			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$n = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM fotos WHERE id='$value' ");
					$data = $coisas->fetch_object();

					if(isset($data->titulo)){

						$lista[$n]['id'] = $data->id;
						$lista[$n]['codigo'] = $data->codigo;
						$lista[$n]['titulo'] = $data->titulo;

						$n++;
					}
				}
			}
		}
		
		//echo "<pre>"; print_r($lista); echo "<pre>"; exit;
		return $lista;
	}
	
	public function lista_categorias($selecionado = null){
		
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM fotos_categorias order by titulo asc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['selected'] = '';

			if($selecionado == $data->codigo){
				$lista[$n]['selected'] = "selected";
			}

			$n++;
		}

		return $lista;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MASCARA IMAGEM
	
	public function carrega_mascara(){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_marcadagua WHERE id='1' ");
		$data_masc = $exec->fetch_object();
		return $data_masc->codigo;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_mascara($codigo){

		$db = new mysql();
		$db->alterar("fotos_marcadagua", array(			 
			"codigo"	=>$codigo
		), " id='1' " );

	}
	

	///////////////////////////////////////////////////////////////////////////
	// GRUPOS
	
	public function lista_grupos(){
		
		$categorias = array();
		$i = 0;
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_grupos order by titulo asc");		
		while($data = $exec->fetch_object()) {
			
			$categorias[$i]['id'] = $data->id;
			$categorias[$i]['codigo'] = $data->codigo;
			$categorias[$i]['titulo'] = strip_tags($data->titulo);
			
			$i++;
		}
		return $categorias;
	}
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_grupo($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}


}