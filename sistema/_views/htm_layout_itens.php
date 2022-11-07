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
	<link rel="stylesheet" href="<?=LAYOUT?>api/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />	
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
						
						<div class="nav-tabs-custom">

							<ul class="nav nav-tabs">

								<li <?php if($aba_selecionada == "botoes"){ echo "class='active'"; } ?> >
									<a href="#botoes" data-toggle="tab">Botões</a>
								</li>
								<li <?php if($aba_selecionada == "fontes"){ echo "class='active'"; } ?> >
									<a href="#fontes" data-toggle="tab">Fontes</a>
								</li>
								<li <?php if($aba_selecionada == "css"){ echo "class='active'"; } ?> >
									<a href="#css" data-toggle="tab">Classes CSS</a>
								</li>
								
							</ul>
							
							<div class="tab-content" >

								<div id="botoes" class="tab-pane <?php if($aba_selecionada == "botoes"){ echo "active"; } ?>" >

									<form action="<?=$_base['objeto']?>botoes_apagar" method="post" id="form_apagar1" name="form_apagar1" >

										<div style="text-align:left;">

											<button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>botoes_novo', 'Novo');">Novo</button>

											<button type="button" class="btn btn-default" onClick="apagar_varios('form_apagar1');" >Apagar Selecionados</button>

										</div>

										<hr>				    	 

										<table id="tabela1" class="table table-bordered table-striped">

											<thead>
												<tr>
													<th></th>
													<th>Titulo</th>
												</tr>
											</thead>

											<tbody>
												<?php

												foreach ($botoes as $key => $value) {

													$linklinha = "onClick=\"modal('".$_base['objeto']."botoes_alterar/codigo/".$value['codigo']."', 'Alterar');\" style='cursor:pointer;' ";
													
													if($value['id'] != 1){
														$selecao = "<input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='".$value['codigo']."' >";
													} else {
														$selecao = "";
													}
													
													echo "
													<tr>
													<td class='center' style='width:30px;' >$selecao</td>
													<td $linklinha >".$value['titulo']."</td>
													</tr>
													";

												}

												?>
											</tbody>

										</table>


									</form>


								</div>


								<div id="fontes" class="tab-pane <?php if($aba_selecionada == "fontes"){ echo "active"; } ?>" > 



									<form action="<?=$_base['objeto']?>fontes_apagar" method="post" id="form_apagar2" name="form_apagar2" >

										<div style="text-align:left;">

											<button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>fontes_novo', 'Novo');">Novo</button>

											<button type="button" class="btn btn-default" onClick="apagar_varios('form_apagar2');" >Apagar Selecionados</button>

										</div>

										<hr>				    	 

										<table id="tabela2" class="table table-bordered table-striped">
											
											<thead>
												<tr>
													<th></th>
													<th>Titulo</th>
												</tr>
											</thead>

											<tbody>
												<?php

												foreach ($fontes as $key => $value) {

													if($value['fixo'] == 1){
														$selecao = "";
														$linklinha = "";
													} else {
														$selecao = "<input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='".$value['codigo']."' >";
														$linklinha = "onClick=\"modal('".$_base['objeto']."fontes_alterar/codigo/".$value['codigo']."', 'Alterar');\" style='cursor:pointer;' ";
													}

													echo "
													<tr>
													<td class='center' style='width:30px;' >$selecao</td>
													<td $linklinha >".$value['titulo']."</td>
													</tr>
													";

												}

												?>
											</tbody>

										</table>


									</form>


								</div>



								<div id="css" class="tab-pane <?php if($aba_selecionada == "css"){ echo "active"; } ?>" >

									<form action="<?=$_base['objeto']?>css_apagar" method="post" id="form_apagar3" name="form_apagar3" >

										<div style="text-align:left;">

											<button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>css_novo', 'Novo');">Novo</button>

											<button type="button" class="btn btn-default" onClick="apagar_varios('form_apagar3');" >Apagar Selecionados</button>

										</div>

										<hr>				    	 

										<table id="tabela3" class="table table-bordered table-striped">

											<thead>
												<tr>
													<th></th>
													<th>Titulo</th>
												</tr>
											</thead>

											<tbody>
												<?php

												foreach ($lista_css as $key => $value) {

													$linklinha = "onClick=\"modal('".$_base['objeto']."css_alterar/codigo/".$value['codigo']."', 'Alterar');\" style='cursor:pointer;' ";
													
													$selecao = "<input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='".$value['codigo']."' >";

													
													echo "
													<tr>
													<td class='center' style='width:30px;' >$selecao</td>
													<td $linklinha >".$value['titulo']."</td>
													</tr>
													";

												}

												?>
											</tbody>

										</table>


									</form>


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
	<script src="<?=LAYOUT?>api/jquery/jquery.js"></script>
	<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script> 
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>    
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

	<script>
		$(function() {

			$(".select2").select2();			

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

		});

		<?php
		if($codigo_selecionado AND ($aba_selecionada == 'fontes') ){
			?>
			
			modal('<?=$_base['objeto']?>fontes_alterar/codigo/<?=$codigo_selecionado?>', 'Alterar');
			
			<?php
		}
		?>

		<?php
		if($codigo_selecionado AND ($aba_selecionada == 'botoes') ){
			?>

			modal('<?=$_base['objeto']?>botoes_alterar/codigo/<?=$codigo_selecionado?>', 'Alterar');
			
			<?php
		}
		?>
		
	</script>

	<script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>