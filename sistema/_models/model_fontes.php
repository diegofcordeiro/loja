<?php

Class model_fontes extends model{
	
	public function lista(){
		
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_fontes ORDER BY titulo asc");
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['family'] = $data->family;
			$lista[$n]['tipo'] = $data->tipo;
			$lista[$n]['fixo'] = $data->fixo;
			
			$n++;
		}

		return $lista;
	}

	public function font_family($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_fontes WHERE codigo='$codigo' ");
		$data = $exec->fetch_object();
		$font_family = addslashes($data->family);
		return $font_family;
	}
	
	public function lista_tudo(){
		
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_fontes ORDER BY titulo asc");
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['family'] = $data->family;
			$lista[$n]['tipo'] = $data->tipo;
			$lista[$n]['endereco'] = $data->endereco;
			$lista[$n]['arquivo'] = $data->arquivo;

			$n++;
		}

		return $lista;
	}

}