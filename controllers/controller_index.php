<?php

class index extends controller {
	
	public function init(){
		$this->inicializacao();
		
	}
	
	public function inicial(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;
	
		// lista_produto_comprado
		if($dados['_nome_usuario'] != 'Visitante'){ 
			
			$pedidos = new model_pedidos();
			$lista_minhas_compras = $pedidos->lista_produto_comprado($dados['_cod_usuario']);

			if(count($lista_minhas_compras) > 0){
				$in_ids = '';
				foreach($lista_minhas_compras as $key => $curso){
					$point = (count($lista_minhas_compras)==1 || $key == 0) ? '' : ',';
					$in_ids .= $point.$curso['produto_codigo'];
					
				}
				
				$conexao = new mysql();
				$result_comprados = $conexao->query("SELECT distinct 
										autor.nome as autor_nome,
										produto.*,
										t1.imagem
										FROM loja.produto 
										inner join loja.autor on produto.autor = autor.id
										inner join loja.produto_canal ON produto.codigo=produto_canal.id_produto 
										inner join (select max(id) id, codigo, imagem from loja.produto_imagem group by codigo) t1 on produto.codigo=t1.codigo
										AND produto.status = 1
										WHERE produto.codigo in ($in_ids)
										order by produto.id desc;");
				$new_comprados = array();
				while ($obj_novidades = $result_comprados->fetch_object()) {
					$new_comprados = array_merge($new_comprados,array($obj_novidades));
				}
			}
		}
		
		// itens da inicial
		$chave = $this->_layout;
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' AND status='1' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;
		
		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$dados['banner_popup'] = array();
		if($codigo_pagina == 1){
			// banner por cima da tela
			$banners = new model_banners();
			$dados['banner_popup'] = $banners->lista_simples('148713351986017'); 
		}

		// banners laterais
		$banners = new model_banners();
		$dados['banners_esquerda'] = $banners->lista_simples('148713350186607');
		$dados['banners_direita'] = $banners->lista_simples('148841831030374');

		////////////////////////////////////////////////////////////////////////
		//busca para todos
		$busca_padrao = $this->get('busca');
		////////////////////////////////////////////////////////////////////////
		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key_ordemm => $value_bloco_principal){
				
				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value_bloco_principal' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;
					$lista_blocos[$n_bloc]['cor_fundo'] = $data_bloco->cor_fundo;

					
					$lista_blocos[$n_bloc]['img_fundo'] = $data_bloco->img_fundo;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}
								// echo'<pre>';print_r($lista_layout);exit;
								if($data->tipo == 'acordeon'){
									$acordeon = new model_acordeon();
									$lista_layout['conteudo'] = $acordeon->lista($data->codigo);
								}

								if($data->tipo == 'banner'){
									$banners = new model_banners();
									$lista_layout['conteudo'] = $banners->lista($data->codigo);
								}

								if($data->tipo == 'conteudos_blocos'){							
									$conteudos_blocos = new model_conteudos_blocos();
									$lista_layout['conteudo'] = $conteudos_blocos->carregar($data->codigo);
								}

								if($data->tipo == 'rastreamento'){							
									$rastreamento = new model_rastreamento();
									$lista_layout['conteudo'] = $rastreamento->carregar($data->codigo);
								}

								if($data->tipo == 'cadastro_email'){
									$cadastro_email = new model_cadastro_email();
									$lista_layout['conteudo'] = $cadastro_email->carregar($data->codigo);
								}

								if($data->tipo == 'cadastro_fone'){							
									$cadastro_fone = new model_cadastro_fone();
									$lista_layout['conteudo'] = $cadastro_fone->carregar($data->codigo);
								}

								if($data->tipo == 'cadastro'){							
									$cadastro = new model_cadastro();
									$lista_layout['conteudo'] = $cadastro->carregar($data->codigo);
									$estados_cidades = new model_estados_cidades();
									$lista_layout['conteudo']['estados'] = $estados_cidades->lista_estados();
								}

								if($data->tipo == 'caracteristicas'){
									$caracteristicas = new model_caracteristicas();
									$lista_layout['conteudo'] = $caracteristicas->lista($data->codigo);
								}

								if($data->tipo == 'contador'){
									$contador = new model_contador();
									$lista_layout['conteudo'] = $contador->lista($data->codigo);
								}

								if($data->tipo == 'destaques'){
									$destaques = new model_destaques();
									$lista_layout['conteudo'] = $destaques->lista($data->codigo);
								}

								if($data->tipo == 'contato'){							
									$contato = new model_contato();
									$lista_layout['conteudo'] = $contato->carregar($data->codigo);
								}

								if($data->tipo == 'equipe'){
									$equipe = new model_equipe();
									$lista_layout['conteudo'] = $equipe->lista($data->codigo);
								}

								if($data->tipo == 'postagens'){

									$postagens = new model_postagens();
									$id_var = $modulo_id;
									$postagens->controller_name = $this->_controller;
									$postagens->id_var = $id_var;

									if($busca_padrao){
										$postagens->busca = $busca_padrao;
									}

									if($this->get('busca_'.$id_var)){ $postagens->busca = $this->get('busca_'.$id_var); }
									if($this->get('categoria_'.$id_var)){ $postagens->categoria = $this->get('categoria_'.$id_var); }
									if($this->get('startitem_'.$id_var)){ $postagens->startitem = $this->get('startitem_'.$id_var); }
									if($this->get('startpage_'.$id_var)){ $postagens->startpage = $this->get('startpage_'.$id_var); }
									if($this->get('endpage_'.$id_var)){ $postagens->endpage = $this->get('endpage_'.$id_var); }
									if($this->get('reven_'.$id_var)){ $postagens->reven = $this->get('reven_'.$id_var); }
									$lista_layout['conteudo'] = $postagens->lista($data->codigo);

								}

								if($data->tipo == 'planos'){
									$planos = new model_planos();
									$lista_layout['conteudo'] = $planos->lista($data->codigo);
								}

								if($data->tipo == 'depoimentos'){
									$depoimentos = new model_depoimentos();
									$lista_layout['conteudo'] = $depoimentos->lista($data->codigo);
								}

								if($data->tipo == 'duvidas'){							
									$duvidas = new model_duvidas();
									$lista_layout['conteudo'] = $duvidas->lista($data->codigo);
								}

								if($data->tipo == 'parceiros'){
									$parceiros = new model_parceiros();
									$lista_layout['conteudo'] = $parceiros->lista($data->codigo);
								}

								if($data->tipo == 'enquete'){							
									$enquete = new model_enquetes();
									$lista_layout['conteudo'] = $enquete->carregar($data->codigo);
								}

								if($data->tipo == 'servicos'){							
									$servicos = new model_servicos();
									$lista_layout['conteudo'] = $servicos->lista($data->codigo);
								}

								if($data->tipo == 'filiais'){							
									$filiais = new model_filiais();
									$lista_layout['conteudo'] = $filiais->lista($data->codigo);
								}

								if($data->tipo == 'videos'){							
									$videos = new model_videos();
									$lista_layout['conteudo'] = $videos->lista($data->codigo);
								}

								if($data->tipo == 'audios'){							
									$audios = new model_audios();
									$lista_layout['conteudo'] = $audios->lista($data->codigo);
								}

								if($data->tipo == 'fotos'){							
									$fotos = new model_fotos();
									$lista_layout['conteudo'] = $fotos->lista($data->codigo);
								}

								if($data->tipo == 'revistajornal'){							
									$revistas = new model_revistas();
									$lista_layout['conteudo'] = $revistas->lista($data->codigo);
								}

								if($data->tipo == 'produtos'){

									$produtos = new model_produtos();
									$id_var = $modulo_id;
									$produtos->controller_name = $this->_controller;
									$produtos->id_var = $id_var;

									if($busca_padrao){
										$produtos->busca = $busca_padrao;
									}

									if($this->get('busca')){ $produtos->busca = $this->get('busca'); }
									if($this->get('categoria_'.$id_var)){ $produtos->categoria = $this->get('categoria_'.$id_var); }
									if($this->get('prod_categoria')){ $produtos->categoria = $this->get('prod_categoria'); }
									if($this->get('marca_'.$id_var)){ $produtos->marca = $this->get('marca_'.$id_var); }
									if($this->get('prod_marca')){ $produtos->marca = $this->get('prod_marca'); }
									if($this->get('startitem_'.$id_var)){ $produtos->startitem = $this->get('startitem_'.$id_var); }
									if($this->get('startpage_'.$id_var)){ $produtos->startpage = $this->get('startpage_'.$id_var); }
									if($this->get('endpage_'.$id_var)){ $produtos->endpage = $this->get('endpage_'.$id_var); }
									if($this->get('reven_'.$id_var)){ $produtos->reven = $this->get('reven_'.$id_var); }
									if($this->get('ordem_'.$id_var)){ $produtos->ordem = $this->get('ordem_'.$id_var); }

									$lista_layout['conteudo'] = $produtos->lista($data->codigo);

								}

								if($data->tipo == 'widgets'){							
									$widgets = new model_widgets();
									$lista_layout['conteudo'] = $widgets->carregar($data->codigo);
								}

								if($data->tipo == 'imoveis'){

									$imoveis = new model_imoveis();
									$id_var = $modulo_id;
									$imoveis->controller_name = $this->_controller;
									$imoveis->id_var = $id_var;

									if($busca_padrao){
										$imoveis->busca = $busca_padrao;
									}

									if($this->get('imo_ref')){ $imoveis->busca = $this->get('imo_ref'); }
									if($this->get('imo_cat')){ $imoveis->categoria = $this->get('imo_cat'); }
									if($this->get('imo_tipo')){ $imoveis->tipo = $this->get('imo_tipo'); }
									if($this->get('imo_cidade')){ $imoveis->cidade = $this->get('imo_cidade'); }
									if($this->get('imo_bairro')){ $imoveis->bairro = $this->get('imo_bairro'); }
									if($this->get('imo_dorm')){ $imoveis->dormitorios = $this->get('imo_dorm'); }
									if($this->get('imo_suites')){ $imoveis->suites = $this->get('imo_suites'); }
									if($this->get('imo_gara')){ $imoveis->garagens = $this->get('imo_gara'); }

									if($this->get('imo_val_max')){ $imoveis->valor_max = $this->get('imo_val_max'); }
									if($this->get('imo_val_min')){ $imoveis->valor_min = $this->get('imo_val_min'); }

									if($this->get('imo_ordem')){ $imoveis->ordem = $this->get('imo_ordem'); }

									if($this->get('startitem_'.$id_var)){ $imoveis->startitem = $this->get('startitem_'.$id_var); }
									if($this->get('startpage_'.$id_var)){ $imoveis->startpage = $this->get('startpage_'.$id_var); }
									if($this->get('endpage_'.$id_var)){ $imoveis->endpage = $this->get('endpage_'.$id_var); }
									if($this->get('reven_'.$id_var)){ $imoveis->reven = $this->get('reven_'.$id_var); }

									$lista_layout['conteudo'] = $imoveis->lista($data->codigo);

									$dados['imo_tipo_busca'] = $this->get('imo_tipo_busca');


									$dados['imo_alugar_valor_min'] = 700;
									$dados['imo_alugar_valor_max'] = 50000;

									$dados['imo_comprar_valor_min'] = 10000;
									$dados['imo_comprar_valor_max'] = 10000000;

									if($this->get('imo_cat') == '5280'){

										if($this->get('imo_val_min')){ $dados['imo_alugar_valor_min'] = $this->get('imo_val_min'); }
										if($this->get('imo_val_max')){ $dados['imo_alugar_valor_max'] = $this->get('imo_val_max'); }

									} else {

										if($this->get('imo_val_min')){ $dados['imo_comprar_valor_min'] = $this->get('imo_val_min'); }
										if($this->get('imo_val_max')){ $dados['imo_comprar_valor_max'] = $this->get('imo_val_max'); }

									}

								}

								if($data->tipo == 'garagem'){

									$garagem = new model_garagem();
									$id_var = $modulo_id;
									$garagem->controller_name = $this->_controller;
									$garagem->id_var = $id_var;
									
									if($busca_padrao){
										$garagem->busca = $busca_padrao;
									}

									if($this->get('gara_busca')){ $garagem->busca = $this->get('gara_busca'); }
									if($this->get('gara_tipo')){ $garagem->tipo = $this->get('gara_tipo'); }
									if($this->get('gara_cat')){ $garagem->categoria = $this->get('gara_cat'); }
									if($this->get('gara_marca')){ $garagem->marca = $this->get('gara_marca'); }
									if($this->get('gara_modelo')){ $garagem->modelo = $this->get('gara_modelo'); }
									if($this->get('gara_combustivel')){ $garagem->combustivel = $this->get('gara_combustivel'); }
									if($this->get('gara_transmissao')){ $garagem->transmissao = $this->get('gara_transmissao'); }
									if($this->get('gara_cor')){ $garagem->cor = $this->get('gara_cor'); }
									if($this->get('gara_motor')){ $garagem->motor = $this->get('gara_motor'); } 

									if($this->get('gara_val_max')){ $garagem->valor_max = $this->get('gara_val_max'); }
									if($this->get('gara_val_min')){ $garagem->valor_min = $this->get('gara_val_min'); }

									if($this->get('gara_ano_fab')){ $garagem->ano_fab = $this->get('gara_ano_fab'); }
									if($this->get('gara_ano_mod')){ $garagem->ano_mod = $this->get('gara_ano_mod'); }
									
									if($this->get('gara_ordem')){ $garagem->ordem = $this->get('gara_ordem'); }
									
									if($this->get('startitem_'.$id_var)){ $garagem->startitem = $this->get('startitem_'.$id_var); }
									if($this->get('startpage_'.$id_var)){ $garagem->startpage = $this->get('startpage_'.$id_var); }
									if($this->get('endpage_'.$id_var)){ $garagem->endpage = $this->get('endpage_'.$id_var); }
									if($this->get('reven_'.$id_var)){ $garagem->reven = $this->get('reven_'.$id_var); }
									
									$lista_layout['conteudo'] = $garagem->lista($data->codigo);


									$dados['gara_tipo_busca'] = $this->get('gara_tipo_busca');									
									$dados['gara_valor_min'] = 10000;
									$dados['gara_valor_max'] = 10000000;

								}

								if($data->tipo == 'classificados'){

									$classificados = new model_classificados();
									$id_var = $modulo_id;
									$classificados->controller_name = $this->_controller;
									$classificados->id_var = $id_var;

									if($busca_padrao){
										$classificados->busca = $busca_padrao;
									}

									if($this->get('cla_ref')){ $classificados->busca = $this->get('cla_ref'); }
									if($this->get('cla_cat')){ $classificados->categoria = $this->get('cla_cat'); }
									if($this->get('cla_cidade')){ $classificados->cidade = $this->get('cla_cidade'); }
									if($this->get('cla_bairro')){ $classificados->bairro = $this->get('cla_bairro'); }

									if($this->get('cla_val_max')){ $classificados->valor_max = $this->get('cla_val_max'); }
									if($this->get('cla_val_min')){ $classificados->valor_min = $this->get('cla_val_min'); }

									if($this->get('cla_ordem')){ $classificados->ordem = $this->get('cla_ordem'); }

									if($this->get('startitem_'.$id_var)){ $classificados->startitem = $this->get('startitem_'.$id_var); }
									if($this->get('startpage_'.$id_var)){ $classificados->startpage = $this->get('startpage_'.$id_var); }
									if($this->get('endpage_'.$id_var)){ $classificados->endpage = $this->get('endpage_'.$id_var); }
									if($this->get('reven_'.$id_var)){ $classificados->reven = $this->get('reven_'.$id_var); }

									$opcoes_array = array();
									$n_op = 0;
									$opcoes = $classificados->lista_opcoes();
									foreach ($opcoes as $key_op => $value_op) {
										foreach ($value_op['opcoes'] as $key_op2 => $value_op2) {
											if($this->get('cla_op_'.$value_op2['id']) == 1){
												$opcoes_array[$n_op] = $value_op2['codigo'];
												$n_op++;
											}
										}
									}
									if($n_op != 0){ $classificados->opcoes = $opcoes_array; }

									$lista_layout['conteudo'] = $classificados->lista($data->codigo);

									$dados['cla_tipo_busca'] = $this->get('cla_tipo_busca');

									$dados['cla_valor_min'] = 50;
									$dados['cla_valor_max'] = 1000;

									if($this->get('cla_val_min')){ $dados['cla_valor_min'] = $this->get('cla_val_min'); }
									if($this->get('cla_val_max')){ $dados['cla_valor_max'] = $this->get('cla_val_max'); }

								}


								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}





								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$query = null;
		$inner = null;
		$campo = null;
		// print_r($_POST);
		if($_POST['autor']){
			if($_POST['autor'] == 0){
				$query = '';
				$inner = '';
				$campo = '';
			}else{
				$id_autor = $_POST['autor'];
				$query .= " AND autor.id = $id_autor ";
			}
		}
		if($_POST['categoria']){
			if($_POST['categoria'] == 0){
				$query = '';
				$inner = '';
				$campo = '';
			}else{
				$id_categoria = $_POST['categoria'];
				$campo .= " produto_categoria.id as categoria_id, produto_categoria.titulo as categoria, ";
				$inner .= " inner join produto_categoria_sel on produto_categoria_sel.produto_codigo = produto.codigo
							inner join produto_categoria on produto_categoria.codigo = produto_categoria_sel.categoria_codigo ";
				$query .= " AND produto_categoria.id = $id_categoria ";
			}
		}
		if($_POST['estrelas']){
			$estrela = $_POST['estrelas'];
			$campo .= " t2.media_estrela, ";
			$inner .= " inner join curso_produto on curso_produto.id_produto = produto.id
			inner join (select curso_produto.id_produto, round(avg(feedback.estrela),1) as media_estrela 
			from curso_produto         
			inner join curso_feedback        on curso_produto.id_curso  = curso_feedback.id_curso 
			inner join feedback              on curso_feedback.id_feedback  = feedback.id
			group by curso_produto.id_produto) t2 on curso_produto.id_produto = t2.id_produto ";
			$query .= " AND t2.media_estrela <= $estrela ";
		}
		if($_POST['buscar1']){
			if($_POST['buscar1'] == ''){
				$query = '';
				$inner = '';
				$campo = '';
			}else{
				$buscar_campo = $_POST['buscar1'];
				$query .= " AND produto.titulo LIKE '%$buscar_campo%' ";
			}
		}
		
		$conexao = new mysql();
		$combo = $conexao->query("SELECT
									combos.id as combo_id,
									combos.titulo as combo_titulo,
									combos.banner as combo_banner,
									combos.plano_id as plano_id,
									combos.valor as plano_valor,
									combos.usar_desconto as usar_desconto,
									combos.status as combo_status,
									combos.desconto as combo_desconto,
									produto.id as produto_id,
									produto.titulo as protudo_titulo,
									produto.*
									FROM `combos` 
									inner join combo_produto on combo_produto.id_combo = combos.id
									inner join produto on produto.id = combo_produto.id_produto;");
		$new_cmb = array();
		while ($obj_cmb = $combo->fetch_object()) {
			// array_push($new_cmb,$obj_cmb);
			
			$combo_id = $obj_cmb->combo_id;
			
			if (!empty($new_cmb[$combo_id])){
				// $new_cmb[$combo_id] = array_merge($new_cmb[$combo_id], array($obj_cmb));
				array_push($new_cmb[$combo_id]['produtos'],$obj_cmb);
			}else{
				$new_cmb[$combo_id]['combo_id'] 			= $obj_cmb->combo_id;
				$new_cmb[$combo_id]['combo_titulo'] 		= $obj_cmb->combo_titulo;
				$new_cmb[$combo_id]['combo_banner'] 		= $obj_cmb->combo_banner;
				$new_cmb[$combo_id]['combo_status'] 		= $obj_cmb->combo_status;
				$new_cmb[$combo_id]['plano_valor'] 			= $obj_cmb->plano_valor;
				$new_cmb[$combo_id]['usar_desconto'] 		= $obj_cmb->usar_desconto;
				$new_cmb[$combo_id]['combo_desconto'] 		= $obj_cmb->combo_desconto;
				$new_cmb[$combo_id]['produtos'] = array($obj_cmb);
			}
		}

		$result = $conexao->query("SELECT distinct 
									$campo
									autor.nome as autor_nome,
									canal.id_canal,
									canal.nm_canal,
									produto.*,
									t1.imagem
									FROM loja.produto 
									inner join loja.autor on produto.autor = autor.id
									inner join loja.produto_canal ON produto.codigo=produto_canal.id_produto 
									inner join loja.canal ON canal.id_canal = produto_canal.id_canal 
									inner join (select max(id) id, codigo, imagem from loja.produto_imagem group by codigo) t1 on produto.codigo=t1.codigo
									$inner
									where  canal.status <= 3 
									AND produto.status = 1
									AND produto.only_combo = 0
									$query
									order by canal.status asc;");

		$new = array();
		while ($obj = $result->fetch_object()) {
			$nm_canal = $obj->nm_canal;
			if (!empty($new[$nm_canal])){
				$new[$nm_canal] = array_merge($new[$nm_canal], array($obj));
			}else{
				$new[$nm_canal] = array($obj);
			}
		}

		$result_novidades = $conexao->query("SELECT distinct 
									$campo
									autor.nome as autor_nome,
									produto.*,
									t1.imagem
									FROM loja.produto 
									inner join loja.autor on produto.autor = autor.id
									inner join loja.produto_canal ON produto.codigo=produto_canal.id_produto 
									inner join (select max(id) id, codigo, imagem from loja.produto_imagem group by codigo) t1 on produto.codigo=t1.codigo
									$inner
									WHERE produto.novidades = 1
									AND produto.status = 1
									AND produto.only_combo = 0
									$query
									order by produto.id desc;");
		$new_novidades = array();
		while ($obj_novidades = $result_novidades->fetch_object()) {
			$nm_canal_novidades = $obj_novidades->nm_canal;
			if (!empty($new_novidades[$nm_canal_novidades])){
				$new_novidades[$nm_canal_novidades] = array_merge($new_novidades[$nm_canal_novidades], array($obj_novidades));
			}else{
				$new_novidades[$nm_canal_novidades] = array($obj_novidades);
			}
		}

		$result_vendidos = $conexao->query("SELECT distinct 
									$campo
									autor.nome as autor_nome,
									produto.*,
									t1.imagem
									FROM loja.produto 
									inner join loja.autor on produto.autor = autor.id
									inner join loja.produto_canal ON produto.codigo=produto_canal.id_produto 
									inner join (select max(id) id, codigo, imagem from loja.produto_imagem group by codigo) t1 on produto.codigo=t1.codigo
									$inner
									WHERE produto.mais_vendidos = 1
									AND produto.status = 1
									AND produto.only_combo = 0
									$query
									order by produto.id desc;");
		$new_vendidos = array();
		while ($obj_vendidos = $result_vendidos->fetch_object()) {
			$nm_canal_vendidos = $obj_vendidos->nm_canal;
			if (!empty($new_vendidos[$nm_canal_vendidos])){
				$new_vendidos[$nm_canal_vendidos] = array_merge($new_vendidos[$nm_canal_vendidos], array($obj_vendidos));
			}else{
				$new_vendidos[$nm_canal_vendidos] = array($obj_vendidos);
			}
		}

		$result_melhor_qualificado = $conexao->query("SELECT distinct 
									$campo
									autor.nome as autor_nome,
									produto.*,
									t1.imagem
									FROM loja.produto 
									inner join loja.autor on produto.autor = autor.id
									inner join loja.produto_canal ON produto.codigo=produto_canal.id_produto 
									inner join (select max(id) id, codigo, imagem from loja.produto_imagem group by codigo) t1 on produto.codigo=t1.codigo
									$inner
									WHERE produto.melhor_qualificado = 1
									AND produto.status = 1
									AND produto.only_combo = 0
									$query
									order by produto.id desc;");
		$new_melhor_qualificado = array();
		while ($obj_melhor_qualificado = $result_melhor_qualificado->fetch_object()) {
			$nm_canal_melhor_qualificado = $obj_melhor_qualificado->nm_canal;
			if (!empty($new_melhor_qualificado[$nm_canal_melhor_qualificado])){
				$new_melhor_qualificado[$nm_canal_melhor_qualificado] = array_merge($new_melhor_qualificado[$nm_canal_melhor_qualificado], array($obj_melhor_qualificado));
			}else{
				$new_melhor_qualificado[$nm_canal_melhor_qualificado] = array($obj_melhor_qualificado);
			}
		}

		$dados['cat_selecionada'] = ($_POST['categoria'] > 0 ? $_POST['categoria'] : 0);
		$dados['autor_selecionado'] = ($_POST['autor'] > 0 ? $_POST['autor'] : 0);
		$dados['buscar_campo'] = $_POST['buscar1'];
		$dados['estrelas_campo'] = ($_POST['estrelas'] > 0 ? $_POST['estrelas'] : 0);
		
		$dados['categorias'] = $produtos->lista_categorias();
		$dados['autores'] = $produtos->lista_autor();
		$dados['canais'] = $produtos->lista_canal();
		$dados['lista_canal'] = $new;
		$dados['combos'] = $new_cmb;
		
		$dados['lista_comprados'] = $new_comprados;

		$dados['lista_canal_novidades'] = $new_novidades;
		$dados['lista_canal_mais_vendidos'] = $new_vendidos;
		$dados['lista_canal_melhor_qualificado'] = $new_melhor_qualificado;

		$dados['layout_lista'] = $lista_blocos;

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
		$this->view('index', $dados);
	}

	public function cat_produto(){
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inicial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$id = $this->get('id');

		if(!$id){
			$this->irpara(DOMINIO);
		}


		$conexao = new mysql();
		$result = $conexao->query("SELECT 
									t6.nome as autor_nome,
									t3.titulo as titulo_produto,
									t4.imagem,
									t1.* 
									FROM produto t1 
									inner join autor t6 on t1.autor = t6.id
									inner join produto_categoria_sel t2 on t1.codigo = t2.produto_codigo 
									inner join produto_categoria t3 on t2.categoria_codigo = t3.codigo 
									inner join (select max(id) id, codigo, imagem from produto_imagem group by codigo) t4 on t1.codigo=t4.codigo
									WHERE 1 = 1 and t3.id = $id ");


		$new = array();
		while ($obj = $result->fetch_object()) {
			array_push($new,$obj);
		}

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];

		$dados['novos_cursos'] = $new;
		// echo'<pre>';print_r($dados['novos_cursos']);exit;

		$this->view('cat_produto.detalhes', $dados);
	}

	public function cadastro_email(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$nome = $this->get('nome');
		$email = $this->get('email');
		$grupo = $this->get('grupo');

		if(!$nome){
			$retorno = "erro";
		} else {
			if(!$email){
				$retorno = "erro";
			} else {
				if(!$grupo){
					$retorno = "erro";
				} else {
					$valida = new model_valida();

					if(!$valida->email($email)){
						$retorno = "erro";
					} else {

						$db = new mysql();
						$exec = $db->executar("select * from cadastro_email WHERE email='$email' AND grupo_codigo='$grupo' ");
						$linhas = $exec->num_rows;

						if($linhas == 0){

							$conexao = new mysql();
							$coisas_grupo = $conexao->Executar("select titulo from cadastro_email_grupos where codigo='$grupo' ");
							$data_grupo = $coisas_grupo->fetch_object();

							$grupo_titulo = $data_grupo->titulo;

							$db = new mysql();
							$db->inserir("cadastro_email", array(
								"nome"=>"$nome",
								"email"=>"$email",
								"grupo_codigo"=>"$grupo",
								"grupo_titulo"=>"$grupo_titulo"
							));

						}

						$retorno = "ok";
					}		
				}		
			}
		}

		$dados['retorno'] = $retorno;

		$this->view('conteudo_cadastro_email.retorno', $dados);
	}

	public function cadastro_fone(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$nome = $this->get('nome');
		$fone = $this->get('fone');
		$grupo = $this->get('grupo');

		if(!$nome){
			$retorno = "erro";
		} else {
			if(!$fone){
				$retorno = "erro";
			} else {
				if(!$grupo){
					$retorno = "erro";
				} else {

					$db = new mysql();
					$exec = $db->executar("select * from cadastro_fone WHERE fone='$fone' AND grupo_codigo='$grupo' ");
					$linhas = $exec->num_rows;

					if($linhas == 0){

						$conexao = new mysql();
						$coisas_grupo = $conexao->Executar("select titulo from cadastro_fone_grupos where codigo='$grupo' ");
						$data_grupo = $coisas_grupo->fetch_object();

						$grupo_titulo = $data_grupo->titulo;

						$db = new mysql();
						$db->inserir("cadastro_fone", array(
							"nome"=>"$nome",
							"fone"=>"$fone",
							"grupo_codigo"=>"$grupo",
							"grupo_titulo"=>"$grupo_titulo"
						));

					}

					$retorno = "ok";
				}		
			}
		}

		$dados['retorno'] = $retorno;

		$this->view('conteudo_cadastro_fone.retorno', $dados);
	}

	public function contato_enviar(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$nome = $this->post('nome');
		$cidade = $this->post('cidade');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		$captcha = $this->post('g-recaptcha-response');
		$grupo = $this->post('grupo');
		$email_destino = $this->post('email_destino');
		
		if($nome AND $email AND $grupo){
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$key = recaptcha_secret;
			$url = 'https://www.google.com/recaptcha/api/siteverify';

			// RECAPTCH RESPONSE
			$recaptcha_response = file_get_contents($url.'?secret='.$key.'&response='.$captcha.'&remoteip='.$ip);
			$data = json_decode($recaptcha_response);
			if(isset($data->success) &&  $data->success === true) {

				/* mensagem */
				$msg =  "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Contato enviado pelo Website</strong></p>";	
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Nome:</strong> ".$nome."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Cidade:</strong> ".$cidade."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>E-mail:</strong> ".$email."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Telefone:</strong> ".$fone."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Mensagem:</strong> ".$mensagem."</p>";


				$db = new mysql();
				$exec = $db->executar("select * from contato_grupos WHERE codigo='$grupo' ");
				$data_grupo = $exec->fetch_object();

				$lista_envio = array();
				$n = 0;

				if($data_grupo->tipo_envio == 'todos'){ 

					$db = new mysql();
					$exec = $db->executar("select * from contato WHERE grupo='$grupo' ");
					while($data = $exec->fetch_object()){
						$lista_envio[$n] = $data->email;
						$n++;
					}

				} else {
					if(!$email_destino){
						echo "O destino selecionado é inválido!";
						exit;
					}
					$lista_envio[0] = $email_destino;
				}
				
				$envio = new model_envio();
				$retorno = $envio->enviar("Contato", $msg, $lista_envio, $email);
				if($retorno['status'] == 1){
					echo $retorno['msg'];
				} else {
					echo 'Erro no envio - '.$retorno['msg'];
				}

			} else {
				echo "Erro na validação do captcha, tente novamente!";
				exit;
			}

		} else {
			echo "Preencha todos os campos para continuar";
			exit;
		}

	}

	public function leitura(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$id = $this->get('id');

		if(!$id){
			$this->irpara(DOMINIO);
			exit;
		}


		// noticia

		$postagens = new model_postagens();
		$dados['data'] = $postagens->carrega_postagem($id);
		if(!$dados['data']->id){
			$this->irpara(DOMINIO);
			exit;
		}

		// grupos
		$dados['categorias'] = $postagens->lista_categorias();
		$dados['categoria_codigo'] = $dados['data']->categoria;
		$dados['categoria'] = $postagens->titulo_categoria($dados['data']->categoria);

		//codigo da noticia
		$codigo = $dados['data']->codigo;

		//endereco da noticia		 
		$dados['endereco_noticia'] = DOMINIO.$this->_controller."/leitura/id/".$dados['data']->amigavel;
		$dados['endereco_noticia_sem_ssl'] = $string = str_replace("https://", "http://", $dados['endereco_noticia']);

		//autor se tiver
		if($dados['data']->autor){			
			$dados['autor'] = $postagens->autor_postagem($dados['data']->autor);			
		} else {
			$dados['autor'] = "";
		}

		//dia
		//$mes = new data();
		//$dados['dia'] = date('d', $dados['data']->data)." ".$mes->mes($dados['data']->data, 2)." ".date('Y', $dados['data']->data);
		$dados['dia'] = date('d/m', $dados['data']->data);

		//pega imagens
		$dados['imagens'] = $postagens->imagens($codigo);

		$dados['imagem_principal_largura'] = "";
		$dados['imagem_principal_altura'] = "";
		$dados['imagem_principal'] = "";
		if(isset($dados['imagens'][0]['imagem_g'])){

			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
			$dados['imagem_principal_sem_ssl'] = $string = str_replace("https://", "http://", $dados['imagens'][0]['imagem_g']);

			$imagem_principal = "arquivos/img_postagens_g/".$dados['data']->codigo."/".$dados['imagens'][0]['imagem'];
			list($largura, $altura) = getimagesize($imagem_principal);
			if($largura){
				$dados['imagem_principal_largura'] = $largura;
			}
			if($altura){
				$dados['imagem_principal_altura'] = $altura;
			}

		}


		$banners = new model_banners();
		$dados['banners_esquerda'] = $banners->lista_simples('148713350186607');
		$dados['banners_direita'] = $banners->lista_simples('148841831030374');


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM noticia_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao .= "<a class='botao_padrao botao_".$data->codigo."' onclick=\"history.go(-1);\" >".$data->texto."</a>";

		} else {
			$botao = "";
		}

		$dados['botao_padrao'] = $botao;

		//carrega view e envia dados para a tela
		$this->view('leitura', $dados);

	}

	public function buscar(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$buscatag = $this->post('busca');
		$pg_des = $this->get('pg');

		if(!$buscatag){
			$this->irpara(DOMINIO);
			exit;
		} else {
			$buscatag_filtrado = str_replace(array('/',' '), "", $buscatag);
			if($pg_des){
				$this->irpara(DOMINIO.$pg_des.'/inicial/busca/'.$buscatag_filtrado);
			} else {
				$this->irpara(DOMINIO.$this->_controller.'/busca/tag/'.$buscatag_filtrado);
			}
		}
	}

	public function busca(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////
		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;

		$buscatag = $this->get('tag');
		if(!$buscatag){
			$this->irpara(DOMINIO);
			exit;
		}
		$dados['buscatag'] = $buscatag;

		$lista = array();
		$n = 0;

		// busca noticias

		$conexao = new mysql();
		$coisas_noticias = $conexao->Executar("SELECT * FROM noticia WHERE titulo LIKE '%$buscatag%' OR previa LIKE '%$buscatag%' ORDER BY data desc");
		if($coisas_noticias->num_rows != 0){
			while($data_noticias = $coisas_noticias->fetch_object()){

				$lista[$n]['tipo'] = 'noticias';
				$lista[$n]['titulo'] = "Postagens - ".$data_noticias->titulo;
				$lista[$n]['previa'] = $data_noticias->previa;
				$lista[$n]['endereco'] = DOMINIO.$this->_controller."/leitura/id/".$data_noticias->amigavel;

				$n++;
			}
		}

		// busca produtos

		$conexao = new mysql();
		$coisas_produtos = $conexao->Executar("SELECT * FROM produto WHERE titulo LIKE '%$buscatag%' OR ref LIKE '%$buscatag%' ORDER BY id asc");
		if($coisas_produtos->num_rows != 0){
			while($data_produtos = $coisas_produtos->fetch_object()){

				$lista[$n]['tipo'] = 'produtos';
				$lista[$n]['titulo'] = "Produtos - ".$data_produtos->titulo;
				$lista[$n]['previa'] = $data_produtos->previa;
				$lista[$n]['endereco'] = DOMINIO.$this->_controller."/produto/id/".$data_produtos->id;

				$n++;
			}
		}

		// busca simples de imoveis

		$conexao = new mysql();
		$coisas_imoveis = $conexao->Executar("SELECT * FROM imoveis WHERE titulo LIKE '%$buscatag%' OR cod_interno LIKE '%$buscatag%' ORDER BY id asc");
		if($coisas_imoveis->num_rows != 0){
			while($data_imoveis = $coisas_imoveis->fetch_object()){

				$lista[$n]['tipo'] = 'imoveis';
				$lista[$n]['titulo'] = "Imóveis - ".$data_imoveis->titulo;
				$lista[$n]['previa'] = '';
				$lista[$n]['endereco'] = DOMINIO.$this->_controller."/imoveis_detalhes/id/".$data_imoveis->codigo;

				$n++;
			}
		}



		$dados['lista'] = $lista;

		//carrega view e envia dados para a tela
		$this->view('busca', $dados);
	}

	public function criar_depoimento(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$codigo_item = $this->get('codigo');

		if($codigo_item){

			$conexao = new mysql();
			$exec = $conexao->Executar("SELECT * FROM depoimentos_grupos WHERE codigo='$codigo_item' ");
			$data_grupo = $exec->fetch_object();

			// cores
			$layout = new model_layout(); 
			$dados['botao'] = $layout->carrega_botao($data_grupo->botao_codigo, " aquivaiolink ", true);

		}

		$this->view('conteudo_depoimentos_adicionar', $dados);		 
	}

	public function enviar_depoimento(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$nome = $this->post('nome');
		$email = $this->post('email');
		$cidade = $this->post('cidade');
		$msg = $this->post('msg');

		// validacoes
		if($nome AND $email AND $msg){

			$time = time();

			$db = new mysql();
			$db->inserir("depoimentos", array(
				'data'=>$time,
				'nome'=>$nome,
				'email'=>$email,
				'cidade'=>$cidade,
				'conteudo'=>$msg,
				'bloqueio'=>"1"
			));

			$this->msg('Seu depoimento foi enviado com sucesso!');
			$this->volta(1);

		} else {
			$this->msg('Informe seus dados corretamente e tente novamente.');
			$this->volta(1);
		}
	}

	public function cidades(){ 

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$estados_cidades = new model_estados_cidades();

		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		$dados['cidades'] = $estados_cidades->lista_cidades($estado, $cidade);

 		//carrega view e envia dados para a tela
		$this->view('cidades', $dados);
	}

	public function busca_endereco_cep(){

		$cep = $this->post('cep');
		if($cep){

			$buscacep = new model_cep();
			$resultado_busca_cep = $buscacep->retorno($cep);

			$retorno = array();

			if($resultado_busca_cep['rua']){
				$retorno['endereco'] = $resultado_busca_cep['rua_tipo']." ".$resultado_busca_cep['rua'];
			} else {
				$retorno['endereco'] = "";
			}

			$retorno['cidade'] = $resultado_busca_cep['cidade'];
			$retorno['estado'] = $resultado_busca_cep['uf'];
			$retorno['bairro'] = $resultado_busca_cep['bairro'];

			echo json_encode($retorno);
		}
	}

	public function finalizar_cadastro(){

		$dados = array();
		$dados['_base'] = $this->_base();

		// retorno de dados caso erro
		function retorno_erro($msg){
			echo "<div style='padding;20px;' >".$msg."</div>";	
			exit;
		}

		// recebe variaveis

		$email = $this->post('email');
		$senha = $this->post('senha');
		$senha_confirma = $this->post('senha_confirma');

		$tipo = $this->post('tipo');

		$fisica_nome = $this->post('fisica_nome');
		$fisica_sexo = $this->post('fisica_sexo');
		$fisica_nascimento = $this->post('fisica_nascimento');
		$fisica_cpf = $this->post('fisica_cpf'); 

		$juridica_nome = $this->post('juridica_nome');
		$juridica_razao = $this->post('juridica_razao');
		$juridica_cnpj = $this->post('juridica_cnpj');
		$juridica_ie = $this->post('juridica_ie');
		$juridica_responsavel = $this->post('juridica_responsavel');

		$telefone = $this->post('cadastro_telefone');
		$cep = $this->post('cadastro_cep');
		$endereco = $this->post('endereco');
		$numero = $this->post('numero');
		$complemento = $this->post('complemento');
		$bairro = $this->post('bairro');
		$estado = $this->post('estado');
		$cidade = $this->post('cidade');
		$cadastro_com_login = $this->post('cadastro_com_login');
		$promocoes = $this->post('promocoes');

		//validar email consultando no banco
		if(!$email){

			retorno_erro("E-mail inválido!");
			exit;

		} else {

			$validaemail = new model_valida();				
			if(!$validaemail->email($email)){
				retorno_erro("E-mail inválido!");
				exit;
			} else {

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE email='$email' ");
				$linhas = $coisas->num_rows;

				if($linhas != 0){
					retorno_erro("Este e-mail esta sendo utilizado por outro cadastro,<br>informe um e-mail diferente ou tente a recuperação de senha.");
					exit;
				}
			}
		}


		if($cadastro_com_login == 1){

			//validar senha
			if($senha AND $senha_confirma){
				if($senha != $senha_confirma){

					retorno_erro("Digite uma senha válida e confirme.");
					exit;

				}
			} else {

				retorno_erro("Digite uma senha válida e confirme.");
				exit;

			}

		} else {
			$senha = '0000';
		}



		// valida documentos
		require_once("api/cpf_cnpj/cpf_cnpj.php");

		//validar cpf ou cnpj simples
		if($tipo == 'F'){		 

			if(!$fisica_cpf){
				retorno_erro("Digite corretamente seu CPF.");			 
				exit;
			} else {

				$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
				if(!$cpf_cnpj->valida()){

					retorno_erro("Digite corretamente seu CPF.");
					exit;

				} else {

					$fisica_cpf = $cpf_cnpj->formata();

					// confere se ja existe
					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE fisica_cpf='$fisica_cpf' ");
					if($coisas->num_rows != 0){
						retorno_erro("CPF já cadastrado.");			 
						exit;
					}

				}

			}

			//limpar dados do oposto do tipo (juridica ou fisica)
			$juridica_nome = "";
			$juridica_razao = "";
			$juridica_cnpj = "";
			$juridica_ie = "";
			$juridica_responsavel = "";


			if(!$fisica_nome){
				retorno_erro("Digite seu nome completo.");	 
				exit;				
			}
			if(!$fisica_sexo){
				retorno_erro("Informe seu sexo.");	 
				exit;
			}
			if(!$fisica_nascimento){
				retorno_erro("Informe sua data de nascimento.");	 
				exit;
			} else {

				// transforma data em inteiro
				$arraydata = explode("/", $fisica_nascimento); 
				if($arraydata[2] <= 1920){
					retorno_erro("Informe sua data de nascimento corretamente.");				 
					exit;
				}
				if($arraydata[1] > 12){
					retorno_erro("Informe sua data de nascimento corretamente.");				 
					exit;
				}
				if($arraydata[0] > 31){
					retorno_erro("Informe sua data de nascimento corretamente.");				 
					exit;
				}
				$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." 00:00:01";
				$fisica_nascimento = strtotime($hora_montada);

			} 

		} else {
			if(!$juridica_cnpj){

				retorno_erro("Digite corretamente o CNPJ.");				 
				exit;

			} else {

				$cpf_cnpj = new valida_cpf_cnpj("$juridica_cnpj");
				if(!$cpf_cnpj->valida()){
					retorno_erro("Digite corretamente o CNPJ.");				 
					exit;
				} else {

					$juridica_cnpj = $cpf_cnpj->formata();

					// confere se ja existe
					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE juridica_cnpj='$juridica_cnpj' ");
					if($coisas->num_rows != 0){
						retorno_erro("CNPJ já cadastrado.");			 
						exit;
					}

				}

			}

			//limpar dados do oposto do tipo (juridica ou fisica)
			$fisica_nome = "";
			$fisica_sexo = "";
			$fisica_nascimento = "";
			$fisica_cpf = "";

			if(!$juridica_nome){
				retorno_erro("Complete todos os dados da empresa.");	 
				exit;
			}
			if(!$juridica_razao){
				retorno_erro("Complete todos os dados da empresa.");	 
				exit;
			}

		}

		if(!$cep){

			retorno_erro("CEP inválido");	 
			exit;

		}
		if($endereco AND $numero AND $bairro AND $estado AND $cidade){ } else {

			retorno_erro("Preencha corretamente seus dados de endereço!");	 
			exit;

		}

		//gravar no banco de dados
		$codigo = substr(time().rand(10000,99999),-15);

		$senha_tratada = password_hash($senha, PASSWORD_DEFAULT);

		$db = new mysql();
		$db->inserir("cadastro", array(
			"codigo"=>"$codigo",
			"tipo"=>"$tipo",
			"fisica_nome"=>"$fisica_nome",
			"fisica_sexo"=>"$fisica_sexo",
			"fisica_nascimento"=>"$fisica_nascimento",
			"fisica_cpf"=>"$fisica_cpf",
			"juridica_nome"=>"$juridica_nome",
			"juridica_razao"=>"$juridica_razao",
			"juridica_responsavel"=>"$juridica_responsavel",
			"juridica_cnpj"=>"$juridica_cnpj",
			"juridica_ie"=>"$juridica_ie",
			"cep"=>"$cep",
			"endereco"=>"$endereco",
			"numero"=>"$numero",
			"complemento"=>"$complemento",
			"bairro"=>"$bairro",
			"estado"=>"$estado",
			"cidade"=>"$cidade",
			"telefone"=>"$telefone",
			"email"=>"$email",
			"senha"=>"$senha_tratada",
			"receber_promocoes"=>"$promocoes"
		));
		
		
		//gera cupom se necessário
		$cupons = '';
		$model_cupom = new model_cupom();
		
		$conexao = new mysql();
		$coisas_promo = $conexao->Executar("select codigo from cupom where cadastro='1' ");
		while($data_promo = $coisas_promo->fetch_object()){

			$cupom = $model_cupom->gera_cupom_promo($data_promo->codigo);

			$cupons .= "<div style='padding:10px; font-size:13px; color:#000;'>
			<p>Você ganhou um cupom de desconto para sua primeira compra,<br>utilize o seguinte codigo quando finalizar sua compra para ganhar o desconto: <strong>$cupom</strong> </p>
			</div>";

		}


		//enviar email de confirmação
		$textos = new model_textos();

		//criando o codigo html para enviar no email

		if($tipo == 'F'){
			$nome_email = $fisica_nome;
		} else {
			$nome_email = $juridica_nome;
		}

		/* mensagem */
		$msg = "
		<div style='padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000;'><p>".utf8_decode('Olá').", ".$nome_email."</p></div>
		<div style='padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000;'><p>".$textos->conteudo('146172119158298')."</p></div>	
		".utf8_decode($cupons)."
		";

		// envia o email
		$envio = new model_envio();
		$retorno = $envio->enviar("Cadastro concluído com sucesso!", $msg, array("0"=>"$email"));

		echo "<div style='padding:20px;'>".$textos->conteudo('159649081566934')."</div>";

	}

	public function cadastro_basico(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		// itens da inciial

		$chave = $this->_layout;
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;
								
								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;



		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM cadastro_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao .= "<a class='botao_padrao botao_".$data->codigo."' onclick=\"finalizar_cadastro();\" >".$data->texto."</a>";

		} else {
			$botao = "";
		}

		$dados['botao_padrao'] = $botao;


		$codigo_cadastro = $this->get('codigo');

		if($codigo_cadastro){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE codigo='$codigo_cadastro' ");
			$data = $coisas->fetch_object();

			$etapa = $data->etapa;

			$estados_cidades = new model_estados_cidades();
			$dados['estados'] = $estados_cidades->lista_estados();

		} else {
			$etapa = 0;
		}

		$dados['etapa'] = $etapa;
		$dados['codigo_cadastro'] = $codigo_cadastro;

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
		//carrega view e envia dados para a tela
		$this->view('cadastro', $dados);
	}

	public function cadastro_basico_grv(){

		$dados = array();
		$dados['_base'] = $this->_base();

		// retorno de dados caso erro
		function retorno_erro($msg){
			echo "<div style='padding;20px;' >".$msg."</div>";	
			exit;
		}

		$etapa = $this->post('etapa');


		if($etapa == 0){

			$email = $this->post('email');
			$confirma_email = $this->post('confirma_email');

			if($email != $confirma_email){
				retorno_erro("E-mails são diferentes!");
				exit;
			}

			$fisica_nome = $this->post('fisica_nome');
			$country_document = $this->post('country_document');
			
			if($country_document == 0){
				$fisica_cpf = $this->post('fisica_documento');
				$telefone = $this->post('cadastro_telefone');
			}else{
				$fisica_cpf = $this->post('fisica_cpf');
				$telefone = $this->post('cadastro_telefone_brasil');
			}
			if(!$fisica_cpf){
				retorno_erro("Digite corretamente seu CPF.");
				exit;

			} elseif($country_document == 1) {
				require_once("api/cpf_cnpj/cpf_cnpj.php");
				$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
				if(!$cpf_cnpj->valida()){
					retorno_erro("Digite corretamente seu CPF.");
					exit;
				}
			}

			$validaemail = new model_valida();	
			if(!$validaemail->email($email)){
				retorno_erro("E-mail inválido!");
				exit;
			} else {

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE email='$email' ");
				$linhas = $coisas->num_rows;

				if($linhas != 0){

					$data = $coisas->fetch_object();

					if($data->etapa == 0){
						retorno_erro("Este e-mail esta sendo utilizado por outro cadastro,<br>informe um e-mail diferente ou tente a recuperação de senha.");
						exit;
					} else {
						$this->irpara(DOMINIO.'index/cadastro_basico/codigo/'.$data->codigo);
						exit;
					}
				}
			}

			$email_lms = $this->check_email_lms($email, $fisica_cpf);
			if($email_lms == 1){
				retorno_erro("Este e-mail esta sendo utilizado por outro cadastro,<br>informe um e-mail diferente ou tente a recuperação de senha.");
				exit;
			}else{
				$last_id = $this->adiciona_email_lms($email);
			}

			//gravar no banco de dados
			$codigo = substr(time().rand(10000,99999),-15);
			$tipo = "F";



			$db = new mysql();
			$db->inserir("cadastro", array(
				"fisica_nome"=>"$fisica_nome",
				"lms_usuario_id"=>"$last_id",
				"telefone"=>"$telefone",
				"is_brasil"=>"$country_document",
				"codigo"=>"$codigo",
				"tipo"=>"$tipo",
				"fisica_cpf"=>"$fisica_cpf",
				"email"=>"$email",
				"senha"=>"000",
				"etapa"=>1
			));

			$this->irpara(DOMINIO.'index/cadastro_basico/codigo/'.$codigo);
			exit;
		}



		// if($etapa == 1){

		// 	$codigo = $this->post('codigo');

		// 	if(!$codigo){
		// 		retorno_erro("Ocorreu um erro!");
		// 		exit;				
		// 	}

		// 	$fisica_nome = $this->post('fisica_nome');
		// 	$country_document = $this->post('country_document');
			
		// 	if($country_document == 0){
		// 		$fisica_cpf = $this->post('fisica_documento');
		// 		$telefone = $this->post('cadastro_telefone');
		// 	}else{
		// 		$fisica_cpf = $this->post('fisica_cpf');
		// 		$telefone = $this->post('cadastro_telefone_brasil');

		// 	}

		// 	if(!$fisica_cpf){

		// 		retorno_erro("Digite corretamente seu CPF.");
		// 		exit;

		// 	} elseif($country_document == 1) {

		// 		require_once("api/cpf_cnpj/cpf_cnpj.php");

		// 		$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
		// 		if(!$cpf_cnpj->valida()){
		// 			retorno_erro("Digite corretamente seu CPF.");
		// 			exit;
		// 		}

		// 	}
			
		// 	$db = new mysql();
		// 	$db->alterar("cadastro", array(
		// 		"fisica_nome"=>"$fisica_nome",
		// 		"telefone"=>"$telefone",
		// 		"is_brasil"=>"$country_document",
		// 		"etapa"=>2
		// 	), " codigo='".$codigo."' AND etapa='1' ");


		// 	$this->irpara(DOMINIO.'index/cadastro_basico/codigo/'.$codigo);
		// 	exit;
		// }


		if($etapa == 1){

			$codigo = $this->post('codigo');

			if(!$codigo){
				retorno_erro("Ocorreu um erro!");
				exit;				
			}
			print_r('aquiioooo');
			$country_document = $this->post('country_document');
			// print_r($country_document);exit;
			if($country_document == 1){
				$cep = $this->post('cadastro_cep');
				$endereco = $this->post('endereco_');
				$numero = $this->post('numero_');
				$complemento = $this->post('complemento_');
				$bairro = $this->post('bairro_');
				$estado = $this->post('estado_');
				$cidade = $this->post('cidade');
				if(!$cep){
					retorno_erro("CEP inválido");	 
					exit;
				}
				if($endereco AND $numero AND $bairro AND $estado AND $cidade){} else {
					retorno_erro("Preencha corretamente seus dados de endereço!");	 
					exit;
				}
			}else{
				$cep = $this->post('postcode');
				$endereco = $this->post('endereco');
				$numero = $this->post('numero');
				$complemento = $this->post('complemento');
				$bairro = $this->post('bairro');
				$cidade = $this->post('cidade_outros');
				$estado = '';

			}

			$db = new mysql();
			$db->alterar("cadastro", array(
				"cep"=>"$cep",
				"endereco"=>"$endereco",
				"numero"=>"$numero",
				"complemento"=>"$complemento",
				"bairro"=>"$bairro",
				"estado"=>"$estado",
				"cidade"=>"$cidade",
				"is_brasil_address"=>"$country_document",
				"etapa"=>2
			), " codigo='".$codigo."' AND etapa='1'  ");


			$this->irpara(DOMINIO.'index/cadastro_basico/codigo/'.$codigo);
			exit;
		}


		if($etapa == 2){

			$codigo = $this->post('codigo');

			if(!$codigo){
				retorno_erro("Ocorreu um erro!");
				exit;				
			}

			$senha = $this->post('senha');
			$senha_confirma = $this->post('senha_confirma');

			//validar senha
			if($senha AND $senha_confirma){
				if($senha != $senha_confirma){
					retorno_erro("Digite uma senha válida e confirme.");
					exit;
				}
			} else {
				retorno_erro("Digite uma senha válida e confirme.");
				exit;
			}

			$senha_tratada = password_hash($senha, PASSWORD_DEFAULT);
			$senha_md5 = $this->post('senha');
			$senha_md5 = md5($senha_md5);

			$db = new mysql();
			$db->alterar("cadastro", array( 
				"senha"=>"$senha_tratada",
				"senha_md5"=>"$senha_md5",
				"etapa"=>3
			), " codigo='".$codigo."' AND etapa='2' ");


			$conexao = new mysql();
			$coisas_confere = $conexao->Executar("select * from cadastro where codigo='$codigo' AND etapa='3' ");
			if($coisas_confere->num_rows == 1){

				$data_confere = $coisas_confere->fetch_object();

				$nome_email = $data_confere->fisica_nome;
				$email = $data_confere->email;

				//gera cupom se necessário
				$cupons = '';
				$model_cupom = new model_cupom();

				$conexao = new mysql();
				$coisas_promo = $conexao->Executar("select codigo from cupom where cadastro='1' ");
				while($data_promo = $coisas_promo->fetch_object()){

					$cupom = $model_cupom->gera_cupom_promo($data_promo->codigo);

					$cupons .= "<div style='padding:10px; font-size:13px; color:#000;'>
					<p>Você ganhou um cupom de desconto para sua primeira compra,<br>utilize o seguinte codigo quando finalizar sua compra para ganhar o desconto: <strong>$cupom</strong> </p>
					</div>";

				}


				//enviar email de confirmação
				$textos = new model_textos();

				/* mensagem */
				$msg = "
				<div style='padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000;'><p>".utf8_decode('Olá').", ".$nome_email."</p></div>
				<div style='padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000;'><p>".$textos->conteudo('146172119158298')."</p></div>	
				".utf8_decode($cupons)."
				";

				// envia o email
				// $envio = new model_envio();
				// $retorno = $envio->enviar("Cadastro concluído com sucesso!", $msg, array("0"=>"$email"));

				// echo "<div style='padding-top:20px; pading-left:20px; padding-right:20px;'>".$textos->conteudo('159649081566934')."</div>";

				echo "<div style='padding-top:20px; pading-left:20px; padding-right:20px;'>Você receberá um e-mail para ativação da conta.</div>";
				
				// echo "<div style='padding-top:20px; padding-bottom:20px; text-align:center;'><a href='".DOMINIO.$this->_controller."/entrar' class='botao_padrao' >FAÇA SEU LOGIN</a></div>";

				$db = new mysql();
				$db->alterar("cadastro", array(
					"etapa"=>0,
					"status" => 0
				), " codigo='".$codigo."' AND etapa='3' ");
				
				$add_data_gerado		= date("Y-m-d H:i:s");
				$senha_md5 = $this->post('senha');
				$senha_md5 = md5($senha_md5);
				$this->salvar_usuario_lms($data_confere->lms_usuario_id, $data_confere->fisica_nome,$data_confere->email,$data_confere->fisica_cpf,$data_confere->telefone,$data_confere->endereco,$data_confere->numero,$data_confere->bairro,$data_confere->cidade,$data_confere->estado,$add_data_gerado,$data_confere->fisica_nascimento,$data_confere->fisica_sexo,$senha_md5);

			} else {
				
				$this->irpara(DOMINIO.'index/entrar');
				exit;
			}
		}
	}
	public function adiciona_email_lms($email = NULL){
		require('conexao.php');
		$sql = "INSERT INTO usuario (nome) VALUES('$email');";
		$mysqli->query($sql);
		$last_id = $mysqli->insert_id;
		$mysqli->close();
		return $last_id;
	}
	 
	public function check_email_lms($email = NULL, $fisica_cpf){
		require('conexao.php');
		$sql = "SELECT email FROM usuario WHERE email = '$email' OR cpf = '$fisica_cpf';";
		if ($result = $mysqli->query($sql)) {
			if($result->num_rows == 1){
				return 1;
			}else{
				return 0;
			}
		}
	}

	public function salvar_usuario_lms($lms_usuario_id, $fisica_nome = NULL ,$email = NULL ,$fisica_cpf = NULL ,$telefone = NULL ,$endereco = NULL ,$numero = NULL ,$bairro = NULL ,$cidade = NULL ,$estado = NULL ,$add_data_gerado = NULL ,$fisica_nascimento = NULL ,$fisica_sexo = NULL ,$senha = NULL ){

		require('conexao.php');
		$sql = "UPDATE usuario
				SET id_ocupacao = 29, id_perfil = 22, id_pais = 1, id_empresa = 1, nome = '$fisica_nome', email = '$email', cpf = '$fisica_cpf', telefone = '$telefone', endereco = '$endereco', numero = '$numero', bairro = '$bairro', cidade = '$cidade', ativo =1, senha = '$senha', pontos = 0, acessibilidade = 0, avisoemail = 0, instrutor =0, id_loja = 3, performance = '0'
				WHERE id = '$lms_usuario_id'";
		$mysqli->query($sql);
		
		$mysqli->close();
	}

	public function duvidas_respostas(){

		$codigo = $this->post('codigo');
		if($codigo){

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM duvidas WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			echo "
			<div class='duvidas_pergunta'>".$data->titulo."</div>
			<div class='duvidas_resposta' >".nl2br($data->resposta)."</div>
			";

		}
	}

	public function resultado_enquete(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;


		$codigo = $this->get('codigo');

		if(!$codigo){

			echo "Ocorreu um erro!";
			exit;

		}


		$trata = new model_valores();

		//lista ultima enquete
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM enquete WHERE codigo='$codigo' ");
		$data = $coisas->fetch_object();

		$dados['enquete']['codigo'] = $data->codigo;
		$dados['enquete']['pergunta'] = $data->enquete;

		//calcula total de votos
		$conexao = new mysql();
		$coisas_vot_total = $conexao->Executar("SELECT id FROM enquete_voto WHERE codigo_enquete='".$dados['enquete']['codigo']."' ");
		$linhas_vot_total = $coisas_vot_total->num_rows;

		//lisa respostas
		$respostas = array();
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM enquete_resposta WHERE enquete_codigo='".$dados['enquete']['codigo']."' ");
		$n = 0;
		while($data = $coisas->fetch_object()){

			$respostas[$n]['texto'] = $data->resposta;
			$respostas[$n]['codigo'] = $data->codigo;

			//calula numero de votos
			$conexao = new mysql();
			$coisas_vot = $conexao->Executar("SELECT id FROM enquete_voto WHERE codigo_enquete='".$dados['enquete']['codigo']."' AND codigo_resposta='$data->codigo' ");
			$linhas_vot = $coisas_vot->num_rows;

			$respostas[$n]['votos'] = $linhas_vot;

			//calula porcentagem de votos
			if($linhas_vot != 0){
				$porcento = ($linhas_vot / $linhas_vot_total) * 100;
				$porcento = $trata->trata_valor_calculo($porcento);
			} else {
				$porcento = 0;
			}
			$respostas[$n]['votos_porc'] = $porcento;

			$n++;
		}
		$dados['enquete_respostas'] = $respostas;


		//carrega view e envia dados para a tela
		$this->view('conteudo_enquete_resultado', $dados);
	}

	public function enquete_votar(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;


		$codigo_enquete = $this->post('codigo');
		$voto = $this->post('enquete');

		if($codigo_enquete AND $voto){

			$ip = $_SERVER["REMOTE_ADDR"];
			$time = time();

			//confere se o ip já votou nesta enquete
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT data FROM enquete_voto WHERE codigo_enquete='$codigo_enquete' AND ip='$ip' order by id desc limit 1 ");

			//caso já exista um voto confere se foi no mesmo dia
			if($coisas->num_rows != 0){
				$data = $coisas->fetch_object();
				if(date('d/m/Y') == date('d/m/Y', $data->data)){
					echo "Desculpe, é permitido apenas 1 voto por pessoa/ip";
					exit;
				}
			}

			// se passou nas validações grava o voto no banco
			$db = new mysql();
			$coisas = $db->inserir("enquete_voto", array(
				"data"=>"$time",
				"codigo_enquete"=>"$codigo_enquete",
				"codigo_resposta"=>"$voto",
				"ip"=>"$ip"
			));

			echo "Obrigao por votar!";
			exit;
		} else {
			echo "Preencha o campo de resposta!";
			exit;
		}

	}

	public function servicos_detalhes(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$id = $this->get('id');

		if(!$id){
			$this->irpara(DOMINIO);
		}

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM servicos WHERE codigo='$id' ");
		$dados['data'] = $exec->fetch_object();


		//carrega view e envia dados para a tela
		$this->view('servicos.detalhes', $dados);

	}	

	public function filial(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->irpara(DOMINIO);
		}

		$filiais = new model_filiais();
		$dados['data'] = $filiais->carrega($codigo);
		$dados['imagens'] = $filiais->imagens($codigo);


		//carrega view e envia dados para a tela
		$this->view('filiais.detalhes', $dados);
	}

	public function videos_categoria(){

		$categoria = $this->post('categoria');
		$itens_por_linha = $this->post('itens_por_linha');
		$mostrar_titulo_video = $this->post('mostrar_titulo_video');

		if($categoria){

			$n_row = 1;

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM videos WHERE categoria='$categoria' ");
			while($data = $exec->fetch_object()){

				if($n_row == 1){ echo "<div class='row' >"; }


				if($itens_por_linha == 1){
					echo "<div class='col-xs-12 col-sm-12 col-md-12' >";
				}
				if($itens_por_linha == 2){
					echo "<div class='col-xs-12 col-sm-6 col-md-6' >";
				}
				if($itens_por_linha == 3){
					echo "<div class='col-xs-12 col-sm-4 col-md-4' >";
				}
				if($itens_por_linha == 4){
					echo "<div class='col-xs-12 col-sm-3 col-md-3' >";
				}

				echo " 
				<div class='videos_div' >
				";

				if($mostrar_titulo_video == 1){

					echo "<div class='videos_titulo'  >".$data->titulo."</div>";

				}

				echo "
				<div class='videos_descricao' >".$data->previa."</div>
				<div class='videos_conteudo' >".$data->conteudo."</div>

				</div>
				</div>
				";

				if($n_row == $itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

			}

			if($n_row != 1){ echo "</div>"; }

		}
	}

	public function audios_categoria(){

		$categoria = $this->post('categoria');
		$itens_por_linha = $this->post('itens_por_linha');
		$mostrar_titulo_audio = $this->post('mostrar_titulo_audio');

		$ntotal = 0;
		if($categoria){

			$n_row = 1;

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM audios WHERE categoria='$categoria' ");
			while($data = $exec->fetch_object()){

				if($n_row == 1){ echo "<div class='row' >"; }


				if($itens_por_linha == 1){
					echo "<div class='col-xs-12 col-sm-12 col-md-12' >";
				}
				if($itens_por_linha == 2){
					echo "<div class='col-xs-12 col-sm-6 col-md-6' >";
				}
				if($itens_por_linha == 3){
					echo "<div class='col-xs-12 col-sm-4 col-md-4' >";
				}
				if($itens_por_linha == 4){
					echo "<div class='col-xs-12 col-sm-3 col-md-3' >";
				}


				if($data->status == 1){
					$status = "<div class='audios_status1' >Online</div>";
				} else {
					$status = "<div class='audios_status2' >Offline</div>";
				}

				echo " 
				<div class='audios_div' >
				<div class='row' >

				<div class='col-xs-4 col-sm-3 col-md-3' >
				<div class='audios_img' style='background-image:url(".PASTA_CLIENTE."img_audios/".$data->imagem.")' ></div>
				<div class='audios_titulo'  >
				".$data->titulo."
				";

				if($data->previa){
					echo "<div class='audios_descricao' >".$data->previa."</div>";
				}

				echo "
				</div>
				<div style='clear:both'></div>
				</div>

				<div class='col-xs-4 col-sm-2 col-md-2' >
				<div class='audios_tempo' >".$data->tempo."</div>
				</div>

				<div class='col-xs-4 col-sm-2 col-md-2' >
				$status
				</div>

				<div class='col-xs-12 col-sm-5 col-md-5' >
				<div class='audios_conteudo' >
				<audio controls='controls'>
				<source src='".PASTA_CLIENTE."audios/".$data->arquivo."' type='audio/mp3' />
				O seu navegador não suporta o elemento <code>audio</code>.
				</audio>
				</div>
				</div>
				
				</div>
				</div>
				</div>
				";

				$ntotal++;
				if($n_row == $itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

			}

			if($n_row != 1){ echo "</div>"; }

		}

		if($ntotal == 0){
			echo "<div style='text-align:center; margin-top:30px;'>Nenhum resultado</a>";

		}

	}

	public function fotos_categoria(){

		$fotos = new model_fotos();

		$categoria = $this->post('categoria');
		$itens_por_linha = $this->post('itens_por_linha'); 
		$formato = $this->post('formato');
		$max_itens = $this->post('max_itens');

		if($categoria)	{

			$n_row = 1;
			$total_n = 1;
			$lista = array();
			$n = 0;

			if($formato == 'imagens'){

				// imagens aleatorias clicar e ampliar

				echo "<div style='width:100%; padding-bottom:30px; margin-top:30px;' class='ampliar_imagem' >";

				$db = new mysql();
				$exec = $db->Executar("SELECT * FROM fotos WHERE categoria='$categoria' ");
				while($data = $exec->fetch_object()){
					$imagens = $fotos->imagens($data->codigo);
					foreach ($imagens['lista'] as $key2 => $value2) {							
						$lista[$n] = $value2['imagem_g'];
						$n++;
					}
				}

				shuffle($lista);

				foreach ($lista as $key => $value) {

					if($total_n <= $max_itens){

						if($n_row == 1){ echo "<div class='row' style='padding-left:15px; padding-right:15px;' >"; }

						if($itens_por_linha == 1){
							echo "<div class='col-xs-12 col-sm-12 col-md-12' style='padding-left:0px; padding-right:0px;' >";
						}
						if($itens_por_linha == 2){
							echo "<div class='col-xs-12 col-sm-6 col-md-6' style='padding-left:0px; padding-right:0px;' >";
						}
						if($itens_por_linha == 3){
							echo "<div class='col-xs-12 col-sm-4 col-md-4' style='padding-left:0px; padding-right:0px;' >";
						}
						if($itens_por_linha == 4){
							echo "<div class='col-xs-12 col-sm-3 col-md-3' style='padding-left:0px; padding-right:0px;' >";
						}

						echo " 
						<a class='fotos1_div' style='background-image:url(".$value.");' href='".$value."' ></a>
						</div>
						";

						$total_n++;

						if($n_row == $itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

					}
				}
				if($n_row != 1){ echo "</div>"; }

				echo "</div>

				<script> $(function () { $('.ampliar_imagem').photobox('a',{ time:0 }); }); </script>

				";

			} else {

				// albuns clicar e abrir nova pagina 

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM fotos WHERE categoria='".$categoria."' ");
				while($data = $coisas->fetch_object()){

					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['previa'] = $data->previa;
					$imagens = $fotos->imagens($data->codigo);
					$lista[$n]['imagem'] = $imagens['principal'];

					$n++;
				}

				$n_row = 1;
				$total_n = 1;
				foreach ($lista as $key => $value) {
					if($total_n <= $max_itens){

						if($n_row == 1){ echo "<div class='row' >"; }

						if($itens_por_linha == 1){
							echo "<div class='col-xs-12 col-sm-12 col-md-12' >";
						}
						if($itens_por_linha == 2){
							echo "<div class='col-xs-12 col-sm-6 col-md-6' >";
						}
						if($itens_por_linha == 3){
							echo "<div class='col-xs-12 col-sm-4 col-md-4' >";
						}
						if($itens_por_linha == 4){
							echo "<div class='col-xs-12 col-sm-3 col-md-3' >";
						}

						echo " 
						<a class='fotos2_div' style='background-image:url(".$value['imagem'].");' href='".DOMINIO.$this->_controller."/fotos_detalhes/codigo/".$value['codigo']."' ></a>
						<a class='fotos2_titulo' href='".DOMINIO.$this->_controller."/fotos_detalhes/codigo/".$value['codigo']."' >".$value['titulo']."</a>

						</div>
						";

						$total_n++;

						if($n_row == $itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

					}
				}
				if($n_row != 1){ echo "</div>"; }

			}

		}
	}

	public function fotos_detalhes(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->irpara(DOMINIO);
		}

		$fotos = new model_fotos();
		$dados['data'] = $fotos->carregar($codigo);
		$dados['imagens'] = $fotos->imagens($codigo);


		//carrega view e envia dados para a tela
		$this->view('fotos.detalhes', $dados);
	}

	public function edicao_leitura(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->irpara(DOMINIO);
		}


		$conexao = new mysql();
		$coisas_edicao = $conexao->Executar("SELECT * FROM revistajornal WHERE codigo='$codigo' ");
		$dados['data'] = $coisas_edicao->fetch_object();

		$revista_paginas = array();
		$n = 0;

		$conexao = new mysql();
		$coisas_edicao = $conexao->Executar("SELECT * FROM revistajornal_imagem WHERE codigo='$codigo' ORDER by pagina asc ");
		while($data_edicao = $coisas_edicao->fetch_object()){

			$revista_paginas[$n]['pagina'] = $data_edicao->pagina;
			$revista_paginas[$n]['imagem'] = PASTA_CLIENTE.'img_revistajornal_g/'.$data_edicao->imagem;

			$n++;
		}
		$dados['revista_paginas'] = $revista_paginas;


		//carrega view e envia dados para a tela
		$this->view('revista.detalhes', $dados);
	}
	
	public function combo_trilhas(){
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inicial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$id = $this->get('id');

		if(!$id){
			$this->irpara(DOMINIO);
		}


		$conexao = new mysql();
		$result = $conexao->query("SELECT 
									t7.titulo as titulo_combo,
									t6.nome as autor_nome,
									t3.titulo as titulo_produto,
									t4.imagem,
									t1.* 
									FROM produto t1 
									inner join autor t6 on t1.autor = t6.id
									inner join produto_categoria_sel t2 on t1.codigo = t2.produto_codigo 
									inner join produto_categoria t3 on t2.categoria_codigo = t3.codigo 
									inner join combo_produto t5 on t5.id_produto = t1.id
									inner join combos t7 on t7.id = t7.id
									inner join (select max(id) id, codigo, imagem from produto_imagem group by codigo) t4 on t1.codigo=t4.codigo
									WHERE 1 = 1 
									and t5.id_combo = $id 
									group by t5.id_produto");


		$new = array();
		while ($obj = $result->fetch_object()) {
			array_push($new,$obj);
		}

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];

		$dados['novos_cursos'] = $new;
		// echo'<pre>';print_r($dados['novos_cursos']);exit;
		$this->view('combo_trilhas.detalhes', $dados);
	}

	public function canais(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inicial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$id = $this->get('id');

		if(!$id){
			$this->irpara(DOMINIO);
		}

		$conexao = new mysql();


		$canal_config = $conexao->query("SELECT canal.id_canal, canal.banner as bann, canal.bio, canal.email, canal.profile, canal.nm_canal FROM loja.canal where  canal.id_canal = '$id' ");

		$query = null;$inner = null;$campo = null;

		if($_POST['autor']){
			if($_POST['autor'] == 0){
				$query = '';
				$inner = '';
				$campo = '';
			}else{
				$id_autor = $_POST['autor'];
				$query .= " AND autor.id = $id_autor ";
			}
		}
		if($_POST['categoria']){
			if($_POST['categoria'] == 0){
				$query = '';
				$inner = '';
				$campo = '';
			}else{
				$id_categoria = $_POST['categoria'];
				$campo .= " produto_categoria.id as categoria_id, produto_categoria.titulo as categoria, ";
				$inner .= " inner join produto_categoria_sel on produto_categoria_sel.produto_codigo = produto.codigo
							inner join produto_categoria on produto_categoria.codigo = produto_categoria_sel.categoria_codigo ";
				$query .= " AND produto_categoria.id = $id_categoria ";
			}
		}
		if($_POST['estrelas']){
			$estrela = $_POST['estrelas'];
			$campo .= " t2.media_estrela, ";
			$inner .= " inner join curso_produto on curso_produto.id_produto = produto.id
			inner join (select curso_produto.id_produto, round(avg(feedback.estrela),1) as media_estrela 
			from curso_produto         
			inner join curso_feedback        on curso_produto.id_curso  = curso_feedback.id_curso 
			inner join feedback              on curso_feedback.id_feedback  = feedback.id
			group by curso_produto.id_produto) t2 on curso_produto.id_produto = t2.id_produto ";
			$query .= " AND t2.media_estrela <= $estrela ";
		}
		if($_POST['buscar1']){
			if($_POST['buscar1'] == ''){
				$query = '';
				$inner = '';
				$campo = '';
			}else{
				$buscar_campo = $_POST['buscar1'];
				$query .= " AND produto.titulo LIKE '%$buscar_campo%' ";
			}
		}

		$result = $conexao->query("SELECT distinct 
									$campo
									autor.nome as autor_nome,
									canal.id_canal,
									canal.banner as bann,
									canal.bio,
									canal.email,
									canal.profile,
									canal.nm_canal,
									produto.*,
									t1.imagem
									FROM loja.produto 
									inner join loja.autor on produto.autor = autor.id
									inner join loja.produto_canal ON produto.codigo=produto_canal.id_produto 
									inner join loja.canal ON canal.id_canal = produto_canal.id_canal 
									inner join (select max(id) id, codigo, imagem from loja.produto_imagem group by codigo) t1 on produto.codigo=t1.codigo
									$inner
									where  canal.id_canal = '$id' 
									$query
									order by produto.id desc ");

		$avaliacao = $conexao->query("SELECT distinct 
									$campo
									autor.nome as autor_nome,
									produto.avaliacao,
									canal.id_canal,
									canal.banner,
									canal.profile,
									canal.nm_canal,
									produto.*,
									t1.imagem
									FROM loja.produto 
									inner join loja.autor on produto.autor = autor.id
									inner join loja.produto_canal ON produto.codigo=produto_canal.id_produto 
									inner join loja.canal ON canal.id_canal = produto_canal.id_canal 
									inner join (select max(id) id, codigo, imagem from loja.produto_imagem group by codigo) t1 on produto.codigo=t1.codigo
									$inner
									where  canal.id_canal = '$id' 
									$query
									order by produto.avaliacao desc ");

		$canal_conf = array();
		while ($obj_canal = $canal_config->fetch_object()) {
			array_push($canal_conf,$obj_canal);
		}

		$new = array();
		while ($obj = $result->fetch_object()) {
			array_push($new,$obj);
		}
		
		$avaliacao_new = array();
		while ($obj_ava = $avaliacao->fetch_object()) {
			array_push($avaliacao_new,$obj_ava);
		}

		$dados['cat_selecionada'] = ($_POST['categoria'] > 0 ? $_POST['categoria'] : 0);
		$dados['autor_selecionado'] = ($_POST['autor'] > 0 ? $_POST['autor'] : 0);
		$dados['buscar_campo'] = $_POST['buscar1'];
		$dados['estrelas_campo'] = ($_POST['estrelas'] > 0 ? $_POST['estrelas'] : 0);
		$produtos = new model_produtos();
		$dados['categorias'] = $produtos->lista_categorias();
		$dados['autores'] = $produtos->lista_autor();

		$dados['novos_cursos'] = $new;
		$dados['canal_config'] = $canal_conf[0];
		$dados['avaliacao_cursos'] = $avaliacao_new;
		// echo '<pre>'; print_r($dados['canal_config']);exit;
		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];

		$this->view('canais.detalhes', $dados);
	}

	public function canal(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inicial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;
		
		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];

		$this->view('canais.lista', $dados);
	}

	public function curso(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inicial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$id = $this->get('id');
		// print_r($id);exit;
		if(!$id){
			$this->irpara(DOMINIO);
		}


		//carrega modulo de produtos
		$cursos = new model_cursos();
		$valores = new model_valores();

		$dados['categorias'] = $cursos->lista_categorias();

		$dados['data'] = $cursos->carrega_curso($id);
		//codigo
		$codigo = $dados['data']->id;
		$dados['curso_conteudo'] = $cursos->curso_conteudo($codigo);
		

		// valor 
		$dados['valor_banco'] = $dados['data']->valor;
		$dados['valor_de'] = $valores->trata_valor($dados['data']->valor_falso);
		$dados['valor_principal'] = $valores->trata_valor($dados['data']->valor);
		$dados['valor_arte_tratado'] = $valores->trata_valor($dados['data']->valor_arte);



		//pega imagens
		$dados['imagens'] = $cursos->imagens($codigo)['imagens'];

 		// tamanhos
		$dados['tamanhos'] = $cursos->tamanhos($codigo);

 		// cores
		$dados['cursos_cores'] = $cursos->cores($codigo);

 		// variacoes
		$dados['variacoes'] = $cursos->variacoes($codigo);


		$opcao_selecionada = $this->get('opcao');
		$dados['opcao_selecionada'] = $opcao_selecionada;

		if(count($dados['variacoes']) >= 1){

			if($opcao_selecionada){
				foreach ($dados['variacoes'] as $key => $value) {
					if($opcao_selecionada == $value['codigo']){						 
						$valor_banco = $value['valor'];
					}
				}
			} else {
				$valor_banco = $dados['variacoes'][0]['valor'];
			}
			$dados['valor_banco'] = $valor_banco;
			$dados['valor_de'] = $valores->trata_valor($dados['valor_banco']);
			$dados['valor_principal'] = $valores->trata_valor($dados['valor_banco']);	
		}

		$tipoarte = $this->get('tipoarte');
		if(!$tipoarte){ $tipoarte = 0; }
		$dados['tipoarte'] = $tipoarte;

		$modelogratisselecionado = $this->get('modelogratisselecionado');
		$dados['modelogratisselecionado'] = $modelogratisselecionado;

		//endereco da noticia		 
		$dados['endereco'] = DOMINIO.$this->_controller."/produto/id/".$dados['data']->id;

		$dados['gabaritos'] = $cursos->gabaritos($codigo);


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM produto_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao .= "<a class='botao_padrao botao_".$data->codigo."' onclick=\"history.go(-1);\" >".$data->texto."</a>";

		} else {
			$botao = "";
		}

		$dados['botao_padrao'] = $botao;

		$db = new mysql();
		$exec = $db->executar("SELECT feedback.* 
								FROM `feedback` 
								inner join curso_feedback on feedback.id = curso_feedback.id_feedback 
								where curso_feedback.id_curso = '$id' ");
		$lista = array();
		$i_ = 0;
		$total_estrelas = 0;
		$estrela1 = 0;	
		$estrela2 = 0;	
		$estrela3 = 0;	
		$estrela4 = 0;	
		$estrela5 = 0;	
		while($data = $exec->fetch_object()) {
			$lista[$i_]['id'] = $data->id;
			$lista[$i_]['nome'] = $data->nome;
			$lista[$i_]['estrela'] = $data->estrela;
			$lista[$i_]['texto'] = $data->texto;
			
			$total_estrelas += $data->estrela;
			if($data->estrela == 5){$estrela5++;}
			if($data->estrela == 4){$estrela4++;}
			if($data->estrela == 3){$estrela3++;}
			if($data->estrela == 2){$estrela2++;}
			if($data->estrela == 1){$estrela1++;}
			$i_++;
		}
		$estrelas = array($estrela5, $estrela4, $estrela3, $estrela2, $estrela1);

		$total_aulas = 0;
		$seconds = 0;
		foreach($dados['curso_conteudo'] as $row){
			foreach($row['conteudo'] as $cont){
				list( $g, $i, $s ) = explode( ':', $cont['duracao'] ); 
				$seconds += $g * 3600;
				$seconds += $i * 60;
				$seconds += $s;
			}
			$total_aulas += count($row['conteudo']);
		}
		$hours = floor( $seconds / 3600 );
		$seconds -= $hours * 3600;
		$minutes = floor( $seconds / 60 );
		$seconds -= ($minutes * 60);
		
		if($hours > 0 ){$hours = $hours.'hrs ';}else{$hours = '';};
		if($minutes > 0 ){$minutes = $minutes.'min ';}else{$minutes = '';};
		if($seconds > 0 ){$seconds = $seconds.'seg ';}else{$seconds = '';};
		
		$total_minutos = $hours.' '.$minutes.' '.$seconds;


		$dados['estrelas'] = $estrelas;
		$dados['lista_feedback'] = $lista;
		// echo'<pre>';print_r($dados['lista_feedback']);exit;
	
		$dados['total_estrelas'] = number_format(($total_estrelas)/$i_, 1, ',', ',');
		$dados['qtd_conteudo'] = count($dados['curso_conteudo']);
		$dados['total_aulas'] = $total_aulas;
		$dados['total_minutos'] = $total_minutos;
		// echo'<pre>';print_r($dados);exit;
		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];

		$this->view('cursos.detalhes', $dados);
	}

	public function produto(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inicial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$id = $this->get('id');
		// print_r($id);exit;
		if(!$id){
			$this->irpara(DOMINIO);
		}


		//carrega modulo de produtos
		$produtos = new model_produtos();
		$valores = new model_valores();

		$dados['categorias'] = $produtos->lista_categorias();

		// echo'<pre>';print_r($dados['categorias']);exit;
		$dados['data'] = $produtos->carrega_produto($id);
		//codigo
		$codigo = $dados['data']->codigo;

		// valor 
		$dados['valor_banco'] = $dados['data']->valor;
		$dados['valor_de'] = $valores->trata_valor($dados['data']->valor_falso);
		$dados['valor_principal'] = $valores->trata_valor($dados['data']->valor);
		$dados['valor_arte_tratado'] = $valores->trata_valor($dados['data']->valor_arte);



		//pega imagens
		$dados['imagens'] = $produtos->imagens($codigo)['imagens'];

 		// tamanhos
		$dados['tamanhos'] = $produtos->tamanhos($codigo);

 		// cores
		$dados['produtos_cores'] = $produtos->cores($codigo);

 		// variacoes
		$dados['variacoes'] = $produtos->variacoes($codigo);


		$opcao_selecionada = $this->get('opcao');
		$dados['opcao_selecionada'] = $opcao_selecionada;

		if(count($dados['variacoes']) >= 1){

			if($opcao_selecionada){
				foreach ($dados['variacoes'] as $key => $value) {
					if($opcao_selecionada == $value['codigo']){						 
						$valor_banco = $value['valor'];
					}
				}
			} else {
				$valor_banco = $dados['variacoes'][0]['valor'];
			}
			$dados['valor_banco'] = $valor_banco;
			$dados['valor_de'] = $valores->trata_valor($dados['valor_banco']);
			$dados['valor_principal'] = $valores->trata_valor($dados['valor_banco']);	
		}

		$tipoarte = $this->get('tipoarte');
		if(!$tipoarte){ $tipoarte = 0; }
		$dados['tipoarte'] = $tipoarte;

		$modelogratisselecionado = $this->get('modelogratisselecionado');
		$dados['modelogratisselecionado'] = $modelogratisselecionado;

		//endereco da noticia		 
		$dados['endereco'] = DOMINIO.$this->_controller."/produto/id/".$dados['data']->id;

		$dados['gabaritos'] = $produtos->gabaritos($codigo);


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM produto_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao .= "<a class='botao_padrao botao_".$data->codigo."' onclick=\"history.go(-1);\" >".$data->texto."</a>";

		} else {
			$botao = "";
		}
		$dados['botao_padrao'] = $botao;

		$db = new mysql();
		$exec = $db->executar("SELECT cursos.* 
								FROM `cursos` 
								inner join curso_produto on cursos.id = curso_produto.id_curso
								where curso_produto.id_produto = '$id' ");
		$lista = array();
		$i = 0;
		while($data = $exec->fetch_object()) {
			$lista[$i]['id'] = $data->id;
			$lista[$i]['nome'] = $data->nome;
			$lista[$i]['capa'] = $data->capa;
			$lista[$i]['qtd_feedback'] = $data->qtd_feedback;
			$lista[$i]['duracao'] = $data->duracao;
			$lista[$i]['avaliacao'] = $data->avaliacao;
			$lista[$i]['descricao'] = $data->descricao;
			$lista[$i]['descricao_card'] = $data->descricao_card;
			$lista[$i]['texto_livre'] = $data->texto_livre;
			$lista[$i]['summary'] = $data->summary;
			$lista[$i]['previa'] = $data->previa;
			$lista[$i]['comentarios_id'] = $data->texto_livre;
			$lista[$i]['esconder'] = $data->esconder;
			
			$exec2 = $db->executar("SELECT feedback.* 
								FROM `feedback` 
								inner join curso_feedback on feedback.id = curso_feedback.id_feedback 
								where curso_feedback.id_curso = '$data->id' ");
			
			$i_ = 0;
			$total_estrelas = 0;
			$estrela1 = 0;$estrela2 = 0;$estrela3 = 0;$estrela4 = 0;$estrela5 = 0;	
			
			while($data2 = $exec2->fetch_object()) {
				$total_estrelas += $data2->estrela;
				if($data2->estrela == 5){$estrela5++;}
				if($data2->estrela == 4){$estrela4++;}
				if($data2->estrela == 3){$estrela3++;}
				if($data2->estrela == 2){$estrela2++;}
				if($data2->estrela == 1){$estrela1++;}
				$i_++;
			}

			$total_aulas = 0;
			$seconds = 0;
			$cursos = new model_cursos();
			$dados1['curso_conteudo'] = $cursos->curso_conteudo($data->id);

			foreach($dados1['curso_conteudo'] as $row_){
				foreach($row_['conteudo'] as $cont){
					list( $g, $i__, $s ) = explode( ':', $cont['duracao'] ); 
					$seconds += $g * 3600;
					$seconds += $i__ * 60;
					$seconds += $s;
				}
				$total_aulas += count($row_['conteudo']);
			}
			$hours = floor( $seconds / 3600 );
			$seconds -= $hours * 3600;
			$minutes = floor( $seconds / 60 );
			$seconds -= ($minutes * 60);
			
			if($hours > 0 ){$hours = ' '.$hours.'hrs ';}else{$hours = '';};
			if($minutes > 0 ){$minutes = $minutes.'min ';}else{$minutes = '';};
			if($seconds > 0 ){$seconds = $seconds.'seg ';}else{$seconds = '';};
			$total_minutos = $hours.' '.$minutes.' '.$seconds;

			$lista[$i]['total_minutos'] = $total_minutos;
			// $lista[$i]['total_estrelas'] = ($total_estrelas)/$i_;
			$lista[$i]['total_estrelas'] = number_format(($total_estrelas)/$i_, 1, ',', ',');
			$lista[$i]['qtd_feedbacks'] = $i_;

			$i++;
		}

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];

		$dados['lista_cursos'] = $lista;
		// echo'<pre>';print_r($dados['lista_cursos']);exit;
		$this->view('produtos.detalhes', $dados);
	}

	public function produto_tipoarte(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['controller'] = $this->_controller;

		$produto = $this->post('produto');
		$opcao = $this->post('id');
		if(!$opcao){
			echo "Erro, selecione uma opção válida!";
			exit;
		}
		if(!$produto){
			echo "Erro, produto inválido!";
			exit;
		}
		$dados['opcao'] = $opcao;
		$dados['produto'] = $produto;
		$dados['opcao_variacoes'] = $this->get('opcao');

		$produtos = new model_produtos();
		$dados['acabamentos'] = $produtos->acabamentos();

		$modelogratisselecionado = $this->post('modelogratisselecionado');
		if($modelogratisselecionado){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM produto_modelos WHERE codigo='$modelogratisselecionado' ");
			$data = $exec->fetch_object();

			if($data->titulo){
				$dados['modelo_selecionado'] = $data->titulo;
				$dados['modelo_selecionado_codigo'] = $modelogratisselecionado;
			} else {
				$dados['modelo_selecionado'] = 'Nenhum';
				$dados['modelo_selecionado_codigo'] = '';
			}

		} else {
			$dados['modelo_selecionado'] = 'Nenhum';
			$dados['modelo_selecionado_codigo'] = '';
		}


		$this->view('produtos.detalhes.opcoes', $dados);
	}

	public function produto_modelos_gratis(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['controller'] = $this->_controller;

		$produto = $this->get('produto');
		if(!$produto){
			echo "Erro, produto inválido!";
			exit;
		}

		$produtos = new model_produtos();
		$categorias = $produtos->modelos_gratis_categorias();
		$dados['categorias'] = $produtos->modelos_gratis_categorias();
		$dados['produto'] = $produto;

		$this->view('produtos.detalhes.modelos_gratis', $dados);
	}

	public function produto_modelos_gratis_lista(){

		$dados = array();
		$dados['_base'] = $this->_base(); 

		$produto = $this->post('produto');
		if(!$produto){
			echo "Erro, produto inválido!";
			exit;
		}
		$categoria = $this->post('categoria');
		if(!$categoria){
			echo "Erro, categoria inválida!";
			exit;
		}

		//pega o id do produto para o link
		$db = new mysql();
		$exec = $db->executar("SELECT id FROM produto WHERE codigo='$produto' ");
		$data = $exec->fetch_object();
		$id_produto = $data->id;

		echo "<div style='font-weight:bold; text-align:center; margin-top:20px;'>Selecione um modelo</div>";

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_modelos WHERE categoria='$categoria' order by titulo asc");
		while($data = $exec->fetch_object()) {

			$db = new mysql();
			$exec2 = $db->executar("SELECT * FROM produto_modelos_sel WHERE produto_codigo='$produto' AND layout_codigo='$data->codigo' ");
			if($exec2->num_rows != 0){

				echo "
				<a style='display:block; width:100%; margin-top:20px;' href='".DOMINIO.$this->_controller."/produto/id/".$id_produto."/modelogratisselecionado/".$data->codigo."/tipoarte/1' >
				<span style='display:block; width:100%; text-align:center; font-size:15px; font-weight:bold;' >".$data->titulo."</span>
				<img src='".PASTA_CLIENTE."img_produtos_modelos/".$data->imagem."' style='width:100%;' >
				</a>
				";

			}
		}		
	}

	public function detalhes_estoque(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$id = $this->post('id');
		$codigo = $this->post('produto');

		$tamanho = $this->post('tamanho');
		if(!$tamanho){
			$tamanho = '-';
		}

		$cor = $this->post('cor');
		if(!$cor){
			$cor = '-';
		}

		$variacao = $this->post('variacao');
		if(!$variacao){
			$variacao = '-';
		}

		//carrega modulo de produtos
		$produtos = new model_produtos();

		$data_produto = $produtos->carrega_produto($id);		 

		// print_r($data_produto->assinatura);

        //confere se tem opcoes de seleçao 
		$i = 0;
		$mensagem_selecao = '';

		$conexao = new mysql();
		$coisas_det = $conexao->Executar("SELECT * FROM produto_variacao_sel where produto_codigo='$codigo' ");
		while($data_det = $coisas_det->fetch_object()){
			$conexao = new mysql();
			$data_det2 = $conexao->Executar("SELECT id FROM produto_variacao where codigo='$data_det->variacao_codigo' ")->fetch_object();
			if(isset($data_det2->id)){
				if($variacao == 0){ $i++; $mensagem_selecao = 'Selecione uma opção.'; }
			}
		}
		$conexao = new mysql();
		$coisas_det = $conexao->Executar("SELECT * FROM produto_cor_sel where produto_codigo='$codigo' ");
		while($data_det = $coisas_det->fetch_object()){
			$conexao = new mysql();
			$data_det2 = $conexao->Executar("SELECT id FROM produto_cor where codigo='$data_det->cor_codigo' ")->fetch_object();
			if(isset($data_det2->id)){
				if($cor == 0){ $i++; $mensagem_selecao = 'Selecione uma cor.'; }
			}        
		}
		$conexao = new mysql();
		$coisas_det = $conexao->Executar("SELECT * FROM produto_tamanho_sel where produto_codigo='$codigo' ");
		while($data_det = $coisas_det->fetch_object()){
			$conexao = new mysql();
			$data_det2 = $conexao->Executar("SELECT id FROM produto_tamanho where codigo='$data_det->tamanho_codigo' ")->fetch_object();
			if(isset($data_det2->id)){
				if($tamanho == 0){ $i++; $mensagem_selecao = 'Selecione um tamanho.'; }
			}             
		}


		if($i == 0){

            //confere se nao é venda sem estoque
			if($data_produto->semestoque == 0){

				$estoque_total = $produtos->estoque_quantidade($codigo, $tamanho, $cor, $variacao);

                //confere se tem estoque disponivel
				if($estoque_total >= 1){

					if($estoque_total == 1){
						$disponiveis =  "<div style='font-size:13px;'>".$estoque_total." Disponível</div>";
					} else {
						$disponiveis =  "<div style='font-size:13px;'>".$estoque_total." Disponíveis</div>";
					}

					if($data_produto->assinatura == 1){
						echo '
						<span>
						<button type="button" class="btn btn-fefault cart" onClick="submit(\'add_carrinho\')" >
						Assinar
						</button>
						<input type="hidden" name="produto" value="'.$codigo.'" >

						<div style="padding-top:10px;" >'.$disponiveis.'</div>
						</span>
						';
					}else{
						echo '
						<span>
						<button type="button" class="btn btn-fefault cart" onClick="submit(\'add_carrinho\')" >
						Comprar agora
						</button>
						<input type="hidden" name="produto" value="'.$codigo.'" >

						<div style="padding-top:10px;" >'.$disponiveis.'</div>
						</span>
						';
					}

				} else {
					echo "
					<div style='padding-top:5px; color:red;' >Produto indisponível</div>
					";
				}

			} else {
				if($data_produto->assinatura == 1){
					echo '
						<span>                                     
						<button type="button" class="btn btn-fefault cart" onClick="submit(\'add_carrinho\')" >
						Assinar
						</button>
						<input type="hidden" name="produto" value="'.$codigo.'" >
						</span>
						';
				}else{
					echo '
						<span>                                     
						<button type="button" class="btn btn-fefault cart" onClick="submit(\'add_carrinho\')" >
						Comprar agora
						</button>
						<input type="hidden" name="produto" value="'.$codigo.'" >
						</span>
						';
				}

				

			}

		} else {
			echo "
			<div>$mensagem_selecao</div>
			";
		}

	}

	public function produto_enviar_anexo(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;



		$this->view('produtos.enviar_anexo', $dados);
	}

	public function produto_enviar_anexo_grv(){

		$dir = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'arquivos'.DIRECTORY_SEPARATOR.'uploads';

		if(isset($_FILES['file'])){

			$arquivo = $_FILES['file'];
			$nomenovo = time().'_'.$_FILES['file']['name'];

			$modelarquivo = new model_arquivos_imagens();
			if(!$modelarquivo->filtro($arquivo)){

				$retorno = array();
				$retorno['status'] = "erro";
				$retorno['msg'] = "Arquivo com formato inválido ou inexistente!";
				echo json_encode($retorno);

			} else {

				if(move_uploaded_file($_FILES['file']['tmp_name'], $dir . DIRECTORY_SEPARATOR . $nomenovo )){
					$retorno = array();
					$retorno['status'] = "ok";
					$retorno['msg'] = "Envio Concluido!";
					$retorno['nomearquivo'] = $nomenovo;
					echo json_encode($retorno);
				}else{
					$retorno = array();
					$retorno['status'] = "erro";
					$retorno['msg'] = "Erro de upload, arquivo muito grande ou com algum defeito.";
					echo json_encode($retorno);
				}

			}
		}
	}

	public function balcoes(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$estados = new model_estados_cidades();
		$dados['estados'] = $estados->lista_estados();

		$this->view('produtos.balcoes', $dados);
	}

	public function balcoes_cidades(){

		$estado = $this->post('estado');
		$selecionado = $this->post('selecionado');

		echo "
		<select id='cidade' name='cidade' class='form-control select2' onChange=\"lista_balcoes('".$estado."',this.value);\" >
		<option value='' >Selecione</option>
		";

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cidade where uf='$estado' order by nome asc ");
		while($data = $exec->fetch_object()){

			$db = new mysql();
			$exec2 = $db->executar("SELECT id FROM balcoes where uf='$estado' AND cidade='$data->nome' ");			
			$itens = $exec2->num_rows;

			if($itens != 0){

				if($selecionado == $data->nome){
					$selected = " selected='' ";
				} else {
					$selected = "";
				}

				echo "<option value='".$data->nome."' $selected >".$data->nome."</option>";
			}
		}

		echo "
		</select>

		<script> $(function () { $('.select2').select2(); }); </script>
		";

	}

	public function balcoes_lista(){

		$uf = $this->post('estado');
		$cidade = $this->post('cidade');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM balcoes WHERE uf='$uf' AND cidade='$cidade' order by id asc");
		while($data = $exec->fetch_object()) {

			echo "
			<div style='text-align:left; font-size:15px; width:100%;' >

			<div style='font-weight:bold; color:#000;'>".$data->titulo."</div>

			<div style='margin-top:5px; color:#333;'>".nl2br($data->descricao)."</div>

			<hr>

			</div>
			";

		}

	}

	public function balcoes_lista_carrinho(){

		$uf = $this->post('estado');
		$cidade = $this->post('cidade');
		$subtotal = $this->post('subtotal');
		$selecionado = $this->post('selecionado');

		$valores = new model_valores();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM balcoes WHERE uf='$uf' AND cidade='$cidade' order by id asc");
		while($data = $exec->fetch_object()) {

			if($selecionado == $data->codigo){ $select = "checked"; } else { $select = ""; }
			$valor_tratado = $valores->trata_valor($data->valor);

			echo "
			<div style='padding-top:5px; '>
			<input type='radio' name='frete' id='frete_".$data->id."' value='".$data->codigo."' onChange=\"window.location='".DOMINIO.$this->_controller."/selecionar_balcao/codigo/".$data->codigo."/valor_subtotal/".$subtotal."'\" $select style='cursor:pointer;' > <label for='frete_".$data->id."' style='font-weight:normal; cursor:pointer;' >".$data->titulo." - <strong> R$ ".$valor_tratado."</strong></label>
			</div>
			";

		}

	}

	public function carrinho(){
		$dados = array();
		$dados['_base'] = $this->_base();
		// echo '<pre>';print_r($dados);exit;
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;
		// print_r($this->_sessao);

		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;



		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM produto_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_car' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


		// CARRINHO


		// carrega modulo de produtos
		$produtos = new model_produtos(); 

		//carrega modulo de produtos
		$carrinho = new model_carrinho();
		$valores = new model_valores();
		$fretes = new model_fretes();
		$formas_pg = new model_formas_pg();

		$dados['carrinho'] = $carrinho->carrinho($this->_sessao); 
		// echo'<pre>';print_r($dados['carrinho']);exit;
		$dados['itens_n'] = 0;

		$dados['tipo_envio'] = 0;
		foreach ($dados['carrinho']['lista'] as $key => $value) {
			$dados['tipo_envio'] = $value['tipo_envio'];
		}
		
		$dados['itens_n'] = count($dados['carrinho']['lista']);

		$dados['cep_destino'] = '';

		// se foi criado o pedido
		if($dados['carrinho']['pedido']){		 

			$dados['data_pedido'] = $carrinho->carrega($this->_sessao);

			$dados['cep_destino'] = $dados['data_pedido']->cep_destino;

			$valor_subtotal = $dados['carrinho']['subtotal'];


			///////////////////////////
	       	// frete

			$dados['balcoes_lista'] = $fretes->lista_balcoes();

			///////////////////////////
			// cupom
			$dados['minimo_compra'] = 'R$ 0,00';
			if($dados['data_pedido']->cupom){

				$conexao = new mysql();
				$coisas_cupom = $conexao->Executar("SELECT * FROM cupom_lista where cupom='".$dados['data_pedido']->cupom."' ");
				$data_cupom = $coisas_cupom->fetch_object();

				if(isset($data_cupom->codigo)){

					$conexao = new mysql();
					$coisas_promo = $conexao->Executar("SELECT * FROM cupom WHERE codigo='$data_cupom->codigo' ");
					$data_promo = $coisas_promo->fetch_object();

					$dados['minimo_compra'] = 'R$ '.$valores->trata_valor($data_promo->valor_minimo);

					//minimo de compra
					if($valor_subtotal > $data_promo->valor_minimo){

						if($dados['data_pedido']->cupom_desconto_porc > 0){

							$percentual = $dados['data_pedido']->cupom_desconto_porc / 100.0;
							$valor_desconto_cupom = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
							$valor_desconto_cupom = $dados['data_pedido']->cupom_desconto_fixo + $valor_desconto_cupom;

						} else {
							$valor_desconto_cupom = $dados['data_pedido']->cupom_desconto_fixo;
						}

					} else {
						$valor_desconto_cupom = 0;
					} 

				}

			} else {
				$valor_desconto_cupom = 0;
			}

			$dados['valor_desconto_cupom'] = $valor_desconto_cupom;
			$dados['valor_desconto_cupom_tratado'] = $valores->trata_valor($valor_desconto_cupom);

	       	///////////////////////////
	       	// descontos da forma de pagamento

			$dados['pagamento_lista'] = $formas_pg->lista($dados['data_pedido']->forma_pagamento);

			if($dados['data_pedido']->forma_pagamento){

				if($dados['data_pedido']->forma_pagamento_desc_porc > 0){

					$percentual = $dados['data_pedido']->forma_pagamento_desc_porc / 100.0;
					$valor_desconto_forma_pag = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
					$valor_desconto_forma_pag = $dados['data_pedido']->forma_pagamento_desc_fixo + $valor_desconto_forma_pag;

				} else {
					$valor_desconto_forma_pag = $dados['data_pedido']->forma_pagamento_desc_fixo;
				}

			} else {
				$valor_desconto_forma_pag = 0;
			}
			$dados['valor_desconto_forma_pag'] = $valor_desconto_forma_pag;
			$dados['valor_desconto_forma_pag_tratado'] = $valores->trata_valor($valor_desconto_forma_pag);


	       	///////////////////////////
	       	//calculo total
			$dados['valor_frete_tratado'] = $valores->trata_valor($dados['data_pedido']->frete_valor);
			$valor_total_pedido = ( ( $valor_subtotal - $valor_desconto_cupom ) - $valor_desconto_forma_pag ) + $dados['data_pedido']->frete_valor;

			if($valor_total_pedido < 0){
				$valor_total_pedido = 0;
			}

			$dados['valor_total_pedido'] = $valor_total_pedido;
			$dados['valor_total_pedido_tratado'] = $valores->trata_valor($valor_total_pedido);

		}

		$estados = new model_estados_cidades();
		$dados['estados'] = $estados->lista_estados();

		if(isset($dados['data_pedido'])){
			if($dados['data_pedido']->frete_balcao){

				$conexao = new mysql();
				$coisas_balcao = $conexao->Executar("SELECT * FROM balcoes WHERE codigo='".$dados['data_pedido']->frete_balcao."' ");
				$dados['data_balcao'] = $coisas_balcao->fetch_object();

			} else {
				$dados['data_balcao'] = null;
			}
		} else {
			$dados['data_balcao'] = null;
		}

		if($this->_cod_usuario){
			$cadastro = new model_cadastro();
			$dados['data_dados'] = $cadastro->dados_usuario($this->_cod_usuario);
		}

		$dados['logado_cep'] = 0;

		// se tiver logado pega o cep do cadastro
		if( isset($_SESSION[$this->_sessao_principal]['loja_acesso']) AND isset($_SESSION[$this->_sessao_principal]['loja_cod_usuario']) AND isset($_SESSION[$this->_sessao_principal]['loja_cod_sessao']) ) {
			$dados['logado_cep'] = 1;
			$cadastro_model = new model_cadastro();
			$data_cadastro = $cadastro_model->dados_usuario($this->_cod_usuario);
			$dados['cep_destino'] = str_replace(array(" ", ".", "-"), "", $data_cadastro->cep);
		}

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
 		//carrega view e envia dados para a tela
		$this->view('carrinho', $dados);
	}

	public function lista_valores(){

		$dados = array();
		$dados['_base'] = $this->_base();

		//carrega modulo de produtos
		$carrinho = new model_carrinho();
		$valores = new model_valores();
		$formas_pg = new model_formas_pg();

		$dados['carrinho'] = $carrinho->carrinho($this->_sessao); 

		// se foi criado o pedido
		if($dados['carrinho']['pedido']){		 

			$dados['data_pedido'] = $carrinho->carrega($this->_sessao);

			$valor_subtotal = $dados['carrinho']['subtotal'];

			///////////////////////////
			// cupom
			$dados['minimo_compra'] = 'R$ 0,00';
			if($dados['data_pedido']->cupom){

				$conexao = new mysql();
				$coisas_cupom = $conexao->Executar("SELECT * FROM cupom_lista where cupom='".$dados['data_pedido']->cupom."' ");
				$data_cupom = $coisas_cupom->fetch_object();

				if(isset($data_cupom->codigo)){

					$conexao = new mysql();
					$coisas_promo = $conexao->Executar("SELECT * FROM cupom WHERE codigo='$data_cupom->codigo' ");
					$data_promo = $coisas_promo->fetch_object();

					$dados['minimo_compra'] = 'R$ '.$valores->trata_valor($data_promo->valor_minimo);

					//minimo de compra
					if($valor_subtotal > $data_promo->valor_minimo){

						if($dados['data_pedido']->cupom_desconto_porc > 0){

							$percentual = $dados['data_pedido']->cupom_desconto_porc / 100.0;
							$valor_desconto_cupom = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
							$valor_desconto_cupom = $dados['data_pedido']->cupom_desconto_fixo + $valor_desconto_cupom;

						} else {
							$valor_desconto_cupom = $dados['data_pedido']->cupom_desconto_fixo;
						}

					} else {
						$valor_desconto_cupom = 0;
					} 

				}

			} else {
				$valor_desconto_cupom = 0;
			}

			$dados['valor_desconto_cupom'] = $valor_desconto_cupom;
			$dados['valor_desconto_cupom_tratado'] = $valores->trata_valor($valor_desconto_cupom);

	       	///////////////////////////
	       	// descontos da forma de pagamento

			$dados['pagamento_lista'] = $formas_pg->lista($dados['data_pedido']->forma_pagamento);

			if($dados['data_pedido']->forma_pagamento){

				if($dados['data_pedido']->forma_pagamento_desc_porc > 0){

					$percentual = $dados['data_pedido']->forma_pagamento_desc_porc / 100.0;
					$valor_desconto_forma_pag = $valores->trata_valor_calculo( $percentual * $valor_subtotal );
					$valor_desconto_forma_pag = $dados['data_pedido']->forma_pagamento_desc_fixo + $valor_desconto_forma_pag;

				} else {
					$valor_desconto_forma_pag = $dados['data_pedido']->forma_pagamento_desc_fixo;
				}

			} else {
				$valor_desconto_forma_pag = 0;
			}
			$dados['valor_desconto_forma_pag'] = $valor_desconto_forma_pag;
			$dados['valor_desconto_forma_pag_tratado'] = $valores->trata_valor($valor_desconto_forma_pag);


	       	///////////////////////////
	       	//calculo total
			$dados['valor_frete_tratado'] = $valores->trata_valor($dados['data_pedido']->frete_valor);
			$valor_total_pedido = ( ( $valor_subtotal - $valor_desconto_cupom ) - $valor_desconto_forma_pag ) + $dados['data_pedido']->frete_valor;

			if($valor_total_pedido < 0){
				$valor_total_pedido = 0;
			}

			$dados['valor_total_pedido'] = $valor_total_pedido;
			$dados['valor_total_pedido_tratado'] = $valores->trata_valor($valor_total_pedido);

			$this->view('carrinho_valores', $dados);

		} else {
			echo '.';
		}

	}

	public function lista_carrinho(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$carrinho = new model_carrinho();
		$dados['carrinho'] = $carrinho->carrinho($this->_sessao);

		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM produto_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_car' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;
		// echo '<pre>';print_r($dados['carrinho']);exit;
		$this->view('carrinho_lista', $dados);
	}

	public function carrinho_adicionar(){	
		$dados = array();
		$dados['_base'] = $this->_base();

		$produtos = new model_produtos();

		$cod_sessao = $this->_sessao;
		if($_POST['produto']){
			$produto = $_POST['produto'];
		}else if($this->get('produto')){
			$produto = $this->get('produto'); 
		}
		else if($this->get('combo')){
			$combo = $this->get('combo'); 
			$produto = array();
			$conexao = new mysql();
			$coisas_det = $conexao->Executar("SELECT produto.codigo 
													FROM produto 
													inner join combo_produto on combo_produto.id_produto = produto.id
													where id_combo='$combo' ");
			while($data_det = $coisas_det->fetch_object()){
				array_push($produto,$data_det->codigo);
			}
		}
		if(!is_array($produto)){	
			$conexao = new mysql();
			$coisas_carrinho = $conexao->Executar("SELECT id FROM pedido_loja_carrinho where sessao='".$this->_sessao."' and produto='".$produto."' ");
			$data_carrinho = $coisas_carrinho->fetch_object();
			if($data_carrinho){
				$this->msg('Produto já adicionado no carrinho!');
				$this->volta(1);
			}

			$quantidade = $this->post('quantidade');
			if(!$produto){
				$this->msg('Produto não indentificado!1');
				$this->volta(1);
			}
			if(!$quantidade){
				$quantidade = 1;
			}
			if( (!$quantidade) OR ($quantidade <= 0) ){
				$this->msg('Quantidade inválida!');
				$this->volta(1);
			}

			//confere se ja existe o pedido senão cria um novo pedido
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM pedido_loja where codigo='".$this->_sessao."' ");
			$data = $coisas->fetch_object();

			if(!isset($data->id)){

				$time = time();
				$ip = $_SERVER["REMOTE_ADDR"];

				//grava no banco
				$conexao = new mysql();
				$conexao->inserir("pedido_loja", array(
					"codigo"=>"$cod_sessao",
					"data"=>"$time",
					"ip"=>"$ip",
					"status"=>"0"
				));

			} else {

				//confere se o pedido foi finalizado
				if($data->status != 0){
					$this->irpara(DOMINIO.$this->_controller."/carrinho");
				} else {
					//zera dados de frete
					$conexao = new mysql();
					$conexao->alterar("pedido_loja", array(
						"frete"=>"",
						"frete_titulo"=>"",
						"frete_valor"=>"",
						"valor_produtos"=>"0",
						"valor_produtos_desc"=>"0",
						"valor_total"=>"0",
						"status"=>"0"
					), " sessao='$cod_sessao' ");
				}			
			}

			// produto
			$data_produto = $produtos->carrega_produto_codigo($produto);

			//verifica se o produto existe
			if(isset($data_produto->id)){
				
				$tipo_envio = $data_produto->tipo_entrega;
				// print_r($tipo_envio);exit;
				$conexao = new mysql();
				$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$cod_sessao' AND tipo_envio!='$tipo_envio' ");
				$linha_carrinho = $coisas_carrinho->num_rows;
				// if($linha_carrinho != 0){			
				// 	$this->msg('Você não pode adicionar produtos com frete diferentes');
				// 	$this->volta(1);
				// }
				//verifica obrigaçao do campo Tamanho
				$tamanho = $this->post('tamanho');
				if(!$tamanho){

					$conexao = new mysql();
					$coisas_det = $conexao->Executar("SELECT * FROM produto_tamanho_sel where produto_codigo='$produto' ");
					$i = 0;
					while($data_det = $coisas_det->fetch_object()){

						$conexao = new mysql();
						$data_det2 = $conexao->Executar("SELECT id FROM produto_tamanho where codigo='$data_det->tamanho_codigo' ")->fetch_object();

						if(isset($data_det2->id)){
							$i++;
						}
					}
					if($i != 0){
						$this->msg('Selecione o tamanho!');
						$this->volta(1);
					}
				}		
				//verifica obrigaçao do campo Cor
				$cor = $this->post('cor');
				if(!$cor){

					$conexao = new mysql();
					$coisas_det = $conexao->Executar("SELECT * FROM produto_cor_sel where produto_codigo='$produto' ");
					$i = 0;
					while($data_det = $coisas_det->fetch_object()){

						$conexao = new mysql();
						$data_det2 = $conexao->Executar("SELECT id FROM produto_cor where codigo='$data_det->cor_codigo' ")->fetch_object();

						if(isset($data_det2->id)){
							$i++;
						}
					}
					if($i != 0){
						$this->msg('Selecione uma cor!');
						$this->volta(1);
					}
				}
				//verifica obrigaçao do campo variacao
				$variacao = $this->post('variacao');
				if(!$variacao){

					$conexao = new mysql();
					$coisas_det = $conexao->Executar("SELECT * FROM produto_variacao_sel where produto_codigo='$produto' ");
					$i = 0;
					while($data_det = $coisas_det->fetch_object()){

						$conexao = new mysql();
						$data_det2 = $conexao->Executar("SELECT id FROM produto_variacao where codigo='$data_det->variacao_codigo' ")->fetch_object();

						if(isset($data_det2->id)){
							$i++;
						}
					}
					if($i != 0){
						$this->msg('Selecione uma variação!');
						$this->volta(1);
					}
				}
				// valor base
				$valor_total = $data_produto->valor;
				$valores = new model_valores();
				$variacao = $this->post('variacao');
				if($variacao){

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM produto_variacao where codigo='$variacao' ");
					$data = $coisas->fetch_object();

					$conexao = new mysql();
					$coisas2 = $conexao->Executar("SELECT * FROM produto_variacao_sel where variacao_codigo='$variacao' AND produto_codigo='$produto' ");
					$data2 = $coisas2->fetch_object();

					$variacao_valor = $data2->valor;
					$variacao_titulo = $data->titulo;

					$valor_total = $data2->valor;

				} else {
					$variacao = '-';
					$variacao_valor = 0;
					$variacao_titulo = "";
				}
				$tam_altura = '';
				$tam_largura = '';
				if($data_produto->tipo != 0){

					$tamanho_largura = $valores->trata_valor_banco($this->post('tamanho_largura'));
					$tamanho_altura = $valores->trata_valor_banco($this->post('tamanho_altura'));

					if($data_produto->tipo == 1){
						$tipounidade = 'm';
					}
					if($data_produto->tipo == 2){
						$tipounidade = 'cm';
					}

					$tam_altura = $tamanho_altura.' '.$tipounidade;
					$tam_largura = $tamanho_largura.' '.$tipounidade;

					$valor_total = $tamanho_altura * $tamanho_largura * $valor_total;

				} 
				//tamanho
				if($tamanho){

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM produto_tamanho where codigo='$tamanho' ");
					$data = $coisas->fetch_object();

					$conexao = new mysql();
					$coisas2 = $conexao->Executar("SELECT * FROM produto_tamanho_sel where tamanho_codigo='$tamanho' AND produto_codigo='$produto' ");
					$data2 = $coisas2->fetch_object();

					$tamanho_valor = $data2->valor;
					$tamanho_titulo = $data->titulo;

					$valor_total = $valor_total + $data2->valor;

				} else {
					$tamanho = '-';
					$tamanho_valor = 0;
					$tamanho_titulo = "";
				}
				//Cor
				if($cor){

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM produto_cor where codigo='$cor' ");
					$data = $coisas->fetch_object();

					$conexao = new mysql();
					$coisas2 = $conexao->Executar("SELECT * FROM produto_cor_sel where cor_codigo='$cor' AND produto_codigo='$produto' ");
					$data2 = $coisas2->fetch_object();

					$cor_valor = $data2->valor;
					$cor_titulo = $data->titulo;

					$valor_total = $valor_total + $data2->valor;

				} else {
					$cor = '-';
					$cor_valor = 0;
					$cor_titulo = "";
				}
				// confere estoque se tiver menos do que o selecionado substitui pela quantidade disponivel
				if($data_produto->semestoque == 0){

					$quantidade_disponivel = $produtos->estoque_quantidade($produto, $tamanho, $cor, $variacao);

					if($quantidade_disponivel <= 0){

						$this->msg('Produto indisponível em estoque!');
						$this->volta(1);

					} else {
						if($quantidade > $quantidade_disponivel){
							$quantidade = $quantidade_disponivel;
						}
					}

				}

				if($data_produto->impresso == 1){

					$tipoarte = $this->post('tipoarte');
					if(!$tipoarte){
						$this->msg('Preencha todos os campos obrigatórios');
						$this->volta(1);
					}

					$modelo_codigo = '';
					$dados_arte = '';
					$valor_arte = 0;

					if($tipoarte == 1){

						$modelo_codigo = $this->post('modelo_selecionado_codigo');
						if(!$modelo_codigo){
							$this->msg('Preencha todos os campos obrigatórios');
							$this->volta(1);
						}

						$dados_arte = $this->post('dados_arte');

					}

					if($tipoarte == 2){

						$dados_arte = $this->post('dados_arte');

					// valor arte
						$valor_arte = $data_produto->valor_arte;
						$valor_total = $valor_total + $valor_arte;

					}


					$arte_acabamento = $this->post('arte_acabamento');
					$arquivo_arte = $this->post('arquivo_arte'); 


					if($data_produto->obrigacaodoanexo == 1){
						if($tipoarte == 3){

							if(!$arquivo_arte){
								$this->msg('Favor anexar sua arte para continuar.');
								$this->volta(1);
							}

						}
					}
				} else {
					$tipoarte = 0;
					$modelo_codigo = '';
					$dados_arte = '';
					$valor_arte = 0;
					$arquivo_arte = '';
					$arte_acabamento = '';
				}


				$titulodoproduto = "";

				if($data_produto->material){
					$titulodoproduto .= $data_produto->material.' ';
				}
				if($data_produto->formato){
					$titulodoproduto .= $data_produto->formato.' ';
				}
				if($data_produto->cores){
					$titulodoproduto .= $data_produto->cores.' ';
				}
				if($data_produto->revestimento){
					$titulodoproduto .= $data_produto->revestimento.' ';
				}
				if($data_produto->acabamento){
					$titulodoproduto .= $data_produto->acabamento.' ';
				}

				$data_compra = new DateTime('now');
				$data_compra = $data_compra->format('Y-m-d');
				$data_compra = strtotime($data_compra);

				$date_vencimento = new DateTime('now');
				$period = '+'.$data_produto->data_vencimento. ' month';
				$date_vencimento->modify($period); 
				$date_vencimento = $date_vencimento->format('Y-m-d');
				$date_vencimento = strtotime($date_vencimento);

				//grava no banco
				$conexao = new mysql();
				$conexao->inserir("pedido_loja_carrinho", array(
					"sessao"=>"$cod_sessao",
					"produto"=>"$produto",
					"produto_id"=>"$data_produto->id",
					"produto_ref"=>"$data_produto->ref",
					"produto_titulo"=>"$data_produto->titulo",
					"produto_subtitulo"=>"$titulodoproduto",
					"produto_valor"=>"$data_produto->valor",
					"produto_assinatura"=>0,
					"data_vencimento"=>"$date_vencimento",
					"data_compra"=>"$data_compra",
					"tamanho"=>"$tamanho",
					"tamanho_titulo"=>"$tamanho_titulo",
					"tamanho_valor"=>"$tamanho_valor",
					"cor"=>"$cor",
					"cor_titulo"=>"$cor_titulo",
					"cor_valor"=>"$cor_valor",
					"variacao"=>"$variacao",
					"variacao_titulo"=>"$variacao_titulo",
					"variacao_valor"=>"$variacao_valor",
					"quantidade"=>"$quantidade",
					"valor_arte"=>"$valor_arte",
					"valor_total"=>"$valor_total",
					"tipoarte"=>"$tipoarte",
					"modelo_codigo"=>"$modelo_codigo",
					"dados_arte"=>"$dados_arte",
					"arquivo_arte"=>"$arquivo_arte",
					"arte_acabamento"=>"$arte_acabamento",
					"tipo_envio"=> 3,
					"tam_largura"=>"$tam_largura",
					"tam_altura"=>"$tam_altura"
				));
				/////////////////////// AQUI ///////////////////////

				$this->irpara(DOMINIO.$this->_controller."/carrinho");

			} else {			
				$this->msg('Produto não encontrado!');
				$this->volta(1);
			}
		}else{
			if($this->get('combo')){
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM pedido_loja where codigo='".$this->_sessao."' ");
				$data = $coisas->fetch_object();

				if(!isset($data->id)){
					$time = time();
					$ip = $_SERVER["REMOTE_ADDR"];
					//grava no banco
					$conexao = new mysql();
					$conexao->inserir("pedido_loja", array(
						"codigo"=>"$cod_sessao",
						"data"=>"$time",
						"ip"=>"$ip",
						"status"=>"0"
					));

				} else {
					//confere se o pedido foi finalizado
					if($data->status != 0){
						$this->irpara(DOMINIO.$this->_controller."/carrinho");
					} else {
						//zera dados de frete
						$conexao = new mysql();
						$conexao->alterar("pedido_loja", array(
							"frete"=>"",
							"frete_titulo"=>"",
							"frete_valor"=>"",
							"valor_produtos"=>"0",
							"valor_produtos_desc"=>"0",
							"valor_total"=>"0",
							"status"=>"0"
						), " sessao='$cod_sessao' ");
					}			
				}
				foreach($produto as $prod){
					$combo_id_get = $this->get('combo');
					$data_produto = $produtos->carrega_produto_codigo($prod);
					if(isset($data_produto->id)){
						$conexao = new mysql();
						$tipo_envio = 3;
						$combo_id = null;
						$combo_id = $combo_id_get;
						if($combo_id_get > 0){
							$combo_id = $combo_id_get;
							$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$cod_sessao' AND produto = '$prod' AND id_combo = $combo_id ");
							$linha_carrinho = $coisas_carrinho->num_rows;
							if($linha_carrinho != 0){			
								$this->msg('Você não pode adicionar 2 combos iguais.');
								$this->irpara(DOMINIO.$this->_controller."/carrinho");
							}
						}
						$tamanho = $this->post('tamanho');
						if(!$tamanho){

							$conexao = new mysql();
							$coisas_det = $conexao->Executar("SELECT * FROM produto_tamanho_sel where produto_codigo='$produto' ");
							$i = 0;
							while($data_det = $coisas_det->fetch_object()){

								$conexao = new mysql();
								$data_det2 = $conexao->Executar("SELECT id FROM produto_tamanho where codigo='$data_det->tamanho_codigo' ")->fetch_object();

								if(isset($data_det2->id)){
									$i++;
								}
							}
							if($i != 0){
								$this->msg('Selecione o tamanho!');
								$this->volta(1);
							}
						}		
						$cor = $this->post('cor');
						if(!$cor){

							$conexao = new mysql();
							$coisas_det = $conexao->Executar("SELECT * FROM produto_cor_sel where produto_codigo='$produto' ");
							$i = 0;
							while($data_det = $coisas_det->fetch_object()){

								$conexao = new mysql();
								$data_det2 = $conexao->Executar("SELECT id FROM produto_cor where codigo='$data_det->cor_codigo' ")->fetch_object();

								if(isset($data_det2->id)){
									$i++;
								}
							}
							if($i != 0){
								$this->msg('Selecione uma cor!');
								$this->volta(1);
							}
						}
						$variacao = $this->post('variacao');
						if(!$variacao){
							$conexao = new mysql();
							$coisas_det = $conexao->Executar("SELECT * FROM produto_variacao_sel where produto_codigo='$produto' ");
							$i = 0;
							while($data_det = $coisas_det->fetch_object()){

								$conexao = new mysql();
								$data_det2 = $conexao->Executar("SELECT id FROM produto_variacao where codigo='$data_det->variacao_codigo' ")->fetch_object();

								if(isset($data_det2->id)){
									$i++;
								}
							}
							if($i != 0){
								$this->msg('Selecione uma variação!');
								$this->volta(1);
							}
						}

						$combo_titulo = '';
						$plano_id = '';
						$combo_disconto_get = '';
						
						$coisas_combo = $conexao->Executar("SELECT * FROM combos where id='$combo_id' ");
						while($data_det = $coisas_combo->fetch_object()){
							$combo_titulo = $data_det->titulo;
							$plano_id = $data_det->plano_id;
							$combo_disconto = $data_det->desconto;
						}

						$conexao = new mysql();
						$coisas_det = $conexao->Executar("SELECT * FROM combos where plano_id='$plano_id' ");
						$usar_valor_vindi = 0;
						$valor_combo_vindi = 0;
						while($data_det = $coisas_det->fetch_object()){
							$usar_discount = $data_det->usar_desconto;
							$valor_combo_vindi = $data_det->valor;
						}
						$usar_valor_vindi = $usar_discount;
						if($usar_discount == 1){
							$valor_total = 0;
							$valor_total_combo_vindi = $valor_combo_vindi;
							$valor_total = $valor_total_combo_vindi;
						}else{
							$combo_disconto = 0;
							if($combo_disconto_get > 0){
								$valor_total = $data_produto->valor - ($data_produto->valor / 100 * $combo_disconto_get);
								$combo_disconto = $combo_disconto_get;
							}else{
								$valor_total = $data_produto->valor;
							}
						}


						
						$tam_altura = '';
						$tam_largura = '';
						if($data_produto->tipo != 0){

							$tamanho_largura = $valores->trata_valor_banco($this->post('tamanho_largura'));
							$tamanho_altura = $valores->trata_valor_banco($this->post('tamanho_altura'));

							if($data_produto->tipo == 1){
								$tipounidade = 'm';
							}
							if($data_produto->tipo == 2){
								$tipounidade = 'cm';
							}

							$tam_altura = $tamanho_altura.' '.$tipounidade;
							$tam_largura = $tamanho_largura.' '.$tipounidade;

							$valor_total = $tamanho_altura * $tamanho_largura * $valor_total;

						} 
						if($tamanho){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM produto_tamanho where codigo='$tamanho' ");
							$data = $coisas->fetch_object();

							$conexao = new mysql();
							$coisas2 = $conexao->Executar("SELECT * FROM produto_tamanho_sel where tamanho_codigo='$tamanho' AND produto_codigo='$produto' ");
							$data2 = $coisas2->fetch_object();

							$tamanho_valor = $data2->valor;
							$tamanho_titulo = $data->titulo;

							$valor_total = $valor_total + $data2->valor;

						} else {
							$tamanho = '-';
							$tamanho_valor = 0;
							$tamanho_titulo = "";
						}
						if($cor){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM produto_cor where codigo='$cor' ");
							$data = $coisas->fetch_object();

							$conexao = new mysql();
							$coisas2 = $conexao->Executar("SELECT * FROM produto_cor_sel where cor_codigo='$cor' AND produto_codigo='$produto' ");
							$data2 = $coisas2->fetch_object();

							$cor_valor = $data2->valor;
							$cor_titulo = $data->titulo;

							$valor_total = $valor_total + $data2->valor;

						} else {
							$cor = '-';
							$cor_valor = 0;
							$cor_titulo = "";
						}
						if($data_produto->semestoque == 0){

							$quantidade_disponivel = $produtos->estoque_quantidade($produto, $tamanho, $cor, $variacao);

							if($quantidade_disponivel <= 0){

								$this->msg('Produto indisponível em estoque!');
								$this->volta(1);

							} else {
								if($quantidade > $quantidade_disponivel){
									$quantidade = $quantidade_disponivel;
								}
							}

						}
						if($data_produto->impresso == 1){

							$tipoarte = $this->post('tipoarte');
							if(!$tipoarte){
								$this->msg('Preencha todos os campos obrigatórios');
								$this->volta(1);
							}

							$modelo_codigo = '';
							$dados_arte = '';
							$valor_arte = 0;

							if($tipoarte == 1){

								$modelo_codigo = $this->post('modelo_selecionado_codigo');
								if(!$modelo_codigo){
									$this->msg('Preencha todos os campos obrigatórios');
									$this->volta(1);
								}

								$dados_arte = $this->post('dados_arte');

							}

							if($tipoarte == 2){

								$dados_arte = $this->post('dados_arte');

							// valor arte
								$valor_arte = $data_produto->valor_arte;
								$valor_total = $valor_total + $valor_arte;

							}


							$arte_acabamento = $this->post('arte_acabamento');
							$arquivo_arte = $this->post('arquivo_arte'); 


							if($data_produto->obrigacaodoanexo == 1){
								if($tipoarte == 3){

									if(!$arquivo_arte){
										$this->msg('Favor anexar sua arte para continuar.');
										$this->volta(1);
									}

								}
							}
						} else {
							$tipoarte = 0;
							$modelo_codigo = '';
							$dados_arte = '';
							$valor_arte = 0;
							$arquivo_arte = '';
							$arte_acabamento = '';
						}
						$titulodoproduto = "";
						if($data_produto->material){
							$titulodoproduto .= $data_produto->material.' ';
						}
						if($data_produto->formato){
							$titulodoproduto .= $data_produto->formato.' ';
						}
						if($data_produto->cores){
							$titulodoproduto .= $data_produto->cores.' ';
						}
						if($data_produto->revestimento){
							$titulodoproduto .= $data_produto->revestimento.' ';
						}
						if($data_produto->acabamento){
							$titulodoproduto .= $data_produto->acabamento.' ';
						}

						$data_compra = new DateTime('now');
						$data_compra = $data_compra->format('Y-m-d');
						$data_compra = strtotime($data_compra);

						$date_vencimento = new DateTime('now');
						$period = '+'.$data_produto->data_vencimento. ' month';
						$date_vencimento->modify($period); 
						$date_vencimento = $date_vencimento->format('Y-m-d');
						$date_vencimento = strtotime($date_vencimento);
							
						//grava no banco
						$conexao = new mysql();
						$conexao->inserir("pedido_loja_carrinho", array(
							"sessao"=>"$cod_sessao",
							"produto"=>"$prod",
							"produto_id"=>"$data_produto->id",
							"produto_ref"=>"$data_produto->ref",
							"id_combo"=>"$combo_id",
							"combo_titulo"=>"$combo_titulo",
							"data_vencimento"=>"$date_vencimento",
							"produto_assinatura"=>"$plano_id",
							"data_compra"=>"$data_compra",
							"produto_titulo"=>"$data_produto->titulo",
							"produto_subtitulo"=>"$titulodoproduto",
							"produto_valor"=>"$data_produto->valor",
							"tamanho"=>"$tamanho",
							"tamanho_titulo"=>"$tamanho_titulo",
							"tamanho_valor"=>"$tamanho_valor",
							"cor"=>"$cor",
							"cor_titulo"=>"$cor_titulo",
							"cor_valor"=>"$cor_valor",
							"variacao"=>"$variacao",
							"variacao_titulo"=>"",
							"variacao_valor"=>0,
							"quantidade"=> 1,
							"valor_arte"=>"$valor_arte",
							"valor_total"=>"$valor_total",
							"valor_total_combo_vindi"=>"$valor_total_combo_vindi",
							"usar_valor_vindi"=>"$usar_valor_vindi",
							"combo_desconto"=>"$combo_disconto",
							"tipoarte"=>"$tipoarte",
							"modelo_codigo"=>"$modelo_codigo",
							"dados_arte"=>"$dados_arte",
							"arquivo_arte"=>"$arquivo_arte",
							"arte_acabamento"=>"$arte_acabamento",
							"tipo_envio"=> 3,
							"tam_largura"=>"$tam_largura",
							"tam_altura"=>"$tam_altura"
						));

						// echo'<pre>';print_r($conexao);exit;
					}
				}
				$this->irpara(DOMINIO.$this->_controller."/carrinho");
			}else{
				// echo '<pre>';print_r($produto);exit;
				//confere se ja existe o pedido senão cria um novo pedido
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM pedido_loja where codigo='".$this->_sessao."' ");
				$data = $coisas->fetch_object();

				if(!isset($data->id)){
					$time = time();
					$ip = $_SERVER["REMOTE_ADDR"];
					//grava no banco
					$conexao = new mysql();
					$conexao->inserir("pedido_loja", array(
						"codigo"=>"$cod_sessao",
						"data"=>"$time",
						"ip"=>"$ip",
						"status"=>"0"
					));

				} else {
					//confere se o pedido foi finalizado
					if($data->status != 0){
						$this->irpara(DOMINIO.$this->_controller."/carrinho");
					} else {
						//zera dados de frete
						$conexao = new mysql();
						$conexao->alterar("pedido_loja", array(
							"frete"=>"",
							"frete_titulo"=>"",
							"frete_valor"=>"",
							"valor_produtos"=>"0",
							"valor_produtos_desc"=>"0",
							"valor_total"=>"0",
							"status"=>"0"
						), " sessao='$cod_sessao' ");
					}			
				}
				foreach($produto as $prod){
					$data_produto = $produtos->carrega_produto_codigo($prod);
					if(isset($data_produto->id)){
						$conexao = new mysql();
						$tipo_envio = 3;
						$combo_id = null;
						if($_POST['combo_id'] > 0){
							$combo_id = $_POST['combo_id'];
							$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$cod_sessao' AND produto = '$prod' AND id_combo = $combo_id ");
							$linha_carrinho = $coisas_carrinho->num_rows;
							if($linha_carrinho != 0){			
								$this->msg('Você não pode adicionar 2 combos iguais.');
								$this->volta(1);
							}
						}
						//verifica obrigaçao do campo Tamanho
						$tamanho = $this->post('tamanho');
						if(!$tamanho){

							$conexao = new mysql();
							$coisas_det = $conexao->Executar("SELECT * FROM produto_tamanho_sel where produto_codigo='$produto' ");
							$i = 0;
							while($data_det = $coisas_det->fetch_object()){

								$conexao = new mysql();
								$data_det2 = $conexao->Executar("SELECT id FROM produto_tamanho where codigo='$data_det->tamanho_codigo' ")->fetch_object();

								if(isset($data_det2->id)){
									$i++;
								}
							}
							if($i != 0){
								$this->msg('Selecione o tamanho!');
								$this->volta(1);
							}
						}		
						//verifica obrigaçao do campo Cor
						$cor = $this->post('cor');
						if(!$cor){

							$conexao = new mysql();
							$coisas_det = $conexao->Executar("SELECT * FROM produto_cor_sel where produto_codigo='$produto' ");
							$i = 0;
							while($data_det = $coisas_det->fetch_object()){

								$conexao = new mysql();
								$data_det2 = $conexao->Executar("SELECT id FROM produto_cor where codigo='$data_det->cor_codigo' ")->fetch_object();

								if(isset($data_det2->id)){
									$i++;
								}
							}
							if($i != 0){
								$this->msg('Selecione uma cor!');
								$this->volta(1);
							}
						}
						//verifica obrigaçao do campo variacao
						$variacao = $this->post('variacao');
						if(!$variacao){

							$conexao = new mysql();
							$coisas_det = $conexao->Executar("SELECT * FROM produto_variacao_sel where produto_codigo='$produto' ");
							$i = 0;
							while($data_det = $coisas_det->fetch_object()){

								$conexao = new mysql();
								$data_det2 = $conexao->Executar("SELECT id FROM produto_variacao where codigo='$data_det->variacao_codigo' ")->fetch_object();

								if(isset($data_det2->id)){
									$i++;
								}
							}
							if($i != 0){
								$this->msg('Selecione uma variação!');
								$this->volta(1);
							}
						}
						// valor base
						$combo_titulo = $_POST['combo_titulo'];
						$plano_id = $_POST['plano_id'];

						$conexao = new mysql();
						$coisas_det = $conexao->Executar("SELECT * FROM combos where plano_id='$plano_id' ");
						$usar_valor_vindi = 0;
						$valor_combo_vindi = 0;
						
						while($data_det = $coisas_det->fetch_object()){
							$usar_discount = $data_det->usar_desconto;
							$valor_combo_vindi = $data_det->valor;
							// echo'<pre>';print_r($data_det);exit;
						}
						$usar_valor_vindi = $usar_discount;
						if($usar_discount == 1){
							$valor_total = 0;
							$valor_total_combo_vindi = $valor_combo_vindi;
							$valor_total = $valor_total_combo_vindi;
						}else{
							$combo_disconto = 0;
							if($_POST['combo_disconto'] > 0){
								$valor_total = $data_produto->valor - ($data_produto->valor / 100 * $_POST['combo_disconto']);
								$combo_disconto = $_POST['combo_disconto'];
							}else{
								$valor_total = $data_produto->valor;
							}
						}

						$tam_altura = '';
						$tam_largura = '';
						if($data_produto->tipo != 0){

							$tamanho_largura = $valores->trata_valor_banco($this->post('tamanho_largura'));
							$tamanho_altura = $valores->trata_valor_banco($this->post('tamanho_altura'));

							if($data_produto->tipo == 1){
								$tipounidade = 'm';
							}
							if($data_produto->tipo == 2){
								$tipounidade = 'cm';
							}

							$tam_altura = $tamanho_altura.' '.$tipounidade;
							$tam_largura = $tamanho_largura.' '.$tipounidade;

							$valor_total = $tamanho_altura * $tamanho_largura * $valor_total;

						} 
						//tamanho
						if($tamanho){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM produto_tamanho where codigo='$tamanho' ");
							$data = $coisas->fetch_object();

							$conexao = new mysql();
							$coisas2 = $conexao->Executar("SELECT * FROM produto_tamanho_sel where tamanho_codigo='$tamanho' AND produto_codigo='$produto' ");
							$data2 = $coisas2->fetch_object();

							$tamanho_valor = $data2->valor;
							$tamanho_titulo = $data->titulo;

							$valor_total = $valor_total + $data2->valor;

						} else {
							$tamanho = '-';
							$tamanho_valor = 0;
							$tamanho_titulo = "";
						}
						//Cor
						if($cor){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM produto_cor where codigo='$cor' ");
							$data = $coisas->fetch_object();

							$conexao = new mysql();
							$coisas2 = $conexao->Executar("SELECT * FROM produto_cor_sel where cor_codigo='$cor' AND produto_codigo='$produto' ");
							$data2 = $coisas2->fetch_object();

							$cor_valor = $data2->valor;
							$cor_titulo = $data->titulo;

							$valor_total = $valor_total + $data2->valor;

						} else {
							$cor = '-';
							$cor_valor = 0;
							$cor_titulo = "";
						}
						// confere estoque se tiver menos do que o selecionado substitui pela quantidade disponivel
						if($data_produto->semestoque == 0){

							$quantidade_disponivel = $produtos->estoque_quantidade($produto, $tamanho, $cor, $variacao);

							if($quantidade_disponivel <= 0){

								$this->msg('Produto indisponível em estoque!');
								$this->volta(1);

							} else {
								if($quantidade > $quantidade_disponivel){
									$quantidade = $quantidade_disponivel;
								}
							}

						}

						if($data_produto->impresso == 1){

							$tipoarte = $this->post('tipoarte');
							if(!$tipoarte){
								$this->msg('Preencha todos os campos obrigatórios');
								$this->volta(1);
							}

							$modelo_codigo = '';
							$dados_arte = '';
							$valor_arte = 0;

							if($tipoarte == 1){

								$modelo_codigo = $this->post('modelo_selecionado_codigo');
								if(!$modelo_codigo){
									$this->msg('Preencha todos os campos obrigatórios');
									$this->volta(1);
								}

								$dados_arte = $this->post('dados_arte');

							}

							if($tipoarte == 2){

								$dados_arte = $this->post('dados_arte');

							// valor arte
								$valor_arte = $data_produto->valor_arte;
								$valor_total = $valor_total + $valor_arte;

							}


							$arte_acabamento = $this->post('arte_acabamento');
							$arquivo_arte = $this->post('arquivo_arte'); 


							if($data_produto->obrigacaodoanexo == 1){
								if($tipoarte == 3){

									if(!$arquivo_arte){
										$this->msg('Favor anexar sua arte para continuar.');
										$this->volta(1);
									}

								}
							}
						} else {
							$tipoarte = 0;
							$modelo_codigo = '';
							$dados_arte = '';
							$valor_arte = 0;
							$arquivo_arte = '';
							$arte_acabamento = '';
						}

						$titulodoproduto = "";

						if($data_produto->material){
							$titulodoproduto .= $data_produto->material.' ';
						}
						if($data_produto->formato){
							$titulodoproduto .= $data_produto->formato.' ';
						}
						if($data_produto->cores){
							$titulodoproduto .= $data_produto->cores.' ';
						}
						if($data_produto->revestimento){
							$titulodoproduto .= $data_produto->revestimento.' ';
						}
						if($data_produto->acabamento){
							$titulodoproduto .= $data_produto->acabamento.' ';
						}

						$data_compra = new DateTime('now');
						$data_compra = $data_compra->format('Y-m-d');
						$data_compra = strtotime($data_compra);

						$date_vencimento = new DateTime('now');
						$period = '+'.$data_produto->data_vencimento. ' month';
						$date_vencimento->modify($period); 
						$date_vencimento = $date_vencimento->format('Y-m-d');
						$date_vencimento = strtotime($date_vencimento);
							
						//grava no banco
						$conexao = new mysql();
						$conexao->inserir("pedido_loja_carrinho", array(
							"sessao"=>"$cod_sessao",
							"produto"=>"$prod",
							"produto_id"=>"$data_produto->id",
							"produto_ref"=>"$data_produto->ref",
							"id_combo"=>"$combo_id",
							"combo_titulo"=>"$combo_titulo",
							"data_vencimento"=>"$date_vencimento",
							"produto_assinatura"=>"$plano_id",
							"data_compra"=>"$data_compra",
							"produto_titulo"=>"$data_produto->titulo",
							"produto_subtitulo"=>"$titulodoproduto",
							"produto_valor"=>"$data_produto->valor",
							"tamanho"=>"$tamanho",
							"tamanho_titulo"=>"$tamanho_titulo",
							"tamanho_valor"=>"$tamanho_valor",
							"cor"=>"$cor",
							"cor_titulo"=>"$cor_titulo",
							"cor_valor"=>"$cor_valor",
							"variacao"=>"$variacao",
							"variacao_titulo"=>"",
							"variacao_valor"=>0,
							"quantidade"=> 1,
							"valor_arte"=>"$valor_arte",
							"valor_total"=>"$valor_total",
							"valor_total_combo_vindi"=>"$valor_total_combo_vindi",
							"usar_valor_vindi"=>"$usar_valor_vindi",
							"combo_desconto"=>"$combo_disconto",
							"tipoarte"=>"$tipoarte",
							"modelo_codigo"=>"$modelo_codigo",
							"dados_arte"=>"$dados_arte",
							"arquivo_arte"=>"$arquivo_arte",
							"arte_acabamento"=>"$arte_acabamento",
							"tipo_envio"=> 3,
							"tam_largura"=>"$tam_largura",
							"tam_altura"=>"$tam_altura"
						));

						// echo'<pre>';print_r($conexao);exit;
					}
					// echo'<pre>';print_r($data_produto);exit;
				}
				$this->irpara(DOMINIO.$this->_controller."/carrinho");
			}
		}	
	}

	public function carrinho_adicionar_plano(){	

		$dados = array();
		$dados['_base'] = $this->_base();

		// instancia
		$produtos = new model_produtos();

		$cod_sessao = $this->_sessao;

		$produto = $this->get('id'); 

		if(!$produto){
			$this->msg('Plano não indentificado!');
			$this->volta(1);
		}

		//confere se ja existe o pedido senão cria um novo pedido
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM pedido_loja where codigo='".$this->_sessao."' ");
		$data = $coisas->fetch_object();

		if(!isset($data->id)){

			$time = time();
			$ip = $_SERVER["REMOTE_ADDR"];

			//grava no banco
			$conexao = new mysql();
			$conexao->inserir("pedido_loja", array(
				"codigo"=>"$cod_sessao",
				"data"=>"$time",
				"ip"=>"$ip",
				"status"=>"0"
			));

		} else {

			//confere se o pedido foi finalizado
			if($data->status != 0){
				$this->irpara(DOMINIO.$this->_controller."/carrinho");
			} else {
				//zera dados de frete
				$conexao = new mysql();
				$conexao->alterar("pedido_loja", array(
					"frete"=>"",
					"frete_titulo"=>"",
					"frete_valor"=>"",
					"valor_produtos"=>"0",
					"valor_produtos_desc"=>"0",
					"valor_total"=>"0",
					"status"=>"0"
				), " sessao='$cod_sessao' ");
			}
		}


		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM planos WHERE codigo='$produto' ");
		$data_produto = $coisas->fetch_object();

		//verifica se o produto existe
		if(isset($data_produto->id)){

			// valor base
			$valor_total = $data_produto->valor;
			$valores = new model_valores();

			$variacao = '-';
			$variacao_valor = 0;
			$variacao_titulo = "";
			
			$tam_altura = '';
			$tam_largura = '';
			
			$tamanho = '-';
			$tamanho_valor = 0;
			$tamanho_titulo = "";
			
			$cor = '-';
			$cor_valor = 0;
			$cor_titulo = "";


			$tipoarte = 0;
			$modelo_codigo = '';
			$dados_arte = '';
			$valor_arte = 0;
			$arquivo_arte = '';
			$arte_acabamento = '';

			$titulodoproduto = "";

			$data_compra = new DateTime('now');
			$data_compra = $data_compra->format('Y-m-d');
			$data_compra = strtotime($data_compra);

			$date_vencimento = new DateTime('now');
			$period = '+'.$data_produto->data_vencimento. ' month';
			$date_vencimento->modify($period); 
			$date_vencimento = $date_vencimento->format('Y-m-d');
			$date_vencimento = strtotime($date_vencimento);

			//grava no banco
			$conexao = new mysql();
			$conexao->inserir("pedido_loja_carrinho", array(
				"sessao"=>"$cod_sessao",
				"produto"=>"$produto",
				"produto_id"=>"$data_produto->id",
				"produto_ref"=>"$data_produto->ref",
				"produto_titulo"=>"$data_produto->titulo",
				"data_vencimento"=>"$date_vencimento",
				"produto_assinatura"=>"$data_produto->assinatura",
				"data_compra"=>"$data_compra",
				"produto_subtitulo"=>"$titulodoproduto",
				"produto_valor"=>"$data_produto->valor",
				"tamanho"=>"$tamanho",
				"tamanho_titulo"=>"$tamanho_titulo",
				"tamanho_valor"=>"$tamanho_valor",
				"cor"=>"$cor",
				"cor_titulo"=>"$cor_titulo",
				"cor_valor"=>"$cor_valor",
				"variacao"=>"$variacao",
				"variacao_titulo"=>"$variacao_titulo",
				"variacao_valor"=>"$variacao_valor",
				"quantidade"=>1,
				"valor_arte"=>0,
				"valor_total"=>$valor_total,
				"tipoarte"=>"$tipoarte",
				"modelo_codigo"=>"$modelo_codigo",
				"dados_arte"=>"$dados_arte",
				"arquivo_arte"=>"$arquivo_arte",
				"arte_acabamento"=>"$arte_acabamento",
				"tipo_envio"=>0,
				"tam_largura"=>"$tam_largura",
				"tam_altura"=>"$tam_altura",
				"plano"=>1
			));

			$this->irpara(DOMINIO.$this->_controller."/carrinho");

		} else {			
			$this->msg('Plano não encontrado!');
			$this->volta(1);
		}

	}

	public function quantidade(){

		$produtos = new model_produtos();

		$id = $this->post('id');
		if($id){

			$quantidade = $this->post('quantidade');
			if($quantidade < 1){
				echo "erro";
				exit;
			}

			$conexao = new mysql();
			$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho where id='$id' AND sessao='".$this->_sessao."' ");
			$data_carrinho = $coisas_carrinho->fetch_object();

			if(isset($data_carrinho->id)){

				$conexao = new mysql();
				$coisas_produto = $conexao->Executar("SELECT * FROM produto WHERE codigo='$data_carrinho->produto' ");
				$data_produto = $coisas_produto->fetch_object();

				if(!isset($data_produto->semestoque)){
					echo "erro";
					exit;
				}

				//confere se nao é venda sem estoque
				if($data_produto->semestoque == 1){

					$conexao = new mysql();
					$conexao->alterar("pedido_loja_carrinho", array(
						"quantidade"=>"$quantidade"
					), " id='$id' AND sessao='".$this->_sessao."' ");

					//zera dados de frete
					$conexao = new mysql();
					$conexao->alterar("pedido_loja", array(
						"frete"=>"",
						"frete_titulo"=>"",
						"frete_valor"=>"",
						"valor_produtos"=>"0",
						"valor_produtos_desc"=>"0",
						"valor_total"=>"0",
						"status"=>"0"
					), " codigo='".$this->_sessao."' ");

					echo "ok";

				} else {

					// confere estoque se tiver menos do que o selecionado substitui pela quantidade disponivel
					if($data_produto->semestoque == 0){

						$quantidade_disponivel = $produtos->estoque_quantidade($data_carrinho->produto, $data_carrinho->tamanho, $data_carrinho->cor, $data_carrinho->variacao);

						if($quantidade_disponivel <= 0){
							echo "erro";
							exit;
						} else {
							if($quantidade > $quantidade_disponivel){
								$quantidade = $quantidade_disponivel;
							}
						}

					}

					$conexao = new mysql();
					$conexao->alterar("pedido_loja_carrinho", array(
						"quantidade"=>"$quantidade"
					), " id='$id' AND sessao='".$this->_sessao."' ");

					//zera dados de frete
					$conexao = new mysql();
					$conexao->alterar("pedido_loja", array(
						"frete"=>"",
						"frete_titulo"=>"",
						"frete_valor"=>"",
						"valor_produtos"=>"0",
						"valor_produtos_desc"=>"0",
						"valor_total"=>"0",
						"status"=>"0"
					), " codigo='".$this->_sessao."' ");

				} 

				echo "ok";

			}
		}
	}

	public function remover_carrinho(){

		$id = $this->get('id');
		if($id){

			$conexao = new mysql();
			$linha = $conexao->Executar("SELECT * FROM pedido_loja_carrinho where id='$id' ");

			$line = $linha->fetch_object();
			if($line->id_combo > 0){
				$conexao->apagar("pedido_loja_carrinho", " id_combo='$line->id_combo' AND sessao='".$this->_sessao."' "); 
			}else{
				$conexao->apagar("pedido_loja_carrinho", " id='$id' AND sessao='".$this->_sessao."' ");
			}

			//zera dados de frete
			$conexao = new mysql();
			$conexao->alterar("pedido_loja", array(
				"frete"=>"",
				"frete_titulo"=>"",
				"frete_valor"=>"",
				"valor_produtos"=>"0",
				"valor_produtos_desc"=>"0",
				"valor_total"=>"0",
				"status"=>"0"
			), " codigo='".$this->_sessao."' ");

			echo "ok";
		}

	}

	public function carrinho_cupom(){

		$cupom = rtrim(ltrim($this->post('cupom')));
		if(!$cupom){
			echo "erro";
			exit;
		}

		$conexao = new mysql();
		$coisas_cupom = $conexao->Executar("SELECT * FROM cupom_lista where cupom='$cupom' ");
		$data_cupom = $coisas_cupom->fetch_object();

		if(isset($data_cupom->codigo)){

			$conexao = new mysql();
			$coisas_promo = $conexao->Executar("SELECT * FROM cupom WHERE codigo='$data_cupom->codigo' ");
			$data_promo = $coisas_promo->fetch_object();

			if(!isset($data_promo->id)){
				echo "erro";
				exit;
			}

			//confere se é unico
			if($data_promo->tipo == 0){
				if($data_cupom->utilizado != 0){
					$this->msg('Cupom inválido ou expirado!');
					$this->irpara(DOMINIO.$this->_controller."/carrinho");
				}
			}

			//confere se ja tem cupom 
			$carrinho = new model_carrinho();		 
			$data_pedido = $carrinho->carrega($this->_sessao);

			if($data_pedido->cupom){
				$conexao = new mysql();
				$conexao->alterar("cupom_lista", array(
					"utilizado"=>"0"
				), " cupom='".$data_pedido->cupom."' ");
			}

			//adiciona cupom ao pedido
			$conexao = new mysql();
			$conexao->alterar("pedido_loja", array(
				"cupom"=>"$cupom",
				"cupom_promocao"=>"$data_promo->titulo",
				"cupom_desconto_fixo"=>$data_promo->desconto_fixo,
				"cupom_desconto_porc"=>$data_promo->desconto_porc,
				"frete"=>"",
				"frete_titulo"=>"",
				"frete_valor"=>0,
				"valor_produtos"=>0,
				"valor_produtos_desc"=>0,
				"valor_total"=>0,
				"status"=>0
			), " codigo='".$this->_sessao."' ");

			echo "ok";

		} else {
			echo "erro";
			exit;
		}

	}

	public function carrinho_cep(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$cep = rtrim(ltrim($this->post('cep')));
		if(!$cep){
			echo "Cep Inválido!";
			exit;
		}

		$buscacep = new model_cep();
		$cep_array = $buscacep->retorno($cep);

		// echo "<pre>";
		// print_r($cep_array);
		// echo "</pre>";
		// exit;

		if(!$cep_array['uf']){
			echo "Cep Inválido!";
			exit;
		}

		//adiciona cep
		$conexao = new mysql();
		$conexao->alterar("pedido_loja", array(
			"cep_destino"=>"$cep",
			"frete"=>"",
			"frete_titulo"=>"",
			"frete_valor"=>0,
			"status"=>0
		), " codigo='".$this->_sessao."' ");

		$carrinho = new model_carrinho();
		$dados['carrinho'] = $carrinho->carrinho($this->_sessao);
		$dados['data_pedido'] = $carrinho->carrega($this->_sessao);

		$valor_subtotal = $dados['carrinho']['subtotal'];

		$fretes = new model_fretes();
		$dados['frete_lista'] = $fretes->lista($cep, $valor_subtotal, $this->_sessao, 0);

		$this->view('carrinho_fretes', $dados);
	}

	public function carrinho_forma_pagamento(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$id = $this->get('id');
		if(!$id){
			exit;
		}

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM pagamento WHERE id='$id' ");
		$data = $coisas->fetch_object();

		if( ($data->id) AND ($data->ativo == 0) ){

			$conexao = new mysql();
			$conexao->alterar("pedido_loja", array(
				"forma_pagamento"=>$id,
				"forma_pagamento_desc_fixo"=>$data->desconto_fixo,
				"forma_pagamento_desc_porc"=>$data->desconto_porc,				
				"valor_produtos"=>"0",
				"valor_produtos_desc"=>"0",
				"valor_total"=>"0",
				"status"=>"0"
			), " codigo='".$this->_sessao."' ");

			echo 'ok';

		}
	}

	public function carrinho_frete(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$fretes = new model_fretes();

		$id = $this->get('id');
		if(!$id){
			exit;
		}

		$valor_subtotal = $this->get('valor_subtotal');
		if(!$valor_subtotal){
			exit;
		}

		//informaçoes do pedido
		$conexao = new mysql();
		$coisas_pedido = $conexao->Executar("SELECT * FROM pedido_loja WHERE codigo='".$this->_sessao."' ");
		$data_pedido = $coisas_pedido->fetch_object();

		// frete
		$frete = $fretes->lista($data_pedido->cep_destino, $valor_subtotal, $this->_sessao, $id);

		$valor_frete = 0;
		$titulo = '';
		foreach ($frete as $key => $value) {
			if($value['selected']){
				$valor_frete = $value['valor_frete'];
				$obs = $value['obs'];
				$titulo = $value['titulo'];
			}
		}

		if($titulo){

			//adiciona frete
			$conexao = new mysql();
			$conexao->alterar("pedido_loja", array(
				"frete"=>$id,
				"frete_titulo"=>$titulo,
				"frete_valor"=>$valor_frete,
				"frete_obs"=>$obs,
				"valor_total"=>0,
				"status"=>0
			), " codigo='".$this->_sessao."' ");

			echo "ok";

		}
	}

	public function fechar_pedido(){
		
		// retorno
		function mostra_result($erro_cod, $erro_msg, $processo, $forma){

			$retorno = array();

			$retorno['erro_cod'] = $erro_cod;
			$retorno['erro_msg'] = $erro_msg;
			$retorno['processo'] = $processo;
			$retorno['forma'] = $forma;

			echo json_encode($retorno);
			exit;
		}

		if( isset($_SESSION[$this->_sessao_principal]['loja_acesso']) AND isset($_SESSION[$this->_sessao_principal]['loja_cod_usuario']) AND isset($_SESSION[$this->_sessao_principal]['loja_cod_sessao']) ) {
		} else {
			mostra_result(2, '', 'erro', '');
			exit;
		}

		// intancia objetos
		$pedidos = new model_pedidos();
		$produtos = new model_produtos();
		$valores = new model_valores();
		$cupons = new model_cupom();

		// retornos

		$time = time();

		//informaçoes do pedido
		$conexao = new mysql();
		$coisas_pedido = $conexao->Executar("SELECT * FROM pedido_loja WHERE codigo='".$this->_sessao."' ");
		$data_pedido = $coisas_pedido->fetch_object();

		
		//confere frete
		if(!$data_pedido->frete){

			// if(!$data_pedido->frete_balcao){

			// 	$ret_erro_cod = "1";
			// 	$ret_erro_msg = "Selecione a forma de entrega para continuar!!";
			// 	$ret_processo = "erro";
			// 	$ret_forma = "";
			// 	$ret_forma_code = "";
			// 	$ret_endereco = "";

			// 	mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
			// 	exit;
			// }
		} else {

			if($data_pedido->frete != 3){

				//confere cep
				if(!$data_pedido->cep_destino){

					$ret_erro_cod = "1";
					$ret_erro_msg = "Informe seu cep para continuar";
					$ret_processo = "erro";
					$ret_forma = "";
					$ret_forma_code = "";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;
				}
			}
		}

		// confere cupom
		if($data_pedido->cupom){
			if($cupons->confere_cupom_pedido($this->_sessao, $data_pedido->cupom) != 'ok'){

				$ret_erro_cod = "1";
				$ret_erro_msg = "Cupom invalido ou expirado";
				$ret_processo = "erro";
				$ret_forma = "";
				$ret_forma_code = "";
				$ret_endereco = "";

				mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
				exit;
			}
		}

		$valor_subtotal = 0;
		$itens_para_email = "<strong>Itens do Pedido:</strong><br><br>";

		// confere produtos
		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='".$this->_sessao."' ");
		$linha_carrinho = $coisas_carrinho->num_rows;

	
		if($linha_carrinho != 0){
			
			while($data_carrinho = $coisas_carrinho->fetch_object()){
				if($data_carrinho->plano == 0){
				
					$total_estoque = $produtos->estoque_quantidade($data_carrinho->produto, $data_carrinho->tamanho, $data_carrinho->cor, $data_carrinho->variacao);

					$conexao = new mysql();
					$coisas_produto = $conexao->Executar("SELECT * FROM produto WHERE codigo='$data_carrinho->produto' ");
					$data_produto = $coisas_produto->fetch_object();

					//Confere Estoque
					if($data_produto->semestoque == 0){
						if($data_carrinho->quantidade > $total_estoque){

							$ret_erro_cod = "1";
							$ret_erro_msg = "Estoque indisponível para o produto: ".$data_carrinho->produto_titulo;
							$ret_processo = "erro";
							$ret_forma = "";
							$ret_forma_code = "";
							$ret_endereco = "";

							mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
							exit;
						}
					}

				} else {
					$total_estoque = 0;
					
					$conexao = new mysql();
					$coisas_produto = $conexao->Executar("SELECT * FROM planos WHERE codigo='$data_carrinho->produto' ");
					$data_produto = $coisas_produto->fetch_object();

				}
				if($data_carrinho->usar_valor_vindi == 1){
					if($data_carrinho->id_combo != 0){
						$conexao = new mysql();
						$count_prod = $conexao->Executar("SELECT * FROM combo_produto WHERE id_combo='".$data_carrinho->id_combo."' ");
						$count_prod = $count_prod->num_rows;
						$total_vindi_combo_half = ($data_carrinho->valor_total/$count_prod);
						$total_unitario = $total_vindi_combo_half;
					}
				}else{
					$total_unitario = $data_carrinho->valor_total;
				}
			
				$total_quantidade = $valores->trata_valor_calculo($total_unitario * $data_carrinho->quantidade);
				$valor_subtotal = $valores->trata_valor_calculo($valor_subtotal + $total_quantidade);
				
				// informações da lista para envio 

				$produto_nome = "<div>$data_carrinho->quantidade un - $data_carrinho->produto_titulo</div>";
				if($data_carrinho->tamanho_titulo){ $produto_nome .= "<div>Tamanho: $data_carrinho->tamanho_titulo</div>"; }
				if($data_carrinho->cor_titulo){ $produto_nome .= "<div>Cor: $data_carrinho->cor_titulo</div>"; }
				if($data_carrinho->variacao_titulo){ $produto_nome .= "<div>Variação: $data_carrinho->variacao_titulo</div>"; }

				if($data_carrinho->tipoarte == 1){

					$conexao = new mysql();
					$coisas_artemod = $conexao->Executar("SELECT titulo FROM produto_modelos WHERE codigo='$data_carrinho->modelo_codigo' ");
					$data_artemod = $coisas_artemod->fetch_object();

					$produto_nome .= "<div>Arte: Modelo gratis - ".$data_artemod->titulo."</div>";

				}
				if($data_carrinho->tipoarte == 2){
					$produto_nome .= "<div>Arte: Criação - adicional R$ ".$valores->trata_valor($data_carrinho->valor_arte)."</div>";
				}
				if($data_carrinho->tipoarte == 3){
					$produto_nome .= "<div>Arte: Enviado pelo cliente</div>";
				}

				if($data_carrinho->arte_acabamento != 0){

					$conexao = new mysql();
					$coisas_acaba = $conexao->Executar("SELECT titulo FROM produto_acabamentos WHERE codigo='$data_carrinho->arte_acabamento' ");
					$data_acaba = $coisas_acaba->fetch_object();

					$produto_nome .= "<div>Acabamento: ".$data_acaba->titulo."</div>";

				}
				if($data_carrinho->arquivo_arte){

					$produto_nome .= "<div>Anexo: <a href='".PASTA_CLIENTE."uploads/".$data_carrinho->arquivo_arte."' target='_blank'>Abrir</a></div>";

				}

				if($data_carrinho->dados_arte){					
					$produto_nome .= "<div>Dados da arte: <a onclick=\"modal('".DOMINIO."meuspedidos/dados_arte/id/".$data_carrinho->id."', 'Dados da arte');\" style='cursor:pointer;' >Ver</a></div>";

				}

				$itens_para_email .= $produto_nome;
				$itens_para_email .= "<br><br>";
				
			}

			$valor_desconto_cupom = 0;
			
			$valor_desconto_forma_pag = 0;

			//calcula o total
			$valor_total_produtos = $valor_subtotal - $valor_desconto_cupom;
			$valor_total_produtos = $valor_total_produtos - $valor_desconto_forma_pag;
			$valor_total_pedido = $valor_total_produtos + $data_pedido->frete_valor;
			$total_descontos = $valor_desconto_cupom + $valor_desconto_forma_pag;


			$cadastro = $this->_cod_usuario;
			$codigo_pedido = $this->_sessao;

			// confere se tem forma de pagamento
			if($data_pedido->forma_pagamento){

				$formadepagamento = $data_pedido->forma_pagamento;

			} else {

				$formas = new model_formas_pg();
				$lista_pg = $formas->lista();						
				$formadepagamento = $lista_pg[0]['id'];

			}

			$cadastro_model = new model_cadastro();
			$data_cadastro = $cadastro_model->dados_usuario($this->_cod_usuario);

			if($data_cadastro->tipo == 'F'){
				$nome_do_cliente = $data_cadastro->fisica_nome;
			} else {
				$nome_do_cliente = $data_cadastro->juridica_nome;
			}

			$envio = new model_envio();
			$textos = new model_textos();

			$texto_email = "<div style='font-size:14px;'>Olá, $nome_do_cliente<br><br><strong>Pedido $data_pedido->id</strong></div>".$textos->conteudo('150457686833612')."<br>".$itens_para_email;

			$texto_email_admin = "Parabéns você tem uma nova venda, acesse o sistema para mais informações.<br><br>Email do Cliente: $data_cadastro->email <br><br>".$itens_para_email;

			$db = new mysql();
			$exec = $db->executar("select * from contato ");
			$lista_envio_adm = array();
			$n_envio = 0;
			while($data = $exec->fetch_object()){
				$lista_envio_adm[$n_envio] = $data->email;
				$n_envio++;
			}

			switch ($formadepagamento) {

				// direciona para pagamento pagseguro
				case '1':

					// instancia model
				$pagseguro = new model_pagseguro();
				$retorno_pagseguro = $pagseguro->pagamento($codigo_pedido, $this->_cod_usuario, "Pedido $data_pedido->id", $valor_total_pedido);
				
				if($retorno_pagseguro['erro'] == 0){

					$codigo_transacao = $retorno_pagseguro['code'];

					if($codigo_transacao){

						$vencimento_pedido = strtotime("+1 days");

							//finaliza pedido
						$conexao = new mysql();
						$conexao->alterar("pedido_loja", array(
							"cadastro"=>$cadastro,
							"vencimento"=>$vencimento_pedido,
							"valor_produtos"=>$valor_subtotal,
							"valor_produtos_desc"=>$total_descontos,
							"valor_total"=>$valor_total_pedido,
							"forma_pagamento"=>$formadepagamento,
							"id_transacao"=>$codigo_transacao,
							"status"=>0
						), " codigo='".$this->_sessao."' ");

							// baixa estoque
						$produtos->baixa_estoque($this->_sessao);

							// envia email DESCOMENTAR DEPOIS
						// $email_destino = $data_cadastro->email;
						// $envio->enviar("Confirmação de Pedido", $texto_email, array("0"=>"$email_destino"));
						// $envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);


						$codigo_pedido = $this->_sessao;

						$novasessao = $this->gera_codigo();
						$this->_sessao = $novasessao;
						$_SESSION[$this->_sessao_principal]['loja_cod_sessao'] = $novasessao;


						// retorna
						$ret_erro_cod = "0";
						$ret_erro_msg = "";
						$ret_processo = "ok";
						$ret_forma = "pagseguro";
						$ret_forma_code = $codigo_transacao;
						$ret_endereco = "";

						mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
						exit;

					} else {

						// retorna
						$ret_erro_cod = "1";
						$ret_erro_msg = "Dados de cadastro incorretos";
						//$ret_erro_msg = "Dados de cadastro incorretos - ".$retorno_pagseguro['erro_msg'];
						$ret_processo = "erro";
						$ret_forma = "";
						$ret_forma_code = "";
						$ret_endereco = "";

						mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
						exit;

					}
				} else {

					// retorna
					$ret_erro_cod = "1";
					$ret_erro_msg = "Dados de cadastro incorretos";
					//$ret_erro_msg = "Dados de cadastro incorretos - ".$retorno_pagseguro['erro_msg'];
					$ret_processo = "erro";
					$ret_forma = "";
					$ret_forma_code = "";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;

				}
				break;

				// deposito
				case '2':

				$vencimento_pedido = strtotime("+2 days");

				$conexao = new mysql();
				$conexao->alterar("pedido_loja", array(
					"cadastro"=>$cadastro,
					"vencimento"=>$vencimento_pedido,
					"valor_produtos"=>$valor_subtotal,
					"valor_produtos_desc"=>$total_descontos,
					"valor_total"=>$valor_total_pedido,
					"forma_pagamento"=>$formadepagamento,
					"status"=>1
				), " codigo='".$this->_sessao."' ");

				// baixa estoque
				$produtos->baixa_estoque($this->_sessao);

				// envia email
				$email_destino = $data_cadastro->email;
				$envio->enviar("Confirmação de Pedido", $texto_email, array("0"=>"$email_destino"));
				$envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);


				$codigo_pedido = $this->_sessao;

				$novasessao = $this->gera_codigo();
				$this->_sessao = $novasessao;
				$_SESSION[$this->_sessao_principal]['loja_cod_sessao'] = $novasessao;


				// retorna
				$ret_erro_cod = "0";
				$ret_erro_msg = "";
				$ret_processo = "ok";
				$ret_forma = "deposito";
				$ret_forma_code = "";
				$ret_endereco = "";
				
				mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
				exit; 

				break;


				// MercadoPago
				case '3':

				$conexao = new mysql();
				$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='3' ");
				$data_pagamento = $coisas_pagamento->fetch_object();

				$enderecoderetorno = DOMINIO."index/pedidos_detalhes/codigo/".$codigo_pedido."/";
				$enderecoderetorno_sucesso = DOMINIO."index/pedidos_detalhes/codigo/".$codigo_pedido."/";

				require_once('vendor/autoload.php');

				MercadoPago\SDK::setClientId($data_pagamento->mercadopago_client_id);
				MercadoPago\SDK::setClientSecret($data_pagamento->mercadopago_client_secret);
				MercadoPago\SDK::setAccessToken($data_pagamento->mercadopago_access_token);
					//$data_pagamento->mercadopago_public_key

				$preference = new MercadoPago\Preference();

				$valor_tratado_mp = str_replace(".", "", $valores->trata_valor($valor_total_pedido));
				$valor_tratado_mp = str_replace(",", ".", $valor_tratado_mp);

				$item = new MercadoPago\Item(); 
				$item->title = "Pedido ".$data_pedido->id;
				$item->quantity = 1;
				$item->unit_price = $valor_tratado_mp;
				$preference->items = array($item);
				$preference->external_reference = $codigo_pedido;
				$preference->back_urls = array(
					"success" => "$enderecoderetorno_sucesso",
					"failure" => "$enderecoderetorno",
					"pending" => "$enderecoderetorno_sucesso"
				);
				$preference->auto_return = "all";
				$preference->notification_url = DOMINIO."sistema/mercadopago_retorno/index.php";					 
				$preference->save();

				if($preference->id){

					$codigo_transacao = $preference->id;

					$vencimento_pedido = strtotime("+2 days");

					$conexao = new mysql();
					$conexao->alterar("pedido_loja", array(
						"cadastro"=>$cadastro,
						"vencimento"=>$vencimento_pedido,
						"valor_produtos"=>$valor_subtotal,
						"valor_produtos_desc"=>$total_descontos,
						"valor_total"=>$valor_total_pedido,
						"forma_pagamento"=>$formadepagamento,
						"id_transacao"=>$codigo_transacao,
						"status"=>1
					), " codigo='".$this->_sessao."' ");

					// baixa estoque
					$produtos->baixa_estoque($this->_sessao);

					// envia email
					$msg = $texto_email;
					$email_destino = $data_cadastro->email;
					$envio->enviar("Confirmação de Pedido", $msg, array("0"=>"$email_destino"));
					$envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);

						// retorna
					$ret_erro_cod = "0";
					$ret_erro_msg = "";
					$ret_processo = "ok";
					$ret_forma = "mercadopago";
					$ret_forma_code = "$codigo_transacao";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;

				} else {

						// retorna
					$ret_erro_cod = "1";
					$ret_erro_msg = "Dados de pagamento incorretos";

						//$ret_erro_msg = "Dados de cadastro incorretos - ".$retorno_mercadopago['erro_msg'];
					$ret_processo = "erro";
					$ret_forma = "";
					$ret_forma_code = "";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;
				} 

				break;

				// PAYPAL
				case '4':

				$conexao = new mysql();
				$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='4' ");
				$data_pagamento = $coisas_pagamento->fetch_object();


				$codigo_transacao = '';

				$vencimento_pedido = strtotime("+2 days");

				$conexao = new mysql();
				$conexao->alterar("pedido_loja", array(
					"cadastro"=>$cadastro,
					"vencimento"=>$vencimento_pedido,
					"valor_produtos"=>$valor_subtotal,
					"valor_produtos_desc"=>$total_descontos,
					"valor_total"=>$valor_total_pedido,
					"forma_pagamento"=>$formadepagamento,
					"id_transacao"=>$codigo_transacao,
					"status"=>0
				), " codigo='".$this->_sessao."' ");

				// baixa estoque
				$produtos->baixa_estoque($this->_sessao);

				// envia email
				$msg = $texto_email;
				$email_destino = $data_cadastro->email;
				$envio->enviar("Confirmação de Pedido", $msg, array("0"=>"$email_destino"));
				$envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);

				// retorna
				$ret_erro_cod = "0";
				$ret_erro_msg = "";
				$ret_processo = "ok";
				$ret_forma = "paypal";
				$ret_forma_code = "$codigo_transacao";
				$ret_endereco = "";

				mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
				exit;


				break;


				case '6':
				
				// instancia model
				$cielo = new model_cielo();
				// echo '<pre>';
				// print_r('valor pedido: '.$valor_total_pedido);
				// exit;
				// $retorno_cielo = $cielo->pagamento($codigo_pedido, $this->_cod_usuario, "Pedido $data_pedido->id", $valor_total_pedido);
				

				// if(1 == 1){

					// $codigo_transacao = $retorno_cielo['code'];
					// $endereco = $retorno_cielo['endereco'];

					// if($endereco){

						$vencimento_pedido = strtotime("+2 days");

						//finaliza pedido
						$conexao = new mysql();
						$conexao->alterar("pedido_loja", array(
							"cadastro"=>"$cadastro",
							"vencimento"=>"$vencimento_pedido",
							"valor_produtos"=>"$valor_subtotal",
							"valor_produtos_desc"=>"$total_descontos",
							"valor_total"=>"$valor_total_pedido",
							"forma_pagamento"=>"$formadepagamento",
							"id_transacao"=>"",
							// "id_transacao"=>"$codigo_transacao",
							// "link_cielo"=>"$endereco",
							"link_cielo"=>"",
							"status"=>"1"
						), " codigo='".$this->_sessao."' ");

							// baixa estoque
						$produtos->baixa_estoque($this->_sessao);

							// envia email									 
						$msg = $texto_email;
						$email_destino = $data_cadastro->email;
						$envio->enviar("Confirmação de Pedido", $msg, array("0"=>"$email_destino"));
						$envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);

							// retorna
						$ret_erro_cod = "0";
						$ret_erro_msg = "";
						$ret_processo = "ok";
						$ret_forma = "cielo";
						$ret_forma_code = $codigo_transacao;
						$ret_endereco = $endereco;

						mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma, $ret_forma_code, $ret_endereco);
						exit;

					// } 
					// else {
					// 		// retorna
					// 	$ret_erro_cod = "1";
					// 	$ret_erro_msg = "Dados de cadastro incorretos";
					// 		//$ret_erro_msg = "Dados de cadastro incorretos - ".$retorno_mercadopago['erro_msg'];
					// 	$ret_processo = "erro";
					// 	$ret_forma = "";
					// 	$ret_forma_code = "";
					// 	$ret_endereco = "";

					// 	mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma, $ret_forma_code, $ret_endereco);
					// 	exit;
					// }
				// } 
				// else {

				// 		// retorna
				// 	$ret_erro_cod = "1";
				// 	$ret_erro_msg = "Dados de cadastro incorretos";
				// 		//$ret_erro_msg = "Dados de cadastro incorretos - ".$retorno_mercadopago['erro_msg'];
				// 	$ret_processo = "erro";
				// 	$ret_forma = "";
				// 	$ret_forma_code = "";
				// 	$ret_endereco = "";

				// 	mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma, $ret_forma_code, $ret_endereco);
				// 	exit;
				// }

				break;


				// PIX MercadoPago
				case '8':

				$conexao = new mysql();
				$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='8' ");
				$data_pagamento = $coisas_pagamento->fetch_object();

				$enderecoderetorno = DOMINIO."index/pedidos_detalhes/codigo/".$codigo_pedido."/";
				$enderecoderetorno_sucesso = DOMINIO."index/pedidos_detalhes/codigo/".$codigo_pedido."/";

				require_once('vendor/autoload.php');

				MercadoPago\SDK::setClientId($data_pagamento->mercadopago_client_id);
				MercadoPago\SDK::setClientSecret($data_pagamento->mercadopago_client_secret);
				MercadoPago\SDK::setAccessToken($data_pagamento->mercadopago_access_token);
					//$data_pagamento->mercadopago_public_key

				$valor_tratado_mp = str_replace(".", "", $valores->trata_valor($valor_total_pedido));
				$valor_tratado_mp = str_replace(",", ".", $valor_tratado_mp);

				$payment = new MercadoPago\Payment();
				$payment->transaction_amount = $valor_tratado_mp;
				$payment->description = "Pedido ".$data_pedido->id;
				$payment->external_reference = $codigo_pedido;
				$payment->payment_method_id = "pix";
				$payment->notification_url = DOMINIO."sistema/mercadopago_retorno/index_pix.php";
				$payment->payer = array(
					"email" =>"$data_cadastro->email",
					"first_name" => "",
					"last_name" => "",
					"identification" => array(
						"type" => "CPF",
						"number" => "$data->fisica_cpf"
					),
					"address"=>  array(
						"zip_code" => "",
						"street_name" => "",
						"street_number" => "",
						"neighborhood" => "",
						"city" => "",
						"federal_unit" => ""
					)
				);

				$payment->save();
				

				// print_r($payment);

				if($payment->id){

					$codigo_transacao = $payment->id;
					$qrcode = $payment->point_of_interaction->transaction_data->qr_code_base64;
					$pix_chave = $payment->point_of_interaction->transaction_data->qr_code;

					$vencimento_pedido = strtotime("+2 days");

					$conexao = new mysql();
					$conexao->alterar("pedido_loja", array(
						"cadastro"=>$cadastro,
						"vencimento"=>$vencimento_pedido,
						"valor_produtos"=>$valor_subtotal,
						"valor_produtos_desc"=>$total_descontos,
						"valor_total"=>$valor_total_pedido,
						"forma_pagamento"=>$formadepagamento,
						"id_transacao"=>$codigo_transacao,
						"pix_qrcode"=>$qrcode,
						"pix_chave"=>$pix_chave,
						"status"=>0
					), " codigo='".$this->_sessao."' ");

					// baixa estoque
					$produtos->baixa_estoque($this->_sessao);

					// envia email
					$msg = $texto_email;
					$email_destino = $data_cadastro->email;
					$envio->enviar("Confirmação de Pedido", $msg, array("0"=>"$email_destino"));
					$envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);

					// retorna
					$ret_erro_cod = "0";
					$ret_erro_msg = "";
					$ret_processo = "ok";
					$ret_forma = "mercadopago";
					$ret_forma_code = "$codigo_transacao";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;

				} else {

						// retorna
					$ret_erro_cod = "1";
					$ret_erro_msg = "Dados de pagamento incorretos";

						//$ret_erro_msg = "Dados de cadastro incorretos - ".$retorno_mercadopago['erro_msg'];
					$ret_processo = "erro";
					$ret_forma = "";
					$ret_forma_code = "";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;
				} 
				break;



				$conexao = new mysql();
				$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='8' ");
				$data_pagamento = $coisas_pagamento->fetch_object();

				$enderecoderetorno = DOMINIO."index/pedidos_detalhes/codigo/".$codigo_pedido."/";
				$enderecoderetorno_sucesso = DOMINIO."index/pedidos_detalhes/codigo/".$codigo_pedido."/";

				require_once('vendor/autoload.php');

				MercadoPago\SDK::setClientId($data_pagamento->mercadopago_client_id);
				MercadoPago\SDK::setClientSecret($data_pagamento->mercadopago_client_secret);
				MercadoPago\SDK::setAccessToken($data_pagamento->mercadopago_access_token);
					//$data_pagamento->mercadopago_public_key

				$preference = new MercadoPago\Preference();

				$valor_tratado_mp = str_replace(".", "", $valores->trata_valor($valor_total_pedido));
				$valor_tratado_mp = str_replace(",", ".", $valor_tratado_mp);

				$item = new MercadoPago\Item(); 
				$item->title = "Pedido ".$data_pedido->id;
				$item->quantity = 1;
				$item->unit_price = $valor_tratado_mp;
				$preference->items = array($item);
				$preference->external_reference = $codigo_pedido;
				$preference->back_urls = array(
					"success" => "$enderecoderetorno_sucesso",
					"failure" => "$enderecoderetorno",
					"pending" => "$enderecoderetorno_sucesso"
				);
				$preference->auto_return = "all";
				$preference->notification_url = DOMINIO."sistema/mercadopago_retorno/index_pix.php";				
				$preference->save();

				if($preference->id){

					$codigo_transacao = $preference->id;

					$vencimento_pedido = strtotime("+2 days");

					$conexao = new mysql();
					$conexao->alterar("pedido_loja", array(
						"cadastro"=>$cadastro,
						"vencimento"=>$vencimento_pedido,
						"valor_produtos"=>$valor_subtotal,
						"valor_produtos_desc"=>$total_descontos,
						"valor_total"=>$valor_total_pedido,
						"forma_pagamento"=>$formadepagamento,
						"id_transacao"=>$codigo_transacao,
						"status"=>1
					), " codigo='".$this->_sessao."' ");

					// baixa estoque
					$produtos->baixa_estoque($this->_sessao);

					// envia email
					$msg = $texto_email;
					$email_destino = $data_cadastro->email;
					$envio->enviar("Confirmação de Pedido", $msg, array("0"=>"$email_destino"));
					$envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);

						// retorna
					$ret_erro_cod = "0";
					$ret_erro_msg = "";
					$ret_processo = "ok";
					$ret_forma = "mercadopago";
					$ret_forma_code = "$codigo_transacao";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;

				} else {

						// retorna
					$ret_erro_cod = "1";
					$ret_erro_msg = "Dados de pagamento incorretos";

						//$ret_erro_msg = "Dados de cadastro incorretos - ".$retorno_mercadopago['erro_msg'];
					$ret_processo = "erro";
					$ret_forma = "";
					$ret_forma_code = "";
					$ret_endereco = "";

					mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
					exit;
				} 

				break;


				default:

				$vencimento_pedido = strtotime("+2 days");

				$conexao = new mysql();
				$conexao->alterar("pedido_loja", array(
					"cadastro"=>$cadastro,
					"vencimento"=>$vencimento_pedido,
					"valor_produtos"=>$valor_subtotal,
					"valor_produtos_desc"=>$total_descontos,
					"valor_total"=>$valor_total_pedido,
					"forma_pagamento"=>$formadepagamento,
					"status"=>0
				), " codigo='".$this->_sessao."' ");

				// baixa estoque
				$produtos->baixa_estoque($this->_sessao);

				// envia email
				$email_destino = $data_cadastro->email;
				$envio->enviar("Confirmação de Pedido", $texto_email, array("0"=>"$email_destino"));
				$envio->enviar("Novo Pedido", $texto_email_admin, $lista_envio_adm);


				$codigo_pedido = $this->_sessao;

				$novasessao = $this->gera_codigo();
				$this->_sessao = $novasessao;
				$_SESSION[$this->_sessao_principal]['loja_cod_sessao'] = $novasessao;


				// retorna
				$ret_erro_cod = "0";
				$ret_erro_msg = "";
				$ret_processo = "ok";
				$ret_forma = "condicional";
				$ret_forma_code = "";
				$ret_endereco = "";

				mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
				exit;

			}

		} else {

			// retorna
			$ret_erro_cod = "1";
			$ret_erro_msg = "Sem itens no carrinho";
			$ret_processo = "erro";
			$ret_forma = "";
			$ret_forma_code = "";
			$ret_endereco = "";

			mostra_result($ret_erro_cod, $ret_erro_msg, $ret_processo, $ret_forma);
			exit;

		}

	}

	public function alterar_cadastro(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$cadastro = new model_cadastro();
		$dados['data_dados'] = $cadastro->dados_usuario($this->_cod_usuario);

		$estados_cidades = new model_estados_cidades();
		$dados['estados'] = $estados_cidades->lista_estados($dados['data_dados']->estado);


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM cadastro_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao .= "<a class='botao_padrao botao_".$data->codigo."' onclick=\"salvar();\" >".$data->texto."</a>";

		} else {
			$botao = "";
		}
		$dados['nome_do_usuario'] = $this->_nome_usuario;

		$dados['botao_padrao'] = $botao;		 
		
		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
 		//carrega view e envia dados para a tela
		$this->view('cadastro_alterar', $dados);
	}

	public function salvar_cadastro(){

		$dados = array();
		$dados['_base'] = $this->_base();

		// retorno de dados caso erro
		function retorno_erro($msg){

			$retorno = array();
			$retorno['erro'] = 1;
			$retorno['processo'] = 'erro';
			$retorno['erro_msg'] = $msg;

			echo json_encode($retorno);	
			exit;
		}

		// recebe variaveis

		$email = $this->post('email');
		$senha = $this->post('senha');
		$senha_confirma = $this->post('senha_confirma');

		$tipo = $this->post('tipo');

		$fisica_nome = $this->post('fisica_nome');
		$fisica_sexo = $this->post('fisica_sexo');
		$fisica_nascimento = $this->post('fisica_nascimento');
		$fisica_cpf = $this->post('fisica_cpf'); 

		$juridica_nome = $this->post('juridica_nome');
		$juridica_razao = $this->post('juridica_razao');
		$juridica_cnpj = $this->post('juridica_cnpj');
		$juridica_ie = $this->post('juridica_ie');
		$juridica_responsavel = $this->post('juridica_responsavel');

		$telefone = $this->post('telefone_fixo');
		$cep = $this->post('cadastro_cep');
		$endereco = $this->post('endereco');
		$numero = $this->post('numero');
		$complemento = $this->post('complemento');
		$bairro = $this->post('bairro');
		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		//validar email consultando no banco
		if(!$email){

			retorno_erro("E-mail inválido!");
			exit;

		} else {

			$validaemail = new model_valida();				
			if(!$validaemail->email($email)){
				retorno_erro("E-mail inválido!");
				exit;
			} else {

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE email='$email' AND codigo!='".$this->_cod_usuario."'  ");
				$linhas = $coisas->num_rows;

				if($linhas != 0){
					retorno_erro("Este e-mail esta sendo utilizado por outro cadastro,<br>informe um e-mail diferente ou tente a recuperação de senha.");
					exit;
				}
			}
		}

		//validar senha
		if($senha AND $senha_confirma){
			if($senha != $senha_confirma){

				retorno_erro("Digite uma senha válida e confirme.");
				exit;

			}
		} else {

			retorno_erro("Digite uma senha válida e confirme.");
			exit;

		}

		// valida documentos
		require_once("api/cpf_cnpj/cpf_cnpj.php");

		//validar cpf ou cnpj simples
		if($tipo == 'F'){

			if(!$fisica_cpf){

				retorno_erro("Digite corretamente seu CPF.");			 
				exit;

			} else {

				$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
				if(!$cpf_cnpj->valida()){
					retorno_erro("Digite corretamente seu CPF.");
					exit;
				}

			}

			//limpar dados do oposto do tipo (juridica ou fisica)
			$juridica_nome = "";
			$juridica_razao = "";
			$juridica_cnpj = "";
			$juridica_responsavel = "";

			if(!$fisica_nome){
				retorno_erro("Digite seu nome completo.");	 
				exit;				
			}
			if(!$fisica_sexo){
				retorno_erro("Informe seu sexo.");	 
				exit;
			}
			if(!$fisica_nascimento){
				retorno_erro("Informe sua data de nascimento.");	 
				exit;
			} else {

				// transforma data em inteiro
				$arraydata = explode("/", $fisica_nascimento);				
				$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." 00:00:01";
				$fisica_nascimento = strtotime($hora_montada);

			}

		} else {
			if(!$juridica_cnpj){

				retorno_erro("Digite corretamente o CNPJ.");				 
				exit;

			} else {

				$cpf_cnpj = new valida_cpf_cnpj("$juridica_cnpj");
				if(!$cpf_cnpj->valida()){
					retorno_erro("Digite corretamente o CNPJ.");				 
					exit;
				}

			}

			//limpar dados do oposto do tipo (juridica ou fisica)
			$fisica_nome = "";
			$fisica_sexo = "";
			$fisica_nascimento = "";
			$fisica_cpf = "";

			if(!$juridica_nome){
				retorno_erro("Complete todos os dados da empresa.");	 
				exit;
			}
			if(!$juridica_razao){
				retorno_erro("Complete todos os dados da empresa.");	 
				exit;
			}

		}		 

		//validar todos os campos de telefone e endereço
		if(!$telefone){

			retorno_erro("Telefone inválido");	 
			exit;

		}
		if(!$cep){

			retorno_erro("CEP inválido");	 
			exit;

		}
		if($endereco AND $numero AND $bairro AND $estado AND $cidade){ } else {

			retorno_erro("Preencha corretamente seus dados de endereço!");	 
			exit;

		}

		$senha_tratada = password_hash($senha, PASSWORD_DEFAULT);

		$db = new mysql();
		$db->alterar("cadastro", array(
			"tipo"=>"$tipo",
			"fisica_nome"=>"$fisica_nome",
			"fisica_sexo"=>"$fisica_sexo",
			"fisica_nascimento"=>"$fisica_nascimento",
			"fisica_cpf"=>"$fisica_cpf",
			"juridica_nome"=>"$juridica_nome",
			"juridica_razao"=>"$juridica_razao",
			"juridica_responsavel"=>"$juridica_responsavel",
			"juridica_cnpj"=>"$juridica_cnpj", 
			"cep"=>"$cep",
			"endereco"=>"$endereco",
			"numero"=>"$numero",
			"complemento"=>"$complemento",
			"bairro"=>"$bairro",
			"estado"=>"$estado",
			"cidade"=>"$cidade",
			"telefone"=>"$telefone",
			"email"=>"$email",
			"senha"=>"$senha_tratada"
		), " codigo='".$this->_cod_usuario."' ");


		// se deu tudo certo retorna ok
		$retorno = array();
		$retorno['erro'] = 0;
		$retorno['processo'] = 'ok';
		$retorno['erro_msg'] = '<strong>Seu cadastro foi atualizado com sucesso!</strong>';
		echo json_encode($retorno);	
		exit;
	}

	public function update_clients_vindi(){
		$id = 38584546;

		require_once('vendor/autoload.php');
		$arguments = array(
			'VINDI_API_KEY' => 'OgsJZgvfOkCv6k_xfxVRoOhK015dphT2tZ3JeS2XQ1M',
			'VINDI_API_URI' => 'https://app.vindi.com.br/api/v1/'
		);
		
		$customerService = new Vindi\Customer($arguments);
		$customerService->update($id, [
			'notes' => 'Atualizado pelo Andre via API',
		]);
		echo '<pre>';
		print_r($customerService->all());
	}

	public function check_curso_matricula_exist($id_usuario, $id_perfil, $id_trilha, $id_curso){
		require('conexao.php');

		$sql = "SELECT id_curso FROM curso_matricula WHERE id_usuario='$id_usuario' AND id_perfil='$id_perfil' AND id_trilha='$id_trilha' AND id_curso='$id_curso';";
		if ($result = $mysqli->query($sql)) {

			if($result->num_rows == 1){
				return 1;
			}else{
				return 0;
			}
		}
		
	}

	public function integrar_trilha_lms($produto_ref,$sessao_loja, $cpf){
		/////////////////////////////////// SEND TO LMS ///////////////////////////////////
		require('conexao.php');
		echo $sessao_loja;
		echo '<br>';
		$cpf = str_replace("-","",$cpf);
		$cpf = str_replace(".","",$cpf);
		echo $cpf;

		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("select * from pedido_loja_carrinho WHERE sessao = '".$sessao_loja."' and produto_ref = '".$produto_ref."' ");
		$linha_carrinho = $coisas_carrinho->num_rows;
		echo'<pre>';

		$sql = "SELECT id, id_perfil FROM usuario WHERE CPF = '$cpf' limit 1 ";
		$id_usuario = null;
		$id_perfil  = null;
		if ($result = $mysqli->query($sql)) {
			while ($obj = $result->fetch_object()) {
				$id_usuario = $obj->id;
				$id_perfil  = $obj->id_perfil;
		  	}
		  	$result->free_result();
		}
		echo 'ID USUARIO';

		echo 'ID USUARIO: '.$id_usuario;
		echo '<br>';
		echo 'Prod_ref - ID TRILHA';

		if($linha_carrinho != 0){

			$data_array = array();
			while($data_carrinho = $coisas_carrinho->fetch_object()){


				$sql2 = "SELECT * FROM curso WHERE id_trilha = '$data_carrinho->produto_ref' ";
				if ($result2 = $mysqli->query($sql2)) {
				print_r($result2);exit;
					while ($obj2 = $result2->fetch_object()) {
						$array = array(
							'id_usuario' => $id_usuario, 
							'id_perfil' => $id_perfil,
							'id_trilha' => $data_carrinho->produto_ref,
							'id_curso'  => $obj2->id,
							'status_curso'  => 0,
							'data_matricula' => date('Y-m-d', $data_carrinho->data_compra),
							'dt_vencimento_matricula' => date('Y-m-d', $data_carrinho->data_vencimento),
							'progresso' => 0,
							'ativo_matricula' => 1
						);
						
						array_push($data_array,$array);
					}
				}	
			}
		}
		echo 'aqui';
		print_r($data_array);exit;
		foreach($data_array as $data){
			$id_usuario 				= $data['id_usuario'];
			$id_perfil 					= $data['id_perfil'];
			$id_trilha 					= $data['id_trilha'];
			$id_curso 					= $data['id_curso'];
			$status_curso 				= $data['status_curso'];
			$data_matricula 			= $data['data_matricula'];
			$dt_vencimento_matricula 	= $data['dt_vencimento_matricula'];
			$progresso 					= $data['progresso'];
			$ativo_matricula 			= $data['ativo_matricula'];
			
			$exit_line = $this->check_curso_matricula_exist($id_usuario, $id_perfil, $id_trilha, $id_curso);

			if($exit_line == 0){
				$sql_insert = "INSERT INTO curso_matricula (id_usuario, id_perfil, id_trilha, id_curso, status_curso, data_matricula, ativo_matricula, progresso, dt_vencimento_matricula)
					VALUES('$id_usuario', '$id_perfil', '$id_trilha', '$id_curso', '$status_curso', '$data_matricula', '$ativo_matricula' , '$progresso', '$dt_vencimento_matricula');";
				$mysqli->query($sql_insert);
			}else{
				$sql_update = "UPDATE curso_matricula SET ativo_matricula='$ativo_matricula', dt_vencimento_matricula='$dt_vencimento_matricula' WHERE id_usuario='$id_usuario' AND id_perfil='$id_perfil' AND id_trilha='$id_trilha' AND id_curso='$id_curso';";
				$mysqli->query($sql_update);
			}
			print_r($mysqli);
		}

		print_r('Cliente adicionado');echo'<br>';

		/////////////////////////////////// SEND TO LMS ///////////////////////////////////
	}

	/////////  ESTORNO /////////

	public function estorno(){
		require('conexao.php');

		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='".$_POST['codigo']."' ");

		$sql_update = "UPDATE curso_matricula SET ativo_matricula='$ativo_matricula', dt_vencimento_matricula='$dt_vencimento_matricula' WHERE id_usuario='$id_usuario' AND id_perfil='$id_perfil' AND id_trilha='$id_trilha' AND id_curso='$id_curso';";
		$mysqli->query($sql_update);

	}
	/////////////////////////////

	///////// PAGAMENTOS /////////

	public function vindi_flow(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;
		$dados['data_pagina'] = 'Finalizada';
		$chave = $this->_layout;
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;
		
		////////////////////////////////////////////////////////////////////////
		
		$cores = array();
		
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;
		
		////////////////////////////////////////////////////////////////////////
		
		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;
		require_once('vendor/autoload.php');

		$arguments = array(
			'VINDI_API_KEY' => $_POST['vindi_key'],
			'VINDI_API_URI' => $_POST['vindi_url']
		);
		$customerService = new Vindi\Customer($arguments);
		$paymentProfile = new Vindi\PaymentProfile($arguments);
		$productService = new Vindi\Product;
		
		$cpf = $_POST['cpf'];
		$recorrencia = 0;
		$email = $_POST['email'];
		$name = $_POST['nomeCompleto'];
		
		$name_on_card = $_POST['nomeCompleto'];
		$card_number = $_POST['cardNumber'];
		$expiration_card = $_POST['cardExpiry'];
		$cvv = $_POST['cardCVC'];
		$payment_company_name = $_POST['brand_'];
		$total_amount = $_POST['amount_'];
		$card_number = str_replace("-","",$card_number);
		$last4 = substr($card_number,12,16);

		$cod = $_POST['codigo'];

		//////////////////////////////////////////////////////////////
		// Checando se usuario existe na VINDI
		$customer = $customerService->all([
			'query' => 'email: "'.$email.'"'
		]);
		if($customer[0]->id > 0){//pegando o id do usuario na VINDI
			$id_client = $customer[0]->id;
		}else{ // Adicionando usuario
			$data = [
				'name'   => $name,
				'email'  => $email
			];
			$add_client = $this->vindi_add_new_client($arguments,$data);
			$id_client = $add_client->id;
		}
		//////////////////////////////////////////////////////////////

		//////////////////////////////////////////////////////////////
		// Checando meio de pagamento do usuario na VINDI
		$result = $paymentProfile->all([
			'query' => 'customer_id="'.$id_client.'"'
		]);

		//Checando se tem algum cartao cadastrado e se ele eh o mesmo que o usuario passou
		$last_four = 0;
		$pay_met = 0;
		foreach($result as $res){
			if($res->status == 'active'){
				$last_four = $res->card_number_last_four;
				$pay_met = $res->payment_method->code;
			}
		}
				
		// Adicionando cartao na VINDI se nao tiver nenhum cartao cadastrado ou se o cartao usado é diferente
		if($last_four == $last4){
			$payment_met = $pay_met;
		}else{
			$card = [
				'name' => $name_on_card,
				"holder_name" => $name_on_card,
				"card_expiration" => $expiration_card,
				"card_number" => $card_number,
				"card_cvv" => $cvv,
				"payment_method_code" => "credit_card",
				"payment_company_code" => $payment_company_name,
				"customer_id" => $id_client
			];
			$add_card = $this->vindi_add_card_to_client($arguments,$card);

			if(isset($add_card->payment_method->code)){
				$payment_met =  $add_card->payment_method->code;
			}else{
				$this->msg($add_card);
				$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$cod);
			}
		}	
		//////////////////////////////////////////////////////////////

		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='".$cod."' ");
		$linha_carrinho = $coisas_carrinho->num_rows;
		
		if($linha_carrinho != 0){

			$recorrentes = array();
			$nao_recorrentes = array();
			while($data_carrinho = $coisas_carrinho->fetch_object()){
				if($data_carrinho->id_combo > 0){

					$id_combo = $data_carrinho->id_combo;
					if (!empty($recorrentes[$id_combo]))
					{
						$recorrentes[$id_combo] = array_merge($recorrentes[$id_combo], array($data_carrinho));
					}
					else
					{
						$recorrentes[$id_combo] = array($data_carrinho);
					}
				}else{
					$nao_recorrentes[] = $data_carrinho;
				}
				
			}
		}	
		
		
		/////////     RECCORENTE    /////////////
		// foreach($recorrentes as $key => $recorrencia){
			
		// 	// $this->integrar_trilha_lms($cod, $cpf);
		// 	foreach($recorrencia as $rec){
		// 		// print_r($rec->produto_ref.' - '.$cod.''.$cpf);exit;
		// 		$this->integrar_trilha_lms($rec->produto_ref,$cod, $cpf);
		// 	}
		// 	exit;
		
		// 	$amout = 0;
		// 	$produto_assinatura = '';
		// 	foreach($recorrencia as $rec){
		// 		if($rec->usar_valor_vindi == 1){
		// 			$amout = $rec->valor_total;
		// 		}else{
		// 			$amout = $amout + $rec->valor_total;
		// 		}
		// 		$produto_assinatura = $rec->produto_assinatura;
		// 	}
		// 	// echo '<pre>'; print_r($id_client.'-'.$payment_met.'-'.$produto_assinatura.'-1040228-'.$amout);exit;
		// 	$bill = $this->vindi_add_subscription($id_client,$payment_met,$produto_assinatura,1040228,$amout);

		// 	if(isset($bill['bill']['id'])){
		// 		$id_charge = $bill['bill']['charges'][0]['id'];
		// 		$id_trans = $bill['bill']['id'];

		// 		if($bill['bill']['charges'][0]['status'] == 'paid'){ 
		// 			$status = 4;
		// 			foreach($recorrencia as $rec){
		// 				$this->integrar_trilha_lms($rec->produto_ref,$cod, $cpf);
		// 			}
					
		// 		}else{
		// 			$status = 1;
		// 		}
		// 		$db = new mysql();
		// 		$db->alterar("pedido_loja_carrinho", array(
		// 			"transacao_charger_id"=>"$id_charge",
		// 			"transacao_bill_id"=>"$id_trans",
		// 			"status"=>"$status",
		// 		), " id='$rec->id' ");

		// 		$db->alterar("pedido_loja", array(
		// 			"transacao_charger_id"=>"$id_charge",
		// 			"transacao_bill_id"=>"$id_trans",
		// 			"status"=>"$status",
		// 		), " codigo='$cod' ");
		// 	}
		// }
		
		/////////  /////////////  /////////////

		/////////////   NAO  RECCORENTE    /////////////

		foreach($nao_recorrentes as $key => $recorrencia){
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			$bill = $this->pay_bill_vindi($id_client,$payment_met,$recorrencia->valor_total);

			if(isset($bill->id)){
				$id_charge = $bill->charges[0]->id;
				$id_trans = $bill->id;

				if($bill->status == 'paid'){ 
					$status = 4;
					foreach($recorrencia as $rec){
						print_r($rec->produto_ref);exit;
						$this->integrar_trilha_lms($rec->produto_ref,$cod, $cpf);
					}
				}else{
					$status = 1;
				}
				$db = new mysql();
				$db->alterar("pedido_loja_carrinho", array(
					"transacao_charger_id"=>"$id_charge",
					"transacao_bill_id"=>"$id_trans",
					"status"=>"$status",
					
				), " id='$recorrencia->id' ");
				$db->alterar("pedido_loja", array(
					"transacao_charger_id"=>"$id_charge",
					"transacao_bill_id"=>"$id_trans",
					"status"=>"$status",
					
				), " codigo='$cod' ");
			}
		}
		/////////////  /////////////  /////////////
			$this->view('finalizada', $dados);
		
	}

	public function vindi_add_subscription($id_client,$payment_met,$plano,$prodId,$amout){
		
		$subscriptionService = new Vindi\Subscription;
		try{
			$subscription = $subscriptionService->create([
				'plan_id' => $plano,
				'customer_id' => $id_client,
				'payment_method_code' => "credit_card",
				'product_items' => [
					[
						'product_id' => 451606,
						'pricing_schema' => [
							"price" => $amout,
						]
					]
				]
			]);
			$lastResponse = $subscriptionService->getLastResponse()->getBody();
			$decoded_body = json_decode($lastResponse, true);
		} catch(Vindi\Exceptions\ValidationException $e){
			echo '<pre>';var_dump($e->getErrors());exit;
		}
		return $decoded_body;
	}

	public function vindi_add_new_client($arguments,$data){
		$customerService = new Vindi\Customer($arguments);
		$customer = $customerService->create($data);
		return $customer;
	}

	public function vindi_add_card_to_client($arguments,$data){
		$paymentProfileData = new Vindi\PaymentProfile($arguments);
		try{
			$paymentProfile = $paymentProfileData->create($data);
		} catch(Vindi\Exceptions\ValidationException $e){
			$paymentProfile = 'Verifique os detalhes do seu cartão e tente novamente.';
		}
		return $paymentProfile;
	}

	public function pay_bill_vindi($id_client,$payment_met,$amout){

		$billService = new Vindi\Bill;
		try{
		$bill = $billService->create( [
				'customer_id' => $id_client,
				'payment_method_code' => $payment_met,
				'bill_items' => [
					[
						'product_id' => 451606,
						'amount' => $amout
					]
				]
		]);
		} catch(Vindi\Exceptions\ValidationException $e){
			echo '<pre>';var_dump($e->getErrors());exit;
		}
		return $bill;
	}

	public function vindi_estorno(){
		$codigo = $this->get('codigo');
		require_once('vendor/autoload.php');

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://app.vindi.com.br/api/v1/charges/'.$codigo.'/refund',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"cancel_bill": "true",
				"comments": "Estorno pelo site"
			}',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'authorization: Basic N2FGMXktTW1uX2N5SE13QVhOaEhpdE5pNk1NaGFlNk9OdlFhSlg5TGJCYzp1bmRlZmluZWQ=',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		$response = json_decode($response, true);
		curl_close($curl);
		$this->irpara(DOMINIO.$this->_controller.'/minhaconta');
		// return $response;
		// if(isset($response['errors'])){
		// 	$response = 0;
		// }else{
		// 	if($response['charge']['status'] == 'canceled'){
		// 		$response = 1;
		// 	}else{
		// 		$response = 0;
		// 	}
		// }
		
		// return $response;
	}

	public function WebhookHandler(){

		require_once('vendor/autoload.php');	
		$webhookHandler = new Vindi\WebhookHandler();
		$event = $webhookHandler->handle();

		switch ($event->type) {
			case 'subscription_canceled':

				break;
			case 'subscription_created':

				break;
			case 'charge_rejected':

				break;
			case 'bill_created':

				break;
			case 'bill_paid':

				break;
			case 'charge_refunded':

				$id_charge 	= $event->data->charge->id;
				$id_bill 	= $event->data->charge->bill->id;

				$db = new mysql();
				$db->alterar("pedido_loja_carrinho", array(
					"status"=>8,
				), " transacao_charger_id='$id_charge' and transacao_bill_id='$id_bill' ");
				
				$db->alterar("pedido_loja", array(
					"status"=>8,
				), " transacao_charger_id='$id_charge' and transacao_bill_id='$id_bill' ");

				break;
			case 'test':

				break;
			default:

				break;
		}
	}

	public function pay2(){
		
		// ------------------------------------------------------------------

		$curl_2 = curl_init();

		curl_setopt_array($curl_2, array(
		CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals?email=financeiro@zoombusiness.com.br&token=0FA44F019F824AFF9917B863CB3C1B1C',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"plan": "655F6DF79898E33554D96FB303B5137A",
			"reference": "Teste",
			"sender": {
				"name": "Andre Test",
				"email": "financeiro@zoombusiness.com.br",
				"hash": "{{ADICIONE_SENDERHASH_DO_COMPRADOR}}",
				"phone": {
					"areaCode": "11",
					"number": "20516250"
				},
				"address": {
					"street": "Rua Vi Jose De Castro",
					"number": "99",
					"complement": "",
					"district": "It",
					"city": "Sao Paulo",
					"state": "SP",
					"country": "BRA",
					"postalCode": "06240300"
				},
				"documents": [{
					"type": "CPF",
					"value": "68951723003"
				}]
			},
			"paymentMethod": {
				"type": "CREDITCARD",
				"creditCard": {
					"token": "{{ADICIONE_TOKEN_DO_CARTÃO}}",
					"holder": {
						"name": "Julian Teste",
						"birthDate": "04/12/1991",
						"documents": [{
							"type": "CPF",
							"value": "19333575090"
						}],
						"phone": {
							"areaCode": "11",
							"number": "20516250"
						},
						"billingAddress": {
							"street": "Rua Vi Jose De Castro",
							"number": "99",
							"complement": "",
							"district": "It",
							"city": "Sao Paulo",
							"state": "SP",
							"country": "BRA",
							"postalCode": "06240300"
						}
					}
				}
			}
		}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Accept: application/vnd.pagseguro.com.br.v1+json;charset=ISO-8859-1'
		),
		));

		$response2 = curl_exec($curl_2);

		curl_close($curl_2);
		echo $response2;
		

		
	}

	public function nfe(){
		require_once("api/nfe/init.php");
		
		NFe_io::setApiKey('ox28nBhAujjmff3MhD12Fd4LYvS1POv2cAwgZ3HhJ9LOYlVoLVxRcq3ogbR7mwrUpIg'); // Ache sua chave API no painel (https://app.nfe.io/account/apikeys)
		// echo 'aqui 3';exit;
		$invoiceCreated = NFe_ServiceInvoice::create(
		// ID da empresa, você deve copiar exatamente como está no painel
		'62a8ad08da661a1a14e1a6f5',
		// Dados da nota fiscal de serviço
		array(
			// Código do serviço de acordo com o a cidade
			'cityServiceCode' => '2690',
			// Descrição dos serviços prestados
			'description'     => 'TESTE EMISSAO',
			// Valor total do serviços
			'servicesAmount'  => 0.01,
			// Dados do Tomador dos Serviços
			'borrower' => array(
			// CNPJ ou CPF (opcional para tomadores no exterior)
			'federalTaxNumber' => 191,
			// Nome da pessoa física ou Razão Social da Empresa
			'name'             => 'BANCO DO BRASIL SA',
			// Email para onde deverá ser enviado a nota fiscal
			'email'            => 'drekehrer@gmail.com', // Para visualizar os e-mails https://www.mailinator.com/
			// Endereço do tomador
			'address'          => array(
				// Código do pais com três letras
				'country'               => 'BRA',
				// CEP do endereço (opcional para tomadores no exterior)
				'postalCode'            => '70073901',
				// Logradouro
				'street'                => 'Outros Quadra 1 Bloco G Lote 32',
				// Número (opcional)
				'number'                => 'S/N',
				// Complemento (opcional)
				'additionalInformation' => 'QUADRA 01 BLOCO G',
				// Bairro
				'district'              => 'Asa Sul',
				// Cidade é opcional para tomadores no exterior
				'city' => array(
					// Código do IBGE para a Cidade
					'code' => '5300108',
					// Nome da Cidade
					'name' => 'Brasilia'
				),
				// Sigla do estado (opcional para tomadores no exterior)
				'state' => 'DF'
			)
			)
		)
		);

		echo($invoiceCreated->id);
	}

	public function pay(){
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;
		$dados['data_pagina'] = 'Finalizada';


		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

			$dados['layout_lista'] = $lista_blocos;

			$pref = $_POST['telefone'];
			$tel  = $_POST['telefone'];
			$pref = $pref[1].$pref[2];
			$tel  = substr($tel, 5); 
			$tel  = str_replace("-","",$tel);
			$cpf  = str_replace("-","",$_POST['cpf']);
			$cpf  = str_replace(".","",$cpf);

		if($_POST['forma_pagamento'] == 1){

			if($_POST['recorrencia'] == 1){
				
				
				// $curl_2 = curl_init();

				// curl_setopt_array($curl_2, array(
				// CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals?email=financeiro@zoombusiness.com.br&token=0FA44F019F824AFF9917B863CB3C1B1C',
				// CURLOPT_RETURNTRANSFER => true,
				// CURLOPT_ENCODING => '',
				// CURLOPT_MAXREDIRS => 10,
				// CURLOPT_TIMEOUT => 0,
				// CURLOPT_FOLLOWLOCATION => true,
				// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				// CURLOPT_CUSTOMREQUEST => 'POST',
				// CURLOPT_POSTFIELDS =>'{
				// 	"plan": "655F6DF79898E33554D96FB303B5137A",
				// 	"reference": "Teste",
				// 	"sender": {
				// 		"name": "Andre Test",
				// 		"email": "andre@swiftstudio.co",
				// 		"hash": "'.$_POST['senderHash'].'",
				// 		"phone": {
				// 			"areaCode": "11",
				// 			"number": "20516250"
				// 		},
				// 		"address": {
				// 			"street": "Rua Vi Jose De Castro",
				// 			"number": "99",
				// 			"complement": "",
				// 			"district": "It",
				// 			"city": "Sao Paulo",
				// 			"state": "SP",
				// 			"country": "BRA",
				// 			"postalCode": "06240300"
				// 		},
				// 		"documents": [{
				// 			"type": "CPF",
				// 			"value": "68951723003"
				// 		}]
				// 	},
				// 	"paymentMethod": {
				// 		"type": "CREDITCARD",
				// 		"creditCard": {
				// 			"token": "'.$_POST['token'].'",
				// 			"holder": {
				// 				"name": "Julian Teste",
				// 				"birthDate": "04/12/1991",
				// 				"documents": [{
				// 					"type": "CPF",
				// 					"value": "35323092890"
				// 				}],
				// 				"phone": {
				// 					"areaCode": "11",
				// 					"number": "20516250"
				// 				},
				// 				"billingAddress": {
				// 					"street": "Rua Vi Jose De Castro",
				// 					"number": "99",
				// 					"complement": "",
				// 					"district": "It",
				// 					"city": "Sao Paulo",
				// 					"state": "SP",
				// 					"country": "BRA",
				// 					"postalCode": "06240300"
				// 				}
				// 			}
				// 		}
				// 	}
				// }',
				// CURLOPT_HTTPHEADER => array(
				// 	'Content-Type: application/json',
				// 	'Accept: application/vnd.pagseguro.com.br.v1+json;charset=ISO-8859-1'
				// ),
				// ));

				// $response2 = curl_exec($curl_2);
				// curl_close($curl_2);
				// $response2 = json_decode($response2);
				// echo $response2->code;
				$curl3 = curl_init();
				curl_setopt_array($curl3, array(
				CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/payment?email=financeiro@zoombusiness.com.br&token=0FA44F019F824AFF9917B863CB3C1B1C',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<payment>
					<items>
						<item>
							<id>0001</id>
							<description>Descricao Teste</description>
							<amount>100.00</amount>
							<quantity>1</quantity>
						</item>
						<item>
							<id>0002</id>
							<description>Descricao Teste 2</description>
							<amount>100.00</amount>
							<quantity>9</quantity>
						</item>
						<item>
							<id>0003</id>
							<description>Descricao Teste 3</description>
							<amount>1000.00</amount>
							<quantity>1</quantity>
						</item>
						<item>
							<id>0004</id>
							<description>Descricao Teste 4</description>
							<amount>9900.00</amount>
							<quantity>99</quantity>
						</item>
					</items>
					<reference>REF1234-1</reference>
					<preApprovalCode>656B265F363601EFF4905FA64EA319FB</preApprovalCode>
				</payment> ',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/xml',
					'Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1'
				),
				));

				$response3 = curl_exec($curl3);

				curl_close($curl3);
				echo '<pre>';
				print_r($response3);

			}else{
				print_r('aqui2');
				exit;
				$creditCardToken = htmlspecialchars($_POST["token"]);
				$senderHash = htmlspecialchars($_POST["senderHash"]);
				$id_transacao = htmlspecialchars($_POST["id_transacao"]);

				$itemAmount = number_format($_POST["amount"], 2, '.', '');
				$shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
				$installmentValue = number_format($_POST["installmentValue"], 2, '.', '');
				$installmentsQty = $_POST["installments"];
				$PAGSEGURO_EMAIL = 'financeiro@zoombusiness.com.br';
				$PAGSEGURO_TOKEN = '0FA44F019F824AFF9917B863CB3C1B1C';


				$params = array(
					'email'                     => $PAGSEGURO_EMAIL,  
					'token'                     => $PAGSEGURO_TOKEN,
					'creditCardToken'           => $creditCardToken,
					'senderHash'                => $senderHash,
					'receiverEmail'             => $PAGSEGURO_EMAIL,
					'paymentMode'               => 'default', 
					'paymentMethod'             => 'creditCard', 
					'currency'                  => 'BRL',
					'itemId1'                   => '0001',
					'itemDescription1'          => 'Test',  
					'itemAmount1'               => $itemAmount,  
					'itemQuantity1'             => 1,
					'reference'                 => $id_transacao,
					'senderName'                => $_POST['nomeCompleto'],
					'senderCPF'                 => $cpf,
					'senderAreaCode'            => $pref,
					'senderPhone'               => $tel,
					'senderEmail'               => $_POST['email'],
					'shippingAddressStreet'     => $_POST['endereco'],
					'shippingAddressNumber'     => $_POST['numero'],
					'shippingAddressDistrict'   => $_POST['bairro'],
					'shippingAddressPostalCode' => $_POST['cep'],
					'shippingAddressCity'       => $_POST['estado'],
					'shippingAddressState'      => $_POST['cidade'],
					'shippingAddressCountry'    => 'BRA',
					'shippingType'              => 1,
					'shippingCost'              => $shippingCoast,
					'maxInstallmentNoInterest'      => 2,
					'noInterestInstallmentQuantity' => 2,
					'installmentQuantity'       => $installmentsQty,
					'installmentValue'          => $installmentValue,
					'creditCardHolderName'      => 'Chuck Norris',
					'creditCardHolderCPF'       => $cpf,
					'creditCardHolderBirthDate' => '01/01/1990',
					'creditCardHolderAreaCode'  => $pref,
					'creditCardHolderPhone'     => $tel,
					'billingAddressStreet'     => $_POST['endereco'],
					'billingAddressNumber'     => $_POST['numero'],
					'billingAddressDistrict'   => $_POST['bairro'],
					'billingAddressPostalCode' => $_POST['cep'],
					'billingAddressCity'       => $_POST['estado'],
					'billingAddressState'      => $_POST['cidade'],
					'billingAddressCountry'    => 'BRA'
				);

				$header = array('Content-Type' => 'application/json; charset=UTF-8;');
				$PAGSEGURO_API_URL = 'https://ws.sandbox.pagseguro.uol.com.br/v2';
				$response = $this->curlExec($PAGSEGURO_API_URL."/transactions", $params, $header);
				
				$json = json_decode(json_encode(simplexml_load_string($response)));

				if($json->status == 1){
					$this->view('finalizada', $dados);
				}
			}	
		}elseif($_POST['forma_pagamento'] == 6){

			function cielo_capture($MerchantID,$MerchantKey,$Ambiente,$MerchantOrderId,$description,$amount,$currencyCode,$cardType,$cardNumber,$cardExpiry,$cardStart,$cardIssueNumber,
			$cardCvv, $firstname,  $lastname, $email, $address1, $address2,  $city, $state,  $postcode, $country, $phone, $companyName, $systemUrl,  $returnUrl,  $langPayNow,
			$moduleDisplayName, $moduleName,  $whmcsVersion, $parcelas, $ccpf)
			{
				/*Transformar valor em centavos */
				$amount = str_replace(",", "", $amount);
				$amount = str_replace(".", "", $amount);

				if ( preg_match('/^5[1-5]/', $cardNumber) ): $bandeira = 'Master';
				elseif ( preg_match('/^4/', $cardNumber) ): $bandeira = 'Visa';
				elseif ( preg_match('/^((((636368)|(438935)|(504175)|(451416)|(636297))\d{0,10})|((5067)|(4576)|(4011))\d{0,12})$/', $cardNumber) ): $bandeira = 'Elo';
				elseif ( preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}/', $cardNumber) ): $bandeira = 'Diners';
				elseif ( preg_match('/^6(?:011|5[0-9]{2})[0-9]{12}/', $cardNumber) ): $bandeira = 'Discover';
				elseif ( preg_match('/^(?:2131|1800|35\d{3})\d{11}/', $cardNumber) ): $bandeira = 'JCB';
				elseif ( preg_match('/^3[47][0-9]{13}/', $cardNumber) ): $bandeira = 'Amex';
				elseif ( preg_match('/^50/', $cardNumber) ): $bandeira = 'Aura';
				else: $bandeira = 'Visa'; endif;

				$request = array(
					"MerchantOrderId" => $MerchantOrderId,  //Numero de identifica��o do Pedido.
					"Customer" => array(
						"Name" => $firstname,
						"Identity" => $ccpf
					),
					"Payment" => array(
						"Type" => "CreditCard",
						"Amount" => $amount,
						"Currency" => "BRL", 
						"Capture" => true,
						"Country" => "BRA",
						"Installments" => $parcelas,
						"SoftDescriptor" => substr(str_replace('w','',str_replace('.','',$_SERVER['SERVER_NAME'])),0,12),
						"CreditCard" => array(
							"CardNumber" => $cardNumber,
							"ExpirationDate" => $cardExpiry,
							"SecurityCode" => $cardCvv,
							"Brand" => $bandeira
						)
					)
				);
				echo'<pre>';print_r($request);exit;
				$data_string = json_encode($request, true);
				if ($Ambiente==2){
					$ch = curl_init("https://apisandbox.cieloecommerce.cielo.com.br/1/sales"); //ambiente de  testes
				}else{
					$ch = curl_init("https://api.cieloecommerce.cielo.com.br/1/sales");      //ambiente de producao
				}
				echo $ch;
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'MerchantId: ' . $MerchantID,
					'MerchantKey: ' . $MerchantKey,
					'Content-Length: ' . strlen($data_string))
				);
				$result = curl_exec($ch);
				$result = json_decode($result, true);
				return $result;
			}

			$pref = $_POST['telefone'];
			$tel  = $_POST['telefone'];
			$pref = $pref[1].$pref[2];
			$tel  = substr($tel, 5); 
			$tel  = str_replace("-","",$tel);
			$cpf  = str_replace("-","",$_POST['cpf']);
			$cpf  = str_replace(".","",$cpf);
			$itemAmount = number_format($_POST["amount"], 2, '.', '');


			$cMerchantOrderId=1;  
			$cvencimento=$_POST['cardExpiry'];
			// $primeironome=explode(' ',$_POST['nomeCompleto']);
			$cnome=$_POST['nomeCompleto'];
			$csobrenome='';
			$cemail=$_POST['email'];
			$cendereco=$_POST['endereco'];
			$cbairro=$_POST['bairro'];
			$ccidade=$_POST['cidade'];
			$cuf=$_POST['estado'];
			$ccep=$_POST['cep'];
			$cparcelas=$_POST['parcelas'];
			$ccpf=$cpf;
			$cvalor=$itemAmount;
			$cfrete=0;
			$cwhatsapp=$tel;
			$cnumerocartao=$_POST['cardNumber'];
			$cvv=$_POST['cardCVC'];
			$cloja = null;
			$cidcielo="";  
			$ckeycielo=""; 
			$retorno=cielo_capture($cidcielo,$ckeycielo,2,$cMerchantOrderId,'',$cvalor,'','',$cnumerocartao,$cvencimento,'','',
			$cvv, $cnome,  $csobrenome, $cemail, $cendereco, '',  $ccidade, $cuf,  $ccep, 'BRASIL', $cwhatsapp, $cloja, '',  '',  'PT',
			'', '',  '',$cparcelas, $ccpf);

			print_r($retorno);exit;
			if($retorno['Payment']['Status'] == 1){
				$this->view('finalizada', $dados);
			}

		}
	}

	public function minhaconta(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$dados['nome_do_usuario'] = $this->_nome_usuario;

		$pedidos = new model_pedidos();
		$dados['lista_pedidos'] = $pedidos->lista($this->_cod_usuario);
		$dados['lista_produto_comprado'] = $pedidos->lista_produto_comprado($this->_cod_usuario);

		// echo'<pre>'; print_r($dados['lista_produto_comprado']);exit;



		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM produto_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


 		//carrega view e envia dados para a tela
		$this->view('minhaconta', $dados);		
	}

	public function pedidos_detalhes(){

		$this->autenticado();
		
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;
		$nome = $this->_nome_usuario;

		$conexao = new mysql();
		$nome = $conexao->Executar("SELECT * FROM `cadastro` WHERE `fisica_nome` = '$nome'");
		while($data = $nome->fetch_object()){
			$dados['nome_cli'] 			= $data->fisica_nome;
			$dados['cpf'] 				= $data->fisica_cpf;
			$dados['fisica_nascimento'] = date('Y-m-d', $data->fisica_nascimento);
			$dados['cep'] 				= $data->cep;
			$dados['endereco'] 			= $data->endereco;
			$dados['numero'] 			= $data->numero;
			$dados['bairro'] 			= $data->bairro;
			$dados['estado'] 			= $data->estado;
			$dados['cidade'] 			= $data->cidade;
			$dados['telefone'] 			= $data->telefone;
			$dados['email'] 			= $data->email;
		}
		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		// carrega modulo de produtos
		$produtos = new model_produtos();
		$dados['categorias'] = $produtos->lista_categorias();

		//carrega modulo de produtos
		$valores = new model_valores();
		$pedidos = new model_pedidos(); 
		$fretes = new model_fretes(); 

		//altera sessao
		$altera_sessao = $this->get('altera_sessao');
		if($altera_sessao){
			$novasessao = $this->gera_codigo();
			$this->_sessao = $novasessao;
			$_SESSION[$this->_sessao_principal]['loja_cod_sessao'] = $novasessao;
		}

		$cadastro = new model_cadastro();
		$dados['data_dados'] = $cadastro->dados_usuario($this->_cod_usuario);

		$estados_cidades = new model_estados_cidades();
		$dados['estados'] = $estados_cidades->lista_estados($dados['data_dados']->estado);


		$codigo = $this->get('codigo');

		$dados['data_pedido'] = $pedidos->carrega($codigo);
		
		// se foi criado o pedido
		if($dados['data_pedido']->id){

			// zera mensagens nao limpa_mensagens_n_lidas
			$pedidos->limpa_mensagens_n_lidas($codigo);
			$dados['mensagens'] = $pedidos->lista_mensagens($codigo);

			$status = $dados['data_pedido']->status;	 		
			$dados['status'] = $pedidos->status($status);

			$dados['forma_pagamento'] = $pedidos->forma_pagamento_dados($dados['data_pedido']->forma_pagamento);

			$dados['produtos'] = $pedidos->produtos($codigo);

			$dados['valor_desconto_cupom_tratado'] = $valores->trata_valor($dados['data_pedido']->valor_produtos_desc);
			$dados['valor_frete_tratado'] = $valores->trata_valor($dados['data_pedido']->frete_valor);
			$dados['valor_total_pedido_tratado'] = $valores->trata_valor($dados['data_pedido']->valor_total);			
			$dados['valor_total_pedido_paypal'] = $valores->trata_valor_banco($dados['valor_total_pedido_tratado']);

			if($dados['data_pedido']->frete_balcao){

				$dados['envio'] = $fretes->carrega_balcao($dados['data_pedido']->frete_balcao);
				$dados['envio_titulo'] = 'Retirada em balcão - '.$dados['envio']->titulo;

			} else {

				if($dados['data_pedido']->frete == 99999){
					$dados['envio_titulo'] = "Frete Gratis";
				} else {
					$dados['envio'] = $fretes->carrega($dados['data_pedido']->frete);
					$dados['envio_titulo'] = $dados['envio']->titulo;
				}

			}
			// paypal
			if($dados['data_pedido']->forma_pagamento == 4){
			}
			// botao e detalhes 

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM produto_detalhes WHERE id='1' ");
			$data_detalhes = $coisas->fetch_object();

			$conexao = new mysql();
			$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
			$data = $coisas->fetch_object();

			if(isset($data->codigo)){

				$botao_style = "
				<style>
				a.botao_".$data->codigo.", .botao_".$data->codigo."{
					border:".$data->borda."px solid ".$data->cor_borda." !important; 
				
					border-radius:".$data->borda_radius."px !important; 
					color:".$data->cor_texto." !important;
					cursor:pointer !important;
					padding-top:".$data->padding_top."px !important;
					padding-left:".$data->padding_left."px !important;
					padding-right:".$data->padding_right."px !important;
					padding-bottom:".$data->padding_bottom."px !important;
					";

					if($data->imagem_fundo){

						$botao_style .= "
						background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
						background-repeat:no-repeat !important; 
						background-size:cover !important; 
						background-position:center !important;
						";

					}

					$botao_style .= "
				}
				a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
					
					
					border-radius:".$data->borda_radius."px !important;
					color:".$data->cor_sel_texto." !important;
				}

				</style>
				";

				$botao_css = "botao_padrao botao_".$data->codigo;

			} else {
				$botao_css = "";
				$botao_style = "";
			}

			$dados['botao_css'] = $botao_css;
			$dados['botao_style'] = $botao_style;

			// echo '<pre>';print_r($dados);exit;
	        //carrega view e envia dados para a tela
			$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
			$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
			$this->view('pedido', $dados);

		} else {
			$this->msg('Pedido não encontrado!');
			$this->volta(1);
		}

	}

	public function enviar_comprovante_pg(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		$pedido = $this->post('pedido');
		$pedido_id = $this->post('pedido_id');
		$mensagem = $this->post('mensagem');

 		// validacoes
		$this->valida($pedido);

 		// arquivo
		$nome_arquivo = "";

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		if($tmp_name){

			// images
         	//  'png' => 'image/png',
            //'jpe' => 'image/jpeg',
            //'jpeg' => 'image/jpeg',
            //'jpg' => 'image/jpeg',
            //'gif' => 'image/gif',
            //'bmp' => 'image/bmp',

			$tipo_arquivo = mime_content_type($tmp_name);

			if($tipo_arquivo != 'image/png'){
				if($tipo_arquivo != 'image/jpeg'){
					if($tipo_arquivo != 'image/bmp'){
						if($tipo_arquivo != 'image/gif'){
							if($tipo_arquivo != 'application/pdf'){
								$this->msg('Não foi possível anexar o arquivo, verifique o formato do seu arquivo!');
								$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$pedido);
							}
						}
					}
				}
			}

	 		//carrega model de gestao de imagens
			$arquivo = new model_arquivos_imagens();

			//// Definicao de Diretorios / 
			$diretorio = "arquivos/anexos_pedidos/$pedido/";
			// verifica se exite a pasta
			if(!is_dir($diretorio)) {
				mkdir($diretorio);
			}

			if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

				$nome_original = $_FILES['arquivo']['name'];
				$nome_arquivo  = $this->gera_codigo().'.'.$arquivo->extensao($nome_original);				
				$destino = $diretorio.$nome_arquivo;

				if(!copy($tmp_name, $destino)){ 
					$this->msg('Não foi possível anexar o arquivo, verifique o tamanho e o nome do seu arquivo!');
					$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$pedido);
				}
			}

			$db = new mysql();
			$db->alterar("pedido_loja", array(
				"comprovante"=>"$nome_arquivo"
			), " codigo='$pedido' ");

		} else {
			$this->msg('Selecione um comprovante válido para continuar!');
			$this->volta(1);
		}

		$pedidos = new model_pedidos();
		$data_pedido = $pedidos->carrega($pedido);
		$pedido_id = $data_pedido->id;

		/* mensagem */
		$msg = "Você recebeu uma nova mensagem no pedido $pedido_id <br> acesse o Painel administrativo da sua loja virtual para responder!";

		$array_lista = array();
		$n = 0;
		$db = new mysql();
		$exec = $db->executar("select * from contato ");
		while($data = $exec->fetch_object()){
			$array_lista[$n] = $data->email;
			$n++;
		}

		// envia o email
		$envio = new model_envio();
		$retorno = $envio->enviar("Nova interação no Pedido $pedido_id", $msg, $array_lista);

		$this->msg("Enviado com sucesso!");
		$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$pedido);
	}

	public function pedido_envia_msg(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$pedido = $this->post('pedido');
		$pedido_id = $this->post('pedido_id');
		$mensagem = $this->post('mensagem');

 		// validacoes
		$this->valida($pedido);
		if(!$mensagem){
		//	$this->msg('Digite uma mensagem para continuar...');
		//	$this->volta(1);
		}

 		// arquivo
		$nome_arquivo = "";

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		if($tmp_name){

			// images
         	//  'png' => 'image/png',
            //'jpe' => 'image/jpeg',
            //'jpeg' => 'image/jpeg',
            //'jpg' => 'image/jpeg',
            //'gif' => 'image/gif',
            //'bmp' => 'image/bmp',

			$tipo_arquivo = mime_content_type($tmp_name);

			if($tipo_arquivo != 'image/png'){
				if($tipo_arquivo != 'image/jpeg'){
					if($tipo_arquivo != 'image/bmp'){
						if($tipo_arquivo != 'image/gif'){
							if($tipo_arquivo != 'application/pdf'){
								$this->msg('Não foi possível anexar o arquivo, verifique o formato do seu arquivo!');
								$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$pedido);
							}
						}
					}
				}
			}

	 		//carrega model de gestao de imagens
			$arquivo = new model_arquivos_imagens();

			//// Definicao de Diretorios / 
			$diretorio = "arquivos/anexos_pedidos/$pedido/";
			// verifica se exite a pasta
			if(!is_dir($diretorio)) {
				mkdir($diretorio);
			}

			if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

				$nome_original = $_FILES['arquivo']['name'];
				$nome_arquivo  = $this->gera_codigo().'.'.$arquivo->extensao($nome_original);				
				$destino = $diretorio.$nome_arquivo;

				if(!copy($tmp_name, $destino)){ 
					$this->msg('Não foi possível anexar o arquivo, verifique o tamanho e o nome do seu arquivo!');
					$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$pedido);
				}
			}
		}

		$time = time();

		$db = new mysql();
		$db->inserir("pedido_loja_mensagens", array(
			"pedido"=>"$pedido",
			"usuario"=>$this->_cod_usuario,
			"data"=>$time,
			"msg"=>"$mensagem",
			"anexo"=>"$nome_arquivo",
			"lida"=>0
		));

		$pedidos = new model_pedidos();
		$data_pedido = $pedidos->carrega($pedido);
		$pedido_id = $data_pedido->id;

		/* mensagem */
		$msg = "Você recebeu uma nova mensagem no pedido $pedido_id <br> acesse o Painel administrativo da sua loja virtual para responder!";

		$array_lista = array();
		$n = 0;
		$db = new mysql();
		$exec = $db->executar("select * from contato ");
		while($data = $exec->fetch_object()){
			$array_lista[$n] = $data->email;
			$n++;
		}

		// envia o email
		$envio = new model_envio();
		$retorno = $envio->enviar("Nova mensagem no Pedido $pedido_id", $msg, $array_lista);

		$this->msg("Mensagem enviada com sucesso!");
		$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$pedido);
	}

	public function cancelar_pedido(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		$pedido = $this->get('codigo');

		if($pedido){

			$produtos = new model_produtos(); 
			$pedidos = new model_pedidos(); 
			$data_pedido = $pedidos->carrega($pedido);

			if($data_pedido->id){

				if($data_pedido->cadastro == $this->_cod_usuario){	

					if( $data_pedido->status <= 3 ){

						function lista_carrinho($codigo){

							$valores = new model_valores();
							$produtos = new model_produtos();

							$lista = array();
							$i = 0;

							$conexao = new mysql();
							$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$codigo' ");
							$linha_carrinho = $coisas_carrinho->num_rows;

							if($linha_carrinho != 0){
								while($data_carrinho = $coisas_carrinho->fetch_object()){

									$produto_nome = "<div>$data_carrinho->produto_titulo</div>";

									if($data_carrinho->tamanho_titulo){ $produto_nome .= "<div>Tamanho: $data_carrinho->tamanho_titulo</div>"; }
									if($data_carrinho->cor_titulo){ $produto_nome .= "<div>Cor: $data_carrinho->cor_titulo</div>"; }
									if($data_carrinho->variacao_titulo){ $produto_nome .= "<div>Variação: $data_carrinho->variacao_titulo</div>"; }

									$lista[$i]['id'] = $data_carrinho->id;
									$lista[$i]['produto'] = $data_carrinho->produto;
									$lista[$i]['tamanho'] = $data_carrinho->tamanho;
									$lista[$i]['cor'] = $data_carrinho->cor;
									$lista[$i]['variacao'] = $data_carrinho->variacao;

									$lista[$i]['produto_nome'] = $produto_nome;
									$lista[$i]['quantidade'] = $data_carrinho->quantidade;
									$lista[$i]['valor_total'] = $data_carrinho->valor_total;
									$lista[$i]['valor_total_tratado'] = $valores->trata_valor($data_carrinho->valor_total);
									$lista[$i]['total_calculo'] = $data_carrinho->valor_total * $data_carrinho->quantidade;
									$lista[$i]['total_calculo_tratado'] = $valores->trata_valor($lista[$i]['total_calculo']);
									$lista[$i]['reserva_estoque'] = $data_carrinho->reserva_estoque;

									if(!isset($imagem[0]['imagem_g'])){
										$lista[$i]['produto_imagem'] = LAYOUT."img/semimagem.png";
									} else {
										$lista[$i]['produto_imagem'] = $imagem[0]['imagem_g'];
									}

									$i++;
								}
							}

							return $lista;
						}

						foreach (lista_carrinho($pedido) as $key => $value) {

							// lista itens
							if($value['reserva_estoque'] == 1){

								$descricao = "Registro Automatico - Adicionado ".$value['quantidade']." item(s) - Cancelamento Pedido ".$data_pedido->id." ";

								// volta estoque
								$produtos->add_estoque_auto($value['produto'], $value['tamanho'], $value['cor'], $value['variacao'], $value['quantidade'], $descricao);

								// marca como processado
								$db = new mysql();
								$db->alterar("pedido_loja_carrinho", array(
									"reserva_estoque"=>"0"
								), " id='".$value['id']."' ");

							}
						}

						$db = new mysql();
						$db->alterar("pedido_loja", array(
							"status"=>"7"
						), " codigo='".$pedido."' ");

						$this->msg("Pedido cancelado com sucesso!");
					}
				}
			}


		}


		$this->irpara(DOMINIO.$this->_controller.'/pedidos_detalhes/codigo/'.$pedido);
	}

	/////////  END PAGAMENTO /////////

	public function entrar(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
		//carrega view e envia dados para a tela
		$this->view('entrar', $dados);
	}

	public function login(){
		
		$time = time();
		$ip = $_SERVER["REMOTE_ADDR"];
		$prefixosessao = $this->_sessao.'_';
		
		$email = $this->post('login_usuario');
		$senha = $this->post('login_senha');

		if($email AND $senha) {

			$conexao = new mysql();
			$coisas_dados = $conexao->Executar("SELECT * FROM cadastro WHERE fisica_cpf='$email' ");
			$data_dados = $coisas_dados->fetch_object();

			if($coisas_dados->num_rows == 1){

				if( password_verify($senha, $data_dados->senha) ){

					//carrega sessoes
					$_SESSION[$this->_sessao_principal]['loja_acesso'] = TOKEN1.$data_dados->codigo;
					$_SESSION[$this->_sessao_principal]['loja_cod_usuario'] = $data_dados->codigo;
					$_SESSION[$this->_sessao_principal]['loja_cod_sessao'] = $this->_sessao;

					if( empty($data_dados->endereco) OR empty($data_dados->cep) OR empty($data_dados->estado) OR empty($data_dados->cidade) ){

						$this->irpara(DOMINIO.$this->_controller.'/alterar_cadastro');

					} else {

						//confere se tem pedido  (se tiver salva usuario no pedido e renova sessao)
						$conexao = new mysql();
						$coisas_pedido = $conexao->Executar("SELECT * FROM pedido_loja WHERE codigo='".$this->_sessao."' ");
						$linhas = $coisas_pedido->num_rows;
						
						

						if($linhas == 1){
							$this->irpara(DOMINIO.$this->_controller.'/carrinho');
						} else {

							if($_SESSION['acesso_controller']){ 
								if($_SESSION['acesso_action']){ 
									$destino = DOMINIO.$_SESSION['acesso_controller'].'/'.$_SESSION['acesso_action'];
								} else {
									$destino = DOMINIO;
								}
							} else {
								$destino = DOMINIO;
							}

							$this->irpara($destino);
						}

					}				

				} else {

					echo "
					<div class='cadastro_msg_interna' style='padding-top:20px; text-align:center;' >E-mail ou senha incorreto(s)!</div>
					";
					exit;

				}

			} else {

				echo "
				<div class='cadastro_msg_interna' style='padding-top:20px; text-align:center;' >E-mail ou senha incorreto(s)!</div>
				";
				exit;

			}

		} else {
			echo "
			<div class='cadastro_msg_interna' style='padding-top:20px; text-align:center;' >Digite seu e-mail e sua senha para continuar!</div>
			";
			exit;
		}

	}

	public function logout(){

		$this->finaliza_sessao();
		$this->irpara(DOMINIO);
		exit;

	}

	public function recuperar_senha(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;

		$dados['primaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][0]['cor'];
		$dados['secundaria'] = $dados['layout_lista'][0]['coluna1']['conteudo']['cores']['detalhes'][1]['cor'];
		$this->view('recuperar_senha', $dados);
	}

	public function recuperar_senha_enviar(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$valida = new model_valida();
		$textos = new model_textos();

		$email = $this->post('email');

		if(!$valida->email($email)){
			echo "Digite o e-mail do cadastro corretamente";
			exit;
		}

		$captcha = $this->post('g-recaptcha-response');
		if(!$captcha){

			echo "Recaptcha inválido, tente novamente!";
			exit;

		} else {
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$key = recaptcha_secret;
			$url = 'https://www.google.com/recaptcha/api/siteverify';

			// RECAPTCH RESPONSE
			$recaptcha_response = file_get_contents($url.'?secret='.$key.'&response='.$captcha.'&remoteip='.$ip);
			$data = json_decode($recaptcha_response);

			if(isset($data->success) &&  $data->success === true) {

				//configuracoes
				$conexao = new mysql();
				$coisas_config = $conexao->Executar("select * from adm_config where id='1' ");
				$data_config = $coisas_config->fetch_object();

				//lista emails
				$conexao = new mysql();
				$coisas_cadastro = $conexao->Executar("select * from cadastro where email='$email' ");
				$linhas_cadastro = $coisas_cadastro->num_rows;

				if($linhas_cadastro == 1){

					$data_cadastro = $coisas_cadastro->fetch_object();

					$senha = rand(11111, 99999);

					$senha_tratada = password_hash($senha, PASSWORD_DEFAULT);

					$conexao = new mysql();
					$conexao->Executar("UPDATE cadastro SET senha='$senha_tratada' WHERE codigo='$data_cadastro->codigo' ");

					/* mensagem */
					$msg = "
					<div style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;'><p>".$textos->conteudo('146177966276191')."</p></div>
					<div style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;'><p><strong>Novo usuário:</strong> $email</p></div>
					<div style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;'><p><strong>Sua nova senha:</strong> $senha</p></div>
					<div style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;'><p></p></div>
					<div style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;'><p></p></div>
					<div style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;'><p>Este e-mail foi gerado automáticamente, por favor não responda.</p></div>
					";

					$envio = new model_envio();
					$retorno = $envio->enviar("Nova senha de acesso", $msg, array($email), '');

					if($retorno){
						echo "Recuperação enviada com sucesso! Confira seu e-mail!";
						exit;
					} else {
						echo "Ocorreu um erro ao enviar sua solicitação, tente novamente mais tarde!";
						exit;
					}

				} else {
					echo "Desculpe, Não encontramos cadastros vinculados a este e-mail!";
					exit;
				}

			} else {
				echo "Recaptcha inválido, tente novamente!";
				exit;
			}
		}
	}

	public function selecionar_balcao(){

		$dados = array();
		$dados['_base'] = $this->_base();

		$fretes = new model_fretes();

		$codigo = $this->get('codigo');
		if(!$codigo){
			$this->msg('Balcão inválido!');
			$this->irpara(DOMINIO."carrinho");
		}

		$valor_subtotal = $this->get('valor_subtotal');
		if(!$valor_subtotal){
			$this->msg('Forma de envio inválida!');
			$this->irpara(DOMINIO."carrinho");
		}

		//informaçoes do pedido
		$conexao = new mysql();
		$coisas_pedido = $conexao->Executar("SELECT * FROM pedido_loja WHERE codigo='".$this->_sessao."' ");
		$data_pedido = $coisas_pedido->fetch_object();

		$conexao = new mysql();
		$coisas_balcao = $conexao->Executar("SELECT * FROM balcoes WHERE codigo='".$codigo."' ");
		$data_balcao = $coisas_balcao->fetch_object();

		$titulo = $data_balcao->titulo;
		$valor_frete = $data_balcao->valor;

		if($titulo){

			//adiciona frete
			$conexao = new mysql();
			$conexao->alterar("pedido_loja", array(
				"frete"=>"",
				"frete_balcao"=>$codigo,
				"frete_titulo"=>$titulo,
				"frete_valor"=>$valor_frete,
				"valor_total"=>0,
				"status"=>0
			), " codigo='".$this->_sessao."' ");

			$this->irpara(DOMINIO.$this->_controller."/carrinho");

		} else {

			$this->msg('Balcão inválido!');
			$this->irpara(DOMINIO.$this->_controller."/carrinho");

		}

	}

	public function sitemap(){

		header("Content-Type: application/xml; charset=UTF-8");
		echo '<?xml version="1.0" encoding="UTF-8"?>';

		$hoje = date('Y-m-d');

		echo '

		<urlset
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

		<url>
		<loc>'.DOMINIO.'</loc>
		<lastmod>'.$hoje.'</lastmod>
		</url>

		';

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT chave FROM layout_paginas WHERE id!=1 ORDER BY id ASC");
		while($data = $coisas->fetch_object()){

			$destino = DOMINIO.$data->chave;

			echo '
			<url>
			<loc>'.$destino.'</loc>
			<lastmod>'.$hoje.'</lastmod>
			<priority>0.9</priority> 
			</url>
			';

		}


		// noticias 
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT amigavel, data FROM noticia ORDER by data desc");
		while($data = $coisas->fetch_object()){

			$destino = DOMINIO."index/leitura/id/".$data->amigavel;
			$dia = date('Y-m-d', $data->data);

			echo '
			<url>
			<loc>'.$destino.'</loc>
			<lastmod>'.$dia.'</lastmod>
			<priority>0.8</priority> 
			</url>
			';

		}


		// produtos
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT id FROM produto WHERE esconder='0' ORDER by id desc");
		while($data = $coisas->fetch_object()){

			$destino = DOMINIO."index/produto/id/".$data->id."/"; 

			echo '
			<url>
			<loc>'.$destino.'</loc>
			<lastmod>'.$hoje.'</lastmod>
			<priority>0.9</priority> 
			</url>
			';

		}


		echo '
		</urlset>
		';

	}

	public function pagamento_paypal(){

		$codigo = $this->get('codigo');
		$id_transacao = $this->get('id');
		$paymentid = $this->get('paymentid');
		$payerid = $this->get('payerid');

		$pedidos = new model_pedidos();
		$data_pedido = $pedidos->carrega($codigo);

		// se foi criado o pedido
		if($data_pedido->id AND $id_transacao){

			if( ($data_pedido->forma_pagamento == 4) AND ($data_pedido->status <= 3) ){

				$conexao = new mysql();
				$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='4' ");
				$data_pagamento = $coisas_pagamento->fetch_object();

				$PAYPAL_SANDBOX = false;

				$paypalURL = $PAYPAL_SANDBOX?'https://api.sandbox.paypal.com/v1/':'https://api.paypal.com/v1/';

				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, $paypalURL.'oauth2/token'); 
				curl_setopt($ch, CURLOPT_HEADER, false); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
				curl_setopt($ch, CURLOPT_POST, true); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
				curl_setopt($ch, CURLOPT_USERPWD, $data_pagamento->paypal_clienteid.":".$data_pagamento->paypal_clientesecret); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); 
				$response = curl_exec($ch); 
				curl_close($ch); 

				if(empty($response)){

					echo "erro"; exit;

				} else { 

					$jsonData = json_decode($response); 

					// print_r($jsonData);

					$curl = curl_init($paypalURL.'payments/payment/'.$paymentid); 
					curl_setopt($curl, CURLOPT_POST, false); 
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
					curl_setopt($curl, CURLOPT_HEADER, false); 
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
					curl_setopt($curl, CURLOPT_HTTPHEADER, array( 
						'Authorization: Bearer ' . $jsonData->access_token, 
						'Accept: application/json', 
						'Content-Type: application/xml' 
					)); 
					$response = curl_exec($curl); 
					curl_close($curl); 

					$paymentCheck = json_decode($response); 

					if($paymentCheck && $paymentCheck->state == 'approved'){ 

						$db = new mysql();
						$db->alterar("pedido_loja",  array(
							"status"=>4
						), " codigo='".$data_pedido->id."' AND cadastro='".$this->_cod_usuario."' ");

					}

					//print_r($result);
				}
			}

			$this->irpara(DOMINIO.$this->_controller."/pedidos_detalhes/codigo/".$codigo);
		}

		$this->irpara(DOMINIO);
	}

	public function rastreamento_detalhes(){

		$refe = $this->post('rastreio_codigo');

		if($refe){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM rastreamento_objetos WHERE ref='$refe' ");

			if($coisas->num_rows == 0){

				echo "<div style='text-align:center; padding:10px;'>Nenhum item encontrado para essa consulta!</div>";
				exit;

			} else {

				$dados['data'] = $coisas->fetch_object();

				$statusob = "";

				if($dados['data']->status == 0){ $statusob = "Enviado"; }
				if($dados['data']->status == 1){ $statusob = "Em Trânsito"; }
				if($dados['data']->status == 2){ $statusob = "Extraviado"; }
				if($dados['data']->status == 3){ $statusob = "Recusado"; }
				if($dados['data']->status == 4){ $statusob = "Endereço não localizado"; }
				if($dados['data']->status == 5){ $statusob = "Entregue"; }

				$dados['status'] = $statusob;


				$itens = array();
				$n = 0;

				$atualizacao = date('d/m/Y', $dados['data']->data);

				$conexao = new mysql();
				$coisas_itens = $conexao->Executar("SELECT * FROM rastreamento_objetos_itens WHERE codigo='".$dados['data']->codigo."' ORDER by id asc ");
				while($data_itens = $coisas_itens->fetch_object()){

					$atualizacao = date('d/m/Y', $data_itens->data);						
					$itens[$n]['dia'] = date('d/m/Y', $data_itens->data);
					$itens[$n]['descricao'] = nl2br($data_itens->descricao);

					$n++;
				}

				$dados['atualizacao'] = $atualizacao;
				$dados['itens'] = $itens;


				$this->view('conteudo_rastreamento.detalhes', $dados);
			}

		} else {			

			echo "<div style='text-align:center; padding:10px;'>Informe o codigo para continuar!</div>";
			exit;

		}

	}

	public function veiculo_detalhes(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$codigo = $this->get('id');

		if(!$codigo){
			$this->irpara(DOMINIO);
		}


		$conexao = new mysql();
		$coisas_garagemm = $conexao->Executar("SELECT * FROM garagem where codigo='$codigo' ");
		$dados['data'] = $coisas_garagemm->fetch_object();		

		if( !$dados['data']->id ){
			$this->irpara(DOMINIO);
		}

		$garagem = new model_garagem();
		$dados['imagens'] = $garagem->imagens($dados['data']->codigo);
		if(isset($dados['imagens'][0]['imagem_g'])){
			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
		}

		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		$dados['similares'] = $garagem->similares($dados['data']->codigo, $dados['data']->categoria_cod);

		$dados['opcionais'] = $garagem->opcoes($dados['data']->codigo);

		$conexao = new mysql();
		$coisas_garagem = $conexao->Executar("SELECT * FROM garagem_detalhes where id='1' ");
		$dados['data_detalhes'] = $coisas_garagem->fetch_object();
		
		$layoutttt = new model_layout();
		$dados['cores'] = $layoutttt->lista_cores('garagem_detalhes')['lista'];
		$dados['cores_detalhes'] = $layoutttt->lista_cores('garagem_detalhes');
		
		//pega imagens 

		$dados['imagem_principal_largura'] = "";
		$dados['imagem_principal_altura'] = "";
		$dados['imagem_principal'] = "";
		if(isset($dados['imagens'][0]['imagem_g'])){

			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
			$dados['imagem_principal_sem_ssl'] = $string = str_replace("https://", "http://", $dados['imagens'][0]['imagem_g']);

			$imagem_principal = "arquivos/img_veiculos_g/".$dados['data']->codigo."/".$dados['imagens'][0]['imagem'];
			list($largura, $altura) = getimagesize($imagem_principal);
			if($largura){
				$dados['imagem_principal_largura'] = $largura;
			}
			if($altura){
				$dados['imagem_principal_altura'] = $altura;
			}

		}	
		

		//$dados['endereco_postagem'] = DOMINIO.$this->_controller."/veiculo_detalhes/id/".$dados['data']->codigo;
		$dados['endereco_postagem'] = '';
		//$dados['endereco_postagem_sem_ssl'] = $string = str_replace("https://", "http://", $dados['endereco_postagem']);
		$dados['endereco_postagem_sem_ssl'] = '';


		$banners = new model_banners();
		$dados['banners_topoo'] = $banners->lista('163559022182260');


		$this->view('veiculo.detalhes', $dados);
	}

	public function veiculo_detalhes2(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$codigo = $this->get('id');

		if(!$codigo){
			$this->irpara(DOMINIO);
		}


		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM garagem where codigo='$codigo' ");
		$dados['data'] = $coisas_imovel->fetch_object();

		if( !$dados['data']->id ){
			$this->irpara(DOMINIO);
		}

		$garagem = new model_garagem();
		$dados['imagens'] = $garagem->imagens($dados['data']->codigo);
		if(isset($dados['imagens'][0]['imagem_g'])){
			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
		}

		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		$dados['similares'] = $garagem->similares($dados['data']->codigo, $dados['data']->categoria_cod);

		$dados['opcoes'] = $garagem->opcoes($dados['data']->codigo);

		$conexao = new mysql();
		$coisas_garagem = $conexao->Executar("SELECT * FROM garagem_detalhes where id='1' ");
		$dados['data_detalhes'] = $coisas_garagem->fetch_object();

		$layoutttt = new model_layout();
		$dados['cores_gara'] = $layoutttt->lista_cores('garagem_detalhes')['lista'];
		$dados['cores_detalhes'] = $layoutttt->lista_cores('garagem_detalhes');

		//pega imagens 

		$dados['imagem_principal_largura'] = "";
		$dados['imagem_principal_altura'] = "";
		$dados['imagem_principal'] = "";
		if(isset($dados['imagens'][0]['imagem_g'])){

			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
			$dados['imagem_principal_sem_ssl'] = $string = str_replace("https://", "http://", $dados['imagens'][0]['imagem_g']);

			$imagem_principal = "arquivos/img_veiculos_g/".$dados['data']->codigo."/".$dados['imagens'][0]['imagem'];
			list($largura, $altura) = getimagesize($imagem_principal);
			if($largura){
				$dados['imagem_principal_largura'] = $largura;
			}
			if($altura){
				$dados['imagem_principal_altura'] = $altura;
			}

		}	


		$dados['endereco_postagem'] = DOMINIO.$this->_controller."/veiculo_detalhes2/id/".$dados['data']->codigo;
		$dados['endereco_postagem_sem_ssl'] = $string = str_replace("https://", "http://", $dados['endereco_postagem']);


		$this->view('veiculo.detalhes2', $dados);
	}

	public function imoveis_detalhes(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$codigo = $this->get('id');

		if(!$codigo){
			$this->irpara(DOMINIO);
		}


		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM imoveis where codigo='$codigo' ");
		$dados['data'] = $coisas_imovel->fetch_object();

		if( !$dados['data']->id ){
			$this->irpara(DOMINIO);
		}

		$imoveis = new model_imoveis();
		$dados['imagens'] = $imoveis->imagens($dados['data']->codigo);
		if(isset($dados['imagens'][0]['imagem_g'])){
			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
		}

		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		$dados['iptu'] = $valores->trata_valor($dados['data']->iptu);
		$dados['condominio'] = $valores->trata_valor($dados['data']->condominio);	
		$dados['similares'] = $imoveis->similares($dados['data']->codigo, $dados['data']->categoria_id, $dados['data']->tipo_id);

		$dados['opcoes'] = $imoveis->opcoes($dados['data']->codigo);



		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM imoveis_detalhes where id='1' ");
		$dados['data_detalhes'] = $coisas_imovel->fetch_object();

		$formatodapaginadetalhes = $dados['data_detalhes']->formato_pg;

		$layoutttt = new model_layout();
		$dados['cores_imo'] = $layoutttt->lista_cores('imoveis_detalhes'.$formatodapaginadetalhes)['lista'];



		$dados['endereco_imovel_sem_ssl'] = DOMINIO.$this->_controller.'/imoveis_detalhes/id/'.$dados['data']->codigo;

		//pega imagens 

		$dados['imagem_principal_largura'] = "";
		$dados['imagem_principal_altura'] = "";
		$dados['imagem_principal'] = "";
		if(isset($dados['imagens'][0]['imagem_g'])){

			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
			$dados['imagem_principal_sem_ssl'] = $string = str_replace("https://", "http://", $dados['imagens'][0]['imagem_g']);

			$imagem_principal = "arquivos/img_imoveis_g/".$dados['data']->codigo."/".$dados['imagens'][0]['imagem'];
			list($largura, $altura) = getimagesize($imagem_principal);
			if($largura){
				$dados['imagem_principal_largura'] = $largura;
			}
			if($altura){
				$dados['imagem_principal_altura'] = $altura;
			}

		}	

		// favoritos
		$conexao = new mysql();
		$coisas_fav = $conexao->Executar("SELECT * FROM imoveis_favoritos where codigo='".$dados['data']->codigo."' AND sessao='".$this->_sessao."' ");
		if($coisas_fav->num_rows == 0){
			$dados['favorito'] = 2;
		} else {
			$dados['favorito'] = 1;
		}

		$dados['endereco_postagem'] = DOMINIO.$this->_controller."/imoveis_detalhes/id/".$dados['data']->codigo;
		$dados['endereco_postagem_sem_ssl'] = $string = str_replace("https://", "http://", $dados['endereco_postagem']);


		if($formatodapaginadetalhes == 2){
			$this->view('imoveis.detalhes2', $dados);
		} else {
			$this->view('imoveis.detalhes', $dados);
		}
	}

	public function imoveis_agendar(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$id = $this->get('id');
		if(!$id){
			$this->irpara(DOMINIO."erro");
		}

		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM imoveis where id='$id' ");
		$dados['data'] = $coisas_imovel->fetch_object();

		//carrega view e envia dados para a tela
		$this->view('imoveis.agendar', $dados);
	}

	public function imoveis_agendar_enviar(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;


		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		$imovel = $this->post('imovel');
		$captcha = $this->post('g-recaptcha-response');

		if($nome AND $email AND $imovel){

			$ip = $_SERVER['REMOTE_ADDR'];
			$key = recaptcha_secret;
			$url = 'https://www.google.com/recaptcha/api/siteverify';

			$recaptcha_response = file_get_contents($url.'?secret='.$key.'&response='.$captcha.'&remoteip='.$ip);
			$data = json_decode($recaptcha_response);
			if(isset($data->success) &&  $data->success === true) {

				$msg =  "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Agendar Visita</strong></p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Nome:</strong> ".$nome."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>E-mail:</strong> ".$email."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Telefone:</strong> ".$fone."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Imóvel:</strong> ".$imovel."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Mensagem:</strong> ".$mensagem."</p>";

				$db = new mysql();
				$exec_det = $db->executar("SELECT * FROM imoveis_detalhes where id='1' ");
				$data_det = $exec_det->fetch_object();

				$envio = new model_envio();

				$lista_envio = array();
				$lista_envio[0] = $data_det->destino_form;

				$retorno = $envio->enviar("Desejo Agendar Visita", $msg, $lista_envio, $email);

				$this->msg($retorno['msg']);
				$this->volta(1);

			} else {
				$this->msg('Erro na validação do captcha, tente novamente!');
				$this->volta(1);
			} 

		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}

	}

	public function imovel_desejo(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$id = $this->get('id');
		if(!$id){
			$this->irpara(DOMINIO."erro");
		}

		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM imoveis where id='$id' ");
		$dados['data'] = $coisas_imovel->fetch_object();

		//carrega view e envia dados para a tela
		$this->view('imoveis.desejo', $dados);
	}

	public function desejo_enviar(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		$imovel = $this->post('imovel');
		$captcha = $this->post('g-recaptcha-response');

		if($nome AND $email AND $imovel){

			$ip = $_SERVER['REMOTE_ADDR'];
			$key = recaptcha_secret;
			$url = 'https://www.google.com/recaptcha/api/siteverify';

			$recaptcha_response = file_get_contents($url.'?secret='.$key.'&response='.$captcha.'&remoteip='.$ip);
			$data = json_decode($recaptcha_response);
			if(isset($data->success) &&  $data->success === true) {

				$msg =  "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Desejo receber mais informações</strong></p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Nome:</strong> ".$nome."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>E-mail:</strong> ".$email."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Telefone:</strong> ".$fone."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Imóvel:</strong> ".$imovel."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Mensagem:</strong> ".$mensagem."</p>";

				$db = new mysql();
				$exec_det = $db->executar("SELECT * FROM imoveis_detalhes where id='1' ");
				$data_det = $exec_det->fetch_object();

				$envio = new model_envio();

				$lista_envio = array();
				$lista_envio[0] = $data_det->destino_form;

				$retorno = $envio->enviar("Desejo receber novidades", $msg, $lista_envio, $email);

				$this->msg($retorno['msg']);
				$this->volta(1);

			} else {
				$this->msg('Erro na validação do captcha, tente novamente!');
				$this->volta(1);
			} 

		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}

	}

	public function desejo_enviar2(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$nome = $this->post('nome');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		$imovel = $this->post('imovel');

		if($nome AND $fone AND $imovel){

			$msg =  "<p><strong>Desejo receber mais informações</strong></p>";
			$msg .= "<p><strong>Nome:</strong> ".$nome."</p>";
			$msg .= "<p><strong>Telefone:</strong> ".$fone."</p>";
			$msg .= "<p><strong>Imóvel:</strong> ".$imovel."</p>";
			$msg .= "<p><strong>Mensagem:</strong> ".$mensagem."</p>";

			$db = new mysql();
			$exec_det = $db->executar("SELECT * FROM imoveis_detalhes where id='1' ");
			$data_det = $exec_det->fetch_object();

			$envio = new model_envio();

			$lista_envio = array();
			$lista_envio[0] = $data_det->destino_form;

			$retorno = $envio->enviar("Desejo receber novidades", $msg, $lista_envio);

			echo $retorno['msg'];
			exit;

		} else {
			echo "Preencha todos os campos para continuar";
			exit;
		}

	}	

	public function desejo_enviar_cla(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$nome = $this->post('nome');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		$anuncio = $this->post('anuncio');

		if($nome AND $fone AND $anuncio){

			$msg =  "<p><strong>Desejo receber mais informações</strong></p>";
			$msg .= "<p><strong>Nome:</strong> ".$nome."</p>";
			$msg .= "<p><strong>Telefone:</strong> ".$fone."</p>";
			$msg .= "<p><strong>Anúncio:</strong> ".$anuncio."</p>";
			$msg .= "<p><strong>Mensagem:</strong> ".$mensagem."</p>";

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM classificados where codigo='$anuncio' ");
			$data = $coisas->fetch_object();

			if($data->cadastro){

				$cadastro = new model_cadastro();
				$data_cad = $cadastro->dados_usuario($data->cadastro);	
				if($data_cad->email){
					$lista_envio = array();
					$lista_envio[0] = $data_cad->email;
				} else {
					echo "Este anúncio não pode receber mensagens";
					exit;
				}

			} else {
				echo "Este anúncio não pode receber mensagens";
				exit;
			}


			$envio = new model_envio();
			$retorno = $envio->enviar("Desejo receber novidades", $msg, $lista_envio);

			echo $retorno['msg'];
			exit;

		} else {
			echo "Preencha todos os campos para continuar";
			exit;
		}

	}	

	public function imoveis_proposta(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$id = $this->get('id');
		if(!$id){
			$this->irpara(DOMINIO."erro");
		}

		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM imoveis where id='$id' ");
		$dados['data'] = $coisas_imovel->fetch_object();

		//carrega view e envia dados para a tela
		$this->view('imoveis.proposta', $dados);
	}

	public function imoveis_proposta_enviar(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		$imovel = $this->post('imovel');
		$captcha = $this->post('g-recaptcha-response');

		if($nome AND $email AND $imovel){

			$ip = $_SERVER['REMOTE_ADDR'];
			$key = recaptcha_secret;
			$url = 'https://www.google.com/recaptcha/api/siteverify';

			$recaptcha_response = file_get_contents($url.'?secret='.$key.'&response='.$captcha.'&remoteip='.$ip);
			$data = json_decode($recaptcha_response);
			if(isset($data->success) &&  $data->success === true) {

				$msg =  "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Proposta</strong></p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Nome:</strong> ".$nome."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>E-mail:</strong> ".$email."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Telefone:</strong> ".$fone."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Imóvel:</strong> ".$imovel."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Mensagem:</strong> ".$mensagem."</p>";

				$db = new mysql();
				$exec_det = $db->executar("SELECT * FROM imoveis_detalhes where id='1' ");
				$data_det = $exec_det->fetch_object();

				$envio = new model_envio();

				$lista_envio = array();
				$lista_envio[0] = $data_det->destino_form;

				$retorno = $envio->enviar("Proposta Imovel", $msg, $lista_envio, $email);

				$this->msg($retorno['msg']);
				$this->volta(1);

			} else {
				$this->msg('Erro na validação do captcha, tente novamente!');
				$this->volta(1);
			} 

		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}

	}

	public function ligamospravc(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		//carrega view e envia dados para a tela
		$this->view('imoveis.ligamospravc', $dados);
	}

	public function ligamospravc_enviar(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$nome = $this->post('nome');
		$hora = $this->post('hora');
		$fone = $this->post('fone');
		$captcha = $this->post('g-recaptcha-response');

		if($nome AND $hora AND $fone){

			$ip = $_SERVER['REMOTE_ADDR'];
			$key = recaptcha_secret;
			$url = 'https://www.google.com/recaptcha/api/siteverify';

			$recaptcha_response = file_get_contents($url.'?secret='.$key.'&response='.$captcha.'&remoteip='.$ip);
			$data = json_decode($recaptcha_response);
			if(isset($data->success) &&  $data->success === true) {

				$msg =  "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Ligue me</strong></p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Nome:</strong> ".$nome."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Horário:</strong> ".$hora."</p>";
				$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Telefone:</strong> ".$fone."</p>";  

				$db = new mysql();
				$exec_det = $db->executar("SELECT * FROM imoveis_detalhes where id='1' ");
				$data_det = $exec_det->fetch_object();

				$envio = new model_envio();

				$lista_envio = array();
				$lista_envio[0] = $data_det->destino_form;

				$retorno = $envio->enviar("Ligue-me", $msg, $lista_envio);

				$this->msg($retorno['msg']);
				$this->volta(1);

			} else {
				$this->msg('Erro na validação do captcha, tente novamente!');
				$this->volta(1);
			} 

		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}

	}

	public function carrega_bairros(){

		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');
		$bairro_nome = $this->post('bairro_nome');

		if($cidade){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
			$data_cid = $exec->fetch_object();

			echo "
			<select class='select2' name='bairro' >
			<option value='0' selected='' >Bairro</option>
			";

			$db = new mysql();
			$exec = $db->executar("SELECT codigo, bairro FROM imoveis_bairros WHERE cidade='$data_cid->cidade' AND estado='$data_cid->estado' order by bairro asc");
			while($data = $exec->fetch_object()) {

				$selected = "";
				if($bairro == $data->codigo){
					$selected = "selected=''";
				}
				if($bairro_nome == $data->bairro){
					$selected = "selected=''";
				}
				
				echo "<option value='".$data->codigo."' $selected >".$data->bairro."</option>";
			}

			echo "
			</select>
			";

		} else {

			echo "
			<select class='select2' name='bairro' >
			<option value='0' selected >Bairro</option>
			</select>
			"; 

		}

		echo "
		<script>
		$('.select2').select2();
		</script>
		";

	}

	public function carrega_bairros_cla(){

		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');

		if($cidade){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM classificados_cidades WHERE codigo='$cidade' ");
			$data_cid = $exec->fetch_object();

			echo "
			<select class='select2' name='bairro' >
			<option value='0' selected='' >Bairro</option>
			";

			$db = new mysql();
			$exec = $db->executar("SELECT codigo, bairro FROM classificados_bairros WHERE cidade='$data_cid->cidade' AND estado='$data_cid->estado' order by bairro asc");
			while($data = $exec->fetch_object()) {

				if($bairro == $data->codigo){
					$selected = "selected=''";
				} else {
					$selected = "";
				}

				echo "<option value='".$data->codigo."' $selected >".$data->bairro."</option>";
			}

			echo "
			</select>
			";

		} else {

			echo "
			<select class='select2' name='bairro' >
			<option value='0' selected >Bairro</option>
			</select>
			"; 

		}

		echo "
		<script>
		$('.select2').select2();
		</script>
		";

	}

	public function imoveis_busca_simp(){

		$conteudo_id = $this->post('grupo_pagina');

		if($conteudo_id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imoveis_grupos WHERE id='$conteudo_id' ");
			$data_destino = $exec->fetch_object();

			if($data_destino->busca_pagina){

				$categoria = $this->post('categoria');
				$tipo = $this->post('tipo');
				$cidade = $this->post('cidade');
				$bairro = $this->post('bairro');

				$this->irpara(DOMINIO.$data_destino->busca_pagina.'/inicial/imo_cat/'.$categoria.'/imo_tipo/'.$tipo.'/imo_cidade/'.$cidade.'/imo_bairro/'.$bairro.'/imo_tipo_busca/1');

			} else {
				$this->irpara(DOMINIO);
			}
		} else {
			$this->irpara(DOMINIO);
		}

	}

	public function garagem_busca_ref(){

		$conteudo_id = $this->post('grupo_pagina');

		if($conteudo_id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_grupos WHERE id='$conteudo_id' ");
			$data_destino = $exec->fetch_object();

			if($data_destino->busca_pagina){

				$referencia = $this->post('busca');
				$referencia = str_replace(array("?", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$"), "", $referencia);
				if(!$referencia){
					$referencia = 0;
				}

				$this->irpara(DOMINIO.$data_destino->busca_pagina.'/inicial/gara_busca/'.$referencia);

			} else {
				$this->irpara(DOMINIO);
			}
		} else {
			$this->irpara(DOMINIO);
		}

	}

	public function imoveis_busca_ref(){

		$conteudo_id = $this->post('grupo_pagina');

		if($conteudo_id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imoveis_grupos WHERE id='$conteudo_id' ");
			$data_destino = $exec->fetch_object();

			if($data_destino->busca_pagina){

				$referencia = $this->post('referencia');
				$referencia = str_replace(array("?", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$"), "", $referencia);
				if(!$referencia){
					$referencia = 0;
				}

				$this->irpara(DOMINIO.$data_destino->busca_pagina.'/inicial/imo_ref/'.$referencia.'/imo_tipo_busca/2');

			} else {
				$this->irpara(DOMINIO);
			}
		} else {
			$this->irpara(DOMINIO);
		}


	}

	public function imoveis_busca_det(){

		$conteudo_id = $this->post('grupo_pagina');

		if($conteudo_id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imoveis_grupos WHERE id='$conteudo_id' ");
			$data_destino = $exec->fetch_object();

			if($data_destino->busca_pagina){

				$categoria = $this->post('categoria');
				$tipo = $this->post('tipo');
				$cidade = $this->post('cidade');
				$bairro = $this->post('bairro');
				$dormitorios = $this->post('dormitorios');
				$suites = $this->post('suites');
				$garagem = $this->post('garagem');

				$alugar_valor_min = $this->post('alugar_valor_min');
				$alugar_valor_max = $this->post('alugar_valor_max');
				$comprar_valor_min = $this->post('comprar_valor_min');
				$comprar_valor_max = $this->post('comprar_valor_max');

				if($categoria == '5280'){
					$valor_maximo = $alugar_valor_max;
					$valor_minimo = $alugar_valor_min;
				} else {
					$valor_maximo = $comprar_valor_max;
					$valor_minimo = $comprar_valor_min;
				}

				$ordem = $this->post('ordem');

				$this->irpara(DOMINIO.$data_destino->busca_pagina.'/inicial/imo_cat/'.$categoria.'/imo_tipo/'.$tipo.'/imo_cidade/'.$cidade.'/imo_bairro/'.$bairro.'/imo_dorm/'.$dormitorios.'/imo_suites/'.$suites.'/imo_gara/'.$garagem.'/imo_val_max/'.$valor_maximo.'/imo_val_min/'.$valor_minimo.'/imo_ordem/'.$ordem.'/imo_tipo_busca/3');

			} else {
				$this->irpara(DOMINIO);
			}
		} else {
			$this->irpara(DOMINIO);
		}


	}

	public function imoveis_favoritos_acao(){

		$codigo = $this->post('codigo');
		if($codigo){

			$conexao = new mysql();
			$coisas_fav = $conexao->Executar("SELECT * FROM imoveis_favoritos where codigo='".$codigo."' AND sessao='".$this->_sessao."' ");
			if($coisas_fav->num_rows == 0){
				$db = new mysql();
				$db->inserir("imoveis_favoritos", array(
					"codigo"=>$codigo,
					"sessao"=>$this->_sessao
				));
				echo '2';
				exit;
			} else {
				$db = new mysql();
				$db->apagar("imoveis_favoritos"," codigo='".$codigo."' AND sessao='".$this->_sessao."' ");
				echo '1';
				exit;
			}
		}
	}

	public function classificados_favoritos_acao(){

		$codigo = $this->post('codigo');
		if($codigo){

			$conexao = new mysql();
			$coisas_fav = $conexao->Executar("SELECT * FROM classificados_favoritos where codigo='".$codigo."' AND sessao='".$this->_sessao."' ");
			if($coisas_fav->num_rows == 0){
				$db = new mysql();
				$db->inserir("classificados_favoritos", array(
					"codigo"=>$codigo,
					"sessao"=>$this->_sessao
				));
				echo '2';
				exit;
			} else {
				$db = new mysql();
				$db->apagar("classificados_favoritos"," codigo='".$codigo."' AND sessao='".$this->_sessao."' ");
				echo '1';
				exit;
			}
		}
	}

	public function classificados_favoritos(){	

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		// config dos classificados caso necessario

		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM classificados_detalhes where id='1' ");
		$dados['data_detalhes'] = $coisas_imovel->fetch_object();

		$layoutttt = new model_layout();
		$dados['cores_imo'] = $layoutttt->lista_cores('classificados_detalhes')['lista'];


		$classificados = new model_classificados();
		$dados['lista_favoritos'] = $classificados->favoritos($this->_sessao);


		$this->view('classificados.favoritos', $dados);
	}

	public function imoveis_favoritos(){	

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;

		// config dos imoveis caso necessario

		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM imoveis_detalhes where id='1' ");
		$dados['data_detalhes'] = $coisas_imovel->fetch_object();

		$formatodapaginadetalhes = $dados['data_detalhes']->formato_pg;

		$layoutttt = new model_layout();
		$dados['cores_imo'] = $layoutttt->lista_cores('imoveis_detalhes'.$formatodapaginadetalhes)['lista'];



		$imoveis = new model_imoveis();
		$dados['lista_favoritos'] = $imoveis->favoritos($this->_sessao);


		$this->view('imoveis.favoritos', $dados);
	}

	public function imoveis_cliente(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$dados['nome_do_usuario'] = $this->_nome_usuario;


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


		$imoveis = new model_imoveis();
		$dados['lista_imoveis'] = $imoveis->lista_anuncios($this->_cod_usuario); 

		$dados['abre_pagamento'] = false;
		$codigo_pag = $this->get('pagamento');
		if($codigo_pag){
			$conexao = new mysql();
			$coisas_pg = $conexao->executar("SELECT * FROM imoveis_pedidos WHERE codigo='$codigo_pag' AND status='1' ");
			$data_pg = $coisas_pg->fetch_object();			 
			if(isset($data_pg->id_transacao)){
				$dados['abre_pagamento'] = $data_pg->id_transacao;
			}			
		}


		// pedidos

		$lista_pedidos = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM imoveis_pedidos WHERE cadastro='".$this->_cod_usuario."' AND status>=1 ");
		while($data = $coisas->fetch_object()){

			$lista_pedidos[$n]['id'] = $data->id;
			$lista_pedidos[$n]['codigo'] = $data->codigo;
			$lista_pedidos[$n]['plano'] = $data->plano_titulo;
			$lista_pedidos[$n]['anuncios'] = 'Utilizados '.$data->plano_utilizado.' de '.$data->plano_limite;
			$lista_pedidos[$n]['status_id'] = $data->status;

			if($data->status == 1){ 
				$lista_pedidos[$n]['status'] = "Aguardando Pagamento"; 
			} else {
				$lista_pedidos[$n]['status'] = "Aprovado"; 
			}

			$n++;
		}

		$dados['lista_pedidos'] = $lista_pedidos;


 		//carrega view e envia dados para a tela
		$this->view('minhaconta_imoveis', $dados);		
	}

	public function imoveis_pedido_detalhes(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$codigo = $this->get('codigo');

		if(!$codigo){
			echo "Ocorreu um erro1!";
			exit;
		}

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM imoveis_pedidos WHERE codigo='$codigo' AND cadastro='".$this->_cod_usuario."' ");
		if($coisas->num_rows != 1){
			echo "Ocorreu um erro!";
			exit;
		}

		$dados['data'] = $coisas->fetch_object();


		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_pedidos_utilizacoes where pedido='$codigo' order by id desc"); 
		while($data = $exec->fetch_object()) { 

			$lista[$i]['id'] = $data->id; 
			$lista[$i]['data'] = date('d/m/y H:i', $data->data);
			$lista[$i]['imovel'] = $data->imovel;
			$lista[$i]['ref'] = $data->imovel_ref;

			$i++;
		}

		$dados['lista'] = $lista;




		$this->view('imoveis.pedido.detalhes', $dados);		
	}

	public function adicionar_imovel(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////
		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$dados['nome_do_usuario'] = $this->_nome_usuario;


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;

		$imoveis = new model_imoveis();
		$dados['cidades'] = $imoveis->lista_cidades();


 		//carrega view e envia dados para a tela
		$this->view('minhaconta_add_imo', $dados);
	}

	public function adicionar_imovel_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		// retorno de dados caso erro
		function retorno_erro($msg){
			echo "<div style='padding;20px;' >".$msg."</div>";	
			exit;
		}

		// recebe variaveis

		$titulo = $this->post('titulo');
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');
		$cep = $this->post('cep');

		if(!$titulo){
			retorno_erro("Digite uma titulo válido.");
			exit;
		}

		$endereco_rua = "";
		if($cep){

			$buscacep = new model_cep();
			$resultado_busca_cep = $buscacep->retorno($cep);

			if($resultado_busca_cep['cidade']){

				if($resultado_busca_cep['rua']){
					$endereco_rua = $resultado_busca_cep['rua_tipo']." ".$resultado_busca_cep['rua'];
				}

				$cidade_nome = $resultado_busca_cep['cidade'];
				$estado_uf = $resultado_busca_cep['uf'];

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE cidade='$cidade_nome' AND estado='$estado_uf' ");
				if($coisas->num_rows == 0){					

					$cidade_id = $this->gera_codigo();

					$db = new mysql();
					$db->inserir("imoveis_cidades", array( 
						"codigo"=>$cidade_id,
						"cidade"=>$cidade_nome,
						"estado"=>$estado_uf,
						"principal"=>0
					));

				} else {
					$data_cidade = $coisas->fetch_object();					
					$cidade_id = $data_cidade->codigo;
				}

				if($resultado_busca_cep['bairro']){
					$bairro_nome = $resultado_busca_cep['bairro'];
				} else {
					$bairro_nome = "Centro";
				}

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM imoveis_bairros WHERE cidade='$cidade_nome' AND estado='$estado_uf' AND bairro='$bairro_nome' ");
				if($coisas->num_rows == 0){					

					$bairro_id = $this->gera_codigo();

					$db = new mysql();
					$db->inserir("imoveis_bairros", array( 
						"codigo"=>$bairro_id,
						"bairro"=>$bairro_nome,
						"cidade"=>$cidade_nome,
						"estado"=>$estado_uf
					));

				} else {

					$data_bairro = $coisas->fetch_object();
					$bairro_id = $data_bairro->codigo; 

				}

			} else {
				retorno_erro("Digite um CEP válido.");
				exit;				
			}

		} else {
			if($bairro AND $cidade){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
				if($coisas->num_rows != 1){
					retorno_erro("Ocorreu um erro.");
					exit;					
				} else {
					$data_cidade = $coisas->fetch_object();
					$cidade_id = $data_cidade->codigo;
					$cidade_nome = $data_cidade->cidade;
					$estado_uf = $data_cidade->estado;
				}

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM imoveis_bairros WHERE cidade='$cidade_nome' AND estado='$estado_uf' AND bairro='$bairro' ");
				if($coisas->num_rows == 0){					
					retorno_erro("Ocorreu um erro.");
					exit;
				} else {
					$data_bairro = $coisas->fetch_object();
					$bairro_id = $data_bairro->codigo;
					$bairro_nome = $data_bairro->bairro; 
				}

			} else {
				retorno_erro("Preencha o estado e a cidade do imóvel.");
				exit;
			}
		}


		// echo 'Bairro: '.$bairro_nome.'<br>Bairro Id: '.$bairro_id.'<br>Cidade: '.$cidade_nome.'<br>Cidade id: '.$cidade_id.'<br>Estado: '.$estado_uf; exit;


		//gravar no banco de dados
		$codigo = substr(time().rand(10000,99999),-15);
		$categoria_titulo = "Todas";
		$categoria = 0;
		$time = time();

		$db = new mysql();
		$db->inserir("imoveis", array(
			"data_alteracao"=>$time,
			"codigo"=>$codigo,
			"cadastro"=>$this->_cod_usuario,
			"titulo"=>$titulo,
			"categoria_id"=>$categoria,
			"categoria_titulo"=>$categoria_titulo,
			"endereco"=>$endereco_rua,
			"bairro_id"=>$bairro_id,
			"bairro"=>$bairro_nome,
			"cidade_id"=>$cidade_id,
			"cidade"=>$cidade_nome,
			"uf"=>$estado_uf,
			"valor"=>0,
			"quartos"=>0,
			"suites"=>0,
			"garagem"=>0,
			"banheiros"=>0,
			"churrasqueira"=>0,
			"destaque"=>0,
			"status"=>0
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar_imovel/id/'.$codigo);
	}

	public function alterar_imovel(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$dados['nome_do_usuario'] = $this->_nome_usuario;


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;



		$valores = new model_valores();
		$imoveis = new model_imoveis();

		$codigo_imovel = $this->get('id');

		if(!$codigo_imovel){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo_imovel' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$dados['data_imovel'] = $exec->fetch_object();


		$dados['valor'] = $valores->trata_valor($dados['data_imovel']->valor);
		$dados['condominio'] = $valores->trata_valor($dados['data_imovel']->condominio);
		$dados['iptu'] = $valores->trata_valor($dados['data_imovel']->iptu);

 		//imagens
		$dados['imagens'] = $imoveis->imagens($dados['data_imovel']->codigo);

		// categorias
		$dados['categorias'] = $imoveis->lista_categorias();

 		// tipos
		$dados['tipos'] = $imoveis->tipos();

		//cidades
		$dados['cidades'] = $imoveis->lista_cidades();



 		//carrega view e envia dados para a tela
		$this->view('minhaconta_alterar_imo', $dados);
	}

	public function alterar_imovel_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		$valores = new model_valores();

		// retorno de dados caso erro
		function retorno_erro($msg){
			echo "<div style='padding;20px;' >".$msg."</div>";	
			exit;
		}

		// recebe variaveis
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');

		if(!$codigo){
			retorno_erro("Ocorreu um erro.");
			exit;
		}

		if(!$titulo){
			retorno_erro("Digite uma titulo válido.");
			exit;
		}


		if($bairro AND $cidade){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
			if($coisas->num_rows != 1){
				retorno_erro("Ocorreu um erro.");
				exit;					
			} else {
				$data_cidade = $coisas->fetch_object();
				$cidade_id = $data_cidade->codigo;
				$cidade_nome = $data_cidade->cidade;
				$estado_uf = $data_cidade->estado;
			}

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM imoveis_bairros WHERE cidade='$cidade_nome' AND estado='$estado_uf' AND bairro='$bairro' ");
			if($coisas->num_rows == 0){					
				retorno_erro("Ocorreu um erro.");
				exit;
			} else {
				$data_bairro = $coisas->fetch_object();
				$bairro_id = $data_bairro->codigo;
				$bairro_nome = $data_bairro->bairro; 
			}

		} else {
			retorno_erro("Preencha o estado e a cidade do imóvel.");
			exit;
		}

		$cod_interno = $this->post('cod_interno');	

		$valor = $this->post('valor');
		$valor_formatado = $valores->trata_valor_banco($valor);

		$condominio = $this->post('condominio');
		$condominio_formatado = $valores->trata_valor_banco($condominio);

		$iptu = $this->post('iptu');
		$iptu_formatado = $valores->trata_valor_banco($iptu);

		$descricao = $this->post('descricao');

		$categoria = $this->post('categoria');
		$tipo = $this->post('tipo'); 

		$endereco = $this->post('endereco');
		$numero  = $this->post('numero');
		$complemento  = $this->post('complemento');

		$area_util = $this->post('area_util');
		$area_total  = $this->post('area_total');

		$quartos = $this->post('quartos');
		$suites  = $this->post('suites');
		$banheiros  = $this->post('banheiros');
		$garagem  = $this->post('garagem');
		$churrasqueira  = $this->post('churrasqueira');


		// categoria
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT titulo FROM imoveis_categorias WHERE codigo='$categoria' ");
		$data = $coisas->fetch_object();

		if(isset($data->titulo)){
			$categoria_titulo = $data->titulo;
		} else {
			$categoria_titulo = "Todas";
			$categoria = 0;
		}

		// tipo

		$tipo_titulo = '';
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT titulo FROM imoveis_tipos WHERE codigo='$tipo' ");
		$data = $coisas->fetch_object();
		if(isset($data->titulo)){
			$tipo_titulo = $data->titulo;
		} else {
			retorno_erro("Selecione o Tipo.");
			exit;
		}


		//gravar no banco de dados 
		$time = time();

		$db = new mysql();
		$db->alterar("imoveis", array(
			"data_alteracao"=>$time,
			"titulo"=>$titulo,
			"cod_interno"=>"$cod_interno",
			"categoria_id"=>$categoria,
			"categoria_titulo"=>$categoria_titulo,
			"tipo_id"=>"$tipo",
			"tipo_titulo"=>"$tipo_titulo",
			"descricao"=>"$descricao",
			"endereco"=>"$endereco",
			"numero"=>"$numero",
			"complemento"=>"$complemento",
			"bairro_id"=>$bairro_id,
			"bairro"=>$bairro_nome,
			"cidade_id"=>$cidade_id,
			"cidade"=>$cidade_nome,
			"uf"=>$estado_uf,
			"valor"=>"$valor_formatado",
			"area_util"=>"$area_util",
			"area_total"=>"$area_total",
			"iptu"=>"$iptu_formatado",
			"condominio"=>"$condominio_formatado",
			"quartos"=>"$quartos",
			"suites"=>"$suites",
			"garagem"=>"$garagem",
			"banheiros"=>"$banheiros",
			"churrasqueira"=>"$churrasqueira"
		), " codigo='".$codigo."' AND cadastro='".$this->_cod_usuario."' ");


		retorno_erro("Alterado com sucesso.");
		exit;
	}

	public function imoveis_enviar_imagem(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_imovel = $this->get('codigo');

		if(!$codigo_imovel){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo_imovel' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$data_imovel = $exec->fetch_object();



		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		if($tmp_name){

			// images
         	//  'png' => 'image/png',
            //'jpe' => 'image/jpeg',
            //'jpeg' => 'image/jpeg',
            //'jpg' => 'image/jpeg',
            //'gif' => 'image/gif',
            //'bmp' => 'image/bmp',

			$tipo_arquivo = mime_content_type($tmp_name);

			if($tipo_arquivo == 'image/png'){
				$extensao = "png";
			} else {
				if($tipo_arquivo == 'image/jpeg'){ 
					$extensao = "jpg";
				} else {
					$this->msg('Não foi possível reconhecer o arquivo, verifique o formato do seu arquivo!');
					$this->irpara(DOMINIO.$this->_controller.'/alterar_imovel/id/'.$codigo_imovel);
					exit;
				}
			} 

	 		//carrega model de gestao de imagens
			$img = new model_arquivos_imagens();


			$pasta = "imoveis";
			$diretorio_g = "arquivos/img_".$pasta."_g/".$codigo_imovel."/";
			$diretorio_p = "arquivos/img_".$pasta."_p/".$codigo_imovel."/";

			if(!is_dir($diretorio_g)) {
				mkdir($diretorio_g);
			}
			if(!is_dir($diretorio_p)) {
				mkdir($diretorio_p);
			}

			$nome_foto  = $this->gera_codigo().'.'.$extensao;

			if(copy($tmp_name, $diretorio_g.$nome_foto)){

				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					// foto grande
					$largura_g = 1200;
					$altura_g = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);

					//redimenciona miniatura 
					if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
						//se não redimencionar copia padrao
						copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					}

				} else {

					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

				}


				$db = new mysql();
				$db->inserir("imoveis_imagem", array(
					"codigo"	=>$codigo_imovel,
					"imagem"	=>$nome_foto
				));
				$ultid = $db->ultimo_id();

				//ordem
				$imoveis = new model_imoveis();
				$ordem = $imoveis->ordem_imagens($codigo_imovel);								
				if($ordem){
					$novaordem = $ordem.",".$ultid;
				} else {
					$novaordem = $ultid;
				}

				$db = new mysql();
				$db->inserir("imoveis_imagem_ordem", array(
					"codigo"=>"$codigo_imovel",
					"data"=>"$novaordem"
				));

				$this->irpara(DOMINIO.$this->_controller.'/alterar_imovel/id/'.$codigo_imovel);

			} else {
				$this->msg('Selecione uma imagem válida!');
				$this->volta(1);
				exit;
			}

		} else {
			$this->msg('Selecione uma imagem válida!');
			$this->volta(1);
			exit;
		}

	}

	public function imoveis_ordenar_imagem(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_imovel = $this->post('codigo');

		if(!$codigo_imovel){
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo_imovel' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			exit;
		}

		$list = $this->post_html('list');

		if($list)

		// instancia
			$imoveis = new model_imoveis();

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		//grava
		$db = new mysql();
		$db->inserir("imoveis_imagem_ordem", array(
			"codigo"=>"$codigo_imovel",
			"data"=>"$ordem"
		));

	}

	public function imoveis_apagar_imagem(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_imovel = $this->get('codigo');

		if(!$codigo_imovel){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo_imovel' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$id = $this->get('id');
		if(!$id){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		} else {

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imoveis_imagem WHERE id='$id' ");
			$data = $exec->fetch_object();

			//imagem
			if($data->imagem){
				unlink('arquivos/img_imoveis_g/'.$data->codigo.'/'.$data->imagem);
				unlink('arquivos/img_imoveis_p/'.$data->codigo.'/'.$data->imagem);
			}

			//apaga
			$db = new mysql();
			$db->apagar("imoveis_imagem", " id='$id' ");


			$this->irpara(DOMINIO.$this->_controller.'/alterar_imovel/id/'.$codigo_imovel);
		}

	}

	public function imoveis_comprar_plano(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['controller'] = $this->_controller;

		$planos = new model_imoveis_planos();
		$dados['planos'] = $planos->lista();

		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


 		//carrega view e envia dados para a tela
		$this->view('imoveis.comprar.plano', $dados);		
	}

	public function imoveis_ativar_anuncio(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['controller'] = $this->_controller;

		$codigo_imovel = $this->get('codigo');

		if(!$codigo_imovel){
			echo "Ocorreu um erro.";
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo_imovel' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			echo "Ocorreu um erro.";
			exit;
		}

		$dados['data_imovel'] = $exec->fetch_object();


		$cadastro = new model_cadastro();
		$dados['data_dados'] = $cadastro->dados_usuario($this->_cod_usuario);		

		// lista planos

		$lista_pedidos = array();
		$n = 0;

		if($dados['data_dados']->anuncio_gratis == 0){

			$conexao = new mysql();
			$coisas = $conexao->executar("SELECT * FROM imoveis_planos WHERE id='1' ");
			$data = $coisas->fetch_object();

			if($data->limite != 0){

				$lista_pedidos[$n]['id'] = 1;
				$lista_pedidos[$n]['codigo'] = 1;
				$lista_pedidos[$n]['titulo'] = 'Gratis';

				$n++;	

			}
		}

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM imoveis_pedidos WHERE cadastro='".$this->_cod_usuario."' AND status='2' ");
		while($data = $coisas->fetch_object()){
			if($data->plano_limite > $data->plano_utilizado){

				$lista_pedidos[$n]['id'] = $data->id;
				$lista_pedidos[$n]['codigo'] = $data->codigo;
				$lista_pedidos[$n]['titulo'] = $data->plano_titulo;

				$n++;
			}
		}

		$dados['planos'] = $lista_pedidos;



		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


 		//carrega view e envia dados para a tela
		$this->view('imoveis.ativar.anuncio', $dados);		
	}

	public function imoveis_confere_plano(){

		$valores = new model_valores();

		$codigo = $this->post('codigo');

		if($codigo){

			$conexao = new mysql();
			$coisas = $conexao->executar("SELECT * FROM imoveis_planos WHERE codigo='$codigo' ");
			$data = $coisas->fetch_object();

			$valor_tratado = $valores->trata_valor($data->valor);

			if($data->meses != 0){
				if($data->meses == 1){
					$periodo = "1 Mês";
				} else {
					$periodo = $data->meses." Meses";
				}
			} else {
				if($data->dias == 1){
					$periodo = "1 Dia";
				} else {
					$periodo = $data->dias." dias";
				}
			}		

			echo "
			<div class='imoveis_planos_div' >

			<div class='imoveis_planos_meses' >Período: <strong>$periodo</strong></div>

			<div class='imoveis_planos_meses' >Número de anúncios: <strong>$data->limite</strong></div>

			<div class='imoveis_planos_meses' >Valor do plano: <strong>R$ ".$valor_tratado."</strong></div>

			</div>
			";

		}
	}

	public function imoveis_comprar_plano_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		$plano = $this->post('plano');

		if(!$plano){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_planos WHERE codigo='$plano' ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$data_plano = $exec->fetch_object();

		$codigo = $this->gera_codigo();
		$time = time();

		$db = new mysql();
		$db->inserir("imoveis_pedidos", array(
			"codigo"=>$codigo,
			"cadastro"=>$this->_cod_usuario,
			"plano"=>$plano,
			"plano_titulo"=>$data_plano->titulo,
			"plano_valor"=>$data_plano->valor,
			"plano_periodo_meses"=>$data_plano->meses,
			"plano_periodo_dias"=>$data_plano->dias,
			"plano_limite"=>$data_plano->limite,
			"data"=>$time,
			"status"=>0
		));

		$id_pedido = $db->ultimo_id();

		$valores = new model_valores();

		$conexao = new mysql();
		$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='3' ");
		$data_pagamento = $coisas_pagamento->fetch_object();

		$enderecoderetorno = DOMINIO."index/imoveis_cliente/pagamento/".$codigo."/";
		$enderecoderetorno_sucesso = DOMINIO."index/imoveis_cliente/pagamento/".$codigo."/";

		require_once('vendor/autoload.php');

		MercadoPago\SDK::setClientId($data_pagamento->mercadopago_client_id);
		MercadoPago\SDK::setClientSecret($data_pagamento->mercadopago_client_secret);
		MercadoPago\SDK::setAccessToken($data_pagamento->mercadopago_access_token);
		//$data_pagamento->mercadopago_public_key

		$preference = new MercadoPago\Preference();

		$valor_tratado_mp = str_replace(".", "", $valores->trata_valor($data_plano->valor));
		$valor_tratado_mp = str_replace(",", ".", $valor_tratado_mp);

		$item = new MercadoPago\Item();
		$item->title = "Pedido ".$id_pedido;
		$item->quantity = 1;
		$item->unit_price = $valor_tratado_mp;
		$preference->items = array($item);
		$preference->external_reference = $codigo;
		$preference->back_urls = array(
			"success" => "$enderecoderetorno_sucesso",
			"failure" => "$enderecoderetorno",
			"pending" => "$enderecoderetorno_sucesso"
		);
		$preference->auto_return = "all";
		$preference->notification_url = DOMINIO."sistema/mercadopago_retorno/index.php";					 
		$preference->save();

		if($preference->id){

			$codigo_transacao = $preference->id;

			$conexao = new mysql();
			$conexao->alterar("imoveis_pedidos", array(				
				"status"=>1,
				"id_transacao"=>$codigo_transacao
			), " codigo='".$codigo."' ");

			$this->irpara(DOMINIO.'index/imoveis_cliente/pagamento/'.$codigo);

		} else {
			echo "Ocorreu um erro!";
			exit;
		}

	}

	public function imoveis_ativar_anuncio_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_imovel = $this->post('imovel');

		if(!$codigo_imovel){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$plano = $this->post('plano');

		if(!$plano){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo_imovel' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$data_imovel = $exec->fetch_object();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_pedidos WHERE codigo='$plano' ");
		if($exec->num_rows != 1){

			if($plano == 1){

				$cadastro = new model_cadastro();
				$data_dados = $cadastro->dados_usuario($this->_cod_usuario);
				if($data_dados->anuncio_gratis == 0){

					$plano = $this->gera_codigo();

					$db = new mysql();
					$exec2 = $db->executar("SELECT * FROM imoveis_planos WHERE codigo='1' ");
					$data_plano2 = $exec2->fetch_object();
					$time = time();

					$db = new mysql();
					$db->inserir("imoveis_pedidos", array(
						"codigo"=>$plano,
						"cadastro"=>$this->_cod_usuario,
						"plano"=>1,
						"plano_titulo"=>'Gratis',
						"plano_valor"=>0,
						"plano_periodo_meses"=>$data_plano2->meses,
						"plano_periodo_dias"=>$data_plano2->dias,
						"plano_limite"=>$data_plano2->limite,
						"data"=>$time,
						"status"=>2
					));

					$db = new mysql();
					$db->alterar("cadastro", array(
						"anuncio_gratis"=>1
					), " codigo='".$this->_cod_usuario."' ");

					$db = new mysql();
					$exec = $db->executar("SELECT * FROM imoveis_pedidos WHERE codigo='$plano' ");

				}

			} else {

				$this->irpara(DOMINIO.'index/imoveis_cliente');
				exit;
			}
		}

		$data_plano = $exec->fetch_object();		

		$plano_utilizado = $data_plano->plano_utilizado + 1;

		if($plano_utilizado > $data_plano->plano_limite){
			$this->msg('O plano exedeu o numero de anúncios!');
			$this->irpara(DOMINIO.'index/imoveis_cliente');
			exit;
		}

		$db = new mysql();
		$db->alterar("imoveis_pedidos", array(
			"plano_utilizado"=>$plano_utilizado
		), " codigo='$plano' ");

		$time = time();

		$db = new mysql();
		$db->inserir("imoveis_pedidos_utilizacoes", array(
			"pedido"=>$plano,
			"data"=>$time,
			"imovel"=>$codigo_imovel,
			"imovel_ref"=>$data_imovel->id
		));

		if($data_plano->plano_periodo_meses == 0){
			$vencimento = strtotime('+ '.$data_plano->plano_periodo_dias.' days');
		} else {
			$vencimento = strtotime('+ '.$data_plano->plano_periodo_meses.' months');
		}

		$db = new mysql();
		$db->alterar("imoveis",  array(
			"anuncio_vencimento"=>$vencimento
		), " id='$data_imovel->id' ");


		$this->irpara(DOMINIO.'index/imoveis_cliente');
	}

	public function classificados_busca_simp(){

		$conteudo_id = $this->post('grupo_pagina');

		if($conteudo_id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM classificados_grupos WHERE id='$conteudo_id' ");
			$data_destino = $exec->fetch_object();

			if($data_destino->busca_pagina){

				$categoria = $this->post('categoria');
				$cidade = $this->post('cidade');
				$bairro = $this->post('bairro');

				$this->irpara(DOMINIO.$data_destino->busca_pagina.'/inicial/cla_cat/'.$categoria.'/cla_cidade/'.$cidade.'/cla_bairro/'.$bairro.'/cla_tipo_busca/1');

			} else {
				$this->irpara(DOMINIO);
			}
		} else {
			$this->irpara(DOMINIO);
		}

	}

	public function classificados_busca_ref(){

		$conteudo_id = $this->post('grupo_pagina');

		if($conteudo_id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM classificados_grupos WHERE id='$conteudo_id' ");
			$data_destino = $exec->fetch_object();

			if($data_destino->busca_pagina){

				$referencia = $this->post('referencia');
				$referencia = str_replace(array("?", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$"), "", $referencia);
				if(!$referencia){
					$referencia = 0;
				}

				$this->irpara(DOMINIO.$data_destino->busca_pagina.'/inicial/cla_ref/'.$referencia.'/cla_tipo_busca/2');

			} else {
				$this->irpara(DOMINIO);
			}
		} else {
			$this->irpara(DOMINIO);
		}


	}

	public function classificados_busca_det(){


		$conteudo_id = $this->post('grupo_pagina');

		if($conteudo_id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM classificados_grupos WHERE id='$conteudo_id' ");
			$data_destino = $exec->fetch_object();

			if($data_destino->busca_pagina){

				$categoria = $this->post('categoria'); 
				$cidade = $this->post('cidade');
				$bairro = $this->post('bairro');

				$valor_min = $this->post('valor_min');
				$valor_max = $this->post('valor_max'); 

				$valor_maximo = $valor_max;
				$valor_minimo = $valor_min;

				$ordem = $this->post('ordem');

				$complemento = ""; 

				$classificados = new model_classificados();
				$opcoes = $classificados->lista_opcoes();
				foreach ($opcoes as $key => $value) {
					foreach ($value['opcoes'] as $key2 => $value2) {
						if($this->post('cla_opcoes_'.$value2['id']) == $value2['id']){
							$complemento .= "/cla_op_".$value2['id']."/1";
						}
					}
				}


				$this->irpara(DOMINIO.$data_destino->busca_pagina.'/inicial/cla_cat/'.$categoria.'/cla_cidade/'.$cidade.'/cla_bairro/'.$bairro.'/cla_val_max/'.$valor_maximo.'/cla_val_min/'.$valor_minimo.'/cla_ordem/'.$ordem.'/cla_tipo_busca/3'.$complemento);

			} else {
				$this->irpara(DOMINIO);
			}
		} else {
			$this->irpara(DOMINIO);
		}


	}

	public function classificados_detalhes(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$codigo = $this->get('id');

		if(!$codigo){
			$this->irpara(DOMINIO);
		}


		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM classificados where codigo='$codigo' ");
		$dados['data'] = $coisas_imovel->fetch_object();

		$dados['whats_do_anuncio'] = '';
		if($dados['data']->cadastro){

			$cadastro = new model_cadastro();
			$data_cad = $cadastro->dados_usuario($dados['data']->cadastro);	
			if($data_cad->telefone){
				$dados['whats_do_anuncio'] = str_replace(array("(", ")", " ", "-", "."), "", $data_cad->telefone);
			}
		}


		if( !$dados['data']->id ){
			$this->irpara(DOMINIO);
		}

		$classificados = new model_classificados();
		$dados['imagens'] = $classificados->imagens($dados['data']->codigo);
		if(isset($dados['imagens'][0]['imagem_g'])){
			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
		}

		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		$dados['similares'] = $classificados->similares($dados['data']->codigo, $dados['data']->categoria_id);

		$dados['opcoes'] = $classificados->opcoes($dados['data']->codigo);
		$dados['lista_videos'] = $classificados->lista_videos($dados['data']->codigo);

		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM classificados_detalhes where id='1' ");
		$dados['data_detalhes'] = $coisas_imovel->fetch_object();


		$layoutttt = new model_layout();
		$dados['cores_imo'] = $layoutttt->lista_cores('classificados_detalhes')['lista'];



		$dados['endereco_imovel_sem_ssl'] = DOMINIO.$this->_controller.'/classificados_detalhes/id/'.$dados['data']->codigo;

		//pega imagens 

		$dados['imagem_principal_largura'] = "";
		$dados['imagem_principal_altura'] = "";
		$dados['imagem_principal'] = "";
		if(isset($dados['imagens'][0]['imagem_g'])){

			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
			$dados['imagem_principal_sem_ssl'] = $string = str_replace("https://", "http://", $dados['imagens'][0]['imagem_g']);

			$imagem_principal = "arquivos/img_classificados_g/".$dados['data']->codigo."/".$dados['imagens'][0]['imagem'];
			list($largura, $altura) = getimagesize($imagem_principal);
			if($largura){
				$dados['imagem_principal_largura'] = $largura;
			}
			if($altura){
				$dados['imagem_principal_altura'] = $altura;
			}

		}

		$dados['endereco_postagem'] = DOMINIO.$this->_controller."/classificados_detalhes/id/".$dados['data']->codigo;
		$dados['endereco_postagem_sem_ssl'] = $string = str_replace("https://", "http://", $dados['endereco_postagem']);



		// favoritos
		$conexao = new mysql();
		$coisas_fav = $conexao->Executar("SELECT * FROM classificados_favoritos where codigo='".$dados['data']->codigo."' AND sessao='".$this->_sessao."' ");
		if($coisas_fav->num_rows == 0){
			$dados['favorito'] = 2;
		} else {
			$dados['favorito'] = 1;
		}



		$this->view('classificados.detalhes', $dados);

	}

	public function classificados_cliente(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$dados['nome_do_usuario'] = $this->_nome_usuario;


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


		$classificados = new model_classificados();
		$dados['lista_classificados'] = $classificados->lista_anuncios($this->_cod_usuario); 

		$dados['abre_pagamento'] = false;
		$codigo_pag = $this->get('pagamento');
		if($codigo_pag){
			$conexao = new mysql();
			$coisas_pg = $conexao->executar("SELECT * FROM classificados_pedidos WHERE codigo='$codigo_pag' AND status='1' ");
			$data_pg = $coisas_pg->fetch_object();			 
			if(isset($data_pg->id_transacao)){
				$dados['abre_pagamento'] = $data_pg->id_transacao;
			}			
		}


		// pedidos

		$lista_pedidos = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM classificados_pedidos WHERE cadastro='".$this->_cod_usuario."' AND status>=1 ");
		while($data = $coisas->fetch_object()){

			$lista_pedidos[$n]['id'] = $data->id;
			$lista_pedidos[$n]['codigo'] = $data->codigo;
			$lista_pedidos[$n]['plano'] = $data->plano_titulo;
			$lista_pedidos[$n]['anuncios'] = 'Utilizados '.$data->plano_utilizado.' de '.$data->plano_limite;
			$lista_pedidos[$n]['status_id'] = $data->status;

			if($data->status == 1){ 
				$lista_pedidos[$n]['status'] = "Aguardando Pagamento"; 
			} else {
				$lista_pedidos[$n]['status'] = "Aprovado"; 
			}

			$n++;
		}

		$dados['lista_pedidos'] = $lista_pedidos;


 		//carrega view e envia dados para a tela
		$this->view('minhaconta_classificados', $dados);		
	}

	public function classificados_pedido_detalhes(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;

		$codigo = $this->get('codigo');

		if(!$codigo){
			echo "Ocorreu um erro1!";
			exit;
		}

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM classificados_pedidos WHERE codigo='$codigo' AND cadastro='".$this->_cod_usuario."' ");
		if($coisas->num_rows != 1){
			echo "Ocorreu um erro!";
			exit;
		}

		$dados['data'] = $coisas->fetch_object();


		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos_utilizacoes where pedido='$codigo' order by id desc"); 
		while($data = $exec->fetch_object()) { 

			$lista[$i]['id'] = $data->id; 
			$lista[$i]['data'] = date('d/m/y H:i', $data->data);
			$lista[$i]['anuncio'] = $data->anuncio;
			$lista[$i]['ref'] = $data->anuncio_ref;

			$i++;
		}

		$dados['lista'] = $lista;




		$this->view('classificados.pedido.detalhes', $dados);		
	}

	public function adicionar_anuncio(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$dados['nome_do_usuario'] = $this->_nome_usuario;


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;

		$classificados = new model_classificados();
		$dados['cidades'] = $classificados->lista_cidades();


 		//carrega view e envia dados para a tela
		$this->view('minhaconta_add_cla', $dados);
	}

	public function adicionar_anuncio_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		// retorno de dados caso erro
		function retorno_erro($msg){
			echo "<div style='padding;20px;' >".$msg."</div>";	
			exit;
		}

		// recebe variaveis

		$titulo = $this->post('titulo');
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');
		$cep = $this->post('cep');

		if(!$titulo){
			retorno_erro("Digite uma titulo válido.");
			exit;
		}

		$endereco_rua = "";
		if($cep){

			$buscacep = new model_cep();
			$resultado_busca_cep = $buscacep->retorno($cep);

			if($resultado_busca_cep['cidade']){

				if($resultado_busca_cep['rua']){
					$endereco_rua = $resultado_busca_cep['rua_tipo']." ".$resultado_busca_cep['rua'];
				}

				$cidade_nome = $resultado_busca_cep['cidade'];
				$estado_uf = $resultado_busca_cep['uf'];

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM classificados_cidades WHERE cidade='$cidade_nome' AND estado='$estado_uf' ");
				if($coisas->num_rows == 0){					

					$cidade_id = $this->gera_codigo();

					$db = new mysql();
					$db->inserir("classificados_cidades", array( 
						"codigo"=>$cidade_id,
						"cidade"=>$cidade_nome,
						"estado"=>$estado_uf,
						"principal"=>0
					));

				} else {
					$data_cidade = $coisas->fetch_object();					
					$cidade_id = $data_cidade->codigo;
				}

				if($resultado_busca_cep['bairro']){
					$bairro_nome = $resultado_busca_cep['bairro'];
				} else {
					$bairro_nome = "Centro";
				}

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM classificados_bairros WHERE cidade='$cidade_nome' AND estado='$estado_uf' AND bairro='$bairro_nome' ");
				if($coisas->num_rows == 0){					

					$bairro_id = $this->gera_codigo();

					$db = new mysql();
					$db->inserir("classificados_bairros", array( 
						"codigo"=>$bairro_id,
						"bairro"=>$bairro_nome,
						"cidade"=>$cidade_nome,
						"estado"=>$estado_uf
					));

				} else {

					$data_bairro = $coisas->fetch_object();
					$bairro_id = $data_bairro->codigo; 

				}

			} else {
				retorno_erro("Digite um CEP válido.");
				exit;				
			}

		} else {
			if($bairro AND $cidade){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM classificados_cidades WHERE codigo='$cidade' ");
				if($coisas->num_rows != 1){
					retorno_erro("Ocorreu um erro.");
					exit;					
				} else {
					$data_cidade = $coisas->fetch_object();
					$cidade_id = $data_cidade->codigo;
					$cidade_nome = $data_cidade->cidade;
					$estado_uf = $data_cidade->estado;
				}

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM classificados_bairros WHERE cidade='$cidade_nome' AND estado='$estado_uf' AND codigo='$bairro' ");
				if($coisas->num_rows == 0){					
					retorno_erro("Ocorreu um erro.");
					exit;
				} else {
					$data_bairro = $coisas->fetch_object();
					$bairro_id = $data_bairro->codigo;
					$bairro_nome = $data_bairro->bairro; 
				}

			} else {
				retorno_erro("Preencha o estado e a cidade do imóvel.");
				exit;
			}
		}


		// echo 'Bairro: '.$bairro_nome.'<br>Bairro Id: '.$bairro_id.'<br>Cidade: '.$cidade_nome.'<br>Cidade id: '.$cidade_id.'<br>Estado: '.$estado_uf; exit;


		//gravar no banco de dados
		$codigo = substr(time().rand(10000,99999),-15);
		$categoria_titulo = "Todas";
		$categoria = 0;
		$time = time();

		$db = new mysql();
		$db->inserir("classificados", array(
			"data_alteracao"=>$time,
			"codigo"=>$codigo,
			"cadastro"=>$this->_cod_usuario,
			"titulo"=>$titulo,
			"categoria_id"=>$categoria,
			"categoria_titulo"=>$categoria_titulo,
			"bairro_id"=>$bairro_id,
			"bairro"=>$bairro_nome,
			"cidade_id"=>$cidade_id,
			"cidade"=>$cidade_nome,
			"uf"=>$estado_uf,
			"valor"=>0,
			"status"=>0
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar_anuncio/id/'.$codigo);
	}

	public function alterar_anuncio(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		$dados['_cod_usuario'] = $this->_cod_usuario;
		$dados['_sessao'] = $this->_sessao;
		$dados['_acesso'] = $this->_acesso;
		$dados['_nome_usuario'] = $this->_nome_usuario;


		// itens da inciial

		$chave = $this->_layout;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($coisas->num_rows != 1){
			$this->_layout = "index";
			$this->irpara(DOMINIO);
		}
		$dados['data_pagina'] = $coisas->fetch_object();
		$codigo_pagina = $dados['data_pagina']->codigo;

		////////////////////////////////////////////////////////////////////////

		$cores = array();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo_pagina' ");
		while($data = $coisas->fetch_object()){
			$cores[$data->codigo] = $data->cor;
		}
		$dados['pagina_cores'] = $cores;

		////////////////////////////////////////////////////////////////////////

		$lista_blocos = array();
		$n_bloc = 0; 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo_pagina' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_bloco = $conexao->Executar("SELECT * FROM layout_blocos WHERE id='$value' AND pagina='$codigo_pagina' ");
				$data_bloco = $coisas_bloco->fetch_object();

				if(isset($data_bloco->id)){

					$lista_blocos[$n_bloc]['id'] = $data_bloco->id;
					$lista_blocos[$n_bloc]['codigo'] = $data_bloco->codigo;
					$lista_blocos[$n_bloc]['colunas'] = $data_bloco->colunas;
					$lista_blocos[$n_bloc]['full'] = $data_bloco->full;
					$lista_blocos[$n_bloc]['formato'] = $data_bloco->formato;

					$n_col = 1;
					while ($n_col <= $data_bloco->colunas) {

						$item_codigo = '';
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}
						if($n_col == 2){
							$item_codigo = $data_bloco->coluna2;
						}
						if($n_col == 3){
							$item_codigo = $data_bloco->coluna3;
						}
						if($n_col == 4){
							$item_codigo = $data_bloco->coluna4;
						}
						if($n_col == 5){
							$item_codigo = $data_bloco->coluna5;
						}
						if($n_col == 6){
							$item_codigo = $data_bloco->coluna6;
						}
						if($n_col == 1){
							$item_codigo = $data_bloco->coluna1;
						}

						$lista_layout = array(); 

						if($item_codigo){

							$conexao = new mysql();
							$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$item_codigo' ");
							$data = $coisas->fetch_object();

							if(isset($data->id)){

								$modulo_id = $lista_blocos[$n_bloc]['id'].'_'.$n_col.'_'.$data->id;

								$lista_layout['id'] = $modulo_id;
								$lista_layout['codigo'] = $data->codigo;
								$lista_layout['titulo'] = $data->titulo;
								$lista_layout['tipo'] = $data->tipo;

								if($data->tipo == 'topo'){
									$topos = new model_topos();
									$lista_layout['conteudo'] = $topos->lista($data->codigo);
									$banners = new model_banners();
									$lista_layout['conteudo']['banners_topo'] = $banners->lista_simples('148713350186606');
								}

								if($data->tipo == 'rodape'){							
									$rodapes = new model_rodapes();
									$lista_layout['conteudo'] = $rodapes->lista($data->codigo);
								}

								// termina tipos de conteudo
							}
						}

						$lista_blocos[$n_bloc]['coluna'.$n_col] = $lista_layout;

						$n_col++;
					}

					$n_bloc++;
				}

			}

		}

		$dados['layout_lista'] = $lista_blocos;


		$dados['nome_do_usuario'] = $this->_nome_usuario;


		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;



		$valores = new model_valores();
		$classificados = new model_classificados();

		$codigo_anuncio = $this->get('id');

		if(!$codigo_anuncio){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados WHERE codigo='$codigo_anuncio' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$dados['data_anuncio'] = $exec->fetch_object();


		$dados['valor'] = $valores->trata_valor($dados['data_anuncio']->valor); 

 		//imagens
		$dados['imagens'] = $classificados->imagens($dados['data_anuncio']->codigo);

		// categorias
		$dados['categorias'] = $classificados->lista_categorias();

 		// tipos
		$dados['opcoes'] = $classificados->lista_opcoes();

		//cidades
		$dados['cidades'] = $classificados->lista_cidades();

		$opcoes_selecionadas = array();
		$opcoes_selecionadas_n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_opcoes_sel WHERE codigo='$codigo_anuncio' ");
		while($data = $coisas->fetch_object()){
			$opcoes_selecionadas[$opcoes_selecionadas_n] = $data->opcional;
			$opcoes_selecionadas_n++;
		}

		$dados['classificados_opcoes_selecionadas'] = $opcoes_selecionadas;

 		//carrega view e envia dados para a tela
		$this->view('minhaconta_alterar_cla', $dados);
	}

	public function alterar_anuncio_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		$valores = new model_valores();

		// retorno de dados caso erro
		function retorno_erro($msg){
			echo "<div style='padding;20px;' >".$msg."</div>";	
			exit;
		}

		// recebe variaveis
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');

		if(!$codigo){
			retorno_erro("Ocorreu um erro.");
			exit;
		}

		if(!$titulo){
			retorno_erro("Digite uma titulo válido.");
			exit;
		}


		if($bairro AND $cidade){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM classificados_cidades WHERE codigo='$cidade' ");
			if($coisas->num_rows != 1){
				retorno_erro("Ocorreu um erro.");
				exit;					
			} else {
				$data_cidade = $coisas->fetch_object();
				$cidade_id = $data_cidade->codigo;
				$cidade_nome = $data_cidade->cidade;
				$estado_uf = $data_cidade->estado;
			}

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM classificados_bairros WHERE cidade='$cidade_nome' AND estado='$estado_uf' AND codigo='$bairro' ");
			if($coisas->num_rows == 0){					
				retorno_erro("Ocorreu um erro.");
				exit;
			} else {
				$data_bairro = $coisas->fetch_object();
				$bairro_id = $data_bairro->codigo;
				$bairro_nome = $data_bairro->bairro; 
			}

		} else {
			retorno_erro("Preencha o estado e a cidade do imóvel.");
			exit;
		}

		$cod_interno = $this->post('cod_interno');	

		$valor = $this->post('valor');
		$valor_formatado = $valores->trata_valor_banco($valor);

		$descricao = $this->post('descricao');

		$categoria = $this->post('categoria');

		// categoria
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT titulo FROM classificados_categorias WHERE codigo='$categoria' ");
		$data = $coisas->fetch_object();

		if(isset($data->titulo)){
			$categoria_titulo = $data->titulo;
		} else {
			$categoria_titulo = "Todas";
			$categoria = 0;
		}


		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_opcoes ");
		while($data = $exec->fetch_object()){

			if($this->post('cla_opcoes_'.$data->id) == $data->id){

				$db = new mysql();
				$exec2 = $db->executar("SELECT * FROM classificados_opcoes_sel where codigo='$codigo' AND opcional='$data->codigo' ");
				if($exec2->num_rows == 0){
					$db = new mysql();
					$db->inserir("classificados_opcoes_sel", array(
						"codigo"=>$codigo,
						"opcional"=>$data->codigo
					));
				}

			} else {

				$db = new mysql();
				$exec2 = $db->executar("SELECT * FROM classificados_opcoes_sel where codigo='$codigo' AND opcional='$data->codigo' ");
				if($exec2->num_rows != 0){
					$db = new mysql();
					$db->apagar("classificados_opcoes_sel", " codigo='$codigo' AND opcional='$data->codigo' ");
				}

			}
		}


		//gravar no banco de dados 
		$time = time();

		$db = new mysql();
		$db->alterar("classificados", array(
			"data_alteracao"=>$time,
			"titulo"=>$titulo,
			"cod_interno"=>"$cod_interno",
			"categoria_id"=>$categoria,
			"categoria_titulo"=>$categoria_titulo,			 
			"descricao"=>"$descricao",			 
			"bairro_id"=>$bairro_id,
			"bairro"=>$bairro_nome,
			"cidade_id"=>$cidade_id,
			"cidade"=>$cidade_nome,
			"uf"=>$estado_uf,
			"valor"=>$valor_formatado
		), " codigo='".$codigo."' AND cadastro='".$this->_cod_usuario."' ");


		retorno_erro("Alterado com sucesso.");
		exit;
	}

	public function classificados_enviar_imagem(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_anuncio = $this->get('codigo');

		if(!$codigo_anuncio){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados WHERE codigo='$codigo_anuncio' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$data_anuncio = $exec->fetch_object();



		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		if($tmp_name){

			// images
         	//  'png' => 'image/png',
            //'jpe' => 'image/jpeg',
            //'jpeg' => 'image/jpeg',
            //'jpg' => 'image/jpeg',
            //'gif' => 'image/gif',
            //'bmp' => 'image/bmp',

			$tipo_arquivo = mime_content_type($tmp_name);

			if($tipo_arquivo == 'image/png'){
				$extensao = "png";
			} else {
				if($tipo_arquivo == 'image/jpeg'){ 
					$extensao = "jpg";
				} else {
					$this->msg('Não foi possível reconhecer o arquivo, verifique o formato do seu arquivo!');
					$this->irpara(DOMINIO.$this->_controller.'/alterar_anuncio/id/'.$codigo_anuncio);
					exit;
				}
			} 

	 		//carrega model de gestao de imagens
			$img = new model_arquivos_imagens();


			$pasta = "classificados";
			$diretorio_g = "arquivos/img_".$pasta."_g/".$codigo_anuncio."/";
			$diretorio_p = "arquivos/img_".$pasta."_p/".$codigo_anuncio."/";

			if(!is_dir($diretorio_g)) {
				mkdir($diretorio_g);
			}
			if(!is_dir($diretorio_p)) {
				mkdir($diretorio_p);
			}

			$nome_foto  = $this->gera_codigo().'.'.$extensao;

			if(copy($tmp_name, $diretorio_g.$nome_foto)){

				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					// foto grande
					$largura_g = 1200;
					$altura_g = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);

					//redimenciona miniatura 
					if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
						//se não redimencionar copia padrao
						copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					}

				} else {

					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

				}


				$db = new mysql();
				$db->inserir("classificados_imagem", array(
					"codigo"	=>$codigo_anuncio,
					"imagem"	=>$nome_foto
				));
				$ultid = $db->ultimo_id();

				//ordem
				$classificados = new model_classificados();
				$ordem = $classificados->ordem_imagens($codigo_anuncio);								
				if($ordem){
					$novaordem = $ordem.",".$ultid;
				} else {
					$novaordem = $ultid;
				}

				$db = new mysql();
				$db->inserir("classificados_imagem_ordem", array(
					"codigo"=>"$codigo_anuncio",
					"data"=>"$novaordem"
				));

				$this->irpara(DOMINIO.$this->_controller.'/alterar_anuncio/id/'.$codigo_anuncio);

			} else {
				$this->msg('Selecione uma imagem válida!');
				$this->volta(1);
				exit;
			}

		} else {
			$this->msg('Selecione uma imagem válida!');
			$this->volta(1);
			exit;
		}

	}

	public function classificados_ordenar_imagem(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_anuncio = $this->post('codigo');

		if(!$codigo_anuncio){
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados WHERE codigo='$codigo_anuncio' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			exit;
		}

		$list = $this->post_html('list');

		if($list)

		// instancia
			$classificados = new model_classificados();

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		//grava
		$db = new mysql();
		$db->inserir("classificados_imagem_ordem", array(
			"codigo"=>"$codigo_anuncio",
			"data"=>"$ordem"
		));

	}

	public function classificados_apagar_imagem(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_anuncio = $this->get('codigo');

		if(!$codigo_anuncio){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados WHERE codigo='$codigo_anuncio' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$id = $this->get('id');
		if(!$id){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		} else {

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM classificados_imagem WHERE id='$id' ");
			$data = $exec->fetch_object();

			//imagem
			if($data->imagem){
				unlink('arquivos/img_classificados_g/'.$data->codigo.'/'.$data->imagem);
				unlink('arquivos/img_classificados_p/'.$data->codigo.'/'.$data->imagem);
			}

			//apaga
			$db = new mysql();
			$db->apagar("classificados_imagem", " id='$id' ");


			$this->irpara(DOMINIO.$this->_controller.'/alterar_anuncio/id/'.$codigo_anuncio);
		}

	}

	public function classificados_comprar_plano(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['controller'] = $this->_controller;

		$planos = new model_classificados_planos();
		$dados['planos'] = $planos->lista();

		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


 		//carrega view e envia dados para a tela
		$this->view('classificados.comprar.plano', $dados);		
	}

	public function classificados_ativar_anuncio(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['controller'] = $this->_controller;

		$codigo_anuncio = $this->get('codigo');

		if(!$codigo_anuncio){
			echo "Ocorreu um erro.";
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados WHERE codigo='$codigo_anuncio' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			echo "Ocorreu um erro.";
			exit;
		}

		$dados['data_anuncio'] = $exec->fetch_object();


		$cadastro = new model_cadastro();
		$dados['data_dados'] = $cadastro->dados_usuario($this->_cod_usuario);		

		// lista planos

		$lista_pedidos = array();
		$n = 0;

		if($dados['data_dados']->anuncio_gratis == 0){

			$conexao = new mysql();
			$coisas = $conexao->executar("SELECT * FROM classificados_planos WHERE id='1' ");
			$data = $coisas->fetch_object();

			if($data->limite != 0){

				$lista_pedidos[$n]['id'] = 1;
				$lista_pedidos[$n]['codigo'] = 1;
				$lista_pedidos[$n]['titulo'] = 'Gratis';

				$n++;	

			}
		}

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM classificados_pedidos WHERE cadastro='".$this->_cod_usuario."' AND status='2' ");
		while($data = $coisas->fetch_object()){
			if($data->plano_limite > $data->plano_utilizado){

				$lista_pedidos[$n]['id'] = $data->id;
				$lista_pedidos[$n]['codigo'] = $data->codigo;
				$lista_pedidos[$n]['titulo'] = $data->plano_titulo;

				$n++;
			}
		}

		$dados['planos'] = $lista_pedidos;



		// botao e detalhes 

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM classificados_detalhes WHERE id='1' ");
		$data_detalhes = $coisas->fetch_object();

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$data_detalhes->botao_codigo_ped' ");
		$data = $coisas->fetch_object();

		if(isset($data->codigo)){

			$botao_style = "
			<style>
			a.botao_".$data->codigo.", .botao_".$data->codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
			
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao_style .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao_style .= "
			}
			a.botao_".$data->codigo.":hover, .botao_".$data->codigo.":hover {
				
				
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			$botao_css = "botao_padrao botao_".$data->codigo;

		} else {
			$botao_css = "";
			$botao_style = "";
		}

		$dados['botao_css'] = $botao_css;
		$dados['botao_style'] = $botao_style;


 		//carrega view e envia dados para a tela
		$this->view('classificados.ativar.anuncio', $dados);		
	}

	public function classificados_confere_plano(){

		$valores = new model_valores();

		$codigo = $this->post('codigo');

		if($codigo){

			$conexao = new mysql();
			$coisas = $conexao->executar("SELECT * FROM classificados_planos WHERE codigo='$codigo' ");
			$data = $coisas->fetch_object();

			$valor_tratado = $valores->trata_valor($data->valor);

			if($data->meses != 0){
				if($data->meses == 1){
					$periodo = "1 Mês";
				} else {
					$periodo = $data->meses." Meses";
				}
			} else {
				if($data->dias == 1){
					$periodo = "1 Dia";
				} else {
					$periodo = $data->dias." dias";
				}
			}		

			echo "
			<div class='classificados_planos_div' >

			<div class='classificados_planos_meses' >Período: <strong>$periodo</strong></div>

			<div class='classificados_planos_meses' >Número de anúncios: <strong>$data->limite</strong></div>

			<div class='classificados_planos_meses' >Valor do plano: <strong>R$ ".$valor_tratado."</strong></div>

			</div>
			";

		}
	}

	public function classificados_comprar_plano_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();

		$plano = $this->post('plano');

		if(!$plano){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_planos WHERE codigo='$plano' ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$data_plano = $exec->fetch_object();

		$codigo = $this->gera_codigo();
		$time = time();

		$db = new mysql();
		$db->inserir("classificados_pedidos", array(
			"codigo"=>$codigo,
			"cadastro"=>$this->_cod_usuario,
			"plano"=>$plano,
			"plano_titulo"=>$data_plano->titulo,
			"plano_valor"=>$data_plano->valor,
			"plano_periodo_meses"=>$data_plano->meses,
			"plano_periodo_dias"=>$data_plano->dias,
			"plano_limite"=>$data_plano->limite,
			"data"=>$time,
			"status"=>0
		));

		$id_pedido = $db->ultimo_id();

		$valores = new model_valores();

		$conexao = new mysql();
		$coisas_pagamento = $conexao->Executar("SELECT * FROM pagamento WHERE id='3' ");
		$data_pagamento = $coisas_pagamento->fetch_object();

		$enderecoderetorno = DOMINIO."index/classificados_cliente/pagamento/".$codigo."/";
		$enderecoderetorno_sucesso = DOMINIO."index/classificados_cliente/pagamento/".$codigo."/";

		require_once('vendor/autoload.php');

		MercadoPago\SDK::setClientId($data_pagamento->mercadopago_client_id);
		MercadoPago\SDK::setClientSecret($data_pagamento->mercadopago_client_secret);
		MercadoPago\SDK::setAccessToken($data_pagamento->mercadopago_access_token);
		//$data_pagamento->mercadopago_public_key

		$preference = new MercadoPago\Preference();

		$valor_tratado_mp = str_replace(".", "", $valores->trata_valor($data_plano->valor));
		$valor_tratado_mp = str_replace(",", ".", $valor_tratado_mp);

		$item = new MercadoPago\Item();
		$item->title = "Pedido ".$id_pedido;
		$item->quantity = 1;
		$item->unit_price = $valor_tratado_mp;
		$preference->items = array($item);
		$preference->external_reference = $codigo;
		$preference->back_urls = array(
			"success" => "$enderecoderetorno_sucesso",
			"failure" => "$enderecoderetorno",
			"pending" => "$enderecoderetorno_sucesso"
		);
		$preference->auto_return = "all";
		$preference->notification_url = DOMINIO."sistema/mercadopago_retorno/index.php";					 
		$preference->save();

		if($preference->id){

			$codigo_transacao = $preference->id;

			$conexao = new mysql();
			$conexao->alterar("classificados_pedidos", array(				
				"status"=>1,
				"id_transacao"=>$codigo_transacao
			), " codigo='".$codigo."' ");

			$this->irpara(DOMINIO.'index/classificados_cliente/pagamento/'.$codigo);

		} else {
			echo "Ocorreu um erro!";
			exit;
		}

	}

	public function classificados_ativar_anuncio_grv(){

		$this->autenticado();

		$dados = array();
		$dados['_base'] = $this->_base();


		$codigo_anuncio = $this->post('anuncio');

		if(!$codigo_anuncio){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$plano = $this->post('plano');

		if(!$plano){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados WHERE codigo='$codigo_anuncio' AND cadastro='".$this->_cod_usuario."'  ");
		if($exec->num_rows != 1){
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$data_anuncio = $exec->fetch_object();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM classificados_pedidos WHERE codigo='$plano' ");
		if($exec->num_rows != 1){

			if($plano == 1){

				$cadastro = new model_cadastro();
				$data_dados = $cadastro->dados_usuario($this->_cod_usuario);
				if($data_dados->anuncio_gratis == 0){

					$plano = $this->gera_codigo();

					$db = new mysql();
					$exec2 = $db->executar("SELECT * FROM classificados_planos WHERE codigo='1' ");
					$data_plano2 = $exec2->fetch_object();
					$time = time();

					$db = new mysql();
					$db->inserir("classificados_pedidos", array(
						"codigo"=>$plano,
						"cadastro"=>$this->_cod_usuario,
						"plano"=>1,
						"plano_titulo"=>'Gratis',
						"plano_valor"=>0,
						"plano_periodo_meses"=>$data_plano2->meses,
						"plano_periodo_dias"=>$data_plano2->dias,
						"plano_limite"=>$data_plano2->limite,
						"data"=>$time,
						"status"=>2
					));

					$db = new mysql();
					$db->alterar("cadastro", array(
						"anuncio_gratis"=>1
					), " codigo='".$this->_cod_usuario."' ");

					$db = new mysql();
					$exec = $db->executar("SELECT * FROM classificados_pedidos WHERE codigo='$plano' ");

				}

			} else {

				$this->irpara(DOMINIO.'index/classificados_cliente');
				exit;
			}
		}

		$data_plano = $exec->fetch_object();		

		$plano_utilizado = $data_plano->plano_utilizado + 1;

		if($plano_utilizado > $data_plano->plano_limite){
			$this->msg('O plano exedeu o numero de anúncios!');
			$this->irpara(DOMINIO.'index/classificados_cliente');
			exit;
		}

		$db = new mysql();
		$db->alterar("classificados_pedidos", array(
			"plano_utilizado"=>$plano_utilizado
		), " codigo='$plano' ");

		$time = time();

		$db = new mysql();
		$db->inserir("classificados_pedidos_utilizacoes", array(
			"pedido"=>$plano,
			"data"=>$time,
			"anuncio"=>$codigo_anuncio,
			"anuncio_ref"=>$data_anuncio->id
		));

		if($data_plano->plano_periodo_meses == 0){
			$vencimento = strtotime('+ '.$data_plano->plano_periodo_dias.' days');
		} else {
			$vencimento = strtotime('+ '.$data_plano->plano_periodo_meses.' months');
		}

		$db = new mysql();
		$db->alterar("classificados",  array(
			"anuncio_vencimento"=>$vencimento
		), " id='$data_anuncio->id' ");


		$this->irpara(DOMINIO.'index/classificados_cliente');
	}

	public function cookies_aceitar(){
		$_SESSION['cookies'] = 'sim';
		echo "ok";
	}

}