<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div>

	<?php if($opcao == 1){ ?>
		
		<div style="font-size: 15px;"><span style="font-weight: bold;">Modelo Selecionado:</span> <?=$modelo_selecionado?> - <a style="cursor: pointer;" onclick="modal('<?=DOMINIO?><?=$controller?>/produto_modelos_gratis/produto/<?=$produto?><?php if($opcao_variacoes){ echo "/opcao/<?=$opcao_variacoes?>/"; } ?>','Selecione o modelo');">Trocar modelo</a>
			<input type="hidden" name="modelo_selecionado_codigo" value="<?=$modelo_selecionado_codigo?>">
		</div>
		
		<div style="margin-top: 15px; font-size: 15px; color: blue; font-weight: bold;">Informe os dados para inserir na sua arte</div>
		
		<div style="margin-top: 15px;">
			<textarea class="form-control" style="height: 130px;" name="dados_arte" placeholder="Escreva aqui os dados e informações para inserir na sua arte. Ex.: nome, telefone, endereço, email, site, texto etc." ></textarea>
		</div>
		
		<div style="margin-top: 15px; font-size: 15px; color: red; font-weight: bold;">Atenção: A arte será enviada para o e-mail de contato.</div>
		
		<div style="margin-top: 15px;">

			<div id="arquivo_arte_bt">
				<input type="button" class="botao_upload botao_padrao" value="Carregar Arquivo" onclick="modal('<?=DOMINIO?><?=$controller?>/produto_enviar_anexo', 'Carregar arquivo');" />
			</div>

			<input type="hidden" name="arquivo_arte" id="arquivo_arte" value="" />
			
		</div>
		
		<div style="margin-top:25px;">
			<div style="font-size: 14px; padding-bottom: 5px; font-weight: bold; ">Selecione um acabamento (opcional)</div>
			<select name="arte_acabamento" class="form-control" style="width: 100%;" >
				<option value="" >Selecione</option>
				<?php

				foreach ($acabamentos as $key => $value) {
					
					echo "
					<option value='".$value['codigo']."' >".$value['titulo']."</option>
					";
					
				}

				?>
			</select>
		</div>

	<?php } ?>

	<?php if($opcao == 2){ ?>


		<div style="margin-top: 15px; font-size: 15px; color: blue; font-weight: bold;">Informe os dados para inserir na sua arte</div>

		<div style="margin-top: 15px;">
			<textarea class="form-control" style="height: 130px;" name="dados_arte" placeholder="Escreva aqui os dados e informações para inserir na sua arte. Ex.: nome, telefone, endereço, email, site, texto, cores e que tipo de imagem deseja usar etc." ></textarea>
		</div>
		
		<div style="margin-top: 15px; font-size: 15px; color: red; font-weight: bold;">Atenção: A arte será enviada para o e-mail de contato.</div>
		
		<div style="margin-top: 15px;">

			<div id="arquivo_arte_bt">
				<input type="button" class="botao_upload botao_padrao" value="Carregar Arquivo" onclick="modal('<?=DOMINIO?><?=$controller?>/produto_enviar_anexo', 'Carregar arquivo');" />
			</div>

			<input type="hidden" name="arquivo_arte" id="arquivo_arte" value="" />
			
		</div>
		
		<div style="margin-top:25px;">
			<div style="font-size: 14px; padding-bottom: 5px; font-weight: bold; ">Selecione um acabamento (opcional)</div>
			<select name="arte_acabamento" class="form-control" style="width: 100%;" >
				<option value="" >Selecione</option>
				<?php

				foreach ($acabamentos as $key => $value) {
					
					echo "
					<option value='".$value['codigo']."' >".$value['titulo']."</option>
					";

				}

				?>
			</select>
		</div>

		
	<?php } ?>

	<?php if($opcao == 3){ ?>

		<div style="margin-top: 15px; font-size: 15px; color: red; font-weight: bold;">Atenção: não esqueça de ajustar o seu arquivo de acordo com o gabarito.</div>
		
		<div style="margin-top: 15px;">
			
			<div id="arquivo_arte_bt">
				<input type="button" class="botao_upload botao_padrao" value="Carregar Arquivo" onclick="modal('<?=DOMINIO?><?=$controller?>/produto_enviar_anexo', 'Carregar arquivo');" />
			</div>
			
			<input type="hidden" name="arquivo_arte" id="arquivo_arte" value="" />
			
		</div>
		
		<div style="margin-top:25px;">
			<div style="font-size: 14px; padding-bottom: 5px; font-weight: bold; ">Selecione um acabamento (opcional)</div>
			<select name="arte_acabamento" class="form-control" style="width: 100%;" >
				<option value="" >Selecione</option>
				<?php
				
				foreach ($acabamentos as $key => $value) {
					
					echo "
					<option value='".$value['codigo']."' >".$value['titulo']."</option>
					";

				}

				?>
			</select>
		</div>

	<?php } ?>

</div>