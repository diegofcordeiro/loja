<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<table class="table tabela_boa" >

	<thead>
		<tr>
			<th style='width:30px;'></th>
			<th>Produto</th>
			<th></th>
			<th style='text-align:center;' >Preço</th>
			<!-- <th style='text-align:center; width:50px;' >Quantidade</th> -->
			<th style='text-align:center; width:120px;' >Total</th>

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

	foreach ($carrinho['lista'] as $key => $values) { 
		foreach ($values as $key2 => $value) { 
			if($value['usar_valor_vindi'] == 1){
				$valor_unitario = '-';
				$total_geral = '-';
				$subtotal= $value['valor_total_combo_vindi'];
			}else{
				$valor_unitario = "R$ ".$value['total_unitario'];
				$total_geral = "R$ ".$value['total_quantidade'];
			}
			// echo '<pre>';print_r(count($values));exit;
			if($key != 0){
				if($key2 == 0){
					echo "
						<tr>
							<td colspan='5' style='border-bottom: 1px white solid;'>
								<div class='carrinho_lista_remover' style='padding-top:0px !important'><a href='#' onClick=\"remove_carrinho('".$value['id']."');\" ><i class='fa fa-times' aria-hidden='true'></i></a></div>".$value['combo_titulo']."
							</td>
						</tr>
					";
				}
				echo "
					<tr>

					<td>
						
					</td>

					<td colspan='2' >
					<div class='carrinho_lista_imagem' style='background-image:url(".$value['imagem'].");' ></div>
					<div class='carrinho_lista_texto' ><div style='padding-left:15px; padding-right:15px;'>".$value['titulo']."</div></div>
					</td>

					<td style='text-align:center;' >
					<div class='carrinho_lista_valor' >".$valor_unitario."</div>
					</td>";
					// <td style='width:200px;' ><div style='margin-top:30px; text-align:center;'>
					// <input class='carrinho_quantidade_input' name='quantidade_".$value['id']."' id='quantidade_".$value['id']."' value='".$value['quantidade']."' onkeypress='Mascara(this,Integer)' onKeyDown='Mascara(this,Integer)' >
					// <button type='button' class='botao_padrao ".$botao_css."' onClick=\"altera_quantidade('".$value['id']."')\" >Alterar</button>	</div>	 
					
					echo "</td>

					<td style='text-align:center; width:120px;' >
					<div class='carrinho_lista_valor' >".$total_geral."</div>
					</td>

					</tr>
				";
				if($key2 == count($values)-1){
					echo "
						<tr>
							<td colspan='6' style='padding: 1px !important;background: #dddddd;'></td>
						</tr>
					";
				}
			}else{
				if($key2 == 0){
					echo "
						<tr>
							<td colspan='5' style='border-bottom: 1px white solid;'>
								Curso avulso
							</td>
						</tr>
					";
				}
				echo "
					<tr>

					<td>
					<div class='carrinho_lista_remover' ><a href='#' onClick=\"remove_carrinho('".$value['id']."');\" ><i class='fa fa-times' aria-hidden='true'></i></a></div>
					</td>

					<td colspan='2' >
					<div class='carrinho_lista_imagem' style='background-image:url(".$value['imagem'].");' ></div>
					<div class='carrinho_lista_texto' ><div style='padding-left:15px; padding-right:15px;'>".$value['titulo'].$value['id_combo']."</div></div>
					</td>

					<td style='text-align:center;' >
					<div class='carrinho_lista_valor'>".$valor_unitario."</div>
					</td>";

					// <td style='width:200px;' >
					// <div style='margin-top:30px; text-align:center;'>
					// <input class='carrinho_quantidade_input' name='quantidade_".$value['id']."' id='quantidade_".$value['id']."' value='".$value['quantidade']."' onkeypress='Mascara(this,Integer)' onKeyDown='Mascara(this,Integer)' >
					// <button type='button' class='botao_padrao ".$botao_css."' onClick=\"altera_quantidade('".$value['id']."')\" ><i style='font-size:15px' class='fa'>&#xf021;</i></button>		 
					// </div>
					// </td>

					echo "<td style='text-align:center; width:120px;' >
					<div class='carrinho_lista_valor' >".$total_geral."</div>
					</td>

					</tr>
				";
			}

			$n++;
			echo "</table>";
			// echo "
			// <table>
			// 	<tr>
			// 	<td colspan='4' style='text-align:right; ' >Sub-total</td>
			// 	<td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$subtotal."</td> 
			// 	</tr>
			// </table>
			// ";
		}
	}


	if($n != 0){

		// echo "
		// <tr>
		// <td colspan='4' style='text-align:right; ' >Sub-total</td>
		// <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$carrinho['subtotal_tratado']."</td> 
		// </tr>
		// ";

	} else {

		echo "
		<tr>
		<td colspan='5' style='text-align:center; padding-top:120px; padding-bottom:120px; font-size:20px;' >Seu carrinho está vazio.</td>
		</tr>
		";

	}

	?>

