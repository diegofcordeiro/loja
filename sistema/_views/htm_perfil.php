<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<title><?=$_titulo?> - <?=TITULO_VIEW?></title>
	<link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
	
	<link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>api/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />

	<?php include_once('css.php'); ?>
	
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

							<ul class="nav nav-tabs">
								
								<li <?php if($aba_selecionada == "informacoes"){ echo "class='active'"; } ?> >
									<a href="#informacoes" data-toggle="tab">Informações</a>
								</li>
								<li <?php if($aba_selecionada == "imagem"){ echo "class='active'"; } ?> >
									<a href="#imagem" data-toggle="tab">Imagem de Exibição</a>
								</li>
								<li <?php if($aba_selecionada == "senha"){ echo "class='active'"; } ?> >
									<a href="#senha" data-toggle="tab">Alterar Senha</a>
								</li>
								<li <?php if($aba_selecionada == "menu_pers"){ echo "class='active'"; } ?> >
									<a href="#menu_pers" data-toggle="tab">Ordem Menu</a>
								</li>

							</ul>

							<div class="tab-content" >

								<div id="informacoes" class="tab-pane <?php if($aba_selecionada == "informacoes"){ echo "active"; } ?>" >
									<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">
										
										<fieldset>
											
											<div class="form-group">
												<label class="col-md-12" >Nome</label>
												<div class="col-md-6">
													<input name="nome" type="text" class="form-control" value="<?=$data->nome?>" >
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-12" >E-mail <?=ajuda('E-mail utilizado para recuperação de senha.')?></label>
												<div class="col-md-6">
													<input name="email_recuperacao" type="text" class="form-control" value="<?=$data->email_recuperacao?>" >
												</div>
											</div>                            
											
										</fieldset>
										
										<div>
											<button type="submit" class="btn btn-primary">Salvar</button>	
										</div>

									</form>    
								</div>

								<div id="imagem" class="tab-pane <?php if($aba_selecionada == "imagem"){ echo "active"; } ?>" >
									
									<?php if($data->imagem){ ?>
										
										<div><img src="<?=PASTA_CLIENTE?>img_usuarios/<?=$data->imagem?>" style="border:0px; max-width:300px;" ></div>
										
										<div style="padding-top:10px;">
											<button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>apagar_imagem');"  >Apagar Imagem</button>
										</div>
										
									<?php } else { ?>
										
										<form action="<?=$_base['objeto']?>imagem" class="form-horizontal" method="post" enctype="multipart/form-data" >
											
											<fieldset>
												<div class="form-group">
													<label class="col-md-12">Arquivo</label>
													<div class="col-md-7">
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div class="input-append">
																<div class="uneditable-input">
																	<i class="fa fa-file fileupload-exists"></i>
																	<span class="fileupload-preview"></span>
																</div>
																<span class="btn btn-default btn-file">
																	<span class="fileupload-exists">Alterar</span>
																	<span class="fileupload-new">Procurar arquivo</span>
																	<input type="file" name="arquivo" />
																</span>
																<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
															</div>
														</div>
													</div>
												</div>
											</fieldset>
											
											<div>
												<button type="submit" class="btn btn-primary">Enviar</button>
											</div>
											
										</form>
										
									<?php } ?>
									
								</div>

								<div id="senha" class="tab-pane <?php if($aba_selecionada == "senha"){ echo "active"; } ?>" >
									<form action="<?=$_base['objeto']?>alterar_senha" class="form-horizontal" method="post">
										
										<fieldset>
											
											<div class="form-group">
												<label class="col-md-12" >Digite o novo usuario de acesso <?=ajuda('Digite um usuário que não esteja sendo utilizado')?></label>
												<div class="col-md-4">
													<input name="usuario" type="text" class="form-control" >
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-12" >Digite a nova senha de acesso</label>
												<div class="col-md-4">
													<input name="senha" type="text" class="form-control" >
												</div>
											</div>
											
										</fieldset>
										
										<div>
											<button type="submit" class="btn btn-primary">Salvar</button>
										</div>
										
									</form>    
								</div>

								<div id="menu_pers" class="tab-pane <?php if($aba_selecionada == "menu_pers"){ echo "active"; } ?>" >
									
									<div style="text-align:left; font-size:15px; margin-bottom: 20px;">Selecione o menu e arraste para cima ou para baixo para ajustar a ordem que desejar.</div>

									<div class="row" >
										<div class="col-md-4" >

											<div style="padding-top:20px;">
												<table class="table" >		             
													
													<tbody id="sortable_menu" >
														<?php

														foreach ($listamenu as $key => $value) {
															
															echo "
															<tr id='item_".$value['id']."' style='cursor:move; '>
															<td style='border:1px solid #999; width:600px;'>".$value['titulo']."</td>
															</tr>
															";

														}

														?>
													</tbody>

												</table>
											</div>

										</div>
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
		<script src="<?=LAYOUT?>api/jquery/jquery.js"></script>
		<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
		<script src="<?=LAYOUT?>dist/js/demo.js"></script> 

		<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
		<script src="<?=LAYOUT?>js/funcoes.js"></script>

		<script>
			$(function() {
				$( "#sortable_menu" ).sortable({
					update: function(event, ui){
						var postData = $(this).sortable('serialize');
						console.log(postData);
						
						$.post('<?=$_base['objeto']?>ordem', { list: postData }, function(o){
							console.log(o);
						}, 'json');
					}
				});
			});
		</script>
		<script src="<?=LAYOUT?>js/ajuda.js"></script> 
	</body>
	</html>