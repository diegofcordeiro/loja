<?php

class relatorios extends controller {
	
	protected $_modulo_nome = "Relatórios";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(84);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		
		$dados['resultado'] = false;

		$status = $this->post('status');
		$inicio = $this->post('inicio');
		$fim = $this->post('fim');

		if($inicio AND $fim AND $status){

			$dados['inicio'] = $inicio;
			$dados['fim'] = $fim;

			$dados['resultado'] = true;

			$arraydata = explode("/", $inicio);
			$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." 00:00:00";
			$data_inicial = strtotime($hora_montada);

			$arraydata = explode("/", $fim);
			$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." 23:59:59";
			$data_final = strtotime($hora_montada);

			// pesquisar pedidos no periodo

			$valores = new model_valores();
			$cadastro = new model_cadastros();

			$db = new mysql();
			if($status == 'todos'){
				$exec = $db->executar("SELECT id, codigo, data, valor_total, status, cadastro FROM pedido_loja where status!='0' AND data>='$data_inicial' AND data<='$data_final' order by data desc");
			} else {
				$exec = $db->executar("SELECT id, codigo, data, valor_total, status, cadastro FROM pedido_loja where status='$status' AND data>='$data_inicial' AND data<='$data_final' order by data desc");
			}
			$i = 0;
			$retorno = array();
			$valor_total_periodo = 0;
			while($data = $exec->fetch_object()){

				if($data->cadastro){

					$db = new mysql();
					$exec_cadastro = $db->executar("SELECT id, tipo, fisica_nome, juridica_nome, email FROM cadastro where codigo='$data->cadastro' ");
					$data_cadastro = $exec_cadastro->fetch_object();

					if( isset($data_cadastro->id) ){

						if($data_cadastro->tipo == 'F'){
							$retorno[$i]['nome'] = $data_cadastro->fisica_nome;
						} else {
							$retorno[$i]['nome'] = $data_cadastro->juridica_nome;
						}

					} else {
						$retorno[$i]['nome'] = "Cadastro não identificado";
					}

					$retorno[$i]['email'] = $data_cadastro->email;

					$retorno[$i]['id'] = $data->id;
					$retorno[$i]['codigo'] = $data->codigo;
					$retorno[$i]['data'] = date('d/m/y H:i', $data->data);
					$retorno[$i]['valor'] = $valores->trata_valor($data->valor_total);

					$valor_total_periodo = $valor_total_periodo+$data->valor_total;
					
					// status
					$db = new mysql();
					$exec_status = $db->executar("SELECT status FROM pedido_loja_status where codigo='$data->status' ");
					$data_status = $exec_status->fetch_object();
					
					$retorno[$i]['status'] = $data_status->status;
					
				$i++;
				}
			}
			
			$dados['lista'] = $retorno;
			$dados['valor_total_periodo'] = $valores->trata_valor($valor_total_periodo);
			
		} else {
			
			$status = 1;
			$dados['inicio'] = date('d/m/Y', strtotime('-30 days'));
			$dados['fim'] = date('d/m/Y');
			
		}
		
		
		// lista status
		$pedidos = new model_pedidos();
		$dados['lista_status'] = $pedidos->lista_status($status);


		$this->view('relatorios', $dados);
	}
	

}