<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Detalhes do Pedido <?=$data_pedido->id?> - <?=$data_pagina->meta_titulo?></title>
	<link rel="shortcut icon" href="<?=$_base['favicon'];?>" />

	<meta name="description" content="<?=$data_pagina->meta_titulo?>" />
	<meta property="og:description" content="<?=$data_pagina->meta_titulo?>" />
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
	<link href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/qunit/qunit-1.11.0.css" type="text/css" media="all">

	<?php include_once('htm_css.php'); ?>
	<?php include_once('htm_css_resp.php'); ?>

	<style type="text/css">
		body {
		/* background-color:<?=$pagina_cores[1]?>; */
        /* background-color: #f4f4f4 !important; */
        background-color: #F9F9F9 !important;
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
    .style1 {
        font-size: 36
    }
        .style2 {
        font-size: 24px;
    }
        .style3 {	font-size: 12px
    }
    .style6 {font-size: 14px}
    @media (min-width: 1200px){
        .container {
            width: 97%;
        }
    }
    .i_star{
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
	@media (min-width: 992px){
		.col-md-4 {
			width: 32.33333333%;
		}
	}
	ul li{
		padding-bottom: 8px;
	}
	#e1,#e2,#e3,#e4,#e5{
		color:#ECECEC;
		cursor: pointer;
	}
	.sec_color{
		color: <?=$secundaria?> !important;
	}
	#categorias, #autor{
		border: 1px #2C3E50 solid;
		border-radius: 4px !important;
		color: #2C3E50;
		background: white;
		margin-bottom: 10px;
	}
	@media (min-width: 1200px){
		.new_cont {
			width: 900px;
			border: 1px #c7c7c7 solid;
			border-radius: 10px;
			padding: 20px;
		}
	}
	.div_form {
    	padding-top: 0px !important;
	}
</style>

