<?php include_once('base.php'); ?>

<select id="cidade" name="cidade" class="form-control select2" style="width: 100%;" >
	<option value='' >Selecione</option>
	<?php
	
	foreach ($cidades as $key => $value) {
		
		if($value['selected']){ $select = "selected"; } else { $select = ""; }
		
		echo "<option value='".$value['nome']."' $select >".$value['nome']."</option>";
		
	}
	
	?>
</select>

<script>
	$(function () {
		$(".select2").select2();
	});
</script>