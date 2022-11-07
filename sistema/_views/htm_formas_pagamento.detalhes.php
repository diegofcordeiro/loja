<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >
	
	<fieldset>
		
		<div class="form-group">
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" disabled >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12">Ativar/desativar esta opção de pagamento</label>
			<div class="col-md-3">
				<select data-plugin-selectTwo class="form-control populate" name="ativo" >
					<option value='0' <?php if($data->ativo == 0){ echo "selected"; } ?> >Ativo</option>
					<option value='1' <?php if($data->ativo == 1){ echo "selected"; } ?> >Inativo</option>
				</select>
			</div>
		</div>

		<?php if($id == 1){ ?>

			<div class="form-group">
				<label class="col-md-12" >E-mail no Pagseguro</label>
				<div class="col-md-12">
					<input name="email_pagseguro" type="text" class="form-control" value="<?=$data->email_pagseguro?>" >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-12" >Token de Retorno</label>
				<div class="col-md-12">
					<input name="token_retorno_pagseguro" type="text" class="form-control" value="<?=$data->token_retorno_pagseguro?>" >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-12" >Endereço de Finalização da Compra</label>
				<div class="col-md-12">
					<?=$endereco_finalizacao?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Endereço do Retorno de Dados</label>
				<div class="col-md-12">
					<?=$endereco_retorno?>
				</div>
			</div>

		<?php } ?>


		<?php if( ($id == 2) OR ($id == 4) ){ ?>
				
			<div class="form-group">
				<label class="col-md-12" >Desconto de R$ (Valor Fixo)</label>
				<div class="col-md-12">
					<input name="desconto_fixo" type="text" class="form-control" value="<?=$desconto_fixo?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)"  >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-12" >Desconto de % (Porcentagem)</label>
				<div class="col-md-12">
					<input name="desconto_porc" type="text" class="form-control" value="<?=$desconto_porc?>" onkeypress="Mascara(this,porcentagem)" onKeyDown="Mascara(this,porcentagem)"  maxlength="5" >
				</div>
			</div>
			
		<?php } ?>
		
		<?php if($id == 2){ ?>
			
			<div class="form-group">
				<label class="col-md-12">Dados para Depósito</label>
				<div class="col-md-12">
					<textarea name="deposito_dados" rows="5" class="form-control" ><?=$data->deposito_dados?></textarea>
				</div>
			</div>
			
		<?php } ?>  
		
		<?php if( ($id == 3) OR ($id == 8) ){ ?>
			
			<div style="font-size: 14px; margin-bottom: 10px;">Estas informações estão neste <a href="https://www.mercadopago.com/mlb/account/credentials" target="_blank">link</a> lembre-se de estar logado na sua conta do MercadoPago</div>

			<div class="form-group">
				<label class="col-md-12" >Client Id </label>
				<div class="col-md-12">
					<input name="mercadopago_client_id" type="text" class="form-control" value="<?=$data->mercadopago_client_id?>" >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Client Secret</label>
				<div class="col-md-12">
					<input name="mercadopago_client_secret" type="text" class="form-control" value="<?=$data->mercadopago_client_secret?>" >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Public key</label>
				<div class="col-md-12">
					<input name="mercadopago_public_key" type="text" class="form-control" value="<?=$data->mercadopago_public_key?>" >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-12" >Access token</label>
				<div class="col-md-12">
					<input name="mercadopago_access_token" type="text" class="form-control" value="<?=$data->mercadopago_access_token?>" >
				</div>
			</div>

		<?php } ?>

		<?php if($id == 4){ ?>
			
			<div class="form-group">
				<label class="col-md-12" >Acount</label>
				<div class="col-md-12">
					<input name="paypal_conta" type="text" class="form-control" value="<?=$data->paypal_conta?>" >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Client ID</label>
				<div class="col-md-12">
					<input name="paypal_clienteid" type="text" class="form-control" value="<?=$data->paypal_clienteid?>" >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-12" >Client Secret</label>
				<div class="col-md-12">
					<input name="paypal_clientesecret" type="text" class="form-control" value="<?=$data->paypal_clientesecret?>" >
				</div>
			</div>

		<?php } ?>

		<?php if($id == 5){ ?>
			
			<div class="form-group">
				<label class="col-md-12" >API KEY</label>
				<div class="col-md-12">
					<input name="vindi_key" type="text" class="form-control" value="<?=$data->vindi_key?>" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-12" >URL</label>
				<div class="col-md-12">
					<input name="vindi_url" type="text" class="form-control" value="<?=$data->vindi_url?>" >
				</div>
			</div>

		<?php } ?>

		<?php if($id == 6){ ?> 

			<div class="form-group">
				<label class="col-md-12" >Client ID</label>
				<div class="col-md-12">
					<input name="cielo_clientId" type="text" class="form-control" value="<?=$data->cielo_clientId?>" >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-12" >Client Secret</label>
				<div class="col-md-12">
					<input name="cielo_clientSecret" type="text" class="form-control" value="<?=$data->cielo_clientSecret?>" >
				</div>
			</div>
			
		<?php } ?>

		<?php if($id > 10){ ?>

			<div class="form-group" >
				<label class="col-md-12" >Estado/Cidade</label>
				<div class="col-md-12">
					<select id="estado" name="estado" class="form-control select2" onChange="cidades(this.value)" style="width: 100%;" >
						<?php

						foreach ($estados as $key => $value) {

							if($data->estado == $value['uf']){ $select = "selected"; } else { $select = ""; }

							echo "<option value='".$value['uf']."' $select >".$value['nome']."</option>";

						}

						?>
					</select>
				</div>
			</div>
			
			<div id="cidade_div" style="margin-bottom: 15px; text-align: left;" > 
				<div class="form-group" > 
					<div class="col-md-12">
						<select id="cidade" name="cidade" class="form-control select2" style="width: 100%;" >
							<option value='' >Selecione</option>
						</select>
					</div>
				</div>
			</div>
			
		<?php } ?>




	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="id" value="<?=$data->id?>">

</form>

<?php if( $id >= 5 ){ ?>

	<!-- <script type="text/javascript">

		function cidades(estado){

			$('#cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:20px;' ></div>");

			$.post('<?=DOMINIO?>formas_pagamento/cidades', {estado: estado, cidade: '<?=$data->cidade?>'},function(data){
				if(data){
					$('#cidade_div').html(data);
				}
			});

		}
		cidades('<?=$data->estado?>');

	</script> -->

	<?php } ?>