<?=$botao_style?>

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
				<div class="col-sm-12">
					<h2 class="titulo_padrao" >PEDIDO <span><?=$data_pedido->id?></span></h2>
					<div class="titulo_padrao_linha" ></div>
					<div class="bt_alterar_dados" style="margin-bottom:30px;text-align: center;">
						<?php
						if($data_pedido->status <= 3){
							?>
							<button type="button" class="botao_padrao <?=$botao_css?>" style="width: 200px; background-color: #ba4343 !important; border-color:#ba4343 !important; color:#fff  !important; " onClick="confirma_cancelamento('<?=DOMINIO?><?=$controller?>/cancelar_pedido/codigo/<?=$data_pedido->codigo?>');" >Cancelar Pedido</button>
							<?php
						}
						?>
						<button type="button" class="botao_padrao <?=$botao_css?>" style="width: 200px;background: #2c3e4e !important;" onClick="window.location='<?=DOMINIO?><?=$controller?>/minhaconta';" >Voltar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="container new_cont">
			<div class="row">
				<div class="col-sm-12">					
					<!-- <div><strong>Status do Pedido:</strong> <?=$status?></div> -->
					<!-- <div style="padding-top:15px;" ><strong>Vencimento:</strong> <?=date('d/m/Y', $data_pedido->vencimento)?></div> -->
					<!-- <div style="padding-top:15px;" ><strong>Forma de Envio:</strong> <?=$envio_titulo?></div> -->
					<?php if($data_pedido->codigo_envio){ ?>
						<?php if( ($data_pedido->frete == 1) OR ($data_pedido->frete == 2) ){ ?>
							<!-- <div style="padding-top:20px;">
								<strong>Rastreamento:</strong> <a href="http://www.linkcorreios.com.br/<?=$data_pedido->codigo_envio?>" target="_blank"><?=$data_pedido->codigo_envio?></a>
							</div> -->
						<?php } else { ?>
							<!-- <div style="padding-top:20px;"><strong>Rastreamento:</strong> <?=$data_pedido->codigo_envio?> </div> -->
						<?php } ?>
					<?php } ?>
					<!-- <div style="padding-top:15px;" ><strong>Forma de Pagamento:</strong> <?=$forma_pagamento->titulo?></div> -->



					<!-- ////////////////////////////////// PAGSEGURO ////////////////////////////////// -->
					<?php if( ($forma_pagamento->id == 1) AND ($data_pedido->status <= 3) ){ ?>
						<div style="margin-top:20px;" >
							<?php
								date_default_timezone_set('America/Sao_Paulo');
								function curlExec($url, $post = NULL, array $header = array()){
									$ch = curl_init($url);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									if(count($header) > 0) {
										curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
									}
									if($post !== null) {
										curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post, '', '&'));
									}
									//Ignore SSL
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									$data = curl_exec($ch);

									curl_close($ch);
									return $data;
								}
								$params = array(
									'email' => 'financeiro@zoombusiness.com.br',
									'token' => '0FA44F019F824AFF9917B863CB3C1B1C'
								);
								$header = array();
								$response = curlExec("https://ws.sandbox.pagseguro.uol.com.br/v2/sessions", $params, $header);
								$json = json_decode(json_encode(simplexml_load_string($response)));
								$sessionCode = $json->id;
								// echo '<pre>';
								// print_r($_nome_usuario);
							?>
							
							<form role="form" action="<?=DOMINIO?>index/pay" method="POST">

								<input type="hidden" name="brand">
								<input type="hidden" name="token">
								<input type="hidden" name="forma_pagamento" value="<?=$forma_pagamento->id?>">
								<input type="hidden" name="senderHash">
								<input type="hidden" name="id_transacao" value="<?=$data_pedido->id_transacao_pagseguro?>">
								<input type="hidden" name="amount" value="<?=$data_pedido->valor_total?>">
								<input type="hidden" name="shippingCoast" value="0">



								<div class="row">
									<div class="col-xs-12">
										<div class="div_form" >
											<label>País</label><br>
											<input type="radio" id="Brasil_doc" name="country_document" <?= $data_dados->is_brasil == 1 ? 'checked':'' ?>  value="1">
											<label for="Brasil">Brasil </label>
											<input type="radio" id="Outros_doc" name="country_document" <?= $data_dados->is_brasil == 0 ? 'checked':'' ?>  value="0">
											<label for="Outros">Outros</label><br>
										</div>
									</div>
								</div>
								<br>	
								<div class="row">
									<div class="col-xs-8 col-md-8">
										<div class="form-group">
											<label for="cardNumber">Nome Completo</label>
											<input type="text" class="form-control" name="nomeCompleto" placeholder="Nome Completo" autocomplete="Nome completo" value="<?=$nome_cli?>" required/>
										</div>                            
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="nascimento">Data de Nascimento</label>
											<input type="date" class="form-control" name="nascimento" placeholder="Data de Nascimento" autocomplete="Data de Nascimento" value="<?=$fisica_nascimento?>" required/>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="email">E-mail</label>
											<input type="email" class="form-control" name="email" placeholder="E-mail" autocomplete="Email" value="<?=$email?>" required/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="tel">Telefone</label>
											<input type="text" class="form-control" name="telefone" id="telefone" maxlength="15" placeholder="Telefone" autocomplete="Telefone" value="<?=$telefone?>" required/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">												
												<label for="tel" id="label_cpf"><?= $data_dados->is_brasil == 1 ? 'CPF':'Documento' ?></label>
												<input type="text" style="<?= $data_dados->is_brasil == 1 ? '':'display: none' ?>" class="form-control" name="cpf" id="cpf"  placeholder="CPF" value="<?=$cpf?>" required/>
												<input type="text" style="<?= $data_dados->is_brasil == 0 ? '':'display: none' ?>" class="form-control" name="cpf_outros" id="documento_cpf"  placeholder="Documento" value="<?=$cpf?>" required/>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-12">
										<div class="div_form" >
											<label>País</label><br>
											<input type="radio" id="Brasil_end" name="country_endereco" <?= $data_dados->is_brasil_address == 1 ? 'checked':'' ?> value="1">
											<label for="Brasil">Brasil </label>
											<input type="radio" id="Outros_end" name="country_endereco" <?= $data_dados->is_brasil_address == 0 ? 'checked':'' ?> value="0">
											<label for="Outros">Outros</label><br>
										</div>
									</div>
								</div>
								<br>				
								<div class="endereco_brasil" style="<?= $data_dados->is_brasil_address == 1 ? '':'display: none' ?>">
									<div class="row">
										<div class="col-xs-10">
											<div class="form-group">
												<label for="cardNumber">Endereço</label>
												<input type="text" class="form-control" name="endereco" placeholder="Endereco" autocomplete="endereco" value="<?=$endereco?>" required/>
											</div>                            
										</div>
										<div class="col-xs-2">
											<div class="form-group">
												<label for="cardNumber">Número</label>
												<input type="text" class="form-control" name="numero" placeholder="Número" autocomplete="Número" value="<?=$numero?>" required/>
											</div>                            
										</div>
									</div>
									<div class="row">
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="bairro">Bairro</label>
												<input type="text" class="form-control" name="bairro" placeholder="Bairro" autocomplete="Bairro" value="<?=$bairro?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cep">CEP</label>
												<input type="text" class="form-control cep" name="cep" id="cep" placeholder="00000-000" value="<?=$cep?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Estado</label>
												<select id="estado" class="form-control" name="estado">
													<?php
														foreach ($estados as $key => $value) {
															if($value['selected']){ $select = "selected"; } else { $select = ""; }
															echo "<option value='".$value['uf']."' $select >".$value['nome']."</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Cidade</label>
												<div class="div_form" id="cadastro_cidade_div">
													<select id="cidade" name="cidade" class="form-control select2 cadastro_form" >
														<option value=''>Selecione a Cidade</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>


								
			
								<div class="endereco_outros" style="<?= $data_dados->is_brasil_address == 0 ? '':'display: none' ?>">
									<div class="row">
										<div class="col-xs-10">
											<div class="form-group">
												<label for="cardNumber">Endereço</label>
												<input type="text" class="form-control" name="endereco_outros" placeholder="Endereco" autocomplete="endereco" value="<?=$endereco?>" required/>
											</div>                            
										</div>
										<div class="col-xs-2">
											<div class="form-group">
												<label for="cardNumber">Número</label>
												<input type="text" class="form-control" name="numero_outros" placeholder="Número" autocomplete="Número" value="<?=$numero?>" required/>
											</div>                            
										</div>
									</div>
									<div class="row">
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="bairro">Bairro</label>
												<input type="text" class="form-control" name="bairro_outros" placeholder="Bairro" autocomplete="Bairro" value="<?=$bairro?>" />
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cep">CEP</label>
												<input type="text" class="form-control cep_outros" name="cep_outros" id="cep_outros" value="<?=$cep?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Estado</label>
												<input type="text" class="form-control estado_outros" name="estado_outros" id="estado_outros" value="<?=$estado?>" />
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Cidade</label>
												<input type="text" class="form-control cidade_outros" name="cidade_outros" id="cidade_outros" value="<?=$cidade?>" />
											</div>
										</div>
									</div>
								</div>





								<hr>
								
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="cardNumber">Nº Cartão</label>
											<div class="input-group">
												<input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus value="4111 1111 1111 1111"/>
												<span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
											</div>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-7 col-md-5">
										<div class="form-group">
											<label for="cardExpiry">Validade</label>
											<input type="tel" class="form-control" name="cardExpiry" placeholder="MM / YY" autocomplete="cc-exp" required value="12/2030"/>
										</div>
									</div>
									<div class="col-xs-3 col-md-3">
										<div class="form-group">
											<label for="cardCVC">CVV</label>
											<input type="tel" class="form-control" name="cardCVC" placeholder="CVV" autocomplete="cc-csc" required value="123"/>
										</div>
									</div>
									<div class="col-xs-2">
										<div class="form-group">
											<label for="installments">Parcelas</label>
												<select name="installments" id="select-installments" class="form-control">
													<option selected>1</option>
												</select>
												<input type="hidden" name="installmentValue">
										</div>                            
									</div>
									<div class="col-xs-2 col-md-2">
										<div class="form-group">
											<label for="recorrencia">Recorrencia?</label>
											<select id="recorrencia" class="form-control" name="recorrencia">
												<option value="1">Sim</option>
												<option value="0">Não</option>
											</select>
										</div>
									</div>
								</div>
								<br><br>
								<div class="row">
									<div class="col-xs-12">
										<button class="pagar_btn btn btn-success btn-lg btn-block" type="button">Pagar</button>
									</div>
								</div>





							</form>
							
						</div>

					<?php } ?>	

					<?php if($forma_pagamento->id == 2){ ?>

						<!-- <div style="padding:10px; margin-top:20px; background-color:#eee; font-size: 15px;" ><strong>Dados para Depósito:</strong><br><br><?=nl2br($forma_pagamento->deposito_dados)?></div>

						<?php
						if(!$data_pedido->comprovante){ ?>
							</div>
							<div class="container">
							<div class="row">
								<div class='col-xs-12 col-sm-12 col-md-12'>
									<div style="padding: 10px; ">

										<form action="<?=DOMINIO?><?=$controller?>/enviar_comprovante_pg" name="anexo_comprovante" id="anexo_comprovante" method="post" enctype="multipart/form-data" >

											<h5 class="titulo_padrao" style="width: 400px; text-align: left; font-size:20px !important; ">Enviar comprovante</h5>
											<div class="titulo_padrao_linha" ></div>

											<div style="color:red; font-size: 14px; font-weight: 500; margin-bottom:20px;">Envie seu comprovante o mais rápido possível para darmos sequencia ao seu pedido.</div>

											<div class="form-group">
												<label >Comprovante</label>
												<div >
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="input-append">
															<div class="uneditable-input">
																<i class="fa fa-file fileupload-exists"></i>
																<span class="fileupload-preview"></span>
															</div>
															<span class="btn btn-default btn-file">
																<span class="fileupload-exists">Alterar</span>
																<span class="fileupload-new">Procurar arquivo</span>
																<input type="file" name="arquivo" required />
															</span>
															<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
														</div>
													</div>
												</div>
											</div>

											<button type='button' class='btn botao_padrao <?=$botao_css?>' onClick="submit();" style="margin-top:20px;" >Anexar Comprovante</button>
											<input type="hidden" name="pedido" value="<?=$data_pedido->codigo?>">

										</form>
									</div>
								</div>
							</div>
						<?php } else {?>

							<div style="margin-top: 20px; font-size: 16px; font-weight: bold; color:#000;">Comprovante enviado!</div>

						<?php } ?> -->

					<?php } ?>

					<?php if( ($forma_pagamento->id == 3) AND ($data_pedido->status <= 3) ){ ?>

						<div style="margin-top:20px;" >
							<?php //echo '<pre>'; print_r($email);exit; ?>

							<style>

								#form-checkout {
								display: flex;
								flex-direction: column;
								width: 60%;
								margin: 100px 20%;
								padding: 10px 20px;
								background-color: #eee;	
								}
	
								.container iframe{
									background-color: #fff !important;
									/* padding: 10px 20px !important; */
									width: 100%;
									height: 25px !important;
								}
								.cont_iframe{
									width: 100%;
									padding: 0px;
									margin: 0px;
								}
								
							</style>

							<form id="form-checkout" action="<?=DOMINIO?>index/mercadopago_flow" method="POST">
								<p><b>Nome:</b> APRO - 
								<b>Cartão:</b> 5031433215406351 -
								<b>CVV:</b> 123 -
								<b>Data:</b> 11/2025 -
								<b>CPF:</b> 12345678909</p>
								
								<div id="form-checkout__cardNumber" class="container cont_iframe"></div>
								<div id="form-checkout__expirationDate" class="container cont_iframe"></div>
								<div id="form-checkout__securityCode" class="container cont_iframe"></div>
								
								<input type="text" id="form-checkout__cardholderName" placeholder="Titular do cartão"  class="fields" />
								<select id="form-checkout__issuer" name="issuer">
									<option value="" disabled selected>Banco emissor</option>
								</select>
								<select id="form-checkout__installments" name="installments">
								<option value="" disabled selected>Parcelas</option>
								</select>
								<select id="form-checkout__identificationType" name="identificationType">
								<option value="" disabled selected>Tipo de documento</option>
								</select>
								<input type="text" id="form-checkout__identificationNumber" class="fields" name="identificationNumber" placeholder="Número do documento" />
								<input type="email" value="<?=$email?>" id="form-checkout__email" name="email" class="fields" placeholder="E-mail"/>

								<input id="token" name="token" type="hidden">
								<input id="paymentMethodId" name="paymentMethodId" type="hidden">
								<input id="transactionAmount" name="transactionAmount" type="hidden" value="100">
								<input id="description" name="description" type="hidden" value="Nome do Produto">

								<input type="hidden"  name="mercadopago_client_id" value="<?=$forma_pagamento->mercadopago_client_id?>">
								<input type="hidden"  name="mercadopago_client_secret" value="<?=$forma_pagamento->mercadopago_client_secret?>">
								<input type="hidden"  name="mercadopago_public_key" value="<?=$forma_pagamento->mercadopago_public_key?>">
								<input type="hidden"  name="mercadopago_access_token" value="<?=$forma_pagamento->mercadopago_access_token?>">
								<input type="text" name="codigo" value="<?=$data_pedido->codigo?>">

								<button type="submit" id="form-checkout__submit">Pagar Agora</button>
							</form>
							<script src="https://sdk.mercadopago.com/js/v2"></script>
							 <script>
								const mp = new MercadoPago("<?=$forma_pagamento->mercadopago_public_key?>");
							</script>
							<script type="text/javascript">
								const publicKey = "<?=$forma_pagamento->mercadopago_public_key?>";
								const mercadopago = new MercadoPago(publicKey);

								//Inicializar campos de cartão
								const cardNumberElement = mp.fields.create('cardNumber', {
									placeholder: "Número do cartão"
									}).mount('form-checkout__cardNumber');
									const expirationDateElement = mp.fields.create('expirationDate', {
									placeholder: "MM/YY",
									}).mount('form-checkout__expirationDate');
									const securityCodeElement = mp.fields.create('securityCode', {
									placeholder: "Código de segurança"
									}).mount('form-checkout__securityCode');

								//Obter tipos de documento
								(async function getIdentificationTypes() {
									try {
										const identificationTypes = await mp.getIdentificationTypes();
										const identificationTypeElement = document.getElementById('form-checkout__identificationType');

										createSelectOptions(identificationTypeElement, identificationTypes);
									} catch (e) {
										return console.error('Error getting identificationTypes: ', e);
									}
									})();

									function createSelectOptions(elem, options, labelsAndKeys = { label: "name", value: "id" }) {
									const { label, value } = labelsAndKeys;

									elem.options.length = 0;

									const tempOptions = document.createDocumentFragment();

									options.forEach(option => {
										const optValue = option[value];
										const optLabel = option[label];

										const opt = document.createElement('option');
										opt.value = optValue;
										opt.textContent = optLabel;

										tempOptions.appendChild(opt);
									});

									elem.appendChild(tempOptions);
									}

								//Obter métodos de pagamento do cartão
								const paymentMethodElement = document.getElementById('paymentMethodId');
									const issuerElement = document.getElementById('form-checkout__issuer');
									const installmentsElement = document.getElementById('form-checkout__installments');

									const issuerPlaceholder = "Bandeira";
									const installmentsPlaceholder = "Parcelas";

									let currentBin;
									cardNumberElement.on('binChange', async (data) => {
									const { bin } = data;
									try {
										if (!bin && paymentMethodElement.value) {
										clearSelectsAndSetPlaceholders();
										paymentMethodElement.value = "";
										}

										if (bin && bin !== currentBin) {
										const { results } = await mp.getPaymentMethods({ bin });
										const paymentMethod = results[0];

										paymentMethodElement.value = paymentMethod.id;
										updatePCIFieldsSettings(paymentMethod);
										updateIssuer(paymentMethod, bin);
										updateInstallments(paymentMethod, bin);
										}

										currentBin = bin;
									} catch (e) {
										console.error('error getting payment methods: ', e)
									}
									});

									function clearSelectsAndSetPlaceholders() {
									clearHTMLSelectChildrenFrom(issuerElement);
									createSelectElementPlaceholder(issuerElement, issuerPlaceholder);

									clearHTMLSelectChildrenFrom(installmentsElement);
									createSelectElementPlaceholder(installmentsElement, installmentsPlaceholder);
									}

									function clearHTMLSelectChildrenFrom(element) {
									const currOptions = [...element.children];
									currOptions.forEach(child => child.remove());
									}

									function createSelectElementPlaceholder(element, placeholder) {
									const optionElement = document.createElement('option');
									optionElement.textContent = placeholder;
									optionElement.setAttribute('selected', "");
									optionElement.setAttribute('disabled', "");

									element.appendChild(optionElement);
									}

									// Esta etapa melhora as validações cardNumber e securityCode
									function updatePCIFieldsSettings(paymentMethod) {
									const { settings } = paymentMethod;

									const cardNumberSettings = settings[0].card_number;
									cardNumberElement.update({
										settings: cardNumberSettings
									});

									const securityCodeSettings = settings[0].security_code;
									securityCodeElement.update({
										settings: securityCodeSettings
									});
									}

								//Banco Emissor
								async function updateIssuer(paymentMethod, bin) {
									const { additional_info_needed, issuer } = paymentMethod;
									let issuerOptions = [issuer];

									if (additional_info_needed.includes('issuer_id')) {
										issuerOptions = await getIssuers(paymentMethod, bin);
									}

									createSelectOptions(issuerElement, issuerOptions);
									}

									async function getIssuers(paymentMethod, bin) {
									try {
										const { id: paymentMethodId } = paymentMethod;
										return await mp.getIssuers({ paymentMethodId, bin });
									} catch (e) {
										console.error('error getting issuers: ', e)
									}
									};

								//Obter quantidade de parcelas
								async function updateInstallments(paymentMethod, bin) {
									try {
										const installments = await mp.getInstallments({
										amount: document.getElementById('transactionAmount').value,
										bin,
										paymentTypeId: 'credit_card'
										});
										const installmentOptions = installments[0].payer_costs;
										const installmentOptionsKeys = { label: 'recommended_message', value: 'installments' };
										createSelectOptions(installmentsElement, installmentOptions, installmentOptionsKeys);
									} catch (error) {
										console.error('error getting installments: ', e)
									}
									}
									
								//Criar Token do Cartão de Crédito
								const formElement = document.getElementById('form-checkout');
									formElement.addEventListener('submit', createCardToken);

									async function createCardToken(event) {
									try {
										const tokenElement = document.getElementById('token');
										if (!tokenElement.value) {
										event.preventDefault();
										const token = await mp.fields.createCardToken({
											cardholderName: document.getElementById('form-checkout__cardholderName').value,
											identificationType: document.getElementById('form-checkout__identificationType').value,
											identificationNumber: document.getElementById('form-checkout__identificationNumber').value,
										});
										tokenElement.value = token.id;
										formElement.requestSubmit();
										}
									} catch (e) {
										console.error('error creating card token: ', e)
									}
									}

							</script>
							
							
							<form name="formulario_" id="form-checkout" method="POST" action="<?=DOMINIO?>index/mercadopago_flow">

								<input type="text"  name="mercadopago_client_id" value="<?=$forma_pagamento->mercadopago_client_id?>">
								<input type="text"  name="mercadopago_client_secret" value="<?=$forma_pagamento->mercadopago_client_secret?>">
								<input type="text"  name="mercadopago_public_key" value="<?=$forma_pagamento->mercadopago_public_key?>">
								<input type="text"  name="mercadopago_access_token" value="<?=$forma_pagamento->mercadopago_access_token?>">

								<input type="text"  name="is_brasil" value="<?=$data_dados->is_brasil?>">
								<input type="text"  name="is_brasil_address" value="<?=$data_dados->is_brasil_address?>">
								
								<input type="text" name="forma_pagamento" value="<?=$forma_pagamento->id?>">
								<input type="text" name="codigo" value="<?=$data_pedido->codigo?>">
								<input type="text" name="amount_" value="<?=$data_pedido->valor_total?>">
								
								<div class="row">
									<div class="col-xs-12">
										<div class="div_form" >
											<label>País</label><br>
											<input type="radio" id="Brasil_doc" name="country_document" <?= $data_dados->is_brasil == 1 ? 'checked':'' ?>  value="1">
											<label for="Brasil">Brasil </label>
											<input type="radio" id="Outros_doc" name="country_document" <?= $data_dados->is_brasil == 0 ? 'checked':'' ?>  value="0">
											<label for="Outros">Outros</label><br>
										</div>
									</div>
								</div>
								<br>	
								<div class="row">
									<div class="col-xs-8 col-md-8">
										<div class="form-group">
											<label for="cardNumber">Nome Completo</label>
											<!-- <input type="text" class="form-control" name="nomeCompleto" placeholder="Nome Completo" autocomplete="Nome completo" value="<?=$nome_cli?>" required/> -->
											<input type="text" id="form-checkout__cardholderName" name="nomeCompleto" placeholder="Nome Completo"  class="form-control" value="<?=$nome_cli?>"/>
										</div>                            
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="nascimento">Data de Nascimento</label>
											<input type="date" class="form-control" name="nascimento" placeholder="Data de Nascimento" autocomplete="Data de Nascimento" value="<?=$fisica_nascimento?>" required/>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="email">E-mail</label>
											<!-- <input type="email" class="form-control" name="email" placeholder="E-mail" autocomplete="Email" value="<?=$email?>" required/> -->
											<input type="email" value="<?=$email?>" id="form-checkout__email" name="email" class="form-control" placeholder="E-mail"/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="tel">Telefone</label>
											<input type="text" class="form-control" name="telefone" id="telefone" maxlength="15" placeholder="Telefone" autocomplete="Telefone" value="<?=$telefone?>" required/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">												
												<label for="tel" id="label_cpf"><?= $data_dados->is_brasil == 1 ? 'CPF':'Documento' ?></label>
												<input type="text" style="<?= $data_dados->is_brasil == 1 ? '':'display: none' ?>" class="form-control" name="cpf" id="cpf"  placeholder="CPF" value="<?=$cpf?>" required/>
												<input type="text" style="<?= $data_dados->is_brasil == 0 ? '':'display: none' ?>" class="form-control" name="cpf_outros" id="documento_cpf"  placeholder="Documento" value="<?=$cpf?>" required/>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-12">
										<div class="div_form" >
											<label>País</label><br>
											<input type="radio" id="Brasil_end" name="country_endereco" <?= $data_dados->is_brasil_address == 1 ? 'checked':'' ?> value="1">
											<label for="Brasil">Brasil </label>
											<input type="radio" id="Outros_end" name="country_endereco" <?= $data_dados->is_brasil_address == 0 ? 'checked':'' ?> value="0">
											<label for="Outros">Outros</label><br>
										</div>
									</div>
								</div>
								<br>	

								<div class="endereco_brasil" style="<?= $data_dados->is_brasil_address == 1 ? '':'display: none' ?>">
									<div class="row">
										<div class="col-xs-10">
											<div class="form-group">
												<label for="cardNumber">Endereço</label>
												<input type="text" class="form-control" name="endereco" placeholder="Endereco" autocomplete="endereco" value="<?=$endereco?>" required/>
											</div>                            
										</div>
										<div class="col-xs-2">
											<div class="form-group">
												<label for="cardNumber">Número</label>
												<input type="text" class="form-control" name="numero" placeholder="Número" autocomplete="Número" value="<?=$numero?>" required/>
											</div>                            
										</div>
									</div>
									<div class="row">
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="bairro">Bairro</label>
												<input type="text" class="form-control" name="bairro" placeholder="Bairro" autocomplete="Bairro" value="<?=$bairro?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cep">CEP</label>
												<input type="text" class="form-control cep" name="cep" id="cep" placeholder="00000-000" value="<?=$cep?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Estado</label>
												<select id="estado" class="form-control" name="estado">
													<?php
														foreach ($estados as $key => $value) {
															if($value['selected']){ $select = "selected"; } else { $select = ""; }
															echo "<option value='".$value['uf']."' $select >".$value['nome']."</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Cidade</label>
												<div class="div_form" id="cadastro_cidade_div">
													<select id="cidade" name="cidade" class="form-control select2 cadastro_form" >
														<option value=''>Selecione a Cidade</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
			
								<div class="endereco_outros" style="<?= $data_dados->is_brasil_address == 0 ? '':'display: none' ?>">
									<div class="row">
										<div class="col-xs-10">
											<div class="form-group">
												<label for="cardNumber">Endereço</label>
												<input type="text" class="form-control" name="endereco_outros" placeholder="Endereco" autocomplete="endereco" value="<?=$endereco?>" required/>
											</div>                            
										</div>
										<div class="col-xs-2">
											<div class="form-group">
												<label for="cardNumber">Número</label>
												<input type="text" class="form-control" name="numero_outros" placeholder="Número" autocomplete="Número" value="<?=$numero?>" required/>
											</div>                            
										</div>
									</div>
									<div class="row">
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="bairro">Bairro</label>
												<input type="text" class="form-control" name="bairro_outros" placeholder="Bairro" autocomplete="Bairro" value="<?=$bairro?>" />
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cep">CEP</label>
												<input type="text" class="form-control cep_outros" name="cep_outros" id="cep_outros" value="<?=$cep?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Estado</label>
												<input type="text" class="form-control estado_outros" name="estado_outros" id="estado_outros" value="<?=$estado?>" />
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Cidade</label>
												<input type="text" class="form-control cidade_outros" name="cidade_outros" id="cidade_outros" value="<?=$cidade?>" />
											</div>
										</div>
									</div>
								</div>

								<hr>
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="cardNumber">Nº Cartão</label>
											<div class="input-group">
												<!-- <input type="tel" class="form-control" name="cardNumber" pattern=".{17,19}" placeholder="Valid Card Number" id="input-cc" autocomplete="cc-number" required autofocus value=""/> -->
												<div id="form-checkout__cardNumber" class="container cont_iframe"></div>
												<span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
											</div>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<div class="form-group">
											<label for="cardExpiry">Validade</label>
											<input type="tel" class="form-control"  data-mask="00/0000" name="cardExpiry" placeholder="MM/YYYY" autocomplete="cc-exp" required />
										</div>
									</div>
									<div class="col-xs-6 col-md-6">
										<div class="form-group">
											<label for="cardCVC">CVV</label>
											<input type="tel" class="form-control" data-mask="000" name="cardCVC" placeholder="CVV" autocomplete="cc-csc" required value="123"/>
										</div>
									</div>
									<div class="col-xs-2">
										<div class="form-group">
											<label for="installments">Recorrencia</label>
												<select name="recorrencia" class="form-control">
													<option selected value="0">0</option>
													<option value="1">Mensal</option>
												</select> 
												<input type="hidden" name="carrinho_coisas[]" value=<?$produtos['lista']?>>
												<input type="hidden" name="installmentValue">
										</div>                            
									</div>
								</div>
								<br><br>
								<div class="row">
									<div class="col-xs-12">
										<button id="btn_pagar_bill" class="btn btn-success btn-lg btn-block" type="submit">Pagar</button>
									</div>
								</div>
								<?php
									// foreach ($produtos['lista'] as $key => $value) {
									// 	echo $value['titulo'].$value['quantidade'].$value['id_produto'];

									// 	$n++;
									// }
								?>
							</form>	
						
						</div>

					<?php } ?>

					<?php if( ($forma_pagamento->id == 8) AND ($data_pedido->status <= 3) ){ ?>

						<!-- <div style="margin-top:20px;" >
							
							<div style="font-size:15px; font-weight:500; color:#666;">Pague com RQCODE PIX</div>
							<div style="margin-top:0px; margin-left: -15px;">
								<img style='width:250px; height: 250px;' src='data:image/png;base64, <?=$data_pedido->pix_qrcode?>' > 
							</div>

							<textarea class="form-control" style="width:250px; height:30px;" id="chavepix"><?=$data_pedido->pix_chave?></textarea>
							<div style="margin-top:10px;"><a onclick="copiachave();" style="cursor: pointer;display: inline-block;" class="btn btn-default">Copiar Chave PIX</a></div>

							<div style="font-size: 12px; margin-top: 10px;">Caso já tenha efetuado o pagamento aguarde a compensação.</div>
						</div> -->

					<?php } ?>

					<?php if( ($forma_pagamento->id == 4) AND ($data_pedido->status <= 3) ){ ?>
						
						<!-- <div style="font-size: 12px; margin-top: 10px;">Caso já tenha efetuado o pagamento aguarde a compensação.</div>
						
						<div style="margin-top:20px; width: 70%; text-align: left;" >
							
							<?php

								// $forma_pagamento->paypal_conta
								// $forma_pagamento->paypal_clienteid
								// $forma_pagamento->paypal_clientesecret

							?>

							<div id="paypal-button-container"></div>


							<script src="https://www.paypal.com/sdk/js?client-id=<?=$forma_pagamento->paypal_clienteid?>&currency=BRL"></script>

							<script>
								paypal.Buttons({

									createOrder: function(data, actions) {
										return actions.order.create({
											purchase_units: [{
												reference_id: '<?=$data_pedido->id?>',
												description: 'Pedido <?=$data_pedido->id?>',
												amount: {
													value: '<?=$valor_total_pedido_paypal?>'
												}
											}]
										});
									},

									onApprove: function(data, actions) {
										return actions.order.capture().then(function(details) {
											window.location='<?=DOMINIO?><?=$controller?>/pagamento_paypal/codigo/<?=$data_pedido->codigo?>/id/'+data.orderID+'/payerid/'+data.payerID+'/paymentid/'+data.paymentID;
										});
									}

								}).render('#paypal-button-container');
							</script>


							

						</div> -->

					<?php } ?>

					<!-- ////////////////////////////  VINDI   ///////////////////////////  -->
					<?php if( ($forma_pagamento->id == 5) AND ($data_pedido->status <= 3) ){ ?>
						<script>
							!function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t():"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?exports.Cleave=t():e.Cleave=t()}(this,function(){return function(e){function t(i){if(r[i])return r[i].exports;var n=r[i]={exports:{},id:i,loaded:!1};return e[i].call(n.exports,n,n.exports,t),n.loaded=!0,n.exports}var r={};return t.m=e,t.c=r,t.p="",t(0)}([function(e,t,r){(function(t){"use strict";var i=function(e,t){var r=this,n=!1;if("string"==typeof e?(r.element=document.querySelector(e),n=document.querySelectorAll(e).length>1):"undefined"!=typeof e.length&&e.length>0?(r.element=e[0],n=e.length>1):r.element=e,!r.element)throw new Error("[cleave.js] Please check the element");if(n)try{console.warn("[cleave.js] Multiple input fields matched, cleave.js will only take the first one.")}catch(a){}t.initValue=r.element.value,r.properties=i.DefaultProperties.assign({},t),r.init()};i.prototype={init:function(){var e=this,t=e.properties;return t.numeral||t.phone||t.creditCard||t.time||t.date||0!==t.blocksLength||t.prefix?(t.maxLength=i.Util.getMaxLength(t.blocks),e.isAndroid=i.Util.isAndroid(),e.lastInputValue="",e.isBackward="",e.onChangeListener=e.onChange.bind(e),e.onKeyDownListener=e.onKeyDown.bind(e),e.onFocusListener=e.onFocus.bind(e),e.onCutListener=e.onCut.bind(e),e.onCopyListener=e.onCopy.bind(e),e.initSwapHiddenInput(),e.element.addEventListener("input",e.onChangeListener),e.element.addEventListener("keydown",e.onKeyDownListener),e.element.addEventListener("focus",e.onFocusListener),e.element.addEventListener("cut",e.onCutListener),e.element.addEventListener("copy",e.onCopyListener),e.initPhoneFormatter(),e.initDateFormatter(),e.initTimeFormatter(),e.initNumeralFormatter(),void((t.initValue||t.prefix&&!t.noImmediatePrefix)&&e.onInput(t.initValue))):void e.onInput(t.initValue)},initSwapHiddenInput:function(){var e=this,t=e.properties;if(t.swapHiddenInput){var r=e.element.cloneNode(!0);e.element.parentNode.insertBefore(r,e.element),e.elementSwapHidden=e.element,e.elementSwapHidden.type="hidden",e.element=r,e.element.id=""}},initNumeralFormatter:function(){var e=this,t=e.properties;t.numeral&&(t.numeralFormatter=new i.NumeralFormatter(t.numeralDecimalMark,t.numeralIntegerScale,t.numeralDecimalScale,t.numeralThousandsGroupStyle,t.numeralPositiveOnly,t.stripLeadingZeroes,t.prefix,t.signBeforePrefix,t.tailPrefix,t.delimiter))},initTimeFormatter:function(){var e=this,t=e.properties;t.time&&(t.timeFormatter=new i.TimeFormatter(t.timePattern,t.timeFormat),t.blocks=t.timeFormatter.getBlocks(),t.blocksLength=t.blocks.length,t.maxLength=i.Util.getMaxLength(t.blocks))},initDateFormatter:function(){var e=this,t=e.properties;t.date&&(t.dateFormatter=new i.DateFormatter(t.datePattern,t.dateMin,t.dateMax),t.blocks=t.dateFormatter.getBlocks(),t.blocksLength=t.blocks.length,t.maxLength=i.Util.getMaxLength(t.blocks))},initPhoneFormatter:function(){var e=this,t=e.properties;if(t.phone)try{t.phoneFormatter=new i.PhoneFormatter(new t.root.Cleave.AsYouTypeFormatter(t.phoneRegionCode),t.delimiter)}catch(r){throw new Error("[cleave.js] Please include phone-type-formatter.{country}.js lib")}},onKeyDown:function(e){var t=this,r=e.which||e.keyCode;t.lastInputValue=t.element.value,t.isBackward=8===r},onChange:function(e){var t=this,r=t.properties,n=i.Util;t.isBackward=t.isBackward||"deleteContentBackward"===e.inputType;var a=n.getPostDelimiter(t.lastInputValue,r.delimiter,r.delimiters);t.isBackward&&a?r.postDelimiterBackspace=a:r.postDelimiterBackspace=!1,this.onInput(this.element.value)},onFocus:function(){var e=this,t=e.properties;e.lastInputValue=e.element.value,t.prefix&&t.noImmediatePrefix&&!e.element.value&&this.onInput(t.prefix),i.Util.fixPrefixCursor(e.element,t.prefix,t.delimiter,t.delimiters)},onCut:function(e){i.Util.checkFullSelection(this.element.value)&&(this.copyClipboardData(e),this.onInput(""))},onCopy:function(e){i.Util.checkFullSelection(this.element.value)&&this.copyClipboardData(e)},copyClipboardData:function(e){var t=this,r=t.properties,n=i.Util,a=t.element.value,o="";o=r.copyDelimiter?a:n.stripDelimiters(a,r.delimiter,r.delimiters);try{e.clipboardData?e.clipboardData.setData("Text",o):window.clipboardData.setData("Text",o),e.preventDefault()}catch(l){}},onInput:function(e){var t=this,r=t.properties,n=i.Util,a=n.getPostDelimiter(e,r.delimiter,r.delimiters);return r.numeral||!r.postDelimiterBackspace||a||(e=n.headStr(e,e.length-r.postDelimiterBackspace.length)),r.phone?(!r.prefix||r.noImmediatePrefix&&!e.length?r.result=r.phoneFormatter.format(e):r.result=r.prefix+r.phoneFormatter.format(e).slice(r.prefix.length),void t.updateValueState()):r.numeral?(r.prefix&&r.noImmediatePrefix&&0===e.length?r.result="":r.result=r.numeralFormatter.format(e),void t.updateValueState()):(r.date&&(e=r.dateFormatter.getValidatedDate(e)),r.time&&(e=r.timeFormatter.getValidatedTime(e)),e=n.stripDelimiters(e,r.delimiter,r.delimiters),e=n.getPrefixStrippedValue(e,r.prefix,r.prefixLength,r.result,r.delimiter,r.delimiters,r.noImmediatePrefix,r.tailPrefix,r.signBeforePrefix),e=r.numericOnly?n.strip(e,/[^\d]/g):e,e=r.uppercase?e.toUpperCase():e,e=r.lowercase?e.toLowerCase():e,r.prefix&&(r.tailPrefix?e+=r.prefix:e=r.prefix+e,0===r.blocksLength)?(r.result=e,void t.updateValueState()):(r.creditCard&&t.updateCreditCardPropsByValue(e),e=n.headStr(e,r.maxLength),r.result=n.getFormattedValue(e,r.blocks,r.blocksLength,r.delimiter,r.delimiters,r.delimiterLazyShow),void t.updateValueState()))},updateCreditCardPropsByValue:function(e){var t,r=this,n=r.properties,a=i.Util;a.headStr(n.result,4)!==a.headStr(e,4)&&(t=i.CreditCardDetector.getInfo(e,n.creditCardStrictMode),n.blocks=t.blocks,n.blocksLength=n.blocks.length,n.maxLength=a.getMaxLength(n.blocks),n.creditCardType!==t.type&&(n.creditCardType=t.type,n.onCreditCardTypeChanged.call(r,n.creditCardType)))},updateValueState:function(){var e=this,t=i.Util,r=e.properties;if(e.element){var n=e.element.selectionEnd,a=e.element.value,o=r.result;if(n=t.getNextCursorPosition(n,a,o,r.delimiter,r.delimiters),e.isAndroid)return void window.setTimeout(function(){e.element.value=o,t.setSelection(e.element,n,r.document,!1),e.callOnValueChanged()},1);e.element.value=o,r.swapHiddenInput&&(e.elementSwapHidden.value=e.getRawValue()),t.setSelection(e.element,n,r.document,!1),e.callOnValueChanged()}},callOnValueChanged:function(){var e=this,t=e.properties;t.onValueChanged.call(e,{target:{name:e.element.name,value:t.result,rawValue:e.getRawValue()}})},setPhoneRegionCode:function(e){var t=this,r=t.properties;r.phoneRegionCode=e,t.initPhoneFormatter(),t.onChange()},setRawValue:function(e){var t=this,r=t.properties;e=void 0!==e&&null!==e?e.toString():"",r.numeral&&(e=e.replace(".",r.numeralDecimalMark)),r.postDelimiterBackspace=!1,t.element.value=e,t.onInput(e)},getRawValue:function(){var e=this,t=e.properties,r=i.Util,n=e.element.value;return t.rawValueTrimPrefix&&(n=r.getPrefixStrippedValue(n,t.prefix,t.prefixLength,t.result,t.delimiter,t.delimiters,t.noImmediatePrefix,t.tailPrefix,t.signBeforePrefix)),n=t.numeral?t.numeralFormatter.getRawValue(n):r.stripDelimiters(n,t.delimiter,t.delimiters)},getISOFormatDate:function(){var e=this,t=e.properties;return t.date?t.dateFormatter.getISOFormatDate():""},getISOFormatTime:function(){var e=this,t=e.properties;return t.time?t.timeFormatter.getISOFormatTime():""},getFormattedValue:function(){return this.element.value},destroy:function(){var e=this;e.element.removeEventListener("input",e.onChangeListener),e.element.removeEventListener("keydown",e.onKeyDownListener),e.element.removeEventListener("focus",e.onFocusListener),e.element.removeEventListener("cut",e.onCutListener),e.element.removeEventListener("copy",e.onCopyListener)},toString:function(){return"[Cleave Object]"}},i.NumeralFormatter=r(1),i.DateFormatter=r(2),i.TimeFormatter=r(3),i.PhoneFormatter=r(4),i.CreditCardDetector=r(5),i.Util=r(6),i.DefaultProperties=r(7),("object"==typeof t&&t?t:window).Cleave=i,e.exports=i}).call(t,function(){return this}())},function(e,t){"use strict";var r=function(e,t,i,n,a,o,l,s,c,u){var d=this;d.numeralDecimalMark=e||".",d.numeralIntegerScale=t>0?t:0,d.numeralDecimalScale=i>=0?i:2,d.numeralThousandsGroupStyle=n||r.groupStyle.thousand,d.numeralPositiveOnly=!!a,d.stripLeadingZeroes=o!==!1,d.prefix=l||""===l?l:"",d.signBeforePrefix=!!s,d.tailPrefix=!!c,d.delimiter=u||""===u?u:",",d.delimiterRE=u?new RegExp("\\"+u,"g"):""};r.groupStyle={thousand:"thousand",lakh:"lakh",wan:"wan",none:"none"},r.prototype={getRawValue:function(e){return e.replace(this.delimiterRE,"").replace(this.numeralDecimalMark,".")},format:function(e){var t,i,n,a,o=this,l="";switch(e=e.replace(/[A-Za-z]/g,"").replace(o.numeralDecimalMark,"M").replace(/[^\dM-]/g,"").replace(/^\-/,"N").replace(/\-/g,"").replace("N",o.numeralPositiveOnly?"":"-").replace("M",o.numeralDecimalMark),o.stripLeadingZeroes&&(e=e.replace(/^(-)?0+(?=\d)/,"$1")),i="-"===e.slice(0,1)?"-":"",n="undefined"!=typeof o.prefix?o.signBeforePrefix?i+o.prefix:o.prefix+i:i,a=e,e.indexOf(o.numeralDecimalMark)>=0&&(t=e.split(o.numeralDecimalMark),a=t[0],l=o.numeralDecimalMark+t[1].slice(0,o.numeralDecimalScale)),"-"===i&&(a=a.slice(1)),o.numeralIntegerScale>0&&(a=a.slice(0,o.numeralIntegerScale)),o.numeralThousandsGroupStyle){case r.groupStyle.lakh:a=a.replace(/(\d)(?=(\d\d)+\d$)/g,"$1"+o.delimiter);break;case r.groupStyle.wan:a=a.replace(/(\d)(?=(\d{4})+$)/g,"$1"+o.delimiter);break;case r.groupStyle.thousand:a=a.replace(/(\d)(?=(\d{3})+$)/g,"$1"+o.delimiter)}return o.tailPrefix?i+a.toString()+(o.numeralDecimalScale>0?l.toString():"")+o.prefix:n+a.toString()+(o.numeralDecimalScale>0?l.toString():"")}},e.exports=r},function(e,t){"use strict";var r=function(e,t,r){var i=this;i.date=[],i.blocks=[],i.datePattern=e,i.dateMin=t.split("-").reverse().map(function(e){return parseInt(e,10)}),2===i.dateMin.length&&i.dateMin.unshift(0),i.dateMax=r.split("-").reverse().map(function(e){return parseInt(e,10)}),2===i.dateMax.length&&i.dateMax.unshift(0),i.initBlocks()};r.prototype={initBlocks:function(){var e=this;e.datePattern.forEach(function(t){"Y"===t?e.blocks.push(4):e.blocks.push(2)})},getISOFormatDate:function(){var e=this,t=e.date;return t[2]?t[2]+"-"+e.addLeadingZero(t[1])+"-"+e.addLeadingZero(t[0]):""},getBlocks:function(){return this.blocks},getValidatedDate:function(e){var t=this,r="";return e=e.replace(/[^\d]/g,""),t.blocks.forEach(function(i,n){if(e.length>0){var a=e.slice(0,i),o=a.slice(0,1),l=e.slice(i);switch(t.datePattern[n]){case"d":"00"===a?a="01":parseInt(o,10)>3?a="0"+o:parseInt(a,10)>31&&(a="31");break;case"m":"00"===a?a="01":parseInt(o,10)>1?a="0"+o:parseInt(a,10)>12&&(a="12")}r+=a,e=l}}),this.getFixedDateString(r)},getFixedDateString:function(e){var t,r,i,n=this,a=n.datePattern,o=[],l=0,s=0,c=0,u=0,d=0,m=0,p=!1;4===e.length&&"y"!==a[0].toLowerCase()&&"y"!==a[1].toLowerCase()&&(u="d"===a[0]?0:2,d=2-u,t=parseInt(e.slice(u,u+2),10),r=parseInt(e.slice(d,d+2),10),o=this.getFixedDate(t,r,0)),8===e.length&&(a.forEach(function(e,t){switch(e){case"d":l=t;break;case"m":s=t;break;default:c=t}}),m=2*c,u=l<=c?2*l:2*l+2,d=s<=c?2*s:2*s+2,t=parseInt(e.slice(u,u+2),10),r=parseInt(e.slice(d,d+2),10),i=parseInt(e.slice(m,m+4),10),p=4===e.slice(m,m+4).length,o=this.getFixedDate(t,r,i)),4!==e.length||"y"!==a[0]&&"y"!==a[1]||(d="m"===a[0]?0:2,m=2-d,r=parseInt(e.slice(d,d+2),10),i=parseInt(e.slice(m,m+2),10),p=2===e.slice(m,m+2).length,o=[0,r,i]),6!==e.length||"Y"!==a[0]&&"Y"!==a[1]||(d="m"===a[0]?0:4,m=2-.5*d,r=parseInt(e.slice(d,d+2),10),i=parseInt(e.slice(m,m+4),10),p=4===e.slice(m,m+4).length,o=[0,r,i]),o=n.getRangeFixedDate(o),n.date=o;var h=0===o.length?e:a.reduce(function(e,t){switch(t){case"d":return e+(0===o[0]?"":n.addLeadingZero(o[0]));case"m":return e+(0===o[1]?"":n.addLeadingZero(o[1]));case"y":return e+(p?n.addLeadingZeroForYear(o[2],!1):"");case"Y":return e+(p?n.addLeadingZeroForYear(o[2],!0):"")}},"");return h},getRangeFixedDate:function(e){var t=this,r=t.datePattern,i=t.dateMin||[],n=t.dateMax||[];return!e.length||i.length<3&&n.length<3?e:r.find(function(e){return"y"===e.toLowerCase()})&&0===e[2]?e:n.length&&(n[2]<e[2]||n[2]===e[2]&&(n[1]<e[1]||n[1]===e[1]&&n[0]<e[0]))?n:i.length&&(i[2]>e[2]||i[2]===e[2]&&(i[1]>e[1]||i[1]===e[1]&&i[0]>e[0]))?i:e},getFixedDate:function(e,t,r){return e=Math.min(e,31),t=Math.min(t,12),r=parseInt(r||0,10),(t<7&&t%2===0||t>8&&t%2===1)&&(e=Math.min(e,2===t?this.isLeapYear(r)?29:28:30)),[e,t,r]},isLeapYear:function(e){return e%4===0&&e%100!==0||e%400===0},addLeadingZero:function(e){return(e<10?"0":"")+e},addLeadingZeroForYear:function(e,t){return t?(e<10?"000":e<100?"00":e<1e3?"0":"")+e:(e<10?"0":"")+e}},e.exports=r},function(e,t){"use strict";var r=function(e,t){var r=this;r.time=[],r.blocks=[],r.timePattern=e,r.timeFormat=t,r.initBlocks()};r.prototype={initBlocks:function(){var e=this;e.timePattern.forEach(function(){e.blocks.push(2)})},getISOFormatTime:function(){var e=this,t=e.time;return t[2]?e.addLeadingZero(t[0])+":"+e.addLeadingZero(t[1])+":"+e.addLeadingZero(t[2]):""},getBlocks:function(){return this.blocks},getTimeFormatOptions:function(){var e=this;return"12"===String(e.timeFormat)?{maxHourFirstDigit:1,maxHours:12,maxMinutesFirstDigit:5,maxMinutes:60}:{maxHourFirstDigit:2,maxHours:23,maxMinutesFirstDigit:5,maxMinutes:60}},getValidatedTime:function(e){var t=this,r="";e=e.replace(/[^\d]/g,"");var i=t.getTimeFormatOptions();return t.blocks.forEach(function(n,a){if(e.length>0){var o=e.slice(0,n),l=o.slice(0,1),s=e.slice(n);switch(t.timePattern[a]){case"h":parseInt(l,10)>i.maxHourFirstDigit?o="0"+l:parseInt(o,10)>i.maxHours&&(o=i.maxHours+"");break;case"m":case"s":parseInt(l,10)>i.maxMinutesFirstDigit?o="0"+l:parseInt(o,10)>i.maxMinutes&&(o=i.maxMinutes+"")}r+=o,e=s}}),this.getFixedTimeString(r)},getFixedTimeString:function(e){var t,r,i,n=this,a=n.timePattern,o=[],l=0,s=0,c=0,u=0,d=0,m=0;return 6===e.length&&(a.forEach(function(e,t){switch(e){case"s":l=2*t;break;case"m":s=2*t;break;case"h":c=2*t}}),m=c,d=s,u=l,t=parseInt(e.slice(u,u+2),10),r=parseInt(e.slice(d,d+2),10),i=parseInt(e.slice(m,m+2),10),o=this.getFixedTime(i,r,t)),4===e.length&&n.timePattern.indexOf("s")<0&&(a.forEach(function(e,t){switch(e){case"m":s=2*t;break;case"h":c=2*t}}),m=c,d=s,t=0,r=parseInt(e.slice(d,d+2),10),i=parseInt(e.slice(m,m+2),10),o=this.getFixedTime(i,r,t)),n.time=o,0===o.length?e:a.reduce(function(e,t){switch(t){case"s":return e+n.addLeadingZero(o[2]);case"m":return e+n.addLeadingZero(o[1]);case"h":return e+n.addLeadingZero(o[0])}},"")},getFixedTime:function(e,t,r){return r=Math.min(parseInt(r||0,10),60),t=Math.min(t,60),e=Math.min(e,60),[e,t,r]},addLeadingZero:function(e){return(e<10?"0":"")+e}},e.exports=r},function(e,t){"use strict";var r=function(e,t){var r=this;r.delimiter=t||""===t?t:" ",r.delimiterRE=t?new RegExp("\\"+t,"g"):"",r.formatter=e};r.prototype={setFormatter:function(e){this.formatter=e},format:function(e){var t=this;t.formatter.clear(),e=e.replace(/[^\d+]/g,""),e=e.replace(/^\+/,"B").replace(/\+/g,"").replace("B","+"),e=e.replace(t.delimiterRE,"");for(var r,i="",n=!1,a=0,o=e.length;a<o;a++)r=t.formatter.inputDigit(e.charAt(a)),/[\s()-]/g.test(r)?(i=r,n=!0):n||(i=r);return i=i.replace(/[()]/g,""),i=i.replace(/[\s-]/g,t.delimiter)}},e.exports=r},function(e,t){"use strict";var r={blocks:{uatp:[4,5,6],amex:[4,6,5],diners:[4,6,4],discover:[4,4,4,4],mastercard:[4,4,4,4],dankort:[4,4,4,4],instapayment:[4,4,4,4],jcb15:[4,6,5],jcb:[4,4,4,4],maestro:[4,4,4,4],visa:[4,4,4,4],mir:[4,4,4,4],unionPay:[4,4,4,4],general:[4,4,4,4]},re:{uatp:/^(?!1800)1\d{0,14}/,amex:/^3[47]\d{0,13}/,discover:/^(?:6011|65\d{0,2}|64[4-9]\d?)\d{0,12}/,diners:/^3(?:0([0-5]|9)|[689]\d?)\d{0,11}/,mastercard:/^(5[1-5]\d{0,2}|22[2-9]\d{0,1}|2[3-7]\d{0,2})\d{0,12}/,dankort:/^(5019|4175|4571)\d{0,12}/,instapayment:/^63[7-9]\d{0,13}/,jcb15:/^(?:2131|1800)\d{0,11}/,jcb:/^(?:35\d{0,2})\d{0,12}/,maestro:/^(?:5[0678]\d{0,2}|6304|67\d{0,2})\d{0,12}/,mir:/^220[0-4]\d{0,12}/,visa:/^4\d{0,15}/,unionPay:/^(62|81)\d{0,14}/},getStrictBlocks:function(e){var t=e.reduce(function(e,t){return e+t},0);return e.concat(19-t)},getInfo:function(e,t){var i=r.blocks,n=r.re;t=!!t;for(var a in n)if(n[a].test(e)){var o=i[a];return{type:a,blocks:t?this.getStrictBlocks(o):o}}return{type:"unknown",blocks:t?this.getStrictBlocks(i.general):i.general}}};e.exports=r},function(e,t){"use strict";var r={noop:function(){},strip:function(e,t){return e.replace(t,"")},getPostDelimiter:function(e,t,r){if(0===r.length)return e.slice(-t.length)===t?t:"";var i="";return r.forEach(function(t){e.slice(-t.length)===t&&(i=t)}),i},getDelimiterREByDelimiter:function(e){return new RegExp(e.replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1"),"g")},getNextCursorPosition:function(e,t,r,i,n){return t.length===e?r.length:e+this.getPositionOffset(e,t,r,i,n)},getPositionOffset:function(e,t,r,i,n){var a,o,l;return a=this.stripDelimiters(t.slice(0,e),i,n),o=this.stripDelimiters(r.slice(0,e),i,n),l=a.length-o.length,0!==l?l/Math.abs(l):0},stripDelimiters:function(e,t,r){var i=this;if(0===r.length){var n=t?i.getDelimiterREByDelimiter(t):"";return e.replace(n,"")}return r.forEach(function(t){t.split("").forEach(function(t){e=e.replace(i.getDelimiterREByDelimiter(t),"")})}),e},headStr:function(e,t){return e.slice(0,t)},getMaxLength:function(e){return e.reduce(function(e,t){return e+t},0)},getPrefixStrippedValue:function(e,t,r,i,n,a,o,l,s){if(0===r)return e;if(e===t&&""!==e)return"";if(s&&"-"==e.slice(0,1)){var c="-"==i.slice(0,1)?i.slice(1):i;return"-"+this.getPrefixStrippedValue(e.slice(1),t,r,c,n,a,o,l,s)}if(i.slice(0,r)!==t&&!l)return o&&!i&&e?e:"";if(i.slice(-r)!==t&&l)return o&&!i&&e?e:"";var u=this.stripDelimiters(i,n,a);return e.slice(0,r)===t||l?e.slice(-r)!==t&&l?u.slice(0,-r-1):l?e.slice(0,-r):e.slice(r):u.slice(r)},getFirstDiffIndex:function(e,t){for(var r=0;e.charAt(r)===t.charAt(r);)if(""===e.charAt(r++))return-1;return r},getFormattedValue:function(e,t,r,i,n,a){var o="",l=n.length>0,s="";return 0===r?e:(t.forEach(function(t,c){if(e.length>0){var u=e.slice(0,t),d=e.slice(t);s=l?n[a?c-1:c]||s:i,a?(c>0&&(o+=s),o+=u):(o+=u,u.length===t&&c<r-1&&(o+=s)),e=d}}),o)},fixPrefixCursor:function(e,t,r,i){if(e){var n=e.value,a=r||i[0]||" ";if(e.setSelectionRange&&t&&!(t.length+a.length<=n.length)){var o=2*n.length;setTimeout(function(){e.setSelectionRange(o,o)},1)}}},checkFullSelection:function(e){try{var t=window.getSelection()||document.getSelection()||{};return t.toString().length===e.length}catch(r){}return!1},setSelection:function(e,t,r){if(e===this.getActiveElement(r)&&!(e&&e.value.length<=t))if(e.createTextRange){var i=e.createTextRange();i.move("character",t),i.select()}else try{e.setSelectionRange(t,t)}catch(n){console.warn("The input element type does not support selection")}},getActiveElement:function(e){var t=e.activeElement;return t&&t.shadowRoot?this.getActiveElement(t.shadowRoot):t},isAndroid:function(){return navigator&&/android/i.test(navigator.userAgent)},isAndroidBackspaceKeydown:function(e,t){return!!(this.isAndroid()&&e&&t)&&t===e.slice(0,-1)}};e.exports=r},function(e,t){(function(t){"use strict";var r={assign:function(e,r){return e=e||{},r=r||{},e.creditCard=!!r.creditCard,e.creditCardStrictMode=!!r.creditCardStrictMode,e.creditCardType="",e.onCreditCardTypeChanged=r.onCreditCardTypeChanged||function(){},e.phone=!!r.phone,e.phoneRegionCode=r.phoneRegionCode||"AU",e.phoneFormatter={},e.time=!!r.time,e.timePattern=r.timePattern||["h","m","s"],e.timeFormat=r.timeFormat||"24",e.timeFormatter={},e.date=!!r.date,e.datePattern=r.datePattern||["d","m","Y"],e.dateMin=r.dateMin||"",e.dateMax=r.dateMax||"",e.dateFormatter={},e.numeral=!!r.numeral,e.numeralIntegerScale=r.numeralIntegerScale>0?r.numeralIntegerScale:0,e.numeralDecimalScale=r.numeralDecimalScale>=0?r.numeralDecimalScale:2,e.numeralDecimalMark=r.numeralDecimalMark||".",e.numeralThousandsGroupStyle=r.numeralThousandsGroupStyle||"thousand",e.numeralPositiveOnly=!!r.numeralPositiveOnly,e.stripLeadingZeroes=r.stripLeadingZeroes!==!1,e.signBeforePrefix=!!r.signBeforePrefix,e.tailPrefix=!!r.tailPrefix,e.swapHiddenInput=!!r.swapHiddenInput,e.numericOnly=e.creditCard||e.date||!!r.numericOnly,e.uppercase=!!r.uppercase,e.lowercase=!!r.lowercase,e.prefix=e.creditCard||e.date?"":r.prefix||"",e.noImmediatePrefix=!!r.noImmediatePrefix,e.prefixLength=e.prefix.length,e.rawValueTrimPrefix=!!r.rawValueTrimPrefix,e.copyDelimiter=!!r.copyDelimiter,e.initValue=void 0!==r.initValue&&null!==r.initValue?r.initValue.toString():"",e.delimiter=r.delimiter||""===r.delimiter?r.delimiter:r.date?"/":r.time?":":r.numeral?",":(r.phone," "),e.delimiterLength=e.delimiter.length,e.delimiterLazyShow=!!r.delimiterLazyShow,e.delimiters=r.delimiters||[],e.blocks=r.blocks||[],e.blocksLength=e.blocks.length,e.root="object"==typeof t&&t?t:window,e.document=r.document||e.root.document,e.maxLength=0,e.backspace=!1,e.result="",e.onValueChanged=r.onValueChanged||function(){},e}};e.exports=r}).call(t,function(){return this}())}])});
						</script>
							<!-- <form role="form" action="<?=DOMINIO?>index/pay" method="POST"> -->
							<form name="formulario_" id="formulario_" method="POST" action="<?=DOMINIO?>index/vindi_flow">
								<input type="hidden"  id="brand_" name="brand_">
								<input type="hidden"  name="vindi_key" value="<?=$forma_pagamento->vindi_key?>">

								<input type="hidden"  name="is_brasil" value="<?=$data_dados->is_brasil?>">
								<input type="hidden"  name="is_brasil_address" value="<?=$data_dados->is_brasil_address?>">
								
								<input type="hidden"  name="vindi_url" value="<?=$forma_pagamento->vindi_url?>">
								<input type="hidden" name="forma_pagamento" value="<?=$forma_pagamento->id?>">
								<input type="hidden" name="codigo" value="<?=$data_pedido->codigo?>">
								<input type="hidden" name="amount_" value="<?=$data_pedido->valor_total?>">
								
								
								<div class="row">
									<div class="col-xs-12">
										<div class="div_form" >
											<label>País</label><br>
											<input type="radio" id="Brasil_doc" name="country_document" <?= $data_dados->is_brasil == 1 ? 'checked':'' ?>  value="1">
											<label for="Brasil">Brasil </label>
											<input type="radio" id="Outros_doc" name="country_document" <?= $data_dados->is_brasil == 0 ? 'checked':'' ?>  value="0">
											<label for="Outros">Outros</label><br>
										</div>
									</div>
								</div>
								<br>	
								<div class="row">
									<div class="col-xs-8 col-md-8">
										<div class="form-group">
											<label for="cardNumber">Nome Completo</label>
											<input type="text" class="form-control" name="nomeCompleto" placeholder="Nome Completo" autocomplete="Nome completo" value="<?=$nome_cli?>" required/>
										</div>                            
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="nascimento">Data de Nascimento</label>
											<input type="date" class="form-control" name="nascimento" placeholder="Data de Nascimento" autocomplete="Data de Nascimento" value="<?=$fisica_nascimento?>" required/>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="email">E-mail</label>
											<input type="email" class="form-control" name="email" placeholder="E-mail" autocomplete="Email" value="<?=$email?>" required/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="tel">Telefone</label>
											<input type="text" class="form-control" name="telefone" id="telefone" maxlength="15" placeholder="Telefone" autocomplete="Telefone" value="<?=$telefone?>" required/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">												
												<label for="tel" id="label_cpf"><?= $data_dados->is_brasil == 1 ? 'CPF':'Documento' ?></label>
												<input type="text" style="<?= $data_dados->is_brasil == 1 ? '':'display: none' ?>" class="form-control" name="cpf" id="cpf"  placeholder="CPF" value="<?=$cpf?>" required/>
												<input type="text" style="<?= $data_dados->is_brasil == 0 ? '':'display: none' ?>" class="form-control" name="cpf_outros" id="documento_cpf"  placeholder="Documento" value="<?=$cpf?>" required/>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-12">
										<div class="div_form" >
											<label>País</label><br>
											<input type="radio" id="Brasil_end" name="country_endereco" <?= $data_dados->is_brasil_address == 1 ? 'checked':'' ?> value="1">
											<label for="Brasil">Brasil </label>
											<input type="radio" id="Outros_end" name="country_endereco" <?= $data_dados->is_brasil_address == 0 ? 'checked':'' ?> value="0">
											<label for="Outros">Outros</label><br>
										</div>
									</div>
								</div>
								<br>				
								<div class="endereco_brasil" style="<?= $data_dados->is_brasil_address == 1 ? '':'display: none' ?>">
									<div class="row">
										<div class="col-xs-10">
											<div class="form-group">
												<label for="cardNumber">Endereço</label>
												<input type="text" class="form-control" name="endereco" placeholder="Endereco" autocomplete="endereco" value="<?=$endereco?>" required/>
											</div>                            
										</div>
										<div class="col-xs-2">
											<div class="form-group">
												<label for="cardNumber">Número</label>
												<input type="text" class="form-control" name="numero" placeholder="Número" autocomplete="Número" value="<?=$numero?>" required/>
											</div>                            
										</div>
									</div>
									<div class="row">
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="bairro">Bairro</label>
												<input type="text" class="form-control" name="bairro" placeholder="Bairro" autocomplete="Bairro" value="<?=$bairro?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cep">CEP</label>
												<input type="text" class="form-control cep" name="cep" id="cep" placeholder="00000-000" value="<?=$cep?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Estado</label>
												<select id="estado" class="form-control" name="estado">
													<?php
														foreach ($estados as $key => $value) {
															if($value['selected']){ $select = "selected"; } else { $select = ""; }
															echo "<option value='".$value['uf']."' $select >".$value['nome']."</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Cidade</label>
												<div class="div_form" id="cadastro_cidade_div">
													<select id="cidade" name="cidade" class="form-control select2 cadastro_form" >
														<option value=''>Selecione a Cidade</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>


								
			
								<div class="endereco_outros" style="<?= $data_dados->is_brasil_address == 0 ? '':'display: none' ?>">
									<div class="row">
										<div class="col-xs-10">
											<div class="form-group">
												<label for="cardNumber">Endereço</label>
												<input type="text" class="form-control" name="endereco_outros" placeholder="Endereco" autocomplete="endereco" value="<?=$endereco?>" required/>
											</div>                            
										</div>
										<div class="col-xs-2">
											<div class="form-group">
												<label for="cardNumber">Número</label>
												<input type="text" class="form-control" name="numero_outros" placeholder="Número" autocomplete="Número" value="<?=$numero?>" required/>
											</div>                            
										</div>
									</div>
									<div class="row">
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="bairro">Bairro</label>
												<input type="text" class="form-control" name="bairro_outros" placeholder="Bairro" autocomplete="Bairro" value="<?=$bairro?>" />
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cep">CEP</label>
												<input type="text" class="form-control cep_outros" name="cep_outros" id="cep_outros" value="<?=$cep?>" required/>
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Estado</label>
												<input type="text" class="form-control estado_outros" name="estado_outros" id="estado_outros" value="<?=$estado?>" />
											</div>
										</div>
										<div class="col-xs-3 col-md-3">
											<div class="form-group">
												<label for="cidade">Cidade</label>
												<input type="text" class="form-control cidade_outros" name="cidade_outros" id="cidade_outros" value="<?=$cidade?>" />
											</div>
										</div>
									</div>
								</div>





								<hr>
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="cardNumber">Nº Cartão</label>
											<div class="input-group">
												<input type="tel" class="form-control" name="cardNumber" pattern=".{17,19}" placeholder="Valid Card Number" id="input-cc" autocomplete="cc-number" required autofocus value=""/>
												<span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
											</div>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<div class="form-group">
											<label for="cardExpiry">Validade</label>
											<input type="tel" class="form-control"  data-mask="00/0000" name="cardExpiry" placeholder="MM/YYYY" autocomplete="cc-exp" required />
										</div>
									</div>
									<div class="col-xs-6 col-md-6">
										<div class="form-group">
											<label for="cardCVC">CVV</label>
											<input type="tel" class="form-control" data-mask="000" name="cardCVC" placeholder="CVV" autocomplete="cc-csc" required value="123"/>
										</div>
									</div>
									<div class="col-xs-2">
										<div class="form-group">
											<!-- <label for="installments">Recorrencia</label>
												<select name="recorrencia" class="form-control">
													<option selected value="0">0</option>
													<option value="1">Mensal</option>
												</select> -->
												<input type="hidden" name="carrinho_coisas[]" value=<?$produtos['lista']?>>
												<input type="hidden" name="installmentValue">
										</div>                            
									</div>
								</div>
								<br><br>
								<div class="row">
									<div class="col-xs-12">
										<button id="btn_pagar_bill" class="btn btn-success btn-lg btn-block" type="submit">Pagar</button>
									</div>
								</div>
								<?php
									// foreach ($produtos['lista'] as $key => $value) {
									// 	echo $value['titulo'].$value['quantidade'].$value['id_produto'];

									// 	$n++;
									// }
								?>
							</form>
							<br><br>
							<script>
								var cc_type = 'unknown';
								var cleave = new Cleave('#input-cc', {
									creditCard: true,
									delimiter: '-',
									onCreditCardTypeChanged: function (type) {
										console.log(type);
										$("#brand_").val(type);
									}
								});
							</script>
					<?php } ?>
					
					<!-- ////////////////////////////  CIELO   ///////////////////////////  -->
					<?php if( ($forma_pagamento->id == 6) AND ($data_pedido->status <= 3) ){ $sessionCode = 0;?>
						
						
							<!-- <form role="form" action="<?=DOMINIO?>index/pay" method="POST"> -->
							<form name="formulario" id="formulario" method="POST" action="<?=DOMINIO?>index/pay">
								<input type="text" name="brand">
								<input type="text" name="token">
								<input type="text" name="forma_pagamento" value="<?=$forma_pagamento->id?>">
								<input type="text" name="senderHash">
								<input type="text" name="id_transacao" value="<?=$data_pedido->id_transacao?>">
								<input type="text" name="amount" value="<?=$data_pedido->valor_total?>">
								<input type="text" name="shippingCoast" value="0">
								<div class="row">
									<div class="col-xs-8 col-md-8">
										<div class="form-group">
											<label for="cardNumber">Nome Completo</label>
											<input type="text" class="form-control" name="nomeCompleto" placeholder="Nome Completo" autocomplete="Nome completo" value="<?=$nome_cli?>" required/>
										</div>                            
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="nascimento">Data de Nascimento</label>
											<input type="date" class="form-control" name="nascimento" placeholder="Data de Nascimento" autocomplete="Data de Nascimento" value="<?=$fisica_nascimento?>" required/>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="email">E-mail</label>
											<input type="email" class="form-control" name="email" placeholder="E-mail" autocomplete="Email" value="<?=$email?>" required/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="tel">Telefone</label>
											<input type="text" class="form-control" name="telefone" id="telefone" maxlength="15" placeholder="Telefone" autocomplete="Telefone" value="<?=$telefone?>" required/>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form-group">
											<label for="tel">CPF</label>
											<input type="text" class="form-control" name="cpf" id="cpf"  placeholder="CPF" value="<?=$cpf?>" required/>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-10">
										<div class="form-group">
											<label for="cardNumber">Endereço</label>
											<input type="text" class="form-control" name="endereco" placeholder="Endereco" autocomplete="endereco" value="<?=$endereco?>" required/>
										</div>                            
									</div>
									<div class="col-xs-2">
										<div class="form-group">
											<label for="cardNumber">Número</label>
											<input type="text" class="form-control" name="numero" placeholder="Número" autocomplete="Número" value="<?=$numero?>" required/>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-3 col-md-3">
										<div class="form-group">
											<label for="bairro">Bairro</label>
											<input type="text" class="form-control" name="bairro" placeholder="Bairro" autocomplete="Bairro" value="<?=$bairro?>" required/>
										</div>
									</div>
									<div class="col-xs-3 col-md-3">
										<div class="form-group">
											<label for="cep">CEP</label>
											<input type="text" class="form-control cep" name="cep" id="cep" placeholder="00000-000" value="<?=$cep?>" required/>
										</div>
									</div>
									<div class="col-xs-3 col-md-3">
										<div class="form-group">
											<label for="cidade">Estado</label>
											<select id="estado" class="form-control" name="estado">
												<?php
													foreach ($estados as $key => $value) {
														if($value['selected']){ $select = "selected"; } else { $select = ""; }
														echo "<option value='".$value['uf']."' $select >".$value['nome']."</option>";
													}
												?>
											</select>
										</div>
									</div>
									<div class="col-xs-3 col-md-3">
										<div class="form-group">
											<label for="cidade">Cidade</label>
											<select id="cidade" class="form-control" name="cidade">
												<option value="AC">Acre</option>
												<option value="AL">Alagoas</option>
												<option value="AP">Amapá</option>
												<option value="AM">Amazonas</option>
												<option value="BA">Bahia</option>
												<option value="CE">Ceará</option>
												<option value="DF">Distrito Federal</option>
												<option value="ES">Espírito Santo</option>
												<option value="GO">Goiás</option>
												<option value="MA">Maranhão</option>
												<option value="MT">Mato Grosso</option>
												<option value="MS">Mato Grosso do Sul</option>
												<option value="MG">Minas Gerais</option>
												<option value="PA">Pará</option>
												<option value="PB">Paraíba</option>
												<option value="PR">Paraná</option>
												<option value="PE">Pernambuco</option>
												<option value="PI">Piauí</option>
												<option value="RJ">Rio de Janeiro</option>
												<option value="RN">Rio Grande do Norte</option>
												<option value="RS">Rio Grande do Sul</option>
												<option value="RO">Rondônia</option>
												<option value="RR">Roraima</option>
												<option value="SC">Santa Catarina</option>
												<option value="SP">São Paulo</option>
												<option value="SE">Sergipe</option>
												<option value="TO">Tocantins</option>
												<option value="EX">Estrangeiro</option>
											</select>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="cardNumber">Nº Cartão</label>
											<div class="input-group">
												<input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus value="4111 1111 1111 1111"/>
												<span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
											</div>
										</div>                            
									</div>
								</div>
								<div class="row">
									<div class="col-xs-7 col-md-5">
										<div class="form-group">
											<label for="cardExpiry">Validade</label>
											<input type="tel" class="form-control" id="validade_cartao" name="cardExpiry" placeholder="MM/YYYY" autocomplete="cc-exp" required />
										</div>
									</div>
									<div class="col-xs-5 col-md-5">
										<div class="form-group">
											<label for="cardCVC">CVV</label>
											<input type="tel" class="form-control" name="cardCVC" placeholder="CVV" autocomplete="cc-csc" required value="CVV"/>
										</div>
									</div>
									<div class="col-xs-2">
										<div class="form-group">
											<label for="installments">Parcelas</label>
												<select name="installments" id="select-installments" name="parcelas" class="form-control">
													<option selected>1</option>
												</select>
												<input type="hidden" name="installmentValue">
										</div>                            
									</div>
								</div>
								<br><br>
								<div class="row">
									<div class="col-xs-12">
										<button class="btn btn-success btn-lg btn-block" type="submit">Pagar</button>
									</div>
								</div>
							</form>
							<br><br>
						
						<!-- <div style="font-size: 12px; margin-top: 10px;">Clique abaixo para efetuar o pagamento (caso já tenha efetuado o pagamento aguarde a compensação).</div>

						<div style="margin-top:20px; width: 70%; text-align: left;" >
							<a href="<?=$data_pedido->link_cielo?>" target="_blank"><img src="<?=LAYOUT?>img/cielo.jpg" style="width: 100px;"></a>
						</div> -->

					<?php } ?>
					<div style="width: 100%; padding-top: 50px;"></div>
				</div>
			</div>
			</div>
				<div class="container new_cont" style="margin-top:30px">
			<div class="row">
				<div class="col-sm-12">
					<h4>Detalhe da compra</h4> <br>								
					<div class="table-responsive" style="min-height: 250px; margin-top:10px;">
						<table class="table tabela_pedidos">

							<thead>
								<tr>
									<th>Produto</th>
									<th></th>
									<th style='text-align:center;' >Preço</th>
									<th style='text-align:center; width:50px;' >Quantidade</th>
									<th style='text-align:center; width:120px;' >Total</th>
								</tr>
							</thead>

							<?php
							// echo '<pre>'; print_r($produtos);exit;
							$n = 0;
							foreach ($produtos['lista'] as $key => $valu) {
								$subtotal_ = 0;

								foreach ($valu as $key1 => $value) {
									if($value['usar_valor_vindi'] == 1){
										$valor_unitario = '-';
										$total_geral = '-';
										$subtotal_ = $value['combo_valor'];
										
									}else{
										$valor_unitario = "R$ ".$value['total_unitario'];
										$total_geral = "R$ ".$value['total_quantidade'];

										$resultado = str_replace('.', '', $value['total_unitario']); // remove o ponto
										$resultado = str_replace(',', '.', $resultado); // substitui a vírgula por ponto
										$subtotal_ = ($subtotal_ + floatval($resultado));
									}

									if($key1==0){
										if($value['combo_titulo']){
											echo "
												<tr>
													<td colspan='5' style='border-bottom: 1px white solid;'>
														".$value['combo_titulo']."
													</td>
												</tr>
											";
										}
										else{
											echo "
												<tr>
													<td colspan='5' style='border-bottom: 1px white solid;'>
														Trilha avulsa
													</td>
												</tr>
											";
										}
									}
									
									echo "
									<tr>

									<td colspan='2' >
									<div class='carrinho_lista_imagem' style='background-image:url(".$value['imagem'].");' ></div>
									<div class='carrinho_lista_texto' ><div style='padding-left:15px; padding-right:15px;'>".$value['titulo']."</div></div>
									</td>

									<td style='text-align:center;' >
									<div class='carrinho_lista_valor' >".$valor_unitario."</div>
									</td>

									<td style='text-align:center;' >
									<div class='carrinho_lista_valor' >
									".$value['quantidade']."
									</div>
									</td>

									<td style='text-align:center; ' >
									<div class='carrinho_lista_valor' >".$total_geral."</div>
									</td>                                    

									</tr>
									";

									$n++;
								}
								echo "
									<tr>
									<td colspan='4' style='text-align:right; ' >Sub-total</td>
									<td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".number_format($subtotal_,2)."</td> 
									</tr>
								";
							}



							if($n != 0){
								echo "
									<tr>
										<td colspan='4' style='text-align:right; ' >Total do Pedido</td>
										<td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$valor_total_pedido_tratado."</td>
									</tr>
								"; 
								// echo "
								// <tr>
								// <td colspan='4' style='text-align:right; ' >Sub-total</td>
								// <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$produtos['subtotal_tratado']."</td>                           
								// </tr>

								// <tr>
								// <td colspan='4' style='text-align:right; ' >Total de Descontos</td>
								// <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$valor_desconto_cupom_tratado."</td>
								// </tr>

								// <tr>
								// <td colspan='4' style='text-align:right; ' >Total de Frete</td>
								// <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$valor_frete_tratado."</td>
								// </tr>

								// <tr>
								// <td colspan='4' style='text-align:right; ' >Total do Pedido</td>
								// <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$valor_total_pedido_tratado."</td>
								// </tr>
								// "; 


							} else {

								echo "
								<tr>
								<td colspan='5' style='text-align:center; padding-top:120px; padding-bottom:120px; font-size:20px;' >Não encontramos produtos neste pedido!</td>
								</tr>
								";

							}

							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php

	// rodape
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
				if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-6 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-8 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-5 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-3 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna2'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-4 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna3'];
					if($conteudo_coluna['tipo'] == 'rodape'){

						$conteudo_id = $conteudo_coluna['id'];
						$conteudo_sessao = $conteudo_coluna['conteudo'];
						include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

					}

					?>
				</div>
				<div class="col-md-2 corrige_cedulas_principais">
					<?php

					$conteudo_coluna = $value_layout['coluna4'];
					if($conteudo_coluna['tipo'] == 'rodape'){

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
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna2'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna3'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna4'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna5'];
				if($conteudo_coluna['tipo'] == 'rodape'){

					$conteudo_id = $conteudo_coluna['id'];
					$conteudo_sessao = $conteudo_coluna['conteudo'];
					include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';

				}

				?>
			</div>              
			<div class="col-md-2 corrige_cedulas_principais">
				<?php

				$conteudo_coluna = $value_layout['coluna6'];
				if($conteudo_coluna['tipo'] == 'rodape'){

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

	// termina rodape
	?>

	<script type="text/javascript" src="<?=LAYOUT?>js/jquery-2.2.4.min.js" ></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?=LAYOUT?>js/jquery-ui.min.js"></script>  
	<script type="text/javascript" >function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script type="text/javascript" src="<?=LAYOUT?>js/funcoes.js"></script>
	<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="<?=LAYOUT?>js/animation.js"></script>
	<script type="text/javascript" src="<?=LAYOUT?>js/responsiveslides.min.js"></script>
	<script type="text/javascript" src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script type="text/javascript" src="<?=STC_URL_PAGSEGURO?>pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
	<script type="text/javascript" src="<?=LAYOUT?>js/cpf.js"></script>
	<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
  	<script type="text/javascript" src="http://code.jquery.com/qunit/qunit-1.11.0.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	<!-- <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script> -->
	


<script type="text/javascript">
/* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){
	id('telefone').onkeypress = function(){
		mascara( this, mtel );
	}
}
</script>
<script>
	// label_cpf

		$("#Brasil_doc").click(function(){
			$("#label_cpf").html('CPF');
			$("#cpf").show();
			$("#documento_cpf").hide();
		});
		$("#Outros_doc").click(function(){
			$("#label_cpf").html('Document');
			$("#cpf").hide();
			$("#documento_cpf").show();
		});

		$("#Brasil_end").click(function(){
			$(".endereco_brasil").show();
			$(".endereco_outros").hide();
		});
		$("#Outros_end").click(function(){
			$(".endereco_brasil").hide();
			$(".endereco_outros").show();
		});
	$('#formulario_').submit(function(){

		$(this).find(':input[type=submit]').html('enviando...').prop('disabled', true);
	});
	function cadastro_cidades(estado, cidade = null){
		
		$('#cadastro_cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:250px;' ></div>");

		$.post('<?=DOMINIO?><?=$controller?>/cidades', {estado: estado, cidade: cidade},function(data){
			if(data){
				$('#cadastro_cidade_div').html(data);
			}
		});
		
	}
	<?php if($data_dados->estado){ ?>
		cadastro_cidades('<?=$data_dados->estado?>', '<?=$data_dados->cidade?>');
	<?php } else { ?>
		cadastro_cidades('AC');
	<?php } ?>

	var installments = [];

	$("input[name='cardNumber']").keyup(function(){
		getInstallments();
	});

	$("#select-installments").change(function(){
		console.log(installments[$(this).val()-1]);
		$("input[name='installmentValue']").val(installments[$(this).val()-1].installmentAmount);
	});

	function getInstallments(){
		
		var cardNumber = $("input[name='cardNumber']").val();
		
		//if creditcard number is finished, get installments
		if(cardNumber.length != 19){
			return;
		} 

		PagSeguroDirectPayment.getBrand({
			cardBin: cardNumber.replace(/ /g,''),
			success: function(json){
				console.log(json);
				var brand = json.brand.name;
				$("input[name='brand']").val(brand);
				
				var amount = parseFloat($("input[name='amount']").val());
				var shippingCoast = parseFloat($("input[name='shippingCoast']").val());
				
				//The maximum installment qty with no extra fees (You must configure it on your PagSeguro dashboard with same value)
				var max_installment_no_extra_fees = 2;

				PagSeguroDirectPayment.getInstallments({
					amount: amount + shippingCoast,
					brand: brand,
					maxInstallmentNoInterest: max_installment_no_extra_fees,
					success: function(response) {
						
						/*
							Available installments options.
							Here you have quantity and value options
						*/
						console.log(response);
						installments = response.installments[brand];
						$("#select-installments").html("");
						for(var installment of installments){
							$("#select-installments").append("<option value='" + installment.quantity + "'>" + installment.quantity + " x R$ " + installment.installmentAmount + " - " + (installment.quantity <= max_installment_no_extra_fees? "Sem" : "Com")  + " Juros</option>");
						}

					}, error: function(response) {
						console.log(response);
					}, complete: function(response) {
						//Called after sucess or error
					} 
				});
			}, error: function(json){
				console.log(json);
			}, complete: function(json){
				console.log(json);
			}
		});
	}
		
	$(".pagar_btn").click(function(){
		var param = {
			cardNumber: $("input[name='cardNumber']").val().replace(/ /g,''),
			brand: $("input[name='brand']").val(),
			cvv: $("input[name='cardCVC']").val(),
			expirationMonth: $("input[name='cardExpiry']").val().split('/')[0],
			expirationYear: $("input[name='cardExpiry']").val().split('/')[1],
			success: function(json){
				var token = json.card.token;
				$("input[name='token']").val(token);
				console.log("Token: " + token);

				var senderHash = PagSeguroDirectPayment.getSenderHash();
				$("input[name='senderHash']").val(senderHash);
				$("form").submit();
			}, error: function(json){
				console.log(json);
			}, complete:function(json){
			}
		}

		PagSeguroDirectPayment.createCardToken(param);
	});

	jQuery(function($) {

		var shippingCoast = parseFloat($("input[name='shippingCoast']").val());
		var amount = parseFloat($("input[name='amount']").val());
		$("input[name='installmentValue']").val(amount + shippingCoast);

		PagSeguroDirectPayment.setSessionId('<?php echo $sessionCode;?>');

			PagSeguroDirectPayment.getPaymentMethods({
				success: function(json){

					console.log(json);
					getInstallments();

				}, error: function(json){
					console.log(json);
					var erro = "";
					for(i in json.errors){
						erro = erro + json.errors[i];
					}
					
					// alert(erro);
				}, complete: function(json){
				}
			});
		});

    </script>
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

	<script>

		function confirma_cancelamento(endereco) {
			if(confirm('Tem certeza que deseja cancelar o pedido?')){
				window.location=endereco;
			} else {
				return false;
			}
		}

		// abrir janela pagseguro $('#comprar_pagseguro').submit();

		// copia chave		
		function copiachave(){			
			const inputTest = document.querySelector("#chavepix");
			inputTest.select();
			document.execCommand('copy');
		}
	$(document).ready(function(){
		$("#cpf").mask("999.999.999-99");
		// $(".cep").mask("99999-999");
	});
	</script>

</body>
</html>