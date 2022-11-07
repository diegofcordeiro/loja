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
					<div class="col-md-12">




						
						<section class="panel">
							<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">
								
								<div class="panel-body">

									<fieldset>

										<div class="row">                	 
											<div class="col-md-4">
												
												<?php if($data->tipo == 'F'){ ?>

													<div class="form-group" >
														<label class="col-md-12" >Nome</label>
														<div class="col-md-12">
															<input name="fisica_nome" type="text" class="form-control" value="<?=$data->fisica_nome?>" >
														</div>
													</div>
													
												<?php } else { ?>
													
													<div class="form-group" >
														<label class="col-md-12" >Nome</label>
														<div class="col-md-12">
															<input name="juridica_nome" type="text" class="form-control" value="<?=$data->juridica_nome?>" >
														</div>
													</div>
													
												<?php } ?>

											</div>
											<div class="col-md-4">

												<div class="form-group" >
													<label class="col-md-12" >Fone</label>
													<div class="col-md-12">
														<input name="telefone" id="telefone" type="text" class="form-control" onkeypress="Mascara(this,telefone)" onKeyDown="Mascara(this,telefone)" maxlength="15" value="<?=$data->telefone?>" >
													</div>
												</div>

											</div>
											<div class="col-md-4">

												<div class="form-group" >
													<label class="col-md-12" >E-mail</label>
													<div class="col-md-12">
														<input name="email" type="text" class="form-control" value="<?=$data->email?>" >
													</div>
												</div>

											</div>
										</div>

										<div style="padding-top:10px;"><hr></div>

										<div class="row">

											<div class="col-md-4">

												<div class="form-group">
													<label class="col-md-12">Tipo</label>
													<div class="col-md-12">
														<select class="form-control select2" name="tipo" onChange="tipo_cadastro(this.value);" >
															<option value="J" <?php if($data->tipo == 'J'){ echo "selected=''"; } ?> >Pessoa Jurídica</option>
															<option value="F" <?php if($data->tipo == 'F'){ echo "selected=''"; } ?> >Pessoa Física</option>
														</select>
													</div>
												</div>
												
											</div>
											
											<div class="col-md-5 tipo_juridica">

												<div class="form-group" >
													<label class="col-md-12" >Razão Social</label>
													<div class="col-md-12">
														<input name="juridica_razao" type="text" class="form-control" value="<?=$data->juridica_razao?>" >
													</div>
												</div>
												
											</div>                	 
											
										</div>

										<div class="row form_margem">
											<div class="col-md-4 tipo_juridica">

												<div class="form-group" >
													<label class="col-md-12" >CNPJ</label>
													<div class="col-md-12">
														<input name="juridica_cnpj" id="cnpj" type="text" class="form-control" value="<?=$data->juridica_cnpj?>" >
													</div>
												</div>

											</div>
											<div class="col-md-4 tipo_juridica">
												
												<div class="form-group" >
													<label class="col-md-12" >Inscrição Estadual</label>
													<div class="col-md-12">
														<input name="juridica_ie" type="text" class="form-control" value="<?=$data->juridica_ie?>" >
													</div>
												</div>
												
											</div>					 
										</div>

										<div class="row form_margem">
											
											<div class="col-md-4 tipo_juridica">
												
												<div class="form-group">
													<label class="col-md-12">Representante Legal</label>
													<div class="col-md-12">
														<input name="juridica_responsavel" type="text" class="form-control" value="<?=$data->juridica_responsavel?>" >
													</div>
												</div>
												
											</div>

											<div class="col-md-4">

												<div class="form-group" >
													<label class="col-md-12" >CPF</label>
													<div class="col-md-12">
														<input name="fisica_cpf" id="cpf" type="text" class="form-control" value="<?=$data->fisica_cpf?>" >
													</div>
												</div>
												
											</div> 

										</div>

										<div class="row form_margem">
											
											<div class="col-md-4">

												<div class="form-group" >
													<label class="col-md-12" >Sexo</label>
													<div class="col-md-12">
														<select class="form-control select2" name="fisica_sexo" >
															<option value="" <?php if(!$data->fisica_sexo){ echo "selected=''"; } ?> >Selecione</option>
															<option value="M" <?php if($data->fisica_sexo == 'M'){ echo "selected=''"; } ?> >Masculino</option>
															<option value="F" <?php if($data->fisica_sexo == 'F'){ echo "selected=''"; } ?> >Feminino</option>
														</select>
													</div>
												</div>

											</div>
											<div class="col-md-3">
												<div class="form-group" >
													<label class="col-md-12" >Aniversário</label>
													<div class="col-md-12">
														<input name="fisica_nascimento" id="nascimento" type="text" class="form-control" value="<?php if($data->fisica_nascimento){ echo date('d/m/Y', $data->fisica_nascimento); } ?>" >
													</div>
												</div>
											</div>
										</div>

										<div style="padding-top:10px;"><hr></div>

										<div class="row">             		
											<div class="col-md-4">
												
												<div class="form-group" >
													<label class="col-md-12" >Endereço</label>
													<div class="col-md-12">
														<input name="endereco" type="text" class="form-control" value="<?=$data->endereco?>" >
													</div>
												</div>

											</div>
											<div class="col-md-2">

												<div class="form-group" >
													<label class="col-md-12" >Número</label>
													<div class="col-md-12">
														<input name="numero" type="text" class="form-control" value="<?=$data->numero?>" >
													</div>
												</div>
												
											</div>
											<div class="col-md-2">
												
												<div class="form-group" >
													<label class="col-md-12" >Complemento</label>
													<div class="col-md-12">
														<input name="complemento" type="text" class="form-control" value="<?=$data->complemento?>" >
													</div>
												</div>
												
											</div>
											<div class="col-md-4">

												<div class="form-group" >
													<label class="col-md-12" >Bairro</label>
													<div class="col-md-12">
														<input name="bairro" type="text" class="form-control" value="<?=$data->bairro?>" >
													</div>
												</div>
												
											</div>
										</div> 
										
										<div class="row form_margem">             		
											<div class="col-md-4">

												<div class="form-group" >
													<label class="col-md-12" >Estado</label>
													<div class="col-md-12">
														<input name="estado" type="text" class="form-control" value="<?=$data->estado?>" >								 
													</div>
												</div>
												
											</div>
											<div class="col-md-4">

												<div class="form-group" >
													<div class="form-group" >
														<label class="col-md-12" >Cidade</label>
														<div class="col-md-12">
															<input name="cidade" type="text" class="form-control" value="<?=$data->cidade?>" >								 
														</div>
													</div>
												</div>

											</div>
											<div class="col-md-3">

												<div class="form-group" >
													<label class="col-md-12" >Cep</label>
													<div class="col-md-12">
														<input name="cep" id="cep" type="text" class="form-control" value="<?=$data->cep?>" >
													</div>
												</div>

											</div>
										</div>		 

										<div style="padding-top:10px;"><hr></div>

									</fieldset>
									
									<div class="form_margem"></div>
									
								</div>
								
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary">Salvar</button>
											<input type="hidden" name="codigo" value="<?=$data->codigo?>">
											<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>detalhes/codigo/<?=$data->codigo?>';">Voltar</button>
										</div>
									</div>
								</div> 
								
							</form>
						</section>


						



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
	<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script> 
	<script src="<?=LAYOUT?>js/funcoes.js"></script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>api/jquery-maskedinput/jquery.maskedinput.min.js"></script>
	<script>
		
		function tipo_cadastro(tipo){
			if(tipo == 'J'){
				$('.tipo_fisica').hide();
				$('.tipo_juridica').show();
			} else {
				$('.tipo_fisica').show();
				$('.tipo_juridica').hide();
			}
		}
		tipo_cadastro('<?=$data->tipo?>');


		$(document).ready(function(){

			$(".select2").select2();

			$("#cpf").mask("999.999.999-99"); 
			$("#telefone").mask("(99) 99999-9999"); 
			$("#celular").mask("(99) 99999-9999"); 
			$("#cnpj").mask("99.999.999/9999-99");
			$("#cep").mask("99999-999");
			$("#nascimento").mask("99/99/9999");

		});        
		
	</script>
 	
	<script src="<?=LAYOUT?>js/ajuda.js"></script> 

</body>
</html>