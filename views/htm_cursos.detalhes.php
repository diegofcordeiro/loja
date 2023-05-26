<?php if (!isset($_base['libera_views'])) {
	header("HTTP/1.0 404 Not Found");
	exit;
} ?>
<!DOCTYPE html>
<html>

<head>

	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title><?= $data->titulo ?> - <?= $data_pagina->meta_titulo ?></title>
	<link rel="shortcut icon" href="<?= $_base['favicon']; ?>" />

	<meta name="description" content="<?= $data->nome ?>" />
	<meta property="og:description" content="<?= $data->nome ?>" />
	<meta name="author" content="<?= AUTOR ?>" />
	<meta name="classification" content="Website" />
	<meta name="robots" content="index, follow" />
	<meta name="Indentifier-URL" content="<?= DOMINIO ?>" />

	<link href="<?= LAYOUT ?>api/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>api/fontawesome/css/all.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>css/animate.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>api/hover-master/css/hover-min.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>css/main.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>css/responsiveslides.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>api/bxslider/jquery.bxslider.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>api/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>api/photobox-master/photobox/photobox.css" rel="stylesheet" type="text/css">
	<link href="<?= LAYOUT ?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= LAYOUT ?>css/custom.css" rel="stylesheet" type="text/css" />

	<?php include_once('htm_css.php'); ?>
	<?php include_once('htm_css_resp.php'); ?>

	<style type="text/css">
		body {
			/* background-color:#f4f4f4; */
			background-color: #141414;
		}

		.style1 {
			font-size: 36
		}

		.style2 {
			font-size: 24px;
		}

		.style3 {
			font-size: 12px
		}

		.style6 {
			font-size: 14px
		}

		/* @media (min-width: 1200px){
        .container {
            width: 100%;
        }
    } */
		.cart {
			background: #85dbd0 !important;
			color: #FFF !important;
			margin: 0px !important;
			padding: 10px 20px !important;
			border-radius: 10px !important;
		}

		.et_pb_bottom_inside_divider {

			/* background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2Mi4xIDExNi4yNmE3My4yOSA3My4yOSAwIDAgMS0zOS4wOSA2TDAgMHYxNDBoMTI4MHoiLz48L2c+PC9zdmc+);
    background-size: 100% 100px;
    bottom: 0;
    height: 100px;
    z-index: 1;
    margin-top: -120px; */
		}

		.jumbotron {
			background-color: #F9F9F9;
		}

		@media (min-width: 1200px) {
			.container {
				width: 80% !important;
			}
		}

		.progress {
			height: 10px;
			margin-bottom: 10px;
			overflow: hidden;
			background-color: #f5f5f5;
			border-radius: 4px;
			-webkit-box-shadow: none !important;
			box-shadow: none !important;
			margin-top: 10px;
		}

		.progress-bar {
			float: left;
			width: 0;
			border: none;
			height: 100%;
			font-size: 12px;
			line-height: 20px;
			color: #fff;
			height: 10px;
			text-align: center;
			background-color: #c1c1c1;
			/* -webkit-box-shadow: none; */
			box-shadow: inset 0 0px 0 rgb(0 0 0 / 15%);
			/* -webkit-transition: width .6s ease; */
			-o-transition: width .6s ease;
			/* transition: width .6s ease; */
		}

		.panel-default>.panel-heading {
			color: white !important;
			background-color: #292929 !important;
		}

		.panel-group .panel {
			border: none !important;
		}

		.modal-content {
			background-color: #fff0 !important;
			border: none !important;
			-webkit-box-shadow: none !important;
		}
	</style>
</head>

