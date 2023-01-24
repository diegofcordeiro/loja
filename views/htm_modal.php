<div id="modal_janela" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div id="fecharmodal" style="position: absolute; z-index: 999; top:-10px; right:-7px; font-size: 26px; cursor: pointer;" onclick="fecharmodaljanela();" ><i class="fas fa-times-circle"></i></div>
		<div class="modal-content" style="margin-top: 50%;background: none;box-shadow: none;border: none;">
			<div class="modal-body">
				<div id="modal_conteudo" style="padding:15px;" ></div>
			</div>
		</div>
	</div>
</div>
<div id="modal_load" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content"style="text-align: center;background: none;border: none;box-shadow: none;margin-top: 50%;" > 
			<img src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="40" alt="">
				<div id="modal_conteudo_loading" style="padding:15px;opacity: 0;" ></div>

		</div>
	</div>
</div>
<script type="text/javascript">
	function fecharmodaljanela(){
		$('#modal_janela').modal('hide'); 
		$('#modal_load').modal('hide'); 
	}
</script>