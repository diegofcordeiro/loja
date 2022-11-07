<div id="modal_janela" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div id="fecharmodal" style="position: absolute; z-index: 999; top:-10px; right:-7px; font-size: 26px; cursor: pointer;" onclick="fecharmodaljanela();" ><i class="fas fa-times-circle"></i></div>
		<div class="modal-content">
			<div class="modal-body">
				<div id="modal_conteudo" style="padding:15px;" ></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function fecharmodaljanela(){
		$('#modal_janela').modal('hide'); 
	}
</script>