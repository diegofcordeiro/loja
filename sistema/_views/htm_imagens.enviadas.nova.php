<?php include_once('base.php'); ?>

<section>
	<form action="<?=$_base['objeto']?>criar_grv" method="post" enctype="multipart/form-data">

		<fieldset>

			<div class="form-group">
				<label>Titulo <?=ajuda('O titulo não aparece no site');?></label>
				<input name="titulo" type="text" class="form-control" >				 
			</div>

			<label>Selecione o arquivo da imagem</label> 
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

		</fieldset>

		<div style="text-align:left; padding-top:20px;">
			<button type="submit" class="btn btn-primary">Enviar</button> 
		</div>

	</form>
</section>