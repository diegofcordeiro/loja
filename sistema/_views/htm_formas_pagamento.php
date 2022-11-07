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
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
	.b_verde{
		width: 10px;
		height: 10px;
		background: #2d9c6b;
		position: absolute;
		border-radius: 10px;
	}
	.b_vermelha{
		width: 10px;
		height: 10px;
		background: #eb3f3f;
		position: absolute;
		border-radius: 10px;
	}
</style>

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
						
						<!-- box -->
						<div class="box">
							<div class="box-body">
								<!-- <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>novo', 'Adicionar');">Adicionar Condicional</button> -->
								<!-- <hr> -->
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Titulo</th>
											<th width="5%">Status</th>
											<!-- <th></th> -->
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($lista as $key => $value) {
											$linklinha = "onClick=\"modal('".$_base['objeto']."alterar/id/".$value['id']."', 'Alterar Forma de Pagamento');\" style='cursor:pointer;' ";
											$bolinha = 'b_vermelha';
											if($value['ativo'] == 0){
												$bolinha = 'b_verde';
											}
											if($value['id'] <= 10){
												echo "
												<tr>
												<td $linklinha >".$value['titulo']."</td>
												<td style='text-align:center;'><span class='".$bolinha."'></span></td>
												</tr>
												";
											} 
											// else {
											// 	// condicionais
											// 	echo "
											// 	<tr>
											// 	<td $linklinha >".$value['titulo']."</td>
											// 	<td $linklinha >".$value['cidade']."</td>
											// 	<td >
											// 	<a href='#' onclick=\"confirma('".$_base['objeto']."apagar/id/".$value['id']."');\" >Remover</a>
											// 	</td>
											// 	</tr>
											// 	";
											// }
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /.box -->
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

	<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
	<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
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