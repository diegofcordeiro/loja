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
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
	
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
						<form action="<?=$_base['objeto']?>apagar_varios" method="post" id="form_apagar" name="form_apagar" >

							<!-- box -->
							<div class="box">
								<div class="box-body">

									<div style="text-align:left;">

										<button type="button" class="btn btn-primary" onClick="window.location='<?=$_base['objeto']?>novo';">Nova</button>
										<button type="button" class="btn btn-default" onClick="apagar_varios('form_apagar');" >Apagar Selecionados</button>

									</div>

									<hr>
									
									<div style="font-size: 14px;">Arraste para cima ou para baixo para ajustar a ordem.</div>

									<hr>

									<table class="table table-bordered table-striped">

										<thead>
											<tr>
												<th>Ord.</th>
												<th>Sel.</th>
												<th>Titulo</th>
											</tr>
										</thead>

										<tbody id="sortable" >
											<?php

											$n = 0;
											foreach ($lista as $key => $value) {

												$linklinha = "onClick=\"window.location='".$_base['objeto']."alterar/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";

												echo "
												<tr id='item_".$value['id']."' >
												<td style='width:30px; cursor:move; text-align:center;' ><i class='fas fa-arrows-alt-v'></i></td>
												<td style='width:30px;' ><input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='1' ></td>
												<td $linklinha >".$value['titulo']."</td>
												</tr>
												";

												$n++;
											}

											if($n == 0){
												echo "
												<tr id='item_".$value['id']."' >
												<td colspan='3' style='padding-top:30px; padding-bottom:30px; text-align:center;' >Nenhum Resultado</td>
												</tr>
												";
											}

											?>
										</tbody>

									</table>

								</div>

							</div>
							<!-- /.box -->

						</form>
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

			$(".select2").select2();

			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue'
			});

			$( "#sortable" ).sortable({
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
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	<script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>