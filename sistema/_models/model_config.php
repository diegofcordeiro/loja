<?php

Class model_config extends model{

	public function carrega_config(){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM adm_config where id='1' ");
		return $exec->fetch_object();
	}

	public function carrega_banner_admin(){
		$db = new mysql();
		$exec = $db->executar("SELECT banner_admin FROM layout_topos");
		return $exec->fetch_object();
	}

	public function carrega_banner_site(){
		$db = new mysql();
		$exec = $db->executar("SELECT fundo FROM layout_topos");
		return $exec->fetch_object();
	}

	public function carrega_logo_site(){
		$db = new mysql();
		$exec = $db->executar("SELECT logo FROM layout_topos");
		return $exec->fetch_object();
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
	
	public function altera_analytics($codigo){
		
		// executa
		$db = new mysql();
		$db->alterar('adm_config', array(
			'analytcs'	=>$codigo
		), " id='1' ");
		
	}
	
}