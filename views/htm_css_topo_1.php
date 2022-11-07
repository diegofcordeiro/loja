<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<style type="text/css">

	.margemtopo{
		position: relative;
		width: 100%;
		height:160px;
		display: none;
	}

	.header-middle .container .row {
		border-bottom: 0px;
	}
	
	.header-middle {
		background-color: <?=$cores[76]?>;
	}

	.header-middle .container .row {
		border-bottom: 0px;
		margin-bottom: 0px;
		padding-bottom: 0px;
		margin-top: 0px;
		padding-top: 0px;
	}

	.header-bottom {
		padding:0px;
		margin: 0px;
		background-color: <?=$cores[54]?>;
		border-top:0px; 
	}

	.logo{
		text-align: left;
		margin-top:20px;
	}
	.logo img{ 
		max-width:80%;
		margin-top: 0px;
	}

	.busca_div{
		margin-top:15px;
		margin-bottom:0px;
		text-align: center;
		width: 100%;
	}

	.busca_input{
		border-top:1px solid <?=$cores['77']?>;
		border-left:1px solid <?=$cores['77']?>;
		border-bottom:1px solid <?=$cores['77']?>;
		border-right: 0px solid transparent;
		height:40px;
		border-radius: 0px; 
		color:<?=$cores['78']?> !important;
		font-size: 14px;
		width: 300px;
		padding: 14px 35px 13px 15px;
		border-radius:4px 0px 0px 4px; 
		box-shadow: none;
		background-color: <?=$cores['87']?> !important;
	}

	.busca_botao{
		background-color: <?=$cores['87']?> !important;
		border-top:1px solid <?=$cores['77']?>;
		border-right:1px solid <?=$cores['77']?>;
		border-bottom:1px solid <?=$cores['77']?>;
		height:40px;
		width: 50px;
		border-radius:0px 4px 4px 0px; 
		background-repeat: no-repeat;
		background-position: center;
		color:<?=$cores['78']?> !important;
		font-size: 20px;
	}

	a.botao_carrinho{
		position: relative;
		display: inline-block;
		width: 160px; 
		margin-left:15px;
		overflow: hidden; 
	}

	.botao_carrinho_esq{
		width:30%; 
		margin-left:15%;
		margin-right:5%;
		float: left;
		margin-top:10px;
		text-align:center;
		font-size:38px;
		color:<?=$cores[89]?>;
	}
	.botao_carrinho_dir{
		width:50%; 
		float: left;
		color: <?=$cores[89]?>;
		text-align: center;
		padding-top:15px;
	}

	.botao_carrinho_dir span{
		color: <?=$cores[88]?>;
		font-weight: bold;
		font-size: 16px; 
	}

	.div_botoes_topo{
		float: right;
		text-align: right; 
		color: <?=$cores[88]?>;
	}
	.div_botoes_topo i{
		font-size:19px;
		color: <?=$cores[88]?>;
	}

	a.botao_conta_topo{
		display: block;
		float: left;
		padding-left: 10px;
		padding-right: 10px;
		padding-top:19px;
		padding-bottom:5px;
		text-align: center;
	}
	a.botao_conta_topo i{
		color:<?=$cores[89]?>;
	}
	a.botao_conta_topo span{
		display:block;
		font-size:10px;
		font-weight: 400;
		color:<?=$cores[88]?>;
		padding-top:3px; 
	}


	.topo_redes{
		margin-top:15px;
		width:auto;
		max-width:90%;
		height:50px;
		text-align: right;
		background-color: <?=$cores[85]?>;
		float: right;
		color: <?=$cores[86]?>;
	}
	.topo_redes_triangulo {
		margin-top:15px;
		width: 0;
		height: 0;
		border-bottom:50px solid <?=$cores[85]?>;
		border-left:40px solid transparent;
		float: right;
	}

	.topo_redes_item{
		float: left;
		margin-top:11px;
		color:<?=$cores[86]?>;
		font-size: 16px;
		font-weight: bold;
		padding-top:5px;
		padding-right:23px; 
		text-align: left;
	}
	.topo_redes_item i{
		font-size: 15px;
		color:<?=$cores[86]?>;
	}


	.mainmenu ul li a{ 
		font-weight: 400;
	}
	.mainmenu ul li a { 
		font-size: 20px;
	}
	.mainmenu ul li a:hover{
		color:<?=$cores[93]?>;
		font-weight: 400;
	}
	.mainmenu ul li a.active{ 
		font-weight: 500;
	}

	.navbar-nav li ul.sub-menu li a:hover {

	}
	.navbar-collapse.collapse {
		padding-top: 7px;
	}

	.navbar-collapse.collapse {
		padding-top: 0px;
	}

	.navbar-header{
		width: 100%;
		text-align: center;
	}

	.mainmenu ul {
		width: 100%;
		height:auto;
		text-align: center; 
	}
	.mainmenu ul li{
		float: none;
		display: inline-block;
		margin:0px;
		padding:0px;
		position:inherit;
		height:auto;
	}
	.mainmenu ul li a{
		position:inherit;
		display: table-cell; 
		height:auto;
		padding-top:15px;
		padding-bottom:13px;
		padding-left:10px;
		padding-right:10px;
	}
	.mainmenu ul li:hover, .mainmenu ul li a:hover{

	} 
	.mainmenu_txt{
		padding-top:0px;
		display: block;
		font-size: 12px;
		text-align: center;
		line-height: 15px;
		width: 100%;
		height:auto;
		color: <?=$cores[56]?> !important;
	}
	.mainmenu_img{
		display: block;
		width:100%;
		height:42px;
		text-align: center;
	}
	.mainmenu ul li img{
		max-width: 42px;
		max-height: 42px;
	}

	.mainmenu_ico{
		display: block;
		width:100%;
		height:38px;
		text-align: center;
		margin-bottom: 3px;
	}
	.mainmenu_ico i{
		font-size:34px;
		color: <?=$cores[56]?> !important;
	}

	.mainmenu ul li ul{
		position: absolute;
		top:90%;
		width:100%;
		min-width:100%;
		height: auto;
		min-height:200px;
		border-left: 1px solid <?=$cores[94]?> !important;
		border-right: 1px solid <?=$cores[94]?> !important;
		border-bottom: 1px solid <?=$cores[94]?> !important;
		border-top: 1px solid <?=$cores[94]?> !important;
		background-color: <?=$cores[61]?> !important;
		margin-left:20px;
		margin-right:20px;
		margin-top: 0px;
	}
	.mainmenu ul li ul li{
		position: relative;
		width:50%;
		height: auto;
		padding: 0px;
		margin: 0px;
		text-align: left;
		max-width: 50%;
		display: block;
		float: left; 
	}

	.mainmenu ul li ul li a{
		position: relative; 
		width: auto;
		height: auto;		
		margin-left: 25px;
		margin-right: 25px;
		text-align: left;
		display: block;
		line-height: 20px;
		padding: 0px;
		text-decoration: none;
	}
	.mainmenu ul li ul li a:hover{
		position: relative; 
		width: auto;
		height: auto; 
		margin-left: 25px;
		margin-right: 25px;
		text-align: left;
		display: block;
		line-height: 20px;
		padding: 0px;
		text-decoration: none;
		background-color:transparent;
	}
	.mainmenu ul li ul li a .mainmenu_img{
		display: none !important;
	}
	.mainmenu ul li ul li .mainmenu_txt{
		padding-left:8px;
		padding-top:8px;
		padding-bottom:8px;
		padding-right: 8px;
		margin-left: 0px;
		text-align: left; 
		background-color:transparent;
		font-size: 14px;
		color: <?=$cores[62]?> !important;
	}
	.mainmenu ul li ul li:hover{
		background-color: transparent;
	}
	.mainmenu ul li ul li .mainmenu_txt:hover{

	}

	.submenu_esq{
		float: left;
		width: 45%;
		padding-bottom: 20px;
	}
	.submenu_meio{
		float: left;
		width: 20%;
		padding-bottom: 20px;
	}
	.submenu_dir{
		float: right;
		width: 35%;
	}

	.mainmenu_titulo{
		padding-left:30px;
		padding-top:20px;
		padding-bottom:15px;
		text-align: left;
		font-size: 20px;
		color:<?=$cores[90]?>;
		font-weight:500;
		width:100%;

	}
	.mainmenu_banner{
		width:100%;
		height:auto;
		max-width: none;
		max-height: none;   
	}
	.mainmenu ul li ul img{
		width: 100%;
		height:auto;
		max-width:none;
		max-height:none;
	}

	.navbar-toggle{
		color: <?=$cores[56]?>;
	}

	.mainmenu ul li ul li .mainmenu_ico {
		display: none;
	}

	.mainmenu ul li ul li .mainmenu_img {
		display: none;
	}

	a.carrinho_pequeno{
		display: none;
	}

	@media (max-width: 1200px){

		.botao_carrinho_esq{
			margin-left: 5%;
		}

	}

	@media (max-width: 990px){

		a.botao_carrinho{
			display: none;
		}
		a.carrinho_pequeno{
			display: inline-block;
		}

		.header-bottom .col-sm-3 {
			top: 27px;
		}

		.navbar-toggle{
			background-color: transparent !important;
			margin-right: 0px;
			border-radius: 0px;
			border: 0px;
			font-size: 17px; 
			padding-bottom: 5px; 
			margin-top:7px;
		}

		.mainmenu ul li { 

		}
		.mainmenu ul li img{
			max-width:35px;
			max-height:35px;
		}
		.mainmenu ul li a{ 
			font-size: 11px;
			padding-top:10px;
			padding-bottom: 10px;
			padding-left:10px;
			padding-right:10px; 
		} 
		.mainmenu ul li ul{ 
			top: 80%;
		}

		.mainmenu_titulo{
			font-size: 18px;
		}
		.mainmenu_txt{
			display: block;
			font-size: 11px;
			text-align: center;
			line-height: 14px;
			width: 100%; 
		}
		.mainmenu_img{
			display: block;
			width:100%;
			height:40px;
			text-align: center;
		}

		.botao_carrinho_dir span{
			font-size: 14px;
		}

		.botao_conta_topo{
			font-size: 12px;
		}
		.botao_conta_topo img{
			display: none;
		}
		.topo_redes{
			background: none;
			width: 100%;
			max-width: 100%;
			margin-top: 0px;
			height: auto;
			text-align: center;
		}
		.topo_redes_triangulo{
			display: none;
		} 
		.topo_redes_item{
			font-size: 13px !important;
			padding-right: 0px;
			padding-left: 10px;
			float: none;
			display: inline-block;
		}
		.botao_conta_topo{
			padding-top:15px !important;
			padding-bottom: 15px !important;
		}

		.logo{
			text-align: center;
			margin-top:10px;
			height: auto;
		}
		.logo img{
			max-width:40%;
			max-height:none;
			height: auto;
		}

		.div_botoes_topo{
			text-align: center !important;
			width: 100%;
			padding-bottom: 10px;
		}
		a.botao_conta_topo{
			float: none;
			display: inline-block;
			padding-bottom:0px !important;
		}

		.margemtopo{
			height:260px;
		}
	}

	@media (max-width: 770px){
		
		.logo{
			text-align: center;
			margin-top:10px;
			height: auto;
		}
		.logo img{
			max-width:80%;
			max-height:none;
			height: auto;
		}

		.mainmenu ul li{
			padding-left: 0px;
			padding-right: 0px;
			padding-top:5px;
			padding-bottom:5px; 
		}
		.mainmenu ul li:last-child {
			padding-bottom: 0px;
		}

		.navbar-collapse{
			box-shadow:none; 
			margin-top:20px;
			padding-top:20px;
		}
		.texto_menu_resp {
			display: block;
		}

		.submenu_meio{
			display: none;
		}
		.navbar-toggle { 
			margin-right: 0px;
			margin-top:7px;
			border-radius: 0px;
			border: 0px;  
			font-size: 17px;
			padding-top: 5px;
			padding-bottom: 5px;
		}
		.search_box {
			margin-top: 0px;
		}

		.header-bottom .col-sm-3 {
			top: 27px;
		}

		.navbar-collapse{
			border:none !important;
			padding: 0px;
		}
		.navbar-toggle{
			background-color: transparent !important;
			margin-right: 0px;
			border-radius: 0px;
			border: 0px !important;
			font-size: 17px;
			padding-top: 5px;
			padding-bottom: 5px;
		}
		.mainmenu{
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px; 
			position: relative;
			left: 0px;
			top: 0px;
			float: none;
			text-align: left;
		}
		.mainmenu_titulo{
			display: none;
		}
		.mainmenu_img{
			display: none;
		}
		.mainmenu ul{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px; 
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto;
			float: none;
			text-align: left;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu ul li{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto;
			float: none;
			text-align: left;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu ul li:hover{
			background-color: transparent;
		}
		.mainmenu ul li:first-child{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto;
			float: none;
			text-align: left;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu ul li ul { 
			list-style: none;
			background-color: transparent !important;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto;
			float: none;
			text-align: left;
			max-width: 100% !important;
			border: none !important;
			width: 100% !important;
		}
		.mainmenu ul li ul li{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto;
			float: none;
			text-align: left;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu ul li a{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
			padding-top: 15px;
			padding-left:10px;
			padding-bottom: 20px;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu ul li a:hover{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px; 
			height: auto;  
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
			padding-top: 15px;
			padding-left:10px;
			padding-bottom: 20px;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu ul li ul li a{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
			padding-left:30px;
			padding-bottom:15px;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu ul li ul li a:hover{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
			padding-left:30px;
			padding-bottom:15px;
			max-width: 100% !important;
			width: 100% !important;
		}

		.mainmenu_txt{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
			max-width: 100% !important;
			width: 100% !important;
		}
		.mainmenu_txt:hover{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
		}

		.mainmenu ul li ul li .mainmenu_txt{
			list-style: none;
			background-color: transparent;
			border: none !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto; 
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
			max-width: 100% !important;
			width: 100% !important;
			color:<?=$cores[56]?> !important;
		}
		.mainmenu ul li ul li .mainmenu_txt:hover{
			list-style: none;
			background-color: transparent;
			border:0px !important;
			padding: 0px;
			margin:0px;
			display: block;
			position: relative;
			left: 0px;
			top: 0px;
			width: 100%;
			height: auto;
			max-width:auto
			min-width:auto;
			height: auto;
			max-height:auto;
			min-height:auto; 
			font-size: 16px;
			float: none;
			text-align: left;
			max-width: 100% !important;
			width: 100% !important;
		}
		.submenu_esq{
			padding: 0px;
			margin: 0px;
			width: 100%;
			background-color: transparent !important;
			border: none !important;
		}
		.submenu_dir{
			padding: 0px;
			margin: 0px;
			width: 100%;
			border: none !important;
		}
		.header-middle{
			padding-bottom:20px;
		}

		.busca_div{
			margin-top: 30px;
			padding-left:15px;
			padding-right: 15px;
		}
		.botao_carrinho_esq{ 
			margin-top:25px;
			font-size:32px;
		}
		.botao_carrinho_esq{
			margin-right: 0px;
			margin-left: 0px;
		}
		.topo_redes{
			text-align: center;
		}

		.div_botoes_topo{
			text-align: center;
			width: 100%;
		}
		a.botao_conta_topo{
			float: none;
			display: inline-block;
			padding-bottom:0px !important;
		}
		.botao_carrinho_dir span{
			font-size: 12px;
		}
		.botao_carrinho_dir{
			width: auto;
			margin-left: 10px;
		}
		.mainmenu ul li a.active{
			padding-left: 10px;
		}
		.mainmenu ul li a{
			padding-top:0px;
			padding-bottom:15px;
		}
		.mainmenu ul li a:hover{
			padding-top:0px;
			padding-bottom:15px;
		}
		.mainmenu_ico{
			display: none;
		}

		.topo_redes{
			display: none;
		}

	}

</style>