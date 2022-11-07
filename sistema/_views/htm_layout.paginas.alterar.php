<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
	<title><?=$_titulo?> - <?=TITULO_VIEW?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css"> 
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

	<?php include_once('css.php'); ?>

	<style type="text/css">
	.item_ordem_div1{
		display: block;
	}
	.item_ordem_div2{
		display: none;
	}
</style>

</head>
<body class="hold-transition skin-blue <?php if($_base['menu_fechado'] == 1){ echo "sidebar-collapse"; } ?> sidebar-mini">
	<div class="wrapper">

		<?php require_once('htm_modal.php'); ?>

		<?php require_once('htm_topo.php'); ?>

		<?php require_once('htm_menu.php'); ?>

		<div class="content-wrapper">

			<section class="content-header">
				<h1>
					<?=$_titulo?>
					<small><?=$_subtitulo?></small>
				</h1> 
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="row">

					<div class="col-xs-12">

						<div class="nav-tabs-custom">

							<ul class="nav nav-tabs ">
								
								<li <?php if($aba_selecionada == "dados"){ echo "class='active'"; } ?> >
									<a href="#dados" data-toggle="tab">Dados</a>
								</li>
								<li <?php if($aba_selecionada == "conteudos"){ echo "class='active'"; } ?> >
									<a href="#conteudos" data-toggle="tab">Conteúdo</a>
								</li>
								<li <?php if($aba_selecionada == "cores"){ echo "class='active'"; } ?> >
									<a href="#cores" data-toggle="tab">Cores</a>
								</li>

							</ul>

							<div class="tab-content" >

								<div id="dados" <?php if($aba_selecionada == "dados"){ echo "class='tab-pane active'"; } else { echo "class='tab-pane'"; } ?> >

									<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">

										<fieldset>

											<div class="form-group">
												<label class="col-md-12" >Titulo</label>
												<div class="col-md-6">
													<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" />
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-12" >Url amigavel, sem acentos ou espaços, ex: nossos_servicos.</label>
												<div class="col-md-6">
													<?php if($data->chave == 'index'){ ?>
														<input name="chave2" type="text" class="form-control" value="<?=$data->chave?>" disabled=""; />
														<input name="chave" type="hidden" class="form-control" value="<?=$data->chave?>" />
													<?php } else { ?>
														<input name="chave" type="text" class="form-control" value="<?=$data->chave?>"  />
													<?php } ?>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-12">Status</label>
												<div class="col-md-3">
													<select name="status" class="form-control select2" style="width: 100%;" >
														<option value="0" <?php if($data->status == 0){ echo "selected"; } ?> >Inativo</option>
														<option value="1" <?php if($data->status == 1){ echo "selected"; } ?> >Ativo</option>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-12">Bloquear botão direito do mouse</label>
												<div class="col-md-3">
													<select name="bloqueio" class="form-control select2" style="width: 100%;" >
														<option value="0" <?php if($data->bloqueio == 0){ echo "selected"; } ?> >Inativo</option>
														<option value="1" <?php if($data->bloqueio == 1){ echo "selected"; } ?> >Ativo</option>
													</select>
												</div>
											</div>

											<hr>

											<div class="form-group">
												<label class="col-md-12" >Meta Titulo</label>
												<div class="col-md-6">
													<input name="meta_titulo" type="text" class="form-control" value="<?=$data->meta_titulo?>" />
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-12" >Meta Descrição</label>
												<div class="col-md-6">
													<textarea name="meta_descricao" class="form-control" style="height:60px;" ><?=$data->meta_descricao?></textarea>
												</div>
											</div>
											
										</fieldset>

										<div style="margin-top: 15px; margin-left:5px;">
											<button type="submit" class="btn btn-primary">Salvar</button>
											<input type="hidden" name="codigo" value="<?=$data->codigo?>" />

											<?php if($data->chave != 'index'){ ?>
												<button type="button" class="btn btn-danger" onClick="confirma('<?=$_base['objeto']?>apagar_pagina/codigo/<?=$data->codigo?>');">Remover Página</button>
											<?php } ?>

											<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>
										</div>

									</form>

								</div>

								<div id="conteudos" <?php if($aba_selecionada == "conteudos"){ echo "class='tab-pane active'"; } else { echo "class='tab-pane'"; } ?> >


									<div style="padding-left:5px;" >
										<button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>blocos_novo/codigo/<?=$data->codigo?>', 'Novo Bloco');">Novo Bloco</button>
									</div>


									<div style="padding-bottom:10px; margin-top:15px; padding-left:5px;">Você pode arrastar para ordenar os conteúdos da página</div>


									<div id="sortable" >
										<?php

										foreach ($blocos as $key => $value){

											$linkalterar = "onClick=\"modal('".DOMINIO."layout/blocos_alterar/codigo/".$value['codigo']."', 'Alterar Bloco');\" style='cursor:pointer;' ";

											echo "
											<div id='item_".$value['id']."' >
											";
											
											
											if($value['colunas'] == 1){
												?> 				

												<div class="quadro_coluna_div">
													<div class="row">
														<div class="col-md-12">
															<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
														</div>
													</div>
												</div> 

											<?php }

											if($value['colunas'] == 2){
												
												if($value['formato'] == '6_6'){
													?> 			

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-6">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-6">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
														</div>
													</div>

												<?php }

												if($value['formato'] == '4_8'){
													?>				

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-8">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
														</div>
													</div>

												<?php }

												if($value['formato'] == '8_4'){
													?>			

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-8">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
														</div>
													</div>

												<?php }

											}


											if($value['colunas'] == 3){

												if($value['formato'] == '4_4_4'){
													?>

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
															</div>
														</div>
													</div> 

												<?php }


												if($value['formato'] == '2_5_5'){
													?>			

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-2">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-5">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
															<div class="col-md-5">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
															</div>
														</div>
													</div>

												<?php }


												if($value['formato'] == '5_2_5'){
													?>			

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-5">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-2">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
															<div class="col-md-5">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
															</div>
														</div>
													</div>

												<?php }

												if($value['formato'] == '5_5_2'){
													?> 				

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-5">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-5">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
															<div class="col-md-2">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
															</div>
														</div>
													</div>

												<?php }

											}

											if($value['colunas'] == 4){

												if($value['formato'] == '3_3_3_3'){
													?>												 				

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-3">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-3">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
															<div class="col-md-3">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
															</div>
															<div class="col-md-3">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna4']?></div>
															</div>
														</div>
													</div>

												<?php }


												if($value['formato'] == '4_2_2_4'){
													?>

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-2">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
															<div class="col-md-2">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
															</div>
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna4']?></div>
															</div>
														</div>
													</div>

												<?php }

												if($value['formato'] == '2_4_4_2'){
													?>

													<div class="quadro_coluna_div">
														<div class="row">
															<div class="col-md-2">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
															</div>
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
															</div>
															<div class="col-md-4">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
															</div>
															<div class="col-md-2">
																<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna4']?></div>
															</div>
														</div>
													</div>

													<?php
												}

											}

											if($value['colunas'] == 6){
												?> 				

												<div class="quadro_coluna_div">
													<div class="row">
														<div class="col-md-2">
															<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna1']?></div>
														</div>
														<div class="col-md-2">
															<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna2']?></div>
														</div>
														<div class="col-md-2">
															<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna3']?></div>
														</div>
														<div class="col-md-2">
															<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna4']?></div>
														</div>
														<div class="col-md-2">
															<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna5']?></div>
														</div>							
														<div class="col-md-2">
															<div class="quadro_coluna_bloco" <?=$linkalterar?> ><?=$value['coluna6']?></div>
														</div>
													</div>
												</div> 

											<?php }


											echo "
											</div>
											";

										}

										?>
									</div>	

								</fieldset> 

								<div style="margin-top: 15px; margin-left:5px;">
									<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>
								</div>

							</div> 


							<div id="cores" <?php if($aba_selecionada == "cores"){ echo "class='tab-pane active'"; } else { echo "class='tab-pane'"; } ?> >
								<form action="<?=$_base['objeto']?>cores_grv" class="form-horizontal" method="post">
									<?php

									foreach ($listacores as $key => $value) {	                			 

										echo "
										<div class='form-group' >
										<label class='col-md-12' >Cor: ".$value['titulo']."</label>
										<div class='col-md-6'>
										<input name='cor_".$value['id']."' type='text' class='form-control my-colorpicker1' value='".$value['cor']."' autocomplete='off' >
										</div>
										</div>
										";

									}

									?>

									<div style="padding-top:15px;">
										<button type="submit" class="btn btn-primary">Salvar</button>
										<input type="hidden" name="pagina" value="<?=$data->codigo?>">
										<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>
									</div>

								</form>
							</div> 

						</div>

					</div>

				</div>

			</div>
			<!-- /.row -->
		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->
	<?php require_once('htm_rodape.php'); ?>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>  
<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
<script src="<?=LAYOUT?>dist/js/demo.js"></script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>
<script>
	$(function () {

		$(".select2").select2();	 	 

		$( "#sortable" ).sortable({
			update: function(event, ui){
				var postData = $(this).sortable('serialize');
				// console.log(postData);
				
				$.post('<?=$_base['objeto']?>salvar_ordem', { list: postData, codigo:'<?=$data->codigo?>' }, function(o){
					// console.log(o);
				}, 'json');
			}
		});

		$(".my-colorpicker1").colorpicker();
	});

	<?php if($bloco_selecionado){ ?>

		modal('<?=DOMINIO?>layout/blocos_alterar/codigo/<?=$bloco_selecionado?>', 'Alterar Bloco');

	<?php } ?>

</script>

<script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>
