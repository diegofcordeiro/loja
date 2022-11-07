<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>gabarito_novo_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >Imagem do Icone</label>
			<div class="col-md-12">
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
		
		<div class="form-group">
			<label class="col-md-12" >Link</label>
			<div class="col-md-12">
				<input name="link" type="text" class="form-control" />
			</div>
		</div>


		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="produto" value="<?=$produto?>">

</form>