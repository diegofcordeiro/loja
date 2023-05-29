<?php if (!isset($_base['libera_views'])) {
	header("HTTP/1.0 404 Not Found");
	exit;
} ?>

<?php
// carrega fontes google

foreach ($_base['fontes_utilizadas'] as $key => $value) {
	if ($value['tipo'] == 'css') {
		echo $value['endereco'];
	}
}

?>
<style type="text/css">
	<?php
	// carrega fontes de arquivo

	foreach ($_base['fontes_utilizadas'] as $key => $value) {
		if ($value['tipo'] == 'arquivo') {
			echo "		
			@font-face {
				font-family: " . $value['family'] . ";
				src: url('" . DOMINIO . "arquivos/fontes/" . $value['arquivo'] . "');
				font-style: normal;
			}
			";
		}
	}

	?>body {
		background-color: <?= $pagina_cores[1] ?>;
	}

	.botao_padrao_div {
		text-align: left;
		margin-top: 5px;
	}

	.botao_padrao {
		display: inline-block;
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 7px;
		padding-bottom: 7px;
	}

	.botao_padrao:hover {}

	a.botao_padrao {
		display: inline-block;
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 7px;
		padding-bottom: 7px;
	}

	a.botao_padrao:hover {}

	a.botao_padrao_a {
		display: inline-block;
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 7px;
		padding-bottom: 7px;
	}

	a.botao_padrao_a:hover {}



	.margemtopo_interno {
		position: relative;
		width: 100%;
		height: 0px;
	}

	.titulo_padrao {
		font-size: 28px;
		padding-top: 0px !important;
		width: 100%;
		max-width: 100%;
		text-align: center;
		color: white;
	}

	.titulo_padrao_linha {
		width: 100%;
		margin-bottom: 10px;
		padding-top: 0px;
		margin-top: 50px;
		text-align: center;
		width: 100%;
	}

	.botao_padrao {}

	.botao_padrao p {
		margin: 0px !important;
	}

	.botao_padrao:hover {
		background-color: #2e3092 !important;
		color: #fff !important;
	}

	a.botao_padrao_a {
		display: inline-block;
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 7px;
		padding-bottom: 7px;
	}

	a.botao_padrao_a:hover {
		background-color: #2e3092 !important;
		color: #fff !important;
	}

	.botao_upload {
		border: none;
		padding-top: 4px;
		padding-bottom: 4px;
		padding-left: 15px;
		padding-right: 15px;
		font-size: 13px;
		cursor: pointer;
	}

	.contactinfo ul li a {
		color: #ccc;
	}

	.social-icons ul li a {
		color: #333;
	}


	.shop-menu ul li a {
		background: none;
		color: #1a1a1a;
	}

	.shop-menu ul li a:hover {
		background: none;
	}


	.shop-menu ul li {
		padding-left: 0px;
	}

	.shop-menu ul li a:hover {
		color: #1a1a1a;
		margin-top: 20px;
	}

	.shop-menu ul li a:hover {
		margin-top: 20px;
		color: #1a1a1a;
	}

	.nomedousuario {
		text-align: right;
		padding-top: 20px;
		font-size: 14px;
		color: #000;
	}

	.botao_busca_blog {
		padding: 10px 14px;
		font-size: 14px !important;
		border: 0px;
		border-radius: 0px;
	}

	.texto_menu_resp {
		display: none;
		position: absolute;
		right: 80px;
		top: 15px;
		font-size: 14px;
		color: #000;
	}

	.category-products .panel-default .panel-heading .panel-title a {
		color: #1a1a1a;
	}

	.add-to-cart {
		width: 100%;
		border-radius: 4px !important;
	}

	.add-to-cart:hover {
		border-radius: 4px !important;
	}

	.indisponivel {}

	.indisponivel:hover {}

	.contactinfo ul li:first-child {
		margin-left: 0px;
	}

	.left-sidebar h2,
	.brands_products h2 {
		color: #000000;
		font-size: 21px;
	}

	.category-products {
		border: 1px solid #ddd;
	}

	.banner_lateral {
		width: 100%;
		text-align: center;
		margin-top: 30px;
	}

	.banners_esquerda_responsivo1 {
		display: block;
	}

	.banners_esquerda_responsivo2 {
		display: none;
	}

	.botao_upload {
		border: none;
		padding-top: 4px;
		padding-bottom: 4px;
		padding-left: 15px;
		padding-right: 15px;
		font-size: 13px;
		cursor: pointer;
	}

	.news_texto {
		text-align: left;
		font-size: 16px;
		font-weight: bold;
		padding-bottom: 15px;
		padding-top: 40px;
	}

	.form_news {
		border-radius: 4px;
		width: 100%;
		height: 40px;
		background-color: #fff;
		border: 0px;
		color: #000;
		padding-left: 20px;
		padding-right: 20px;
		margin-top: 5px;
	}

	.news_botao {
		font-size: 15px;
		border-radius: 0px;
		border: 0px;
		font-weight: bold;
		text-align: center;
		width: 100%;
		height: 40px !important;
		cursor: pointer;
		margin-top: 5px;
	}

	.news_botao:hover {
		background-color: #000000;
		color: #FFF;
	}

	.pull-right a {
		font-weight: normal;
		font-style: normal;
		color: #FFF;
		text-decoration: none;
		font-size: 13px;
	}

	.pull-right a:hover {
		text-decoration: underline;
	}

	a#scrollUp {
		background: #549c13;
		color: #FFF;
	}

	.single-widget h2 {
		padding-top: 5px;
		margin-bottom: 10px;
		color: #FFF;
	}

	.single-widget ul li a:hover {
		color: #000;
	}


	.modal-content {
		border-radius: 0px;
	}

	.busca_input {
		border-radius: 0px;
	}

	#slider {
		padding-top: 0px;
		padding-bottom: 0px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.control-carousel {
		top: 50%;
		margin-top: -40px;
		color: #FFF;
	}

	.control-carousel:hover {
		color: #FFF;
	}

	.carousel-indicators li.active {
		background: #FFF;
	}

	.banner_central {
		width: 100%;
		height: 500px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
	}

	.item {
		padding-left: 0px;
	}

	.produto_detalhes_titulo {
		font-size: 24px;
		color: #000;
		padding-top: 3px;
		padding-bottom: 7px;
		margin-bottom: 25px;
		font-weight: bold;
		border-bottom: 1px solid #ddd;
	}

	.produto_detalhes {
		font-size: 14px;
		color: #666;
		padding-bottom: 5px;
		padding-top: 5px;
		font-weight: normal;
	}

	.produto_detalhes_quant {
		font-size: 15px;
		color: #666;
		padding-top: 5px;
	}

	.produto_detalhes_valor {
		font-size: 35px;
		font-weight: bold;
		color: black;
		padding-bottom: 5px;
		padding-top: 0px;
		margin-top: 0px;
	}

	#similar-product {
		margin-top: 0px;
	}

	.produto_imagem_detalhes {
		display: inline-block;
		width: 100%;
		height: 300px;
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
		cursor: pointer;
	}

	.product-information {
		border: 1px solid #ddd;
		padding-left: 35px;
		padding-top: 20px;
		padding-bottom: 20px;
		padding-right: 35px;
		min-height: 300px;
	}

	.product-information span {
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.cart {
		background: #242415;
		color: #FFF;
		margin: 0px;
	}

	.cart:hover {
		background: #535051;
		color: #FFF;
	}

	.item-control {
		top: 50%;
		margin-top: -10px;
	}

	.item-control i {
		background: #ccc;
		color: #000;
	}

	.item-control i:hover {
		background: #eee;
		color: #333;
	}


	.produtos_detalhes_valortotal {
		font-size: 14px;
		color: #666;
		font-weight: normal;
		margin-top: 15px;
	}

	.produtos_detalhes_margin {
		padding-left: 40px;
	}

	#produto_detalhes_parcelas {
		font-size: 13px;
		color: #666;
		font-weight: normal;
	}

	.tabela_boa thead tr {
		background-color: #292929;
		border: 0px;
	}

	.carrinho_lista_imagem {
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		width: 40%;
		height: 140px;
		float: left;
		margin-top: 10px;
		margin-bottom: 10px;
	}

	.carrinho_lista_texto {
		float: left;
		padding-top: 10px;
		padding-bottom: 10px;
		width: 60%;
		font-size: 18px;
	}

	.carrinho_lista_valor {
		padding-top: 38px;
	}

	.carrinho_lista_remover {
		padding-top: 31px;
		font-size: 20px;
		font-weight: bold;
	}

	.carrinho_quantidade_input {
		width: 50px;
		display: inline-block;
		height: 32px;
		text-align: center;
	}

	.botao_finalizar {
		background: #5a981c;
		color: #FFF;
		border-radius: 10px;
		margin: 0px;
	}

	.botao_finalizar:hover {
		background: #528b19;
		color: #FFF;
		border-radius: 10px;
		margin: 0px;
	}

	.botao_continuar_comprando {
		background: #0067a9;
		color: #FFF;
		margin: 0px;
		border-radius: 10px;
	}

	.botao_continuar_comprando:hover {
		background: #005388;
		color: #FFF;
		margin: 0px;
		border-radius: 10px;
	}


	#contact-page .form-control {
		border-radius: 0px;
	}


	.carrinho_erro {
		text-align: center;
		padding-top: 50px;
		padding-bottom: 50px;
		font-size: 16px;
		color: #333;
		background: white;
	}

	.ajuste_botoes_carrinho_d {
		padding-top: 50px;
		text-align: right;
	}

	.ajuste_botoes_carrinho_e {
		padding-top: 50px;
		text-align: left;
	}

	.meusdados {
		background: #22171B;
		color: #FFF;
		margin: 0px;
	}

	.meusdados:hover {
		background: #626262;
		color: #FFF;
		margin: 0px;
	}

	.bt_alterar_dados {
		position: absolute;
		top: 120px;
		right: 15px;
		text-align: right;
		width: 100%;
		z-index: 99999;
	}

	.tabela_pedidos thead tr {
		background-color: #f2f2f2;
		border: 0px;
	}

	.tabela_pedidos a {
		color: #000;
	}

	.tabela_pedidos a:hover {
		color: #999;
	}

	.pedidostabela {
		padding-bottom: 60px;
		width: 70%;
	}

	.videos_div {
		width: 100%;
		margin-top: 5px;
		margin-bottom: 25px;
	}

	.videos_conteudo {
		width: 100%;
		height: 315px;
		overflow: hidden;
	}

	.videos_titulo {
		padding-top: 0px;
		margin-top: 0px;
		text-align: center;
		font-weight: 16px;
		font-weight: bold;
	}

	.videos_descricao {
		padding-top: 10px;
		font-size: 14px;
		text-align: center;
	}

	.videos_conteudo {
		text-align: center;
		margin-top: 15px;
	}

	a.videos_categorias {
		display: block;
		margin-top: 15px;
		font-size: 16px;
		cursor: pointer;
		font-weight: 500;
	}

	a.videos_categorias_topo {
		display: inline-block;
		margin-top: 10px;
		font-size: 15px;
		cursor: pointer;
		font-weight: 500;
		padding-right: 10px;
		margin-right: 8px;
	}



	.audios_div {
		width: 100%;
		margin-top: 20px;
		margin-bottom: 0px;
	}

	.audios_conteudo {
		width: 100%;
		height: auto;
	}

	.audios_titulo {
		padding-top: 0px;
		margin-top: 0px;
		text-align: center;
		font-weight: 16px;
		font-weight: bold;
	}

	.audios_descricao {
		padding-top: 10px;
		font-size: 14px;
		text-align: center;
	}

	.audios_conteudo {
		text-align: center;
		margin-top: 15px;
	}

	a.audios_categorias {
		display: block;
		margin-top: 15px;
		font-size: 16px;
		cursor: pointer;
		font-weight: 500;
	}

	a.audios_categorias_topo {
		display: inline-block;
		margin-top: 10px;
		font-size: 15px;
		cursor: pointer;
		font-weight: 500;
		padding-right: 10px;
		margin-right: 8px;
	}



	.redessociais {
		float: left;
		margin-top: 10px;
		margin-right: 10px;
	}

	.redessociais img {
		width: 40px;
	}



	.social_titulo {
		font-size: 16px;
		margin-top: 20px;
		margin-bottom: 10px;
		font-weight: bold;
	}

	.social {
		padding-bottom: 40px;
		float: left;
		width: 60%;
	}

	.social ul {
		margin-left: 0px;
		padding-left: 0px;
	}

	.social li {
		list-style: none;
		float: left;
	}

	.social li a {
		display: block;
		width: 40px;
		height: 40px;
		text-align: center;
		line-height: 40px;
		color: #fff;
		margin: 0 3px;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		-ms-border-radius: 2px;
		border-radius: 2px;
		font-size: 16px;
	}

	.social li a.facebook {
		background: #5370bb;
	}

	.social li a.twitter {
		background: #6bb8db;
	}

	.social li a.pinterest {
		background: #e95659;
	}

	.social li a.googleplus {
		background: #dd4b39;
	}

	.social li a.linkedin {
		background: #0077b5;
	}

	.social li a.whats {
		background: #44a24c;
	}

	.social li a.whatsapp {
		background: #009f00;
	}

	.social li a:hover {
		opacity: 0.7;
		color: #FFF;
	}

	.social_imoveis {
		position: absolute;
		top: 50px;
		left: 0px;
		background-color: #fff;
		padding-top: 10px;
		padding-bottom: 20px;
		display: none;
		z-index: 999;
		box-shadow: 0px 0px 5px black;
		border-radius: 4px;
		width: 100% !important;
		height: 80px;
		text-align: center;
	}

	.social_imoveis ul {
		width: 100%;
		text-align: center;
	}

	.social_imoveis li {
		float: none !important;
		margin-top: 10px;
		display: inline-block;
	}


	.social_garagem {
		position: absolute;
		top: 50px;
		left: 0px;
		background-color: #fff;
		padding-top: 10px;
		padding-bottom: 20px;
		display: none;
		z-index: 999;
		box-shadow: 0px 0px 5px black;
		border-radius: 4px;
		width: 100% !important;
		height: 80px;
		text-align: center;
		cursor: pointer;
	}

	.social_garagem ul {
		width: 100%;
		text-align: center;
	}

	.social_garagem li {
		float: none !important;
		margin-top: 10px;
		display: inline-block;
	}

	.pedido_msg {
		margin-top: 15px;
		width: 100%;
		padding: 15px;
		text-align: left;
		font-size: 15px;
	}

	.pedido_usuario {
		text-align: left;
		font-size: 14px;
		padding-bottom: 10px;
		color: #666;
	}

	.pedido_anexo {
		text-align: left;
		font-size: 15px;
		padding-top: 10px;
		font-weight: bold;
	}

	.pedido_anexo a {
		color: blue;
	}




	.produto_imagem {
		display: inline-block;
		width: 90%;
		height: 170px;
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		margin: 5%;
		cursor: pointer;
	}

	.produto_imagem:hover {
		opacity: 0.9;
	}

	.produto_titulo_lista {
		font-size: 14px;
		cursor: pointer;
		height: 35px;
	}

	.produto_titulo_lista:hover {
		text-decoration: underline;
	}

	.product-image-wrapper {
		border: 1px solid #ddd;
		border-radius: 22px 0px 22px 0px;
	}

	.lista_caminho {
		text-align: left;
		padding-left: 15px;
		padding-bottom: 25px;
		padding-top: 7px;
		color: #999;
		float: left;
		font-size: 16px;
	}

	.produtos_lista_ordem {
		text-align: center;
		color: #999;
		padding-bottom: 20px;
		padding-top: 0px;
	}

	.produtos_select_ordem {}

	.produtos_linha {
		width: 100%;
		margin-top: 14px;
		margin-bottom: 4px;
		border-top: 2px solid #f2f2f2;
	}

	.login_div {
		text-align: right;
		padding-bottom: 70px;
	}

	.login_form {
		border-radius: 0px;
	}

	.cadastro_div {
		text-align: left;
		padding-bottom: 70px;
	}

	.cadastro_form {
		border-radius: 2px !important;
		height: 36px !important;
		width: 100% !important;
	}

	.cadastro_select {
		border-radius: 2px !important;
		height: 36px !important;
		width: 100% !important;
		text-align: left !important;
	}

	.select2-container .select2-selection--single {
		height: 36px !important;
		border-radius: 2px !important;
	}

	.select2-container .select2-selection--single .select2-selection__rendered {
		padding-top: 3px;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow b {
		margin-top: 1px;
	}

	.login_div .cart {
		display: inline-block;
		margin: 0px;
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 20px;
		padding-right: 20px;
	}



	.div_form {
		padding-top: 10px;
		width: 100%;
	}

	.form_erro {
		color: #c60202;
		font-size: 14px;
	}

	#cadastro_erro_fundo {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999999;
		display: none;
		background-color: rgba(0, 0, 0, 0.5);
	}

	#cadastro_erro {
		position: fixed;
		left: 50%;
		top: 50%;
		margin-top: -75px;
		margin-left: -200px;
		width: 400px;
		height: auto;
		padding: 30px;
		z-index: 99999999;
		display: none;
		background-color: #FFF;
		font-size: 14px;
		color: #000;
		text-align: center;
		border: 2px solid #666;
		border-radius: 5px;
	}

	.cadastro_msg_interna {
		font-size: 15px;
		color: #666;
		padding-bottom: 20px;
		background: white;
	}

	#login_erro_fundo {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999999;
		display: none;
		background-color: rgba(0, 0, 0, 0.5);
	}

	#login_erro {
		position: fixed;
		left: 50%;
		top: 50%;
		margin-top: -75px;
		margin-left: -200px;
		width: 400px;
		height: auto;
		padding: 30px;
		z-index: 99999999;
		display: none;
		background-color: #FFF;
		font-size: 14px;
		color: #000;
		text-align: center;
		border: 2px solid #666;
		border-radius: 5px;
	}

	.linha_entrar {
		border-left: 1px solid #ccc;
		height: 200px;
		display: inline-block;
	}

	.contactinfo ul li a {
		color: #ccc;
	}

	.social-icons ul li a {
		color: #333;
	}

	.botao_busca_blog {
		padding: 10px 14px;
		font-size: 14px !important;
		border: 0px;
		border-radius: 0px;
	}

	.category-products .panel-default .panel-heading .panel-title a {

		color: #1a1a1a;


	}

	.contactinfo ul li:first-child {
		margin-left: 0px;
	}

	.left-sidebar h2,
	.brands_products h2 {
		color: #000000;
		font-size: 21px;
	}

	.category-products {
		border: 1px solid #ddd;
	}





	.pull-right a {
		font-weight: normal;
		font-style: normal;
		color: #FFF;
		text-decoration: none;
		font-size: 13px;
	}

	.pull-right a:hover {
		text-decoration: underline;
	}

	a#scrollUp {
		background: #549c13;
		color: #FFF;
	}

	.single-widget h2 {
		padding-top: 5px;
		margin-bottom: 10px;
		color: #FFF;
	}

	.single-widget ul li a:hover {
		color: #000;
	}

	.modal-content {
		border-radius: 0px;
	}

	.control-carousel {
		top: 50%;
		margin-top: -40px;
		color: #FFF;
	}

	.control-carousel:hover {
		color: #FFF;
	}

	.carousel-indicators li.active {
		background: #FFF;
	}

	.banner_central {
		width: 100%;
		height: 500px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
	}

	.item {
		padding-left: 0px;
	}

	.produto_detalhes_titulo {
		font-size: 26px;
		color: #000;
		padding-top: 3px;
		padding-bottom: 7px;
		margin-bottom: 25px;
		font-weight: bold;
		border-bottom: 1px solid #ddd;
	}

	.produto_detalhes {
		font-size: 14px;
		color: #666;
		padding-bottom: 5px;
		padding-top: 5px;
		font-weight: normal;
	}

	.produto_detalhes_quant {
		font-size: 15px;
		color: #666;
		padding-top: 5px;
	}

	.produto_detalhes_valor {
		font-size: 38px;
		font-weight: bold;
		color: black;
		padding-bottom: 5px;
		padding-top: 0px;
		margin-top: 0px;
	}

	#valorartevisual {
		font-size: 15px;
		color: #333;
	}

	#similar-product {
		margin-top: 0px;
	}

	.produto_imagem_detalhes {
		display: inline-block;
		width: 100%;
		height: 300px;
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
		cursor: pointer;
	}

	.product-information {
		border: 1px solid #ddd;
		padding-left: 35px;
		padding-top: 20px;
		padding-bottom: 20px;
		padding-right: 35px;
		min-height: 300px;
	}

	.product-information span {
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.cart {
		background: #5a981c;
		color: #FFF;
		margin: 0px;
	}

	.cart:hover {
		background: #528b19;
		color: #FFF;
	}


	.item-control {
		top: 50%;
		margin-top: -10px;
	}

	.item-control i {
		background: #ccc;
		color: #000;
	}

	.item-control i:hover {
		background: #eee;
		color: #333;
	}


	.produtos_detalhes_valortotal {
		font-size: 14px;
		color: #666;
		font-weight: normal;
		margin-top: 15px;
	}

	.produtos_detalhes_margin {
		padding-left: 40px;
	}


	#produto_detalhes_parcelas {
		font-size: 13px;
		color: #666;
		font-weight: normal;
	}

	.tabela_boa thead tr {
		background-color: #292929;
		border: 0px;
	}

	.carrinho_lista_imagem {
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		width: 40%;
		height: 140px;
		float: left;
		margin-top: 10px;
		margin-bottom: 10px;
	}

	.carrinho_lista_texto {
		float: left;
		padding-top: 10px;
		padding-bottom: 10px;
		width: 60%;
		font-size: 18px;
	}

	.carrinho_lista_valor {
		padding-top: 38px;
	}

	.carrinho_lista_remover {
		padding-top: 31px;
		font-size: 20px;
		font-weight: bold;
	}

	.carrinho_quantidade_input {
		width: 50px;
		display: inline-block;
		height: 32px;
		text-align: center;
	}

	.botao_quantidade {
		background: #5a981c;
		color: #FFF;
		margin: 0px;
		width: 50%;
		display: inline-block;
	}

	.botao_quantidade:hover {
		background: #528b19;
		color: #FFF;
	}

	.botao_finalizar {
		background: #5a981c;
		color: #FFF;
		margin: 0px;
	}

	.botao_finalizar:hover {
		background: #528b19;
		color: #FFF;
		margin: 0px;
	}

	.botao_continuar_comprando {
		background: #0067a9;
		color: #FFF;
		margin: 0px;
	}

	.botao_continuar_comprando:hover {
		background: #005388;
		color: #FFF;
		margin: 0px;
	}


	#contact-page .form-control {
		border-radius: 0px;
	}

	.carrinho_erro {
		text-align: center;
		padding-top: 50px;
		padding-bottom: 50px;
		font-size: 16px;
		color: #333;
		background: white;
	}

	.ajuste_botoes_carrinho_d {
		padding-top: 50px;
		text-align: right;
	}

	.ajuste_botoes_carrinho_e {
		padding-top: 50px;
		text-align: left;
	}

	.meusdados {
		background: #0067a9;
		color: #FFF;
		margin: 0px;
	}

	.meusdados:hover {
		background: #005388;
		color: #FFF;
		margin: 0px;
	}

	.bt_alterar_dados {
		position: relative;
		top: 0px;
		right: 0px;
		text-align: right;
		margin: 0px;
		padding-top: 5px;
		padding-bottom: 20px;
		width: 100%;
	}

	.tabela_pedidos thead tr {
		background-color: #f2f2f2;
		border: 0px;
	}

	.tabela_pedidos a {
		color: #000;
	}

	.tabela_pedidos a:hover {
		color: #999;
	}

	.pedidostabela {
		padding-bottom: 60px;
		width: 100%;
	}

	.div_videos {
		background-image: url('../img/verde1.jpg');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: center top;
		background-size: cover;
		padding-top: 50px;
		padding-bottom: 50px;
		width: 100%;
		margin-top: 40px;
		margin-bottom: 40px;
	}

	.videos_inicial {
		width: 100%;
		margin-top: 40px;
	}

	.video_conteudo {
		width: 100%;
		height: 315px;
		overflow: hidden;
	}

	.titulo_video {
		padding-top: 0px;
		margin-top: 0px;
	}

	.titulo_video a {
		color: #FFF;
		font-size: 20px;
		font-weight: 500;
		line-height: 0.0;
	}

	.titulo_video a:hover {
		color: #FFF;
		text-decoration: underline;
	}

	.titulo_video_div {
		margin-top: 0px;
		padding-top: 0px;
	}



	.redessociais {
		float: left;
		margin-top: 10px;
		margin-right: 10px;
	}

	.redessociais img {
		width: 40px;
	}



	.social {
		padding-bottom: 40px;
		float: left;
		width: 60%;
	}

	.social ul {
		margin-left: 0px;
		padding-left: 0px;
	}

	.social li {
		list-style: none;
		float: left;
	}

	.social li a {
		display: block;
		width: 40px;
		height: 40px;
		text-align: center;
		line-height: 40px;
		color: #fff;
		margin: 0 3px;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		-ms-border-radius: 2px;
		border-radius: 2px;
		font-size: 16px;
	}

	.social li a.facebook {
		background: #5370bb;
	}

	.social li a.twitter {
		background: #6bb8db;
	}

	.social li a.pinterest {
		background: #e95659;
	}

	.social li a.googleplus {
		background: #dd4b39;
	}

	.social li a.linkedin {
		background: #0077b5;
	}

	.social li a.whatsapp {
		background: #009f00;
	}

	.social li a:hover {
		opacity: 0.7;
		color: #FFF;
	}

	.pedido_msg {
		margin-top: 15px;
		width: 100%;
		padding: 15px;
		text-align: left;
		font-size: 15px;
	}

	.pedido_usuario {
		text-align: left;
		font-size: 14px;
		padding-bottom: 10px;
		color: #666;
	}

	.pedido_anexo {
		text-align: left;
		font-size: 15px;
		padding-top: 10px;
		font-weight: bold;
	}

	.pedido_anexo a {
		color: blue;
	}

	.facebookwidgets {
		z-index: 999999999999;
		position: fixed;
		right: -360px;
		top: 50%;
		margin-top: 20px;
	}

	.facebookwidgets .botao {
		background: url("<?= LAYOUT ?>img/facebook.png") no-repeat scroll left center transparent !important;
		float: left;
		width: 30px;
		height: 110px;
		cursor: pointer;
	}

	.facebookwidgets .conteudo {
		float: right;
		background-color: #FFF;
		padding: 15px;
	}

	.produto_imagem_lupa {
		width: 100%;
		height: 100%;
		background-repeat: no-repeat;
		background-position: center;
		opacity: 0;
	}


	.botao_leitura {
		border-radius: 0px;
		color: #000;
		font-weight: bold;
		border: 1px solid #ddd;
	}

	#scrollUp {}

	#scrollUp:hover {}

	#depoimentos {
		position: relative;
		width: 100%;
		height: auto;
		min-height: 300px;
		padding-bottom: 50px;
	}

	#slider-depoimentos {
		height: 370px;
	}

	.depoimentos_inicial_conteudo {
		font-size: 17px;
		text-align: center;
		padding-top: 80px;
		width: 100%;
	}

	.depoimentos_inicial_imagem {
		margin-top: 30px;
		text-align: center;
		height: 70px;
		overflow: hidden;
		width: 100%;
	}

	.depoimentos_inicial_imagem img {
		height: 70px;
	}

	.depoimentos_inicial_nome {
		font-size: 18px;
		font-weight: bold;
		margin-top: 10px;
		text-align: center;
	}

	.depoimentos_inicial_cidade {
		font-size: 14px;
		text-align: center;
	}

	.depoimentos_lista {
		padding-top: 50px;
		padding-bottom: 50px;
	}

	.depoimentos_lista_conteudo {
		font-size: 16px;
		color: #666;
		text-align: center;
		width: 100%;
	}

	.depoimentos_lista_nome {
		font-size: 17px;
		color: #000;
		font-weight: bold;
		padding-top: 15px;
		text-align: center;
	}

	.depoimentos_lista_cidade {
		font-size: 14px;
		color: #000;
		text-align: center;
	}

	.depoimentos_lista_imagem {
		padding-top: 30px;
		text-align: center;
	}

	.depoimentos_lista_imagem img {
		max-width: 250px;
	}


	.produto_titulo_lista {
		height: auto;
		font-weight: bold;
	}

	.carousel-indicators {
		bottom: 40px;
	}

	.nome_cliente {
		font-size: 16px;
		text-align: left;
		width: 100%;
		padding-top: 10px;
		padding-bottom: 20px;
	}

	.bt_alterar_dados .add-to-cart {
		margin-bottom: 0px;
	}

	.productinfo p {
		font-size: 13px;
	}

	.produto_imagem {
		display: inline-block;
		width: 90%;
		height: 250px;
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		margin: 5%;
		cursor: pointer;
	}

	.produto_imagem:hover {
		opacity: 0.9;
	}

	.produto_titulo_lista {
		font-size: 14px;
		cursor: pointer;
		height: 35px;
	}

	.produto_titulo_lista:hover {
		text-decoration: underline;
	}

	.product-image-wrapper {
		border: 1px solid #ddd;
	}

	.lista_caminho {
		text-align: left;
		padding-left: 15px;
		padding-bottom: 25px;
		padding-top: 7px;
		color: #999;
		float: left;
		font-size: 16px;
	}

	.produtos_linha {
		width: 100%;
		margin-top: 14px;
		margin-bottom: 4px;
		border-top: 1px solid #f2f2f2;
	}

	.login_div {
		text-align: right;
		padding-bottom: 70px;
	}

	.login_form {
		border-radius: 0px;
	}

	.login_div .cart {
		display: inline-block;
		margin: 0px;
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 20px;
		padding-right: 20px;
	}

	.form_erro {
		color: #c60202;
		font-size: 14px;
	}

	#cadastro_erro_fundo {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999999;
		display: none;
		background-color: rgba(0, 0, 0, 0.5);
	}

	#cadastro_erro {
		position: fixed;
		left: 50%;
		top: 50%;
		margin-top: -75px;
		margin-left: -200px;
		width: 400px;
		height: auto;
		padding: 30px;
		z-index: 99999999;
		display: none;
		background-color: #FFF;
		font-size: 14px;
		color: #000;
		text-align: center;
		border: 2px solid #666;
		border-radius: 5px;
	}

	.cadastro_msg_interna {
		font-size: 15px;
		color: #666;
		padding-bottom: 20px;
		background: white;
	}

	#login_erro_fundo {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999999;
		display: none;
		background-color: rgba(0, 0, 0, 0.5);
	}

	#login_erro {
		position: fixed;
		left: 50%;
		top: 50%;
		margin-top: -75px;
		margin-left: -200px;
		width: 400px;
		height: auto;
		padding: 30px;
		z-index: 99999999;
		display: none;
		background-color: #FFF;
		font-size: 14px;
		color: #000;
		text-align: center;
		border: 2px solid #666;
		border-radius: 5px;
	}

	.linha_entrar {
		border-left: 1px solid #ccc;
		height: 200px;
		display: inline-block;
	}

	.panel-default>.panel-heading .badge {
		background-color: transparent;
		color: #000;
	}

	.banner_frete {
		width: 100%;
		padding-top: 0px;
		padding-bottom: 0px;
		text-align: center;
		background-color: #fff;
	}

	.banner_frete img {
		width: 100%;
	}



	.pagination {}

	.pagination>li:last-child>a,
	.pagination>li:last-child>span {
		border-radius: 0px;
	}

	.pagination li a,
	.pagination li span {}

	.pagination li a:hover,
	.pagination li span :hover {}

	.pagination li a:hover,
	.pagination li span :hover {}

	.pi-pagenav li {
		background: transparent;
		border-radius: 0px;
		margin: 1px;
	}

	.pi-pagenav li:hover {
		background: transparent;
		border-radius: 0px;
	}

	.pi-pagenav li a {}

	.pi-pagenav li a:hover {}

	.pi-pagenav li a.active:hover {}

	.pi-pagenav li .active {
		border-radius: 0px;
	}

	.pi-pagenav a:active,
	.pi-pagenav a.active {}

	.pi-pagenav a:active:hover,
	.pi-pagenav a.active:hover {}

	.pi-pagenav a {
		border-radius: 0px;
	}

	.instagram {
		position: relative;
		background-image: url(<?= LAYOUT ?>img/fundo_insta.png);
		width: 100%;
	}

	.instagram_titulo_conta {
		font-size: 30px;
		font-weight: 500;
		text-align: center;
		width: 100%;
		padding-top: 30px;
		color: #000;
	}

	.instagram_miniaturas {
		margin-top: 30px;
		width: 100%;
		height: auto;
		padding-bottom: 50px;
		text-align: center;
	}

	.instagram_miniaturas a {
		display: inline-block;
		width: 150px;
		margin-left: 3px;
		margin-right: 3px;
		margin-bottom: 10px;
	}

	.instagram_miniaturas a img {
		width: 100%;
	}

	.carousel-pause {
		position: absolute;
		right: 20px;
		bottom: 7px;
		z-index: 9999;
		background-color: #fff;
		border-radius: 0 0 0px 0px;
		padding-left: 10px;
		padding-right: 10px;
	}

	.botao_normal {
		cursor: pointer;
		padding: 7px;
		display: inline-block;
		font-size: 17px;
	}

	.botao_preto {
		cursor: pointer;
		padding: 7px;
		display: inline-block;
		font-size: 17px;
		color: #000;
	}

	a.prev {
		position: absolute;
		left: 10px;
		top: 230px;
		background-image: url(<?= LAYOUT ?>img/setabanner2.png);
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		margin: 0px;
		width: 20px;
		height: 20px;
		z-index: 999999;
	}

	a.next {
		position: absolute;
		right: 10px;
		top: 230px;
		background-image: url(<?= LAYOUT ?>img/setabanner1.png);
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		margin: 0px;
		width: 20px;
		height: 20px;
		z-index: 999999;
	}


	.callbacks_nav {
		opacity: 0.6;
		width: 50px;
		margin: 15px;
	}

	.callbacks_nav.prev {
		display: none;
		margin-top: -50px;
		background-image: url(<?= LAYOUT ?>img/setabanner2.png);
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		height: 100%;
	}

	.callbacks_nav.next {
		display: none;
		margin-top: -50px;
		background-image: url(<?= LAYOUT ?>img/setabanner1.png);
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		height: 100%;
	}

	.callbacks_container {
		padding-top: 0px;
	}

	.callbacks_tabs {
		position: absolute;
		width: 100%;
		left: 0px;
		bottom: 15px;
		text-align: center;
		z-index: 9999;
	}

	.callbacks_tabs li {
		width: 20px !important;
		height: 20px !important;
		display: inline-block;
	}

	.callbacks_tabs a {
		visibility: visible;
		padding: 5px;
		width: 20px !important;
		height: 20px !important;
		border-radius: 10px;
		font-weight: 600;
		font-size: 0px;
		border: 1px solid #fff;
	}

	.callbacks_tabs a:hover {
		text-decoration: none;
	}

	.callbacks_tabs a:after {
		display: none;
	}

	.callbacks_tabs li.callbacks_here a {
		text-decoration: none;
	}

	.produtos_item_destaque {}

	.bx-viewport {
		border: 0px !important;
		-webkit-box-shadow: none !important;
	}


	.botao_arte {
		background-color: blue;
		text-align: center
	}

	.botao_arte span {
		font-size: 15px !important;
		color: #fff !important;
		margin-right: 0px !important;
	}





	.destaques_inicial_imagem {
		width: 100%;
		height: 170px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
	}

	a.quadros_inicial {
		display: block;
		width: 100%;
		height: 230px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
	}

	.quadros_inicial_titulo {
		display: block;
		font-size: 26px;
		color: #fff;
		font-weight: bold;
		text-align: center;
		padding-left: 20px;
		padding-right: 20px;
		padding-bottom: 20px;
		padding-top: 50px;
		width: 100%;
		text-shadow: 2px 2px 3px #000000;
	}

	a.duvidas_lista {
		display: block;
		margin-top: 15px;
		font-size: 16px;
		font-weight: bold;
		color: #000;
		cursor: pointer;
	}

	a.duvidas_lista_ativo {
		display: block;
		margin-top: 15px;
		font-size: 16px;
		font-weight: bold;
		cursor: pointer;
	}

	a.duvidas_lista_topo {
		display: inline-block;
		margin-top: 10px;
		font-size: 15px;
		font-weight: 500;
		color: #000;
		cursor: pointer;
		padding-right: 10px;
		margin-right: 8px;
	}

	a.duvidas_lista_topo_ativo {
		display: inline-block;
		margin-top: 15px;
		font-size: 15px;
		font-weight: 500;
		cursor: pointer;
		padding-right: 10px;
		margin-right: 8px;
	}

	.duvidas_pergunta {
		display: block;
		margin-top: 15px;
		font-size: 18px;
		font-weight: bold;

	}

	.duvidas_resposta {
		display: block;
		margin-top: 15px;
		font-size: 15px;
	}

	.duvidas_div {
		margin-top: 30px;
		margin-bottom: 80px;
	}


	a.servicos_item {
		display: block;
		margin-top: 30px;
		width: 100%;
	}

	.servicos_img {
		width: 100%;
		height: 150px;
		overflow: hidden;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
	}

	.servicos_img img {
		width: 100%;
	}

	.servicos_titulo {
		margin-top: 10px;
		font-size: 15px;
		text-align: center;
		font-weight: bold;
		color: #666;
	}


	a.filiais_item {
		display: block;
		margin-top: 30px;
		width: 100%;
	}

	.filiais_img {
		width: 100%;
		height: 220px;
		overflow: hidden;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
	}

	.filiais_img img {
		width: 100%;
	}

	.filiais_titulo {
		margin-top: 10px;
		font-size: 15px;
		text-align: center;
		font-weight: bold;
		color: #666;
	}

	.parceiros_item {
		width: 100%;
		max-width: 100%;
		text-align: center;
	}

	.parceiros_img_div {
		text-align: center !important;
		width: 100%;
	}

	a.parceiros_img {
		height: 150px;
		width: 290px;
		text-align: center !important;
		display: table-cell;
		vertical-align: middle;
	}

	a.parceiros_img img {
		max-height: 100%;
		display: inline-block !important;
	}

	.parceiros_cidade {
		font-size: 12px;
		margin-top: 7px;
	}

	.parceiros_fone {
		font-size: 12px;
		font-weight: 500;
		margin-top: 1px;
	}


	.video_inicial {
		width: 100%;
	}

	.video_inicial iframe {
		width: 100% !important;
		height: 380px;
	}

	a.servicos_imagens_interno {
		display: inline-block;
		margin: 10px;
		width: auto;
		height: 150px;
	}

	a.servicos_imagens_interno img {
		height: 100%;
	}


	.blocos_sess {
		width: 100%;
		padding-top: 40px;
		padding-bottom: 70px;
	}

	.bloco_imagem {
		width: 100%;
		margin-top: 30px;
	}

	.bloco_imagem img {
		width: 100%;
	}

	.bloco_titulo {
		margin-top: 35px;
		text-align: left;
		font-size: 24px;
		color: #666;
		font-weight: bold;
	}

	.bloco_descricao {
		margin-top: 30px;
		color: #000;
		text-align: left;
		font-size: 16px;
		width: 100%;
	}

	.bloco_botao_div {
		display: inline-block;
		text-align: center;
		margin-top: 10%;
		vertical-align: bottom;
		height: 100%;


	}

	a.blocos_botao {
		display: inline-block;
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 20px;
		padding-right: 20px;
		border-radius: 3px;
		font-size: 16px;
		font-weight: bold;

	}

	a.ultimos_servicos_img {
		display: block;
		width: 100%;
		text-align: center;
		height: 180px;
		margin-top: 30px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
	}


	.caracteristicas_div {
		width: 100%;
		margin-top: 30px;
		text-align: center;
	}

	.caracteristicas_icone {
		text-align: center;
		width: 100%;
		display: block;
	}

	.caracteristicas_icone i {
		font-size: 40px;
	}

	.caracteristicas_img {
		display: block;
		width: 100%;
		text-align: center;
	}

	.caracteristicas_img img {
		width: 40%;
	}

	.caracteristicas_titulo {
		font-size: 16px;
		font-weight: bold;
		color: #333;
	}

	.caracteristicas_descricao {
		font-size: 14px;
		color: #666;
		font-weight: 400;
	}


	.planos_div {
		box-shadow: 0 10px 25px 0 rgba(6, 12, 34, 0.1);
		width: 100%;
		height: auto;
		text-align: center;
		margin-top: 20px;
		border-radius: 15px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: top;
	}

	.planos_titulo {}

	.planos_valor {
		margin-top: 15px;
		text-align: center;
		font-size: 28px;
		font-weight: 500;
	}

	a.planos_botao {
		display: inline-block;
		font-size: 15px;
		border-radius: 50px;
		padding: 10px 40px;
		transition: all 0.2s;
		background-color: #f82249;
		border: 0;
		color: #fff;
	}

	.planos_itens {
		list-style: none;
		text-align: left;
		margin-top: 10px;
		margin-bottom: 20px;
	}

	.planos_itens li {
		margin-top: 7px;
		font-size: 14px;
	}

	.planos_itens li span {
		display: inline-block;
		width: 25px;
		text-align: left;
	}


	.contador_div {
		width: 100%;
		text-align: center;
		margin-top: 30px;
	}

	.contador_img {
		width: 100%;
	}

	.contador_img img {
		width: auto !important;
		height: 50px;
	}

	.contador_valor {
		font-size: 36px;
		margin-top: 15px;
		font-weight: bold;
	}

	.contador_titulo {
		font-size: 22px;
		font-weight: 500;
	}


	.acordeon_titulo {
		width: 100%;
		text-align: left;
		font-size: 16px;
		font-weight: bold;
		border-radius: 7px;
	}

	.acordeon_titulo:active,
	.acordeon_titulo:focus,
	.acordeon_titulo:hovers {}

	.acordeon_titulo i {
		margin-right: 6px;
		font-size: 14px;
	}

	.acordeon_titulo:hover {
		width: 100%;
		text-align: left;
		text-decoration: none;
	}

	.acordeon_descricao {
		width: 100%;
	}


	a.fotos1_div {
		display: block;
		width: 100%;
		height: 220px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		cursor: pointer;
	}

	a.fotos2_div {
		display: block;
		width: 100%;
		height: 200px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		cursor: pointer;
		margin-top: 30px;
	}

	a.fotos2_titulo {
		display: block;
		text-align: center;
		margin-top: 10px;
		font-size: 15px;
		font-weight: 500;
		width: 100%;
	}

	a.fotos_imagens_interno {
		display: inline-block;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		width: 200px;
		height: 150px;
		margin: 15px;
		position: relative;
		margin-bottom: 25px;
	}

	a.fotos_categorias {
		display: block;
		margin-top: 15px;
		font-size: 16px;
		cursor: pointer;
		font-weight: 500;
	}

	a.fotos_categorias_topo {
		display: inline-block;
		margin-top: 10px;
		font-size: 15px;
		cursor: pointer;
		font-weight: 500;
		padding-right: 10px;
		margin-right: 8px;
	}


	.anim-section {
		position: relative;
		-webkit-transition: all 1s ease-in-out;
		-moz-transition: all 1s ease-in-out;
		-ms-transition: all 1s ease-in-out;
		-o-transition: all 1s ease-in-out;
		transition: all 1s ease-in-out;
		-moz-transform: translateY(20px);
		-webkit-transform: translateY(20px);
		-o-transform: translateY(20px);
		-ms-transform: translateY(20px);
		transform: translateY(20px);
		visibility: visible;
		opacity: 0
	}

	.anim-section.animate {
		-moz-transform: translateY(0px);
		-webkit-transform: translateY(0px);
		-o-transform: translateY(0px);
		-ms-transform: translateY(0px);
		transform: translateY(0px);
		visibility: visible;
		opacity: 1
	}

	.fadeIn-section {
		visibility: visible;
		opacity: 0;
		position: relative;
	}

	@-webkit-keyframes fadeIn {
		0% {
			opacity: 0;
		}

		100% {
			opacity: 1;
		}
	}

	@-moz-keyframes fadeIn {
		0% {
			opacity: 0;
		}

		100% {
			opacity: 1;
		}
	}

	@-o-keyframes fadeIn {
		0% {
			opacity: 0;
		}

		100% {
			opacity: 1;
		}
	}

	@-ms-keyframes fadeIn {
		0% {
			opacity: 0;
		}

		100% {
			opacity: 1;
		}
	}

	@keyframes fadeIn {
		0% {
			opacity: 0;
		}

		100% {
			opacity: 1;
		}
	}

	.fadeIn {
		-webkit-animation: fadeIn 1s linear;
		-moz-animation: fadeIn 1s linear;
		-o-animation: fadeIn 1s linear;
		-ms-animation: fadeIn 1s linear;
		animation: fadeIn 1s linear;
		visibility: visible;
		opacity: 1;
		position: relative;
	}


	a.destaques_div {
		display: block;
		width: 100%;
		position: relative;
		margin-left: 0px;
		margin-right: 0px;
	}

	.destaques_img {
		width: 80%;
		height: 250px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		border: 1px solid #ddd;
	}

	.destaques_titulo {
		position: absolute;
		left: 0px;
		width: 100%;
		bottom: 0px;
		padding: 10px;
		font-weight: 500;
		font-size: 15px;
		text-align: center;
	}

	.contato_form {
		border-radius: 1px;
		width: 100%;
		height: 40px;
	}

	.botao_contato {
		text-align: right;
		padding-top: 18px;
		padding-bottom: 40px;
	}



	.equipe_div {
		width: 100%;
		margin-top: 30px;
		text-align: center;
	}

	.equipe_img {
		display: inline-block;
		width: 100%;
		text-align: center;
		overflow: hidden;
	}

	.equipe_img img {
		display: inline-block;
		width: auto !important;
		height: 200px;
	}

	.equipe_titulo {
		margin-top: 20px;
		font-size: 16px;
		font-weight: bold;
		color: #333;
	}

	.equipe_descricao {
		font-size: 14px;
		color: #666;
		font-weight: 400;
	}


	.noticias_imagem_lateral_interna {
		width: 40%;
		float: left;
		margin-right: 20px;
		margin-bottom: 10px;
	}


	.noticias_1_div {
		position: relative;
		padding-top: 0px;
		padding-left: 0px;
		padding-right: 0px;
		padding-bottom: 10px;
		margin-top: 40px;
		height: 440px;
		background-color: #fff;
		border-radius: 10px;
	}

	a.noticias_1_lermais {
		font-size: 16px;
		font-weight: 500;
		color: #000;
		position: absolute;
		bottom: 15px;
		right: 14px;
	}

	.noticias_1_1_img {
		margin-bottom: 20px;
		width: 100%;
		height: 350px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
	}

	.noticias_1_1_img:hover {
		opacity: 0.9;
	}

	.noticias_1_2_img {
		margin-bottom: 20px;
		width: 100%;
		height: 260px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
	}

	.noticias_1_2_img:hover {
		opacity: 0.9;
	}

	.noticias_1_3_img {
		margin-bottom: 20px;
		width: 100%;
		height: 200px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 10px 10px 0px 0px;
	}

	.noticias_1_3_img:hover {
		opacity: 0.9;
	}

	.noticias_1_4_img {
		margin-bottom: 20px;
		width: 100%;
		height: 150px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
	}

	.noticias_1_4_img:hover {
		opacity: 0.9;
	}

	.noticias_1_6_img {
		margin-bottom: 10px;
		width: 100%;
		height: 100px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 10px 10px 0px 0px;
	}

	.noticias_1_6_img:hover {
		opacity: 0.9;
	}

	a.noticias_1_item {
		width: 100%;
		margin-top: 0px;
		display: inline-block;
	}

	.noticias_1_titulo {
		font-family: 'Kastelov Intelo Bold';
		font-size: 24px;
		font-weight: bold;
		margin-top: 10px;
		color: #000;
		padding-left: 30px;
		padding-right: 30px;
		line-height: 22px;
	}

	.noticias_1_previa {
		margin-top: 15px;
		width: 100%;
		font-size: 14px;
		color: #666;
		padding-left: 30px;
		padding-right: 30px;
		padding-bottom: 15px;
		font-weight: normal;
	}



	.noticias_2_div {
		padding-top: 0px;
		padding-left: 0px;
		padding-right: 0px;
		padding-bottom: 10px;
		margin-top: 0px;
		height: auto;
	}

	.noticias_2_1_img {
		margin-bottom: 20px;
		width: 100%;
		height: 350px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 5px;
		position: relative;
	}

	.noticias_2_1_img:hover {
		opacity: 0.9;
	}

	.noticias_2_2_img {
		margin-bottom: 20px;
		width: 100%;
		height: 260px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 5px;
		position: relative;
	}

	.noticias_2_2_img:hover {
		opacity: 0.9;
	}

	.noticias_2_3_img {
		margin-bottom: 20px;
		width: 100%;
		height: 200px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 5px;
		position: relative;
	}

	.noticias_2_3_img:hover {
		opacity: 0.9;
	}

	.noticias_2_4_img {
		margin-bottom: 20px;
		width: 100%;
		height: 150px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 5px;
		position: relative;
	}

	.noticias_2_4_img:hover {
		opacity: 0.9;
	}

	a.noticias_2_item {
		width: 100%;
		margin-top: 20px;
		display: inline-block;
	}

	.noticias_2_titulo {
		position: absolute;
		bottom: 0px;
		left: 0px;
		width: 100%;
		padding: 10px;
		font-size: 15px;
		font-weight: bold;
		color: #fff;
		border-radius: 0px 0px 5px 5px;
	}

	.banner_topo {
		width: 100%;
		overflow: hidden;
		text-align: center;
		max-height: 130px;
	}

	.banner_topo .rslides {
		text-align: center;
	}

	.banner_topo .rslides li {
		text-align: center !important;
	}

	.banner_topo .rslides img {
		width: auto !important;
		max-height: 130px;
		display: inline-block !important;
		float: none;
	}


	.noticias_3_div {
		padding-top: 0px;
		padding-left: 0px;
		padding-right: 0px;
		padding-bottom: 10px;
		margin-top: 0px;
		height: auto;
	}

	.noticias_3_1_img {
		margin-bottom: 10px;
		width: 100%;
		height: 350px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
	}

	.noticias_3_1_img:hover {
		opacity: 0.9;
	}

	.noticias_3_2_img {
		margin-bottom: 20px;
		width: 100%;
		height: 260px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
	}

	.noticias_3_2_img:hover {
		opacity: 0.9;
	}

	.noticias_3_3_img {
		margin-bottom: 20px;
		width: 100%;
		height: 200px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
	}

	.noticias_3_3_img:hover {
		opacity: 0.9;
	}

	.noticias_3_4_img {
		margin-bottom: 20px;
		width: 100%;
		height: 150px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
	}

	.noticias_3_4_img:hover {
		opacity: 0.9;
	}

	a.noticias_3_item {
		width: 100%;
		margin-top: 20px;
		display: inline-block;
	}

	.noticias_3_titulo {
		font-size: 18px;
		font-weight: bold;
		margin-top: 10px;
		color: #000;
	}

	.noticias_3_data {
		margin-top: 5px;
		margin-bottom: 10px;
		width: 100%;
		font-size: 12px;
		color: #666;
	}

	.noticias_3_previa {
		margin-top: 5px;
		width: 100%;
		font-size: 13.5px;
		color: #666;
	}


	.link_busca {
		color: #333;
	}


	a.edicoes_div {
		display: block;
		margin-top: 30px;
		text-align: center;
		width: 100%;
		cursor: pointer;
	}

	.edicoes_img {
		width: 100%;
		text-align: center;
	}

	.edicoes_img img {
		max-width: 100%;
	}

	.edicoes_titulo {
		margin-top: 15px;
		font-weight: 500;
		font-size: 15px;
	}



	.panel-body ul {
		padding-left: 10px;
	}



	.form_rastr {
		border-radius: 0px;
		width: 350px;
		max-width: 100%;
		height: 40px;
		color: #000;
		padding-left: 20px;
		padding-right: 20px;
		margin-top: 5px;
		display: inline-block;
		text-align: center;
	}

	.anuncio_quadro {
		width: 100%;
		height: 340px;
		overflow: hidden;
		border-radius: 5px;
		border: 1px solid #ddd;
	}

	.anuncio_titulo {
		font-size: 14px;
		text-align: left;
		padding-left: 15px;
		padding-top: 12px;
		padding-bottom: 8px;
		float: left;
		font-weight: 500;
		cursor: pointer;
	}

	.anuncio_titulo:hover {
		text-decoration: underline;
	}

	.anuncio_endereco {
		font-size: 13px;
		text-align: left;
		padding-left: 15px;
		padding-top: 12px;
		padding-bottom: 10px;
	}

	.anuncio_imagem {
		clear: both;
		width: 100%;
		height: 180px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		cursor: pointer;
	}


	.veiculo_quadro {
		width: 100%;
		height: 270px;
		overflow: hidden;
		border-radius: 5px;
		border: 1px solid #ddd;
	}

	.imovel_quadro {
		width: 100%;
		height: 340px;
		overflow: hidden;
		border-radius: 5px;
		border: 1px solid #ddd;
	}

	.imovel_titulo {
		font-size: 14px;
		text-align: left;
		padding-left: 15px;
		padding-top: 12px;
		padding-bottom: 8px;
		float: left;
		font-weight: 500;
		cursor: pointer;
	}

	.imovel_titulo:hover {
		text-decoration: underline;
	}

	.imovel_imagem_div {
		width: 100%;
		height: 180px;
		overflow: hidden;
	}

	.imovel_imagem {
		clear: both;
		width: 100%;
		height: 180px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		cursor: pointer;
	}

	.imovel_valor {
		position: absolute;
		top: 55px;
		left: 15px;
		padding-top: 5px;
		padding-bottom: 3px;
		padding-left: 12px;
		padding-right: 12px;
		font-size: 13px;
		font-weight: 500;
		text-align: center;
		color: #FFF;
		z-index: 999;
		background-color: rgba(0, 0, 0, 0.6);
		border-radius: 3px;
	}


	.veiculo_imagem_div {
		width: 100%;
		height: 180px;
		overflow: hidden;
	}

	.veiculo_imagem {
		clear: both;
		width: 100%;
		height: 180px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		cursor: pointer;
	}

	.imovel_endereco {
		font-size: 13px;
		text-align: left;
		padding-left: 15px;
		padding-top: 12px;
		padding-bottom: 10px;
	}

	.imovel_botao {
		float: right;
		font-size: 13px;
		margin-left: 15px;
		margin-right: 15px;
		margin-top: 15px;
		margin-bottom: 10px;
		cursor: pointer;
		background-color: #f2f2f2;
		color: #000;
		padding-top: 7px;
		padding-bottom: 7px;
		padding-left: 15px;
		padding-right: 15px;
		border-radius: 3px;
	}

	.imovel_botao:hover {
		background-color: #fff;
		color: #000;
	}

	.imoveis_lista_itens {
		font-weight: bold;
		display: inline-block;
		font-size: 13px;
		color: #333;
		padding-top: 5px;
		padding-left: 10px;
		padding-right: 10px;
		padding-bottom: 5px;
		margin-left: 5px;
		border: 1px solid #ccc;
		border-radius: 3px;
	}

	.imoveis_lista_itens i {
		margin-right: 5px;
		font-size: 16px;
	}

	.bx-wrapper .bx-pager,
	.bx-wrapper .bx-controls-auto {
		bottom: -40px;
	}



	.imoveis_detalhes {
		background-color: #f5f5f5;
		padding-top: 65px;
	}

	.imoveis_detalhes_titulo {
		font-size: 20px;
		color: #666;
	}

	.imoveis_detalhes_titulo2 {
		font-size: 18px;
		color: #666;
		padding-left: 15px;
		font-weight: 500;
	}

	.imoveis_detalhes_subtitulo {
		font-size: 20px;
		color: #666;
	}

	.imoveis_detalhes_subtitulo span {
		font-weight: bold;
	}

	.imoveis_detalhes_quadro {
		border-radius: 5px;
		width: 100%;
	}

	.imoveis_detalhes_quadro .padding {
		padding: 20px;
	}

	.imoveis_detalhes_quadro_linha {
		border-top: 1px solid #CCC;
		margin-top: 30px;
	}

	.imoveis_detalhes_categoria {
		color: #666;
		font-size: 18px;
		padding-left: 15px;
		font-weight: 500;
	}

	.imoveis_detalhes_valor {
		background-color: #4CAF50;
		padding-top: 5px;
		padding-bottom: 5px;
		padding-left: 15px;
		padding-right: 15px;
		font-size: 16px;
		font-weight: bold;
		color: #FFF;
		text-align: center;
		border-radius: 4px;
	}

	.imoveis_detalhes_ref {
		font-size: 16px;
		color: #666;
		text-align: right;
		padding-bottom: 5px;
	}

	.imoveis_detalhes_ref2 {
		font-size: 14px;
		color: #666;
		text-align: left;
		padding-top: 20px;
		padding-left: 15px;
		display: none;
	}

	.imoveis_detalhes_quadro_ico {
		padding-top: 30px;
		text-align: left;
	}

	.imoveis_detalhes_quadro_ico2 {
		text-align: left;
		font-size: 14px;
		font-weight: 500;
		padding-top: 20px;
		padding-bottom: 20px;
		padding-left: 30px;
		padding-right: 30px;
	}

	.imoveis_detalhes_quadro_ico2 i {
		font-size: 18px;
	}

	.imoveis_detalhes_quadro_ico2 a {
		color: #000;
	}

	.imoveis_detalhes_bt_esq {
		float: left;
		width: 60%;
		margin-top: 20px;
		margin-right: 5%;
	}

	.imoveis_detalhes_bt_dir {
		float: left;
		width: 35%;
		margin-top: 20px;
	}

	.imoveis_detalhes_area {
		font-size: 14px;
		color: #666;
		padding-left: 15px;
		padding-top: 10px;
	}

	.imoveis_detalhes_condominio {
		font-size: 14px;
		color: #666;
		padding-left: 15px;
		padding-top: 10px;
	}

	.imoveis_detalhes_dormitorios {
		font-size: 14px;
		color: #666;
		padding-left: 15px;
		padding-top: 10px;
	}

	.imoveis_detalhes_suites {
		font-size: 14px;
		color: #666;
		padding-left: 15px;
		padding-top: 10px;
	}

	.imoveis_detalhes_opcoes {
		font-size: 13px;
		color: #666;
		padding-left: 15px;
		padding-bottom: 10px;
	}

	.imoveis_detalhes_descricao {
		font-size: 14px;
		color: #666;
		padding-left: 15px;
		padding-top: 10px;
	}

	.imoveis_imagens_div {
		margin-top: 20px;
		width: 100%;
	}

	.imoveis_detalhes_imagens {
		width: 100%;
		height: 400px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		border-radius: 4px;
	}

	.imoveis_imagens_div_min {
		padding-top: 10px;
		margin-left: 50px;
		margin-right: 50px;
	}

	.imoveis_detalhes_imagens_min {
		width: 100%;
		height: 60px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 3px;
	}

	.detalhes_imagens_miniaturas {
		margin-bottom: 30px;
	}



	.garagem_imagens_div {
		margin-top: 0px;
		width: 100%;
	}

	.garagem_detalhes_imagens {
		width: 100%;
		height: 400px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		border-radius: 4px;
	}

	.garagem_imagens_div_min {
		padding-top: 10px;
		margin-left: 50px;
		margin-right: 50px;
	}

	.garagem_detalhes_imagens_min {
		width: 100%;
		height: 60px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		cursor: pointer;
		border-radius: 3px;
	}

	.garagem_imagens_miniaturas {
		margin-bottom: 30px;
	}



	.owl-prev {
		position: absolute !important;
		top: 90% !important;
		left: 10px !important;
		width: 35px !important;
		height: 35px !important;
		background-repeat: no-repeat !important;
		background-position: center !important;
		background-size: cover !important;
		background-image: url(<?= LAYOUT ?>img/prev.svg) !important;
	}

	.owl-next {
		position: absolute !important;
		top: 90% !important;
		right: 10px !important;
		width: 35px !important;
		height: 35px !important;
		background-repeat: no-repeat !important;
		background-position: center !important;
		background-size: cover !important;
		background-image: url(<?= LAYOUT ?>img/next.svg) !important;
	}


	.imoveis_imagens_div_min .owl-next {
		position: absolute !important;
		top: 10px !important;
		right: -50px !important;
		width: 35px !important;
		height: 35px !important;
		background-image: url(<?= LAYOUT ?>img/next.svg) !important;
		background-repeat: no-repeat !important;
		background-position: center !important;
		background-size: cover !important;
	}

	.imoveis_imagens_div_min .owl-prev {
		position: absolute !important;
		top: 10px !important;
		left: -50px !important;
		width: 35px !important;
		height: 35px !important;
		background-image: url(<?= LAYOUT ?>img/prev.svg) !important;
		background-repeat: no-repeat !important;
		background-position: center !important;
		background-size: cover !important;
	}

	.imoveis_destaque_titulo {
		color: #666;
		font-size: 25px;
		text-align: center;
		padding-bottom: 35px;
	}

	.sessao_slideshow {
		position: relative;
		width: 100%;
		height: 550px;
		background-color: #000;
	}


	.imoveis_busca_quadro {
		width: 70%;
		border-radius: 10px;
		display: inline-block;
		margin-top: 70px;
	}



	.imoveis_busca_campo_div {
		float: left;
		width: 20%;
	}

	.imoveis_busca_campo_div2 {
		float: left;
		width: 75%;
	}

	.imoveis_busca_campo_div3 {
		float: left;
		width: 25%;
	}

	.imoveis_busca_campo_txt {
		font-size: 14px;
		color: #FFF;
		text-align: left;
		padding-bottom: 8px;
	}

	.busca_numero_imoveis {
		display: block;
		color: #FFF;
		text-align: left;
		font-size: 14px;
		padding-top: 8px;
	}

	.imoveis_busca_quadro .btn {
		width: 100%;
		padding: 15px 12px;
		font-size: 16px;
		font-weight: 500;
		margin: 0px;
		border-radius: 0px;
	}

	.imoveis_busca_quadro .esq .btn {
		border-radius: 5px 0 0 5px !important;
	}

	.imoveis_busca_quadro .dir .btn {
		border-radius: 0 5px 5px 0px !important;
	}

	.filtros_div3 .btn {
		border-radius: 3px !important;
	}

	.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
		width: 100%;
	}

	#imoveis_busca .bootstrap-select.btn-group .dropdown-menu li a {
		font-size: 16px;
		font-weight: 500;
	}

	#imoveis_busca .input-group-btn:last-child>.btn {
		margin-left: 0px;
		border-radius: 0 5px 5px 0;
	}

	#detalhada .btn {
		padding: 7px 10px 5px 10px;
	}

	#detalhada .bootstrap-select.btn-group .dropdown-toggle .filter-option {
		font-size: 14px;
	}

	#detalhada .bootstrap-select.btn-group .dropdown-menu li a {
		font-size: 14px;
	}


	.slogan {
		line-height: 36px;
	}


	.detalhes_imovel_fav {
		width: 100%;
		font-size: 15px;
		text-align: center;
		cursor: pointer;
	}

	.detalhes_imovel_fav i {
		font-size: 18px;
	}

	.detalhes_imovel_comp {
		width: 100%;
		font-size: 15px;
		text-align: center;
		cursor: pointer;
	}

	.detalhes_imovel_comp i {
		font-size: 18px;
	}

	#sortable_imagem {}

	#sortable_imagem li {
		list-style: none;
	}

	.imovel_quadro_img {
		width: 100%;
		height: 120px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		margin-top: 20px;
		border-radius: 3px;
	}

	.imovel_quadro_img:hover {
		opacity: 0.8;
		cursor: move;
	}


	.imoveis_planos_div {
		margin-top: 20px;
		text-align: center;
		font-size: 16px;
		font-weight: bold;
		font-weight: 500;
	}

	.imoveis_planos_meses {
		margin-top: 5px;
	}

	.imoveis_planos_valor {
		margin-top: 10px;
		font-weight: 500;
		margin-bottom: 20px;
	}



	.anuncio_quadro_img {
		width: 100%;
		height: 120px;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		margin-top: 20px;
		border-radius: 3px;
	}

	.anuncio_quadro_img:hover {
		opacity: 0.8;
		cursor: move;
	}


	.classificados_planos_div {
		margin-top: 20px;
		text-align: center;
		font-size: 16px;
		font-weight: bold;
		font-weight: 500;
	}

	.classificados_planos_meses {
		margin-top: 5px;
	}

	.classificados_planos_valor {
		margin-top: 10px;
		font-weight: 500;
		margin-bottom: 20px;
	}

	.frase_banner {
		position: absolute;
		width: 100%;
		left: 0px;
		top: 0px;
		padding-top: 20px;
	}


	.corrige_cedulas_principais {
		padding-right: 0px;
		padding-left: 0px;
		margin: 0px;
	}

	.fileupload-preview {
		display: inline !important;
	}



	.fot-fixd {
		z-index: 99999999999;
		flex-direction: row;
		width: 100%;
		position: fixed;
		left: 0;
		right: 0;
		bottom: 0;
		background: #000;
		padding: 20px;
		display: flex;
		color: #fff;
		vertical-align: middle;
	}

	.fot-fixd-box {
		display: flex;
		align-items: center;
		align-content: space-between;
	}

	.fot-cookie-show {
		cursor: pointer;
		margin-right: 20px;
		font-weight: 700;
	}

	.fot-fixd-close {
		cursor: pointer;
		display: inline-block;
		width: 125px;
		height: 40px;
		text-align: center;
		line-height: 40px;
		color: #333;
		background: #f1d600;
		font-weight: 700;
	}

	.fot-fixd-msg {
		line-height: 20px;
		padding: 10px 0;
		padding-right: 20px;
		font-size: 16px;
		flex: 1 1 auto;
		max-width: 100%;
	}

	.legenda_galeria {
		position: absolute;
		top: 100%;
		left: 0px;
		width: 100%;
		text-align: center;
		font-size: 14px;
		display: inline-block;
		color: #000;
		padding: 3px;
		background-color: #fff;
	}


	<?php
	// carrega css de arquivo

	foreach ($_base['css_personalizados'] as $key => $value) {

		echo "

		." . $value['classe'] . " {
			" . $value['conteudo'] . "
		}

		";
	}

	?>
</style>