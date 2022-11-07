<?php

Class model_fretes extends model{     

	
	public function lista($cep_destino, $valor_subtotal, $cod_sessao, $selecionado = null){
		
		$valores = new model_valores();
		$produtos = new model_produtos();
		$consuta_cep = new model_cep();
		
		$lista = array();
		$i = 0;
		
		if($cep_destino){

			//////////////////////////////////////////////
			// calculo para peso dos produtos
			// caso não tenha produtos com cobrança de frete ou peso é gratis

			// calcula peso produtos
			$peso_total = 0;
			$itens = array();
			$itens_n = 0;
			
			
			$conexao = new mysql();
			$coisas_peso = $conexao->Executar("SELECT produto, quantidade, valor_total, plano FROM pedido_loja_carrinho WHERE sessao='$cod_sessao' ");
			while($data_peso = $coisas_peso->fetch_object()){

				if($data_peso->plano == 0){

					$data_produto = $produtos->carrega_produto_codigo($data_peso->produto);
					
					if($data_produto->digital == 0){

						if($data_produto->fretegratis != 1){

						// adiciona o minio de 10 gramas por produto
							if($data_produto->peso == 0){
								$peso = 1000;
							} else {
								$peso = $data_produto->peso;
							}
							
							$itens[$itens_n]['id'] = $data_produto->ref;
							$itens[$itens_n]['largura'] = $data_produto->largura;
							$itens[$itens_n]['altura'] = $data_produto->altura;
							$itens[$itens_n]['comprimento'] = $data_produto->comprimento;
							$itens[$itens_n]['peso'] = $peso / 1000;
							$itens[$itens_n]['valor'] =  $data_peso->valor_total;
							$itens[$itens_n]['quantidade'] = $data_peso->quantidade;						 
							
							$peso_total = $peso_total + ($peso * $data_peso->quantidade);

							$itens_n++;
						}
					}
				}
			}
			
			if($itens_n != 0){

				///////////////////////////////////////				
				// busca dados do cep
				$retorno_cep = $consuta_cep->retorno($cep_destino);

 				//confere estado
				$cep_estado = (string) $retorno_cep['uf'];
				$cep_cidade = (string) $retorno_cep['cidade'];

				if($cep_estado AND $cep_cidade){ // confere se reconheceu a cidade pelo cep

					/////////////////////////////////////////////////////////
					// lista de fretes disponiveis do painel
					$conexao = new mysql();
					$coisas_frete = $conexao->Executar("SELECT * FROM frete WHERE ativo='0' order by id desc ");
					while($data_frete = $coisas_frete->fetch_object()){

						////////////////////////////////////////////////////////////////////////////////
						// adiciona regras conforme tipo de entrega
						switch ($data_frete->id) {

							////////////////////////////////////
							// frete por correio pac

							case '1':

							$cep_origem = $data_frete->cep;
							$bloqueio = 0;
							$valor_frete_linha_retorno = 0;
							
							// gratis caso ultrapassar valor tal
							if( ($data_frete->gratis_acima_de <= $valor_subtotal) AND ($data_frete->gratis_acima_de > 0) ){
								
								$valor_frete_linha_retorno = 0;

							} else {

								//calculos basicos de acrescimo
								$percentual = $data_frete->acrescimo_porc / 100.0;
								$valor_frete_acresimo = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
								$valor_frete_linha_retorno = $data_frete->acrescimo_fixo + $valor_frete_acresimo;
								
								$fretefixo = false;
								$valor_frete_fixo = 0;

								if($cep_estado == 'AC'){
									if($data_frete->estado_tipo_AC == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AC;
									}
								}
								if($cep_estado == 'AL'){
									if($data_frete->estado_tipo_AL == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AL;
									}
								}
								if($cep_estado == 'AP'){
									if($data_frete->estado_tipo_AP == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AP;
									}
								}if($cep_estado == 'AM'){
									if($data_frete->estado_tipo_AM == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AM;
									}
								}
								if($cep_estado == 'BA'){
									if($data_frete->estado_tipo_BA == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_BA;
									}
								}
								if($cep_estado == 'CE'){
									if($data_frete->estado_tipo_CE == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_CE;
									}
								}
								if($cep_estado == 'DF'){
									if($data_frete->estado_tipo_DF == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_DF;
									}
								}
								if($cep_estado == 'ES'){
									if($data_frete->estado_tipo_ES == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_ES;
									}
								}
								if($cep_estado == 'GO'){
									if($data_frete->estado_tipo_GO == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_GO;
									}
								}
								if($cep_estado == 'MA'){
									if($data_frete->estado_tipo_MA == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MA;
									}
								}
								if($cep_estado == 'MT'){
									if($data_frete->estado_tipo_MT == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MT;
									}
								}
								if($cep_estado == 'MS'){
									if($data_frete->estado_tipo_MS == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MS;
									}
								}
								if($cep_estado == 'MG'){
									if($data_frete->estado_tipo_MG == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MG;
									}
								}
								if($cep_estado == 'PA'){
									if($data_frete->estado_tipo_PA == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PA;
									}
								}
								if($cep_estado == 'PB'){
									if($data_frete->estado_tipo_PB == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PB;
									}
								}
								if($cep_estado == 'PR'){
									if($data_frete->estado_tipo_PR == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PR; 
									}
								}
								if($cep_estado == 'PE'){
									if($data_frete->estado_tipo_PE == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PE;
									}
								}
								if($cep_estado == 'PI'){
									if($data_frete->estado_tipo_PI == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PI;
									}
								}
								if($cep_estado == 'RJ'){
									if($data_frete->estado_tipo_RJ == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RJ;
									}
								}
								if($cep_estado == 'RN'){
									if($data_frete->estado_tipo_RN == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RN;
									}
								}
								if($cep_estado == 'RS'){
									if($data_frete->estado_tipo_RS == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RS;
									}
								}
								if($cep_estado == 'RO'){
									if($data_frete->estado_tipo_RO == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RO;
									}
								}
								if($cep_estado == 'RR'){
									if($data_frete->estado_tipo_RR == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RR;
									}
								}
								if($cep_estado == 'SC'){
									if($data_frete->estado_tipo_SC == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_SC;
									}
								}
								if($cep_estado == 'SP'){
									if($data_frete->estado_tipo_SP == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_SP;
									}
								}
								if($cep_estado == 'SE'){
									if($data_frete->estado_tipo_SE == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_SE;
									}
								}
								if($cep_estado == 'TO'){
									if($data_frete->estado_tipo_TO == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_TO;
									}
								}
								
								if($fretefixo){
									// se tem frete fixo para o estado faz o calculo
									$valor_frete_linha_retorno = $valor_frete_linha_retorno + $valor_frete_fixo;						
								} else {
									
									$peso_total_frete = $peso_total;
									//se não calcula
									if($peso_total_frete != 0){
										
										//se não calcula pelo pagseguro
										if($peso_total_frete < 300){
											$peso_total_frete = 300;
										}

										$peso_tratado = number_format($peso_total_frete/1000, 1, '.', ',');
										$retorno = $this->calcular_frete_correios($cep_origem,$cep_destino,$peso_tratado,0,'41106');
										$valor_frete_retorno = $valores->trata_valor_banco($retorno->Valor);

										if($valor_frete_retorno == 0){
											$bloqueio = 1;
										}
										$valor_frete_linha_retorno = $valor_frete_linha_retorno + $valor_frete_retorno;

									}

								}

							}

							// bloqueia caso algo errado
							if($bloqueio == 0){

								if($data_frete->id == $selecionado){ $selected = true; } else { $selected = false; }

								$lista[$i]['id'] = $data_frete->id;
								$lista[$i]['id_unico'] = $data_frete->id;
								$lista[$i]['titulo'] = $data_frete->titulo_exibicao;
								$lista[$i]['selected'] = $selected;
								$lista[$i]['valor_frete'] = $valor_frete_linha_retorno;
								$lista[$i]['valor_frete_tratado'] = $valores->trata_valor($valor_frete_linha_retorno);
								$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
								$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);

								$i++;
							}

							break;



							////////////////////////////////////
							// frete por correio sedex

							case '2':

							$cep_origem = $data_frete->cep;
							$bloqueio = 0;
							$valor_frete_linha_retorno = 0;
							
							// gratis caso ultrapassar valor tal
							if( ($data_frete->gratis_acima_de <= $valor_subtotal) AND ($data_frete->gratis_acima_de > 0) ){
								
								$valor_frete_linha_retorno = 0;
								
							} else {
								
								//calculos basicos de acrescimo
								$percentual = $data_frete->acrescimo_porc / 100.0;
								$valor_frete_acresimo = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
								$valor_frete_linha_retorno = $data_frete->acrescimo_fixo + $valor_frete_acresimo;
								
								$fretefixo = false;
								$valor_frete_fixo = 0;

								if($cep_estado == 'AC'){
									if($data_frete->estado_tipo_AC == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AC;
									}
								}
								if($cep_estado == 'AL'){
									if($data_frete->estado_tipo_AL == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AL;
									}
								}
								if($cep_estado == 'AP'){
									if($data_frete->estado_tipo_AP == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AP;
									}
								}if($cep_estado == 'AM'){
									if($data_frete->estado_tipo_AM == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_AM;
									}
								}
								if($cep_estado == 'BA'){
									if($data_frete->estado_tipo_BA == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_BA;
									}
								}
								if($cep_estado == 'CE'){
									if($data_frete->estado_tipo_CE == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_CE;
									}
								}
								if($cep_estado == 'DF'){
									if($data_frete->estado_tipo_DF == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_DF;
									}
								}
								if($cep_estado == 'ES'){
									if($data_frete->estado_tipo_ES == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_ES;
									}
								}
								if($cep_estado == 'GO'){
									if($data_frete->estado_tipo_GO == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_GO;
									}
								}
								if($cep_estado == 'MA'){
									if($data_frete->estado_tipo_MA == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MA;
									}
								}
								if($cep_estado == 'MT'){
									if($data_frete->estado_tipo_MT == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MT;
									}
								}
								if($cep_estado == 'MS'){
									if($data_frete->estado_tipo_MS == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MS;
									}
								}
								if($cep_estado == 'MG'){
									if($data_frete->estado_tipo_MG == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_MG;
									}
								}
								if($cep_estado == 'PA'){
									if($data_frete->estado_tipo_PA == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PA;
									}
								}
								if($cep_estado == 'PB'){
									if($data_frete->estado_tipo_PB == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PB;
									}
								}
								if($cep_estado == 'PR'){
									if($data_frete->estado_tipo_PR == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PR; 
									}
								}
								if($cep_estado == 'PE'){
									if($data_frete->estado_tipo_PE == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PE;
									}
								}
								if($cep_estado == 'PI'){
									if($data_frete->estado_tipo_PI == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_PI;
									}
								}
								if($cep_estado == 'RJ'){
									if($data_frete->estado_tipo_RJ == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RJ;
									}
								}
								if($cep_estado == 'RN'){
									if($data_frete->estado_tipo_RN == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RN;
									}
								}
								if($cep_estado == 'RS'){
									if($data_frete->estado_tipo_RS == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RS;
									}
								}
								if($cep_estado == 'RO'){
									if($data_frete->estado_tipo_RO == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RO;
									}
								}
								if($cep_estado == 'RR'){
									if($data_frete->estado_tipo_RR == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_RR;
									}
								}
								if($cep_estado == 'SC'){
									if($data_frete->estado_tipo_SC == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_SC;
									}
								}
								if($cep_estado == 'SP'){
									if($data_frete->estado_tipo_SP == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_SP;
									}
								}
								if($cep_estado == 'SE'){
									if($data_frete->estado_tipo_SE == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_SE;
									}
								}
								if($cep_estado == 'TO'){
									if($data_frete->estado_tipo_TO == 1){
										$fretefixo = true;
										$valor_frete_fixo = $data_frete->estado_fixo_TO;
									}
								}
								
								if($fretefixo){
									// se tem frete fixo para o estado faz o calculo
									$valor_frete_linha_retorno = $valor_frete_linha_retorno + $valor_frete_fixo;						
								} else {
									
									$peso_total_frete = $peso_total;
									//se não calcula
									if($peso_total_frete != 0){
										
										//se não calcula pelo pagseguro
										if($peso_total_frete < 300){
											$peso_total_frete = 300;
										}

										$peso_tratado = number_format($peso_total_frete/1000, 1, '.', ',');
										$retorno = $this->calcular_frete_correios($cep_origem,$cep_destino,$peso_tratado,0,'40010');
										$valor_frete_retorno = $valores->trata_valor_banco($retorno->Valor);
										
										if($valor_frete_retorno == 0){
											$bloqueio = 1;
										}
										$valor_frete_linha_retorno = $valor_frete_linha_retorno + $valor_frete_retorno;
										
									}

								}

							}

							// bloqueia caso algo errado
							if($bloqueio == 0){

								if($data_frete->id == $selecionado){ $selected = true; } else { $selected = false; }

								$lista[$i]['id'] = $data_frete->id;
								$lista[$i]['id_unico'] = $data_frete->id;
								$lista[$i]['titulo'] = $data_frete->titulo_exibicao;
								$lista[$i]['selected'] = $selected;
								$lista[$i]['valor_frete'] = $valor_frete_linha_retorno;
								$lista[$i]['valor_frete_tratado'] = $valores->trata_valor($valor_frete_linha_retorno);
								$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
								$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);

								$i++;
							}

							break;



							////////////////////////////////////
							// retirada no local

							case '3':

							if($data_frete->id == $selecionado){ $selected = true; } else { $selected = false; }

							$lista[$i]['id'] = $data_frete->id;
							$lista[$i]['id_unico'] = $data_frete->id;
							$lista[$i]['titulo'] = $data_frete->titulo_exibicao;
							$lista[$i]['selected'] = $selected;
							$lista[$i]['valor_frete'] = 0;
							$lista[$i]['valor_frete_tratado'] = '0,00';
							$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
							$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);

							$i++;

							break;



							////////////////////////////////////
							// transportadora padrao

							case '4':

							// gratis caso ultrapassar valor tal
							if( ($data_frete->gratis_acima_de <= $valor_subtotal) AND ($data_frete->gratis_acima_de > 0) ){
								
								if($data_frete->id == $selecionado){ $selected = true; } else { $selected = false; }

								//calculos basicos de acrescimo
								$percentual = $data_frete->acrescimo_porc / 100.0;
								$valor_frete_acresimo = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
								$valor_frete_linha_retorno = $data_frete->acrescimo_fixo + $valor_frete_acresimo;

								$lista[$i]['id'] = $data_frete->id;
								$lista[$i]['id_unico'] = $data_frete->id;
								$lista[$i]['titulo'] = $data_frete->titulo_exibicao;
								$lista[$i]['selected'] = $selected;
								$lista[$i]['valor_frete'] = $valor_frete_linha_retorno;
								$lista[$i]['valor_frete_tratado'] = $valores->trata_valor($valor_frete_linha_retorno);
								$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
								$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);

								$i++;
								
							} else {
 							// frete gratis acima de valor

								if($data_frete->id == $selecionado){ $selected = true; } else { $selected = false; }

								$lista[$i]['id'] = $data_frete->id;
								$lista[$i]['id_unico'] = $data_frete->id;
								$lista[$i]['titulo'] = $data_frete->titulo_exibicao;
								$lista[$i]['selected'] = $selected;
								$lista[$i]['valor_frete'] = 0;
								$lista[$i]['valor_frete_tratado'] = $valores->trata_valor(0);
								$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
								$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);

								$i++;

							}

							break;


							////////////////////////////////////
							// melhor envios

							case '5':

							$melhor_envio = new model_melhor_envio();
							$retornofrete = $melhor_envio->calculo_produtos($data_frete->cep, $cep_destino, $itens);

							foreach ($retornofrete as $key_me => $value_me) {

								$id_unico = $data_frete->id.'_'.$value_me['id'];

								if($id_unico == $selecionado){
									$selected = true;
								} else {
									$selected = false;
								}

								$lista[$i]['id'] = $data_frete->id;
								$lista[$i]['id_unico'] = $id_unico;
								$lista[$i]['id_me'] = $value_me['id'];
								$lista[$i]['titulo'] = 'Melhor Envio - '.$value_me['titulo'];
								$lista[$i]['selected'] = $selected;

								if( ($data_frete->gratis_acima_de <= $valor_subtotal) AND ($data_frete->gratis_acima_de > 0) ){
									$lista[$i]['valor_frete'] = 0;
									$lista[$i]['valor_frete_tratado'] = $valores->trata_valor(0);
								} else {
									$lista[$i]['valor_frete'] = $value_me['valor'];
									$lista[$i]['valor_frete_tratado'] = $valores->trata_valor($value_me['valor']);
								}
								
								$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
								$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);
								$lista[$i]['obs'] = $value_me['obs'];

								$i++;

							}

							break;


							////////////////////////////////////
							// entrega local

							default:

							if($cep_cidade == $data_frete->proximidade_cidade){

 								// gratis caso ultrapassar valor tal
								if( ($data_frete->gratis_acima_de <= $valor_subtotal) AND ($data_frete->gratis_acima_de > 0) ){

									if($data_frete->id == $selecionado){ $selected = true; } else { $selected = false; }

									$lista[$i]['id'] = $data_frete->id;
									$lista[$i]['id_unico'] = $data_frete->id;
									$lista[$i]['titulo'] = $data_frete->titulo_exibicao;
									$lista[$i]['selected'] = $selected;
									$lista[$i]['valor_frete'] = 0;
									$lista[$i]['valor_frete_tratado'] = $valores->trata_valor(0);
									$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
									$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);

									$i++;

								} else {

									if($data_frete->id == $selecionado){ $selected = true; } else { $selected = false; }

									//calculos basicos de acrescimo
									$percentual = $data_frete->acrescimo_porc / 100.0;
									$valor_frete_acresimo = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
									$valor_frete_linha_retorno = $data_frete->acrescimo_fixo + $valor_frete_acresimo;

									$lista[$i]['id'] = $data_frete->id;
									$lista[$i]['id_unico'] = $data_frete->id;
									$lista[$i]['titulo'] = $data_frete->titulo_exibicao;
									$lista[$i]['selected'] = $selected;
									$lista[$i]['valor_frete'] = $valor_frete_linha_retorno;
									$lista[$i]['valor_frete_tratado'] = $valores->trata_valor($valor_frete_linha_retorno);
									$lista[$i]['gratis_acima_de'] = $data_frete->gratis_acima_de;
									$lista[$i]['gratis_acima_de_tratado'] = $valores->trata_valor($data_frete->gratis_acima_de);

									$i++;

								}
							}

							break;


						} // termina

					} // while

				}

			} else {

				// caso não tenha itens para cobrança de frete fica gratuito

				if($selecionado == 99999){ $selected = true; } else { $selected = false; }

				$lista[0]['id'] = 99999;
				$lista[0]['titulo'] = 'Frete Gratis';
				$lista[0]['id_unico'] = '99999';
				$lista[0]['selected'] = $selected;
				$lista[0]['valor_frete'] = 0;
				$lista[0]['valor_frete_tratado'] = '0,00';
				$lista[0]['gratis_acima_de'] = 0;
				$lista[0]['gratis_acima_de_tratado'] = $valores->trata_valor(0);

			}

		}


		// echo "<pre>"; print_r($lista); echo "</pre>"; exit;

		return $lista;
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//


	public function carrega($codigo){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM frete WHERE id='$codigo' ");
		$linhas = $exec->num_rows;

		if($linhas != 0){			
			return $exec->fetch_object();
		} else {
			return false;
		}		
	}


	public function carrega_balcao($codigo){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM balcoes WHERE codigo='$codigo' ");
		$linhas = $exec->num_rows;

		if($linhas != 0){			
			return $exec->fetch_object();
		} else {
			return false;
		}		
	}

	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// calculo de frete direto do correio

	private function calcular_frete_correios($cep_origem,
		$cep_destino,
		$peso,
		$valor,
		$tipo_do_frete,
		$altura = 20,
		$largura = 20,
		$comprimento = 20){

		$valores = new model_valores();
		$valor_confere = $valores->trata_valor_banco($valor);
		if($valor_confere <= 21){
			$valor = '21,00';
		}

		$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
		$url .= "nCdEmpresa=";
		$url .= "&sDsSenha=";
		$url .= "&sCepOrigem=" . $cep_origem;
		$url .= "&sCepDestino=" . $cep_destino;
		$url .= "&nVlPeso=" . $peso;
		$url .= "&nVlLargura=" . $largura;
		$url .= "&nVlAltura=" . $altura;
		$url .= "&nCdFormato=1";
		$url .= "&nVlComprimento=" . $comprimento;
		$url .= "&sCdMaoProria=n";
		$url .= "&nVlValorDeclarado=" . $valor;
		$url .= "&sCdAvisoRecebimento=n";
		$url .= "&nCdServico=" . $tipo_do_frete;
		$url .= "&nVlDiametro=0";
		$url .= "&StrRetorno=xml";

	 	// tipo do frete
	    //Sedex: 40010
	    //Pac: 41106

		$xml = simplexml_load_file($url);

		return $xml->cServico; 
	}
 	// utilização
 	// $val = (calcular_frete('27410200','37500410',2,1000,'41106'));
 	// echo "Valor PAC: R$ ".$val->Valor;


	public function lista_balcoes(){

		$valores = new model_valores();
		
		$lista = array();
		$i = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM balcoes order by titulo asc ");
		while($data = $coisas->fetch_object()){

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['valor'] = $data->valor;
			$lista[$i]['valor_tratado'] = $valores->trata_valor($data->valor);
			
			$i++;
		}
		
		return $lista;
	}




}