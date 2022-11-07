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
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />

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

							<ul class="nav nav-tabs ">

								<?php if($acesso_smtp){ ?>
									<li <?php if($aba_selecionada == "smtp"){ echo "class='active'"; } ?> >
										<a href="#smtp" data-toggle="tab">Envio Smtp</a>
									</li>
								<?php } ?>

								<!-- <?php if($acesso_logo){ ?>
									<li <?php if($aba_selecionada == "imagem"){ echo "class='active'"; } ?> >
										<a href="#imagem" data-toggle="tab">Imagem da Organização</a>
									</li>
								<?php } ?>

								<?php if($acesso_mascara){ ?>
									<li <?php if($aba_selecionada == "mascara"){ echo "class='active'"; } ?> >
										<a href="#mascara" data-toggle="tab">Marca d'água</a>
									</li>
								<?php } ?>
								
								<?php if($acesso_analytics){ ?>
									<li <?php if($aba_selecionada == "analytics"){ echo "class='active'"; } ?> >
										<a href="#analytics" data-toggle="tab">Google Analytics</a>
									</li>
								<?php } ?> -->

							</ul>

							<div class="tab-content" >

								<?php if($acesso_smtp){ ?>
									<div id="smtp" <?php if($aba_selecionada == "smtp"){ echo "class='tab-pane active'"; } else { echo "class='tab-pane'"; } ?> >
										<form action="<?=$_base['objeto']?>smtp_grv" class="form-horizontal" method="post">
											
											<div style="font-size: 14px; margin-bottom: 20px;">A configuração de envio de SMPT é usada para envio de email autenticado no site, em qualquer ponto do site que seja necessário enviar um email será usada esta configuração, por tanto não use contas como contato@ ou atendimento@, crie uma conta para uso exclusivo de envio ex.: naoresponda@seudominio.com ou envio@seudominio.com.</div>
											
											<fieldset>

												<div class="form-group">
													<label class="col-md-12" >Nome de Exibição <?=ajuda('O nome que vai aparecer para quem receber um e-mail através desta conta')?></label>
													<div class="col-md-7">
														<input name="email_nome" type="text" class="form-control" value="<?=$data->email_nome?>" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-12" >E-mail de Envio</label>
													<div class="col-md-7">
														<input name="email_origem" type="text" class="form-control" value="<?=$data->email_origem?>" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-12" >E-mail de Retorno <?=ajuda('O email de retorno é o email de resposta, porem alguns servidores de e-mail consideram uma má pratica utilizar um e-mail de retorno diferente do e-mail de envio, podendo recusar o envio ou até mesmo classificar o envio como lixo eletronico.')?></label>
													<div class="col-md-7">
														<input name="email_retorno" type="text" class="form-control" value="<?=$data->email_retorno?>" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-12" >Porta <?=ajuda('Solicite esta informação junto ao suporte do seu servidor de hospedagem.')?></label>
													<div class="col-md-7">
														<input name="email_porta" type="text" class="form-control" value="<?=$data->email_porta?>" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-12" >Host <?=ajuda('Solicite esta informação junto ao suporte do seu servidor de hospedagem.')?></label>
													<div class="col-md-7">
														<input name="email_host" type="text" class="form-control" value="<?=$data->email_host?>" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-12" >Usuário <?=ajuda('Login de acesso da conta de e-mail')?></label>
													<div class="col-md-7">
														<input name="email_usuario" type="text" class="form-control" value="<?=$data->email_usuario?>" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-12" >Senha <?=ajuda('Senha de acesso da conta de e-mail')?></label>
													<div class="col-md-7">
														<input name="email_senha" type="text" class="form-control" value="<?=$data->email_senha?>" >
													</div>
												</div>

												<hr>

												<div class="form-group">
													<label class="col-md-12" >Deseja testar as configurações? <?=ajuda('Marque esta opção para efetuar um teste nas configurações, informando um e-mail de destino no proximo campo')?></label>
													<div class="col-md-6">
														<select name="email_testes" class="form-control select2" style="width: 100%;" >
															<option value="sim" >Sim</option>
															<option value="" >Não</option>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-12" >E-mail de destino para testes</label>
													<div class="col-md-7">
														<input name="email_testes_destino" type="text" class="form-control" >
													</div>
												</div>

											</fieldset>
											
											<div>
												<button type="submit" class="btn btn-primary">Salvar</button>
											</div>
											
										</form>
									</div>
								<?php } ?>

								<?php if($acesso_logo){ ?>
									<div id="imagem" <?php if($aba_selecionada == "imagem"){ echo "class='tab-pane active'"; } else { echo "class='tab-pane'"; } ?> >

										<div style="font-size: 14px; margin-bottom: 20px;">Personalize este painel com sua logo.</div>
										
										<?php if($data->logo){ ?>
											
											<div><img src="<?=PASTA_CLIENTE?>img_logo/<?=$data->logo?>" style="border:0px; max-width:300px;" ></div>
											
											<div style="padding-top:10px">
												<button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>apagar_logo');"  >Apagar Imagem</button>
											</div>
											
										<?php } else { ?>
											
											<form action="<?=$_base['objeto']?>logo" class="form-horizontal" method="post" enctype="multipart/form-data" >
												
												<fieldset>
													<div class="form-group">
														<label class="col-md-12">Arquivo</label>
														<div class="col-md-7">
															<div class="fileupload fileupload-new" data-provides="fileupload">
																<div class="input-append">
																	<div class="uneditable-input">
																		<i class="fa fa-file fileupload-exists"></i>
																		<span class="fileupload-preview"></span>
																	</div>
																	<span class="btn btn-default btn-file">
																		<span class="fileupload-exists">Alterar</span>
																		<span class="fileupload-new">Procurar arquivo</span>
																		<input type="file" name="arquivo" />
																	</span>
																	<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												
												<div>
													<button type="submit" class="btn btn-primary">Enviar</button>
												</div>
												
											</form>
											
										<?php } ?>
										
									</div>
								<?php } ?>


								<?php if($acesso_mascara){ ?>
									<div id="mascara" <?php if($aba_selecionada == "mascara"){ echo "class='tab-pane active'"; } else { echo "class='tab-pane'"; } ?> >

										<div style="font-size: 14px; margin-bottom: 20px;">
											A marca d'agua é utilizada para marcar fotos do site com sua logo ou uma mascara que impeça a cópia das imagens sem autorização, adicionando sua mascara todas as fotos adicionadas  posteriormente a alteração ficarão com esta marca, você pode adicioanr quantas mascaras quiser, apenas lembre de ativar selecionar qual marca d'agua deseja utilizar antes de enviar suas fotos.
										</div>

										<form action="<?=$_base['objeto']?>apagar_mascara" method="post" id="form_mascara" name="form_mascara" >

											<div>
												<button type="button" class="btn btn-primary" onClick="window.location='<?=$_base['objeto']?>nova_mascara';">Nova</button>
												<button type="button" class="btn btn-default" onClick="apagar_varios('form_mascara');" >Apagar Selecionados</button>
											</div>

											<hr>

											<table id="tabela1" class="table table-bordered table-striped">

												<thead>
													<tr>
														<th class='center' style='width:30px;' >Sel.</th>					                    
														<th>Titulo</th>
														<th>Posição</th>
														<th>Preencher</th>
														<th>Conteúdo</th>
													</tr>
												</thead>
												
												<tbody>
													<?php
													
													foreach ($mascaras as $key => $value) {

														$endereco = " onClick=\"window.location='".$_base['objeto']."alterar_mascara/codigo/".$value['codigo']."';\" style='cursor:pointer;' ";

														$endereco_imagem = " onClick=\"window.open('".$value['imagem']."', '_blank');\" style='cursor:pointer;' ";

														echo "
														<tr>
														<td class='center' style='width:30px;' ><input type='checkbox' class='marcar' name='apagar_".$value['id']."' value='1' ></td>
														<td $endereco >".$value['titulo']."</td>
														<td $endereco >".$value['posicao']."</td>
														<td $endereco >".$value['preencher']."</td>
														<td $endereco_imagem >".$value['imagem']."</td>
														</tr>
														";
													}
													
													?>
												</tbody>

											</table>
											
										</form>
									</div>
								<?php } ?>
								


								<?php if($acesso_analytics){ ?>
									<div id="analytics" <?php if($aba_selecionada == "analytics"){ echo "class='tab-pane active'"; } else { echo "class='tab-pane'"; } ?> >
										<form action="<?=$_base['objeto']?>analytics_grv" class="form-horizontal" method="post">
											
											<div style="font-size: 14px; margin-bottom: 20px;">Solicite o codigo de acompanhamento com o administrador do site ou crie sua conta no <a href='https://analytics.google.com/' target='_blank' >Google Analytcs</a>.</div>
											
											<fieldset>
												
												<div class="form-group">
													<label class="col-md-12" >Código de acompanhamento</label>
													<div class="col-md-7">
														<textarea name="acompanhamento" class="form-control" style="height:250px;"><?=htmlspecialchars_decode(base64_decode($data->analytcs));?></textarea>
													</div>
												</div>
												
											</fieldset>
											
											<div>
												<button type="submit" class="btn btn-primary">Salvar</button>
											</div>
											
										</form>
									</div>
								<?php } ?>


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
		<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
		<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
		<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
		<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
		<script src="<?=LAYOUT?>js/funcoes.js"></script>
		<script> 
			$(function(){

				$(".select2").select2();

				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue'
				});
			});
		</script>
		<script src="<?=LAYOUT?>js/ajuda.js"></script> 
	</body>
	</html>