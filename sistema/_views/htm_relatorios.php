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
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/timepicker/bootstrap-timepicker.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
	
	<?php include_once('css.php'); ?>

</head>
<body class="hold-transition skin-blue <?php if($_base['menu_fechado'] == 1){ echo "sidebar-collapse"; } ?> sidebar-mini">
	<div class="wrapper">

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



				<section class="panel">
					<div class="panel-body">
						<form action="<?=DOMINIO?>relatorios/inicial" method="post" >
							
							<div class="row">
								<div class="col-xs-12">
									<div style="font-size: 16px; padding-left:15px; text-align: left; padding-bottom: 10px;">Selecione o periodo e status para gerar o relatório de pedidos:</div>
								</div>
							</div>
							
							<div class="row">
								
								<div class="col-xs-3">
									
									<div class="form-group">
										<div class="col-md-12">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</span>
												<input type="text" class="form-control datepicker" value="<?=$inicio?>" name="inicio" >
											</div>
										</div>
									</div>

								</div>

								<div class="col-xs-3">
									
									<div class="form-group">
										<div class="col-md-12">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</span>
												<input type="text" class="form-control datepicker" value="<?=$fim?>" name="fim" >
											</div>
										</div>
									</div>
									
								</div>

								<div class="col-xs-4">
									
									<div class="form-group" >
										<div class="col-md-12">
											<select data-plugin-selectTwo class="form-control" name="status" >
												<option value='todos' selected="" >Todos</option>
												<?php

												foreach ($lista_status as $key => $value) {                 
													
													if($value['selected']){ $sel = "selected"; } else { $sel = ""; }
													echo "<option value='".$value['codigo']."' $sel >".$value['status']."</option>";
													
												}
												
												?>
											</select>
										</div>
									</div>
									
								</div>

								<div class="col-xs-2">
									
									<div class="form-group">        
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary"  >GERAR</button>
										</div>
									</div>
									
								</div>

							</div>

						</form>
					</div>
				</section>

				

				<?php if($resultado){ ?>

					<section class="panel">
						<div class="panel-body">

							<table class="table table-bordered table-striped">

								<thead>
									<tr>
										<th>Pedido</th>
										<th>Data</th>
										<th>Nome</th>
										<th>E-mail</th>
										<th>Valor (R$)</th>
										<th>Status</th>
									</tr>
								</thead>						 	

								<tbody>
									<?php

									foreach ($lista as $key => $value) {
										
										$linklinha = "onClick=\"window.location='".DOMINIO."pedidos/detalhes/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";

										echo "
										<tr>
										<td $linklinha >".$value['id']."</td>
										<td $linklinha >".$value['data']."</td>
										<td $linklinha >".$value['nome']."</td>
										<td $linklinha >".$value['email']."</td>
										<td $linklinha >".$value['valor']."</td>
										<td $linklinha >".$value['status']."</td>
										</tr>
										";

									}

									?>
								</tbody>

							</table>

							<div style="font-size:16px;" >Movimento total do periodo: <strong>R$ <?=$valor_total_periodo?></strong></div>

						</div>
					</section>

				<?php } ?>



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
	<script src="<?=LAYOUT?>plugins/daterangepicker/daterangepicker.js"></script>
	<script src="<?=LAYOUT?>plugins/datepicker/bootstrap-datepicker.js"></script> 
	<script src="<?=LAYOUT?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
	<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script>
	<script>
		$(document).ready(function() {

			$(".select2").select2();

			$('.datepicker').datepicker({
				autoclose: true,
				format: 'dd/mm/yyyy'
			});

		});
	</script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	<script src="<?=LAYOUT?>js/ajuda.js"></script>

</body>
</html>