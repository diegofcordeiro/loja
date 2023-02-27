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
// echo'<pre>';print_r($_SESSION['seso_167397569296876']['usuario_cpf']);
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
		
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="#">Fixed navbar</a>
			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-collapse collapse" id="navbarCollapse" style="">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
				</li>
				<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
				</li>
			</ul>
			<form class="form-inline mt-2 mt-md-0">
				<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
			</div>
		</nav>
	</header>
	<section class="margemtopo"></section>
