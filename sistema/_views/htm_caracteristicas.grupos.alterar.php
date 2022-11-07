<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>grupos_alterar_grv" class="form-horizontal" method="post" >
	
	<fieldset>

		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<textarea name="titulo" class="summernote" ><?=$data->titulo?></textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >Mostrar titulo</label>
			<div class="col-md-12">
				<select name="mostrar_titulo" class="form-control select2" style="width: 100%;" >
					<option value='1' <?php if($data->mostrar_titulo == 1){ echo " selected='' "; } ?> >Sim</option>
					<option value='0' <?php if($data->mostrar_titulo == 0){ echo " selected='' "; } ?> >Não</option> 
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Ordem dos Itens</label>
			<div class="col-md-12">
				<select name="ordem_itens" class="form-control select2" style="width: 100%;" >
					<option value='1' <?php if($data->ordem_itens == 1){ echo " selected='' "; } ?> >Imagem, Icone, Titulo, Descrição</option>
					<option value='2' <?php if($data->ordem_itens == 2){ echo " selected='' "; } ?> >Titulo, Imagem, Icone, Descrição</option>
					<option value='3' <?php if($data->ordem_itens == 3){ echo " selected='' "; } ?> >Descrição, Titulo, Imagem, Icone</option>
					<option value='4' <?php if($data->ordem_itens == 4){ echo " selected='' "; } ?> >Titulo, Descrição, Imagem, Icone</option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Itens por linha</label>
			<div class="col-md-12">
				<select name="itens_por_linha" class="form-control select2" style="width: 100%;" >
					<option value='2' <?php if($data->itens_por_linha == 2){ echo " selected='' "; } ?> >2</option>
					<option value='3' <?php if($data->itens_por_linha == 3){ echo " selected='' "; } ?> >3</option>
					<option value='4' <?php if($data->itens_por_linha == 4){ echo " selected='' "; } ?> >4</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12">Descrição (opcional)</label>
			<div class="col-md-12">
				<textarea name="descricao" class="summernote" ><?=$data->descricao?></textarea>
			</div>
		</div>
		
		<hr>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-12" >Classes Css</label>  
					<select name="lista_css[]"  class="js-select2" multiple="multiple" >
						<?php
						
						$lista_selecionada = explode(' ', $data->classes);
						foreach ($lista_css as $key => $value) {
 							
							$consulta = '.'.$value['classe'];
							if(in_array($consulta, $lista_selecionada)){
								$selected = " selected='' ";
							} else {
								$selected = "";
							}

							echo "
							<option value='.".$value['classe']."' data-badge='' $selected >".$value['titulo']."</option>
							";
						}
						?>
					</select> 

				</div>
			</div> 
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-12" >Classes Css Imagens</label>  
					<select name="lista_css_img[]"  class="js-select2" multiple="multiple" >
						<?php
						
						$lista_selecionada = explode(' ', $data->classes_img);
						foreach ($lista_css as $key => $value) {
 							
							$consulta = '.'.$value['classe'];
							if(in_array($consulta, $lista_selecionada)){
								$selected = " selected='' ";
							} else {
								$selected = "";
							}

							echo "
							<option value='.".$value['classe']."' data-badge='' $selected >".$value['titulo']."</option>
							";
						}
						?>
					</select> 

				</div>
			</div> 
		</div>

		<hr>
		
		<?php
		
		foreach ($cores as $key => $value) {
			
			echo "
			<div class='form-group' >
			<label class='col-md-12' >Cor: ".$value['titulo']."</label>
			<div class='col-md-8'>
			<input name='cor_".$value['id']."' type='text' class='form-control my-colorpicker1' value='".$value['cor']."' autocomplete='off' >
			</div>
			</div>
			";
			
		}
		?>
		
	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<input name="codigo" type="hidden" value="<?=$data->codigo?>" >
</form>

<script>
	$(function () {

		$(".select2").select2();

		$(".my-colorpicker1").colorpicker();
		
	});
</script>

<?php include_once('js_summernote.php'); ?>

<script type="text/javascript">
	
	(function($) {
		
		"use strict";

		$(".js-select2").select2({
			closeOnSelect : false,
			placeholder : "Clique e selecione a classe",
			allowHtml: true,
			allowClear: true,
			tags: true
		});

		$('.icons_select2').select2({
			width: "100%",
			templateSelection: iformat,
			templateResult: iformat,
			allowHtml: true,
			placeholder: "Clique e selecione a classe",
			dropdownParent: $( '.select-icon' ),
			allowClear: true,
			multiple: false
		});

		function iformat(icon, badge,) {
			var originalOption = icon.element;
			var originalOptionBadge = $(originalOption).data('badge');
			
			return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
		}

	})(jQuery);

</script>