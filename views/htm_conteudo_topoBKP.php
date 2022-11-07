<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

// echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];
$banners_topo = $conteudo_sessao['banners_topo'];

$botoes = $conteudo_sessao['botoes'];

include('htm_css_topo_'.$conteudo_sessao['data_topo']->modelo.'.php');

if($conteudo_sessao['data_topo']->busca_pagina == ''){
	$destino_busca = DOMINIO.$controller.'/buscar';
} else {
	$destino_busca = DOMINIO.$controller.'/buscar/pg/'.$conteudo_sessao['data_topo']->busca_pagina;
}

$logo_topo = PASTA_CLIENTE.'imagens/'.$conteudo_sessao['data_topo']->logo;

$fonte_topo_padrao = $conteudo_sessao['data_topo']->textos_fonte_family;
$fonte_topo_menu = $conteudo_sessao['data_topo']->menu_fonte_family;

$lista_icones = $conteudo_sessao['icones'];

?>

<style type="text/css">
	
	<?php
	if($conteudo_sessao['data_topo']->posicao == 1){
		?>
		.margemtopo{
			display: block;
		}
		<?php
	}
	?>

	#header{
		<?php

		if($conteudo_sessao['data_topo']->posicao == 0){
			?>
			position: relative !important;
			<?php
		} else {
			?>
			position: fixed !important;
			z-index: 999;
			width: 100% !important;
			<?php
		}

		if($conteudo_sessao['data_topo']->fundo){
			$fundo_topo = PASTA_CLIENTE.'imagens/'.$conteudo_sessao['data_topo']->fundo;
			?>
			background-image: url(<?=$fundo_topo?>) !important;
			background-size:cover !important;
			background-position: center !important;
			background-repeat: no-repeat !important;
			<?php
		}

		if($conteudo_sessao['data_topo']->textos_fonte_family){
			?>
			font-family: <?=$fonte_topo_padrao?> !important;
			<?php
		}

		?>
	}

	<?php
	if($conteudo_sessao['data_topo']->menu_fonte_tam){
		?>
		.mainmenu_txt{
			font-size:<?=$conteudo_sessao['data_topo']->menu_fonte_tam?>px;
		}
		<?php
	}
	?>
</style>

<?php if($conteudo_sessao['data_topo']->modelo == 1){ ?>

	<style type="text/css">
		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
	</style>

	<header id="header" >
		<div id="topo" class="header-middle" >
			<div class="container" >

				<div class="row" >

					<div class="col-xs-12 col-sm-12 col-md-3">
						<div class="logo">
							<a href="<?=DOMINIO?>" ><img src="<?=$logo_topo?>" ></a>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-12 col-md-9">
						<div class="row">

							<?php

							$icone_carrinho = "";
							foreach ($lista_icones as $key => $value) {
								if($value['destino'] == 'index/carrinho'){
									
									$icone_carrinho = '									
									<div class="col-xs-12 col-sm-12 col-md-3">
									<div style="margin-bottom:-15px;">
									<a class="botao_carrinho" href="'.DOMINIO.$controller.'/carrinho" >
									<div class="botao_carrinho_esq">
									'.$value['icone'].'
									</div>
									<div class="botao_carrinho_dir">										
									<span id="textocarrinhotopo" style="font-weight: normal;" >'.$value['titulo'].'<br></span>
									<span id="itens_carrinho" >'.$_base['itens_carrinho'].'</span>
									</div>
									<div style="clear: both;"></div>
									</a>
									</div>
									</div>
									';

								}
							}

							?>

							<?php if(!$icone_carrinho){
								?>
								<div class="col-xs-12 col-sm-12 col-md-3"></div>
								<?php
							} else {
								?>
								<div class="col-xs-12 col-sm-12 col-md-9">
									<?php
								}
								?>

								<div class="busca_div">
									<form action="<?=$destino_busca?>" method="post" > 
										<div class="input-group">
											<input name='busca' type="text" class="form-control busca_input" placeholder="O que você está procurando?" />
											<span class="input-group-btn">
												<button class="btn busca_botao" type="submit" >
													<i class="fas fa-search"></i>
												</button>
											</span>
										</div> 
									</form>
								</div>
							</div>

							<?=$icone_carrinho?>						

						</div>						

						<div class="topo_redes">
							<style type="text/css">
								.topo_redes_item{
									font-size:<?=$conteudo_sessao['data_topo']->textos_fonte_tam;?>px !important;
								}
							</style>
							<?php if($conteudo_sessao['data_topo']->fone1){ ?>
								<div class="topo_redes_item" >
									<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->fone2){ ?>
								<div class="topo_redes_item" >
									<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->email){ ?>
								<div class="topo_redes_item" >
									<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
								</div>								
							<?php } ?>
							<div style="clear: both;"></div>

						</div>

						<div class="topo_redes_triangulo"></div>

						<div class="div_botoes_topo">

							<?php

							foreach ($lista_icones as $key => $value) {
								
								if($value['destino'] == 'index/carrinho'){
									$addclasscss = "carrinho_pequeno";
								} else {
									$addclasscss = "";
								}

								$array = explode('http', $value['destino']);
								if(count($array) > 1){
									$destinolink = "href='".$value['destino']."'";
								} else {

									if($value['destino'] == 'index/ligamospravc'){											
										$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
									} else {
										$destinolink = "href='".DOMINIO.$value['destino']."'";
									}
								}

								echo "
								<a class='botao_conta_topo $addclasscss' $destinolink >
								".$value['icone']."
								<span>".$value['titulo']."</span>
								</a>
								";
							}

							?>
							<div style="clear: both;"></div>
						</div>

						<div style="clear:both; "></div>

					</div>
				</div>

			</div>
		</div>


		<div class="header-bottom" style="font-family: <?=$fonte_topo_menu?> !important; " >
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-'12' col-md-12">

						<div class="navbar-header" >
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
								MENU <i class="fa fa-bars" aria-hidden="true"></i>
							</button>
						</div>

						<div class="mainmenu">
							<ul class="nav navbar-nav collapse navbar-collapse">

								<?php

								function menu($array, $controller, $url_pagina = null){

									foreach ($array as $key => $value) {

										if($value['controller'] == $controller){
											if($value['controller'] == 'conteudo'){
												if($value['url'] == $url_pagina){
													$active = " class='active' ";
												} else {
													$active = "";
												}
											} else {
												$active = " class='active' ";
											}
										} else {
											$active = "";
										}

										echo "<li><a href='".$value['destino']."' ".$active." >";

										if($value['imagem']){
											echo "<span class='mainmenu_img' ><img src='".PASTA_CLIENTE."imagens/".$value['imagem']."' ></span>";
										} else {
											if($value['icone']){
												echo "<span class='mainmenu_ico' >".$value['icone']."</span>";
											}
										}

										echo "<span class='mainmenu_txt' >".$value['titulo']."</span></a>";

										if(count($value['submenu']) != 0){
											echo "<ul>";
											echo "<div class='mainmenu_titulo' >".$value['titulo']."</div>";
											menu($value['submenu'], $controller, $url_pagina);	 
											echo "</ul>";
										}

										echo "</li>";
									}
								}

								menu($conteudo_sessao['menu'], $controller, '');								

								?>
							</ul>
						</div>

					</div>

				</div>
			</div>
		</div>
	</header>

	<section class="margemtopo"></section>

<?php } ?>


