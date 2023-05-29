<?php if (!isset($_base['libera_views'])) {
	header("HTTP/1.0 404 Not Found");
	exit;
} ?>
<!DOCTYPE html>
<html>

<head>

	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Meus dados - <?= $data_pagina->meta_titulo ?></title>
	<link rel="shortcut icon" href="<?= $_base['favicon']; ?>" />

	<meta name="description" content="Meus dados - <?= $data_pagina->meta_titulo ?>" />
	<meta property="og:description" content="Meus dados - <?= $data_pagina->meta_titulo ?>" />
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

	<?php include_once('htm_css.php'); ?>
	<?php include_once('htm_css_resp.php'); ?>

	<style type="text/css">
		* {
			color: white
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
				<h2 class="titulo_padrao">Meus Dados</span></h2>
				<div style="text-align:center;" class="nome_cliente">Olá, <?= $nome_do_usuario ?></div>
				<!-- <div class="titulo_padrao_linha"></div>					  -->
			</div>
		</div>
	</a>
	<section class="animate-effect" style="margin-top:50px; margin-bottom: 50px;padding-right: 20px;padding-left: 20px;">

		<div class="container">

			<div class="row">

				<form id="cadastro_form">

					<div class="div_form">
						<label>País</label><br>
						<input type="radio" id="Brasil_doc" name="country_document" <?= $data_dados->is_brasil == 1 ? 'checked' : '' ?> value="1">
						<label for="Brasil">Brasil </label>
						<input type="radio" id="Outros_doc" name="country_document" <?= $data_dados->is_brasil == 0 ? 'checked' : '' ?> value="0">
						<label for="Outros">Outros</label><br>
					</div>
					<hr>
					<div class='col-xs-12 col-sm-6 col-md-6'>

						<div class="cadastro_div">

							<div style="font-size:14px; text-align:left;">DADOS DE ACESSO</div>

							<div class="div_form"><input type="text" class="form-control cadastro_form" name='email' id='email' placeholder="Digite seu E-mail" value="<?= $data_dados->email ?>"></div>
							<div class="div_form"><input type="hidden" class="form-control cadastro_form" name='is_brasil' id='is_brasil' placeholder="" value="<?= $data_dados->is_brasil ?>"></div>
							<div class="div_form"><input type="hidden" class="form-control cadastro_form" name='lms_id' id='lms_id' placeholder="" value="<?= $data_dados->lms_usuario_id ?>"></div>

							<div class="div_form"><input type="password" class="form-control cadastro_form" name='senha' id='senha' placeholder="Digite sua Senha"></div>

							<div class="div_form"><input type="password" class="form-control cadastro_form" name='senha_confirma' id='senha_confirma' placeholder="Confirme sua Senha"></div>

							<div class="div_form" style="text-align:left; margin-top:20px;">
								<input type="radio" name="tipo" id="tipo_f" value="F" onChange="tipo_cadastro(this.value)" <?php if ($data_dados->tipo == 'F') {
																																echo "checked";
																															} ?>> <label for="tipo_f">Pessoa Física</label>&nbsp; &nbsp;
								<input type="radio" name="tipo" id="tipo_j" value="J" onChange="tipo_cadastro(this.value)" <?php if ($data_dados->tipo == 'J') {
																																echo "checked";
																															} ?>> <label for="tipo_j">Pessoa Jurídica</label>
							</div>

							<div id="fisica" <?php if ($data_dados->tipo == 'F') {
													echo "style='display:block;'";
												} else {
													echo "style='display:none;'";
												} ?>>

								<div style="font-size:14px; text-align:left; margin-top:25px;">PESSOA FÍSICA</div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" name='fisica_nome' id='fisica_nome' value="<?= $data_dados->fisica_nome ?>" placeholder="Nome"></div>

								<div class="div_form" style="text-align:left; margin-top:5px;">
									<input type="radio" name="fisica_sexo" id="sexo_m" value="M" <?php if ($data_dados->fisica_sexo == 'M') {
																										echo "checked";
																									} ?>> <label for="sexo_m" style="font-weight:normal;"> Masculino</label> &nbsp; &nbsp;
									<input type="radio" name="fisica_sexo" id="sexo_f" value="F" <?php if ($data_dados->fisica_sexo == 'F') {
																										echo "checked";
																									} ?>> <label for="sexo_f" style="font-weight:normal;"> Feminino</label>
								</div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" name='fisica_nascimento' id='fisica_nascimento' value="<?php if ($data_dados->fisica_nascimento) {
																																										echo date('d/m/Y', $data_dados->fisica_nascimento);
																																									} ?>" maxlength="10" size="30" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" placeholder="Data Nascimento"></div>

								<div class="div_form"><input type="text" style="<?= $data_dados->is_brasil == 1 ? '' : 'display: none' ?>" class="form-control cadastro_form" name='fisica_cpf' id='fisica_cpf' value="<?= $data_dados->fisica_cpf ?>" onkeypress="Mascara(this,Integer)" maxlength="11" name="cpf" placeholder="CPF"></div>
								<div class="div_form"><input type="text" style="<?= $data_dados->is_brasil == 0 ? '' : 'display: none' ?>" class="form-control cadastro_form" name="cpf_outros" id="documento_cpf" placeholder="Documento" value="<?= $data_dados->fisica_cpf ?>" /></div>

							</div>

							<div id="juridica" <?php if ($data_dados->tipo == 'J') {
													echo "style='display:block;'";
												} else {
													echo "style='display:none;'";
												} ?>>

								<div style="font-size:14px; text-align:left; margin-top:25px;">PESSOA JURÍDICA</div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_nome' id='juridica_nome' value="<?= $data_dados->juridica_nome ?>" placeholder="Nome Fantasia"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_razao' id='juridica_razao' value="<?= $data_dados->juridica_razao ?>" placeholder="Razão Social"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_cnpj' id='juridica_cnpj' value="<?= $data_dados->juridica_cnpj ?>" onkeypress="Mascara(this,Integer)" placeholder="Cnpj"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_responsavel' id='juridica_responsavel' value="<?= $data_dados->juridica_responsavel ?>" placeholder="Responsável"></div>

							</div>

							<div class="div_form"><input type="text" class="form-control cadastro_form" name="telefone_fixo" id="telefone_fixo" value="<?= $data_dados->telefone ?>" placeholder="Telefone/Celular" onKeyPress="Mascara(this,telefone)" onKeyDown="Mascara(this,telefone)" maxlength="15"></div>

						</div>

					</div>

					<div class='col-xs-12 col-sm-6 col-md-6'>

						<div class="cadastro_div">

							<div style="font-size:14px; text-align:left;">DADOS PARA ENTREGA</div>


							<div class="endereco_brasil" style="<?= $data_dados->is_brasil == 1 ? '' : 'display: none' ?>">

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_cep" name="cadastro_cep" placeholder="Digite seu Cep" onkeypress="Mascara(this,ceppp)" onKeyDown="Mascara(this,ceppp)" size="9" maxlength="9" onblur="buscar_endereco()" value="<?= $data_dados->cep ?>"></div>
								<div class="div_form">
									<div style="text-align:left;">
										<div><a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank" style="font-size:13px;">Não sei meu CEP</a></div>
									</div>
								</div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_endereco" name="endereco" value="<?= $data_dados->endereco ?>" placeholder="Endereço" value="<?= $endereco ?>"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_numero" name="numero" value="<?= $data_dados->numero ?>" placeholder="Número"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_complemento" name="complemento" value="<?= $data_dados->complemento ?>" placeholder="Complemento"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_bairro" name="bairro" value="<?= $data_dados->bairro ?>" placeholder="Bairro" value="<?= $bairro ?>"></div>

								<div class="div_form">
									<select name="estado" id="cadastro_estado" class="form-control select2 cadastro_select" onChange="cadastro_cidades(this.value)">
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
									<select id="cidade" name="cidade" class="form-control select2 cadastro_form">
										<option value=''>Selecione</option>
									</select>
								</div>

								<div class="div_form" style="text-align: right;">
									<?= $botao_padrao ?>
								</div>

							</div>

							<div class="endereco_outros" style="<?= $data_dados->is_brasil == 0 ? '' : 'display: none' ?>">
								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_cep" name="cadastro_cep" placeholder="Digite seu Código postal" value="<?= $data_dados->cep ?>"></div>


								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_endereco" name="endereco" value="<?= $data_dados->endereco ?>" placeholder="Endereço" value="<?= $endereco ?>"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_numero" name="numero" value="<?= $data_dados->numero ?>" placeholder="Número"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_complemento" name="complemento" value="<?= $data_dados->complemento ?>" placeholder="Complemento"></div>

								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_estado" name="estado" value="<?= $data_dados->estado ?>" placeholder="Complemento"></div>
								<div class="div_form"><input type="text" class="form-control cadastro_form" id="cidade" name="cidade" value="<?= $data_dados->estado ?>" placeholder="Complemento"></div>

								<div class="div_form" style="text-align: right;">
									<?= $botao_padrao ?>
								</div>
							</div>

						</div>

					</div>

				</form>



			</div>


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
		$("#Brasil_doc").click(function() {
			$("#label_cpf").html('CPF');
			$("#fisica_cpf").show();
			$("#documento_cpf").hide();
			$(".endereco_brasil").show();
			$(".endereco_outros").hide();
		});
		$("#Outros_doc").click(function() {
			$("#label_cpf").html('Document');
			$("#fisica_cpf").hide();
			$("#documento_cpf").show();
			$(".endereco_brasil").hide();
			$(".endereco_outros").show();
		});

		// $("#Brasil_end").click(function(){
		// 	$(".endereco_brasil").show();
		// 	$(".endereco_outros").hide();
		// });
		// $("#Outros_end").click(function(){
		// 	$(".endereco_brasil").hide();
		// 	$(".endereco_outros").show();
		// });

		function tipo_cadastro(tipo) {

			if (tipo == 'J') {
				$('#fisica').hide();
				$('#juridica').show();
			} else {
				$('#juridica').hide();
				$('#fisica').show();
			}

		}

		function salvar() {

			$('#modal_janela').modal('show');
			$('#modal_conteudo').html("<div style='text-align:center;'><img src='<?= LAYOUT ?>img/loading.gif' style='width:250px;'></div>");

			var dados = $("#cadastro_form").serialize();

			$.post('<?= DOMINIO ?><?= $controller ?>/salvar_cadastro', dados, function(data) {
				if (data) {
					var retorno = JSON.parse(data);
					$('#modal_conteudo').html("<div class='carrinho_erro'>" + retorno['erro_msg'] + "</div>");
				}
			});
		}

		function cadastro_cidades(estado, cidade = null) {

			$('#cadastro_cidade_div').html("<div style='text-align:center;'><img src='<?= LAYOUT ?>img/loading.gif' style='border:0px; width:250px;' ></div>");

			$.post('<?= DOMINIO ?><?= $controller ?>/cidades', {
				estado: estado,
				cidade: cidade
			}, function(data) {
				if (data) {
					$('#cadastro_cidade_div').html(data);
				}
			});

		}

		<?php if ($data_dados->estado) { ?>
			cadastro_cidades('<?= $data_dados->estado ?>', '<?= $data_dados->cidade ?>');
		<?php } else { ?>
			cadastro_cidades('AC');
		<?php } ?>

		function buscar_endereco() {

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

				}
			});

		}
	</script>

</body>

</html>