<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<?php
//echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];

$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);

?>

<div id="section-news-email-<?=$conteudo_id?>" class="container-fluid animate-effect" style="background-color:<?=$cores[10]?> !important; color:<?=$cores[11]?> !important; padding-bottom:50px; ">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" > 
			<div class="news_texto" style="color:<?=$cores[11]?> !important;">	
				<?=$conteudo_sessao['descricao']?>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-xs-12 col-sm-5 col-md-5" > 
			<input type="text" name="news_nome_<?=$conteudo_id?>" id="news_nome_<?=$conteudo_id?>" class="form_news <?=$classes_css?>" placeholder="Digite seu nome">
		</div>

		<div class="col-xs-12 col-sm-5 col-md-5" > 
			<input type="text" name="news_email_<?=$conteudo_id?>" id="news_email_<?=$conteudo_id?>" class="form_news <?=$classes_css?>" placeholder="Digite seu e-mail">
		</div>

		<div class="col-xs-12 col-sm-2 col-md-2" > 

			<div class="botao_padrao_div">
				<?php

				$botao = str_replace("aquivaiolink", " onclick=\"cadastro_news_".$conteudo_id."();\" ", $conteudo_sessao['botao']);

				echo $botao;
				?>
			</div>

		</div>

	</div>

</div>