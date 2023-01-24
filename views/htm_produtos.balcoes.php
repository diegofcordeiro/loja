<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div>

	<div style="font-size: 18px; margin-bottom: 10px; text-align: center;">Nossos balcões de retirada</div>

	<hr>

	<div class="row">
		
		<div class="col-md-6">			
			<div class="form-group">
				<label class="col-md-12">Estado</label>
				<div class="col-md-12">
					<select name="uf" class="form-control select2" style="width: 100%;" onChange="cidades(this.value)"  >
						<option value='' selected >Selecione</option>
						<?php
						foreach ($estados as $key => $value) {
							echo "<option value='".$value['uf']."' >".$value['nome']."</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-12">Cidade</label>
				<div class="col-md-12" id="cidade_div" >
					<select id="cidade" name="cidade" class="form-control login_form" >
						<option value='' >Selecione</option>
					</select>
				</div>
			</div>
		</div>

	</div>

	<hr>

	<div id="lista_balcoes"></div>

</div>

<script>

  function cidades(estado){
    
    $('#cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:250px;' ></div>");
    
    $.post('<?=DOMINIO?>produtos/balcoes_cidades', {estado: estado},function(data){
      if(data){
        $('#cidade_div').html(data);
      }
    });
    
  }
  
  function lista_balcoes(estado, cidade){
    
    $('#lista_balcoes').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:250px;' ></div>");
    
    $.post('<?=DOMINIO?>produtos/balcoes_lista', {estado: estado, cidade: cidade},function(data){
      if(data){
        $('#lista_balcoes').html(data);
      }
    });
    
  }

</script>