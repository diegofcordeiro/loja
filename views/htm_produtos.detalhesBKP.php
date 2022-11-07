<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title><?=$data->titulo?> - <?=$data_pagina->meta_titulo?></title>
	<link rel="shortcut icon" href="<?=$_base['favicon'];?>" />

	<meta name="description" content="<?=$data->previa?>" />
	<meta property="og:description" content="<?=$data->previa?>" />
	<meta name="author" content="<?=AUTOR?>" />
	<meta name="classification" content="Website" />
	<meta name="robots" content="index, follow" />
	<meta name="Indentifier-URL" content="<?=DOMINIO?>" />

	<link href="<?=LAYOUT?>api/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>api/fontawesome/css/all.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>css/animate.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>api/hover-master/css/hover-min.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>css/main.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>css/responsiveslides.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>api/bxslider/jquery.bxslider.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>api/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css" rel="stylesheet" type="text/css" />
	<link href="<?=LAYOUT?>api/photobox-master/photobox/photobox.css" rel="stylesheet" type="text/css"> 
	<link href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" rel="stylesheet" type="text/css" />

	<?php include_once('htm_css.php'); ?>
	<?php include_once('htm_css_resp.php'); ?>

	<style type="text/css">
	body {
		background-color:<?=$pagina_cores[1]?>;
	}
.style1 {
	font-size: 36
}
    .style2 {
	font-size: 24px;
}
    .style3 {	font-size: 12px
}
.style6 {font-size: 14px}
    </style>
