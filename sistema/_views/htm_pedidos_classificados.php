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

								<li <?php if($aba_selecionada == "incompletos"){ echo "class='active'"; } ?> >
									<a href="#incompletos" data-toggle="tab">Incompletos</a>
								</li>
								<li <?php if($aba_selecionada == "aguardando"){ echo "class='active'"; } ?> >
									<a href="#aguardando" data-toggle="tab">Aguardando Pagamento</a>
								</li> 
								<li <?php if($aba_selecionada == "aprovados"){ echo "class='active'"; } ?> >
									<a href="#aprovados" data-toggle="tab">Pedidos Confirmados</a>
								</li>
								
							</ul>

							<div class="tab-content" >



								<div id="incompletos" class="tab-pane <?php if($aba_selecionada == "incompletos"){ echo "active"; } ?>" >
									<table id="tabela5" class="table table-bordered table-striped">

										<thead>
											<tr> 
												<th style="width:150px;">Data</th>
												<th>Pedido</th>
												<th>E-mail</th>
											</tr>
										</thead>

										<tbody>
											<?php
											
											foreach ($incompletos as $key => $value) {
												
												$linklinha = "onClick=\"window.location='".$_base['objeto']."detalhes/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";
												
												echo "
												<tr>
												<td $linklinha ><span style='display:none'>".$value['data_int']."</span>".$value['data']."</td>
												<td $linklinha >".$value['id']."</td>
												<td $linklinha >".$value['email']."</td>
												</tr>
												";
												
											}
											
											?>
										</tbody>

									</table>
								</div> 



								<div id="aguardando" class="tab-pane <?php if($aba_selecionada == "aguardando"){ echo "active"; } ?>" >
									<table id="tabela1" class="table table-bordered table-striped">

										<thead>
											<tr>
												<th>Pedido</th>
												<th>Data</th>
												<th>Nome</th>
												<th>E-mail</th>
												<th>Valor (R$)</th> 
											</tr>
										</thead>						 	

										<tbody>
											<?php

											foreach ($aguardando as $key => $value) {

												$linklinha = "onClick=\"window.location='".$_base['objeto']."detalhes/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";

												echo "
												<tr>
												<td $linklinha >".$value['id']."</td>
												<td $linklinha >".$value['data']."</td>
												<td $linklinha >".$value['nome']."</td>
												<td $linklinha >".$value['email']."</td>
												<td $linklinha >".$value['valor']."</td> 
												</tr>
												";

											}

											?>
										</tbody>

									</table>
								</div>


								<div id="aprovados" class="tab-pane <?php if($aba_selecionada == "aprovados"){ echo "active"; } ?>" >
									<table id="tabela2" class="table table-bordered table-striped">

										<thead>
											<tr>
												<th>Pedido</th>
												<th>Data</th>
												<th>Nome</th>
												<th>E-mail</th>
												<th>Valor (R$)</th> 
											</tr>
										</thead>						 	

										<tbody>
											<?php

											foreach ($aprovados as $key => $value) {

												$linklinha = "onClick=\"window.location='".$_base['objeto']."detalhes/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";

												echo "
												<tr>
												<td $linklinha >".$value['id']."</td>
												<td $linklinha >".$value['data']."</td>
												<td $linklinha >".$value['nome']."</td>
												<td $linklinha >".$value['email']."</td>
												<td $linklinha >".$value['valor']."</td> 
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
	<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script src="<?=LAYOUT?>api/nestable/jquery.nestable.js"></script>
	<script src="<?=LAYOUT?>api/nestable/examples.nestable.js"></script>s
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

			$('#tabela2').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});

			$('#tabela3').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});

			$('#tabela4').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});

			$('#tabela5').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});

		});
	</script>

	<script src="<?=LAYOUT?>js/ajuda.js"></script> 
	
</body>
</html>