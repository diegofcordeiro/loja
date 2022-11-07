<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_produto" class="form-horizontal" method="post" enctype="multipart/form-data" >
	
	<fieldset>

		<div class="form-group">
			<label class="col-md-12" >Titulo do produto</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" >
			</div>
		</div>

	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>

</form>