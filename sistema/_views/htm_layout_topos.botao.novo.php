<?php include_once('base.php'); ?>
<form action="<?=$_base['objeto']?>botao_novo_grv" class="form-horizontal" method="post">
	
	<fieldset>

		<div class="form-group">
			<label class="col-md-12" >Titulo/Texto</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Funções Padronizadas</label>
			<div class="col-md-12">
				<select name="destino_padrao" class="form-control select2" style="width: 100%;" onChange="carregaendepadrao(this.value)" >
					<option value="" selected >Nenhum</option>
					<option value="index/carrinho" >Carrinho</option>
					<option value="index/minhaconta" >Minha Conta Loja</option>
					<option value="index/imoveis_cliente" >Minha Conta Imóveis</option>
					<option value="index/imoveis_favoritos" >Imóveis Favoritos</option>
					<option value="index/ligamospravc" >Nós ligamos pra você</option>
					<?php
					foreach ($destinos as $key => $value) {
						echo "<option value='".$value['chave']."' >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >Estilo do botão</label>
			<div class="col-md-12">
				<select name="botao_codigo" class="form-control select2" style="width: 100%;" > 
					<?php
					foreach ($botoes as $key => $value) {
						echo "<option value='".$value['codigo']."' >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Destino <?=ajuda('Digite um link ou selecione uma função padrão.')?></label>
			<div class="col-md-12">
				<input name="destino" id="destino" type="text" class="form-control" >
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