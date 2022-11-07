<?php

Class model_cupom extends model{

	/////////////////////////////////////////////////////////////////////////////
	//	

	private $tab_principal = "cupom";
	private $tab_cupons = "cupom_lista";

	///////////////////////////////////////////////////////////////////////////
	//
	
    public function lista(){
    	
    	// intancia
    	$valores = new model_valores();

    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['desconto_fixo'] = $valores->trata_valor($data->desconto_fixo);
			$lista[$i]['desconto_porc'] = $data->desconto_porc;
			$lista[$i]['tipo'] = $data->tipo;

		$i++;
		}
	  	
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//
	
    public function cupons($codigo){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_cupons." where codigo='$codigo' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['cupom'] = $data->cupom;
			$lista[$i]['utilizado'] = $data->utilizado;

		$i++;
		}
	  	
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." where codigo='$codigo' ");
		return $exec->fetch_object();
    }

    ///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona($vars){
 		
 		// condições da base de dados
		$dados = array(
			'codigo'		=>$vars[0],
			'titulo'		=>$vars[1],
			'tipo'			=>$vars[2],
			'desconto_fixo'	=>$vars[3],
			'desconto_porc'	=>$vars[4],
			'cadastro'		=>$vars[5],
			'prefixo'		=>$vars[6],
			'valor_minimo'	=>$vars[7]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_principal, $dados);

	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_cupom($vars){
 		
 		// condições da base de dados
		$dados = array(
			'codigo'	=>$vars[0],
			'cupom'		=>$vars[1],
			'utilizado'	=>$vars[2]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_cupons, $dados);

	}

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function alterar($vars, $codigo){

		$dados = array(
			'titulo'		=>$vars[0],
			'tipo'			=>$vars[1],
			'desconto_fixo'	=>$vars[2],
			'desconto_porc'	=>$vars[3],
			'cadastro'		=>$vars[4],
			'prefixo'		=>$vars[5],
			'valor_minimo'	=>$vars[6]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_principal, $dados, " codigo='".$codigo."' ");
		
	}
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar($codigo){
		
		// executa
		$db = new mysql();
		$db->apagar($this->tab_principal, " codigo='".$codigo."' ");
		
		// executa
		$db = new mysql();
		$db->apagar($this->tab_cupons, " codigo='".$codigo."' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar_cupom($id){	
		 
		// executa
		$db = new mysql();
		$db->apagar($this->tab_cupons, " id='".$id."' ");
			
	}	  
	 
	///////////////////////////////////////////////////////////////////////////
	//

	public function gera_cupom(){

		$numero_caracteres = 10;
		$simbols = '0A1S2D3F4G5H6J7K8L9QWERT0YUIOPZXCVBNM0'; 

		$numerodeitens = strlen($simbols);
		$return = "";

		for($i=1; $i<=$numero_caracteres; ++$i){

			$LMgetup = $simbols[mt_rand(1, $numerodeitens)-1];
			$return .= $LMgetup;

		} 
		return $return; 
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function gera_cupom_semrepetir(){

		$cupom = $this->gera_cupom();

		//confere se existe no banco
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT id FROM ".$this->tab_cupons." where cupom='$cupom' ");
		$linhas = $coisas->num_rows;
		
		if($linhas == 0){
			return $cupom;
		} else {
			return $this->gera_cupom_semrepetir();
		}
	}

}