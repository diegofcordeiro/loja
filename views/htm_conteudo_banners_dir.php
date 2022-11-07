<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<?php

foreach ($banners_direita as $key => $value) {
	
	if($value['link']){
		$endereco = " onClick=\"window.open('".$value['link']."', '_blank');\" style='cursor:pointer;' ";
	} else {
		$endereco = "";
	}
	
	echo "
	
	<div class='banner_lateral' $endereco >
	<img src='".$value['imagem']."' style='max-width:100%;'>
	</div>
	";
	
}
