<?php include_once('base.php'); ?>
<form action="<?=$_base['objeto']?>menu_novo_grv" class="form-horizontal" method="post">
	
	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" >
			</div>
		</div>
		
		<?php 

		if(count($categorias) != 0){

			?>

			<div class="form-group">
				<label class="col-md-12" >Vincular Categoria de Produto</label>
				<div class="col-md-12">
					<select name="categoria" class="form-control select2" style="width: 100%;" >
						<option value='' selected >Nenhuma</option>
						<?php
						foreach ($categorias as $key => $value) {

							echo "<option value='".$value['codigo']."' >".$value['titulo']."</option>";

						}
						?>
					</select>
				</div>
			</div>

		<?php } ?>
		
		<div class="form-group">
			<label class="col-md-12" >Destinos Padronizados <?=ajuda('Selecione uma pagina padrão.')?></label>
			<div class="col-md-12">
				<select name="destino_padrao" class="form-control select2" style="width: 100%;" onChange="carregaendepadrao(this.value)" >
					<option value='' selected >Nenhum</option>
					<?php
					foreach ($destinos as $key => $value) {
						echo "<option value='".$value['chave']."' >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Destino <?=ajuda('Digite um link ou selecione uma pagina padrão.')?></label>
			<div class="col-md-12">
				<input name="destino" id="destino" type="text" class="form-control" >
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >Icone (fontawesome)</label>
			<div class="col-md-12">
				<input name="icone" type="text" class="form-control" >
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

<script type="text/javascript">

	function carregaendepadrao(endereco){
		$('#destino').val(endereco);
	}

</script>