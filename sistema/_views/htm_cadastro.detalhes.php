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
	<link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />

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



					<div class="col-md-7">


						<section class="panel">

							<div class="panel-body">

								<div class="row">
									<div class="col-md-5">

										<div style="text-align:center; padding-top:20px;">

											<?php

											if($data->imagem){

												?>

												<div style="width: 100%">
													<img src="<?=PASTA_CLIENTE?>img_clientes/<?=$data->imagem?>" style="width: 100%" >
												</div>

												<?php

											} else {

												?>

												<div style="font-size:100px; color:#f2f2f2;">
													<i class="fa fa-user" aria-hidden="true"></i>
												</div>

												<?php

											}

											?>
											
											<div style="padding-top:20px; padding-bottom:20px;">
												<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>alterar/codigo/<?=$data->codigo?>';">Alterar Dados</button>
												<button type="button" class="btn btn-default" onClick="modal('<?=$_base['objeto']?>alterar_imagem/codigo/<?=$data->codigo?>', 'Alterar Imagem');">Alterar Imagem</button>
											</div>

										</div>

									</div>
									<div class="col-md-7">

										<div class="detalhes_cliente" >

											<?php

											if($data->fisica_nome){

												echo "<div><span class='detalhes_campo'>Nome:</span> <strong>$data->fisica_nome</strong></div>";
											}

											?>

											<?php

											if($data->juridica_nome){

												echo "<div><span class='detalhes_campo'>Nome:</span> <strong>$data->juridica_nome</strong></div>";

											}

											?>

											<?php

											if($data->telefone){

												echo "<div><span class='detalhes_campo'>Telefone:</span> <strong>$data->telefone</strong></div>";

											}

											?>
											 
											
											<?php

											if($data->email){

												echo "<div><span class='detalhes_campo'>Email:</span> <strong>$data->email</strong></div>";

											}

											?>

											<div style="padding-top:10px;">

												<?php

												if($data->complemento){
													$complemento = " - $data->complemento";
												} else {
													$complemento = "";
												}

												?>
												
												<?php

												if($data->numero){												
													$numero = ", $data->numero";
												} else {
													$numero = "";
												}

												?>
												
												<?php

												if($data->endereco){
													echo "<div><span class='detalhes_campo'>Endereço:</span> $data->endereco$numero$complemento </div>";
												}

												?>
												
												<?php

												if($data->bairro){	
													echo "<div><span class='detalhes_campo'>Bairro:</span> $data->bairro </div>";
												}

												?>

												<?php

												if($data->cep){
													
													echo "<div><span class='detalhes_campo'>Cep:</span> $data->cep</div>";

												}

												?>

												<?php

												if($data->cidade){
													echo "<div><span class='detalhes_campo'>Cidade:</span> $data->cidade - $data->estado</div>";
												}

												?>

											</div>

											<div style="padding-top:10px; padding-bottom:10px;">

												<div>
													<span class='detalhes_campo'>Pessoa:</span> <?php if($data->tipo == 'J'){ echo "Juridica"; } else { echo "Física"; } ?>
												</div>

												<?php

												if($data->juridica_cnpj){ 
													echo "<div><span class='detalhes_campo'>Cnpj:</span> $data->juridica_cnpj</div>";
												}

												?>

												<?php

												if($data->juridica_razao){
													echo "<div><span class='detalhes_campo'>Razão Social:</span> $data->juridica_razao</div>";
												}

												?>

												<?php

												if($data->juridica_ie){

													echo "<div><span class='detalhes_campo'>inscrição Estadual:</span> $data->juridica_ie</div>";

												}

												?>

												<?php

												if($data->juridica_responsavel){
													echo "<div><span class='detalhes_campo'>Representante legal:</span> $data->juridica_responsavel</div>";
												}

												?>

												<?php
												if($data->fisica_cpf){
													echo "<div><span class='detalhes_campo'>Cpf:</span> $data->fisica_cpf</div>";
												}
												?>

												<?php
												if($data->fisica_nascimento){
													echo "<div><span class='detalhes_campo' >Aniversário:</span> ".date('d/m/Y', $data->fisica_nascimento)."</div>";
												}
												?>

												<?php
												if($data->fisica_sexo){
													echo "<div><span class='detalhes_campo'>Sexo:</span> $data->fisica_sexo</div>";
												}
												?>

											</div>

										</div>

									</div>
								</div>

							</div>

							<div class="panel-footer">
								<div class="row">
									<div class="col-md-6">
										<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>
									</div> 
								</div>
							</div> 

						</section>


						<section class="panel">
							<div class="panel-body">

								<div style="font-weight:bold;">OBSERVAÇÕES</div>
								<hr>
								<div>
									<?php

									foreach ($comentarios as $key => $value) {

										echo "
										<div style='position:relative; width:100%;'>
										<div style='font-size:16px; text-align:right; position:absolute; right:15px; top:0px; cursor:pointer;' onClick=\"confirma('".$_base['objeto']."/comentario_apagar/id/".$value['id']."/cadastro/".$data->codigo."');\" >
										<i class='fa fa-trash-o' aria-hidden='true'></i>
										</div>
										<div style='color:#000; ' >".$value['data']." - <strong>".$value['usuario']."</strong></div>
										<div style='font-size:14px; padding-top:5px;' >".$value['comentario']."</div>
										</div>
										<hr>
										";

									}

									?>
								</div>

								<div>
									<form action="<?=$_base['objeto']?>comentario_grv" method="post" >

										<div>Redefinir Senha</div>

										<div>
											<textarea name="comentario" class="form-control" style="height:80px;" ></textarea>
										</div>

										<div style="text-align:right; margin-top:15px;">
											<button type="submit" class="btn btn-primary">Salvar</button>
											<input type="hidden" name="codigo" value="<?=$data->codigo?>" >
										</div>

									</form>
								</div>

								<div>
									<form action="<?=$_base['objeto']?>comentario_grv" method="post" >

										<div>Adicione uma observação para este cadastro</div>

										<div>
											<textarea name="comentario" class="form-control" style="height:80px;" ></textarea>
										</div>

										<div style="text-align:right; margin-top:15px;">
											<button type="submit" class="btn btn-primary">Salvar</button>
											<input type="hidden" name="codigo" value="<?=$data->codigo?>" >
										</div>

									</form>
								</div>



							</div>
						</section>


					</div>

					<div class="col-md-5">		





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
	<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
	<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.js"></script>
	<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script>
	<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script>
		$(document).ready(function(){	
			$(".select2").select2();	
		});
	</script>

</body>
</html>