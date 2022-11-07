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

							<div class="box">
								<div class="box-body">

									<div style="text-align:left;">
										
										<button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>novo', 'Novo');">Novo</button>
										
										<button type="button" class="btn btn-default" onClick="apagar_varios('form_apagar');" >Apagar Selecionados</button>
										
										<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>grupos';">Grupos/Páginas</button>
										
									</div>

									<div style="text-align:left; padding-top:15px;">
										<label>Filtro: <?=ajuda('Selecione para filtrar por setor')?></label>
										<select data-plugin-selectTwo class="form-control select2" name="grupo" onChange="window.location='<?=$_base['objeto']?>inicial/grupo/'+this.value;"; >
											<?php
											foreach ($grupos as $key => $value) {
												
												if($value['codigo'] == $grupo_selecionado){
													$selected = " selected ";
												} else {
													$selected = "";
												}
												
												echo "<option value='".$value['codigo']."' ".$selected." >".$value['titulo']."</option>";
											}
											?>
										</select>
									</div>

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
											
											foreach ($lista as $key => $value) {
												
												$linklinha = "onClick=\"window.location='".$_base['objeto']."alterar/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";
												
												echo "
												<tr id='item_".$value['id']."' >
												<td style='width:30px; cursor:move; text-align:center;' ><i class='fas fa-arrows-alt-v' ></i></td>
												<td style='width:30px;' ><input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='1' ></td>
												<td $linklinha >".$value['titulo']."</td>
												</tr>
												";
												
											}
											
											?>
										</tbody>

									</table>

								</div>

							</div>

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
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	
	<script>
		$(function () {

			$(".select2").select2();

			$( "#sortable" ).sortable({
				update: function(event, ui){
					var postData = $(this).sortable('serialize');
					console.log(postData);
					
					$.post('<?=$_base['objeto']?>ordem', { grupo:'<?=$grupo_selecionado?>', list: postData }, function(o){
						console.log(o);
					}, 'json');
				}
			});

		});
		
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue'
		});
		
	</script> 
	
	<script src="<?=LAYOUT?>js/ajuda.js"></script> 

</body>
</html>