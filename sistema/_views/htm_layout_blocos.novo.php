<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>blocos_novo_grv" class="form-horizontal" method="post" >
	
	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12">Número de Colunas</label>
			<div class="col-md-12">
				<select name="colunas" class="form-control select2" style="width: 100%;" >
					<option value='1' selected="" >1</option>
					<option value='2' >2</option>
					<option value='3' >3</option>													
					<option value='4' >4</option>
					<option value='6' >6</option>
				</select>
			</div>
		</div>
		
	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="pagina" value="<?=$pagina?>">

</form>