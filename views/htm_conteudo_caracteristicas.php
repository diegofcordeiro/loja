<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

//echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];
$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);

?>

<style type="text/css">
	#section-caracteristicas-<?=$conteudo_id?> .caracteristicas_icone i{
		color:<?=$cores[23]?>;
	}
	#section-caracteristicas-<?=$conteudo_id?> .caracteristicas_titulo{
		color:<?=$cores[23]?>
	}
	#section-caracteristicas-<?=$conteudo_id?> .caracteristicas_descricao{
		color:<?=$cores[23]?>
	} 
</style>

<!-- <div id="section-caracteristicas-<?=$conteudo_id?>" class="container-fluid animate-" style="padding-top:5px; padding-bottom:10px; background-color: <?=$cores[22]?>; ">

	<?php if($conteudo_config->mostrar_titulo == 1){ ?>

		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div>
					<h2 class="titulo_padrao" style="color:<?=$cores[23]?> !important; border-color:<?=$cores[23]?> !important; " ><?=$conteudo_config->titulo?></h2>
					<div class="titulo_padrao_linha" style="color:<?=$cores[23]?>; " ></div> 
				</div>
			</div>
		</div>

	<?php } ?>

	<?php if($conteudo_config->descricao){ ?>

		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div style="margin-top:30px; padding-bottom: 20px; font-size: 16px; color:<?=$cores[23]?>; text-align: center;">
					<?=$conteudo_config->descricao?>
				</div>
			</div>
		</div>

	<?php } ?>

	<?php

	$caracteristicas_lista = $conteudo_sessao['lista'];

	$n_row = 1;
	foreach ($caracteristicas_lista as $key => $value) {

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
		echo " 
		<div class='caracteristicas_div $classes_css' style='text-align:".$value['alinhamento'].";' >		
		";

		if($conteudo_config->ordem_itens == 1){

			if($value['imagem']){
				echo "<div class='caracteristicas_img' style='text-align:".$value['alinhamento'].";' ><img src='".$value['imagem']."' class='".$classes_css_img."' ></div>";
			}
			if($value['icone']){
				echo "<div class='caracteristicas_icone' style='margin-top:15px;' >".$value['icone']."</div>";
			}

			echo "
			<div class='caracteristicas_titulo' style='margin-top:16px;' >".$value['titulo']."</div>
			<div class='caracteristicas_descricao' style='margin-top:0px;' >".$value['descricao']."</div>
			";
		}

		if($conteudo_config->ordem_itens == 2){

			echo "<div class='caracteristicas_titulo' >".$value['titulo']."</div>";

			if($value['imagem']){
				echo "<div class='caracteristicas_img' style='margin-top:15px;' ><img src='".$value['imagem']."' class='".$classes_css_img."'></div>";
			}
			if($value['icone']){
				echo "<div class='caracteristicas_icone' style='margin-top:15px;' >".$value['icone']."</div>";
			}

			echo "<div class='caracteristicas_descricao' style='margin-top:15px;' >".$value['descricao']."</div>";

		}

		if($conteudo_config->ordem_itens == 3){

			echo "<div class='caracteristicas_descricao' >".$value['descricao']."</div>";

			echo "<div class='caracteristicas_titulo' style='margin-top:15px;' >".$value['titulo']."</div>";

			if($value['imagem']){
				echo "<div class='caracteristicas_img' style='margin-top:15px;' ><img src='".$value['imagem']."' class='".$classes_css_img."' ></div>";
			}
			if($value['icone']){
				echo "<div class='caracteristicas_icone' style='margin-top:15px;' >".$value['icone']."</div>";
			}			 

		}

		if($conteudo_config->ordem_itens == 4){

			echo "<div class='caracteristicas_titulo' >".$value['titulo']."</div>";

			echo "<div class='caracteristicas_descricao' style='margin-top:15px;' >".$value['descricao']."</div>";

			if($value['imagem']){
				echo "<div class='caracteristicas_img' style='margin-top:15px;' ><img src='".$value['imagem']."' class='".$classes_css_img."' ></div>";
			}
			if($value['icone']){
				echo "<div class='caracteristicas_icone' style='margin-top:15px;' >".$value['icone']."</div>";
			}
			
		}


		echo "
		</div>
		</div>
		";

		if($n_row == $conteudo_config->itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

	}
	if($n_row != 1){ echo "</div>"; }

	?>

</div> -->