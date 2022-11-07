<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

// echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];
$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);

?>

<div id="section-caracteristicas-<?=$conteudo_id?>" class="container-fluid animate-effect $classes_css" style="padding-top:50px; padding-bottom:80px; background-color: <?=$cores[58]?>; "> 
	
	<?php if($conteudo_config->mostrar_titulo == 1){ ?>

		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div>
					<h2 class="titulo_padrao" style="color:<?=$cores[59]?> !important; border-color:<?=$cores[59]?> !important; " ><?=$conteudo_config->titulo?></h2>
					<div class="titulo_padrao_linha" style="color:<?=$cores[59]?>; " ></div> 
				</div>
			</div>
		</div>

	<?php } ?>

	<?php if($conteudo_config->enquadramento == 1){ ?>

		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div><?=htmlspecialchars_decode(base64_decode($conteudo_config->conteudo));?></div>
			</div>
		</div>

	<?php } ?>

</div>

<?php if($conteudo_config->enquadramento == 0){ ?>
	<div class='$classes_css'>
		<?=htmlspecialchars_decode(base64_decode($conteudo_config->conteudo));?>
	</div>
	<?php } ?>