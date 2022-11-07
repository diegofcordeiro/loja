<?php

Class model_perguntas extends model{

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// tabelas

	private $tab_perguntas = "pergunta";
	private $tab_grupos = "pergunta_grupo";
	private $tab_ordem = "pergunta_ordem";

    public function lista($grupo){
    	
    	$lista = array();

		if($this->ordem($grupo)){

			$order = explode(',', $this->ordem($grupo));

			$i = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM ".$this->tab_perguntas." WHERE id='$value' ");
				$data = $coisas->fetch_object();

				if(isset($data->id)){

					$lista[$i]['id'] = $data->id;
					$lista[$i]['codigo'] = $data->codigo;
					$lista[$i]['grupo'] = $data->grupo;
					$lista[$i]['pergunta'] = $data->pergunta;
					$lista[$i]['resposta'] = $data->resposta; 

				$i++;
				}
			}
		}

		return $lista;
	}

	public function ordem($grupo){ 
    	$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM ".$this->tab_ordem." WHERE codigo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	public function altera_ordem($ordem, $codigo){
		
		$db = new mysql();
		$db->apagar($this->tab_ordem, " codigo='$codigo' ");
 		
 		$db = new mysql();
		$db->inserir($this->tab_ordem, array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));

	}

	public function grupos($codigo = null){
    	
    	$lista = array();
    	$i = 0;

    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_grupos." ");		 
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			
			if($codigo == $data->codigo){
				$lista[$i]['selected'] = true;
			} else {
				 $lista[$i]['selected'] = false;
			}

		$i++;
		}
	  	
		return $lista;
	}

	public function carrega($codigo){ 
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_perguntas." WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	public function carrega_grupo($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_grupos." WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function adiciona_grupo($vars){
 		
 		// condições da base de dados
		$dados = array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_grupos, $dados);
	}

	public function altera_grupo($vars, $codigo){
 		
 		// condições da base de dados
		$dados = array(
			'titulo'=>$vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_grupos, $dados, " codigo='$codigo' ");
	}

	public function apaga_grupo($codigo){
 		
		// executa
		$db = new mysql();
		$db->apagar($this->tab_grupos, " codigo='$codigo' ");
	}
 	
	
}