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

						<!-- box -->
						<div class="box">
							<div class="box-body"> 

								<div style="text-align:left;">

									<button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>novo', 'Nova Página');">Nova Página</button>
																		
								</div>
								
								<hr>				    	 
								
								<table id="tabela1" class="table table-bordered table-striped">
									
									<thead>
										<tr> 
											<th>Titulo</th>
											<th>Url <?=ajuda('Url para configurar paginas no menu.')?></th>
											<th>Status</th>
											<th>Principal</th>
										</tr>
									</thead>
									
									<tbody>
										<?php

										foreach ($lista as $key => $value) {

											$linklinha = "onClick=\"window.location='".$_base['objeto']."alterar/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";											
											 
											if($value['status'] == 1){
												$status = "Ativo";
											} else {
												$status = "Inativa";
											}
											
											$ativar = "";
											if($value['chave'] != 'index'){
												$ativar = "<a class='btn btn-primary' href='".$_base['objeto']."definir_pg_inicial/codigo/".$value['codigo']."' >Definir como Inicial</a>";
											} else {
												$ativar = "Inicial";
											}
											
											echo "
											<tr> 
											<td $linklinha >".$value['titulo']."</td> 
											<td>".$value['url']."</td>
											<td>".$status."</td>
											<td>".$ativar."</td>
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