<?php if($conteudo_sessao['data_topo']->modelo == 2){ ?>

	<style type="text/css">
		.topo2_superior_esq, .topo2_superior_dir{
			font-size:<?=$conteudo_sessao['data_topo']->textos_fonte_tam;?>px;
		}

		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
	</style>

	<header id="header" class="topo2" >

		<div id="topo" class="header-top topo2_superior" >
			<div class="container" >
				<div class="row" >
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="topo2_superior_esq" >

							<?php if($conteudo_sessao['data_topo']->fone1){ ?>
								<span><i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?></span>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->fone2){ ?>
								<span><i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?></span>
							<?php } ?>

						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="topo2_superior_dir" >
							<?php if($conteudo_sessao['data_topo']->email){ ?>
								<span><i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?></span>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>				
		</div>

		<div class="header-middle" >
			<div class="container" >
				<div class="row" >

					<div class="col-xs-12 col-sm-4 col-md-3">
						<div class="logo">
							<a href="<?=DOMINIO?>" ><img src="<?=$logo_topo?>" ></a>
						</div>
					</div>

					<div class="col-xs-12 col-sm-8 col-md-9">
						<div class="row">

							<div class="col-xs-12 col-sm-6 col-md-7">
								<div class="busca_div">
									<form action="<?=$destino_busca?>" method="post" > 
										<div class="input-group">
											<input name='busca' type="text" class="form-control busca_input" placeholder="O que você está procurando?" />
											<span class="input-group-btn">
												<button class="btn busca_botao" type="submit" >
													<i class="fas fa-search"></i>
												</button>
											</span>
										</div> 
									</form>
								</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-5" >

								<div class="div_botoes_topo">

									<?php

									foreach ($lista_icones as $key => $value) { 

										$array = explode('http', $value['destino']);
										if(count($array) > 1){
											$destinolink = "href='".$value['destino']."'";
										} else {

											if($value['destino'] == 'index/ligamospravc'){											
												$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
											} else {
												$destinolink = "href='".DOMINIO.$value['destino']."'";
											}
										}

										echo "
										<a class='botao_conta_topo' $destinolink >
										".$value['icone']."
										<span>".$value['titulo']."</span>
										</a>
										";

									}

									?>
									<div style="clear: both;"></div>
								</div>

							</div> 

						</div> 
					</div>
				</div>

			</div>
		</div>

		<div class="header-bottom" style="font-family: <?=$fonte_topo_menu?> !important; " >
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-'12' col-md-12">

						<div class="navbar-header" >
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
								MENU <i class="fa fa-bars" aria-hidden="true"></i>
							</button>
						</div>

						<div class="mainmenu">
							<ul class="nav navbar-nav collapse navbar-collapse">

								<?php

								function menu($array, $controller, $url_pagina = null){

									foreach ($array as $key => $value) {

										if($value['controller'] == $controller){
											if($value['controller'] == 'conteudo'){
												if($value['url'] == $url_pagina){
													$active = " class='active' ";
												} else {
													$active = "";
												}
											} else {
												$active = " class='active' ";
											}
										} else {
											$active = "";
										}

										echo "<li><a href='".$value['destino']."' ".$active." >";

										if($value['imagem']){
											echo "<span class='mainmenu_img' ><img src='".PASTA_CLIENTE."imagens/".$value['imagem']."' ></span>";
										} else {
											if($value['icone']){
												echo "<span class='mainmenu_ico' >".$value['icone']."</span>";
											}
										}

										echo "<span class='mainmenu_txt' >".$value['titulo']."</span></a>";

										if(count($value['submenu']) != 0){
											echo "<ul>";
											echo "<div class='mainmenu_titulo' >".$value['titulo']."</div>";
											menu($value['submenu'], $controller, $url_pagina);	 
											echo "</ul>";
										}

										echo "</li>";
									}
								}

								menu($conteudo_sessao['menu'], $controller, '');								

								?>
							</ul>
						</div>

					</div>

				</div>
			</div>
		</div>
	</header>

	<section class="margemtopo"></section>

<?php } ?>



<?php if($conteudo_sessao['data_topo']->modelo == 3){ ?>

	<style type="text/css">
		.topo_contatos_item{
			font-size:<?=$conteudo_sessao['data_topo']->textos_fonte_tam;?>px;
		}
		
		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
	</style>

	<header id="header" >

		<div id="topo" class="topo3" >
			<div class="container">
				<div class="row" >

					<div class="col-xs-6 col-sm-5 col-md-4">
						<div class="logo">
							<a href="<?=DOMINIO?>" ><img src="<?=$logo_topo?>" ></a>
						</div>
						<div class="logo_fundo"></div>
					</div>
					
					<div class="col-xs-1 col-sm-3 col-md-5">
						
						<div class="topo_contatos" >
							<?php if($conteudo_sessao['data_topo']->fone1){ ?>
								<div class="topo_contatos_item" >
									<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->fone2){ ?>
								<div class="topo_contatos_item" >
									<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->email){ ?>
								<div class="topo_contatos_item" >
									<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
								</div>								
							<?php } ?>
							<div style="clear: both;"></div>
						</div>
						
					</div>

					<div class="col-xs-5 col-sm-4 col-md-3">

						<div class="div_botoes_topo">

							<?php

							foreach ($lista_icones as $key => $value) { 

								$array = explode('http', $value['destino']);
								if(count($array) > 1){
									$destinolink = "href='".$value['destino']."'";
								} else {

									if($value['destino'] == 'index/ligamospravc'){											
										$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
									} else {
										$destinolink = "href='".DOMINIO.$value['destino']."'";
									}
								}

								if($value['destino'] != 'index'){		
									echo "
									<a class='botao_conta_topo' $destinolink >
									".$value['icone']."
									<span>".$value['titulo']."</span>
									</a>
									";
								}

							}

							?>
							<div style="clear: both;"></div>
						</div>

					</div>

				</div>
			</div>

		</div>

		<div class="topo3_bottom">

			<div class="container">

				<div class="row" >
					<div class="col-md-12">

						<div class="menu_home">
							<a href="<?=DOMINIO?>">
								<i class="fa fa-home" aria-hidden="true"></i>
							</a>
						</div>

						<div class="menu"  style="font-family: <?=$fonte_topo_menu?> !important; "  >

							<div class="botaomenuresponsivo" onclick="abremenu();" >
								<i class="fa fa-bars" aria-hidden="true"></i> MENU
							</div>

							<div class="mainmenu">

								<ul class="nav navbar-nav collapse navbar-collapse">

									<?php

									function menu($array, $controller, $url_pagina = null){

										foreach ($array as $key => $value) {

											if($value['controller'] == $controller){
												if($value['controller'] == 'conteudo'){
													if($value['url'] == $url_pagina){
														$active = " class='active' ";
													} else {
														$active = "";
													}
												} else {
													$active = " class='active' ";
												}
											} else {
												$active = "";
											}

											echo "<li><a href='".$value['destino']."' ".$active." >";

											echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

											if(count($value['submenu']) != 0){

												echo "<ul>";
												echo "
												<span class='setasub'><i class='fas fa-sort-up'></i></span>
												<div class='submenu_esq' >
												";

												menu($value['submenu'], $controller, $url_pagina);								 

												echo "</div>";											 

												echo "<div style='clear:both' ></div>";
												echo "</ul>";
											}

											echo "</li>";
										}
									}

									if($controller == 'conteudo'){
										menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
									} else {
										menu($conteudo_sessao['menu'], $controller, '');
									}

									?>
								</ul>
							</div>

						</div>
					</div>

				</div>
			</div>

		</div>		

	</header>

	<section class="margemtopo"></section>

	<script type="text/javascript">
		function abremenu(){
			$('.navbar-collapse').toggle();
		}	
	</script>


<?php } ?>



<?php if($conteudo_sessao['data_topo']->modelo == 4){ ?>

	<style type="text/css">
		.topo_contatos_item{
			font-size:<?=$conteudo_sessao['data_topo']->textos_fonte_tam;?>px;
		}
		
		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
	</style>

	<header id="header" >
		<div id="topo" class="topo4" >
			<div class="container">
				<div class="row">

					<div class="col-xs-12 col-sm-4 col-md-4">

						<div class="logo_div">
							<a href="<?=DOMINIO?>" class="logo">
								<img alt="" src="<?=$logo_topo?>" >
							</a>
						</div>

					</div>

					<div class="col-xs-12 col-sm-8 col-md-8">

						<div class="topo_contatos" >
							<?php if($conteudo_sessao['data_topo']->fone1){ ?>
								<div class="topo_contatos_item" >
									<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->fone2){ ?>
								<div class="topo_contatos_item" >
									<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->email){ ?>
								<div class="topo_contatos_item" >
									<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
								</div>								
							<?php } ?>
							<div style="clear: both;"></div>
						</div>
						

						<div class="div_botoes_topo">

							<?php

							foreach ($lista_icones as $key => $value) { 

								$array = explode('http', $value['destino']);
								if(count($array) > 1){
									$destinolink = "href='".$value['destino']."'";
								} else {

									if($value['destino'] == 'index/ligamospravc'){											
										$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
									} else {
										$destinolink = "href='".DOMINIO.$value['destino']."'";
									}
								}

								echo "
								<a class='botao_conta_topo' $destinolink >
								".$value['icone']."
								<span>".$value['titulo']."</span>
								</a>
								";

							}

							?>
							<div style="clear: both;"></div>
						</div>




					</div>

				</div>

				<div class='linha_menu' ></div>

				<div class="row">

					<div class="col-sm-10" >

						<div class="menu"  style="font-family: <?=$fonte_topo_menu?> !important; "  > 

							<div class="botaomenuresponsivo" onclick="abremenu();" >
								<i class="fa fa-bars" aria-hidden="true"></i> MENU
							</div>

							<div class="mainmenu">

								<ul class="nav navbar-nav collapse navbar-collapse">

									<?php

									function menu($array, $controller, $url_pagina = null){

										foreach ($array as $key => $value) {

											if($value['controller'] == $controller){
												if($value['controller'] == 'conteudo'){
													if($value['url'] == $url_pagina){
														$active = " class='active' ";
													} else {
														$active = "";
													}
												} else {
													$active = " class='active' ";
												}
											} else {
												$active = "";
											}

											echo "<li><a href='".$value['destino']."' ".$active." >";

											echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

											if(count($value['submenu']) != 0){

												echo "<ul>";
												echo "
												<span class='setasub'><i class='fas fa-sort-up'></i></span>
												<div class='submenu_esq' >
												";

												menu($value['submenu'], $controller, $url_pagina);								 

												echo "</div>";											 

												echo "<div style='clear:both' ></div>";
												echo "</ul>";
											}

											echo "</li>";
										}
									}

									if($controller == 'conteudo'){
										menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
									} else {
										menu($conteudo_sessao['menu'], $controller, '');
									}

									?>
								</ul>
							</div>

						</div>
					</div>

					<div class="col-sm-2" >

						<div class="topo2_superior_dir" >
							<?php

							foreach ($_base['redessociais'] as $key => $value) {

								echo "
								<a class='redes_topo_item' href='".$value['endereco']."' target='_blank' ><img src='".$value['imagem']."' ></a>
								";

							}

							?>
						</div>

					</div>

				</div>


			</div>
		</div>
	</header>

	<section class="margemtopo"></section>

	<script type="text/javascript">
		function abremenu(){
			$('.navbar-collapse').toggle();
		}	
	</script>

<?php } ?>



<?php if($conteudo_sessao['data_topo']->modelo == 5){ ?>
	
	<style type="text/css">
		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
	</style>

	<header id="header" >
		
		<div class="topo5" >

			<div id="topo" class="header-top topo_superior" >
				<div class="container" >
					<div class="row" >
						<div class="col-xs-12 col-sm-7 col-md-6">

							<div class="topo_contatos" >
								<?php if($conteudo_sessao['data_topo']->fone1){ ?>
									<div class="topo_contatos_item" >
										<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
									</div>
								<?php } ?>
								<?php if($conteudo_sessao['data_topo']->fone2){ ?>
									<div class="topo_contatos_item" >
										<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
									</div>
								<?php } ?>
								<?php if($conteudo_sessao['data_topo']->email){ ?>
									<div class="topo_contatos_item" >
										<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
									</div>								
								<?php } ?>
								<div style="clear: both;"></div>
							</div>


						</div>
						<div class="col-xs-12 col-sm-5 col-md-6">
							<div class="div_botoes_topo">

								<?php

								foreach ($lista_icones as $key => $value) { 

									$array = explode('http', $value['destino']);
									if(count($array) > 1){
										$destinolink = "href='".$value['destino']."'";
									} else {

										if($value['destino'] == 'index/ligamospravc'){											
											$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
										} else {
											$destinolink = "href='".DOMINIO.$value['destino']."'";
										}
									}

									echo "
									<a class='botao_conta_topo' $destinolink >
									".$value['icone']."
									<span>".$value['titulo']."</span>
									</a>
									";

								}

								?>
								<div style="clear: both;"></div>
							</div>
						</div>
					</div>
				</div>				
			</div>

			<div class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">

						<div class="logo_div">
							<a href="<?=DOMINIO?>" class="logo">
								<img alt="" src="<?=$logo_topo?>">
							</a>
						</div>

					</div>
				</div>
			</div>

			<div class="menu_borda" ></div>

			<div class="container">

				<div class="row">

					<div class="col-sm-12" >

						<div class="menu"  style="font-family: <?=$fonte_topo_menu?> !important; " >

							<div class="botaomenuresponsivo" onclick="abremenu();" >
								<i class="fa fa-bars" aria-hidden="true"></i> MENU
							</div>

							<div class="mainmenu">

								<ul class="nav navbar-nav collapse navbar-collapse">

									<?php

									function menu($array, $controller, $url_pagina = null){

										foreach ($array as $key => $value) {

											if($value['controller'] == $controller){
												if($value['controller'] == 'conteudo'){
													if($value['url'] == $url_pagina){
														$active = " class='active' ";
													} else {
														$active = "";
													}
												} else {
													$active = " class='active' ";
												}
											} else {
												$active = "";
											}

											echo "<li><a href='".$value['destino']."' ".$active." >";

											echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

											if(count($value['submenu']) != 0){

												echo "<ul>";
												echo "
												<span class='setasub'><i class='fas fa-sort-up'></i></span>
												<div class='submenu_esq' >
												";

												menu($value['submenu'], $controller, $url_pagina);								 

												echo "</div>";											 

												echo "<div style='clear:both' ></div>";
												echo "</ul>";
											}

											echo "</li>";
										}
									}

									if($controller == 'conteudo'){
										menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
									} else {
										menu($conteudo_sessao['menu'], $controller, '');
									}

									?>
								</ul>
							</div>

						</div>
					</div>

				</div>

			</div>

		</div>

	</header>

	<section class="margemtopo"></section>

	<script type="text/javascript">
		function abremenu(){
			$('.navbar-collapse').toggle();
		}	
	</script>

<?php } ?>



<?php if($conteudo_sessao['data_topo']->modelo == 6){ ?>

	<style type="text/css">
		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
	</style>

	<header id="header" >

		<div class="topo6" >

			<div class="header-top topo_superior" >
				<div class="container" >
					<div class="row" >
						<div class="col-xs-12 col-sm-7 col-md-6">

							<div class="topo_contatos" >
								<?php if($conteudo_sessao['data_topo']->fone1){ ?>
									<div class="topo_contatos_item" >
										<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
									</div>
								<?php } ?>
								<?php if($conteudo_sessao['data_topo']->fone2){ ?>
									<div class="topo_contatos_item" >
										<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
									</div>
								<?php } ?>
							</div>

						</div>
						<div class="col-xs-12 col-sm-5 col-md-6">
							<div class="topo_contatos2">
								<?php if($conteudo_sessao['data_topo']->email){ ?>
									<div class="topo_contatos_item" >
										<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>				
			</div>

			<div id="topo" class="header-middle" >
				<div class="container" >
					<div class="row" >

						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="logo_div">
								<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
							</div>
						</div>

						<div class="col-xs-12 col-sm-4 col-md-4">

							<div class="busca_div">
								<form action="<?=$destino_busca?>" method="post" > 
									<div class="input-group">
										<input name='busca' type="text" class="form-control busca_input" placeholder="O que você está procurando?" />
										<span class="input-group-btn">
											<button class="btn busca_botao" type="submit" ><i class="fa fa-search" aria-hidden="true"></i></button>
										</span>
									</div> 
								</form>
							</div>

						</div>

						<div class="col-xs-12 col-sm-4 col-md-4">

							<div class="div_botoes_topo">

								<?php

								foreach ($lista_icones as $key => $value) { 

									$array = explode('http', $value['destino']);
									if(count($array) > 1){
										$destinolink = "href='".$value['destino']."'";
									} else {

										if($value['destino'] == 'index/ligamospravc'){											
											$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
										} else {
											$destinolink = "href='".DOMINIO.$value['destino']."'";
										}
									}

									echo "
									<a class='botao_conta_topo' $destinolink >
									".$value['icone']."
									<span>".$value['titulo']."</span>
									</a>
									";

								}

								?>
								<div style="clear: both;"></div>
							</div>

						</div>
					</div>

				</div>
			</div>


			<div class="header-bottom" >
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-'12' col-md-12">

							<div class="navbar-header" >
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
									MENU <i class="fa fa-bars" aria-hidden="true"></i>
								</button>
							</div>

							<div class="mainmenu"  style="font-family: <?=$fonte_topo_menu?> !important; "  >
								<ul class="nav navbar-nav collapse navbar-collapse">

									<?php

									function menu($array, $controller, $url_pagina = null){

										foreach ($array as $key => $value) {

											if($value['controller'] == $controller){
												if($value['controller'] == 'conteudo'){
													if($value['url'] == $url_pagina){
														$active = " class='active' ";
													} else {
														$active = "";
													}
												} else {
													$active = " class='active' ";
												}
											} else {
												$active = "";
											}

											echo "<li><a href='".$value['destino']."' ".$active." >";

											echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

											if(count($value['submenu']) != 0){

												echo "<ul>";
												echo "
												<span class='setasub'><i class='fas fa-sort-up'></i></span>
												<div class='submenu_esq' >
												";

												menu($value['submenu'], $controller, $url_pagina);								 

												echo "</div>";											 

												echo "<div style='clear:both' ></div>";
												echo "</ul>";
											}

											echo "</li>";
										}
									}

									if($controller == 'conteudo'){
										menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
									} else {
										menu($conteudo_sessao['menu'], $controller, '');
									}

									?>
								</ul>
							</div>

						</div>

					</div>
				</div>
			</div>

		</div>

	</header>

	<section class="margemtopo"></section>

<?php } ?>



<?php if($conteudo_sessao['data_topo']->modelo == 7){ ?>

	<style type="text/css">
		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
		.topo_superior{
			background-color: <?=$cores[268]?>;
			color: <?=$cores[269]?> !important;
		}
		.topo_superior i{ 
			color: <?=$cores[269]?> !important;
		}
		.topo_superior a{ 
			color: <?=$cores[269]?> !important;
		}
		.topo_contatos_item{
			color: <?=$cores[269]?> !important;
		}
	</style>


	<header id="header" >

		<div class="topo7" >

			<div class="header-top topo_superior" >
				<div class="container" >
					<div class="row" >
						<div class="col-xs-12 col-sm-7 col-md-6">

							<div class="topo_contatos" >
								<?php if($conteudo_sessao['data_topo']->fone1){ ?>
									<div class="topo_contatos_item" >
										<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
									</div>
								<?php } ?>
								<?php if($conteudo_sessao['data_topo']->fone2){ ?>
									<div class="topo_contatos_item" >
										<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
									</div>
								<?php } ?>
								<?php if($conteudo_sessao['data_topo']->email){ ?>
									<div class="topo_contatos_item" >
										<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
									</div>								
								<?php } ?>
								<div style="clear: both;"></div>
							</div>


						</div>
						<div class="col-xs-12 col-sm-5 col-md-6">
							<div class="div_botoes_topo">

								<?php

								foreach ($lista_icones as $key => $value) { 

									$array = explode('http', $value['destino']);
									if(count($array) > 1){
										$destinolink = "href='".$value['destino']."'";
									} else {

										if($value['destino'] == 'index/ligamospravc'){											
											$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
										} else {
											$destinolink = "href='".DOMINIO.$value['destino']."'";
										}
									}

									echo "
									<a class='botao_conta_topo' $destinolink >
									".$value['icone']."
									<span>".$value['titulo']."</span>
									</a>
									";

								}

								?>
								<div style="clear: both;"></div>
							</div>
						</div>
					</div>
				</div>				
			</div>



			<div id="topo" class="header-middle" >
				<div class="container" >
					<div class="row" >

						<div class="col-xs-8 col-sm-3 col-md-3">
							<div class="logo_div">
								<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
							</div>
						</div>

						<div class="col-xs-12 col-sm-9 col-md-9 fundomenuresponsivo"  style="font-family: <?=$fonte_topo_menu?> !important; "  >

							<div class="navbar-header" >
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
									<i class="fa fa-bars" aria-hidden="true"></i>
								</button>
							</div>

							<div class="mainmenu">
								<ul class="nav navbar-nav collapse navbar-collapse">

									<?php

									function menu($array, $controller, $url_pagina = null){

										foreach ($array as $key => $value) {

											if($value['controller'] == $controller){
												if($value['controller'] == 'conteudo'){
													if($value['url'] == $url_pagina){
														$active = " class='active' ";
													} else {
														$active = "";
													}
												} else {
													$active = " class='active' ";
												}
											} else {
												$active = "";
											}

											echo "<li><a href='".$value['destino']."' ".$active." >";

											echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

											if(count($value['submenu']) != 0){

												echo "<ul>";
												echo " 
												<div class='submenu_esq' >
												";

												menu($value['submenu'], $controller, $url_pagina);								 

												echo "</div>";											 

												echo "<div style='clear:both' ></div>";
												echo "</ul>";
											}

											echo "</li>";
										}
									}

									if($controller == 'conteudo'){
										menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
									} else {
										menu($conteudo_sessao['menu'], $controller, '');
									}

									?>
								</ul>
							</div>



						</div>
					</div>

				</div>
			</div>

		</div>

	</header>

	<section class="margemtopo"></section>

<?php } ?>


<?php if($conteudo_sessao['data_topo']->modelo == 8){ ?>

	<style type="text/css">
		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
	</style>

	<header id="header" class="topo8" >

		<div id="topo" class="header-middle" >
			<div class="container" >
				<div class="row" >

					<div class="col-xs-12 col-sm-4 col-md-3">
						<div class="logo_div">
							<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
						</div>
					</div>

					<div class="col-xs-12 col-sm-8 col-md-9 fundomenuresponsivo" >


						<div class="topo_faixasuperior">
							<div class="topo_redes_triangulo1"></div>
							<div class="topo_redes">
								<?php

								foreach ($lista_icones as $key => $value) { 

									$array = explode('http', $value['destino']);
									if(count($array) > 1){
										$destinolink = "href='".$value['destino']."'";
									} else {

										if($value['destino'] == 'index/ligamospravc'){											
											$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
										} else {
											$destinolink = "href='".DOMINIO.$value['destino']."'";
										}
									}

									echo "
									<a class='fone_topo' $destinolink >
									".$value['icone']."
									<span>".$value['titulo']."</span>
									</a>
									";

								}

								?> 

								<div style="clear: both;"></div>

							</div>
							<div class="topo_redes_triangulo2"></div>
							<div style="clear:both; "></div>
						</div>


						<div class="topo_contatos" >
							<?php if($conteudo_sessao['data_topo']->fone1){ ?>
								<div class="topo_contatos_item" >
									<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->fone2){ ?>
								<div class="topo_contatos_item" >
									<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
								</div>
							<?php } ?>
							<?php if($conteudo_sessao['data_topo']->email){ ?>
								<div class="topo_contatos_item" >
									<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
								</div>								
							<?php } ?>
							<div style="clear: both;"></div>
						</div>


						<div class="navbar-header" >
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
								MENU <i class="fa fa-bars" aria-hidden="true"></i>
							</button>
						</div>

						<div class="mainmenu"  style="font-family: <?=$fonte_topo_menu?> !important; "  >
							<ul class="nav navbar-nav collapse navbar-collapse">

								<?php

								function menu($array, $controller, $url_pagina = null){

									foreach ($array as $key => $value) {

										if($value['controller'] == $controller){
											if($value['controller'] == 'conteudo'){
												if($value['url'] == $url_pagina){
													$active = " class='active' ";
												} else {
													$active = "";
												}
											} else {
												$active = " class='active' ";
											}
										} else {
											$active = "";
										}

										echo "<li><a href='".$value['destino']."' ".$active." >";

										echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

										if(count($value['submenu']) != 0){

											echo "<ul>";
											echo "
											<span class='setasub'><i class='fas fa-sort-up'></i></span>
											<div class='submenu_esq' >
											";

											menu($value['submenu'], $controller, $url_pagina);								 

											echo "</div>";											 

											echo "<div style='clear:both' ></div>";
											echo "</ul>";
										}

										echo "</li>";
									}
								}

								if($controller == 'conteudo'){
									menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
								} else {
									menu($conteudo_sessao['menu'], $controller, '');
								}

								?>
							</ul>
						</div>


					</div>
				</div>

			</div>
		</div>

	</header>

	<section class="margemtopo"></section>

<?php } ?>

<?php if($conteudo_sessao['data_topo']->modelo == 9){ ?>

	<style type="text/css">
		
		.topo9{
			<?php
			if($conteudo_sessao['data_topo']->posicao == 0){
				?>
				position: relative !important;
				<?php
			} else {
				?>
				position: fixed !important;
				z-index: 999999;
				width: 100% !important;
				<?php
			}
			?>
		}

	</style>

	<header id="header" >

		<div class="topo9" >

			<div id="topo" class="header-middle" >
				<div class="container" >
					<div class="row" >

						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="logo_div">
								<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
							</div>
						</div>

						<div class="col-xs-12 col-sm-8 col-md-9 fundomenuresponsivo"  style="font-family: <?=$fonte_topo_menu?> !important; "  >

							<div class="navbar-header" >
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
									MENU <i class="fa fa-bars" aria-hidden="true"></i>
								</button>
							</div>

							<div class="mainmenu">
								<ul class="nav navbar-nav collapse navbar-collapse">

									<?php

									function menu($array, $controller, $url_pagina = null){

										foreach ($array as $key => $value) {

											if($value['controller'] == $controller){
												if($value['controller'] == 'conteudo'){
													if($value['url'] == $url_pagina){
														$active = " class='active' ";
													} else {
														$active = "";
													}
												} else {
													$active = " class='active' ";
												}
											} else {
												$active = "";
											}

											echo "<li><a href='".$value['destino']."' ".$active." >";

											echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

											if(count($value['submenu']) != 0){

												echo "<ul>";
												echo "
												<div class='submenu_esq' >
												";

												menu($value['submenu'], $controller, $url_pagina);								 

												echo "</div>";											 

												echo "<div style='clear:both' ></div>";
												echo "</ul>";
											}

											echo "</li>";
										}
									}

									if($controller == 'conteudo'){
										menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
									} else {
										menu($conteudo_sessao['menu'], $controller, '');
									}

									?>
								</ul>
							</div>


						</div>
					</div>

				</div>
			</div>

		</div>
		
	</header>

	<section class="margemtopo"></section>	

<?php } ?>

<?php if($conteudo_sessao['data_topo']->modelo == 10){ ?>

	<style type="text/css">
		
		.topo10{
			<?php
			if($conteudo_sessao['data_topo']->posicao == 0){
				?>
				position: relative !important;
				<?php
			} else {
				?>
				position: fixed !important;
				z-index: 999999;
				width: 100% !important;
				<?php
			}
			?>
		}

	</style>

	<header id="header" >

		<div class="topo10" > 

			<div id="topo" class="header-middle" >
				<div class="container" >
					<div class="row" >

						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="logo_div">
								<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
							</div>
						</div>

						<div class="col-xs-12 col-sm-8 col-md-9 fundomenuresponsivo"  style="font-family: <?=$fonte_topo_menu?> !important; "  >

							<div class="navbar-header" >
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
									MENU <i class="fa fa-bars" aria-hidden="true"></i>
								</button>
							</div>

							<div class="mainmenu">
								<ul class="nav navbar-nav collapse navbar-collapse">

									<?php

									function menu($array, $controller, $url_pagina = null){

										foreach ($array as $key => $value) {

											if($value['controller'] == $controller){
												if($value['controller'] == 'conteudo'){
													if($value['url'] == $url_pagina){
														$active = " class='active' ";
													} else {
														$active = "";
													}
												} else {
													$active = " class='active' ";
												}
											} else {
												$active = "";
											}

											echo "<li><a href='".$value['destino']."' ".$active." >";

											echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

											if(count($value['submenu']) != 0){

												echo "<ul>";
												echo "
												<div class='submenu_esq' >
												";

												menu($value['submenu'], $controller, $url_pagina);								 

												echo "</div>";											 

												echo "<div style='clear:both' ></div>";
												echo "</ul>";
											}

											echo "</li>";
										}
									}

									if($controller == 'conteudo'){
										menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
									} else {
										menu($conteudo_sessao['menu'], $controller, '');
									}

									?>
								</ul>
							</div>


						</div>
					</div>

				</div>
			</div>

		</div>

	</header>

	<section class="margemtopo"></section>

<?php } ?>


<?php if($conteudo_sessao['data_topo']->modelo == 11){ ?>

	<style type="text/css">
		
		#header{
			<?php
			if($conteudo_sessao['data_topo']->posicao == 0){
				?>
				position: relative !important;
				<?php
			} else {
				?>
				position: fixed !important;
				z-index: 999999;
				width: 100% !important;
				<?php
			}
			?>
		}

		@media (max-width: 770px){
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}

	</style>

	<header id="header" > 

		<div id="topo" class="header-middle topo11" >
			<div class="container" >
				<div class="row" >

					<div class="col-xs-12 col-sm-4 col-md-3">
						<div class="logo_div">
							<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
						</div>
					</div>

					<div class="col-xs-12 col-sm-8 col-md-9">

						<div>
							<?php
							$banners_topo = $conteudo_sessao['banners_topo'];
							include 'htm_conteudo_banners_topo.php'; ?>
						</div>


						<div class="row">

							<div class="col-xs-12 col-sm-6 col-md-7">

								<div class="topo_contatos" >
									<?php if($conteudo_sessao['data_topo']->fone1){ ?>
										<div class="topo_contatos_item" >
											<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
										</div>
									<?php } ?>
									<?php if($conteudo_sessao['data_topo']->fone2){ ?>
										<div class="topo_contatos_item" >
											<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
										</div>
									<?php } ?>
									<?php if($conteudo_sessao['data_topo']->email){ ?>
										<div class="topo_contatos_item" >
											<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
										</div>								
									<?php } ?>
									<div style="clear: both;"></div>
								</div>

							</div>

							<div class="col-xs-12 col-sm-6 col-md-5">

								<div class="busca_div">
									<form action="<?=$destino_busca?>" method="post" > 
										<div class="input-group">
											<input name='busca' type="text" class="form-control busca_input" placeholder="O que você está procurando?" />
											<span class="input-group-btn">
												<button class="btn busca_botao" type="submit" ><i class="fa fa-search" aria-hidden="true"></i></button>
											</span>
										</div> 
									</form>
								</div>

							</div>

						</div>

					</div>

				</div>

			</div>
		</div>


		<div class="header-bottom"  style="font-family: <?=$fonte_topo_menu?> !important; "  >
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-'12' col-md-12">				 

						<div class="navbar-header" >
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
								MENU <i class="fa fa-bars" aria-hidden="true"></i>
							</button>
						</div>

						<div class="mainmenu">
							<ul class="nav navbar-nav collapse navbar-collapse">

								<?php

								function menu($array, $controller, $url_pagina = null){

									foreach ($array as $key => $value) {

										if($value['controller'] == $controller){
											if($value['controller'] == 'conteudo'){
												if($value['url'] == $url_pagina){
													$active = " class='active' ";
												} else {
													$active = "";
												}
											} else {
												$active = " class='active' ";
											}
										} else {
											$active = "";
										}

										echo "<li><a href='".$value['destino']."' ".$active." >";

										echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

										if(count($value['submenu']) != 0){

											echo "<ul>";
											echo "
											<span class='setasub'><i class='fas fa-sort-up'></i></span>
											<div class='submenu_esq' >
											";

											menu($value['submenu'], $controller, $url_pagina);								 

											echo "</div>";											 

											echo "<div style='clear:both' ></div>";
											echo "</ul>";
										}

										echo "</li>";
									}
								}

								if($controller == 'conteudo'){
									menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
								} else {
									menu($conteudo_sessao['menu'], $controller, '');
								}

								?>
							</ul>
						</div>

					</div>

				</div>
			</div>
		</div>

	</div>		

</header>

<section class="margemtopo"></section>

<script type="text/javascript">
	function abremenu(){
		$('.navbar-collapse').toggle();
	}	
</script>


<?php } ?>


<?php if($conteudo_sessao['data_topo']->modelo == 12){ ?>

	<style type="text/css">
		.mainmenu_txt{
			font-size: <?=$conteudo_sessao['data_topo']->menu_fonte_tam?>px;
		}
		.fundo_menu{
			font-family: <?=$fonte_topo_menu?>;
		}
	</style>

	<header id="header" >

		<div id="topo" class="header-middle topo12" >

			<div class="logo_div">

				<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>

				<button type="button" class="navbar-toggle botao_menu_responsivo" onclick="abremenu();">
					<i class="fa fa-bars" aria-hidden="true"></i> MENU
				</button>

				<button type="button" class="navbar-toggle botao_menu_responsivo_fechar" onclick="fechamenu();">
					<i class="fas fa-times"></i> FECHAR
				</button>

			</div>


			<div class="topo_direita"> 

				<div class="lnks_topo_div">

					<div>
						<?php if($conteudo_sessao['data_topo']->fone1){ ?>
							<a class="lnks_topo" >
								<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
							</a>
						<?php } ?>
						<?php if($conteudo_sessao['data_topo']->fone2){ ?>
							<a class="lnks_topo" >
								<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
							</a>
						<?php } ?>
						<?php if($conteudo_sessao['data_topo']->email){ ?>
							<a class="lnks_topo" >
								<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
							</a>								
						<?php } ?>
					</div>

					<?php

					foreach ($lista_icones as $key => $value) { 

						$array = explode('http', $value['destino']);
						if(count($array) > 1){
							$destinolink = "href='".$value['destino']."'";
						} else {

							if($value['destino'] == 'index/ligamospravc'){											
								$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
							} else {
								$destinolink = "href='".DOMINIO.$value['destino']."'";
							}
						}

						echo "
						<a class='lnks_topo' $destinolink >
						".$value['icone']."
						<span>".$value['titulo']."</span>
						</a>
						";

					}

					?>
					<div style="clear: both;"></div>
				</div>


				<div class="fundo_menu anime_menu" >					 

					<div class="mainmenu">
						<ul class="nav navbar-nav collapse navbar-collapse">

							<?php

							function menu($array, $controller, $url_pagina = null){

								foreach ($array as $key => $value) {

									if($value['controller'] == $controller){
										if($value['controller'] == 'conteudo'){
											if($value['url'] == $url_pagina){
												$active = " class='active' ";
											} else {
												$active = "";
											}
										} else {
											$active = " class='active' ";
										}
									} else {
										$active = "";
									}

									echo "<li><a href='".$value['destino']."' ".$active." >";

									echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

									if(count($value['submenu']) != 0){

										echo "<ul>";
										echo "
										<span class='setasub'></span>
										<div class='submenu_esq' >
										";

										menu($value['submenu'], $controller, $url_pagina);								 

										echo "</div>";											 

										echo "<div style='clear:both' ></div>";
										echo "</ul>";
									}

									echo "</li>";
								}
							}

							if($controller == 'conteudo'){
								menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
							} else {
								menu($conteudo_sessao['menu'], $controller, '');
							}

							?>
						</ul>
					</div>

					<div style="clear: both;"></div>
				</div>

			</div>

			<div style="clear: both;"></div>		

		</header>

		<section class="margemtopo"></section>

		<script type="text/javascript">
			function abremenu(){
				$('.anime_menu').addClass('anime_menu2');
				$('.botao_menu_responsivo').hide();
				$('.botao_menu_responsivo_fechar').show();
			}
			function fechamenu(){
				$('.anime_menu').removeClass('anime_menu2');
				$('.botao_menu_responsivo').show();
				$('.botao_menu_responsivo_fechar').hide();
			}	
		</script>


	<?php } ?>



	<?php if($conteudo_sessao['data_topo']->modelo == 13){ ?>

		<style type="text/css">
			@media (max-width: 770px){
				#header{
					position: relative !important;
				}
				.margemtopo{
					display: none !important;
				}
			}
			.topo_superior{
				background-color: <?=$cores[309]?>;
				color: <?=$cores[310]?> !important;
			}
			.topo_superior i{ 
				color: <?=$cores[310]?> !important;
			}
			.topo_superior a{ 
				color: <?=$cores[310]?> !important;
			}
			.topo_contatos_item{
				color: <?=$cores[310]?> !important;
			}
			.fundomenuresponsivo{
				font-family: <?=$fonte_topo_menu?> !important;  
				min-height: 0px !important;
			}


			 
		</style>


		<header id="header" >

			<div class="topo13" >

				<div class="header-top topo_superior" >
					<div class="container" >
						<div class="row" >
							<div class="col-xs-12 col-sm-7 col-md-6">

								<div class="topo_contatos" >
									<?php if($conteudo_sessao['data_topo']->fone1){ ?>
										<div class="topo_contatos_item" >
											<i class="fas fa-phone"></i> <?=$conteudo_sessao['data_topo']->fone1?>
										</div>
									<?php } ?>
									<?php if($conteudo_sessao['data_topo']->fone2){ ?>
										<div class="topo_contatos_item" >
											<i class="fab fa-whatsapp"></i> <?=$conteudo_sessao['data_topo']->fone2?>
										</div>
									<?php } ?>
									<?php if($conteudo_sessao['data_topo']->email){ ?>
										<div class="topo_contatos_item" >
											<i class="fas fa-envelope"></i> <?=$conteudo_sessao['data_topo']->email?>
										</div>								
									<?php } ?>
									<div style="clear: both;"></div>
								</div>

							</div>
							<div class="col-xs-12 col-sm-5 col-md-6">
								<div class="div_botoes_topo">

									<?php

									foreach ($lista_icones as $key => $value) { 

										$array = explode('http', $value['destino']);
										if(count($array) > 1){
											$destinolink = "href='".$value['destino']."'";
										} else {

											if($value['destino'] == 'index/ligamospravc'){											
												$destinolink = "href='#' onclick=\"modal('".DOMINIO."index/ligamospravc');\" ";
											} else {
												$destinolink = "href='".DOMINIO.$value['destino']."'";
											}
										}

										echo "
										<a class='botao_conta_topo' $destinolink >
										".$value['icone']."
										<span>".$value['titulo']."</span>
										</a>
										";

									}

									?>
									<div style="clear: both;"></div>
								</div>
							</div>
						</div>
					</div>				
				</div>



				<div id="topo" class="header-middle" >
					<div class="container" >
						<div class="row" >

							<div class="col-xs-8 col-sm-3 col-md-3">
								<div class="logo_div">
									<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
								</div>
							</div>

							<?php if(count($botoes) > 0){ ?>

								<div class="col-xs-12 col-sm-9 col-md-6 fundomenuresponsivo" >

								<?php } else { ?>

									<div class="col-xs-12 col-sm-9 col-md-9 fundomenuresponsivo" >

									<?php } ?>

									<div class="navbar-header" >
										<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
											<i class="fa fa-bars" aria-hidden="true"></i>
										</button>
									</div>

									<div class="mainmenu">
										<ul class="nav navbar-nav collapse navbar-collapse">

											<?php

											function menu($array, $controller, $url_pagina = null){

												foreach ($array as $key => $value) {

													if($value['controller'] == $controller){
														if($value['controller'] == 'conteudo'){
															if($value['url'] == $url_pagina){
																$active = " class='active' ";
															} else {
																$active = "";
															}
														} else {
															$active = " class='active' ";
														}
													} else {
														$active = "";
													}

													echo "<li><a href='".$value['destino']."' ".$active." >";

													echo "<span class='mainmenu_txt' >".$value['icone']." ".$value['titulo']."</span></a>";

													if(count($value['submenu']) != 0){

														echo "<ul>";
														echo " 
														<div class='submenu_esq' >
														";

														menu($value['submenu'], $controller, $url_pagina);								 

														echo "</div>";											 

														echo "<div style='clear:both' ></div>";
														echo "</ul>";
													}

													echo "</li>";
												}
											}

											if($controller == 'conteudo'){
												menu($conteudo_sessao['menu'], $controller, 'conteudo/pag/id/'.$pagina['url']);
											} else {
												menu($conteudo_sessao['menu'], $controller, '');
											}

											?>

											<?php if(count($botoes) > 0){ ?>

												<div class="botoes_topo_div_resp">
													<?php
													foreach ($botoes as $key => $value) {
														echo $value['botao'];
													}											
													?>
												</div> 

											<?php } ?>
										</ul>



									</div>

								</div>

								<?php if(count($botoes) > 0){ ?>

									<div class="col-xs-12 col-sm-12 col-md-3">
										<div class="botoes_topo_div">
											<?php
											foreach ($botoes as $key => $value) {
												echo $value['botao'];
											}											
											?>
										</div>
									</div>

								<?php } ?>

							</div>
						</div>

					</div>
				</div>

			</div>

		</header>

		<section class="margemtopo"></section>

		<?php } ?>