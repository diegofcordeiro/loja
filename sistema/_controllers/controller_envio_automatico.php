<?php

class envio_automatico extends controller {
	
	protected $_modulo_nome = "";

	public function init(){
	}
	
	public function inicial(){
		echo "acesso negado!";
		exit;	
	}

	public function processar(){
		
		$envio = new model_envio();
		
		// carrega texto padrao para email de aviso		

		$db = new mysql();
		$exec_texto = $db->executar("SELECT conteudo FROM conteudos WHERE codigo='163657934464164' ");
		$data_texto = $exec_texto->fetch_object();
		$mensagem_do_email = $data_texto->conteudo;
		
		$db = new mysql();
		$exec = $db->executar("SELECT id, codigo, cadastro FROM pedido_loja where status='4' order by id asc");
		while($data = $exec->fetch_object()) {
			
			echo '<br><br>'.$data->id;
			
			$numero_itens_total = 0;
			$numero_itens_para_envio = 0;
			$texto_final = "";

			// lsita itens do carrinho
			$conexao = new mysql();
			$coisas_carrinho = $conexao->Executar("SELECT produto, tamanho, cor, variacao FROM pedido_loja_carrinho WHERE sessao='$data->codigo' ");
			$linha_carrinho = $coisas_carrinho->num_rows;

			if($linha_carrinho != 0){
				while($data_carrinho = $coisas_carrinho->fetch_object()){
					
					$conexao = new mysql();
					$coisas_produto = $conexao->Executar("SELECT id FROM produto WHERE codigo='$data_carrinho->produto' AND digital='1' AND digital_entrega='1' ");
					$linha_produto = $coisas_produto->num_rows;

					if($linha_produto == 1){

						echo " - $data_carrinho->produto: é digital";

						$conexao = new mysql();
						$coisas_entrega = $conexao->Executar("SELECT texto FROM produto_entrega_auto WHERE produto='$data_carrinho->produto' AND tamanho='$data_carrinho->tamanho' AND cor='$data_carrinho->cor' AND variacao='$data_carrinho->variacao' ");
						$linha_entrega = $coisas_entrega->num_rows;

	    					// verifica se existe o texto para envio
						if($linha_entrega != 0){

							$data_entrega = $coisas_entrega->fetch_object();

							if($data_entrega->texto){
								$numero_itens_para_envio++;
								$texto_final .= $data_entrega->texto;
								echo "- texto para entrega OK";
							} else {
								echo "- o texto para entrega esta em branco";
							}
						} else {
							echo "- nenhum registro de texto para entrega";
						}
					}

					$numero_itens_total++;
				}
			}


			if($numero_itens_para_envio > 0){    	 
				
				// pega o email do cliente
				$conexao = new mysql();
				$coisas_cadastro = $conexao->Executar("SELECT email FROM cadastro WHERE codigo='$data->cadastro' ");
				$data_cadastro = $coisas_cadastro->fetch_object();

				if(isset($data_cadastro->email)){

					$email_cliente = $data_cadastro->email;

					// envia o email								 
					$retorno = $envio->enviar("Nova mensagem no Pedido $data->id", $mensagem_do_email, array("0"=>"$email_cliente"));

					if($retorno == "Enviada com sucesso!"){

						$time = time();

						// grava mensagem
						$db = new mysql();
						$db->inserir("pedido_loja_mensagens", array(
							"pedido"=>$data->codigo,
							"usuario"=>'1',
							"data"=>$time,
							"msg"=>$texto_final,
							"lida"=>0
						));

						// confere se foi enviado todos os produtos
						if($numero_itens_total == $numero_itens_para_envio){				  

							// baixar do pedido se foi enviado todos os produtos

							$db = new mysql();
							$db->alterar("pedido_loja", array(
								"status"=>'6'
							), " codigo='$data->codigo' ");

						} else {
							
							// caso não foi enviado todos e ainda tem algum fisico						
							$db = new mysql();
							$db->alterar("pedido_loja", array(
								"status"=>'5'
							), " codigo='$data->codigo' ");

						}
					}
				}
			}

		}		 

	}

//termina classe
}