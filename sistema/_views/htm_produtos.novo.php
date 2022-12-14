<?php include_once('base.php'); ?>
<link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>

<form action="<?=$_base['objeto']?>novo_produto" class="form-horizontal" method="post" enctype="multipart/form-data" >
	
	<fieldset>

		<div class="form-group">
			<label class="col-md-12" >Titulo da Trilha</label>
			<div class="col-md-12">
				<select class="form-control select2" id="ref" name="ref">
					<?php foreach($lista_trilha_lms as $trilha){ ?>
						<option data-title="<?=$trilha['nome_trilha']?>" value='<?=$trilha['id_trilha']?>'><?=$trilha['id_trilha'].' - '.$trilha['nome_trilha']?></option>
					<?php }?>
				</select>
				<input name="titulo" type="hidden" id="titulo" class="form-control" value="<?=$data->titulo?>" >
			</div>
		</div>

	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>

</form>

<script>
	$(document).ready(function() {
		$(".select2").select2();

          var title = $("select#ref option:selected").text();
            $('#titulo').val(title);

          $("#ref").change(function(){
            var title = $("select#ref option:selected").text();
            $('#titulo').val(title);
          });

        });
</script>