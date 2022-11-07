<?php

class pedidos_classificados extends controller {
	
	protected $_modulo_nome = "Pedidos";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(137);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'aprovados';
		}
		
		// instancia
		$pedidos = new model_pedidos_classificados();
		
		$dados['incompletos'] = $pedidos->lista_incompletos();
		$dados['aguardando'] = $pedidos->lista_aguardando(); 
		$dados['aprovados'] = $pedidos->lista_aprovados(); 
		
		$this->view('pedidos_classificados', $dados);
	}
	
	public function detalhes(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Detalhes";

		$codigo = $this->get('codigo');

		$this->valida($codigo);

 		// instancia
		$pedidos = new model_pedidos_classificados();
		$cadastro = new model_cadastros();
		$valores = new model_valores();
		$forma_pg = new model_formas_pagamento();
		
		$dados['data'] = $pedidos->carrega($codigo);
		$dados['utilizados'] = $pedidos->utilizados($codigo);

		$dados['valor'] = $valores->trata_valor($dados['data']->plano_valor); 
		
		$dados['data_cadastro'] = $cadastro->carrega($dados['data']->cadastro);
		
		$dados['status'] = "";
		if($dados['data']->status == 0){
			$dados['status'] = "Incompleto";
		}
		if($dados['data']->status == 1){
			$dados['status'] = "Aguardando";
		}
		if($dados['data']->status == 2){
			$dados['status'] = "Completo";
		}

		$this->view('pedidos_classificados.detalhes', $dados);
	}

	public function ativar(){

		$dados['_base'] = $this->base(); 

		$codigo = $this->get('codigo');

		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos where codigo='$codigo' AND status<'2' ");				
		if($exec->num_rows == 1){

			$data_pedido = $exec->fetch_object();

			if($data_pedido->id){
				
				$db = new mysql();
				$db->alterar("classificados_pedidos",  array(
					"status"=>2
				), " codigo='$codigo' ");
				
				$this->msg('Pedido ativado com sucesso!');
				$this->volta(1);
				
			} else {
				$this->msg('Ocorreu um erro!');
				$this->volta(1);
			}
			
		} else {
			$this->msg('Ocorreu um erro!');
			$this->volta(1);
		}
	}

}	