<?php

Class model_planos extends model{

	public function lista($grupo){

		$retorno = array();

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM planos_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
		$retorno['botao'] = $layout->carrega_botao($data_grupo->botao_codigo, " aquivaiolink ", true);
		
		$valores = new model_valores();
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM planos_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM planos WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->id)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo; 
					$lista[$n]['valor'] = $valores->trata_valor($data->valor);			 
					$lista[$n]['endereco'] = $data->endereco;
					$lista[$n]['img_fundo'] = $data->img_fundo;
					$lista[$n]['tipo'] = $data->tipo; 
					$lista[$n]['itens'] = $this->itens($data->codigo);
					
					$n++;
				}
			}
		}		
		
		$retorno['lista'] = $lista;

		
		return $retorno;
	}

	public function itens($codigo){

		$lista = array();
		$n = 0;		 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM planos_itens WHERE codigo='$codigo' order by id asc ");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['tipo'] = $data->tipo;

			$n++;
		}
		
		return $lista;
	}
	
}