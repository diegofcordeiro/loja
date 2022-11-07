<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>alterar_entrega_auto_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >
	
	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Produto</label>
			<div class="col-md-12">
				<select data-plugin-selectTwo class="form-control select2" id="produto" name="produto"  onChange="alterar_texto()" <?php if($produto){ echo "disabled"; } ?> style="width: 100%;" >
					<option value='' >Selecione um produto</option>
					<?php
					foreach ($lista_produtos as $key => $value) {
						
						if($value['codigo'] == $produto){
							$selected = " selected ";
						} else {
							$selected = "";
						}
						
						echo "<option value='".$value['codigo']."' ".$selected." >".$value['ref']." - ".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Tamanho</label>
			<div class="col-md-12">
				<select data-plugin-selectTwo class="form-control select2" id="tamanho" name="tamanho" onChange="alterar_texto()" style="width: 100%;" >
					<option value='-' >Indefinido</option>
					<?php
					foreach ($lista_tamanhos as $key => $value) {
						
						if($value['codigo'] == $tamanho){
							$selected = " selected ";
						} else {
							$selected = "";
						}

						echo "<option value='".$value['codigo']."' ".$selected." >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >Cor</label>
			<div class="col-md-12">
				<select data-plugin-selectTwo class="form-control select2" id="cor" name="cor" onChange="alterar_texto()" style="width: 100%;" >
					<option value='-' >Indefinido</option>
					<?php
					foreach ($lista_cores as $key => $value) {
						
						if($value['codigo'] == $cor){
							$selected = " selected ";
						} else {
							$selected = "";
						}
						
						echo "<option value='".$value['codigo']."' ".$selected." >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >Variação</label>
			<div class="col-md-12">
				<select data-plugin-selectTwo class="form-control select2" id="variacao" name="variacao" onChange="alterar_texto()" style="width: 100%;" >
					<option value='-' >Indefinido</option>
					<?php
					foreach ($lista_variacoes as $key => $value) {
						
						if($value['codigo'] == $variacao){
							$selected = " selected ";
						} else {
							$selected = "";
						}
						
						echo "<option value='".$value['codigo']."' ".$selected." >".$value['titulo']."</option>";
					}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group" >
			<label class="col-md-12" >Texto para Entrega</label>
			<div class="col-md-12" >
				<div id="div_texto" >
					<textarea name="texto" rows="5" class="form-control" ><?=$texto?></textarea>
				</div>
			</div>
		</div>

	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<?php if($produto){ ?>
		<input type="hidden" name="produto" value="<?=$produto?>">
	<?php } ?>
	<input type="hidden" name="retorno" value="<?=$retorno?>">
	
</form>

<script>
	$(function () {  	
		$(".select2").select2();
	});

	function alterar_texto(){

		$('#div_texto').html("<img src='"+dominio()+"_views/img/loading.gif' style='width:25px;'>");
		
		var produto = $('#produto').val();
		var tamanho = $('#tamanho').val();
		var cor = $('#cor').val();
		var variacao = $('#variacao').val(); 
		
		$.post("<?=$_base['objeto']?>texto_entrega_auto", { produto: produto, tamanho: tamanho, cor: cor, variacao: variacao },function(retorno){
			$('#div_texto').html('<textarea name="texto" rows="5" class="form-control" >'+retorno+'</textarea>');
		});
		
	}

</script>