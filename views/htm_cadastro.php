<?php if (!isset($_base['libera_views'])) {
	header("HTTP/1.0 404 Not Found");
	exit;
} ?>
<!DOCTYPE html>
<html>

<head>

	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Cadastro - <?= $data_pagina->meta_titulo ?></title>
	<link rel="shortcut icon" href="<?= $_base['favicon']; ?>" />

	<meta name="description" content="Cadastro - <?= $data_pagina->meta_titulo ?>" />
	<meta property="og:description" content="Cadastre-se - <?= $data_pagina->meta_titulo ?>" />
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
	<link rel="stylesheet" href="http://code.jquery.com/qunit/qunit-1.11.0.css" type="text/css" media="all">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

	<?php include_once('htm_css.php'); ?>
	<?php include_once('htm_css_resp.php'); ?>

	<style type="text/css">
		body {
			background-color: <?= $pagina_cores[1] ?>;
		}

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
			background-color: #F9F9F9 !important;
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
			background-color: #F9F9F9;
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
			border: 1px #2C3E50 solid;
			border-radius: 4px !important;
			color: #2C3E50;
			background: white;
			margin-bottom: 10px;
		}

		.fa-eye {
			position: absolute;
			top: 18%;
			right: 7%;
			cursor: pointer;
			color: #646464;
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

	<a href="<?= $link_banner ?>" style="cursor:pointer">
		<div class="jumbotron" style="background: <?= $primaria ?>;margin-top: -10px;">
			<div class="container" style="color: white;">
				<h2 class="titulo_padrao">Cadastre-se</h2>
				<div class="titulo_padrao_linha"></div>
			</div>
		</div>
	</a>
	<section class="animate-effect" style="margin-top:50px; margin-bottom: 50px;padding-right: 20px;padding-left: 20px;">

		<div class="container">

			<?php


			if ($etapa == 0) {

			?>
				<!-- <div class="row">
					<div class="col-sm-12">
						<h2 class="titulo_padrao" >Cadastre-se</span></h2>
						<div class="titulo_padrao_linha" ></div>
					</div>
				</div> -->

				<div class="row">

					<div class='col-xs-12 col-sm-3 col-md-3'></div>
					<div class='col-xs-12 col-sm-6 col-md-6'>
						<form id="cadastro_form" name="cadastro_form">
							<div class="cadastro_div">
								<div class="div_form">
									<label>País</label><br>
									<input type="radio" id="Brasil" name="country_document" checked value="1">
									<label for="Brasil">Brasil</label><br>
									<input type="radio" id="Outros" name="country_document" value="0">
									<label for="Outros">Outros</label><br>
								</div>
								<div class="div_form" id="brasil_div">
									<label>CPF</label>
									<input type="text" class="form-control cadastro_form" name='fisica_cpf' data-mask="00000000000" id='fisica_cpf' placeholder="Digite seu cpf">
								</div>
								<div class="div_form" id="outros_div" style="display:none">
									<label>Documento</label>
									<input type="text" class="form-control cadastro_form" name='fisica_documento' id='fisica_documento' placeholder="Digite seu documento">
								</div>
								<div class="div_form">
									<label>Nome Completo</label>
									<input type="text" class="form-control cadastro_form" name='fisica_nome' id='fisica_nome' placeholder="Nome Completo">
								</div>
								<div class="div_form">
									<label>Telefone</label>
									<input type="text" class="form-control cadastro_form" name="cadastro_telefone_brasil" id="cadastro_telefone_brasil" data-mask="(00) 00000-0000" placeholder="Telefone">
									<input type="text" class="form-control cadastro_form" name="cadastro_telefone" id="cadastro_telefone_outros" placeholder="Telefone" style="display:none">
								</div>
								<div class="div_form">
									<label>Digite seu E-mail</label>
									<input type="text" class="form-control cadastro_form" name="email" autocomplete="off" placeholder="Digite seu E-mail">
								</div>

								<div class="div_form">
									<label>Confirme seu E-mail</label>
									<input type="text" class="form-control cadastro_form" id="email_confirma" name="confirma_email" autocomplete="off" placeholder="Confirme seu E-mail">
								</div>

								<div class="div_form" style="text-align: right;">
									<?= $botao_padrao ?>
									<input type="hidden" name="etapa" value="0">
								</div>

							</div>
						</form>
					</div>
					<div class='col-xs-12 col-sm-3 col-md-3'></div>

				</div>

			<?php

			}

			?>




			<?php

			if ($etapa == 1) {

			?>
				<!-- <div class="row">
					<div class="col-sm-12">
						<h2 class="titulo_padrao" >Complete seus dados</span></h2>
						<div class="titulo_padrao_linha" ></div>
					</div>
				</div> -->


				<div class="row">

					<div class='col-xs-12 col-sm-3 col-md-3'></div>
					<div class='col-xs-12 col-sm-6 col-md-6'>
						<form id="cadastro_form" name="cadastro_form">
							<div class="cadastro_div">
								<div class="div_form">
									<label>País</label><br>
									<input type="radio" id="Brasil" name="country_document" checked value="1">
									<label for="Brasil">Brasil</label><br>
									<input type="radio" id="Outros" name="country_document" value="0">
									<label for="Outros">Outros</label><br>
								</div>

								<div class="div_correio_brasil" style="">

									<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_cep" name="cadastro_cep" placeholder="Digite seu Cep" onkeypress="Mascara(this,ceppp)" onKeyDown="Mascara(this,ceppp)" size="9" maxlength="9" onblur="buscar_endereco()"></div>
									<div class="div_form">
										<div style="text-align:left;">
											<div><a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank" style="font-size:13px;">Não sei meu CEP</a></div>
										</div>
									</div>

									<div id="endereco_div_load"></div>

									<div id="endereco_div" style="display: none;">

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_endereco" name="endereco_" placeholder="Endereço" value="<?= $endereco ?>"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_numero" name="numero_" placeholder="Número"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_complemento" name="complemento_" placeholder="Complemento"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_bairro" name="bairro_" placeholder="Bairro" value="<?= $bairro ?>"></div>

										<div class="div_form">
											<select name="estado_" id="cadastro_estado" class="form-control select2 cadastro_select" onChange="cadastro_cidades(this.value)">
												<option value="" selected="">Selecione seu estado</option>
												<?php

												foreach ($estados as $key => $value) {

													if ($value['selected']) {
														$select = "selected";
													} else {
														$select = "";
													}
													echo "<option value='" . $value['uf'] . "' $select >" . $value['nome'] . "</option>";
												}

												?>
											</select>
										</div>

										<div class="div_form" id="cadastro_cidade_div">
											<select id="cidade" name="cidade_" class="form-control select2 cadastro_select">
												<option value=''>Selecione</option>
											</select>
										</div>

										<div class="div_form" style="text-align: right;">
											<?= $botao_padrao ?>
											<input type="hidden" name="etapa" value="1">
											<input type="hidden" name="codigo" value="<?= $codigo_cadastro ?>">
										</div>

									</div>

								</div>

								<div class="div_correio_outros" style="display:none">

									<div id="endereco_div">

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_endereco" name="endereco" placeholder="Endereço" value="<?= $endereco ?>"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_numero" name="numero" placeholder="Número" value="<?= $numero ?>"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_complemento" name="complemento" placeholder="Complemento" value="<?= $complemento ?>"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_bairro" name="bairro" placeholder="Bairro" value="<?= $bairro ?>"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_cidade" name="cidade_outros" placeholder="Cidade" value="<?= $cidade ?>"></div>

										<div class="div_form"><input type="text" class="form-control cadastro_form" id="postcode" name="postcode" placeholder="Postcode/Zipcode" value="<?= $cep ?>"></div>

										<div class="div_form" style="text-align: right;">
											<?= $botao_padrao ?>
											<input type="hidden" name="etapa" value="1">
											<input type="hidden" name="codigo" value="<?= $codigo_cadastro ?>">
										</div>

									</div>

								</div>


							</div>
						</form>
					</div>
					<div class='col-xs-12 col-sm-3 col-md-3'></div>

				</div>

			<?php

			}

			?>


			<?php

			if ($etapa == 2) {

			?>
				<!-- <div class="row">
					<div class="col-sm-12">
						<h2 class="titulo_padrao" >Complete seus dados</span></h2>
						<div class="titulo_padrao_linha" ></div>
					</div>
				</div> -->


				<div class="row">

					<div class='col-xs-12 col-sm-3 col-md-3'></div>
					<div class='col-xs-12 col-sm-6 col-md-6'>
						<form id="cadastro_form" name="cadastro_form">
							<div class="cadastro_div">

								<div class="div_form">
									<label>Digite uma Senha</label>
									<input type="password" class="form-control cadastro_form" id="password" name="senha" autocomplete="off" placeholder="Digite sua Senha">
									<i class="fa-solid fa-eye" id="eye"></i>
								</div>

								<div class="div_form">
									<label>Confirme sua Senha</label>
									<input type="password" class="form-control cadastro_form" name="senha_confirma" autocomplete="off" placeholder="Confirme sua Senha">
								</div>

								<div class="div_form" style="text-align: right;">
									<?= $botao_padrao ?>
									<input type="hidden" name="etapa" value="2">
									<input type="hidden" name="codigo" value="<?= $codigo_cadastro ?>">
								</div>

							</div>
						</form>
					</div>
					<div class='col-xs-12 col-sm-3 col-md-3'></div>

				</div>

			<?php

			}

			?>


		</div>

	</section>



	<?php

	// rodape
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
				if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-6 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-8 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if ($conteudo_coluna['tipo'] == 'rodape') {

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
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna2'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna3'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna4'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna5'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_' . $conteudo_coluna['tipo'] . '.php';
				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna6'];
				if ($conteudo_coluna['tipo'] == 'rodape') {

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

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/qunit/qunit-1.11.0.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<?php

	foreach ($layout_lista as $key_layout => $value_blocos) {
		$n_col = 1;
		while ($n_col <= $value_blocos['colunas']) {

			$value_layout = $value_blocos['coluna' . $n_col];

			if (isset($value_layout['tipo'])) {

				if ($value_layout['tipo'] == 'topo') {

					$conteudo_id = $value_layout['id'];
					$conteudo_sessao = $value_layout['conteudo'];
					$id_script = '#slider_topo_' . $conteudo_id; ?>
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
							$("#email_confirma").bind('paste', function(e) {
								e.preventDefault();
							});
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

	<script>
		const passwordInput = document.querySelector("#password")
		const eye = document.querySelector("#eye")
		eye.addEventListener("click", function() {
			this.classList.toggle("fa-eye-slash")
			const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
			passwordInput.setAttribute("type", type)
		})
	</script>

	<script type="text/javascript">
		$("#Brasil").click(function() {
			$("#brasil_div").show();
			$("#outros_div").hide();

			$(".div_correio_brasil").show();
			$(".div_correio_outros").hide();

			$("#cadastro_telefone_brasil").show();
			$("#cadastro_telefone_outros").hide();

		});
		$("#Outros").click(function() {
			$("#brasil_div").hide();
			$("#outros_div").show();

			$(".div_correio_brasil").hide();
			$(".div_correio_outros").show();

			$("#cadastro_telefone_brasil").hide();
			$("#cadastro_telefone_outros").show();
		});

		function finalizar_cadastro() {

			$('#modal_janela').modal('show');
			$('#modal_conteudo').html("<div style='text-align:center;'><img src='<?= LAYOUT ?>img/loading.gif' style='width:25px;'></div>");
			// $('#modal_load').modal('show');

			var dados = $("#cadastro_form").serialize();

			$.post('<?= DOMINIO ?><?= $controller ?>/cadastro_basico_grv', dados, function(data) {
				// if(data){
				// $('#modal_conteudo').html(data);
				// }
				$('#modal_conteudo').html(data);
				console.log(data.length);
				console.log(data);
				// if(data.length != 127){
				// $('#modal_load').modal('hide');
				// $('#modal_janela').modal('show');
				// $('#modal_conteudo').html(data);
				// }else{
				// $('#modal_conteudo_loading').html(data);
				// }
			});

		}

		function cadastro_cidades(estado, cidade = null) {

			$('#cadastro_cidade_div').html("<div style='text-align:center;'><img src='<?= LAYOUT ?>img/loading.gif' style='border:0px; width:250px;'></div>");

			$.post('<?= DOMINIO ?><?= $controller ?>/cidades', {
				estado: estado,
				cidade: cidade
			}, function(data) {
				if (data) {
					$('#cadastro_cidade_div').html(data);
				}
			});

		}

		function buscar_endereco() {

			$('#endereco_div_load').html("<div style='text-align:center;'><img src='<?= LAYOUT ?>img/loading.gif' style='width:25px;'></div>");

			var cep = $('#cadastro_cep').val();

			$.post('<?= DOMINIO ?><?= $controller ?>/busca_endereco_cep', {
				cep: cep
			}, function(data) {
				if (data) {

					var filtro = data.replace(/^\s+|\s+$/g, "");
					var retorno = JSON.parse(filtro);

					$('#cadastro_endereco').val(retorno.endereco);
					$('#cadastro_bairro').val(retorno.bairro);
					$('#cadastro_endereco').val(retorno.endereco);
					$('#cadastro_estado').val(retorno.estado).trigger('change');

					cadastro_cidades(retorno.estado, retorno.cidade);

					$('#endereco_div').show();
					$('#endereco_div_load').hide();
				}
			});


		}
	</script>



</body>

</html>