<?php

Class model_config extends model{

	public function carrega_config(){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM adm_config where id='1' ");
		return $exec->fetch_object();
	}

    ///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_meta(){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM meta where id='1' ");
		return $exec->fetch_object();
	}

    ///////////////////////////////////////////////////////////////////////////
	//
	
	public function carrega_contato($id){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM contato where id='$id' ");
		return $exec->fetch_object();
	}

    ///////////////////////////////////////////////////////////////////////////
	//
	
	public function carrega_contato_grupo($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM contato_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}

    //////////////////////////////////////////////////////////////////////////
	//

	public function contato_grupos(){
		$lista = array();
		$n=0;
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM contato_grupos order by titulo asc");
		while($data = $exec->fetch_object()){
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$n++;
		}
		return $lista;
	}

	public function lista_contatos($grupo = null){

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM contato WHERE grupo='$grupo' order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['email'] = $data->email;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['grupo_codigo'] = $data->grupo;
			
			$db = new mysql();
			$exec2 = $db->executar("SELECT * FROM contato_grupos where codigo='$data->grupo' ");
			$data2 = $exec2->fetch_object();

			if(isset($data2->titulo)){
				$lista[$i]['grupo_titulo'] = $data2->titulo;
			} else {
				$lista[$i]['grupo_titulo'] = '';
			}

			$i++;
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_contato($vars){ 

		// executa
		$db = new mysql();
		$db->inserir('contato', array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1],
			'email'=>$vars[2],
			'grupo'=>$vars[3]
		));
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_contato($vars, $id){

		$dados = array(
			'titulo'=>$vars[0],
			'email'=>$vars[1],
			'grupo'=>$vars[2]
		);

		// executa
		$db = new mysql();
		$db->alterar('contato', $dados, " id='".$id."' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar_contato($id){

		// executa
		$db = new mysql();
		$db->apagar('contato', " id='".$id."' ");

	}
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_smtp($vars){

		$dados = array(
			'email_nome'	=>$vars[0],
			'email_origem'	=>$vars[1],
			'email_retorno'	=>$vars[2],
			'email_porta'	=>$vars[3],
			'email_host'	=>$vars[4],
			'email_usuario'	=>$vars[5],
			'email_senha'	=>$vars[6]
		);
		// executa
		$db = new mysql();
		$db->alterar('adm_config', $dados, " id='1' ");

	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_logo($imagem){

		// executa
		$db = new mysql();
		$db->alterar('adm_config', array(
			'logo'	=>$imagem
		), " id='1' ");

	}


}