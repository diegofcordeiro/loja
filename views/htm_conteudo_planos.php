<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

//echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];
$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);

?>

<div id="section-planos-<?=$conteudo_id?>" class="container-fluid animate-effect" style="padding-top:50px; padding-bottom:80px; background-color: <?=$cores[44]?>; "> 

	<?php if($conteudo_config->mostrar_titulo == 1){ ?>

		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div>
					<h2 class="titulo_padrao" style="color:<?=$cores[45]?> !important; border-color:<?=$cores[45]?> !important; " ><?=$conteudo_config->titulo?></h2>
					<div class="titulo_padrao_linha" style="color:<?=$cores[45]?>; " ></div> 
				</div>
			</div>
		</div>

	<?php } ?>

	<?php if($conteudo_config->descricao){ ?>

		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div style="margin-top:20px; padding-bottom:20px; font-size: 16px; color:<?=$cores[45]?>; text-align: center;">
					<?=$conteudo_config->descricao?>
				</div>
			</div>
		</div>

	<?php } ?>

	<?php

	$planos_lista = $conteudo_sessao['lista'];

	$n_row = 1;
	foreach ($planos_lista as $key => $value) {

		if($n_row == 1){ echo "<div class='row' >"; }

		if($conteudo_config->itens_por_linha == 2){
			echo "<div class='col-xs-12 col-sm-6 col-md-6' >";
		}
		if($conteudo_config->itens_por_linha == 3){
			echo "<div class='col-xs-12 col-sm-4 col-md-4' >";
		}
		if($conteudo_config->itens_por_linha == 4){
			echo "<div class='col-xs-12 col-sm-3 col-md-3' >";
		}
		if($conteudo_config->itens_por_linha == 6){
			echo "<div class='col-xs-12 col-sm-2 col-md-2' >";
		}

		if($value['img_fundo']){
			$imgfundoplano = " background-image:url(".PASTA_CLIENTE."imagens/".$value['img_fundo']."); border-radius:6px; ";
			$imgplano = "<img src='".PASTA_CLIENTE."imagens/".$value['img_fundo']."' style='width:100%; margin-left:-100%; height:auto; opacity:0; float:left; ' class='".$classes_css_img."' >";
		} else {
			$imgfundoplano = "";
			$imgplano = "";
		}

		echo "
		<div class='planos_div $classes_css' style='background-color:".$cores['80']." !important; ".$imgfundoplano." ' >
		$imgplano
		<div style='float:left; width:100%; height:auto; padding: 20px;'>
		";
		
		if($conteudo_config->plano_titulo == 1){
			echo "
			<div class='planos_titulo' >".$value['titulo']."</div>
			";
		}
		if($conteudo_config->plano_valor == 1){
			echo "
			<div class='planos_valor' style='color:".$cores['82']."; ' ><span style='font-size:14px;'>R$</span> ".$value['valor']."</div>
			";
		}

		if($conteudo_config->plano_itens == 1){

			echo "
			<hr>
			<ul class='planos_itens'>
			";

			foreach ($value['itens'] as $key2 => $value2) {

				if($value2['tipo'] == 1){
					$ico = "<i class='fa fa-check'></i>";
					$cor = $cores[76];
				} else {
					$ico = "<i class='fa fa-times'></i>";				
					$cor = $cores[77];
				}

				echo "
				<li style='color:".$cor." !important;' ><span>$ico</span> ".$value2['titulo']."</li>						
				";

			}

			echo "
			</ul>
			<hr style='padding-bottom:25px;'>
			";

		}

		if($value['tipo'] == 0){
			$botao = "<div style='position:absolute; bottom:15px; left:0px; width:100%;'>".str_replace("aquivaiolink", " href='".$value['endereco']."' ", $conteudo_sessao['botao'])."</div>";
		} else {
			$linkbt = " onClick=\"window.location='".DOMINIO.$controller."/carrinho_adicionar_plano/id/".$value['codigo']."';\" ";
			$botao = "<div style='position:absolute; bottom:15px; left:0px; width:100%;'>".str_replace("aquivaiolink", $linkbt, $conteudo_sessao['botao'])."</div>";
		}

		echo $botao;
		echo "
		</div>
		<div style='clear:both;'></div>
		</div>
		</div>
		";


		if($n_row == $conteudo_config->itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

	}
	if($n_row != 1){ echo "</div>"; }

	?>

</div> 