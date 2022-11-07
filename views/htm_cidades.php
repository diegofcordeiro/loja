<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<select id="cidade" name="cidade" class="form-control select2 cadastro_select" >
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
