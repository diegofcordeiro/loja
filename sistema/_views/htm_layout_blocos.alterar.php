<?php include_once('base.php'); ?>


<form action="<?=$_base['objeto']?>blocos_alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >  					
	<fieldset>

		<div class="row" >
			<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-12">Tamanho</label>
					<div class="col-md-12">
						<select name="full" class="form-control select2" style="width: 100%;" >
							<option value='0' <?php if($data->full == 0){ echo " selected='' "; } ?> >Container</option>
							<option value='1' <?php if($data->full == 1){ echo " selected='' "; } ?> >Tela Cheia</option> 
						</select>
					</div>
				</div>
			</div>
		</div>										 


		<div class='form-group' >
			<label class='col-md-12' >Cor do Fundo:</label>
			<div class='col-md-6'>
				<input name='cor_fundo' type='text' class='form-control my-colorpicker1' value='<?=$data->cor_fundo?>' autocomplete='off' >
			</div>
		</div>




		<div class='form-group' >
			<label class='col-md-12' >Imagem fundo</label>
			<div class='col-md-12'>
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

		<?php if($data->img_fundo){ ?>

			<div style="text-align:left;">
				<img src="<?=PASTA_CLIENTE?>imagens/<?=$data->img_fundo?>" style="max-height:100px;" >
			</div>

			<div style="text-align:left; padding-top:10px;">
				<button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>apagar_fundo/codigo/<?=$data->codigo?>/pagina/<?=$data->pagina?>');" >Apagar Imagem</button>
			</div>

		<?php } ?>
	</div>
</div>

<hr>

<div style="text-align: center; font-size: 15px; margin-bottom:15px; margin-top: 20px; font-weight: bold;">Selecione o formato</div>

