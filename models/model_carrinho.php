<?php

Class model_carrinho extends model{     


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


	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function carrinho($cod_sessao){

		$retorno = array();
		$lista = array();
		$restricoes = 0;
		
 		// instancia
		$produtos = new model_produtos();
		$valores = new model_valores();
		
		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$cod_sessao' ");
		$linha_carrinho = $coisas_carrinho->num_rows;
		
		$i = 0;
		$valor_subtotal = 0;
		
		if($linha_carrinho != 0){
			
			while($data_carrinho = $coisas_carrinho->fetch_object()){
				$lista[$i]['id'] = $data_carrinho->id;
				$lista[$i]['tipo_envio'] = $data_carrinho->tipo_envio;
				$lista[$i]['id_combo'] = $data_carrinho->id_combo;
				$lista[$i]['combo_titulo'] = $data_carrinho->combo_titulo;
				
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
				// echo'<pre>';print_r($list['id_combo']);exit;
				
				$combo = ($list['id_combo'] > 0 ? $list['id_combo'] : 0);

				if (!empty($new[$combo])){
					$new[$combo] = array_merge($new[$combo], array($list));
				}else{
					$new[$combo] = array($list);
				}
			}

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

		$retorno['restricoes'] = $restricoes;

		return $retorno;
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//


	public function itens_carrinho($cod_sessao){ 	 

		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$cod_sessao' ");
		$linha_carrinho = $coisas_carrinho->num_rows; 

		return $linha_carrinho;
	}



}