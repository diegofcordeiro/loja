<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">
	
	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Destino, sem acentos ou espaços, ex: nossos_servicos.</label>
			<div class="col-md-12">
				<input name="chave" type="text" class="form-control" >
			</div>
		</div>

	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>	
</form>