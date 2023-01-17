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

$url = $_GET['url'];
// $usuario_cpf = $_SESSION['usuario_cpf'];
print_r($_SESSION);
// $dados['_nome_usuario'] = $this->_nome_usuario;
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
			/* background-image: url(<?=$fundo_topo?>) !important; */
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
	<style type="text/css">
		a.botao_padrao{
		background-color: <?=$primaria?> !important;
		}
		/* .botao_padrao:hover {
			background-color: <?=$primaria?> !important;
			color: #fff !important;
		} */
		.botao_padrao{
			background-color: <?=$primaria?> !important;
			border: none;
    		color: white;
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
		.estrela_amarela {
			color: <?=$secundaria?>;
		}
		.item button:hover, .cart:hover {
			background: <?=$secundaria?> !important;
		}
		@media (max-width: 770px){
			.logo_div {
				margin: 0 auto;
			}
			.li_loja a {
				padding: 10px 10px !important;
			}
			#header{
				position: relative !important;
			}
			.margemtopo{
				display: none !important;
			}
		}
		a.logo {
			display: inline-block;
			width: 100%;
			margin: 0px;
			margin-bottom: 15px;
		}
		.ul_loja {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
		}
		.li_loja {
			float: left;
			padding-bottom: 0px;
		}
		.li_loja a {
			display: block;
			color: #344456;
			text-align: center;
			padding: 30px 18px;
			text-decoration: none;
		}
		.li_loja a:hover {
			background-color: <?=$primaria?>;
			color:white;
		}
		a.logo {
			display: inline-block;
			width: 100%;
			margin: 0px;
			margin-top: 8px;
			margin-bottom: 0px;
		}
		/* .logo_div {
			width: 100%;
			padding: 10px 0px;
		} */
		.busca_div, .div_botoes_topo{
			padding: 10px 0px;margin-top: 10px;margin-bottom: -1px;
		}
		.span_btn{padding: 5px 10px 5px 10px; border-radius: 5px;border: 1px #2c3e4f solid;}
		.span_btn_cad{padding: 5px 10px 5px 10px;border-radius: 5px;border: 1px <?=$primaria?> solid;background: <?=$primaria?>;color: white !important;}
		.busca_input {
			border-top: none;
			border-left: none;
			border-bottom: none;
			border-right: none;
			height: 25px;
			border-radius: 0px;
			color: #575757 !important;
			font-size: 14px;
			width: 300px;
			padding: 10px;
			box-shadow: none;
			background-color: #cccccc !important;
		}
		.busca_botao {
			background-color: #f8f8f8 !important;
			border-top: none;
			border-right: none;
			border-bottom: none;
			height: 32px;
			width: 0px;
			border-radius: none;
			background-repeat: no-repeat;
			background-position: center;
			color: #575757 !important;
			font-size: 14px;
		}
		.busca_div {
    		padding: 20px 0px !important;
		}
		.selected_orange{background: <?=$primaria?>;color: white !important;}
		.selected_orange_text{color: white !important;}

		@media (max-width: 770px){
			.desk_menu{display:none !important}
			.mobile_menu{display:block !important}
			.container-fluid>.navbar-collapse {margin-left: 0;}
		}
		@media (min-width: 771px){
			.mobile_menu{display:none !important}
			.desk_menu{display:block !important}
		}
		@media (min-width: 1369px){
			.logo_div {
				width: 60%;
				padding: 10px 0px;
			}
		}
		@media (min-width: 1101px) and (max-width: 1368px){
			.logo_div {
				width: 90%;
				padding: 10px 0px;
			}
		}
		@media (max-width: 1100px){
			.logo_div {
				width: 80%;
				padding: 10px 0px;
			}
			.logo_div_desk {
				width: 100% !important;
				padding: 15px 0px !important;
			}
		}
		.mobile_menu{margin: 0 !important;padding: 0 !important;}
		.logo_mobile_{float: left;max-width: 140px;margin-left: 5px;}
		.navbar-default {border: none !important;margin-top: 15px !important;margin-bottom: -5px !important;}
		.navbar-collapse.collapse {padding-top: 0px !important;border: none !important;}
		.navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:focus, .navbar-default .navbar-nav>.active>a:hover {
			color: white;
			background-color: <?=$primaria?>;
		}
		.container-fluid {padding-right: 0;}
		.rodape_contatos span {line-height: 20px;}
		.dropdown-menu li a:hover, .dropdown-menu li a:focus {
    		background-color: <?=$primaria?> !important;
		}
	</style>
	<header id="header">
		<div class="topo6">
			<div id="topo" class="header-middle">
				<div class="container desk_menu">
					<div class="row">
						<div class="col-xs-12 col-sm-2 col-md-2">
							<div class="logo_div logo_div_desk">
								<a href="<?=DOMINIO?>" class="logo" ><img src="<?=$logo_topo?>" ></a>
							</div>
						</div>
						<?php if($_nome_usuario == 'Visitante'){ ?>
							<div class="col-xs-12 col-sm-6 col-md-6">
						<?php }else {?>
							<div class="col-xs-12 col-sm-8 col-md-8">
						<?php }?>
							<ul class="ul_loja">
								<li class="li_loja <?=($url == '' ? 'selected_orange' : '')?>"><a <?=($url == '' ? 'class="selected_orange_text"' : '')?> href="<?=DOMINIO?>">Home</a></li>
								<li class="li_loja <?=($url == 'index/canal' ? 'selected_orange' : '')?>"><a <?=($url == 'index/canal' ? 'class="selected_orange_text"' : '')?> href="<?=DOMINIO.$controller?>/canal">Canais</a></li>
							</ul>
						</div>
						<?php if($_nome_usuario == 'Visitante'){ ?>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="div_botoes_topo">
										<a class="botao_conta_topo" href="<?=DOMINIO?>index/carrinho">
											<i class="fas fa-shopping-cart"></i>
										</a>
										<a class="botao_conta_topo" href="<?=DOMINIO?>index/entrar">
											<span class="span_btn">Fazer login</span>
										</a>
										<a class="botao_conta_topo" href="<?=DOMINIO?>index/cadastro_basico">
											<span class="span_btn_cad" style="color: white !important;">Cadastre-se</span>
										</a>
									<div style="clear: both;"></div>
								</div>
							</div>
							<?php }else{ ?>
								<div class="col-xs-2 col-sm-2 col-md-2" style="margin-top: 25px;">
									<div class="dropdown" style="float:left">
										<button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><?=$_nome_usuario?>
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="<?=DOMINIO?><?=$controller?>/minhaconta">Minha conta</a></li>
											<li><a href="<?=DOMINIO?><?=$controller?>/alterar_cadastro">Alterar cadastro</a></li>
											<li><a href="" id="meus_cursos">Meus Cursos</a></li>
											<li><a href="<?=DOMINIO?><?=$controller?>/logout">Sair</a></li>
										</ul>
									</div>
									<a class="botao_conta_topo" href="<?=DOMINIO?>index/carrinho">
										<i class="fas fa-shopping-cart"></i>
									</a>
									<div style="clear: both;"></div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="container mobile_menu">
					<nav class="navbar navbar-default">
						<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								</button>
								<!-- <a class="navbar-brand" href="#">Project name</a> -->
								<a href="<?=DOMINIO?>" class="logo_mobile_" ><img src="<?=$logo_topo?>" ></a>
							</div>
							<div id="navbar" class="navbar-collapse collapse">
								<ul class="nav navbar-nav">
									<li class="<?=($url == '' ? 'active' : '')?>"><a href="<?=DOMINIO?>">Home</a></li>
									<li class="<?=($url == 'index/canal' ? 'active' : '')?>"><a href="<?=DOMINIO.$controller?>/canal">Canais</a></li>
								</ul>
								<?php if($_nome_usuario == 'Visitante'){ ?>
									<ul class="nav navbar-nav navbar-right">
										<li class=""><a href="<?=DOMINIO?>index/carrinho"><i class="fas fa-shopping-cart"></i></li>
										<li><a href="<?=DOMINIO?>index/entrar"><span class="span_btn">Fazer login</span></a></li>
										<li><a href="<?=DOMINIO?>index/cadastro_basico"><span class="span_btn_cad" style="color: white !important;">Cadastre-se</span></a></li>
									</ul>
								<?php }else{ ?>
									<div class="dropdown">
										<button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><?=$_nome_usuario?>
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="<?=DOMINIO?><?=$controller?>/minhaconta">Minha conta</a></li>
											<li><a href="<?=DOMINIO?><?=$controller?>/alterar_cadastro">Alterar cadastro</a></li>
											<li><a href="" id="meus_cursos">Meus Cursos</a></li>
											<li><a href="<?=DOMINIO?><?=$controller?>/logout">Sair</a></li>
										</ul>
									</div>
									<div style="clear: both;"></div>
									<br><br>
								<?php } ?>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<section class="margemtopo"></section>