<body>
	<?= $_base['analytics'] ?>
	<?php include_once('htm_modal.php'); ?>
	<?php
	// topo 
	foreach ($layout_lista as $key_layout => $value_layout) {

		if ($value_layout['full'] != 1) {
			echo "<div class='container' >";
		}
		echo "<div class='row' style='margin-right:0px; margin-left:0px;' >";

		if ($value_layout['colunas'] == 1) {
	?>

			<div class="col-md-12 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if ($conteudo_coluna['tipo'] == 'topo') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>

			<?php }
		if ($value_layout['colunas'] == 2) {

			if ($value_layout['formato'] == '6_6') {
			?>

				<div class="col-md-6 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-6 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }

			if ($value_layout['formato'] == '4_8') {
			?>

				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-8 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }

			if ($value_layout['formato'] == '8_4') {
			?>
				<div class="col-md-8 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
			<?php }
		}
		if ($value_layout['colunas'] == 3) {

			if ($value_layout['formato'] == '4_4_4') {
			?>

				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }


			if ($value_layout['formato'] == '2_5_5') {
			?>

				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }


			if ($value_layout['formato'] == '5_2_5') {
			?>

				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }

			if ($value_layout['formato'] == '5_5_2') {
			?>

				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }
		}
		if ($value_layout['colunas'] == 4) {

			if ($value_layout['formato'] == '3_3_3_3') {
			?>

				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }


			if ($value_layout['formato'] == '4_2_2_4') {
			?>

				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php }

			if ($value_layout['formato'] == '2_4_4_2') {
			?>

				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'topo') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>

			<?php
			}
		}
		if ($value_layout['colunas'] == 6) {
			?>

			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if ($conteudo_coluna['tipo'] == 'topo') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna2'];
				if ($conteudo_coluna['tipo'] == 'topo') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna3'];
				if ($conteudo_coluna['tipo'] == 'topo') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna4'];
				if ($conteudo_coluna['tipo'] == 'topo') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna5'];
				if ($conteudo_coluna['tipo'] == 'topo') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna6'];
				if ($conteudo_coluna['tipo'] == 'topo') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>

	<?php }

		echo "
		</div>
		";

		if ($value_layout['full'] != 1) {
			echo "</div>";
		}
	}
	// termina topo
	?>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<iframe width="600" height="400" id="link_youtube_iframe" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
	<?php $back_image = DOMINIO . 'arquivos/img_cursos_g/' . $data->id . '/' . $data->capa; ?>
	<div class="jumbotron" style="background-image: url(<?= $back_image ?>);min-height: 450px;margin-top: -10px;background-repeat: no-repeat;background-position: top center;background-size: 100%;">
		<div class="container" style="width: 80%;">
			<p class="bem_vindo_canal" style="margin: 10px 0px !important;">CURSO</p>
			<p class="canal_do"><?= $data->nome ?> </p>
		</div>
	</div>
	<div class="et_pb_bottom_inside_divider"></div>
	<section class="animate-effect" style="margin-top:50px; margin-bottom: 50px;">
		<div class="container">
			<div class="row">
				<div class='col-xs-12 col-sm-7 col-md-7'>
					<div class="desc_bloc">
						<h3>O que você aprenderá no curso:</h3>
						<div class="style1" style="margin-top: 20px;color: #7f7f7f;"><?= $data->summary ?></div>
					</div>
					<div class="desc_bloc">
						<h3>Conteúdo do curso:</h3>
						<span style="color: #939393;font-size: 15px;"><?php if ($qtd_conteudo == 1) {
																			echo $qtd_conteudo . ' seção';
																		} else {
																			echo $qtd_conteudo . ' seções';
																		} ?> • <?php if ($total_aulas == 1) {
																					echo $total_aulas . ' aula';
																				} else {
																					echo $total_aulas . ' aulas';
																				} ?> Duração total: <?= $total_minutos ?></span>
						<div style="margin-top: 30px;"></div>
						<?php
						foreach ($curso_conteudo as $value) {

							$total_aulas = 0;
							$seconds = 0;
							foreach ($value['conteudo'] as $row) {
								list($g, $i, $s) = explode(':', $row['duracao']);
								$seconds += $g * 3600;
								$seconds += $i * 60;
								$seconds += $s;
								$total_aulas++;
							}
							$hours = floor($seconds / 3600);
							$seconds -= $hours * 3600;
							$minutes = floor($seconds / 60);
							$seconds -= ($minutes * 60);

							if ($hours > 0) {
								$hours = $hours . 'hrs ';
							} else {
								$hours = '';
							};
							if ($minutes > 0) {
								$minutes = $minutes . 'min ';
							} else {
								$minutes = '';
							};
							if ($seconds > 0) {
								$seconds = $seconds . 'seg ';
							} else {
								$seconds = '';
							};
							$total_minutos = $hours . ' ' . $minutes . ' ' . $seconds;

						?>
							<div class="panel-group" id="accordion" data-toggle="collapse" data-target="#collapse<?= $value['id'] ?>" style="margin-bottom: 5px;cursor: pointer;">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value['id'] ?>"> <?= $value['nome'] ?></a>
											<i class="fas fa-plus" style="float:right"></i>
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value['id'] ?>" style="float:right;padding-right: 10px;"> <?= $total_aulas ?> <?php if ($total_aulas == 1) {
																																																		echo ' Aula';
																																																	} else {
																																																		echo ' Aulas';
																																																	} ?> - <?= $total_minutos ?></a>
										</h4>
									</div>
									<div id="collapse<?= $value['id'] ?>" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="card-body">
												<table class="table">
													<?php foreach ($value['conteudo'] as $row) { ?>
														<tr>
															<td class="td_list_conteudo_curso">
																<?= $row['icon'] == 0 ? '<img src="' . DOMINIO . 'arquivos/scorm.png" alt="">' : '' ?>
																<?= $row['icon'] == 1 ? '<img src="' . DOMINIO . 'arquivos/videoaula.png" alt="">' : '' ?>
																<?= $row['icon'] == 2 ? '<img src="' . DOMINIO . 'arquivos/youtube.png" alt="">' : '' ?>
																<?= $row['icon'] == 3 ? '<img src="' . DOMINIO . 'arquivos/podcast.png" alt="">' : '' ?>
																<?= $row['icon'] == 4 ? '<img src="' . DOMINIO . 'arquivos/pdf.png" alt="">' : '' ?>
																<?= $row['icon'] == 5 ? '<img src="' . DOMINIO . 'arquivos/exame.png" alt="">' : '' ?>

															</td>
															<td class="list_conteudo_curso"><?= $row['nome'] ?></td>
															<td class="td_list_conteudo_curso">
																<?php
																if (($row['icon'] == 1 || $row['icon'] == 2) && $row['visualizar'] != '') { ?>
																	<a style="z-index:99999 !important" data-toggle="modal" data-target="#exampleModal" data-video="<?= $row['visualizar'] ?>" id="youtubelink">Visualizar</a>
																<?php
																}
																?>
															</td>
															<td class="td_list_conteudo_curso"><?= $row['duracao'] ?></td>
														</tr>
													<?php } ?>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class='col-xs-12 col-sm-5 col-md-5'>
					<div class="desc_bloc">
						<h3>Sobre o curso</h3>
						<div class="style1" style="margin-top: 20px;color: #7f7f7f;"><?= $data->descricao ?></div>
					</div>
					<div class="desc_bloc">
						<h3>Feedback dos alunos</h3>
						<div class="style1" style="margin-top: 20px;">
							<div class="qtd_estrelas">
								<h3 class="overall_estrela"><?= $total_estrelas ?></h3>
								<div class="overall__estrelas">
									<div style="margin-top: 15px;">
										<?php if (floor($total_estrelas) == 0) {
											echo "<i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($total_estrelas) == 1) {
											echo "<i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($total_estrelas) == 2) {
											echo "<i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($total_estrelas) == 3) {
											echo "<i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_cinza'></i> <i class='f25 fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($total_estrelas) == 4) {
											echo "<i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($total_estrelas) == 5) {
											echo "<i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i> <i class='f25 fas fa-star estrela_amarela'></i>";
										} ?>
									</div>
									<div style="margin-top: -10px;">
										<span class="qtd_avaliacoes"><?= $data->qtd_feedback ?> avaliações</span>
									</div>
								</div>
							</div>
							<?php foreach ($estrelas as $key => $row) {
								$pctg = (($row * 100) / count($lista_feedback));
								$pctg = number_format($pctg, 0, ',', ',');
							?>

								<div class="row" style="margin:0;margin-top: -20px;">
									<div class="prog">
										<div class="progress">
											<div class="progress-bar bg-info" role="progressbar" style="width: <?= $pctg ?>%" aria-valuenow="<?= $pctg ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<div class="estrela_lista">
										<?php if (floor($key) == 0) {
											echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i>";
										} ?>
										<?php if (floor($key) == 1) {
											echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($key) == 2) {
											echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($key) == 3) {
											echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i>";
										} ?>
										<?php if (floor($key) == 4) {
											echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i>";
										} ?>
									</div>
									<div class="pctg_lista">
										<?= $pctg ?>%
									</div>
								</div>
							<?php } ?>
							<div style="margin-top: 100px;">
								<?php foreach ($lista_feedback as $row) {
									// print_r($row);echo'<br>';
								?>
									<div>
										<div class="name_feedback">
											<?= $row['nome'] ?>
										</div>
										<div class="estrela_feedback">
											<?php if ($row['estrela'] == 0) {
												echo "<i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i>";
											} ?>
											<?php if ($row['estrela'] == 1) {
												echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i>";
											} ?>
											<?php if ($row['estrela'] == 2) {
												echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i>";
											} ?>
											<?php if ($row['estrela'] == 3) {
												echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i> <i class='fas fa-star estrela_cinza'></i>";
											} ?>
											<?php if ($row['estrela'] == 4) {
												echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_cinza'></i>";
											} ?>
											<?php if ($row['estrela'] == 5) {
												echo "<i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i> <i class='fas fa-star estrela_amarela'></i>";
											} ?>
										</div>
									</div>
									<div class="texto_feedback">
										<?= $row['texto'] ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="text-align: center;">
				<button style="background: <?= $primaria ?>;border: none;padding: 6px 50px;border-radius: 8px;color: #fff;font-size: 16px;" onclick="history.go(-1);">Voltar para a Trilha</button>
			</div>
		</div>
	</section>

	<span class="style1">
		<?php
		// rodape
		foreach ($layout_lista as $key_layout => $value_layout) {

			if ($value_layout['full'] != 1) {
				echo "<div class='container' >";
			}
			echo "<div class='row' style='margin-right:0px; margin-left:0px;' >";

			if ($value_layout['colunas'] == 1) {
		?>
	</span>
	<div class="col-md-12 corrige_cedulas_principais style1">
		<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

		?>
	</div>

	<span class="style1">
		<?php }

			if ($value_layout['colunas'] == 2) {

				if ($value_layout['formato'] == '6_6') {
		?>
	</span>
	<div class="col-md-6 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-6 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<span class="style1">
	<?php }
				if ($value_layout['formato'] == '4_8') {
	?>
	</span>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-8 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php }

				if ($value_layout['formato'] == '8_4') {
	?>
	</span>
	<div class="col-md-8 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<span class="style1">
	<?php }
			}
			if ($value_layout['colunas'] == 3) {

				if ($value_layout['formato'] == '4_4_4') {
	?>
	</span>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php }


				if ($value_layout['formato'] == '2_5_5') {
	?>
	</span>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-5 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-5 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php }


				if ($value_layout['formato'] == '5_2_5') {
	?>
	</span>
	<div class="col-md-5 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-5 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php }

				if ($value_layout['formato'] == '5_5_2') {
	?>
	</span>
	<div class="col-md-5 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-5 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php }
			}
			if ($value_layout['colunas'] == 4) {

				if ($value_layout['formato'] == '3_3_3_3') {
	?>
	</span>
	<div class="col-md-3 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-3 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-3 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-3 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php }


				if ($value_layout['formato'] == '4_2_2_4') {
	?>
	</span>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php }

				if ($value_layout['formato'] == '2_4_4_2') {
	?>
	</span>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna1'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-4 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

		?>
	</div>

	<span class="style1">
	<?php
				}
			}
			if ($value_layout['colunas'] == 6) {
	?>
	</span>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

				$conteudo_coluna = $value_layout['coluna1'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

				$conteudo_coluna = $value_layout['coluna2'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

				$conteudo_coluna = $value_layout['coluna3'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

				$conteudo_coluna = $value_layout['coluna4'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

				$conteudo_coluna = $value_layout['coluna5'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

		?>
	</div>
	<div class="col-md-2 corrige_cedulas_principais style1">
		<?php

				$conteudo_coluna = $value_layout['coluna6'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

		?>
	</div>

	<span class="style1">
<?php }


			echo "
		</div>
		";
			if ($value_layout['full'] != 1) {
				echo "</div>";
			}
		}
		// termina rodape
?>
<script type="text/javascript" src="<?= LAYOUT ?>js/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?= LAYOUT ?>js/jquery-ui.min.js"></script>
<script type="text/javascript">
	function dominio() {
		return '<?= DOMINIO ?>';
	}
</script>
<script type="text/javascript" src="<?= LAYOUT ?>js/funcoes.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="<?= LAYOUT ?>js/animation.js"></script>
<script type="text/javascript" src="<?= LAYOUT ?>js/responsiveslides.min.js"></script>
<script type="text/javascript" src="<?= LAYOUT ?>api/photobox-master/photobox/jquery.photobox.js"></script>
<script type="text/javascript" src="<?= LAYOUT ?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<?php
foreach ($layout_lista as $key_layout => $value_blocos) {
	$n_col = 1;
	while ($n_col <= $value_blocos['colunas']) {
		$value_layout = $value_blocos['coluna' . $n_col];
		if (isset($value_layout['tipo'])) {
			if ($value_layout['tipo'] == 'topo') {

				$conteudo_id = $value_layout['id'];
				$conteudo_sessao = $value_layout['conteudo'];
				$id_script = '#slider_topo_' . $conteudo_id;

?>
				<script>
					<?php if ($conteudo_sessao['data_topo']->modelo  == 11) { ?>

						$("<?= $id_script ?>").responsiveSlides({
							auto: true,
							pager: false,
							nav: false,
							speed: 500,
							pause: true,
							pauseControls: true,
							namespace: "callbacks",
							before: function() {
								$('.events').append("<li>before event fired.</li>");
							},
							after: function() {
								$('.events').append("<li>after event fired.</li>");
							}
						});

					<?php } ?>

					$(document).ready(function() {
						$(window).on('scroll', function() {
							var posicao_topo = $(window).scrollTop();

							<?php if ($conteudo_sessao['data_topo']->modelo  == 6) { ?>

								if (posicao_topo > 100) {
									$(".topo6").addClass("topo6_decendo");
								}
								if (posicao_topo < 100) {
									$(".topo6").removeClass("topo6_decendo");
								}

							<?php } ?>

							<?php if ($conteudo_sessao['data_topo']->modelo  == 7) { ?>

								if (posicao_topo > 100) {
									$(".topo7").addClass("topo7_decendo");
								}
								if (posicao_topo < 100) {
									$(".topo7").removeClass("topo7_decendo");
								}

							<?php } ?>

							<?php if ($conteudo_sessao['data_topo']->modelo  == 8) { ?>

								if (posicao_topo > 100) {
									$(".topo8").addClass("topo8_decendo");
								}
								if (posicao_topo < 100) {
									$(".topo8").removeClass("topo8_decendo");
								}

							<?php } ?>

							<?php if ($conteudo_sessao['data_topo']->modelo  == 9) { ?>

								if (posicao_topo > 100) {
									$(".topo9").addClass("topo9_decendo");
								}
								if (posicao_topo < 100) {
									$(".topo9").removeClass("topo9_decendo");
								}

							<?php } ?>

							<?php if ($conteudo_sessao['data_topo']->modelo  == 10) { ?>

								if (posicao_topo > 100) {
									$(".topo10").addClass("topo10_decendo");
								}
								if (posicao_topo < 100) {
									$(".topo10").removeClass("topo10_decendo");
								}

							<?php } ?>

							<?php if ($conteudo_sessao['data_topo']->modelo  == 13) { ?>

								if (posicao_topo > 100) {
									$(".topo13").addClass("topo13_decendo");
								}
								if (posicao_topo < 100) {
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
	$('#youtubelink').click(function(e) {
		e.preventDefault();
		var link = $(this).attr('data-video');
		$('#link_youtube_iframe').attr("src", "https://www.youtube.com/embed/" + link);
	});

	$('.panel-group').click(function() {
		$(this).find('i').toggleClass('fas fa-plus fas fa-minus');
	});
	$(function() {
		$('#gallery').photobox('a', {
			time: 0
		});
	});
</script>

<?php if ($data_pagina->bloqueio == 1) { ?>

	<script type="text/javascript">
		$(document).ready(function() {



			$(document).bind("contextmenu", function(e) {
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
		if ($data->impresso == 1) {
		?>

			function carregatipoarte(id) {
				$.post('<?= DOMINIO ?><?= $controller ?>/produto_tipoarte', {
					id: id,
					produto: '<?= $data->codigo ?>',
					modelogratisselecionado: '<?= $modelogratisselecionado ?>',
					opcao: '<?= $opcao_selecionada ?>'
				}, function(data) {
					if (data) {

						if (id == 2) {
							$('#valorartevisual').html('Criação de arte adicional de: R$ <?= $valor_arte_tratado ?>');
						} else {
							$('#valorartevisual').html('');
						}

						$('#tipo_arte').html(data);

						if (id == 1) {
							var modelogratisselecionado = '<?= $modelogratisselecionado ?>';
							if (modelogratisselecionado == '') {

								modal('<?= DOMINIO ?><?= $controller ?>/produto_modelos_gratis/produto/<?= $data->codigo ?><?php if ($opcao_selecionada) {
																																echo "/opcao/" . $opcao_selecionada;
																															} ?>', 'Selecione o modelo');

							}
						}
					}
				});
			}
			<?php if ($modelogratisselecionado) { ?>
				carregatipoarte('<?= $tipoarte ?>');
			<?php } ?>

		<?php } ?>



		<?php if (!$esconder_valor) { ?>

			function recalcular() {

				var valor_inicial = parseFloat($('#produto_valor_unitario_inicial').attr('value'));

				var tamanho = parseFloat($('#combo_tamanho :selected').attr('rel'));
				var tamanho_codigo = parseFloat($('#combo_tamanho :selected').attr('value'));

				var cor = parseFloat($('#combo_cor :selected').attr('rel'));
				var cor_codigo = parseFloat($('#combo_cor :selected').attr('value'));

				var variacao = parseFloat($('#combo_variacao :selected').attr('rel'));
				var variacao_codigo = parseFloat($('#combo_variacao :selected').attr('value'));

				var valor_total = valor_inicial;

				var valor_total_tratado = numeroParaMoeda(valor_total);
				$('#produto_valor_unitario').html("R$ " + valor_total_tratado);

				$.post('<?= DOMINIO ?><?= $controller ?>/detalhes_estoque', {
					id: <?= $data->id ?>,
					produto: <?= $data->codigo ?>,
					tamanho: tamanho_codigo,
					cor: cor_codigo,
					variacao: variacao_codigo
				}, function(data) {
					if (data) {
						$('#div_comprar').html(data);
					}
				});
			}

			recalcular();

		<?php } ?>

		function calculo_medida_largura(v) {
			v = v.replace(/\D/g, "");
			v = v.replace(/(\d{2})$/, ",$1");
			v = v.replace(/(\d+)(\d{3},\d{2})$/g, "$1$2");
			var qtdLoop = (v.length - 3) / 3;
			var count = 0;
			while (qtdLoop > count) {
				count++;
				v = v.replace(/(\d+)(\d{3}.*)/, "$1$2");
			}
			v = v.replace(/^(0)(\d)/g, "$2");

			var valor_inicial = parseFloat(<?= $valor_banco ?>);

			var tamanho_altura = $('#tamanho_altura').val();
			tamanho_altura = tamanho_altura.replace(",", ".");
			tamanho_altura = parseFloat(tamanho_altura);

			var tamanho_largura = v;
			tamanho_largura = tamanho_largura.replace(",", ".");
			tamanho_largura = parseFloat(tamanho_largura);

			var valor_total = tamanho_largura * tamanho_altura * valor_inicial;

			var valor_total_tratado = numeroParaMoeda(valor_total);
			$('#produto_valor_unitario').html("R$ " + valor_total_tratado);

			return v
		}

		function calculo_medida_altura(v) {
			v = v.replace(/\D/g, "");
			v = v.replace(/(\d{2})$/, ",$1");
			v = v.replace(/(\d+)(\d{3},\d{2})$/g, "$1$2");
			var qtdLoop = (v.length - 3) / 3;
			var count = 0;
			while (qtdLoop > count) {
				count++;
				v = v.replace(/(\d+)(\d{3}.*)/, "$1$2");
			}
			v = v.replace(/^(0)(\d)/g, "$2");

			var valor_inicial = parseFloat(<?= $valor_banco ?>);

			var tamanho_largura = $('#tamanho_largura').val();
			tamanho_largura = tamanho_largura.replace(",", ".");
			tamanho_largura = parseFloat(tamanho_largura);

			var tamanho_altura = v;
			tamanho_altura = tamanho_altura.replace(",", ".");
			tamanho_altura = parseFloat(tamanho_altura);

			var valor_total = tamanho_largura * tamanho_altura * valor_inicial;

			var valor_total_tratado = numeroParaMoeda(valor_total);
			$('#produto_valor_unitario').html("R$ " + valor_total_tratado);

			return v
		}
	</script>
</body>

</html>