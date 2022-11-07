<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
 ?>
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
	 <link href="<?=LAYOUT?>css/custom.css" rel="stylesheet" type="text/css" />

	<?php include_once('htm_css.php'); ?>
	<?php include_once('htm_css_resp.php'); ?>

	<style type="text/css">
		.nome_trilha_curso{
			font-size: 18px;
			font-family: 'Roboto';
			color: #97999b;
			/* margin-left: 8px; */
		}
		ul {
        padding: 0;
	}
	.pontuacao {
		font-size: 16px;
		margin-bottom: 0px;
		margin-left: 0px;
		margin-top: 10px;
		font-family: roboto;
		font-weight: 300;
	}
	ul li{
		padding-bottom: 8px;
	}
	body {
		/* background-color:#f4f4f4; */
		background-color:#fff;
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
	/* @media (min-width: 1200px){
			.container {
				width: 100%;
			}
		} */
		.cart {
			background: <?=$primaria?> !important;
			color: #FFF !important;
			margin: 0px !important;
			padding: 12px 30px !important;
			border-radius: 20px !important;
			font-size: 18px;
			text-transform: uppercase;
		}
	.et_pb_bottom_inside_divider {
/* 		
		background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2Mi4xIDExNi4yNmE3My4yOSA3My4yOSAwIDAgMS0zOS4wOSA2TDAgMHYxNDBoMTI4MHoiLz48L2c+PC9zdmc+);
		background-size: 100% 100px;
		bottom: 0;
		height: 100px;
		z-index: 1;
		margin-top: -120px; */
	}
	@media (min-width: 1200px){
		.container {
			width: 80% !important;
		}
	}
	@media (min-width: 951px) and (max-width: 1200px){
		.container_flex {
			grid-auto-columns: 30% !important;
		}
	}
	.pontuacao_curso {font-size: 12px;margin-bottom: 0px;margin-top: 10px;display: grid;grid-template-columns: 1fr 1fr;}
	.pontuacao_curso > span:nth-child(1) {text-align: left;}
	.pontuacao_curso > span:nth-child(2) {text-align: right;}
	.bottom_card {grid-template-columns: 2fr 1fr;}
	.name-author {min-height: 60px;}
	body{background-color: #F9F9F9;}
	.desc_bloc{box-shadow:none}
	.item{float: left;width: 100%;margin-right: 20px;margin-bottom: 20px;}
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
	<?php 
		// echo '<pre>';print_r($valor_principal);exit;
		if($imagens[0]['imagem_g']){
			$back_image = $imagens[0]['imagem_g'];
		}
	?>

	<div class="jumbotron jumb_produto" style="background-image: url(<?=$back_image?>)">
		<div class="container" style="width: 80%;">
			<p class="bem_vindo_canal" style="margin: 10px 0px !important;">TRILHA</p>
        	<p class="canal_do"><?=$data->titulo?> </p>
		</div>
	</div>  
	<div class="et_pb_bottom_inside_divider2"></div>
	<section class="animate-effect" style="margin-top:50px; margin-bottom: 50px;">
		<form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?><?=$controller?>/carrinho_adicionar" method="post" enctype="multipart/form-data" >
			<div class="container">
				<div class="row">
					<?php
					$valor_principal = explode(",",$valor_principal);
					if($data->banner != ''){ ?>
						<div class='col-xs-12 col-sm-5 col-md-5'>
							<img src="/arquivos/banner_img_produto_g/<?=$data->codigo?>/<?=$data->banner?>" alt="">
						</div>
						<div class='col-xs-12 col-sm-4 col-md-4'>
							<div class="desc_bloc">
								<div class="style1" style="margin-top: 20px;"><?=$data->summary?></div>
							</div>
						</div>
						<div class='col-xs-12 col-sm-3 col-md-3'>
							<div class="produto_detalhes_valor" style="text-align: center;">
								<div class="produtos_detalhes_valortotal" style="text-decoration: line-through;"></div>
								<div class="produtos_detalhes_valortotal" style="margin-top: 0px; font-weight:500;color:#2C3E50">Investimento:</div>
								<?php if($valor_de != '0,00'){ ?>
								<div style="color: #9C9C9C;font-size: 24px;font-weight: 300;text-decoration: line-through;">R$ <?=$valor_de?></div>
								<?php } ?>
								<span id="produto_valor_unitario" style="color:#2C3E50">
									<span style="color:#2C3E50;font-size: 30px;">R$</span>
									<span style="color:#2C3E50;margin-left: -5px;font-size: 50px;"><?=$valor_principal[0]?></span>
									<span style="color:#2C3E50;font-size: 30px;margin-left: -10px;">,<?=$valor_principal[1]?>
								</span>
								<input type='hidden' id='produto_valor_unitario_inicial' name='produto_valor_unitario_inicial' value='<?=$valor_banco?>' >
								<div id="valorartevisual" ></div>
								<div id="div_comprar"></div>
							</div>
						</div>
					<?php }else{ ?>
							<div class='col-xs-12 col-sm-6 col-md-6'>
							<div class="desc_bloc">
								<div class="style1" style="margin-top: 20px;"><?=$data->summary?></div>
							</div>
						</div>
						<div class='col-xs-12 col-sm-6 col-md-6'>
							<div class="produto_detalhes_valor" style="text-align: center;">
								<div class="produtos_detalhes_valortotal" style="text-decoration: line-through;"></div>
								<div class="produtos_detalhes_valortotal" style="margin-top: 0px; font-weight:500;color:#2C3E50">Investimento:</div>
								<?php if($valor_de != '0,00'){ ?>
								<div style="color: #9C9C9C;font-size: 24px;font-weight: 300;text-decoration: line-through;">R$ <?=$valor_de?></div>
								<?php } ?>
								<span id="produto_valor_unitario" style="color:#2C3E50">
									<span style="color:#2C3E50;font-size: 30px;">R$</span>
									<span style="color:#2C3E50;margin-left: -5px;font-size: 50px;"><?=$valor_principal[0]?></span>
									<span style="color:#2C3E50;font-size: 30px;margin-left: -10px;">,<?=$valor_principal[1]?>
								</span>
								<input type='hidden' id='produto_valor_unitario_inicial' name='produto_valor_unitario_inicial' value='<?=$valor_banco?>' >
								<div id="valorartevisual" ></div>
								<div id="div_comprar"></div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="row ak" style="padding-top: 50px;padding-bottom: 50px;">
					<div class='col-xs-12 col-sm-12 col-md-12'>
						<?php if(isset($lista_cursos)){?>
							<div class="snaps-inline owl-carousel owl-theme">
								<?php foreach($lista_cursos as $value){ 
									$conexao = new mysql();
									if($value['capa']){
										$imagem = $value['capa'];
									} else {
										$imagem = LAYOUT."img/semimagem.png";
									}
									$endereco_img = DOMINIO."/arquivos/img_cursos_g/".$value['id']."/";
									$endereco = DOMINIO.$controller."/curso/id/".$value['id']."/";
									$botao_comprar = str_replace("aquivaiolink", " href='".$endereco."' ", $conteudo_sessao->botao);
									$id_curso = $value['id'];
									$tags = mysqli_query($conexao,"SELECT * FROM produto_categoria inner join curso_categoria_sel on produto_categoria.codigo = curso_categoria_sel.categoria_codigo WHERE curso_categoria_sel.curso_id = $id_curso ORDER BY RAND() LIMIT 3;");
									$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);

									$curso_conteudo = mysqli_query($conexao,"SELECT * FROM conteudo_curso_topico WHERE id_produto = $id_curso ORDER BY RAND() LIMIT 3;");
									$curso_conteudo = $curso_conteudo->fetch_all(MYSQLI_ASSOC);

									?>
									<div class="item">
										<div class="grid1">
											<div style="position:relative">
												<div class="box_overlay" style="background-image: linear-gradient(#00000000, #0000007d);"></div>
												<a href="<?=$endereco?>">
													<!-- <img src="<?=$endereco_img.$imagem?>" height="200" width="auto" alt=""> -->
													<div style="background-image: url(<?=$endereco_img.$imagem?>);min-height: 200px;background-repeat: no-repeat;background-position: center center;background-size: 550px;border-radius: 20px 20px 0px 0px;"></div>
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
														<span class="points" style="color:white"><?=$value['total_estrelas']?></span> 
													</span>
												</div>
												<div></div>
											</div>
											<div class="desc_text" style="margin-left: 8px;">
												<div class="name-author all">
													<a style="color: #2C3E50;" href="<?=$endereco?>"><?=$value['nome']?></a>
												</div>
												<p class="nome_trilha_curso"><?=$data->titulo?></p>
												<div class="pontuacao">
													<ul>
														<li><i class="fas fa-graduation-cap"></i> <?=count($curso_conteudo)?> <?php if(count($curso_conteudo) <= 1 ){echo 'aula';}else{echo'aulas';} ?></li>
														<li><i class="fas fa-clock"></i><?=$value['total_minutos']?></li>
														<!-- <li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li> -->
													</ul>
												</div>
												<p style="line-height: 16px;font-size:12px;margin-top: 10px;min-height: 110px;">
													<a style="color: #7F7F7F;" href="<?=$endereco?>"><?=substr($value['descricao_card'], 0, 350);?>...</a>
												</p>
											</div>
											<div style="padding-left: 8px;">    
												<a href="<?=$endereco?>"><div><i style="float: left;border: 2px #2C3E50 solid;padding: 5px 8px;border-radius: 15px;color: #2C3E50;font-size: 10px;margin-left: 8px;" class="fas fa-info"></i> <p style="color: #2C3E50;font-weight: 500;margin-left: 6px;float: left;" class="">SAIBA MAIS</p></div></a>
												<div></div>
											</div>
										</div>
									</div>
								<?php } ?>		
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12'>
						<div class="desc_bloc">
							<div class="style1" style="margin-top: 20px;"><?=$data->descricao?></div>
						</div>
					</div>
				</div>
				<?= $botao_comprar ?> 
			</div>
		</form>
		<div style="text-align: center;">
			<button style="background: <?=$primaria?>;border: none;padding: 6px 50px;border-radius: 8px;color: #fff;font-size: 16px;" onclick="history.go(-1);">Voltar</button>
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

				var valor_total = valor_inicial;

				var valor_total_tratado = numeroParaMoeda(valor_total);
				// $('#produto_valor_unitario').html("R$ "+valor_total_tratado);
				
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
			// $('#produto_valor_unitario').html("R$ "+valor_total_tratado);

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
			// $('#produto_valor_unitario').html("R$ "+valor_total_tratado);

			return v
		}

	                </script>
</body>
</html>