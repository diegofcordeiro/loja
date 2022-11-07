<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<table class="table tabela_boa" >
	
	<!-- <tr>
		<td style='text-align:right; border-top:0px;' >Descontos do Cupom (Mínimo de Compra <?=$minimo_compra?>)</td>
		<td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_desconto_cupom_tratado?></td>
	</tr>
	
	<tr>
		<td style='text-align:right; border-top:0px;' >Descontos da Forma de Pagamento</td>
		<td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_desconto_forma_pag_tratado?></td>
	</tr>

	<tr>
		<td style='text-align:right; border-top:0px;' >Total de Frete</td>
		<td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_frete_tratado?></td>
	</tr>-->

	<tr>
		<td style='text-align:right; border-top:0px;' >Total do Pedido</td>
		<td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_total_pedido_tratado?></td>
	</tr> 

</table>