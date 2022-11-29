<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }
// ini_set(display_errors, 1);
// error_reporting(E_ALL);
$cores = $conteudo_sessao['cores']['lista'];
$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);
$paginacao = $conteudo_sessao['paginacao'];
$banner = $layout_lista[0]['coluna1']['conteudo']['data_topo']->fundo;
$link_banner = $layout_lista[0]['coluna1']['conteudo']['data_topo']->link_banner;
$categoria_selecionada = $conteudo_sessao['categoria_selecionada'];
$marca_selecionada = $conteudo_sessao['marca_selecionada'];
$banners_esquerda = $banners_esquerda;
$banners_direita = $banners_direita;
$ordem = $conteudo_sessao['ordem'];

?>
<style type="text/css">
	.owl-theme .owl-dots .owl-dot span {	
		width: 10px;
		height: 10px;
		margin: 5px 7px;
		background: #D6D6D6;
		display: block;
		-webkit-backface-visibility: visible;
		transition: opacity .2s ease;
		border-radius: 30px;
	}
	.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
		background: #869791;
	}
	.owl-theme .owl-dots, .owl-theme .owl-nav {
		text-align: center;
		-webkit-tap-highlight-color: transparent;
		margin-top: 20px;

	}
	a.botao_padrao{
		background-color: <?=$primaria?> !important;
	}
	.botao_padrao:hover {
    	background-color: <?=$secundaria?> !important;
		color: #fff !important;
	}

	.botao_comprar {
    	background-color: <?=$primaria?>;
	}
	.points, .yellow_points{
    	color:<?=$secundaria?>
	}
	.laranja_points{
		background: <?=$secundaria?> !important;
		padding: 4px 8px;
		font-size: 10px;
		border-radius: 4px;
		margin-left: 6px;
	}
	#categorias, #autor{
		border: 1px #2C3E50 solid;
		border-radius: 4px !important;
		color: #2C3E50;
		background: white;
		margin-bottom:10px
	}

	.produtos_item_destaque_<?=$conteudo_id?> .produto_devalor_lista{
		padding-top:3px;
		color: <?=$cores['106']?> !important;
		font-size:13px;
		text-decoration:line-through;
		text-align:center;
	}
	.produtos_item_destaque_<?=$conteudo_id?> .produto_porvalor_lista{ 
		color: <?=$cores['107']?> !important;
		text-align: center;
	}
	.produtos_item_destaque_<?=$conteudo_id?> a.indisponivel{ 
	}
	.produtos_item_destaque_<?=$conteudo_id?> a.bt_comprar_lista{ 
	}
	.produtos_item_destaque_<?=$conteudo_id?> a.bt_comprar_lista i{

	}
	ul {
        padding: 0;
	}
	.pontuacao {
		font-size: 16px;
		margin-bottom: 0px;
		margin-left: 8px;
		margin-top: 10px;
		font-family: roboto;
		font-weight: 300;
	}
	ul li{
		padding-bottom: 8px;
	}
	@media (min-width: 1200px){
        .container {
            width: 97%;
        }
    }
	.container-fluid{
		background-color: #f9f9f9;
	}
	#e1,#e2,#e3,#e4,#e5{
		color:#ECECEC;
		cursor: pointer;
	}
	.sec_color{
		color: <?=$secundaria?> !important;
	}
</style>
<a href="<?=$link_banner?>" style="cursor:pointer">
	<div class="jumbotron banner_canal" style="background-image: url(<?=DOMINIO."arquivos/imagens/".$banner?>);">
		<div class="container" style="width: 80%;padding-top: 40px;">
		</div>
	</div> 
