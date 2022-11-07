<?php

Class model_textos extends model{
	
	public function lista(){
		
		$lista = array();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM textos ORDER BY titulo asc");
		$n = 0;
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['conteudo'] = $data->conteudo;
			$n++;
		}

		return $lista;
	}
	
}