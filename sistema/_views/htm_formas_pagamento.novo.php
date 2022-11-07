<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post" >
	
	<fieldset>

		<div class="form-group" >
			<label class="col-md-12" >Estado</label>
			<div class="col-md-12">
				<select name="estado" class="form-control select2" onChange="cidades(this.value)" style="width: 100%;" >
					<option value="" selected="">Selecione</option>
					<?php
					
					foreach ($estados as $key => $value) {
						
						echo "<option value='".$value['uf']."' >".$value['nome']."</option>";

					}

					?>
				</select>
			</div>
		</div>

		<div id="cidade_div" style="margin-bottom: 15px; text-align: left;" > 
			<div class="form-group" >
				<label class="col-md-12" >Cidade</label>
				<div class="col-md-12">
					<select name="cidade" class="form-control select2" style="width: 100%;" >
						<option value='' >Selecione</option>
					</select> 
				</div>
			</div>
		</div>

	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>
	
</form>


<script type="text/javascript">

	function cidades(estado){

		$('#cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:20px;' ></div>");

		$.post('<?=DOMINIO?>formas_pagamento/cidades', {estado: estado},function(data){
			if(data){
				$('#cidade_div').html(data);
			}
		});

	}

	$(function () {
		$(".select2").select2();
	});

</script>