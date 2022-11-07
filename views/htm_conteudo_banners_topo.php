<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

echo '
<div id="banner-'.$conteudo_id.'" class="callbacks_container banner_topo" >
<ul class="rslides" id="slider_topo_'.$conteudo_id.'">
';

foreach ($banners_topo as $key => $value) {

	if($value['link']){
		$endereco = " onClick=\"window.open('".$value['link']."', '_blank');\" ";
	} else {
		$endereco = "";
	}
	
	echo "
	<li ".$endereco." > 
	<img src='".$value['imagem']."' > 
	</li>
	";
	
}

echo '
</ul>
</div>
';