</a>
<div class="et_pb_bottom_inside_divider"></div>
<div id="section-produtos-<?=$conteudo_id?>" class="container-fluid animate" style="width:100%; padding-top:10px; padding-bottom:10px; background-color: #f9f9f9;">
	<?php if($conteudo_config->mostrar_titulo == 1){ ?>
		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div>
					<h2 class="titulo_padrao" style="color:<?=$cores[49]?> !important; border-color:<?=$cores[49]?> !important; " ><?=$conteudo_config->titulo?></h2>
					<div class="titulo_padrao_linha" style="color:<?=$cores[49]?>; " ></div> 
				</div>
			</div>
		</div>
	<?php } ?>

	<div style="width: 100%; padding-top:-10px;"></div>
	<div class="row">
		<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
			<br>
			<form action="<?=DOMINIO?><?=$controller?>/" method="POST" style="margin-top: 5px;">
				<div class="row" style="background-color: #f9f9f9;">
					<div class='col-xs-12 col-sm-3 col-md-3 sm-1ak'>
						<select name="categoria" id="categorias">
							<option value="0">Todas</option>
							<?php foreach ($categorias as $cat){ ?>
							<option value="<?=$cat['id']?>" <?php echo ($cat_selecionada ==  $cat['id'] ? 'selected' : '') ?>><?=$cat['titulo']?></option>
							<?php } ?>
						</select>
					</div>
					<div class='col-xs-12 col-sm-3 col-md-3 sm-1ak'>
						<select name="autor" id="autor">
							<option value="0">Todos</option>
							<?php foreach ($autores as $autor){ ?>
							<option value="<?=$autor['id']?>" <?php echo ($autor_selecionado ==  $autor['id'] ? 'selected' : '' )?>><?=$autor['nome']?></option>
							<?php } ?>
						</select>
					</div>
					<div class='col-xs-12 col-sm-3 col-md-2 sm-2ak centralizar_mobile'>
						Qualificação:
							<i id="e1" class="fas fa-star i_star"></i>
							<i id="e2" class="fas fa-star i_star"></i>
							<i id="e3" class="fas fa-star i_star"></i>
							<i id="e4" class="fas fa-star i_star"></i>
							<i id="e5" class="fas fa-star i_star"></i>
							<input type="hidden" id="estrelas" name="estrelas" class="buscar_input">
					</div>
					<div class='col-xs-12 col-sm-3 col-md-4 sm-3ak centralizar_mobile'>
						Buscar
						<input type="text" name="buscar1" class="buscar_input" value="<?=$buscar_campo?>">
						<button class="filtrar_bntn desk_menu" type="submit">
							FILTRAR
						</button>
					</div>
				</div>
				<div class="row mobile_menu">
					<div class='col-xs-6 col-sm-6 col-md-6 sm-3ak centralizar_mobile'>
						<button class="filtrar_bntn" type="submit">
							FILTRAR
						</button>
					</div>
					<div class='col-xs-6 col-sm-6 col-md-6 sm-3ak centralizar_mobile'>
						<a href="<?=DOMINIO?>" class="limpar_filtrar_bntn">LIMPAR FILTRO</a>
					</div>
				</div>
				<a href="<?=DOMINIO?>" class="limpar_filtrar_bntn desk_menu">LIMPAR FILTRO</a>
			</form>
		</div>  
				<?php
			if($conteudo_config->formato == 1){
				if(isset($lista_comprados) and (count($lista_comprados) > 0)){
					
							echo '
							<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
								<div class="content flex-row-fluid" id="kt_content">
									<div class="row gy-5 g-xl-8">
										<div class="col-xl-12">
											<h3 style="font-size: 18px;padding: 10px 0px;color: #334555;">Meus Cursos</h3>
											<div class="card card-xl-stretch mb-5 mb-xl-8">
												<div class="container_flex snaps-inline owl-carousel owl-theme">';
												foreach($lista_comprados as $key => $value){
													// echo'<pre>';print_r($canal);exit;						
													$itens_listados = 1;
													$n_row = 1;
													// foreach ($canal as $key => $value) {
															$conexao = new mysql();
															$cursos = new model_cursos();
															$exec = mysqli_query($conexao,"SELECT cursos.* 
																								FROM `cursos` 
																								inner join curso_produto on cursos.id = curso_produto.id_curso
																								where curso_produto.id_produto = '$value->id' ");

															$list_id = null;
															foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur){
																if($key == 0){
																	$list_id = $lista_cur['id'];
																}else{
																	$list_id = $list_id.','.$lista_cur['id'];
																}
															}
															// $data_id = 	$exec->fetch_all(MYSQLI_ASSOC)[0]['id'];
															// $this->p($data_id);
															
															$exec2 = mysqli_query($conexao,"SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
															$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];
															
															$exec3 = mysqli_query($conexao,"SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
															$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
															
															$tags = mysqli_query($conexao,"SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
															$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);

															// echo'<pre>';print_r($tags_cat);
															
															$curso_conteudo = $cursos->curso_conteudo_varios($list_id);

															$total_aulas = 0;
															$seconds = 0;
															foreach($curso_conteudo as $row){
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
															$valor_principal = explode(".",$value->valor);
															if(strlen($valor_principal[1]) == 1){
																$valor_principal[1] = $valor_principal[1].'0';
															}

															// echo'<pre>';print_r($total_minutos);exit;

															$media_estrelas = number_format($media_estrelas, 1, '.', '');
															$qtd_cursos = mysqli_num_rows($exec);

														if( ($itens_listados <= $conteudo_config->max_itens) OR ($conteudo_config->max_itens == 0) ){
															if($value->ref){
																$ref = $value->ref." - ";
															} else {
																$ref = "";
															}
															if($value->imagem){
																$imagem = $value->imagem;
															} else {
																$imagem = LAYOUT."img/semimagem.png";
															}
															$esconder_valor = false;
															if($value->esconder_valor == 1){
																if(!$_cod_usuario){
																	$esconder_valor = true;
																}
															}
															$endereco = DOMINIO.$controller."/produto/id/".$value->id."/";
															$endereco_img = DOMINIO."/arquivos/img_produtos_g/".$value->codigo."/";
															
															$botao_comprar = str_replace("aquivaiolink", " href='".$endereco."' ", $conteudo_sessao->botao);
															?>
															
															<div class="item">
																	<div class="grid1">
																		<div style="position:relative">
																			<a href="<?=$endereco?>">
																			<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
																				<div class="img_card_" style="background-image: url(<?=$endereco_img.$imagem?>);"></div>
																			</a>                        
																		</div>
																	<div class="tag_porcent">
																			<div>
																				<?php if(isset($tags_cat)){ ?>
																					<?php foreach($tags_cat as $key => $cat){?>
																						<span style="background: <?=$cat['cor_fundo']?> !important;color: <?=$cat['cor_texto']?> !important;"class="<?=$key == 0 ? '': 'tag2'?>"><?=$cat['titulo']?></span>
																					<?php } ?>
																				<?php } ?>
																				<span class="laranja_points">
																					<i class="fas fa-star" style="color:white"></i>
																					<span class="points" style="color:white"><?=$media_estrelas?></span> 
																				</span>
																			</div>
																			<div></div>
																		</div>
																		<div class="desc_text">
																			<div class="name-author all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>"><?=$value->titulo?></a>
																			</div>
																			<p style="line-height: 16px;font-size:12px">
																				<a style="color: #7F7F7F;" href="<?=$endereco?>">
																					<?php
																						if($value->assinatura ==1 ){
																							echo 'Assinatura';
																						}else{echo 'Conteúdo único';}
																					?>
																				</a>
																			</p>
																			<div class="name-author_ all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>">Autor: <?=$value->autor_nome?></a>
																			</div>
																		</div>
																		<div class="pontuacao">
																			<ul>
																				<li><i class="fas fa-graduation-cap"></i> <?=$qtd_cursos?> cursos</li>
																				<li><i class="fas fa-clock"></i> <?=$total_minutos?></li>
																				<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
																				<li><i class="fas fa-redo"></i> Última atualização em <?=date('d/m/Y', $value->data_atualizacao);?></li>
																			</ul>
																			<?php if($media_estrelas == 22){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			} elseif($media_estrelas == 33){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 44){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 55){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}
																			elseif($media_estrelas == 66){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																			}
																			?>
																		</div>
																		<?php if($value->valor_falso > 0){ ?>
																			<div class="price_container">
																				<p class="preco_desc">R$ <?=number_format($value->valor_falso,2,",",".")?></p>
																				<p class="preco_list_indi">
																					<span class="real">R$ </span>
																					<span class="price_card"> <?=$valor_principal[0]?> </span>
																					<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																				</p>
																				</div>
																				<?php }elseif($value->valor > 0){ ?>
																					<p class="preco_list">
																						<span class="real">R$ </span>
																						<span class="price_card"> <?=$valor_principal[0]?> </span>
																						<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																					</p>
																				<?php }else{ ?>
																				<p class="preco_list">Gratuito</p>
																		<?php } ?>
																		<div class="bottom_card">
																			<div><a href="<?=$endereco?>" onclick="acessando(this);"><p class="saibamais_btn">SAIBA MAIS</p></a></div>
																			<!-- <div><a href="<?=$endereco?>" onclick="acessando(this);" class="botao_comprar"><?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?></a></div> -->
																			<div id="div_comprar">
																				<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >
																					<span>                                     
																						<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
																							<?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?>
																						</button>
																						<input type="hidden" name="produto" value="<?=$value->codigo?>">
																					</span>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
														<?php }
														$itens_listados++;
													}		
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						if($n_row != 1){ echo "</div>"; }
					
				}
			}	

		?>
		<?php
			if($conteudo_config->formato == 1){
				if(isset($combos) and (count($combos) > 0)){
					echo '<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile"><div class="content flex-row-fluid" id="kt_content"><div class="row gy-5 g-xl-8"><div class="col-xl-12"><h3 style="font-size: 18px;padding: 10px 0px;color: #334555;">Combos</h3><div class="card card-xl-stretch mb-5 mb-xl-8"><div class="container_flex snaps-inline owl-carousel owl-theme">';
						foreach($combos as $key => $value){
							$i_combo = 0;$valor_principal_=0;$qtd_cursos_ = null;$media_estrelas_ = null;$hours_ = null;$minutes_ = null;$seconds_ = null;$data_atualizacao_ = null;$tags_cat_ = array();
							
							$codigo_produtos_carrinho = array();
							foreach ($value['produtos'] as $key => $value) {
								array_push($codigo_produtos_carrinho,$value->codigo);
								$conexao = new mysql();
								$cursos = new model_cursos();
								$exec = mysqli_query($conexao,"SELECT cursos.* 
																	FROM `cursos` 
																	inner join curso_produto on cursos.id = curso_produto.id_curso
																	where curso_produto.id_produto = '$value->id' ");

								$list_id = null;
								foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur){
									if($key == 0){
										$list_id = $lista_cur['id'];
									}else{
										$list_id = $list_id.','.$lista_cur['id'];
									}
								}
								$exec2 = mysqli_query($conexao,"SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
								$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];
								
								$exec3 = mysqli_query($conexao,"SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
								$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
								
								$tags = mysqli_query($conexao,"SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
								$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);
								
								$curso_conteudo = $cursos->curso_conteudo_varios($list_id);
								$total_aulas = 0;
								$seconds = 0;
								foreach($curso_conteudo as $row){
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
								
								$qtd_cursos = mysqli_num_rows($exec);
								
								$qtd_cursos_ 		+= $qtd_cursos;
								$media_estrelas_ 	+= $media_estrelas;
								$hours_				+= $hours;
								$minutes_ 			+= $minutes;
								$seconds_ 			+= $seconds;
								if($data_atualizacao_ < $value->data_atualizacao){
									$data_atualizacao_ = $value->data_atualizacao;
								}
								$valor_principal_ += $value->valor;

								$i_combo++;
							}
							$valor_principal_full = $valor_principal_;

							if($value->combo_desconto > 0){
								$valor_descontado = $valor_principal_full - ($valor_principal_full / 100 * $value->combo_desconto);
							}
							$valor_descontado = explode(".",$valor_descontado);
							if(strlen($valor_descontado[1]) == 1){
								$valor_descontado[1] = $valor_descontado[1].'0';
							}
							if($hours_ > 0 ){$hours_ = $hours_.'hrs ';}else{$hours_ = '';};
							if($minutes_ > 0 ){$minutes_ = $minutes_.'min ';}else{$minutes_ = '';};
							if($seconds_ > 0 ){$seconds_ = $seconds_.'seg ';}else{$seconds_ = '';};
							
							$total_minutos = $hours_.' '.$minutes_.' '.$seconds_;
							$media_estrelas_final = number_format((($media_estrelas_)/$i_combo), 1, '.', '');
							$saiba_mais = DOMINIO.$controller.'/combo_trilhas/id/'.$value->combo_id;
							?>
							<div class="item">
								<div class="grid1">
									<div style="position:relative">
										<a href="<?=$saiba_mais?>">
											<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
											<div class="img_card_" style="background-image: url(<?=DOMINIO?><?="arquivos/img_combos_g/".$value->combo_id."/".$value->combo_banner?>);"></div>
										</a>                        
									</div>
									<div class="tag_porcent">
										<div>
											<?php if(isset($tags_cat)){ ?>
												<?php foreach($tags_cat as $key => $cat){?>
													<span style="background: <?=$cat['cor_fundo']?> !important;color: <?=$cat['cor_texto']?> !important;"class="<?=$key == 0 ? '': 'tag2'?>"><?=$cat['titulo']?></span>
												<?php } ?>
											<?php } ?>
											<span class="laranja_points">
												<i class="fas fa-star" style="color:white"></i>
												<span class="points" style="color:white"><?=$media_estrelas_final?></span> 
											</span>
										</div>
										<div></div>
									</div>
									<div class="desc_text">
										<div class="name-author all">
											<a style="color: #2C3E50;" href="<?=$saiba_mais?>"><?=$value->combo_titulo?></a>
										</div>
										<p style="line-height: 16px;font-size:12px">
											<a style="color: #7F7F7F;" href="<?=$saiba_mais?>">
												<?php
													if($value->assinatura ==1 ){
														echo 'Assinatura';
													}else{echo 'Conteúdo único';}
												?>
											</a>
										</p>
										<div class="name-author_ all">
											<!-- <a style="color: #2C3E50;" href="<?=$endereco?>">Autor: <?=$value->autor_nome?></a> -->
										</div>
									</div>
									<div class="pontuacao">
										<ul>
											<li><i class="fas fa-graduation-cap"></i> <?=$qtd_cursos_?> cursos</li>
											<li><i class="fas fa-clock"></i> <?=$total_minutos?></li>
											<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
											<li><i class="fas fa-redo"></i> Última atualização em <?=date('d/m/Y', $data_atualizacao_);?></li>
										</ul>
										<?php if($media_estrelas_final == 22){
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif($media_estrelas_final == 33){
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										}elseif($media_estrelas_final == 44){
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										}elseif($media_estrelas_final == 55){
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										}
										elseif($media_estrelas_final == 66){
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
										}
										?>
									</div>

									<div class="price_container">
										<p class="preco_desc">R$ <?=number_format($valor_principal_full,2,",",".")?></p>
										<p class="preco_list_indi">
											<span class="real">R$ </span>
											<span class="price_card"> <?=$valor_descontado[0]?> </span>
											<span class="virgura_price"> ,<?=($valor_descontado[1]>0 ? $valor_descontado[1]:'00')?>
										</p>
									</div>
									<!-- <?php if($value->valor_falso > 0){ ?>
											<div class="price_container">
												<p class="preco_desc">R$ <?=number_format($valor_descontado[1],2,",",".")?></p>
												<p class="preco_list_indi">
													<span class="real">R$ </span>
													<span class="price_card"> <?=$valor_descontado[0]?> </span>
													<span class="virgura_price"> ,<?=($valor_descontado[1]>0 ? $valor_descontado[1]:'00')?>
												</p>
											</div>
											<?php }elseif($value->valor > 0){ ?>
												<p class="preco_list">
													<span class="real">R$ </span>
													<span class="price_card"> <?=$valor_descontado[0]?> </span>
													<span class="virgura_price"> ,<?=($valor_descontado[1]>0 ? $valor_descontado[1]:'00')?>
												</p>
											<?php }else{ ?>
											<p class="preco_list">Gratuito</p>
									<?php } ?> -->
									<div class="bottom_card">
										<div><a href="<?=$saiba_mais?>" onclick="acessando(this);"><p class="saibamais_btn">SAIBA MAIS</p></a></div>
										<div id="div_comprar">
											<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >
												<span>                                     
													<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
														<?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?>
													</button>
													<?php foreach($codigo_produtos_carrinho as $prod){ ?>
														<input type="hidden" name="produto[]" value="<?=$prod?>">
														<?php } ?>
														<input type="hidden" name="combo_disconto" value="<?=$value->combo_desconto?>">
														<input type="hidden" name="combo_id" value="<?=$value->combo_id?>">
														<input type="hidden" name="combo_titulo" value="<?=$value->combo_titulo?>">
														<input type="text" name="plano_id" value="<?=$value->plano_id?>">
												</span>
											</form>
										</div>
									</div>
								</div>
							</div>
							<?php 
						}
					echo '</div>';echo '</div>';echo '</div>';echo '</div>';echo '</div>';echo '</div>';
				}
			}	

		?>
		<?php
			if($conteudo_config->formato == 1){
				if(isset($lista_canal_novidades) and (count($lista_canal_novidades) > 0)){
					foreach($lista_canal_novidades as $key => $canal){
						// echo'<pre>';print_r($canal);exit;						
						$itens_listados = 1;
						$n_row = 1;
						echo '
							<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
								<div class="content flex-row-fluid" id="kt_content">
									<div class="row gy-5 g-xl-8">
										<div class="col-xl-12">
											<h3 style="font-size: 18px;padding: 10px 0px;color: #334555;">Novidades</h3>
											<div class="card card-xl-stretch mb-5 mb-xl-8">
												<div class="container_flex snaps-inline owl-carousel owl-theme">';
													foreach ($canal as $key => $value) {
														// echo'<pre>';print_r($value);exit;
														$conexao = new mysql();
															$cursos = new model_cursos();
															$exec = mysqli_query($conexao,"SELECT cursos.* 
																								FROM `cursos` 
																								inner join curso_produto on cursos.id = curso_produto.id_curso
																								where curso_produto.id_produto = '$value->id' ");

															$list_id = null;
															foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur){
																if($key == 0){
																	$list_id = $lista_cur['id'];
																}else{
																	$list_id = $list_id.','.$lista_cur['id'];
																}
															}
															
															$data_id = 	$exec->fetch_all(MYSQLI_ASSOC)[0]['id'];
															
															$exec2 = mysqli_query($conexao,"SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
															$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];
															
															$exec3 = mysqli_query($conexao,"SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
															$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
															
															$tags = mysqli_query($conexao,"SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
															$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);
															
															$curso_conteudo = $cursos->curso_conteudo_varios($list_id);

															$total_aulas = 0;
															$seconds = 0;
															foreach($curso_conteudo as $row){
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
															$valor_principal = explode(".",$value->valor);

															if(strlen($valor_principal[1]) == 1){
																$valor_principal[1] = $valor_principal[1].'0';
															}

															$media_estrelas = number_format($media_estrelas, 1, '.', '');
															$qtd_cursos = mysqli_num_rows($exec);

														if( ($itens_listados <= $conteudo_config->max_itens) OR ($conteudo_config->max_itens == 0) ){
															if($value->ref){
																$ref = $value->ref." - ";
															} else {
																$ref = "";
															}
															if($value->imagem){
																$imagem = $value->imagem;
															} else {
																$imagem = LAYOUT."img/semimagem.png";
															}
															$esconder_valor = false;
															if($value->esconder_valor == 1){
																if(!$_cod_usuario){
																	$esconder_valor = true;
																}
															}
															$endereco = DOMINIO.$controller."/produto/id/".$value->id."/";
															$endereco_img = DOMINIO."/arquivos/img_produtos_g/".$value->codigo."/";
															
															$botao_comprar = str_replace("aquivaiolink", " href='".$endereco."' ", $conteudo_sessao->botao);
															?>
															
															<div class="item">
																<div class="grid1">
																	<div style="position:relative">
																		<a href="<?=$endereco?>">
																		<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
																			<div class="img_card_" style="background-image: url(<?=$endereco_img.$imagem?>);"></div>
																		</a>                        
																	</div>
																	<div class="tag_porcent">
																		<div>
																			<?php if(isset($tags_cat)){ ?>
																				<?php foreach($tags_cat as $key => $cat){?>
																					<span style="background: <?=$cat['cor_fundo']?> !important;color: <?=$cat['cor_texto']?> !important;"class="<?=$key == 0 ? '': 'tag2'?>"><?=$cat['titulo']?></span>
																				<?php } ?>
																			<?php } ?>
																			<span class="laranja_points">
																				<i class="fas fa-star" style="color:white"></i>
																				<span class="points" style="color:white"><?=$media_estrelas?></span> 
																			</span>
																		</div>
																		<div></div>
																	</div>
																	<div class="desc_text">
																		<div class="name-author all">
																			<a style="color: #2C3E50;" href="<?=$endereco?>"><?=$value->titulo?></a>
																		</div>
																		<p style="line-height: 16px;font-size:12px">
																			<a style="color: #7F7F7F;" href="<?=$endereco?>">
																				<?php
																					if($value->assinatura ==1 ){
																						echo 'Assinatura';
																					}else{echo 'Conteúdo único';}
																				?>
																			</a>
																		</p>
																		<div class="name-author_ all">
																			<a style="color: #2C3E50;" href="<?=$endereco?>">Autor: <?=$value->autor_nome?></a>
																		</div>
																	</div>
																	<div class="pontuacao">
																		<ul>
																			<li><i class="fas fa-graduation-cap"></i> <?=$qtd_cursos?> cursos</li>
																			<li><i class="fas fa-clock"></i> <?=$total_minutos?></li>
																			<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
																			<li><i class="fas fa-redo"></i> Última atualização em <?=date('d/m/Y', $value->data_atualizacao);?></li>
																		</ul>
																		<?php if($media_estrelas == 22){
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																		} elseif($media_estrelas == 33){
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																		}elseif($media_estrelas == 44){
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																		}elseif($media_estrelas == 55){
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="far fa-star i_star"></i>';
																		}
																		elseif($media_estrelas == 66){
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																			echo '<i class="fas fa-star i_star"></i>';
																		}
																		?>
																	</div>
																	<?php if($value->valor_falso > 0){ ?>
																		<div class="price_container">
																			<p class="preco_desc">R$ <?=number_format($value->valor_falso,2,",",".")?></p>
																			<p class="preco_list_indi">
																				<span class="real">R$ </span>
																				<span class="price_card"> <?=$valor_principal[0]?> </span>
																				<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																			</p>
																			</div>
																			<?php }elseif($value->valor > 0){ ?>
																				<p class="preco_list">
																					<span class="real">R$ </span>
																					<span class="price_card"> <?=$valor_principal[0]?> </span>
																					<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																				</p>
																			<?php }else{ ?>
																			<p class="preco_list">Gratuito</p>
																	<?php } ?>
																	<div class="bottom_card">
																		<div><a href="<?=$endereco?>" onclick="acessando(this);"><p class="saibamais_btn">SAIBA MAIS</p></a></div>
																		<!-- <div><a href="<?=$endereco?>" onclick="acessando(this);" class="botao_comprar"><?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?></a></div> -->
																		<div id="div_comprar">
																			<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >
																				<span>                                     
																					<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
																						<?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?>
																					</button>
																					<input type="hidden" name="produto" value="<?=$value->codigo?>">
																				</span>
																			</form>
																		</div>
																	</div>
																</div>
															</div>
														<?php }
														$itens_listados++;
													}		
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						if($n_row != 1){ echo "</div>"; }
					}
				}
			}	
		?>
		<?php
			if($conteudo_config->formato == 1){
				if(isset($lista_canal_mais_vendidos) and (count($lista_canal_mais_vendidos) > 0)){
					foreach($lista_canal_mais_vendidos as $key => $canal){
						// echo'<pre>';print_r($canal);exit;						
						$itens_listados = 1;
						$n_row = 1;
							echo '
							<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
								<div class="content flex-row-fluid" id="kt_content">
									<div class="row gy-5 g-xl-8">
										<div class="col-xl-12">
											<h3 style="font-size: 18px;padding: 10px 0px;color: #334555;">Mais Vendidos</h3>
											<div class="card card-xl-stretch mb-5 mb-xl-8">
												<div class="container_flex snaps-inline owl-carousel owl-theme">';
													foreach ($canal as $key => $value) {
															$conexao = new mysql();
															$cursos = new model_cursos();
															$exec = mysqli_query($conexao,"SELECT cursos.* 
																								FROM `cursos` 
																								inner join curso_produto on cursos.id = curso_produto.id_curso
																								where curso_produto.id_produto = '$value->id' ");

															$list_id = null;
															foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur){
																if($key == 0){
																	$list_id = $lista_cur['id'];
																}else{
																	$list_id = $list_id.','.$lista_cur['id'];
																}
															}
															
															$data_id = 	$exec->fetch_all(MYSQLI_ASSOC)[0]['id'];
															
															$exec2 = mysqli_query($conexao,"SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
															$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];
															
															$exec3 = mysqli_query($conexao,"SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
															$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
															
															$tags = mysqli_query($conexao,"SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
															$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);

															// echo'<pre>';print_r($tags_cat);
															
															$curso_conteudo = $cursos->curso_conteudo_varios($list_id);

															$total_aulas = 0;
															$seconds = 0;
															foreach($curso_conteudo as $row){
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
															$valor_principal = explode(".",$value->valor);
															if(strlen($valor_principal[1]) == 1){
																$valor_principal[1] = $valor_principal[1].'0';
															}

															// echo'<pre>';print_r($total_minutos);exit;

															$media_estrelas = number_format($media_estrelas, 1, '.', '');
															$qtd_cursos = mysqli_num_rows($exec);

														if( ($itens_listados <= $conteudo_config->max_itens) OR ($conteudo_config->max_itens == 0) ){
															if($value->ref){
																$ref = $value->ref." - ";
															} else {
																$ref = "";
															}
															if($value->imagem){
																$imagem = $value->imagem;
															} else {
																$imagem = LAYOUT."img/semimagem.png";
															}
															$esconder_valor = false;
															if($value->esconder_valor == 1){
																if(!$_cod_usuario){
																	$esconder_valor = true;
																}
															}
															$endereco = DOMINIO.$controller."/produto/id/".$value->id."/";
															$endereco_img = DOMINIO."/arquivos/img_produtos_g/".$value->codigo."/";
															
															$botao_comprar = str_replace("aquivaiolink", " href='".$endereco."' ", $conteudo_sessao->botao);
															?>
															
															<div class="item">
																	<div class="grid1">
																		<div style="position:relative">
																			<a href="<?=$endereco?>">
																			<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
																				<div class="img_card_" style="background-image: url(<?=$endereco_img.$imagem?>);"></div>
																			</a>                        
																		</div>
																	<div class="tag_porcent">
																			<div>
																				<?php if(isset($tags_cat)){ ?>
																					<?php foreach($tags_cat as $key => $cat){?>
																						<span style="background: <?=$cat['cor_fundo']?> !important;color: <?=$cat['cor_texto']?> !important;"class="<?=$key == 0 ? '': 'tag2'?>"><?=$cat['titulo']?></span>
																					<?php } ?>
																				<?php } ?>
																				<span class="laranja_points">
																					<i class="fas fa-star" style="color:white"></i>
																					<span class="points" style="color:white"><?=$media_estrelas?></span> 
																				</span>
																			</div>
																			<div></div>
																		</div>
																		<div class="desc_text">
																			<div class="name-author all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>"><?=$value->titulo?></a>
																			</div>
																			<p style="line-height: 16px;font-size:12px">
																				<a style="color: #7F7F7F;" href="<?=$endereco?>">
																					<?php
																						if($value->assinatura ==1 ){
																							echo 'Assinatura';
																						}else{echo 'Conteúdo único';}
																					?>
																				</a>
																			</p>
																			<div class="name-author_ all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>">Autor: <?=$value->autor_nome?></a>
																			</div>
																		</div>
																		<div class="pontuacao">
																			<ul>
																				<li><i class="fas fa-graduation-cap"></i> <?=$qtd_cursos?> cursos</li>
																				<li><i class="fas fa-clock"></i> <?=$total_minutos?></li>
																				<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
																				<li><i class="fas fa-redo"></i> Última atualização em <?=date('d/m/Y', $value->data_atualizacao);?></li>
																			</ul>
																			<?php if($media_estrelas == 22){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			} elseif($media_estrelas == 33){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 44){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 55){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}
																			elseif($media_estrelas == 66){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																			}
																			?>
																		</div>
																		<?php if($value->valor_falso > 0){ ?>
																			<div class="price_container">
																				<p class="preco_desc">R$ <?=number_format($value->valor_falso,2,",",".")?></p>
																				<p class="preco_list_indi">
																					<span class="real">R$ </span>
																					<span class="price_card"> <?=$valor_principal[0]?> </span>
																					<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																				</p>
																				</div>
																				<?php }elseif($value->valor > 0){ ?>
																					<p class="preco_list">
																						<span class="real">R$ </span>
																						<span class="price_card"> <?=$valor_principal[0]?> </span>
																						<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																					</p>
																				<?php }else{ ?>
																				<p class="preco_list">Gratuito</p>
																		<?php } ?>
																		<div class="bottom_card">
																			<div><a href="<?=$endereco?>" onclick="acessando(this);"><p class="saibamais_btn">SAIBA MAIS</p></a></div>
																			<!-- <div><a href="<?=$endereco?>" onclick="acessando(this);" class="botao_comprar"><?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?></a></div> -->
																			<div id="div_comprar">
																				<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >
																					<span>                                     
																						<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
																							<?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?>
																						</button>
																						<input type="hidden" name="produto" value="<?=$value->codigo?>">
																					</span>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
														<?php }
														$itens_listados++;
													}		
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						if($n_row != 1){ echo "</div>"; }
					}
				}
			}	
		?>
		<?php
			if($conteudo_config->formato == 1){
				if(isset($lista_canal_melhor_qualificado) and (count($lista_canal_melhor_qualificado) > 0)){
					foreach($lista_canal_melhor_qualificado as $key => $canal){
						// echo'<pre>';print_r($canal);exit;						
						$itens_listados = 1;
						$n_row = 1;
							echo '
							<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
								<div class="content flex-row-fluid" id="kt_content">
									<div class="row gy-5 g-xl-8">
										<div class="col-xl-12">
											<h3 style="font-size: 18px;padding: 10px 0px;color: #334555;">Melhor Avaliados</h3>
											<div class="card card-xl-stretch mb-5 mb-xl-8">
												<div class="container_flex snaps-inline owl-carousel owl-theme">';
													foreach ($canal as $key => $value) {
														$conexao = new mysql();
															$cursos = new model_cursos();
															$exec = mysqli_query($conexao,"SELECT cursos.* 
																								FROM `cursos` 
																								inner join curso_produto on cursos.id = curso_produto.id_curso
																								where curso_produto.id_produto = '$value->id' ");

															$list_id = null;
															foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur){
																if($key == 0){
																	$list_id = $lista_cur['id'];
																}else{
																	$list_id = $list_id.','.$lista_cur['id'];
																}
															}
															
															$data_id = 	$exec->fetch_all(MYSQLI_ASSOC)[0]['id'];
															
															$exec2 = mysqli_query($conexao,"SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
															$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];
															
															$exec3 = mysqli_query($conexao,"SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
															$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
															
															$tags = mysqli_query($conexao,"SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
															$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);

															// echo'<pre>';print_r($tags_cat);
															
															$curso_conteudo = $cursos->curso_conteudo_varios($list_id);

															$total_aulas = 0;
															$seconds = 0;
															foreach($curso_conteudo as $row){
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
															$valor_principal = explode(".",$value->valor);
															if(strlen($valor_principal[1]) == 1){
																$valor_principal[1] = $valor_principal[1].'0';
															}
															// echo'<pre>';print_r($total_minutos);exit;

															$media_estrelas = number_format($media_estrelas, 1, '.', '');
															$qtd_cursos = mysqli_num_rows($exec);

														if( ($itens_listados <= $conteudo_config->max_itens) OR ($conteudo_config->max_itens == 0) ){
															if($value->ref){
																$ref = $value->ref." - ";
															} else {
																$ref = "";
															}
															if($value->imagem){
																$imagem = $value->imagem;
															} else {
																$imagem = LAYOUT."img/semimagem.png";
															}
															$esconder_valor = false;
															if($value->esconder_valor == 1){
																if(!$_cod_usuario){
																	$esconder_valor = true;
																}
															}
															$endereco = DOMINIO.$controller."/produto/id/".$value->id."/";
															$endereco_img = DOMINIO."/arquivos/img_produtos_g/".$value->codigo."/";
															
															$botao_comprar = str_replace("aquivaiolink", " href='".$endereco."' ", $conteudo_sessao->botao);
															?>
															
															<div class="item">
																	<div class="grid1">
																		<div style="position:relative">
																			<a href="<?=$endereco?>">
																			<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
																				<div class="img_card_" style="background-image: url(<?=$endereco_img.$imagem?>);"></div>
																			</a>                        
																		</div>
																	<div class="tag_porcent">
																			<div>
																				<?php if(isset($tags_cat)){ ?>
																					<?php foreach($tags_cat as $key => $cat){?>
																						<span style="background: <?=$cat['cor_fundo']?> !important;color: <?=$cat['cor_texto']?> !important;"class="<?=$key == 0 ? '': 'tag2'?>"><?=$cat['titulo']?></span>
																					<?php } ?>
																				<?php } ?>
																				<span class="laranja_points">
																					<i class="fas fa-star" style="color:white"></i>
																					<span class="points" style="color:white"><?=$media_estrelas?></span> 
																				</span>
																			</div>
																			<div></div>
																		</div>
																		<div class="desc_text">
																			<div class="name-author all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>"><?=$value->titulo?></a>
																			</div>
																			<p style="line-height: 16px;font-size:12px">
																				<a style="color: #7F7F7F;" href="<?=$endereco?>">
																					<?php
																						if($value->assinatura ==1 ){
																							echo 'Assinatura';
																						}else{echo 'Conteúdo único';}
																					?>
																				</a>
																			</p>
																			<div class="name-author_ all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>">Autor: <?=$value->autor_nome?></a>
																			</div>
																		</div>
																		<div class="pontuacao">
																			<ul>
																				<li><i class="fas fa-graduation-cap"></i> <?=$qtd_cursos?> cursos</li>
																				<li><i class="fas fa-clock"></i> <?=$total_minutos?></li>
																				<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
																				<li><i class="fas fa-redo"></i> Última atualização em <?=date('d/m/Y', $value->data_atualizacao);?></li>
																			</ul>
																			<?php if($media_estrelas == 22){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			} elseif($media_estrelas == 33){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 44){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 55){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}
																			elseif($media_estrelas == 66){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																			}
																			?>
																		</div>
																		<?php if($value->valor_falso > 0){ ?>
																			<div class="price_container">
																				<p class="preco_desc">R$ <?=number_format($value->valor_falso,2,",",".")?></p>
																				<p class="preco_list_indi">
																					<span class="real">R$ </span>
																					<span class="price_card"> <?=$valor_principal[0]?> </span>
																					<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																				</p>
																				</div>
																				<?php }elseif($value->valor > 0){ ?>
																					<p class="preco_list">
																						<span class="real">R$ </span>
																						<span class="price_card"> <?=$valor_principal[0]?> </span>
																						<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																					</p>
																				<?php }else{ ?>
																				<p class="preco_list">Gratuito</p>
																		<?php } ?>
																		<div class="bottom_card">
																			<div><a href="<?=$endereco?>" onclick="acessando(this);"><p class="saibamais_btn">SAIBA MAIS</p></a></div>
																			<!-- <div><a href="<?=$endereco?>" onclick="acessando(this);" class="botao_comprar"><?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?></a></div> -->
																			<div id="div_comprar">
																				<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >
																					<span>                                     
																						<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
																							<?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?>
																						</button>
																						<input type="hidden" name="produto" value="<?=$value->codigo?>">
																					</span>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
														<?php }
														$itens_listados++;
													}		
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						if($n_row != 1){ echo "</div>"; }
					}
				}
			}	
		?>
		<div class="container">
			<br><br><br> 
			<div class="row" style="background-color: #f9f9f9;">
				<div class='col-xs-12 col-sm-12 col-md-12'>
					<h4>Principais categorias</h4>
					<div class="container_flex_cat_link">
						<?php
							$conexao = new mysql();
							$exec = mysqli_query($conexao,"SELECT * FROM `produto_categoria` ");
							$cat = $exec->fetch_all(MYSQLI_ASSOC);
							// print_r($cat[0]['id']);exit;
							foreach ($cat as $c){
								$endereco = DOMINIO.$controller."/cat_produto/id/".$c['id'];
						?>
							<a href="<?=$endereco?>">
								<div class="item item_cat">
									<img style="" src="<?=DOMINIO.'arquivos/p/'?><?=$c['imagem']?>" alt="">
								<p><?=$c['titulo']?></p>
								</div>
							</a>
						<?php } ?>
					</div>
				</div>
			</div>
			<br> <br> <br> 
		</div> 
		<?php
			$produtos_lista = $conteudo_sessao['lista'];
			// echo'<pre>';print_r($produtos_lista);exit;
			if($conteudo_config->formato == 1){
				if(isset($lista_canal) and (count($lista_canal) > 0)){
					foreach($lista_canal as $key => $canal){
						// echo'<pre>';print_r($canal);exit;						
						$itens_listados = 1;
						$n_row = 1;
							echo '
							<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
								<div class="content flex-row-fluid" id="kt_content">
									<div class="row gy-5 g-xl-8">
										<div class="col-xl-12">
											<h3 style="font-size: 18px;padding: 10px 0px;color: #334555;"><a href ="'.DOMINIO.$controller."/canais/id/".$canal[0]->id_canal.'">Canal '.$key.' </a></h3>
											<div class="card card-xl-stretch mb-5 mb-xl-8">
												<div class="container_flex snaps-inline owl-carousel owl-theme">';
													foreach ($canal as $key => $value) {
															$conexao = new mysql();
															$cursos = new model_cursos();
															$exec = mysqli_query($conexao,"SELECT cursos.* 
																								FROM `cursos` 
																								inner join curso_produto on cursos.id = curso_produto.id_curso
																								where curso_produto.id_produto = '$value->id' ");

															$list_id = null;
															foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur){
																if($key == 0){
																	$list_id = $lista_cur['id'];
																}else{
																	$list_id = $list_id.','.$lista_cur['id'];
																}
															}
															
															$data_id = 	$exec->fetch_all(MYSQLI_ASSOC)[0]['id'];
															
															$exec2 = mysqli_query($conexao,"SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
															$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];
															
															$exec3 = mysqli_query($conexao,"SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
															$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
															
															$tags = mysqli_query($conexao,"SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
															$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);

															// echo'<pre>';print_r($tags_cat);
															
															$curso_conteudo = $cursos->curso_conteudo_varios($list_id);

															$total_aulas = 0;
															$seconds = 0;
															foreach($curso_conteudo as $row){
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
															$valor_principal = explode(".",$value->valor);
															if(strlen($valor_principal[1]) == 1){
																$valor_principal[1] = $valor_principal[1].'0';
															}

															// echo'<pre>';print_r($total_minutos);exit;

															$media_estrelas = number_format($media_estrelas, 1, '.', '');
															$qtd_cursos = mysqli_num_rows($exec);

														if( ($itens_listados <= $conteudo_config->max_itens) OR ($conteudo_config->max_itens == 0) ){
															if($value->ref){
																$ref = $value->ref." - ";
															} else {
																$ref = "";
															}
															if($value->imagem){
																$imagem = $value->imagem;
															} else {
																$imagem = LAYOUT."img/semimagem.png";
															}
															$esconder_valor = false;
															if($value->esconder_valor == 1){
																if(!$_cod_usuario){
																	$esconder_valor = true;
																}
															}
															$endereco = DOMINIO.$controller."/produto/id/".$value->id."/";
															$endereco_img = DOMINIO."/arquivos/img_produtos_g/".$value->codigo."/";
															
															$botao_comprar = str_replace("aquivaiolink", " href='".$endereco."' ", $conteudo_sessao->botao);
															?>
															
															<div class="item">
																	<div class="grid1">
																		<div style="position:relative">
																			<a href="<?=$endereco?>">
																			<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
																				<div class="img_card_" style="background-image: url(<?=$endereco_img.$imagem?>);"></div>
																			</a>                        
																		</div>
																	<div class="tag_porcent">
																			<div>
																				<?php if(isset($tags_cat)){ ?>
																					<?php foreach($tags_cat as $key => $cat){?>
																						<span style="background: <?=$cat['cor_fundo']?> !important;color: <?=$cat['cor_texto']?> !important;"class="<?=$key == 0 ? '': 'tag2'?>"><?=$cat['titulo']?></span>
																					<?php } ?>
																				<?php } ?>
																				<span class="laranja_points">
																					<i class="fas fa-star" style="color:white"></i>
																					<span class="points" style="color:white"><?=$media_estrelas?></span> 
																				</span>
																			</div>
																			<div></div>
																		</div>
																		<div class="desc_text">
																			<div class="name-author all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>"><?=$value->titulo?></a>
																			</div>
																			<p style="line-height: 16px;font-size:12px">
																				<a style="color: #7F7F7F;" href="<?=$endereco?>">
																					<?php
																						if($value->assinatura ==1 ){
																							echo 'Assinatura';
																						}else{echo 'Conteúdo único';}
																					?>
																				</a>
																			</p>
																			<div class="name-author_ all">
																				<a style="color: #2C3E50;" href="<?=$endereco?>">Autor: <?=$value->autor_nome?></a>
																			</div>
																		</div>
																		<div class="pontuacao">
																			<ul>
																				<li><i class="fas fa-graduation-cap"></i> <?=$qtd_cursos?> cursos</li>
																				<li><i class="fas fa-clock"></i> <?=$total_minutos?></li>
																				<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
																				<li><i class="fas fa-redo"></i> Última atualização em <?=date('d/m/Y', $value->data_atualizacao);?></li>
																			</ul>
																			<?php if($media_estrelas == 22){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			} elseif($media_estrelas == 33){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 44){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}elseif($media_estrelas == 55){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="far fa-star i_star"></i>';
																			}
																			elseif($media_estrelas == 66){
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																				echo '<i class="fas fa-star i_star"></i>';
																			}
																			?>
																		</div>
																		<?php if($value->valor_falso > 0){ ?>
																			<div class="price_container">
																				<p class="preco_desc">R$ <?=number_format($value->valor_falso,2,",",".")?></p>
																				<p class="preco_list_indi">
																					<span class="real">R$ </span>
																					<span class="price_card"> <?=$valor_principal[0]?> </span>
																					<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																				</p>
																				</div>
																				<?php }elseif($value->valor > 0){ ?>
																					<p class="preco_list">
																						<span class="real">R$ </span>
																						<span class="price_card"> <?=$valor_principal[0]?> </span>
																						<span class="virgura_price"> ,<?=($valor_principal[1]>0 ? $valor_principal[1]:'00')?>
																					</p>
																				<?php }else{ ?>
																				<p class="preco_list">Gratuito</p>
																		<?php } ?>
																		<div class="bottom_card">
																			<div><a href="<?=$endereco?>" onclick="acessando(this);"><p class="saibamais_btn">SAIBA MAIS</p></a></div>
																			<!-- <div><a href="<?=$endereco?>" onclick="acessando(this);" class="botao_comprar"><?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?></a></div> -->
																			<div id="div_comprar">
																				<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >
																					<span>                                     
																						<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
																							<?=($value->assinatura == 1 ? 'ASSINAR':'COMPRAR')?>
																						</button>
																						<input type="hidden" name="produto" value="<?=$value->codigo?>">
																					</span>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
														<?php }
														$itens_listados++;
													}		
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						if($n_row != 1){ echo "</div>"; }
					}
				}
			}	
		?>
		<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
			<br> <br> <br> 
			<div class="content flex-row-fluid" id="kt_content">
				<div class="row gy-5 g-xl-8">
					<div class="col-xl-12">
						<h4>Canais</h4>	
						<div class="card card-xl-stretch mb-5 mb-xl-8">
							<div class="container_flex snaps-inline owl-carousel owl-theme">
								<?php
									$conexao = new mysql();
									$exec2 = mysqli_query($conexao,"SELECT * FROM `canal` ");
									$canal = $exec2->fetch_all(MYSQLI_ASSOC);
									foreach ($canal as $c){
										$id = $c['id_canal'];
										$endereco = DOMINIO.$controller."/canais/id/".$c['id_canal'];
								?>
									<a href="<?=$endereco?>">
										<div class="item item_canais" style="text-align: center;">
											<!-- <img style="height: 170px;width:170px;margin-bottom: 15px;border-radius: 170px;" src="<?=DOMINIO.'arquivos/img_canais/'.$id?>/<?=$c['profile']?>" alt=""> -->
											<div class="img_foto_" style="background-image: url(<?=DOMINIO.'arquivos/img_canais/'.$id?>/<?=$c['profile']?>);margin: 0 auto;margin-bottom: 10px;"></div>

										<p><?=$c['nm_canal']?></p>
										</div>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br> <br> <br> 
		</div>	
	</div>								
</div>
<script type="text/javascript" src="<?=LAYOUT?>js/jquery-2.2.4.min.js" ></script>
<script>
	$(document).ready(function(){
		var estrelas_campo = <?=$estrelas_campo?>;

		if(estrelas_campo == 1){$('#e1').toggleClass("sec_color");}
		if(estrelas_campo == 2){$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");}
		if(estrelas_campo == 3){$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");$('#e3').toggleClass("sec_color");}
		if(estrelas_campo == 4){$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");$('#e3').toggleClass("sec_color");$('#e4').toggleClass("sec_color");}
		if(estrelas_campo == 5){$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");$('#e3').toggleClass("sec_color");$('#e4').toggleClass("sec_color");$('#e5').toggleClass("sec_color");}

		$("#e1").click(function(){
			remove_class()
			$('#e1').toggleClass("sec_color");
			$('#estrelas').val(1);
      		e.preventDefault();
		});
		$("#e2").click(function(){
			remove_class()
			$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");
			$('#estrelas').val(2);
      		e.preventDefault();
		});
		$("#e3").click(function(){
			remove_class()
			$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");$('#e3').toggleClass("sec_color");
			$('#estrelas').val(3);
      		e.preventDefault();
		});
		$("#e4").click(function(){
			remove_class()
			$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");$('#e3').toggleClass("sec_color");$('#e4').toggleClass("sec_color");
			$('#estrelas').val(4);
      		e.preventDefault();
		});
		$("#e5").click(function(){
			remove_class()
			$('#e1').toggleClass("sec_color");$('#e2').toggleClass("sec_color");$('#e3').toggleClass("sec_color");$('#e4').toggleClass("sec_color");$('#e5').toggleClass("sec_color");
			$('#estrelas').val(5);
      		e.preventDefault();
		});
		function remove_class(){
			$('#e1').removeClass("sec_color");
			$('#e2').removeClass("sec_color");
			$('#e3').removeClass("sec_color");
			$('#e4').removeClass("sec_color");
			$('#e5').removeClass("sec_color");
		}
		var owl = $('.owl-carousel');
		owl.owlCarousel({
			margin: 10,
			loop: false,
			responsive: {
				0: {
					items: 1
				},
				550: {
					items: 2
				},
				800: {
					items: 3
				},
				1000: {
					items: 4
				},
				1400: {
					items: 4
				},
				1500: {
					items: 5
				},
				2500: {
					items: 7
				},
				4500: {
					items: 9
				}
			}
		})
		$("#categorias").change(function() {
			console.log(this.value);
		});
	});

</script>