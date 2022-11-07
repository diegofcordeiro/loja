<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>modelos_alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12">Categoria</label>
			<div class="col-md-12">
				<select name="categoria" class="form-control select2" style="width: 100%;" >
					<option value='' selected >Selecione</option>
					<?php
					foreach ($categorias as $key => $value) {

						if($data->categoria == $value['codigo']){
							$selected = " selected='' ";
						} else {
							$selected = "";
						}

						echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Imagem</label>
			<div class="col-md-12">
				<img src="<?=PASTA_CLIENTE?>img_produtos_modelos/<?=$data->imagem?>" style="width: 100%;">
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="codigo" value="<?=$data->codigo?>" />
</form>