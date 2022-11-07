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
							<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">
								
								<div class="panel-body">
									
									<fieldset>
										
										<div class="form-group">
											<label class="col-md-12" >Nome</label>
											<div class="col-md-6">
												<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-12" >Nome Técnico</label>
											<div class="col-md-6">
												<input name="titulo_tecnico" type="text" class="form-control" value="<?=$data->titulo_tecnico?>" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-12" >Ico</label>
											<div class="col-md-6">
												<input name="ico" type="text" class="form-control" value="<?=$data->ico?>">
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-12" >Id Pai</label>
											<div class="col-md-6">
												<input name="id_pai" type="text" class="form-control" value="<?=$data->id_pai?>">
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-12" >Endereço</label>
											<div class="col-md-6">
												<input name="endereco" type="text" class="form-control" value="<?=$data->endereco?>">
											</div>
										</div>                
										
									</fieldset>
									
								</div>
								
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary">Salvar</button>
											<input type="hidden" name="codigo" value="<?=$data->id?>">
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
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script>
	<script>
		$(function () {
			$('#tabela1').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
		});
	</script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>

</body>
</html>