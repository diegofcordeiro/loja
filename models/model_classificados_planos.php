<?php

Class model_classificados_planos extends model{

	public function lista(){

		$valores = new model_valores();

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_planos ORDER BY titulo asc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['valor'] = $valores->trata_valor($data->valor);
			
			$n++;
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_planos where codigo='$codigo' ");
		return $exec->fetch_object();
	}

}