</head>
<body>

	<?=$_base['analytics']?>

	<?php include_once('htm_modal.php'); ?>

	<?php
	// topo 
	foreach ($layout_lista as $key_layout => $value_layout) {

		if($value_layout['full'] != 1){
			echo "<div class='container' >";
		}
		echo "<div class='row' style='margin-right:0px; margin-left:0px;' >";

		if($value_layout['colunas'] == 1){
			?>

			<div class="col-md-12 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if($conteudo_coluna['tipo'] == 'topo'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>

		<?php }

		if($value_layout['colunas'] == 2){

			if($value_layout['formato'] == '6_6'){
				?>      

				<div class="col-md-6 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-6 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>          
				</div>

			<?php }

			if($value_layout['formato'] == '4_8'){
				?>        

				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-8 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			<?php }

			if($value_layout['formato'] == '8_4'){
				?>
				<div class="col-md-8 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>        
			<?php }

		}

		if($value_layout['colunas'] == 3){

			if($value_layout['formato'] == '4_4_4'){
				?>

				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

			<?php }


			if($value_layout['formato'] == '2_5_5'){
				?>      

				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

			<?php }


			if($value_layout['formato'] == '5_2_5'){
				?>      

				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			<?php }

			if($value_layout['formato'] == '5_5_2'){
				?>        

				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			<?php }

		}

		if($value_layout['colunas'] == 4){

			if($value_layout['formato'] == '3_3_3_3'){
				?>                                

				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			<?php }


			if($value_layout['formato'] == '4_2_2_4'){
				?>

				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

			<?php }

			if($value_layout['formato'] == '2_4_4_2'){
				?>

				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'topo'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

				<?php
			}

		}

		if($value_layout['colunas'] == 6){
			?>

			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if($conteudo_coluna['tipo'] == 'topo'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna2'];
				if($conteudo_coluna['tipo'] == 'topo'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna3'];
				if($conteudo_coluna['tipo'] == 'topo'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna4'];
				if($conteudo_coluna['tipo'] == 'topo'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna5'];
				if($conteudo_coluna['tipo'] == 'topo'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>              
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna6'];
				if($conteudo_coluna['tipo'] == 'topo'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>

		<?php }


		echo "
		</div>
		";

		if($value_layout['full'] != 1){
			echo "</div>";
		}

	}
	
	// termina topo
	?>

	<section class="animate-effect" style="margin-top:50px; margin-bottom: 50px;">
		<div class="container">
			<div class="row">
				<div class='col-xs-12 col-sm-12 col-md-12'>
					<div class="produtos_detalhes_margin" >
						<h2 class="produto_detalhes_titulo">AQUI<?=$data->titulo?></h2>
						<div class="product-details">
							<div class="row">
								<div class='col-xs-12 col-sm-6 col-md-5'>
									<div id="similar-product" class="carousel slide" data-ride="carousel">
										<div class="carousel-inner" id="gallery" >
											<?php
											$i = 0;
											foreach ($imagens as $key => $value) {

												if($i == 0){
													$active = " active";
												} else {
													$active = "";
												}
												echo "
												<div class='item$active' >
												<div class='produto_imagem_detalhes' style='background-image:url(".$value['imagem_g'].");' >
												<div class='produto_imagem_lupa' >
												<a href='".$value['imagem_g']."' ><img src='".$value['imagem_p']."' style='width:100%; height:100%;' ></a>
												</div>
												</div>
												</div>
												";
												$i++;
											}
											if($i == 0){
												$imagem = LAYOUT."img/semimagem.png";
												echo "
												<div class='item active' >
												<div id='gallery' class='produto_imagem_detalhes' style='background-image:url($imagem);' >
												<img src='".LAYOUT."img/transp.png' style='width:100%; height:100%;' >
												</div>
												</div>
												";

												$i++;
											}

											?>
										</div>
										<?php if($i > 1){ ?>
											<a class="left item-control" href="#similar-product" data-slide="prev">
												<i class="fa fa-angle-left"></i>											</a>
											<a class="right item-control" href="#similar-product" data-slide="next">
												<i class="fa fa-angle-right"></i>											</a>
										<?php } ?>
									</div>
									<?php if(count($gabaritos) > 0){ ?>
										<diV style="text-align: center; margin-top:10px;">
											<?php
											foreach ($gabaritos as $key => $value) {
												echo "
												<a href='".$value['link']."' target='_blank' style='display:inline-block; margin:10px; font-size: 12px; color:#000; ' >
												<img src='".$value['ico']."' style='max-width:150px; display:block' >
												<span style='display:inline-block; color:#000; padding-top:10px; padding-bottom:10px; text-align: center;  font-weight: bold; '>".$value['titulo']."</span>
												</a>
												";

											}

											?>
										</diV>

									<?php } ?>
								</div>
								
								
								<div class="col-xs-12 col-sm-6 col-md-7">
									<div class="product-information" style="border:none; padding-top: 0px;" >                 

										<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >

											<?php if($data->ref){ ?>
												<div class="produto_detalhes" ><strong> Ref.:</strong> <?=$data->ref?></div>
											<?php } ?>

											<?php if($data->formato){ ?>
												<div class="produto_detalhes" ><strong> Formato:</strong> <?=$data->formato?></div>
											<?php } ?>

											<?php if($data->cores){ ?>
												<div class="produto_detalhes" ><strong> Cores:</strong> <?=$data->cores?></div>
											<?php } ?>

											<?php if($data->material){ ?>
												<div class="produto_detalhes" ><strong> Material:</strong> <?=$data->material?></div>
											<?php } ?>

											<?php if($data->revestimento){ ?>
												<div class="produto_detalhes" ><strong> Revestimento:</strong> <?=$data->revestimento?></div>
											<?php } ?>

											
											<?php if($data->producao){ ?>
												<div class="produto_detalhes" ></div>
											    <?php } ?>

											<?php
											if($data->impresso == 1){ 
												?>
												<div style="margin-top: 20px;">
													<div style="font-size: 14px; padding-bottom: 5px; font-weight: bold;">Selecione uma opção:</div>
													<select name="tipoarte" class="form-control" style="width:100%;" onChange="carregatipoarte(this.value);">
														<option value="0" selected="" >Selecione</option>
														<option value="1" <?php if($tipoarte == 1){ echo " selected='' "; } ?> >Escolher modelo GRATIS</option>
														<option value="2" <?php if($tipoarte == 2){ echo " selected='' "; } ?> >Contratar criação de arte</option>
														<option value="3" <?php if($tipoarte == 3){ echo " selected='' "; } ?> >Enviar meu arquivo/arte</option>
													</select>
												</div>

												<hr>

												<div id="tipo_arte"></div>

											<?php } ?>											

											<hr>

											<?php

                                          	// esconde valor para nao logados
											$esconder_valor = false;
											if($data->esconder_valor == 1){
												if(!$_cod_usuario){
													$esconder_valor = true;
												}
											}

											if(!$esconder_valor){

												$mostra = "";                                    
												foreach ($tamanhos as $key => $value) {

													$mostra .= "<option value='".$value['codigo']."' rel='".$value['valor']."' >".$value['titulo']."</option>";

												}

												if($mostra){

													?>
													<div class="produto_detalhes" >Tamanho:</div>
													<div style="padding-bottom:10px;">
														<select name="tamanho" id="combo_tamanho" onChange="recalcular()" >
															<option value='0' rel='0' selected >Selecione</option>
															<?=$mostra?>
														</select>
													</div>

												<?php } else { ?>

													<div style="display:none;">
														<select name="tamanho" id="combo_tamanho" >
															<option value='0' rel='0' selected >Selecione</option>
														</select>
													</div>

												<?php } ?>

												<?php

												$mostra = "";                
												foreach ($produtos_cores as $key => $value) {

													$mostra .= "<option value='".$value['codigo']."' rel='".$value['valor']."' >".$value['titulo']."</option>";

												}

												if($mostra){

													?>
													<div class="produto_detalhes" >Cor:</div>
													<div style="padding-bottom:10px;">
														<select name="cor" id="combo_cor" onChange="recalcular()" >
															<option value='0' rel='0' selected >Selecione</option>
															<?=$mostra?>
														</select>
													</div>

												<?php } else { ?>

													<div style="display:none;">
														<select name="cor" id="combo_cor" >
															<option value='0' rel='0' selected >Selecione</option>
														</select>
													</div>

												<?php } ?>

												<?php

												$mostra = "";     
												foreach ($variacoes as $key => $value) {

													if($opcao_selecionada == $value['codigo']){
														$selected = " selected='' ";
													} else {
														$selected = "";
													}

													$mostra .= "<option value='".$value['codigo']."' $selected rel='".$value['valor']."' >".$value['titulo']."</option>";

												}

												if($mostra){

													if($modelogratisselecionado){
														$destinoquantidade = DOMINIO.$controller.'/produto/id/'.$data->id.'/modelogratisselecionado/'.$modelogratisselecionado.'/tipoarte/'.$tipoarte.'/opcao/';
													} else {
														$destinoquantidade = DOMINIO.$controller.'/produto/id/'.$data->id.'/tipoarte/'.$tipoarte.'/opcao/';
													}

													?>
													<div class="produto_detalhes" >Quantidade:</div>
													<div style="padding-bottom:10px;">
														<select name="variacao" id="combo_variacao" onChange="window.location='<?=$destinoquantidade?>'+this.value;" >
															<?=$mostra?>
														</select>
													</div>

												<?php } else { ?>

													<div style="display:none;">
														<select name="variacao" id="combo_variacao" >
															<option value='0' rel='0' selected >Selecione</option>
														</select>
													</div>

												<?php } ?>


												<?php if($data->tipo == 1){  // metros ?>

													<div class="row">
														<div class='col-xs-12 col-sm-6 col-md-6'>

															<div class="produto_detalhes" >Largura (m²):</div>
															<div style="padding-bottom:10px;">
																<input type="text" name="tamanho_largura" id="tamanho_largura" class="form-control" value="1,00" onKeyPress="Mascara(this,calculo_medida_largura)" onKeyDown="Mascara(this,calculo_medida_largura)" />
															</div>
														</div>
														<div class='col-xs-12 col-sm-6 col-md-6'>

															<div class="produto_detalhes" >Altura (m²):</div>
															<div style="padding-bottom:10px;">
																<input type="text" name="tamanho_altura" id="tamanho_altura" class="form-control" value="1,00" onKeyPress="Mascara(this,calculo_medida_altura)" onKeyDown="Mascara(this,calculo_medida_altura)" />
															</div>
														</div>
													</div>

												<?php } ?>


												<?php if($data->tipo == 2){  // centimetros ?>

													<div class="row">
														<div class='col-xs-12 col-sm-6 col-md-6'>

															<div class="produto_detalhes" >Largura (cm):</div>
															<div style="padding-bottom:10px;">
																<input type="text" name="tamanho_largura" id="tamanho_largura" class="form-control" value="1,00" onKeyPress="Mascara(this,calculo_medida_largura)" onKeyDown="Mascara(this,calculo_medida_largura)" />
															</div>
														</div>
														<div class='col-xs-12 col-sm-6 col-md-6'>

															<div class="produto_detalhes" >Altura (cm²):</div>
															<div style="padding-bottom:10px;">
																<input type="text" name="tamanho_altura" id="tamanho_altura" class="form-control" value="1,00" onKeyPress="Mascara(this,calculo_medida_altura)" onKeyDown="Mascara(this,calculo_medida_altura)" />
															</div>
														</div>
													</div>

												<?php } ?>
												
												
												<?php
												if($data->sobconsulta == 1){
													?>
													<div class="produtos_detalhes_valortotal" style="font-weight: bold; color:red;">PREÇO SOB-CONSULTA</div>
													<?php
												} else {
													?>
										  <div class="produto_detalhes_valor" >
											<div class="produtos_detalhes_valortotal" style="text-decoration: line-through;"><span class="produto_detalhes">
											<?=$data->acabamento?>
											</span></div>
											<div class="produtos_detalhes_valortotal" style="text-decoration: line-through;"></div>
														<div class="produtos_detalhes_valortotal" style="margin-top: 0px; font-weight:500;">Por apenas</div>
														<span id="produto_valor_unitario" >R$ <?=$valor_principal?></span>
														<div id="valorartevisual" ></div>

														<?php //if($data->fretegratis == 1){ echo " <span style='font-size:16px; color:#000;' >(Frete Grátis)</span>"; } ?>
														<input type='hidden' id='produto_valor_unitario_inicial' name='produto_valor_unitario_inicial' value='<?=$valor_banco?>' >
											            <span class="style6"><br>
								            </span>
											<!-- <span class="style6">
								            Pague com:</span><br> -->
                                                        <!-- <span class="style3"><img src="<?=$_base['imagem']['159432484772799']?>" width="277" height="58"></span><br> -->
									            </div>

													<span class="style1 style6">
							                        <?=$data->producao?>
							                        </span>
													<div id="div_comprar"></div>

													<div style="margin-top:20px;">
														<!-- <div class="produto_detalhes" ><strong> Forma de entrega:</strong>  -->
															<?php //if($data->digital == 1){ echo "Produto Digital"; } else { ?>
																<?php //if($data->tipo_entrega == 0){ echo "Correios"; } ?>
																<?php //if($data->tipo_entrega == 1){ echo "Retirada em balcão"; } ?>
																<?php //if($data->tipo_entrega == 2){ echo "Retirar no local"; } ?>
															<?php //} ?>
														</div>

														<?php if($data->tipo_entrega == 1){ ?>
															<!-- <hr>
															<div style="margin-top:10px; font-size: 12px;">Veja também nossos <a style="cursor: pointer;" onClick="modal('<?=DOMINIO?><?=$controller?>/balcoes/','Balcões de retirada');" >balcões de retirada</a></div> -->
														<?php } ?>
													</div>

												<?php } ?>

											<?php } else { echo "<div style='text-align:center; font-size:14px;'><a href='".DOMINIO.$controller."/autenticacao'>Cadastre-se</a> para ter acesso aos valores e efetuar compras</div>"; } // termian if de esconder valor  ?>
										</form>
								  </div>
								</div>
							</div>

							<hr>

							<div class="row">

								<div class="col-sm-12">

									<h4 class="style2" style="padding-top:20px;" >Descrição do Produto</h4> 

								  <div class="style1" style="margin-top: 20px;"><?=$data->descricao?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	





	<span class="style1">
	<?php

	// rodape
	foreach ($layout_lista as $key_layout => $value_layout) {
		
		if($value_layout['full'] != 1){
			echo "<div class='container' >";
		}
		echo "<div class='row' style='margin-right:0px; margin-left:0px;' >";

		if($value_layout['colunas'] == 1){
			?>
</span>
	<div class="col-md-12 corrige_cedulas_principais style1">
				<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
</div>

		<span class="style1">
		<?php }

		if($value_layout['colunas'] == 2){

			if($value_layout['formato'] == '6_6'){
				?>      
</span>
		<div class="col-md-6 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
</div>
				<div class="col-md-6 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>          
				</div>

			    <span class="style1">
			    <?php }

			if($value_layout['formato'] == '4_8'){
				?>        
				</span>
			    <div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-8 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			    <span class="style1">
			    <?php }

			if($value_layout['formato'] == '8_4'){
				?>
				</span>
			    <div class="col-md-8 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>        
			    <span class="style1">
			    <?php }

		}

		if($value_layout['colunas'] == 3){

			if($value_layout['formato'] == '4_4_4'){
				?>
				</span>
			    <div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

			    <span class="style1">
			    <?php }


			if($value_layout['formato'] == '2_5_5'){
				?>      
				</span>
			    <div class="col-md-2 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

			    <span class="style1">
			    <?php }


			if($value_layout['formato'] == '5_2_5'){
				?>      
				</span>
			    <div class="col-md-5 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			    <span class="style1">
			    <?php }

			if($value_layout['formato'] == '5_5_2'){
				?>        
				</span>
			    <div class="col-md-5 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			    <span class="style1">
			    <?php }

		}

		if($value_layout['colunas'] == 4){

			if($value_layout['formato'] == '3_3_3_3'){
				?>                                
				</span>
			    <div class="col-md-3 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>

			    <span class="style1">
			    <?php }


			if($value_layout['formato'] == '4_2_2_4'){
				?>
				</span>
			    <div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

			    <span class="style1">
			    <?php }

			if($value_layout['formato'] == '2_4_4_2'){
				?>
				</span>
			    <div class="col-md-2 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais style1">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div> 

				<span class="style1">
				<?php
			}

		}

		if($value_layout['colunas'] == 6){
			?>
			    </span>
				<div class="col-md-2 corrige_cedulas_principais style1">
				<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais style1">
				<?php

				$conteudo_coluna = $value_layout['coluna2'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais style1">
				<?php

				$conteudo_coluna = $value_layout['coluna3'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais style1">
				<?php

				$conteudo_coluna = $value_layout['coluna4'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais style1">
				<?php

				$conteudo_coluna = $value_layout['coluna5'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>              
			<div class="col-md-2 corrige_cedulas_principais style1">
				<?php

				$conteudo_coluna = $value_layout['coluna6'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>

		    <span class="style1">
		    <?php }


		echo "
		</div>
		";

		if($value_layout['full'] != 1){
			echo "</div>";
		}

	}

	// termina rodape
	?>

	        <script type="text/javascript" src="<?=LAYOUT?>js/jquery-2.2.4.min.js" ></script>
	        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	        <script type="text/javascript" src="<?=LAYOUT?>js/jquery-ui.min.js"></script>  
	        <script type="text/javascript" >function dominio(){ return '<?=DOMINIO?>'; }</script>
	        <script type="text/javascript" src="<?=LAYOUT?>js/funcoes.js"></script>
	        <script src='https://www.google.com/recaptcha/api.js'></script>
	        <script type="text/javascript" src="<?=LAYOUT?>js/animation.js"></script>
	        <script type="text/javascript" src="<?=LAYOUT?>js/responsiveslides.min.js"></script>
	        <script type="text/javascript" src="<?=LAYOUT?>api/photobox-master/photobox/jquery.photobox.js"></script>
	        <script type="text/javascript" src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	
	        <?php
	
	foreach ($layout_lista as $key_layout => $value_blocos) {
		$n_col = 1;
		while ($n_col <= $value_blocos['colunas']) {

			$value_layout = $value_blocos['coluna'.$n_col];
			
			if(isset($value_layout['tipo'])){
				
				if($value_layout['tipo'] == 'topo'){
					
					$conteudo_id = $value_layout['id'];
					$conteudo_sessao = $value_layout['conteudo'];
					$id_script = '#slider_topo_'.$conteudo_id;
					
					?>
					<script>

						<?php if($conteudo_sessao['data_topo']->modelo  == 11){ ?>

							$("<?=$id_script?>").responsiveSlides({
								auto: true,
								pager: false,
								nav: false,
								speed: 500,
								pause: true,
								pauseControls: true,
								namespace: "callbacks",
								before: function () {
									$('.events').append("<li>before event fired.</li>");
								},
								after: function () {
									$('.events').append("<li>after event fired.</li>");
								}
							});

						<?php } ?>
						
						$(document).ready(function(){
							$(window).on('scroll', function() {
								var posicao_topo = $(window).scrollTop();

								<?php if($conteudo_sessao['data_topo']->modelo  == 6){ ?>

									if(posicao_topo > 100){          
										$(".topo6").addClass("topo6_decendo");
									}
									if(posicao_topo < 100){          
										$(".topo6").removeClass("topo6_decendo");
									}

								<?php } ?>

								<?php if($conteudo_sessao['data_topo']->modelo  == 7){ ?>

									if(posicao_topo > 100){          
										$(".topo7").addClass("topo7_decendo");
									}
									if(posicao_topo < 100){          
										$(".topo7").removeClass("topo7_decendo");
									}

								<?php } ?>

								<?php if($conteudo_sessao['data_topo']->modelo  == 8){ ?>

									if(posicao_topo > 100){          
										$(".topo8").addClass("topo8_decendo");
									}
									if(posicao_topo < 100){          
										$(".topo8").removeClass("topo8_decendo");
									}

								<?php } ?>

								<?php if($conteudo_sessao['data_topo']->modelo  == 9){ ?>

									if(posicao_topo > 100){          
										$(".topo9").addClass("topo9_decendo");
									}
									if(posicao_topo < 100){          
										$(".topo9").removeClass("topo9_decendo");
									}

								<?php } ?>

								<?php if($conteudo_sessao['data_topo']->modelo  == 10){ ?>

									if(posicao_topo > 100){          
										$(".topo10").addClass("topo10_decendo");
									}
									if(posicao_topo < 100){          
										$(".topo10").removeClass("topo10_decendo");
									}

								<?php } ?>
								
								<?php if($conteudo_sessao['data_topo']->modelo  == 13){ ?>

									if(posicao_topo > 100){          
										$(".topo13").addClass("topo13_decendo");
									}
									if(posicao_topo < 100){          
										$(".topo13").removeClass("topo13_decendo");
									}
									
								<?php } ?>
								
							});
						});

					</script>
					<?php
				}
			}
			$n_col++;
		}

    // termina lista
	}

	?>

	                <script>        
		$(function(){
			$('#gallery').photobox('a',{ time:0 });
		});
	                </script>

	                <?php if($data_pagina->bloqueio == 1){ ?>

		            <script type="text/javascript">

			$(document).ready(function(){
				$(document).bind("contextmenu",function(e){
					return false;
				});

				$('body').bind('contextmenu', function(event) {
					event.preventDefault();
				});

				$('body').bind('selectstart dragstart', function(event) {
					event.preventDefault();
					return false;
				});

				$("body").bind("cut copy paste", function() {
					return false;
				});

				$('body').focus(function() {
					$(this).blur();
				});

			});
		            </script>

	                <?php } ?> 
            </span>
            <script>

		<?php
		if($data->impresso == 1){ 
			?>

			function carregatipoarte(id) {
				$.post('<?=DOMINIO?><?=$controller?>/produto_tipoarte', {id: id, produto: '<?=$data->codigo?>', modelogratisselecionado: '<?=$modelogratisselecionado?>', opcao:'<?=$opcao_selecionada?>'},function(data){
					if(data){

						if(id == 2){
							$('#valorartevisual').html('Criação de arte adicional de: R$ <?=$valor_arte_tratado?>');
						} else {
							$('#valorartevisual').html('');
						}

						$('#tipo_arte').html(data);

						if(id == 1){
							var modelogratisselecionado = '<?=$modelogratisselecionado?>';
							if(modelogratisselecionado == ''){

								modal('<?=DOMINIO?><?=$controller?>/produto_modelos_gratis/produto/<?=$data->codigo?><?php if($opcao_selecionada){ echo "/opcao/".$opcao_selecionada; } ?>','Selecione o modelo');

							}
						}
					}
				});
			}
			<?php if($modelogratisselecionado){ ?>
				carregatipoarte('<?=$tipoarte?>');
			<?php } ?>

		<?php } ?>



		<?php if(!$esconder_valor){ ?>

			function recalcular(){

				var valor_inicial = parseFloat($('#produto_valor_unitario_inicial').attr('value'));

				var tamanho = parseFloat($('#combo_tamanho :selected').attr('rel'));
				var tamanho_codigo = parseFloat($('#combo_tamanho :selected').attr('value'));

				var cor = parseFloat($('#combo_cor :selected').attr('rel'));
				var cor_codigo = parseFloat($('#combo_cor :selected').attr('value'));

				var variacao = parseFloat($('#combo_variacao :selected').attr('rel'));
				var variacao_codigo = parseFloat($('#combo_variacao :selected').attr('value'));

				var valor_total = valor_inicial + tamanho + cor;

				var valor_total_tratado = numeroParaMoeda(valor_total);
				$('#produto_valor_unitario').html("R$ "+valor_total_tratado);
				
				$.post('<?=DOMINIO?><?=$controller?>/detalhes_estoque', {id: <?=$data->id?>, produto: <?=$data->codigo?>, tamanho: tamanho_codigo, cor: cor_codigo, variacao: variacao_codigo},function(data){
					if(data){
						$('#div_comprar').html(data);
					}
				});
			}

			recalcular();

		<?php } ?>

		function calculo_medida_largura(v){
			v=v.replace(/\D/g,"");
			v=v.replace(/(\d{2})$/,",$1");
			v=v.replace(/(\d+)(\d{3},\d{2})$/g,"$1$2");
			var qtdLoop = (v.length-3)/3; var count = 0;
			while (qtdLoop > count){ count++;
				v=v.replace(/(\d+)(\d{3}.*)/,"$1$2");
			}v=v.replace(/^(0)(\d)/g,"$2");

			var valor_inicial = parseFloat(<?=$valor_banco?>);

			var tamanho_altura = $('#tamanho_altura').val();
			tamanho_altura = tamanho_altura.replace(",", ".");
			tamanho_altura = parseFloat(tamanho_altura);

			var tamanho_largura = v;
			tamanho_largura = tamanho_largura.replace(",", ".");
			tamanho_largura = parseFloat(tamanho_largura);

			var valor_total = tamanho_largura * tamanho_altura * valor_inicial;

			var valor_total_tratado = numeroParaMoeda(valor_total);
			$('#produto_valor_unitario').html("R$ "+valor_total_tratado);

			return v
		}

		function calculo_medida_altura(v){  
			v=v.replace(/\D/g,"");
			v=v.replace(/(\d{2})$/,",$1");
			v=v.replace(/(\d+)(\d{3},\d{2})$/g,"$1$2");
			var qtdLoop = (v.length-3)/3; var count = 0;
			while (qtdLoop > count){ count++;
				v=v.replace(/(\d+)(\d{3}.*)/,"$1$2");
			}v=v.replace(/^(0)(\d)/g,"$2");

			var valor_inicial = parseFloat(<?=$valor_banco?>);

			var tamanho_largura = $('#tamanho_largura').val();
			tamanho_largura = tamanho_largura.replace(",", ".");
			tamanho_largura = parseFloat(tamanho_largura);

			var tamanho_altura = v;
			tamanho_altura = tamanho_altura.replace(",", ".");
			tamanho_altura = parseFloat(tamanho_altura);

			var valor_total = tamanho_largura * tamanho_altura * valor_inicial;

			var valor_total_tratado = numeroParaMoeda(valor_total);
			$('#produto_valor_unitario').html("R$ "+valor_total_tratado);

			return v
		}

	                </script>
</body>
</html>