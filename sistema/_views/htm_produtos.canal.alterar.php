<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>alterar_canal_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>
		<img src="<?=URL."arquivos/img_canais/".$data->id_canal."/".$data->banner?>" width="100" alt="">
		<img src="<?=URL."arquivos/img_canais/".$data->id_canal."/".$data->profile?>" width="100" alt="">
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->nm_canal?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-12" >Email</label>
			<div class="col-md-12">
				<input name="email" type="email" class="form-control" value="<?=$data->email?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<textarea name="bio" type="text" class="form-control"><?=$data->bio?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-12" >Banner</label>
			<div class="col-md-12">
				<input type="file" id="banner" name="banner" accept="image/*">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-12" >Foto do Professor</label>
			<div class="col-md-12">
				<input type="file" id="profile" name="profile" accept="image/*">
			</div>
		</div>

	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="codigo" value="<?=$data->id_canal?>">

</form>