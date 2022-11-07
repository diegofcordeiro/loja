<?php

Class model_imoveis_planos extends model{

	public function lista(){

		$valores = new model_valores();

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_planos ORDER BY titulo asc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['meses'] = $data->meses;
			$lista[$n]['valor'] = $valores->trata_valor($data->valor);
			
			$n++;
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_planos where codigo='$codigo' ");
		return $exec->fetch_object();
	}

}