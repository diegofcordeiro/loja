<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

// echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);


// echo '
// <div style="position:relative;" >

// <div id="banner-'.$conteudo_id.'" class="callbacks_container" style="width: 100%; overflow: hidden;">
// <ul class="rslides" id="slider_'.$conteudo_id.'">
// ';

// foreach ($conteudo_sessao['lista'] as $key => $value) {

// 	if($value['link']){
// 		$endereco = " onClick=\"window.open('".$value['link']."', '_blank');\" ";
// 	} else {
// 		$endereco = "";
// 	}
	
// 	echo "
// 	<li ".$endereco." >
// 	<div class='banner_personal' >
	
// 	<div class='frase_banner ".$classes_css."'>
// 	<div class='container'>
// 	<div class='row'>
// 	<div class='col-xs-12 col-sm-12 col-md-12' >	
	
// 	".$value['texto']."
// 	<div style='text-align:".$value['botao_alinhamento']."'>
// 	".$value['botao']."
// 	</div>

// 	</div>
// 	</div>
// 	</div>
// 	</div>
	
// 	<img src='".$value['imagem']."' class='".$classes_css_img."' >
// 	</div>
// 	</li>
// 	";
	
// }

// echo '
// </ul>

// </div>
// <div class="clearfix"></div>

// </div>
// ';
?>
<!-- 
<div class="jumbotron banner_canal" style="background-image: url(<?=DOMINIO."arquivos/".$banner?>);">
<div class="jumbotron banner_canal banner_index" style="background-image: url(<?=DOMINIO."arquivos/".$banner?>);">
    <div class="container" style="width: 80%;padding-top: 40px;">
        <p class="bem_vindo_canal">CURSO DE LIDERANÇA</p>
        <p class="canal_do">desconto de 50%</p>
        <h1 class="display-3 nome_do_canal">Liderança com Fulana de Tal</h1>
    </div>
</div> 
<div class="et_pb_bottom_inside_divider"></div> -->
