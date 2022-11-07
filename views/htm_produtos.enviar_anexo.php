<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<style type="text/css">

	.upload {
		display:block;
		width: 100%;
	}

	h1 {
		font-size: 1em;
		color: #6f48ad;
		margin-bottom: 20px;
	}

	form {
		position: relative;
		display: block;

		margin-bottom: 10px;
	}


	#formFiles button {
		margin-top: 15px;
		position: relative;
		cursor: pointer;
		padding: 14px;
		display: inline-block;
		background-color: #7233e8;
		color: #fff;
		font-weight: bold;
		font-size: 1.1em;
		border: none;
		outline: none;
		width: 100%;
		border-radius: 3px;
	}

	#formFiles button:hover {
		background-color: #5b12e6;
	}

	#progressBar {
		position: relative;
		display: none;
		background: linear-gradient(135deg, rgb(0, 0, 0) 0%, rgb(0, 0, 0) 100%); 
		width: 0;
		color: #fff;
		font-size: 0.75em;
		overflow: hidden;
		padding:3px;
	}

	#return {
		font-size:14px;
		font-weight: bold;
		margin-bottom: 5px;
	}

</style>

<div class="upload">

	<form id="formFiles" name="formFiles" action="javascript:void(0);" enctype="multipart/form-data">
		

		<label>Arquivo</label> 
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input">
					<i class="fa fa-file fileupload-exists"></i>
					<span class="fileupload-preview"></span>
				</div>
				<span class="btn btn-default btn-file">
					<span class="fileupload-exists">Alterar</span>
					<span class="fileupload-new">Procurar arquivo</span>
					<input type="file" name="file" />
				</span>
				<a href="#" class="btn btn-default fileupload-exists botao_padrao" data-dismiss="fileupload">Remover</a>
			</div>
		</div> 

		<button type="submit" class="botao_padrao" >Enviar</button>

	</form>

	<div id="return"></div>

	<div id="progressBar">
		<span></span>
	</div>

</div>

<script type="text/javascript">

	var formFiles, divReturn, progressBar;

	formFiles = document.getElementById('formFiles');
	divReturn = document.getElementById('return');
	progressBar = document.getElementById('progressBar');

	formFiles.addEventListener('submit', sendForm, false);

	function sendForm(evt) {

		var formData, ajax, pct;

		formData = new FormData(evt.target);

		ajax = new XMLHttpRequest();

		ajax.onreadystatechange = function () {

			if (ajax.readyState == 4) {
				formFiles.reset();

				var retornoarq =  JSON.parse(ajax.response);

				divReturn.textContent = retornoarq.msg;
				progressBar.style.display = 'none';

				if(retornoarq.status == 'ok'){
					$('#arquivo_arte').val(retornoarq.nomearquivo);
					$('#arquivo_arte_bt').html("<span style='font-size:16px; color:blue;'>Arquivo anexado com sucesso!</span>");
					$('#modal_janela').modal('hide');
				}

			} else {
				progressBar.style.display = 'block';
				divReturn.style.display = 'block';
				divReturn.textContent = 'Enviando arquivo...';
			}
		}

		ajax.upload.addEventListener('progress', function (evt) {

			pct = Math.floor((evt.loaded * 100) / evt.total);
			progressBar.style.width = pct + '%';
			progressBar.getElementsByTagName('span')[0].textContent = pct + '%';

		}, false);
		
		ajax.open('POST', '<?=DOMINIO?><?=$controller?>/produto_enviar_anexo_grv');
		ajax.send(formData);
		
	}

</script>
