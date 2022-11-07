<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>menu_alterar_grv" class="form-horizontal" method="post">
	
	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Destinos Padronizados <?=ajuda('Selecione uma pagina padrão.')?></label>
			<div class="col-md-12">
				<select name="destino_padrao" class="form-control select2" style="width: 100%;" onChange="carregaendepadrao(this.value)" >
					<option value='' selected >Nenhum</option>
					<?php
					foreach ($destinos as $key => $value) {
						if($value['chave'] == $data->endereco){
							$selected= " selected='' ";
						} else {
							$selected= "";
						} 
						echo "<option value='".$value['chave']."' $selected >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Destino <?=ajuda('Digite um link ou selecione uma pagina padrão.')?></label>
			<div class="col-md-12">
				<input name="destino" id="destino" type="text" class="form-control" value="<?=$data->endereco?>" >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12">Visibilidade <?=ajuda('Selecione ativado para mostrar este menu no site e desativado para esconder.')?></label>
			<div class="col-md-6">
				<select name="visivel" class="form-control select2" style="width: 100%;" >
					<option value="0" <?php if($data->visivel == 0){ echo " selected='' "; } ?> >Ativado</option>
					<option value="1" <?php if($data->visivel == 1){ echo " selected='' "; } ?> >Desativado</option>
				</select>
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	
	<button type="button" class="btn btn-default" onClick="confirma('<?=$_base['objeto']?>menu_apagar/codigo/<?=$data->codigo?>/rodape_codigo/<?=$data->rodape_codigo?>');" >Apagar</button>
		
	<input type="hidden" name="codigo" value="<?=$data->codigo?>" >
	<input type="hidden" name="rodape_codigo" value="<?=$data->rodape_codigo?>" >

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