<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>alterar_categoria_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>
		<img style="height: 40px;margin-bottom: 15px;" src="<?=URL.'arquivos/p/'?><?=$data->imagem?>" alt="">
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>">
			</div>
			<label class="col-md-12" >Cor do texto</label>
			<div class="col-md-12">
				<input type="color" name="cor_texto" value="<?=$data->cor_texto?>">
			</div>
			<label class="col-md-12" >Cor do fundo</label>
			<div class="col-md-12">
				<input type="color" name="cor_fundo" value="<?=$data->cor_fundo?>">
			</div>
			
			<label class="col-md-12" >Icone</label>
			<div class="col-md-12">
				<input type="file" id="image" name="image" accept="image/*">
			</div>
		</div>

	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="id" value="<?=$data->id?>">
	<input type="hidden" name="codigo" value="<?=$data->codigo?>">

</form>