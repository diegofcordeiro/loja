<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div>
	<?php
	
	$fretes = "";
	
	// foreach ($frete_lista as $key => $value) {

	// 	if($value['selected']){ $select = "checked"; } else { $select = ""; }
		
	// 	$fretes .= "
	// 	<div style='padding-top:5px; '>
	// 	<input type='radio' name='frete' id='frete_".$value['id_unico']."' value='".$value['id_unico']."' onChange=\"seleciona_frete('".$value['id_unico']."', '".$carrinho['subtotal']."');\" $select style='cursor:pointer;' > <label for='frete_".$value['id_unico']."' style='font-weight:normal; cursor:pointer;' >".$value['titulo']." R$ ".$value['valor_frete_tratado']."</label>";
		
	// 	if($value['gratis_acima_de'] > 0){
	// 		$fretes .= "<span style='display:block; font-size:12px; color:#666;'>Frete grátis para compras acima de R$ ".$value['gratis_acima_de_tratado']."</span>";
	// 	}

	// 	$fretes .= "
	// 	</div>
	// 	";

	// }
	
	?>

	<!-- <div style='font-weight:bold; padding-bottom:5px; padding-top:10px;'>Selecione a forma de entrega:</div> -->

	<?php

	// if($fretes){
	// 	echo $fretes;
	// } else {
	// 	echo "Nenhuma forma de entrega está disponível para este cep.";
	// }

	?>

</div>