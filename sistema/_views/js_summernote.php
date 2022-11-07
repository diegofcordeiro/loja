<script>
	$(document).ready(function() {
		
		<?php
		$i = 1;
		$lista_font_1 = "";
		foreach ($_base['fontes_cadastradas'] as $key => $value) {
			if($i != 1){ $lista_font_1 .= ','; }
			$lista_font_1 .= "'".$value['family']."'";
			$i++;
		}
		?>
		
		$('.summernote1').summernote({
			placeholder: '',
			tabsize: 2,
			height: 240,
			toolbar: [
			['font', ['fontname']],
			['fontsize', ['fontsize']], 
			['font', ['bold', 'underline', 'clear']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['view', ['fullscreen', 'codeview']]
			],
			fontNames: [<?=$lista_font_1?>],
			fontNamesIgnoreCheck: [<?=$lista_font_1?>],
			fontSizes: ['10','12','13','14','15','16','17','18','19','20','22','24','26','28','30','32','34','36','38','40','42','44','46','48','50']
		});	
		$('.summernote2').summernote({
			placeholder: '',
			tabsize: 2,
			height: 240,
			toolbar: [
			['font', ['fontname']],
			['fontsize', ['fontsize']], 
			['font', ['bold', 'underline', 'clear']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['view', ['fullscreen', 'codeview']]
			],
			fontNames: [<?=$lista_font_1?>],
			fontNamesIgnoreCheck: [<?=$lista_font_1?>],
			fontSizes: ['10','12','13','14','15','16','17','18','19','20','22','24','26','28','30','32','34','36','38','40','42','44','46','48','50']
		});	
		$('.summernote3').summernote({
			placeholder: '',
			tabsize: 2,
			height: 240,
			toolbar: [
			['font', ['fontname']],
			['fontsize', ['fontsize']], 
			['font', ['bold', 'underline', 'clear']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['view', ['fullscreen', 'codeview']]
			],
			fontNames: [<?=$lista_font_1?>],
			fontNamesIgnoreCheck: [<?=$lista_font_1?>],
			fontSizes: ['10','12','13','14','15','16','17','18','19','20','22','24','26','28','30','32','34','36','38','40','42','44','46','48','50']
		});	 

	});
</script>