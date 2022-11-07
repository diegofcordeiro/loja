<?php

class erro extends controller {
	
	protected $_modulo_nome = "Erro";
	
	public function init(){
	}

	public function inicial(){
		
		$dados = array();
		$dados['_base'] = $this->base();
		
		$this->view('erro', $dados);
	}

//termina classe
}