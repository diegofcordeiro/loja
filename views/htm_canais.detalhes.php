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

	<meta name="description" content="<?= $data->previa ?>" />
	<meta property="og:description" content="<?= $data->previa ?>" />
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

		.owl-theme .owl-dots .owl-dot.active span,
		.owl-theme .owl-dots .owl-dot:hover span {
			background: #869791;
		}

		.owl-theme .owl-dots,
		.owl-theme .owl-nav {
			text-align: center;
			-webkit-tap-highlight-color: transparent;
			margin-top: 20px;

		}

		body {
			/* background-color:<?= $pagina_cores[1] ?>; */
			/* background-color: #f4f4f4 !important; */
			background-color: #141414 !important;
		}

		a.botao_padrao {
			background-color: <?= $primaria ?> !important;
		}

		.botao_padrao:hover {
			background-color: <?= $secundaria ?> !important;
			color: #fff !important;
		}

		.botao_comprar {
			background-color: <?= $primaria ?>;
		}

		.points,
		.yellow_points {
			color: <?= $secundaria ?>
		}

		.laranja_points {
			background: <?= $secundaria ?> !important;
			padding: 4px 8px;
			font-size: 10px;
			border-radius: 4px;
			margin-left: 6px;
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

		@media (min-width: 1200px) {
			.container {
				width: 97%;
			}
		}

		.i_star {
			color: #fc9a00;
		}

		.jumbotron {
			padding-top: 30px;
			padding-bottom: 30px;
			margin-bottom: 30px;
			color: inherit;
			background-color: #141414;
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

		@media (min-width: 992px) {
			.col-md-4 {
				width: 32.33333333%;
			}
		}

		ul li {
			padding-bottom: 8px;
		}

		#e1,
		#e2,
		#e3,
		#e4,
		#e5 {
			color: #ECECEC;
			cursor: pointer;
		}

		.sec_color {
			color: <?= $secundaria ?> !important;
		}

		#categorias,
		#autor {
			border: 1px white solid;
			border-radius: 4px !important;
			color: white;
			background: #181618;
			margin-bottom: 10px;
		}

		.centralizar_mobile {
			color: white
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
	<!-- Button trigger modal -->
	<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<iframe width="100%" 	src="https://www.youtube.com/embed/rNpYwus2TbA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
</div> -->
	<div class="jumbotron banner_canal" style="background-image: url(<?= DOMINIO . "arquivos/img_canais/" . $canal_config->id_canal . "/" . $canal_config->bann ?>);">
		<div class="container" style="width: 80%;">
			<p class="bem_vindo_canal">SEJA BEM VINDO(A) AO CANAL</p>
			<!-- <p class="canal_do">Canal do professor</p> -->
			<h1 class="display-3 nome_do_canal"><?= $canal_config->nm_canal ?></h1>
		</div>
	</div>
	<div class="et_pb_bottom_inside_divider2"></div>
	<div class="jumbotron">
		<div class="container faixa_branca" style="width: 80%;">
			<div class="img_foto_" style="background-image: url(<?= DOMINIO . "arquivos/img_canais/" . $canal_config->id_canal . "/" . $canal_config->profile ?>);"></div>
			<!-- <img src="<?= DOMINIO . "arquivos/img_canais/" . $canal_config->id_canal . "/" . $canal_config->profile ?>" class="img_prof_canal" alt=""> -->
		</div>
	</div>
	<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r60 p-l60 m-top_mobile">
		<br>
		<a href="<?= DOMINIO ?><?= $controller ?>/canais/id/<?= $canal_config->id_canal ?>" class="limpar_filtrar_bntn">LIMPAR FILTRO</a>
		<br>
		<form action="<?= DOMINIO ?><?= $controller ?>/" method="POST" style="margin-top:5px">
			<div class="row">
				<div class='col-xs-12 col-sm-3 col-md-3 sm-1ak'>
					<select name="categoria" id="categorias">
						<option value="0">Todas</option>
						<?php foreach ($categorias as $cat) { ?>
							<option value="<?= $cat['id'] ?>" <?php echo ($cat_selecionada ==  $cat['id'] ? 'selected' : '') ?>><?= $cat['titulo'] ?></option>
						<?php } ?>
					</select>
				</div>
				<div class='col-xs-12 col-sm-3 col-md-3 sm-1ak'>
					<select name="autor" id="autor">
						<option value="0">Todos</option>
						<?php foreach ($autores as $autor) { ?>
							<option value="<?= $autor['id'] ?>" <?php echo ($autor_selecionado ==  $autor['id'] ? 'selected' : '') ?>><?= $autor['nome'] ?></option>
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
					<input type="text" name="buscar1" class="buscar_input" value="<?= $buscar_campo ?>">
					<button class="btn filtrar_bntn" type="submit">
						<!-- <i class="fa fa-search" aria-hidden="true"></i> -->
						FILTRAR
					</button>
				</div>
			</div>
		</form>
	</div>
	<section class="animate-effect" style="margin-bottom: 50px;">
		<div class="container">

			<?php if (count($novos_cursos) > 0) { ?>
				<div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12'>
						<?php
						echo '
                            <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r30 p-l30 m-top_mobile">
                                <div class="content flex-row-fluid" id="kt_content">
                                    <div class="row gy-5 g-xl-8">
                                        <div class="col-xl-12">
                                            <h3 style="font-size: 18px;padding: 10px 0px;color: white;">Novos Cursos</h3>
                                            <div class="card card-xl-stretch mb-5 mb-xl-8">
                                                <div class="container_flex snaps-inline owl-carousel owl-theme">';
						foreach ($novos_cursos as $key => $value) {
							// echo'<pre>';print_r($value->id);exit;
							$conexao = new mysql();
							$cursos = new model_cursos();
							$exec = mysqli_query($conexao, "SELECT cursos.* 
																							FROM `cursos` 
																							inner join curso_produto on cursos.id = curso_produto.id_curso
																							where curso_produto.id_produto = '$value->id' ");

							$list_id = null;
							foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur) {
								if ($key == 0) {
									$list_id = $lista_cur['id'];
								} else {
									$list_id = $list_id . ',' . $lista_cur['id'];
								}
							}

							$data_id = 	$exec->fetch_all(MYSQLI_ASSOC)[0]['id'];

							$exec2 = mysqli_query($conexao, "SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
							$exec3 = mysqli_query($conexao, "SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
							$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
							$tags = mysqli_query($conexao, "SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
							$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);
							$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];


							$curso_conteudo = $cursos->curso_conteudo_varios($list_id);

							$total_aulas = 0;
							$seconds = 0;
							foreach ($curso_conteudo as $row) {
								foreach ($row['conteudo'] as $cont) {
									list($g, $i, $s) = explode(':', $cont['duracao']);
									$seconds += $g * 3600;
									$seconds += $i * 60;
									$seconds += $s;
								}
								$total_aulas += count($row['conteudo']);
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
							$valor_principal = explode(".", $value->valor);
							if (strlen($valor_principal[1]) == 1) {
								$valor_principal[1] = $valor_principal[1] . '0';
							}

							// echo'<pre>';print_r($total_minutos);exit;

							$media_estrelas = number_format($media_estrelas, 1, '.', '');
							$qtd_cursos = mysqli_num_rows($exec);

							if ($value->ref) {
								$ref = $value->ref . " - ";
							} else {
								$ref = "";
							}
							if ($value->imagem) {
								$imagem = $value->imagem;
							} else {
								$imagem = LAYOUT . "img/semimagem.png";
							}
							$esconder_valor = false;
							if ($value->esconder_valor == 1) {
								if (!$_cod_usuario) {
									$esconder_valor = true;
								}
							}
							$endereco = DOMINIO . $controller . "/produto/id/" . $value->id . "/";
							$endereco_img = DOMINIO . "/arquivos/img_produtos_g/" . $value->codigo . "/";

							$botao_comprar = str_replace("aquivaiolink", " href='" . $endereco . "' ", $conteudo_sessao->botao);
							$conexao = new mysql();
							$result = $conexao->query("SELECT produto_categoria.titulo FROM 
                                                                        `produto_categoria_sel`
                                                                        inner join produto_categoria on produto_categoria_sel.categoria_codigo = produto_categoria.codigo
                                                                        WHERE `produto_codigo` = '$value->codigo' ORDER BY RAND() LIMIT 3; ");

							$categories = array();
							while ($obj = $result->fetch_object()) {
								array_push($categories, $obj);
							}
						?>
							<div class="item">
								<div class="grid1">
									<div style="position:relative">
										<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
										<a href="<?= $endereco ?>">
											<img src="<?= $endereco_img . $imagem ?>" height="200" alt="">
										</a>
									</div>
									<div class="tag_porcent">
										<div>
											<?php if (isset($tags_cat)) { ?>
												<?php foreach ($tags_cat as $key => $cat) { ?>
													<span style="background: <?= $cat['cor_fundo'] ?> !important;color: <?= $cat['cor_texto'] ?> !important;" class="<?= $key == 0 ? '' : 'tag2' ?>"><?= $cat['titulo'] ?></span>
												<?php } ?>
											<?php } ?>
											<span class="laranja_points">
												<i class="fas fa-star" style="color:white"></i>
												<span class="points" style="color:white"><?= $media_estrelas ?></span>
											</span>
										</div>
										<div></div>
									</div>
									<div class="desc_text">
										<div class="name-author all">
											<a style="color: white;" href="<?= $endereco ?>"><?= $value->titulo ?></a>
										</div>
										<p style="line-height: 16px;font-size:12px">
											<a style="color: #7F7F7F;" href="<?= $endereco ?>">
												<?php
												if ($value->assinatura == 1) {
													echo 'Assinatura';
												} else {
													echo 'Conteúdo único';
												}
												?>
											</a>
										</p>
										<div class="name-author_ all">
											<a style="color: white;" href="<?= $endereco ?>">Autor: <?= $value->autor_nome ?></a>
										</div>
									</div>
									<div class="pontuacao">
										<ul>
											<li><i class="fas fa-graduation-cap"></i> <?= $qtd_cursos ?> cursos</li>
											<li><i class="fas fa-clock"></i> <?= $total_minutos ?></li>
											<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
											<li><i class="fas fa-redo"></i> Última atualização em <?= date('d/m/Y', $value->data_atualizacao); ?></li>
										</ul>
										<?php if ($media_estrelas == 22) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 33) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 44) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 55) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 66) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
										}
										?>
									</div>
									<?php if ($value->valor_falso > 0) { ?>
										<div class="price_container">
											<p class="preco_desc">R$ <?= number_format($value->valor_falso, 2, ",", ".") ?></p>
											<p class="preco_list_indi">
												<span style="color:white;font-size: 25px;">R$ </span>
												<span style="color:white;font-size: 40px;"> <?= $valor_principal[0] ?> </span>
												<span style="color:white;font-size: 25px;margin-left: -10px;"> ,<?= ($valor_principal[1] > 0 ? $valor_principal[1] : '00') ?>
											</p>
										</div>
									<?php } elseif ($value->valor > 0) { ?>
										<p class="preco_list">
											<span style="color:white;font-size: 25px;">R$ </span>
											<span style="color:white;font-size: 40px;"> <?= $valor_principal[0] ?> </span>
											<span style="color:white;font-size: 25px;margin-left: -10px;"> ,<?= ($valor_principal[1] > 0 ? $valor_principal[1] : '00') ?>
										</p>
									<?php } else { ?>
										<p class="preco_list">Gratuito</p>
									<?php } ?>
									<div class="bottom_card">
										<div><a href="<?= $endereco ?>" onclick="acessando(this);">
												<p class="saibamais_btn">SAIBA MAIS</p>
											</a></div>
										<!-- <div><a href="<?= $endereco ?>" onclick="acessando(this);" class="botao_comprar"><?= ($value->assinatura == 1 ? 'ASSINAR' : 'COMPRAR') ?></a></div> -->
										<div id="div_comprar">
											<form name="add_carrinho" id="add_carrinho" action="<?= DOMINIO ?><?= $controller ?>/carrinho_adicionar" method="post" enctype="multipart/form-data">
												<span>
													<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
														<?= ($value->assinatura == 1 ? 'ASSINAR' : 'COMPRAR') ?>
													</button>
													<input type="hidden" name="produto" value="<?= $value->codigo ?>">
												</span>
											</form>
										</div>
									</div>
								</div>
							</div>
						<?php
						}
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						?>
					</div>
				</div>
			<?php } ?>

			<?php if (count($avaliacao_cursos) > 0) { ?>
				<div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12'>
						<?php
						echo '
                            <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start p-r30 p-l30 m-top_mobile">
                                <div class="content flex-row-fluid" id="kt_content">
                                    <div class="row gy-5 g-xl-8">
                                        <div class="col-xl-12">
                                            <h3 style="font-size: 18px;padding: 10px 0px;color: #334555;">Melhor Avaliados</h3>
                                            <div class="card card-xl-stretch mb-5 mb-xl-8">
                                                <div class="container_flex snaps-inline owl-carousel owl-theme">';
						foreach ($avaliacao_cursos as $key => $value) {
							$conexao = new mysql();
							$cursos = new model_cursos();
							$exec = mysqli_query($conexao, "SELECT cursos.* 
																							FROM `cursos` 
																							inner join curso_produto on cursos.id = curso_produto.id_curso
																							where curso_produto.id_produto = '$value->id' ");

							$list_id = null;
							foreach ($exec->fetch_all(MYSQLI_ASSOC) as $key => $lista_cur) {
								if ($key == 0) {
									$list_id = $lista_cur['id'];
								} else {
									$list_id = $list_id . ',' . $lista_cur['id'];
								}
							}

							$data_id = 	$exec->fetch_all(MYSQLI_ASSOC)[0]['id'];

							$exec2 = mysqli_query($conexao, "SELECT avg(estrela) estrelas FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id )");
							$exec3 = mysqli_query($conexao, "SELECT * FROM `feedback` inner join curso_feedback on feedback.id = curso_feedback.id_feedback where curso_feedback.id_curso in( $list_id ) ORDER BY RAND() LIMIT 3");
							$reviews = $exec3->fetch_all(MYSQLI_ASSOC);
							$tags = mysqli_query($conexao, "SELECT * FROM produto_categoria inner join produto_categoria_sel on produto_categoria.codigo = produto_categoria_sel.categoria_codigo WHERE produto_categoria_sel.produto_codigo = $value->codigo ORDER BY RAND() LIMIT 3;");
							$tags_cat = $tags->fetch_all(MYSQLI_ASSOC);
							$media_estrelas = $exec2->fetch_all(MYSQLI_ASSOC)[0]['estrelas'];


							$curso_conteudo = $cursos->curso_conteudo_varios($list_id);

							$total_aulas = 0;
							$seconds = 0;
							foreach ($curso_conteudo as $row) {
								foreach ($row['conteudo'] as $cont) {
									list($g, $i, $s) = explode(':', $cont['duracao']);
									$seconds += $g * 3600;
									$seconds += $i * 60;
									$seconds += $s;
								}
								$total_aulas += count($row['conteudo']);
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
							$valor_principal = explode(".", $value->valor);
							if (strlen($valor_principal[1]) == 1) {
								$valor_principal[1] = $valor_principal[1] . '0';
							}

							// echo'<pre>';print_r($valor_principal);exit;

							$media_estrelas = number_format($media_estrelas, 1, '.', '');
							$qtd_cursos = mysqli_num_rows($exec);

							if ($value->ref) {
								$ref = $value->ref . " - ";
							} else {
								$ref = "";
							}
							if ($value->imagem) {
								$imagem = $value->imagem;
							} else {
								$imagem = LAYOUT . "img/semimagem.png";
							}
							$esconder_valor = false;
							if ($value->esconder_valor == 1) {
								if (!$_cod_usuario) {
									$esconder_valor = true;
								}
							}
							$endereco = DOMINIO . $controller . "/produto/id/" . $value->id . "/";
							$endereco_img = DOMINIO . "/arquivos/img_produtos_g/" . $value->codigo . "/";

							$botao_comprar = str_replace("aquivaiolink", " href='" . $endereco . "' ", $conteudo_sessao->botao);
							$conexao = new mysql();
							$result = $conexao->query("SELECT produto_categoria.titulo FROM 
                                                                        `produto_categoria_sel`
                                                                        inner join produto_categoria on produto_categoria_sel.categoria_codigo = produto_categoria.codigo
                                                                        WHERE `produto_codigo` = '$value->codigo' ORDER BY RAND() LIMIT 3; ");

							$categories = array();
							while ($obj = $result->fetch_object()) {
								array_push($categories, $obj);
							}
						?>
							<div class="item">
								<div class="grid1">
									<div style="position:relative">
										<div class="box_overlay" style="background-image: linear-gradient(#00000000 70%, #000000)"></div>
										<a href="<?= $endereco ?>">
											<img src="<?= $endereco_img . $imagem ?>" height="200" alt="">
										</a>
									</div>
									<div class="tag_porcent">
										<div>
											<?php if (isset($tags_cat)) { ?>
												<?php foreach ($tags_cat as $key => $cat) { ?>
													<span style="background: <?= $cat['cor_fundo'] ?> !important;color: <?= $cat['cor_texto'] ?> !important;" class="<?= $key == 0 ? '' : 'tag2' ?>"><?= $cat['titulo'] ?></span>
												<?php } ?>
											<?php } ?>
											<span class="laranja_points">
												<i class="fas fa-star" style="color:white"></i>
												<span class="points" style="color:white"><?= $media_estrelas ?></span>
											</span>
										</div>
										<div></div>
									</div>
									<div class="desc_text">
										<div class="name-author all">
											<a style="color: white;" href="<?= $endereco ?>"><?= $value->titulo ?></a>
										</div>
										<p style="line-height: 16px;font-size:12px">
											<a style="color: #7F7F7F;" href="<?= $endereco ?>">
												<?php
												if ($value->assinatura == 1) {
													echo 'Assinatura';
												} else {
													echo 'Conteúdo único';
												}
												?>
											</a>
										</p>
										<div class="name-author_ all">
											<a style="color: white;" href="<?= $endereco ?>">Autor: <?= $value->autor_nome ?></a>
										</div>
									</div>
									<div class="pontuacao">
										<ul>
											<li><i class="fas fa-graduation-cap"></i> <?= $qtd_cursos ?> cursos</li>
											<li><i class="fas fa-clock"></i> <?= $total_minutos ?></li>
											<li><i class="far fa-calendar-alt"></i> Disponivel por 1 ano</li>
											<li><i class="fas fa-redo"></i> Última atualização em <?= date('d/m/Y', $value->data_atualizacao); ?></li>
										</ul>
										<?php if ($media_estrelas == 22) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 33) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 44) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 55) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="far fa-star i_star"></i>';
										} elseif ($media_estrelas == 66) {
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
											echo '<i class="fas fa-star i_star"></i>';
										}
										?>
									</div>
									<?php if ($value->valor_falso > 0) { ?>

										<div class="price_container">
											<p class="preco_desc">R$ <?= number_format($value->valor_falso, 2, ",", ".") ?></p>
											<p class="preco_list_indi">
												<span style="color:white;font-size: 25px;">R$ </span>
												<span style="color:white;font-size: 40px;"> <?= $valor_principal[0] ?> </span>
												<span style="color:white;font-size: 25px;margin-left: -10px;"> ,<?= ($valor_principal[1] > 0 ? $valor_principal[1] : '00') ?>
											</p>
										</div>
									<?php } elseif ($value->valor > 0) { ?>
										<p class="preco_list">
											<span style="color:white;font-size: 25px;">R$ </span>
											<span style="color:white;font-size: 40px;"> <?= $valor_principal[0] ?> </span>
											<span style="color:white;font-size: 25px;margin-left: -10px;"> ,<?= ($valor_principal[1] > 0 ? $valor_principal[1] : '00') ?>
										</p>
									<?php } else { ?>
										<p class="preco_list">Gratuito</p>
									<?php } ?>
									<div class="bottom_card">
										<div><a href="<?= $endereco ?>" onclick="acessando(this);">
												<p class="saibamais_btn">SAIBA MAIS</p>
											</a></div>
										<!-- <div><a href="<?= $endereco ?>" onclick="acessando(this);" class="botao_comprar"><?= ($value->assinatura == 1 ? 'ASSINAR' : 'COMPRAR') ?></a></div> -->
										<div id="div_comprar">
											<form name="add_carrinho" id="add_carrinho" action="<?= DOMINIO ?><?= $controller ?>/carrinho_adicionar" method="post" enctype="multipart/form-data">
												<span>
													<button type="button" class="botao_comprar" onclick="submit('add_carrinho')">
														<?= ($value->assinatura == 1 ? 'ASSINAR' : 'COMPRAR') ?>
													</button>
													<input type="hidden" name="produto" value="<?= $value->codigo ?>">
												</span>
											</form>
										</div>
									</div>
								</div>
							</div>

						<?php
							// $itens_listados++;
						}
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						?>
					</div>
				</div>
			<?php } ?>

		</div>

		<?php if (count($reviews) > 0) { ?>
			<div class="container">
				<div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12'>
						<h3 style="font-size: 18px;padding: 30px 60px;color: #334555;">O que estão dizendo</h3>
					</div>
				</div>
			</div>

			<div class="container">
				<div class="row" style="width: 80%;margin: 0 auto;">
					<?php foreach ($reviews as $key => $row_rev) { ?>
						<?php if ($key == 1) { ?>
							<div class='col-xs-12 col-sm-12 col-md-4 box_renew'>
							<?php } else { ?>
								<div class='col-xs-12 col-sm-12 col-md-4 box_renew2'>
								<?php } ?>
								<br>
								<div class="box_texto">
									"<?= $row_rev['texto'] ?>"
								</div>
								<div style="">
									<h3 style="color: white;font-size: 20px;"><?= $row_rev['nome'] ?></h3>
								</div>
								</div>
							<?php } ?>
							</div>
				</div>
			<?php } ?>
			<br>
			<div class="container">
				<div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12'>
						<div style="padding: 40px;width: 80%;background: #141414;border-radius: 10px;margin: 0 auto;">
							<div style="min-height: 70px;">
								<img src="<?= DOMINIO . "arquivos/img_canais/" . $canal_config->id_canal . "/" . $canal_config->profile ?>" style="border-radius: 80px;width: 50px;height: 50px;float: left;" alt="">
								<h2 style="margin-left: 60px;color:white"><?= $canal_config->nm_canal ?></h2>
							</div>
							<div style="color:white">
								<?= $canal_config->bio ?>
								<br>
								<br>
								<div>
									<a style="color:white" href="mailto:<?= $canal_config->email ?>"><i class="far fa-envelope"></i> Envie uma mensagem para o autor</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div style="text-align: center;">
				<button style="background: <?= $primaria ?>;border: none;padding: 6px 50px;border-radius: 8px;color: #fff;font-size: 16px;" onclick="history.go(-1);">Voltar</button>
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
<script type="text/javascript" src="<?= LAYOUT ?>api/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>

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
						console.log('tes');
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


						var estrelas_campo = <?= $estrelas_campo ?>;

						if (estrelas_campo == 1) {
							$('#e1').toggleClass("sec_color");
						}
						if (estrelas_campo == 2) {
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
						}
						if (estrelas_campo == 3) {
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
							$('#e3').toggleClass("sec_color");
						}
						if (estrelas_campo == 4) {
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
							$('#e3').toggleClass("sec_color");
							$('#e4').toggleClass("sec_color");
						}
						if (estrelas_campo == 5) {
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
							$('#e3').toggleClass("sec_color");
							$('#e4').toggleClass("sec_color");
							$('#e5').toggleClass("sec_color");
						}

						$("#e1").click(function() {
							remove_class()
							$('#e1').toggleClass("sec_color");
							$('#estrelas').val(1);
							e.preventDefault();
						});
						$("#e2").click(function() {
							remove_class()
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
							$('#estrelas').val(2);
							e.preventDefault();
						});
						$("#e3").click(function() {
							remove_class()
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
							$('#e3').toggleClass("sec_color");
							$('#estrelas').val(3);
							e.preventDefault();
						});
						$("#e4").click(function() {
							remove_class()
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
							$('#e3').toggleClass("sec_color");
							$('#e4').toggleClass("sec_color");
							$('#estrelas').val(4);
							e.preventDefault();
						});
						$("#e5").click(function() {
							remove_class()
							$('#e1').toggleClass("sec_color");
							$('#e2').toggleClass("sec_color");
							$('#e3').toggleClass("sec_color");
							$('#e4').toggleClass("sec_color");
							$('#e5').toggleClass("sec_color");
							$('#estrelas').val(5);
							e.preventDefault();
						});

						function remove_class() {
							$('#e1').removeClass("sec_color");
							$('#e2').removeClass("sec_color");
							$('#e3').removeClass("sec_color");
							$('#e4').removeClass("sec_color");
							$('#e5').removeClass("sec_color");
						}


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

				var valor_total = valor_inicial + tamanho + cor;

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