<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div style="margin-top: 15px;">
	<div style="font-size: 14px; padding-bottom: 5px; font-weight: bold; ">Categorias</div>
	<select name="categoria" class="form-control" style="width: 100%;" onchange="lista_modelos(this.value);" >
		<option value="" >Selecione</option>
		<?php

		foreach ($categorias as $key => $value) {

			echo "
			<option value='".$value['codigo']."' >".$value['titulo']."</option>
			";
			
		}

		?>
	</select>
</div>

<div id="lista_modelos"></div>

<script>
	function lista_modelos(categoria){
		
		$('#lista_modelos').html("<div style='text-align:center; margin:30px;'><img src='<?=LAYOUT?>img/loading.gif'></div>");
		
		$.post('<?=DOMINIO?><?=$controller?>/produto_modelos_gratis_lista', { produto: '<?=$produto?>', categoria: categoria }, function(data){
			if(data){
				$('#lista_modelos').html(data);
			}
		});

	}
</script>