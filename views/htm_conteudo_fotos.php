<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

// echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];
$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);

$categorias = $conteudo_sessao['categorias'];

?>
<style type="text/css">
	.fotos2_titulo{
		color:<?=$cores['41']?>;
	}	
</style>

<div id="section-fotos-<?=$conteudo_id?>" class="container-fluid animate-effect" style="padding-top:50px; padding-bottom:80px; background-color: <?=$cores['40']?>; ">

	<?php if($conteudo_config->mostrar_titulo == 1){ ?>

		<div class='row' >
			<div class='col-xs-12 col-sm-12 col-md-12' >
				<div>
					<h2 class="titulo_padrao" style="color:<?=$cores[41]?> !important; border-color:<?=$cores[41]?> !important; " ><?=$conteudo_config->titulo?></h2>
					<div class="titulo_padrao_linha" style="color:<?=$cores[41]?>; " ></div> 
				</div>
			</div>
		</div>

	<?php } ?>

	<?php

	$lista = $conteudo_sessao['lista'];



	if($conteudo_config->mostrar_categorias == 0){

		if($conteudo_config->formato == 'imagens'){

				// imagens aleatorias clicar e ampliar

			echo "<div style='width:100%; margin-bottom:30px;' class='ampliar_imagem' >";

			$n_row = 1;
			$total_n = 1;
			foreach ($lista as $key => $value) {
				if($total_n <= $conteudo_config->max_itens){

					if($n_row == 1){ echo "<div class='row' style='padding-left:15px; padding-right:15px;' >"; }

					if($conteudo_config->itens_por_linha == 1){
						echo "<div class='col-xs-12 col-sm-12 col-md-12' style='padding-left:0px; padding-right:0px;' >";
					}
					if($conteudo_config->itens_por_linha == 2){
						echo "<div class='col-xs-12 col-sm-6 col-md-6' style='padding-left:0px; padding-right:0px;' >";
					}
					if($conteudo_config->itens_por_linha == 3){
						echo "<div class='col-xs-12 col-sm-4 col-md-4' style='padding-left:0px; padding-right:0px;' >";
					}
					if($conteudo_config->itens_por_linha == 4){
						echo "<div class='col-xs-12 col-sm-3 col-md-3' style='padding-left:0px; padding-right:0px;' >";
					}

					echo " 
					<a class='fotos1_div' style='background-image:url(".$value.");' href='".$value."' ></a>
					</div>
					";

					$total_n++;

					if($n_row == $conteudo_config->itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

				}
			}
			if($n_row != 1){ echo "</div>"; }

			echo "</div>";

		} else {

				// albuns clicar e abrir nova pagina

			$n_row = 1;
			$total_n = 1;
			foreach ($lista as $key => $value) {
				if($total_n <= $conteudo_config->max_itens){

					if($n_row == 1){ echo "<div class='row' >"; }

					if($conteudo_config->itens_por_linha == 1){
						echo "<div class='col-xs-12 col-sm-12 col-md-12' >";
					}
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
					<a class='fotos2_div $classes_css' style='background-image:url(".$value['imagem'].");' href='".DOMINIO.$controller."/fotos_detalhes/codigo/".$value['codigo']."' ></a>
					<a class='fotos2_titulo' href='".DOMINIO.$controller."/fotos_detalhes/codigo/".$value['codigo']."' >".$value['titulo']."</a>

					</div>
					";

					$total_n++;

					if($n_row == $conteudo_config->itens_por_linha){ echo "</div>"; $n_row = 1; } else { $n_row++; }

				}
			}
			if($n_row != 1){ echo "</div>"; }

		}


	} else {

			// aqui com categorias

		?>

		<div class="row">

			<?php if($conteudo_config->tipo_menu == 0){ $tipo = ''; ?>				
			<div class="col-sm-4">
			<?php } else { $tipo = '_topo'; ?>
			<div class="col-sm-12">
			<?php } ?>

			<div style="margin-top: 30px; background-color:<?=$cores['97']?>; padding-left:20px; padding-right: 20px; padding-bottom: 20px; padding-top: 10px;  <?php if($conteudo_config->tipo_menu == 1){ echo "text-align:center;";  } ?> ">
				<?php

				$primeiras_fotos = '';
				$n_fot = 0;
				foreach ($categorias as $key => $value) {

					if($n_fot == 0){
						$primeiras_fotos = $value['codigo'];

						if($conteudo_config->tipo_menu == 1){ 
							$borderleft = "border-left:1px solid ".$cores['98']."; padding-left: 10px; ";
						} else {
							$borderleft = "";
						}

					} else {
						$borderleft = "";
					}

					if($conteudo_config->tipo_menu == 1){ 
						$borderright = " border-right:1px solid ".$cores['98']."; ";
					} else {
						$borderright = "";
					}

					echo "
					<a class='fotos_categorias".$tipo."' style='color:".$cores['98']."; ".$borderleft."".$borderright." '  onclick=\"fotos_categoria_".$conteudo_id."('".$value['codigo']."');\"  >".$value['titulo']."</a>
					";

					$n_fot++;
				}

				?>
			</div>
		</div>

		<?php if($conteudo_config->tipo_menu == 0){ ?>
			<div class="col-sm-8">
			<?php } else { ?>
				<div class="col-sm-12">
				<?php } ?>

				<div id="fotos_div-<?=$conteudo_id?>" >

				</div>

			</div>

		</div>


		<?php

	}





	?>

</div>