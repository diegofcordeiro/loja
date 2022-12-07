<?php

Class model_pedidos extends model{     
	
	public function lista($cod_usuario){
		
		$valores = new model_valores();
		
		$lista = array();
		$n = 0;
		
		//informaçoes do pedido
		$conexao = new mysql();
		$coisas_pedidos = $conexao->Executar("SELECT * FROM pedido_loja WHERE cadastro='$cod_usuario' AND status = '0' order by data desc");
		while($data_pedidos = $coisas_pedidos->fetch_object()){
			
			$lista[$n]['id'] = $data_pedidos->id;
			$lista[$n]['codigo'] = $data_pedidos->codigo;
			$lista[$n]['data'] = date('d/m/y', $data_pedidos->data);			
			$lista[$n]['valor_total'] = $valores->trata_valor($data_pedidos->valor_total);
			$lista[$n]['status'] = $this->status($data_pedidos->status);
			$lista[$n]['msg'] = $this->mensagens_n_lidas($data_pedidos->codigo);
			
        $n++;
		}
		
		return $lista;
	}	

	public function lista_produto_comprado($cod_usuario){
	
 		$lista = array();

		$conexao = new mysql();
		$coisas_pedidos = $conexao->Executar("SELECT * FROM pedido_loja WHERE cadastro='$cod_usuario' AND status in( '2', '1') order by data desc");
		$linha_pedido = $coisas_pedidos->num_rows;
		
        $i = 0;
        if($linha_pedido != 0){
        	while($data_pedido = $coisas_pedidos->fetch_object()){
				$conexao = new mysql();
				$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$data_pedido->codigo' ");
				
				while($data_carrinho = $coisas_carrinho->fetch_object()){
					
					$lista[$i]['id'] = $data_carrinho->id;
					$lista[$i]['sessao'] = $data_carrinho->sessao;
					$lista[$i]['produto_id'] = $data_carrinho->produto_id;
					$lista[$i]['produto_codigo'] = $data_carrinho->produto;
					$lista[$i]['produto_assinatura'] = $data_carrinho->produto_assinatura;
					$lista[$i]['produto_titulo'] = $data_carrinho->produto_titulo;
					$lista[$i]['produto_valor'] = $data_carrinho->produto_valor;
					$lista[$i]['valor_total'] = $data_carrinho->valor_total;
					$lista[$i]['data_vencimento'] = $data_carrinho->data_vencimento;
					$lista[$i]['data_compra'] = $data_carrinho->data_compra;
					
					$i++;
				}
			}
			
		}			 
		
 		
 		return $lista;
	}	

/////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function mensagens_n_lidas($codigo){
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja_mensagens WHERE pedido='$codigo' AND usuario='1' AND lida='0' ");
		return $exec->num_rows;
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function limpa_mensagens_n_lidas($codigo){
		
		$db = new mysql();
		$exec = $db->alterar("pedido_loja_mensagens", array(
		"lida"=>"1"
		), " pedido='$codigo' AND usuario='1' AND lida='0' ");		
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function lista_mensagens($pedido){
			
		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM pedido_loja_mensagens WHERE pedido='$pedido' order by data asc");
		while($data= $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['usuario'] = $data->usuario;
			$lista[$n]['data'] = date('d/m/y H:i', $data->data);			
			$lista[$n]['msg'] = $data->msg;

			if($data->anexo){
				$lista[$n]['anexo'] = PASTA_CLIENTE.'anexos_pedidos/'.$pedido.'/'.$data->anexo;
			} else {
				$lista[$n]['anexo'] = false;
			}

        $n++;
		}

		return $lista;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function status($codigo){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja_status WHERE codigo='$codigo' ");
		$linhas = $exec->num_rows;

		if($linhas != 0){

			$data = $exec->fetch_object();
			return $data->status;

		} else {
			return false;
		}		
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function forma_pagamento($id){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pagamento WHERE id='$id' ");
		$linhas = $exec->num_rows;
		
		if($linhas != 0){

			$data = $exec->fetch_object();
			return $data->titulo;
			
		} else {
			return false;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function forma_pagamento_dados($id){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pagamento WHERE id='$id' ");
		$linhas = $exec->num_rows;

		if($linhas != 0){

			return $exec->fetch_object();
			
		} else {
			return false;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////
	 	
 	public function produtos($codigo){
 		
 		$retorno = array();
 		$lista = array();
 		
 		// instancia
 		$produtos = new model_produtos();
 		$valores = new model_valores();

		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$codigo' ");
		$linha_carrinho = $coisas_carrinho->num_rows;
		
        $i = 0;
        $valor_subtotal = 0;

        if($linha_carrinho != 0){

        	while($data_carrinho = $coisas_carrinho->fetch_object()){

				$conexao = new mysql();
				$prod_id = $conexao->Executar("SELECT id FROM produto WHERE codigo='$data_carrinho->produto' ");
				$id_produto = $prod_id->fetch_object();
				// echo '<pre>'; print_r($data_carrinho->produto); exit;
				$lista[$i]['id_produto'] = $id_produto->id;
        		$lista[$i]['id'] = $data_carrinho->id;

        		$imagem = $produtos->imagens($data_carrinho->produto);
				if(!isset($imagem['imagem_principal'])){
					$lista[$i]['imagem'] = LAYOUT."img/semimagem.png";
				} else {
					$lista[$i]['imagem'] = $imagem['imagem_principal'];
				}

        		$titulo = "<div style='font-weight:bold;' >$data_carrinho->produto_titulo</div>";
				$titulo .= "<div style='font-size:13px;' >$data_carrinho->produto_subtitulo</div>";				
				if($data_carrinho->tamanho_titulo){ $titulo .= "<div style='font-size:13px;' >$data_carrinho->tamanho_titulo</div>"; }
				if($data_carrinho->cor_titulo){ $titulo .= "<div style='font-size:13px;' >$data_carrinho->cor_titulo</div>"; }
				if($data_carrinho->variacao_titulo){ $titulo .= "<div style='font-size:13px;' >$data_carrinho->variacao_titulo</div>"; }
									

				if($data_carrinho->tipoarte == 1){

					$conexao = new mysql();
					$coisas_artemod = $conexao->Executar("SELECT titulo FROM produto_modelos WHERE codigo='$data_carrinho->modelo_codigo' ");
					$data_artemod = $coisas_artemod->fetch_object();

					$titulo .= "<div style='font-size:13px;' >Arte: Modelo gratis - ".$data_artemod->titulo."</div>";

				}
				if($data_carrinho->tipoarte == 2){
					$titulo .= "<div style='font-size:13px;' >Arte: Criação - adicional R$ ".$valores->trata_valor($data_carrinho->valor_arte)."</div>";
				}
				if($data_carrinho->tipoarte == 3){
					$titulo .= "<div style='font-size:13px;' >Arte: Enviado pelo cliente</div>";
				}

				if($data_carrinho->arte_acabamento != 0){

					$conexao = new mysql();
					$coisas_acaba = $conexao->Executar("SELECT titulo FROM produto_acabamentos WHERE codigo='$data_carrinho->arte_acabamento' ");
					$data_acaba = $coisas_acaba->fetch_object();
					
					$titulo .= "<div style='font-size:13px;' >Acabamento: ".$data_acaba->titulo."</div>";
					
				}

				$lista[$i]['titulo'] = $titulo;

                $total_unitario = $data_carrinho->valor_total;
                $total_quantidade = $valores->trata_valor_calculo($total_unitario * $data_carrinho->quantidade);
                $valor_subtotal = $valor_subtotal + ($total_unitario * $data_carrinho->quantidade);

                $lista[$i]['total_unitario'] = $valores->trata_valor($total_unitario);
                $lista[$i]['quantidade'] = $data_carrinho->quantidade;
            	$lista[$i]['total_quantidade'] = $valores->trata_valor($total_quantidade);

				$i++;
			}

			$retorno['lista'] = $lista;
			$retorno['subtotal_tratado'] = $valores->trata_valor($valor_subtotal);
 			$retorno['subtotal'] = $valor_subtotal;
 			$retorno['pedido'] = true;

		} else {

			$retorno['lista'] = $lista;
			$retorno['subtotal_tratado'] = '0,00';
 			$retorno['subtotal'] = 0;
 			$retorno['pedido'] = false;

		}
			 
 		
 		return $retorno;
	}
 	
/////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function carrega($codigo){
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja WHERE codigo='$codigo' ");
		$linhas = $exec->num_rows;
		
		if($linhas != 0){
			
			return $exec->fetch_object();
			
		} else {
			return false;
		}		
	}

	
}