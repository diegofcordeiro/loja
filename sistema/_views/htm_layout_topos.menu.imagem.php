<?php include_once('base.php'); ?>

<?php

if(!$data->imagem){

	?>
	
	<form action="<?=$_base['objeto']?>menu_imagem_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

		<fieldset>

			<div class="form-group">
				<label class="col-md-12" >Icone do menu</label>
				<div class="col-md-12">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input">
								<i class="fa fa-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
							</div>
							<span class="btn btn-default btn-file">
								<span class="fileupload-exists">Alterar</span>
								<span class="fileupload-new">Procurar arquivo</span>
								<input type="file" name="arquivo" />
							</span>
							<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
						</div>
					</div>
				</div>
			</div>

		</fieldset>

		<button type="submit" class="btn btn-primary">Salvar</button>
		<input type="hidden" name="codigo" value="<?=$data->codigo?>" >
		<input type="hidden" name="topo_codigo" value="<?=$data->topo_codigo?>" >

	</form>

<?php } else { ?>
	
	<div style="text-align: left; ">
		<img src="<?=PASTA_CLIENTE?>imagens/<?=$data->imagem?>" style="max-width:200px;">
	</div>
	
	<div style="margin-top: 20px;">
		<button type="button" class="btn btn-default" onClick="confirma('<?=$_base['objeto']?>menu_imagem_apagar/codigo/<?=$data->codigo?>/topo_codigo/<?=$data->topo_codigo?>');" >Apagar Imagem</button>
	</div>
	
<?php } ?>

<script src="<?=LAYOUT?>js/ajuda.js"></script>