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
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">

	<?php include_once('css.php'); ?>
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
						<form action="<?=$_base['objeto']?>apagar_varios/" method="post" id="form_apagar" name="form_apagar" >
							
							<!-- box -->
							<div class="box">
								<div class="box-body">
									<div>
										<button type="button" class="btn btn-primary" id="sync_html" onClick="sync()">Sincronizar</button>
										<!-- <button type="button" class="btn btn-default" onClick="apagar_varios('form_apagar');" >Apagar Selecionados</button> -->

										<!-- <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>exportar';">Exportar</button>

										<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>grupos';">Grupos/Páginas</button> -->
									</div>
									<hr>
									<table id="tabela1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th style='width:30px; text-align:center;' >Sel.</th>
												<th>Nome</th>
												<th>Preço</th>
												<th>Intervalo</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
											
											foreach ($lista as $key => $value) {	
                                                $bolinha = 'b_vermelha';
                                                if($value['status'] == 1){$bolinha = 'b_verde';}									
												echo "
												<tr>
												<td class='center' style='width:30px;' ><input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='".$value['id']."' ></td>
												<td><a href='".$_base['objeto']."alterar_plano/codigo/".$value['id']."' >".$value['titulo']."</a></td>
												<td><a href='".$_base['objeto']."alterar_plano/codigo/".$value['id']."' >".$value['price']."</a></td>
												<td><a href='".$_base['objeto']."alterar_plano/codigo/".$value['id']."' >".$value['intervalo']."</a></td>
												<td style='text-align:center;'><span class='".$bolinha."'></span></td>
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
	<!-- jQuery 2.2.3 -->
	<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
	<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script><!-- page script -->
	<script>
		function sync(){
			$('#sync_html').html('Sincronizando...');
			$.ajax({
                    url:'<?=$_base['objeto']?>lista_planos_vindi',
                    method: 'post',
                    success: function(response){
                      location.reload();
                    }
                  });
		}
		$(function () {

			$(".select2").select2();

			$('#tabela1').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
		});
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue'
		});
	</script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	<script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>