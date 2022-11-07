<?php include_once('base.php'); ?>
<form action="<?=$_base['objeto']?>css_novo_grv" class="form-horizontal" method="post">
	
	<fieldset>

		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" >
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="topo_codigo" value="<?=$codigo_topo?>">
	
</form>
</section>

<script>

	$(document).ready(function() {
		
		$(".select2").select2();
		
	}); 

</script>

<script src="<?=LAYOUT?>js/ajuda.js"></script>
 