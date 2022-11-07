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
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">

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

										<button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>novo', 'Novo Curso');">Novo Curso</button>

										<button type="button" class="btn btn-default" onClick="apagar_varios('form_apagar');" >Apagar Sel.</button>
										
										<!-- <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>estoque';">Estoque</button> -->
										
										<!-- <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>categorias';">Categorias</button> -->
										
										<!-- <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>marcas';">Marcas</button> -->
										
										<!-- <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>tamanhos';">Tamanhos</button> -->

										<!-- <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>cores';">Cores</button>
										
										<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>variacoes';">Variações</button>
										
										<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>modelos';">Modelos</button>
										
										<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>acabamentos';">Acabamentos</button>										  -->

									</div>

									<div style="text-align:left; margin-top:5px;">
									<!-- <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>mascara';">Marca d'água</button>

									<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>grupos';">Páginas</button>
										
									<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>pg_detalhes';">Config</button></div> -->

									<hr>

									<table id="tabela1" class="table table-bordered table-striped">
										
										<thead>
											<tr>
												<th>Id</th>
												<th></th>
												<th>Nome</th>
												<!-- <th>Aprendera</th>  -->
											</tr>
										</thead>
										
										<tbody>
											<?php
											
											foreach ($lista as $key => $value) {
												
												$linklinha = "onClick=\"window.location='".$_base['objeto']."alterar_curso/codigo/".$value['id']."';\" style='cursor:pointer;' ";
												
												// echo "
												// <tr>
												// <td class='center' style='width:30px;' ><input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='1' ></td>
												// <td><a href='".$_base['objeto']."alterar_curso/codigo/".$value['id']."' >".$value['nome']."</a></td>
												// <td $linklinha >".$value['aprendera']."</td> 
												// </tr>
												// ";
												echo "
												<tr>
												<td class='center' style='width:30px;' ><input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='1' ></td>
												<td style='width:30px;' $linklinha>".$value['id']."</td> 
												<td><a href='".$_base['objeto']."alterar_curso/codigo/".$value['id']."' >".$value['nome']."</a></td>
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
	<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script> 
	
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
	<script src="<?=LAYOUT?>js/ajuda.js"></script> 

</body>
</html>