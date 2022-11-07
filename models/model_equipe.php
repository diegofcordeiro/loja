<?php

Class model_equipe extends model{
	
	public function lista($grupo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM equipe_grupos WHERE codigo='$grupo' ");
		$data_grupo = $exec->fetch_object();
		
		$retorno['data_grupo'] = $data_grupo;

		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM equipe_ordem WHERE grupo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM equipe WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['descricao'] = $data->conteudo;
					$lista[$n]['links'] = $this->links($data->codigo);
					
					if($data->imagem){
						$lista[$n]['imagem'] = PASTA_CLIENTE.'img_equipe/'.$data->imagem;
					} else {
						$lista[$n]['imagem'] = false;
					}
					
					$n++;
				}
			}
		}		
		$retorno['lista'] = $lista;
		
		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($grupo);
  				
		return $retorno;
	}

	public function links($codigo){

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM equipe_links WHERE codigo='$codigo' order by titulo asc"); 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['link'] = $data->link;
			$lista[$i]['ico'] = PASTA_CLIENTE.'img_equipe/'.$data->ico;

			$i++;
		}
		
		return $lista;
	}	
	
}