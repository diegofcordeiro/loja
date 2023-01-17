<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

// echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];

include('htm_css_rodape_'.$conteudo_sessao['data_rodape']->modelo.'.php');

// if($conteudo_sessao['data_rodape']->imagem_fundo){
// 	$fundo_rodape = PASTA_CLIENTE.'img_rodape/'.$conteudo_sessao['data_rodape']->imagem_fundo;
// 	echo "
// 	<style>
// 	.rodape{
// 		background-image:url(".$fundo_rodape.");
// 		background-size: cover; background-position: bottom; background-repeat: no-repeat;
// 	}
// 	</style>
// 	";
// }

if($conteudo_sessao['data_rodape']->font_family){ 
	echo "
	<style>
	.rodape{
		font-family: ".$conteudo_sessao['data_rodape']->font_family." !important;
	}
	</style>
	";
}

$botao_aviso = $conteudo_sessao['botao_aviso'];

?>
<link href="<?=LAYOUT?>css/custom.css" rel="stylesheet" type="text/css" />
<?php if($conteudo_sessao['data_rodape']->modelo == 1){ ?>

	<footer class="rodape"  >
		<!-- <div class="container">
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-8" >
					<div class="footer-grid">
						<h3 style="font-weight: bold">ACESSO RÁPIDO</h3>
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<ul>
									<?php

									//calcula quantos itens por coluna
									$itens = count($conteudo_sessao['menu']);
									$porcoluna = round($itens/2);

									//lista colunas
									$n = 1;
									foreach ($conteudo_sessao['menu'] as $key => $value) {
										if($n <= $porcoluna){

											echo "<li><a href='".$value['destino']."' >".$value['titulo']."</a></li>";

										}
										$n++;
									}
									?>
								</ul>				  
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<ul>
									<?php
									//lista colunas
									$n = 1;
									foreach ($conteudo_sessao['menu'] as $key => $value) {
										if($n > $porcoluna){

											echo "<li><a href='".$value['destino']."' >".$value['titulo']."</a></li>";

										}
										$n++;
									}
									?>
								</ul>
							</div>
						</div>
					</div>
					<div style="clear: both;"></div>
				</div>

				<div class="col-xs-12 col-sm-1 col-md-1" >
				</div>

				<div class="col-xs-12 col-sm-3 col-md-3">
					<div class="footer-grid">
						<h3 style="font-weight: bold">Fale Conosco</h3>
					</div>

					<div class='rodape_contatos'>

						<span style="font-weight: bold;"><?=$conteudo_sessao['data_rodape']->endereco1?></span>
						<span style="font-weight: bold;"><?=$conteudo_sessao['data_rodape']->endereco2?></span>

						<span style="margin-top:10px;"><?=$conteudo_sessao['data_rodape']->email?></span>
						<span><?=$conteudo_sessao['data_rodape']->fone1?></span>
						<span><?=$conteudo_sessao['data_rodape']->fone2?></span>

					</div>

					<div>
						<?php
						$listaredes = $_base['redessociais'];
						foreach ($listaredes as $key => $value) {

							echo "
							<div class='redessociais hvr-float-shadow'>
							<a href='".$value['endereco']."' target='_blank' >
							<img src='".$value['imagem']."'>
							</a>
							</div>
							";

						}

						?>
						<div style="clear: both;"></div>
					</div>

				</div>

			</div>
			<div style="width: 100%; padding-top:30px;"></div>
		</div>

		<div class="rodape_copy" >
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12" >					
						<a href="https://temdetudoprogramas.com/" target="_blank" ><?=$conteudo_sessao['data_rodape']->copy?></a>
					</div>
				</div>
			</div>
		</div> -->

	</footer>

	<?php
	if( (!isset($_SESSION['cookies'])) AND ($conteudo_sessao['data_rodape']->mostrar_aviso == 1) ){
		?>
		<div class="fot-fixd politica_cookies" style="background-color: <?=$primaria?>; color:<?=$cores['21']?>; " ><div class="fot-fixd-msg"><?=$conteudo_sessao['data_rodape']->aviso_conteudo?></div><div class="fot-fixd-box clearfix"><?=$botao_aviso?></div></div>
		<?php
	}
	?>

<?php } ?>


