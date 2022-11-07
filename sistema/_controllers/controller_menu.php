<?php

class menu extends controller {

	public function init(){
		$this->autenticacao();
	}
	
	public function altera(){

		$perfil = new model_perfil();
		$perfil->encolhe_menu($this->_cod_usuario);
		
	}

}