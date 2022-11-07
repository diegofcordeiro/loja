<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">
	
	<fieldset>

		<div class="form-group">
			<label class="col-md-12" >Nome</label>
			<div class="col-md-12">
				<input name="nome" type="text" class="form-control" >
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12" >E-mail</label>
			<div class="col-md-12">
				<input name="email" type="text" class="form-control" >
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12">Grupo</label>
			<div class="col-md-12">
				<select name="grupo" class="form-control select2" style="width: 100%;" >
					<option value='' selected >Selecione</option>
					<?php
					foreach ($grupos as $key => $value) {

						if($value['codigo'] == $grupo_selecionado){
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

	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	
</form>

<script src="<?=LAYOUT?>js/ajuda.js"></script>