<?php if($conteudo_sessao['data_rodape']->modelo == 3){ ?>

	<footer class="rodape" >
		<div class="container cont_rodape">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4" >
					<?php if($conteudo_sessao['data_rodape']->imagem_fundo){ 
						$fundo_rodape = PASTA_CLIENTE.'img_rodape/'.$conteudo_sessao['data_rodape']->imagem_fundo;
					?>
							<img class="logo_rodape_new" src="<?=$fundo_rodape?>" alt="">
					<?php } ?>
					<div style="margin-top: 15px;">
						<?php if($conteudo_sessao['data_rodape']->insta){ ?>
								<a href="<?=$conteudo_sessao['data_rodape']->insta?>"><i class="fab fa-instagram icon_footer"></i></a>
						<?php } ?>
						<?php if($conteudo_sessao['data_rodape']->face){ ?>
								<a href="<?=$conteudo_sessao['data_rodape']->face?>"><i class="fab fa-facebook-square icon_footer"></i></a>
						<?php } ?>
						<?php if($conteudo_sessao['data_rodape']->youtube){ ?>
								<a href="<?=$conteudo_sessao['data_rodape']->youtube?>"><i class="fab fa-youtube icon_footer"></i></a>
						<?php } ?>
						<?php if($conteudo_sessao['data_rodape']->linkedin){ ?>
								<a href="<?=$conteudo_sessao['data_rodape']->linkedin?>"><i class="fab fa-linkedin icon_footer"></i></a>
						<?php } ?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4" >
					<h4 style="color:white">Contato</h4>
					<div class='rodape_contatos'>

						<span><?=$conteudo_sessao['data_rodape']->fone1?></span>
						<span><?=$conteudo_sessao['data_rodape']->fone2?></span>
						<span style="margin-top:10px;"><?=$conteudo_sessao['data_rodape']->email?></span>
						<br>
						<span style="font-weight: bold;"><?=$conteudo_sessao['data_rodape']->endereco1?></span>
						<span style="font-weight: bold;"><?=$conteudo_sessao['data_rodape']->endereco2?></span>


					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4" >
					<div class='rodape_contatos'>
						<span><?=$conteudo_sessao['data_rodape']->sobre_a_empresa?></span>
					</div>
				</div>
			</div>
			<div style="color: white;text-align: center;padding: 40px 0px 20px 0px;">
				<?=$conteudo_sessao['data_rodape']->copy?>	
			</div>
		</div>
	</footer>

	<?php
	if( (!isset($_SESSION['cookies'])) AND ($conteudo_sessao['data_rodape']->mostrar_aviso == 1) ){
		?>
		<div class="fot-fixd politica_cookies" style="background-color: <?=$cores['20']?>; color:<?=$cores['23']?>; " >
			<div class="fot-fixd-msg">
				<?=$conteudo_sessao['data_rodape']->aviso_conteudo?>
			</div>
		<div class="fot-fixd-box clearfix">
			<?=$botao_aviso?>
		</div>
	</div>
		<?php
	}
	?>

<?php } ?>


<script type="text/javascript">
	function aceitar_cokies(){
		$.post('<?=DOMINIO?>index/cookies_aceitar', {token: '<?=time()?>'},function(data){
			if(data){
				$('.politica_cookies').hide();
			}
		});
	}
</script>


