<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">
	
	<fieldset>

		<div class="form-group">
			<label class="col-md-12" >Nome</label>
			<div class="col-md-12">
				<input name="nome" type="text" class="form-control" >
			</div>
		</div>

        <div class="form-group">
			<label class="col-md-12" >Telefone</label>
			<div class="col-md-12">
				<input name="telefone" type="text" class="form-control" >
			</div>
		</div>

        <div class="form-group">
			<label class="col-md-12" >Documento</label>
			<div class="col-md-12">
				<input name="documento" type="text" class="form-control" >
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >E-mail</label>
			<div class="col-md-12">
				<input name="email" type="text" class="form-control" >
			</div>
		</div>

	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	
</form>

<!-- <script src="<?=LAYOUT?>js/ajuda.js"></script> -->