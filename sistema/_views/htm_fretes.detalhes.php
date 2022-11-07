<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>
		
		<div class="form-group">
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" disabled >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12">Nome para exibição</label>
			<div class="col-md-12">
				<input name="titulo_exibicao" type="text" class="form-control" value="<?=$data->titulo_exibicao?>" style="width: 100%;" >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12">Ativar/desativar esta opção de frete</label>
			<div class="col-md-4">
				<select class="form-control select2" name="ativo" style="width: 100%;" >
					<option value='0' <?php if($data->ativo == 0){ echo "selected"; } ?> >Ativo</option>
					<option value='1' <?php if($data->ativo == 1){ echo "selected"; } ?> >Inativo</option>
				</select>
			</div>
		</div>

		<?php if( ($data->id == 1) OR ($data->id == 2) OR ($data->id == 5) ){ ?>

			<div class="form-group">
				<label class="col-md-12">Cep do Remetente</label>
				<div class="col-md-12">
					<input name="cep" type="text" class="form-control" value="<?=$data->cep?>" >
				</div>
			</div>

		<?php } ?>

		<?php if( $data->id == 5 ){ ?>

			<div class="form-group" >
				<label class="col-md-12" >Melhor Envio Client Id</label>
				<div class="col-md-12">					
					<input name="melhor_envio_id" type="text" class="form-control" value="<?=$data->melhor_envio_id?>" style="width: 100%;" >
				</div>
			</div>
			
			<div class="form-group" >
				<label class="col-md-12" >Melhor Envio Secret</label>
				<div class="col-md-12">						
					<input name="melhor_envio_secret" type="text" class="form-control" value="<?=$data->melhor_envio_secret?>" style="width: 100%;" >
				</div>
			</div>

			<div class="form-group" >
				<label class="col-md-12" >Token de Acesso</label>
				<div class="col-md-12">						
					<textarea name="melhor_envio_token_fixo" class="form-control" style="height: 70px;" ><?=$data->melhor_envio_token_fixo?></textarea>
				</div>
			</div>

			<div class="form-group" >
				<label class="col-md-12" >Link Callback</label>
				<div class="col-md-12">						
					<input name="callback_melhor_envios" type="text" class="form-control" value="<?=$melhor_envios_callback?>" style="width: 100%;" >
				</div>
			</div>

			<div style="margin-top: 20px; margin-bottom: 20px;">
				Status da autorização: <?=$autorizacao_melhor_envios?>				
			</div>

		<?php } ?>

		<?php if( $data->id >= 6 ){ ?>

			<div class="form-group" >
				<label class="col-md-12" >Estado para proximidade</label>
				<div class="col-md-12">
					<select id="estado" name="estado" class="form-control select2" onChange="cidades(this.value)" style="width: 100%;" >
						<?php

						foreach ($estados as $key => $value) {

							if($data->proximidade_estado == $value['uf']){ $select = "selected"; } else { $select = ""; }

							echo "<option value='".$value['uf']."' $select >".$value['nome']."</option>";

						}

						?>
					</select>
				</div>
			</div>

			<div id="cidade_div" style="margin-bottom: 15px; text-align: left;" >
				<div class="form-group" >
					<div class="form-group" >
						<label class="col-md-12" >Cidade para proximidade</label>
						<div class="col-md-12">
							<select id="cidade" name="cidade" class="form-control select2" style="width: 100%;" >
								<option value='' >Selecione</option>
							</select>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>



		<?php if( ($data->id == 1) OR ($data->id == 2) OR ($data->id == 4) OR ($data->id >= 5) ){ ?>

			<div class="form-group">
				<label class="col-md-12" >Acrescimo de valor fixo no valor do pedido</label>
				<div class="col-md-3">
					<input name="acrescimo_fixo" type="text" class="form-control" value="<?=$acrescimoFixo?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
				</div>
			</div>

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) OR ($data->id == 4) OR ($data->id >= 5) ){ ?>

			<div class="form-group">
				<label class="col-md-12" >Acrescimo (%) no valor do pedido</label>
				<div class="col-md-7">
					<input name="acrescimo_porc" type="text" class="form-control" value="<?=$data->acrescimo_porc?>" onkeypress="Mascara(this,porcentagem)" onKeyDown="Mascara(this,porcentagem)" >
				</div>
			</div>				 

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) OR ($data->id == 4) OR ($data->id >= 5) ){ ?>

			<div class="form-group">
				<label class="col-md-12">Frete gratis para compras acima de</label>
				<div class="col-md-3">
					<input name="gratis_acima_de" type="text" class="form-control" value="<?=$gratis_acima_de?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
				</div>
			</div>

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) ){ ?>

			<hr>

			<table class="table table-bordered table-hover" >

				<thead>
					<tr>
						<th>Estado</th>
						<th>UF</th>
						<th>Tipo do Frete</th>
						<th>Valor Fixo R$</th>
					</tr>
				</thead>

				<tbody id="sortable_lista" >					 

					<?php

					foreach ($frete_estado as $key => $value) {

						if($value['tipo'] == 0){
							$check1 = 'checked';
							$check2 = '';
							$dest = "";
						} else {
							$check1 = '';
							$check2 = 'checked';
							$dest = " style=' border: 1px solid #666; ' ";
						}

						echo '
						<tr>
						<td>'.$value['titulo'].'</td>
						<td>'.$value['uf'].'</td>
						<td>
						<input type="radio" name="estado_tipo_'.$value['uf'].'" id="tipo_'.$value['uf'].'_a" value="0" '.$check1.' > 
						<label for="tipo_'.$value['uf'].'_a" >Normal</label><br>
						<input type="radio" name="estado_tipo_'.$value['uf'].'" id="tipo_'.$value['uf'].'_b" value="1" '.$check2.' > 
						<label for="tipo_'.$value['uf'].'_b" >Valor Fixo</label>
						</td>
						<td > 
						<input name="estado_fixo_'.$value['uf'].'" type="text" class="form-control" value="'.$value['valor'].'" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" '.$dest.' >
						</td>
						</tr>
						';

					}
					?>

				</tbody>
			</table>

		<?php } ?>

	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="id" value="<?=$data->id?>">

</form>

<?php if( $data->id >= 5 ){ ?>

	<script type="text/javascript">

		function cidades(estado){

			$('#cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:20px;' ></div>");

			$.post('<?=DOMINIO?>entrega/cidades', {estado: estado, cidade: '<?=$data->proximidade_cidade?>'},function(data){
				if(data){
					$('#cidade_div').html(data);
				}
			});

		}
		cidades('<?=$data->proximidade_estado?>');

	</script>

<?php } ?>

<script>
	$(function () {
		$(".select2").select2();
	});
</script>