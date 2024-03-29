<?php if (!isset($_base['libera_views'])) {
	header("HTTP/1.0 404 Not Found");
	exit;
}

function get_combo_($id)
{
	$conexao = new mysql();
	$combo = $conexao->query("SELECT
									combos.intervalo as intervalo
									FROM `combos` 
									WHERE combos.id = $id;");
	$obj_cmb = $combo->fetch_object();
	return $obj_cmb->intervalo;
}
?>

<table class="table tabela_boa">

	<thead>
		<tr>
			<th style='width:30px;'></th>
			<th>Produto</th>
			<th></th>
			<th style='text-align:center;'>Preço</th>
			<!-- <th style='text-align:center; width:50px;' >Quantidade</th> -->
			<th style='text-align:center; width:120px;'>Total</th>

		</tr>
	</thead>
	<style>
		.botao_160701999128854 {
			border: 2px solid #ffffff !important;
			border-radius: 10px !important;
			color: #ffffff !important;
			cursor: pointer !important;
			padding-top: 9px !important;
			padding-left: 25px !important;
			padding-right: 25px !important;
			padding-bottom: 10px !important;
		}
	</style>

	<?php

	$n = 0;
	$total_pedidos_ = 0;
	foreach ($carrinho['lista'] as $key => $values) {
		// echo '<pre>';
		// print_r(($key));
		// exit;
		$subtotal_ = 0;

		foreach ($values as $key2 => $value) {

			if ($value['usar_valor_vindi'] == 1) {
				$valor_unitario = '-';
				$total_geral = '-';
				$subtotal_ = $value['combo_valor'];
			} else {
				$valor_unitario = "R$ " . $value['total_unitario'];
				$total_geral = "R$ " . $value['total_quantidade'];

				$resultado = str_replace('.', '', $value['total_unitario']); // remove o ponto
				$resultado = str_replace(',', '.', $resultado); // substitui a vírgula por ponto
				$subtotal_ = ($subtotal_ + floatval($resultado));
			}
			// echo '<pre>';print_r(count($values));exit;
			if ($key != 0) {
				if ($key2 == 0) {
					echo "
						<tr>
							<td colspan='5' style='border-bottom: 1px white solid;'>
								<div class='carrinho_lista_remover' style='padding-top:0px !important'><a href='#' onClick=\"remove_carrinho('" . $value['id'] . "');\" ><i class='fa fa-times' aria-hidden='true'></i></a></div>" . $value['combo_titulo'] . "
							</td>
						</tr>
					";
				}
				echo "
					<tr>

					<td>
						
					</td>

					<td colspan='2' >
					<div class='carrinho_lista_imagem' style='background-image:url(" . $value['imagem'] . ");' ></div>
					<div class='carrinho_lista_texto' ><div style='padding-left:15px; padding-right:15px;'>" . $value['titulo'] . "</div></div>
					</td>

					<td style='text-align:center;' >
					<div class='carrinho_lista_valor' >" . $valor_unitario . "</div>
					</td>";
				// <td style='width:200px;' ><div style='margin-top:30px; text-align:center;'>
				// <input class='carrinho_quantidade_input' name='quantidade_".$value['id']."' id='quantidade_".$value['id']."' value='".$value['quantidade']."' onkeypress='Mascara(this,Integer)' onKeyDown='Mascara(this,Integer)' >
				// <button type='button' class='botao_padrao ".$botao_css."' onClick=\"altera_quantidade('".$value['id']."')\" >Alterar</button>	</div>	 

				echo "</td>

					<td style='text-align:center; width:120px;' >
					<div class='carrinho_lista_valor' >" . $total_geral . "</div>
					</td>

					</tr>
				";
				if ($key2 == count($values) - 1) {
					echo "
						<tr>
							<td colspan='6' style='padding: 1px !important;background: #dddddd;'></td>
						</tr>
					";
				}
			} else {
				if ($key2 == 0) {
					echo "
						<tr>
							<td colspan='5' style='border-bottom: 1px white solid;'>
								Trilha avulsa
							</td>
						</tr>
					";
				}
				echo "
					<tr>

					<td>
					<div class='carrinho_lista_remover' ><a href='#' onClick=\"remove_carrinho('" . $value['id'] . "');\" ><i class='fa fa-times' aria-hidden='true'></i></a></div>
					</td>

					<td colspan='2' >
					<div class='carrinho_lista_imagem' style='background-image:url(" . $value['imagem'] . ");' ></div>
					<div class='carrinho_lista_texto' ><div style='padding-left:15px; padding-right:15px;'>" . $value['titulo'] . $value['id_combo'] . "</div></div>
					</td>

					<td style='text-align:center;' >
					<div class='carrinho_lista_valor'>" . $valor_unitario . "</div>
					</td>";

				// <td style='width:200px;' >
				// <div style='margin-top:30px; text-align:center;'>
				// <input class='carrinho_quantidade_input' name='quantidade_".$value['id']."' id='quantidade_".$value['id']."' value='".$value['quantidade']."' onkeypress='Mascara(this,Integer)' onKeyDown='Mascara(this,Integer)' >
				// <button type='button' class='botao_padrao ".$botao_css."' onClick=\"altera_quantidade('".$value['id']."')\" ><i style='font-size:15px' class='fa'>&#xf021;</i></button>		 
				// </div>
				// </td>

				echo "<td style='text-align:center; width:120px;' >
					<div class='carrinho_lista_valor' >" . $total_geral . "</div>
					</td>

					</tr>
				";
			}

			$n++;
		}

		if ($key != 0) {
			$intervalo = get_combo_($key);
			// echo $intervalo;
			if ($intervalo == 'Anual') {
				$valor = $subtotal_ / 12;
				$res_parcelado =  "apenas 12 x R$" . number_format($valor, 2, ',', '.');
			} else if ($intervalo != 'Mensal') {
				$final = explode(" ", $intervalo);
				$valor = $subtotal_ / $final[0];
				$res_parcelado =  'apenas ' . $final[0] . " x R$" . number_format($valor, 2, ',', '.');
			} else {
				$res_parcelado = "R$ " . number_format($subtotal_, 2);
			}
			echo "
			<tr>
				<td colspan='2' style='text-align:right; font-size: 18px;' ></td>
				<td colspan='3' style='text-align:right;  width:120px; font-weight:bold;font-size: 18px;padding-right: 16px;' >" . $res_parcelado . "</td> 
			</tr>
			";
		} else {
			echo "
			<tr>
				<td colspan='4' style='text-align:right; font-size: 18px;' >Sub-total</td>
				<td style='text-align:center;  width:120px; font-weight:bold;font-size: 18px;' >R$ " . number_format($subtotal_, 2, ',', '.') . "</td> 
			</tr>
			";
		}



		$total_pedidos_ = ($total_pedidos_ + $subtotal_);
	}


	if ($n != 0) {

		// echo "
		// <tr>
		// <td colspan='4' style='text-align:right; ' >Sub-total</td>
		// <td style='text-align:center;  width:120px; font-weight:bold;' >R$ " . $res_parcelado . "</td> 
		// </tr>
		// ";
	} else {

		echo "
		<tr>
		<td colspan='5' style='text-align:center; padding-top:120px; padding-bottom:120px; font-size:20px;color:white' >Seu carrinho está vazio.</td>
		</tr>
		";
	}

	?>

</table>
<table class="table tabela_boa" style="border-top: 1px #dddddd solid;">
	<tr style="height: 20px;"></tr>
	<tr>
		<td style='text-align:right; border-top:0px;font-size: 18px;'>Total do Pedido</td>
		<td style='text-align:center; width:120px; font-weight:bold; border-top:0px;font-size: 18px;'>R$ <?= number_format($total_pedidos_, 2, ',', '.') ?></td>
	</tr>

</table>