<?php if($conteudo_sessao['data_rodape']->mostrar_whats == 1){ ?>

	
	<!-- START Widget WhastApp -->
	<a href="https://wa.me/55<?=$conteudo_sessao['data_rodape']->whatsapp?>" class="bt-whatsApp" target="_blank" style="left:25px; position:fixed;width:60px;height:60px;bottom:40px;z-index:100;">
		<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSI3MiIgdmlld0JveD0iMCAwIDcyIDcyIiB3aWR0aD0iNzIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMzYsNzIgTDM2LDcyIEM1NS44ODIyNTEsNzIgNzIsNTUuODgyMjUxIDcyLDM2IEw3MiwzNiBDNzIsMTYuMTE3NzQ5IDU1Ljg4MjI1MSwtMy42NTIzMTAyNmUtMTUgMzYsMCBMMzYsMCBDMTYuMTE3NzQ5LDMuNjUyMzEwMjZlLTE1IC0yLjQzNDg3MzVlLTE1LDE2LjExNzc0OSAwLDM2IEwwLDM2IEMyLjQzNDg3MzVlLTE1LDU1Ljg4MjI1MSAxNi4xMTc3NDksNzIgMzYsNzIgWiIgZmlsbD0iIzAxRTY3NSIvPjxwYXRoIGQ9Ik0zNS45OTMwMzM1LDEyIEwzNS45OTMwMzM1LDEyLjAwMDM5ODIgTDM2LjAwNjk2NjUsMTIuMDAwMzk4MiBDNDkuMjM3NzQ4NSwxMi4wMDAzOTgyIDYwLDIyLjc2NTY4NTMgNjAsMzYuMDAwMTk5MSBDNjAsNDkuMjM0MzE0NyA0OS4yMzc3NDg1LDYwIDM2LjAwNjk2NjUsNjAgQzMxLjEyNjQzMzcsNjAgMjYuNTk4NjA1LDU4LjU0Njk3NDkgMjIuODA0NDQ4Niw1Ni4wMzU1MzkyIEwxMy41Nzk2MDQ3LDU4Ljk4Mzc5ODMgTDE2LjU3MDAyNTgsNTAuMDY2OTQ3MSBDMTMuNjkyNjYxMSw0Ni4xMTYwMjUgMTIsNDEuMjQ4NDUwOCAxMiwzNS45OTk4MDA5IEMxMiwyMi43NjUyODcxIDIyLjc2MjI1MTUsMTIgMzUuOTkzMDMzNSwxMiBaIE0yOS4yOTI4NTAyLDI0LjE5MDgzNjUgQzI4LjgyNzQ4NzgsMjMuMDc2Mjc5OCAyOC40NzQ3ODM3LDIzLjAzNDA3MDggMjcuNzY5NzczNywyMy4wMDU0MDA2IEMyNy41Mjk3Mjc5LDIyLjk5MTQ2MzYgMjcuMjYyMjE0MiwyMi45Nzc1MjY3IDI2Ljk2NTY0MDIsMjIuOTc3NTI2NyBDMjYuMDQ4NDUwNCwyMi45Nzc1MjY3IDI1LjA4OTQ2MTUsMjMuMjQ1NTE0IDI0LjUxMTA0MjcsMjMuODM4MDMyOSBDMjMuODA2MDMyNywyNC41NTc1NzcgMjIuMDU2ODQzMywyNi4yMzYzODA0IDIyLjA1Njg0MzMsMjkuNjc5MjAxNiBDMjIuMDU2ODQzMywzMy4xMjIwMjI4IDI0LjU2NzU3MDksMzYuNDUxNzU1OCAyNC45MDU5NDM5LDM2LjkxNzY0NzYgQzI1LjI1ODY0OCwzNy4zODI3NDMxIDI5LjgwMDgwNzgsNDQuNTUwMzA5OCAzNi44NTMyOTcxLDQ3LjQ3MTQ5MTUgQzQyLjM2ODM3ODcsNDkuNzU3MTQ4OSA0NC4wMDQ5MDk3LDQ5LjU0NTMwNzUgNDUuMjYwMDc0NSw0OS4yNzczMjAxIEM0Ny4wOTM2NTgsNDguODgyMzA3NiA0OS4zOTMwMDIsNDcuNTI3MjM5MiA0OS45NzE0MjA4LDQ1Ljg5MTA0MyBDNTAuNTQ5ODM5NSw0NC4yNTQwNTA0IDUwLjU0OTgzOTUsNDIuODU3MTcxMyA1MC4zODAyNTQ5LDQyLjU2MDkxMTkgQzUwLjIxMTA2ODQsNDIuMjY0NjUyNCA0OS43NDUzMDgsNDIuMDk1ODE2NCA0OS4wNDAyOTc5LDQxLjc0MjYxNDcgQzQ4LjMzNTI4NzgsNDEuMzg5ODExMSA0NC45MDczNzA0LDM5LjY5NjY3MjYgNDQuMjU4NDkwNCwzOS40NzA4OTQyIEM0My42MjM1NDM1LDM5LjIzMTE3ODkgNDMuMDE3MjU4NywzOS4zMTU5OTUxIDQyLjUzNzk2MzMsMzkuOTkzMzMwMiBDNDEuODYwODE5Miw0MC45Mzg2NTI2IDQxLjE5ODAwNjMsNDEuODk4MzEwMSA0MC42NjE3ODQ2LDQyLjQ3NjQ5MzkgQzQwLjIzODYxOTMsNDIuOTI4MDUwNiAzOS41NDcxNDQxLDQyLjk4NDU5NDcgMzguOTY5MTIzNSw0Mi43NDQ0ODEyIEMzOC4xOTMyNTQxLDQyLjQyMDM0NzkgMzYuMDIxMjk3Niw0MS42NTc3OTg1IDMzLjM0MDk4NTQsMzkuMjczMzg3OSBDMzEuMjY3MzU2MSwzNy40MjUzNTAzIDI5Ljg1NjkzNzksMzUuMTI1NzU2IDI5LjQ0ODEwMzcsMzQuNDM0NDg0IEMyOS4wMzg4NzE0LDMzLjcyOTI3NSAyOS40MDU5MDY2LDMzLjMxOTUyOTEgMjkuNzI5OTQ4NSwzMi45Mzg4NTE3IEMzMC4wODI2NTI2LDMyLjUwMTIzMTkgMzAuNDIxMDI1NiwzMi4xOTEwMzU2IDMwLjc3MzcyOTYsMzEuNzgxNjg3OSBDMzEuMTI2NDMzNywzMS4zNzI3Mzg0IDMxLjMyMzg4NDMsMzEuMTYwODk2OSAzMS41NDk1OTksMzAuNjgxMDY4MiBDMzEuNzg5NjQ0OCwzMC4yMTU1NzQ1IDMxLjYyMDA2MDIsMjkuNzM1NzQ1OCAzMS40NTA4NzM3LDI5LjM4Mjk0MjIgQzMxLjI4MTY4NzIsMjkuMDMwMTM4NiAyOS44NzEyNjksMjUuNTg3MzE3NCAyOS4yOTI4NTAyLDI0LjE5MDgzNjUgWiIgZmlsbD0iI0ZGRiIvPjwvZz48L3N2Zz4=" alt="" width="60px">
	</a>
	<span id="alertWapp" style="left:30px; visibility: hidden; position:fixed;	width:17px;	height:17px;bottom:90px; background:red;z-index:101; font-size:11px;color:#fff;text-align:center;border-radius: 50px; font-weight:bold;line-height: normal; "> 1 </span>
	<div id="msg1" style="left: 90px; visibility: visible; background: #1EBC59; color: #fff; position: fixed; width: 200px; bottom: 52px; text-align: center; font-size: 13px; line-height: 31px; height: 32px; border-radius: 100px; z-index: 100; ">Atendimento Via WhatsApp</div>
	<script type="text/javascript">function showIt2() {document.getElementById("msg1").style.visibility = "visible";}    setTimeout("showIt2()", 5000); function hiddenIt() {document.getElementById("msg1").style.visibility = "hidden";}setTimeout("hiddenIt()", 15000); function showIt3() {document.getElementById("msg1").style.visibility = "visible";} setTimeout("showIt3()", 25000);  msg1.onclick = function() {document.getElementById('msg1').style.visibility = "hidden"; };function alertW() { document.getElementById("alertWapp").style.visibility = "visible";	} setTimeout("alertW()", 15000); </script>
	<!-- END Widget WhastApp -->
	<!-- Chatra {literal} -->
		<script>
		$("#meus_cursos").click(function(e){
			e.preventDefault();
			var Cp    = <?='AK'?>;
			var code_ = <?=$_SESSION['usuario_cpf']?>;
			var url_webapp = "<?=URL_BASE?>webapp/integra.php?token=<?=base64_encode($_SESSION['usuario_cpf'])?>";
			window.location.replace(url_webapp);
		});
		
	</script>
	<script>
		(function(d, w, c) {
			w.ChatraID = 'w52CkKrYBvgrmLsAn';
			var s = d.createElement('script');
			w[c] = w[c] || function() {
				(w[c].q = w[c].q || []).push(arguments);
			};
			s.async = true;
			s.src = 'https://call.chatra.io/chatra.js';
			if (d.head) d.head.appendChild(s);
		})(document, window, 'Chatra');
	</script>
	<!-- /Chatra {/literal} -->


	<?php } ?>