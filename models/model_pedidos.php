<?php

Class model_pedidos extends model{     
	
	public function lista($cod_usuario){
		
		$valores = new model_valores();
		
		$lista = array();
		$n = 0;
		
		//informaçoes do pedido
		$conexao = new mysql();
		$coisas_pedidos = $conexao->Executar("SELECT * FROM pedido_loja WHERE cadastro='$cod_usuario' AND status >= '0' order by data desc");
		$linha_pedido = $coisas_pedidos->num_rows;

		$i = 0;
        if($linha_pedido != 0){
        	while($data_pedido = $coisas_pedidos->fetch_object()){
				$conexao = new mysql();
				$coisas_carrinho = $conexao->Executar("SELECT COUNT(valor_total) as valor_total,* FROM pedido_loja_carrinho WHERE sessao='$data_pedido->codigo' group by id_combo ");
				
				while($data_carrinho = $coisas_carrinho->fetch_object()){
					
					$lista[$i]['id'] = $data_pedido->id;
				 	$lista[$i]['codigo'] = $data_pedido->codigo;
				 	$lista[$i]['data'] = date('d/m/y', $data_pedido->data);			
				 	$lista[$i]['valor_total'] = $valores->trata_valor($data_pedido->valor_total);
				 	$lista[$i]['status'] = $this->status($data_carrinho->status);
				 	$lista[$i]['charger_id'] = $data_pedido->transacao_charger_id;
				 	$lista[$i]['status_id'] = $data_carrinho->status;
				 	$lista[$i]['msg'] = $this->mensagens_n_lidas($data_pedido->codigo);

					$lista[$i]['sessao'] = $data_carrinho->sessao;
					$lista[$i]['combo_id'] = $data_carrinho->id_combo;
					$lista[$i]['produto_id'] = $data_carrinho->produto_id;
					$lista[$i]['produto_codigo'] = $data_carrinho->produto;
					$lista[$i]['produto_assinatura'] = $data_carrinho->produto_assinatura;
					$lista[$i]['produto_titulo'] = $data_carrinho->produto_titulo;
					$lista[$i]['produto_valor'] = $data_carrinho->produto_valor;
					$lista[$i]['valor_total_carrinho'] = $data_carrinho->valor_total;
					$lista[$i]['charger_id'] = $data_carrinho->transacao_charger_id;
					$lista[$i]['data_vencimento'] = $data_carrinho->data_vencimento;
					$lista[$i]['data_compra'] = $data_carrinho->data_compra;
					
					$i++;
				}
			}
			
		}
		$new_lista = array();
		foreach ($lista as $obj_lista) {
			$id_combo = $obj_lista['combo_id'];
			$id_combo = $id_combo == '' ? $obj_lista['id'] : $obj_lista['combo_id'];
			$sessao = $obj_lista['sessao'];

			if (!empty($new_lista[$sessao])){
				$new_lista[$sessao] = array_merge($new_lista[$sessao], array($obj_lista));
			}else{
				$new_lista[$sessao] = array($obj_lista);
			}
		}
echo '<pre>';print_r($new_lista);exit;

		// $final_lista_full = array();
		// foreach ($new_lista as $key => $obj_list) {
		// 	$final_lista = array();
		// 	foreach($obj_list as $obj_lista){
		// 		$id_combo = $obj_lista['combo_id'];
		// 		$id_combo = $id_combo == '' ? $obj_lista['id'] : $obj_lista['combo_id'];
		// 		if (!empty($final_lista[$id_combo])){
		// 			$final_lista[$id_combo] = array_merge($final_lista[$id_combo], array($obj_lista));
		// 		}else{
		// 			$final_lista[$id_combo] = array($obj_lista);
		// 		}
		// 	}
		// 	$final_lista_full[$key] = $final_lista;
			
		// }	

		return $new_lista;
	}	

	public function lista_produto_comprado($cod_usuario){
	
 		$lista = array();

		$conexao = new mysql();
		$coisas_pedidos = $conexao->Executar("SELECT * FROM pedido_loja WHERE cadastro='$cod_usuario'  order by data desc");
		$linha_pedido = $coisas_pedidos->num_rows;
		
        $i = 0;
        if($linha_pedido != 0){
        	while($data_pedido = $coisas_pedidos->fetch_object()){
				$conexao = new mysql();
				$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$data_pedido->codigo' AND status = '4' ");
				
				while($data_carrinho = $coisas_carrinho->fetch_object()){
					
					$lista[$i]['id'] = $data_carrinho->id;
					$lista[$i]['sessao'] = $data_carrinho->sessao;
					$lista[$i]['combo_id'] = $data_carrinho->id_combo;
					$lista[$i]['produto_id'] = $data_carrinho->produto_id;
					$lista[$i]['produto_codigo'] = $data_carrinho->produto;
					$lista[$i]['produto_assinatura'] = $data_carrinho->produto_assinatura;
					$lista[$i]['produto_titulo'] = $data_carrinho->produto_titulo;
					$lista[$i]['produto_valor'] = $data_carrinho->produto_valor;
					$lista[$i]['valor_total'] = $data_carrinho->valor_total;
					$lista[$i]['charger_id'] = $data_carrinho->transacao_charger_id;
					$lista[$i]['data_vencimento'] = $data_carrinho->data_vencimento;
					$lista[$i]['data_compra'] = $data_carrinho->data_compra;
					
					$i++;
				}
			}
			
		}	
		$new_lista = array();
		foreach ($lista as $obj_lista) {
			$id_combo = $obj_lista['combo_id'];
			$id_combo = $id_combo == '' ? $obj_lista['id'] : $obj_lista['combo_id'];
			if (!empty($new_lista[$id_combo])){
				$new_lista[$id_combo] = array_merge($new_lista[$id_combo], array($obj_lista));
			}else{
				$new_lista[$id_combo] = array($obj_lista);
			}
		}		
		// echo '<pre>';print_r($lista);exit;
		
 		
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
				$lista[$i]['id'] = $data_carrinho->id;
				$lista[$i]['tipo_envio'] = $data_carrinho->tipo_envio;
				$lista[$i]['id_combo'] = $data_carrinho->id_combo;
				$lista[$i]['combo_titulo'] = $data_carrinho->combo_titulo;
				$lista[$i]['combo_valor'] = $data_carrinho->valor_total_combo_vindi;
				$lista[$i]['usar_valor_vindi'] = $data_carrinho->usar_valor_vindi;


				
				if($data_carrinho->plano == 0){

        			// restrições
					if($produtos->restricao_produto($data_carrinho->produto) == 1){
						$restricoes = 1;
					}

        			// imagens
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
					
					$lista[$i]['digital'] = false;
					
				} else {
					
					// planos

					$lista[$i]['imagem'] = LAYOUT."img/semimagem.png";
					$titulo = "<div style='font-weight:bold;' >$data_carrinho->produto_titulo</div>";
					$lista[$i]['digital'] = true;

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

			$new = array();
			foreach ($lista as $list) {
				$combo = ($list['id_combo'] > 0 ? $list['id_combo'] : 0);
				if (!empty($new[$combo])){
					$new[$combo] = array_merge($new[$combo], array($list));
				}else{
					$new[$combo] = array($list);
				}
			}

			// foreach($new as $key => $linha){
			// 	$total_total = 0;
			// 	foreach($linha as $list){
			// 		if($list['usar_valor_vindi'] == 1){
			// 			$total_total = $list['combo_valor'];
			// 		}else{
			// 			$total_total = ($total_total + $list['total_unitario']);
			// 		}
			// 	}
			// 	$new[$key]['subtotal'] = $total_total;
			// }
			
			// echo'<pre>';print_r($new);exit;
			// $retorno['combo_list'] = $new;
			
			// echo'<pre>';print_r($new);exit; 
			$retorno['lista'] = $new;
			$retorno['subtotal_tratado'] = $valores->trata_valor($valor_subtotal);
 			$retorno['subtotal'] = $valor_subtotal;
 			$retorno['pedido'] = true;

		} else {

			$retorno['lista'] = $lista;
			$retorno['subtotal_tratado'] = '0,00';
 			$retorno['subtotal'] = 0;
 			$retorno['pedido'] = false;

		}
			 
 		// echo'<pre>';print_r($retorno);exit;
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