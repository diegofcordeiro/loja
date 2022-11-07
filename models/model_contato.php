<?php

Class model_contato extends model{
	
	public function carregar($grupo){
		
		$retorno = array();
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM contato_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;
		
		// lista de emails
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM contato_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM contato WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['email'] = $data->email;
					
					$n++;
				}
			}
		}
		$retorno['lista'] = $lista;
		
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
		
		$retorno['botao'] = $layout->carrega_botao($data_grupo->botao_codigo, " aquivaiolink ", true);
		
		return $retorno;
	}
}