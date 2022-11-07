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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
	
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

						
						<section class="panel">
							<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">
								
								<div class="panel-body">
									
									<fieldset>
										
										<div class="form-group">
											<label class="col-md-12" >Nome</label>
											<div class="col-md-6">
												<input name="nome" type="text" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-12" >E-mail <?=ajuda('O e-mail é utilizado para recuperação de senha em caso de necessidade.')?></label>
											<div class="col-md-6">
												<input name="email" type="text" class="form-control" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-12" >Digite um usuário <?=ajuda('O usuário deve ser único')?></label>
											<div class="col-md-4">
												<input name="usuario_sis" type="text" class="form-control" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-12" >Digite uma senha</label>
											<div class="col-md-4">
												<input name="senha_sis" type="password" class="form-control" >
											</div>
										</div>
										
										<div style="padding-top:10px; padding-bottom:20px;"><strong>PERMISSÕES</strong> <?=ajuda('Marque os modulos/setores que deseja que este usuário tenha acesso.')?></div>

										<div class="form-group">
											<div class="col-md-12">
												<?php
												
												foreach ($lista as $key => $value) {
													
													if($value['id_pai'] == 0){
														$margem = 0;
													} else {
														$margem = 20;
													}

													echo "
													<div class='checkbox-custom' style='margin-left:".$margem."px;' >
													<input type='checkbox' id='check_".$value['id']."' name='setor_".$value['id']."' ".$value['check']." value='1' >
													<label for='check_".$value['id']."' >".$value['titulo']."</label>
													</div>
													";

												}

												?>
											</div>
										</div>
										
									</fieldset>

									<div style="padding-top:15px;"></div>
									
								</div>
								
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary">Salvar</button>
											<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>
										</div>
									</div>
								</div> 
								
							</form>
						</section>


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
	<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script>
	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue'
			});
		});
	</script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	<script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>