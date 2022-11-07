<?php

Class model_revistajornal extends model{
	
	public function lista(){
		
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM revistajornal ORDER BY edicao asc ");
		while($data = $exec->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['edicao'] = $data->edicao;
			$lista[$n]['paginas'] = $data->paginas;
			$lista[$n]['formato'] = $this->carrega_formato($data->formato)->titulo;

			$n++;
		}

		return $lista;
	}

	public function carrega($codigo){
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM revistajornal WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function carrega_formato($codigo){
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM revistajornal_formatos WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function formatos(){
		
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM revistajornal_formatos ORDER BY titulo asc ");
		while($data = $exec->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			
			$n++;
		}
		
		return $lista;
	}

	public function imagens($codigo){

		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT paginas FROM revistajornal WHERE codigo='$codigo' ");
		$data = $exec->fetch_object();

		for ($i=1; $i <= $data->paginas; $i++){

			$conexao = new mysql();
			$exec_img = $conexao->Executar("SELECT * FROM revistajornal_imagem WHERE codigo='$codigo' AND pagina='$i' ");
			$data_img = $exec_img->fetch_object();

			if(isset($data_img->imagem)){
				$lista[$i] = $data_img->imagem;
			} else {
				$lista[$i] = '';
			}
		}

		return $lista;
	}


	///////////////////////////////////////////////////////////////////////////
	// GRUPOS

	public function lista_grupos(){

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM revistajornal_grupos order by titulo asc");		
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
		$exec = $db->executar("SELECT * FROM revistajornal_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}

}