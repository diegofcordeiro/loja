<?php include_once('base.php'); ?>
<form action="<?=$_base['objeto']?>botao_alterar_grv" class="form-horizontal" method="post">
	
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
					<option value="" <?php if($data->endereco == ''){ echo "selected=''"; } ?> >Nenhum</option>
					<option value="index/carrinho" <?php if($data->endereco == 'index/carrinho'){ echo "selected=''"; } ?> >Carrinho</option>
					<option value="index/minhaconta" <?php if($data->endereco == 'index/minhaconta'){ echo "selected=''"; } ?> >Minha Conta Loja</option>
					<option value="index/imoveis_cliente" <?php if($data->endereco == 'index/imoveis_cliente'){ echo "selected=''"; } ?> >Minha Conta Imóveis</option>
					<option value="index/classificados_cliente" <?php if($data->endereco == 'index/classificados_cliente'){ echo "selected=''"; } ?> >Minha Conta Classificados</option>
					<option value="index/imoveis_favoritos" <?php if($data->endereco == 'index/imoveis_favoritos'){ echo "selected=''"; } ?> >Imóveis Favoritos</option>
					<option value="index/ligamospravc" <?php if($data->endereco == 'index/ligamospravc'){ echo "selected=''"; } ?> >Nós ligamos pra você</option>
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
			<label class="col-md-12" >Estilo do botão</label>
			<div class="col-md-12">
				<select name="botao_codigo" class="form-control select2" style="width: 100%;" > 
					<?php
					foreach ($botoes as $key => $value) {

						if($data->botao_codigo == $value['codigo']){ $selected = " selected='' "; } else { $selected = ""; }
						
						echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";
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
			<label class="col-md-12" >Visibilidade</label>
			<div class="col-md-12">
				<select name="ativo" class="form-control select2" style="width: 100%;" >
					<option value="0" <?php if($data->ativo == 0){ echo "selected=''"; } ?> >Não</option>
					<option value="1" <?php if($data->ativo == 1){ echo "selected=''"; } ?> >Sim</option>
				</select>
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="codigo" value="<?=$data->codigo?>" >
	<input type="hidden" name="topo_codigo" value="<?=$data->topo_codigo?>" >

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