<?php
if($data->colunas == 1){
	?>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="12" <?php if($data->formato == '12'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-12">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php } ?>


<?php
if($data->colunas == 2){
	?>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="6_6" <?php if($data->formato == '6_6'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-6">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-6">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="4_8" <?php if($data->formato == '4_8'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-8">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="8_4" <?php if($data->formato == '8_4'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-8">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php } ?>



<?php
if($data->colunas == 3){
	?>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="4_4_4" <?php if($data->formato == '4_4_4'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="2_5_5" <?php if($data->formato == '2_5_5'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-5">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-5">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="5_2_5" <?php if($data->formato == '5_2_5'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-5">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-5">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="5_5_2" <?php if($data->formato == '5_5_2'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-5">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-5">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php } ?>


<?php
if($data->colunas == 4){
	?>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="3_3_3_3" <?php if($data->formato == '3_3_3_3'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-3">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-3">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-3">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
					<div class="col-md-3">
						<div class="quadro_coluna_bloco">Col. 4</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="4_2_2_4" <?php if($data->formato == '4_2_2_4'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 4</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="2_4_4_2" <?php if($data->formato == '2_4_4_2'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-4">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 4</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php } ?>


<?php
if($data->colunas == 6){
	?>

	<div class="row" >
		<div class="col-md-1">
			<input type="radio" name="formato" class="quadro_coluna_radio" value="2_2_2_2_2_2" <?php if($data->formato == '2_2_2_2_2_2'){ echo " checked='' "; } ?> >
		</div>
		<div class="col-md-11">					

			<div class="quadro_coluna_div">
				<div class="row">
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 1</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 2</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 3</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 4</div>
					</div>
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 5</div>
					</div>							
					<div class="col-md-2">
						<div class="quadro_coluna_bloco">Col. 6</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php } ?>

<hr>

<div style="text-align: center; font-size: 15px; margin-bottom:15px; margin-top: 20px; font-weight: bold;">Selecione os modulos</div>


<?php if($data->colunas >= 1){ ?>

	<div class="row" >
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-md-12">Coluna 1</label>
				<div class="col-md-12">
					<select name="coluna1" class="form-control select2" style="width: 100%;" >
						<option value='' <?php if(!$data->coluna1){ echo " selected='' "; } ?> >Nenhum</option>
						<?php

						foreach ($modulos_itens as $key => $value) {

							if($data->coluna1 == $value['codigo']){
								$selected = " selected='' ";
							} else {
								$selected = '';
							}

							echo "
							<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>
							";
						}

						?>
					</select>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<?php if($data->colunas >= 2){ ?>

	<div class="row" >
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-md-12">Coluna 2</label>
				<div class="col-md-12">
					<select name="coluna2" class="form-control select2" style="width: 100%;" >
						<option value='' <?php if(!$data->coluna2){ echo " selected='' "; } ?> >Nenhum</option>
						<?php

						foreach ($modulos_itens as $key => $value) {

							if($data->coluna2 == $value['codigo']){
								$selected = " selected='' ";
							} else {
								$selected = '';
							}

							echo "
							<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>
							";
						}

						?>
					</select>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<?php if($data->colunas >= 3){ ?>

	<div class="row" >
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-md-12">Coluna 3</label>
				<div class="col-md-12">
					<select name="coluna3" class="form-control select2" style="width: 100%;" >
						<option value='' <?php if(!$data->coluna3){ echo " selected='' "; } ?> >Nenhum</option>
						<?php

						foreach ($modulos_itens as $key => $value) {

							if($data->coluna3 == $value['codigo']){
								$selected = " selected='' ";
							} else {
								$selected = '';
							}

							echo "
							<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>
							";
						}

						?>
					</select>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<?php if($data->colunas >= 4){ ?>

	<div class="row" >
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-md-12">Coluna 4</label>
				<div class="col-md-12">
					<select name="coluna4" class="form-control select2" style="width: 100%;" >
						<option value='' <?php if(!$data->coluna4){ echo " selected='' "; } ?> >Nenhum</option>
						<?php

						foreach ($modulos_itens as $key => $value) {

							if($data->coluna4 == $value['codigo']){
								$selected = " selected='' ";
							} else {
								$selected = '';
							}

							echo "
							<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>
							";
						}

						?>
					</select>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<?php if($data->colunas >= 5){ ?>

	<div class="row" >
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-md-12">Coluna 5</label>
				<div class="col-md-12">
					<select name="coluna5" class="form-control select2" style="width: 100%;" >
						<option value='' <?php if(!$data->coluna5){ echo " selected='' "; } ?> >Nenhum</option>
						<?php

						foreach ($modulos_itens as $key => $value) {

							if($data->coluna5 == $value['codigo']){
								$selected = " selected='' ";
							} else {
								$selected = '';
							}

							echo "
							<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>
							";
						}

						?>
					</select>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<?php if($data->colunas >= 6){ ?>

	<div class="row" >
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-md-12">Coluna 6</label>
				<div class="col-md-12">
					<select name="coluna6" class="form-control select2" style="width: 100%;" >
						<option value='' <?php if(!$data->coluna6){ echo " selected='' "; } ?> >Nenhum</option>
						<?php

						foreach ($modulos_itens as $key => $value) {

							if($data->coluna6 == $value['codigo']){
								$selected = " selected='' ";
							} else {
								$selected = '';
							}

							echo "
							<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>
							";
						}

						?>
					</select>
				</div>
			</div>
		</div>
	</div>

<?php } ?>



<div>
	<button type="submit" class="btn btn-primary">Salvar</button>
	<button type="submit" class="btn btn-danger" onclick="confirma('<?=DOMINIO?>layout/blocos_apagar/codigo/<?=$data->codigo?>/pagina/<?=$data->pagina?>');">Remover</button>
	<input type="hidden" name="codigo" value="<?=$data->codigo?>" > 
	<input type="hidden" name="pagina" value="<?=$data->pagina?>" >
</div>

</form>
</div> 

<script type="text/javascript">
	$(function () {

		$(".my-colorpicker1").colorpicker();

	});
</script>