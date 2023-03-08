<?php if (!isset($_base['libera_views'])) {
	header("HTTP/1.0 404 Not Found");
	exit;
} ?>

<?php

// echo "<pre>"; print_r($conteudo_sessao['cores']['detalhes']); echo "</pre>";
$cores = $conteudo_sessao['cores']['lista'];
$conteudo_config = $conteudo_sessao['data_grupo'];
$classes_css = str_replace(".", "", $conteudo_config->classes);
$classes_css_img = str_replace(".", "", $conteudo_config->classes_img);

$estados = $conteudo_sessao['estados'];

?>

<dix id="section-cadastro-<?= $conteudo_id ?>" class="container-fluid animate-effect" style="padding-top:50px; padding-bottom:80px; background-color:<?= $cores[60] ?> !important; color:<?= $cores[61] ?> !important; padding-bottom:50px; ">

	<?php if ($conteudo_config->mostrar_titulo == 1) { ?>

		<div class='row'>
			<div class='col-xs-12 col-sm-12 col-md-12'>
				<div>
					<h2 class="titulo_padrao" style="color:<?= $cores[61] ?> !important; border-color:<?= $cores[61] ?> !important; "><?= $conteudo_config->titulo ?></h2>
					<div class="titulo_padrao_linha" style="color:<?= $cores[61] ?>; "></div>
				</div>
			</div>
		</div>

	<?php } ?>

	<?php if ($conteudo_config->descricao) { ?>

		<div class='row'>
			<div class='col-xs-12 col-sm-12 col-md-12'>
				<div style="margin-top:20px; padding-bottom:50px; font-size: 16px; color:<?= $cores[61] ?>; text-align: center;">
					<?= $conteudo_config->descricao ?>
				</div>
			</div>
		</div>

	<?php } ?>

	<div class="row">

		<form id="cadastro_form" name="cadastro_form">
			<div class='col-xs-12 col-sm-6 col-md-6'>

				<div class="cadastro_div <?= $classes_css ?>">

					<div style="font-size:14px; text-align:left; font-weight: bold;">DADOS PESSOAIS</div>

					<div class="div_form"><input type="text" class="form-control cadastro_form" name="email" autocomplete="off" placeholder="Digite seu E-mail"></div>

					<div class="div_form"><input type="text" class="form-control cadastro_form" name="cadastro_telefone" id="cadastro_telefone" placeholder="Telefone" onKeyPress="Mascara(this,telefone)" onKeyDown="Mascara(this,telefone)" maxlength="15"></div>

					<?php if ($conteudo_config->dados_acesso == 1) { ?>

						<div class="div_form"><input type="password" class="form-control cadastro_form" name="senha" autocomplete="off" placeholder="Digite sua Senha"></div>
						<div class="div_form"><input type="password" class="form-control cadastro_form" name="senha_confirma" autocomplete="off" placeholder="Confirme sua Senha"></div>

						<div class="div_form" style="text-align:left; margin-top:20px; margin-bottom: 25px;">
							<input type="radio" name="tipo" id="tipo_f" value="F" onChange="tipo_cadastro(this.value)" checked> <label for="tipo_f">Pessoa Física</label>&nbsp; &nbsp;
							<input type="radio" name="tipo" id="tipo_j" value="J" onChange="tipo_cadastro(this.value)"> <label for="tipo_j">Pessoa Jurídica</label>
						</div>

						<input type='hidden' name='cadastro_com_login' value='1'>

					<?php } else { ?>

						<input type='hidden' name='cadastro_com_login' value='0'>

					<?php } ?>

					<div id="fisica">

						<div style="font-size:14px; text-align:left; font-weight: bold;">PESSOA FÍSICA</div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='fisica_nome' id='fisica_nome' placeholder="Nome Completo"></div>

						<div class="div_form" style="text-align:left; margin-top:5px;">
							<input type="radio" name="fisica_sexo" id="sexo_m" value="M"> <label for="sexo_m" style="font-weight:normal;"> Masculino</label> &nbsp; &nbsp;
							<input type="radio" name="fisica_sexo" id="sexo_f" value="F"> <label for="sexo_f" style="font-weight:normal;"> Feminino</label>
						</div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='fisica_nascimento' id='fisica_nascimento' maxlength="10" size="30" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" placeholder="Data Nascimento"></div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='fisica_cpf' id='fisica_cpf' onkeypress="Mascara(this,Integer)" maxlength="11" name="cpf" placeholder="CPF"></div>

					</div>

					<div id="juridica" style="display:none;">

						<div style="font-size:14px; text-align:left; margin-top:25px; font-weight: bold;">PESSOA JURÍDICA</div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_nome' id='juridica_nome' placeholder="Nome Fantasia"></div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_razao' id='juridica_razao' placeholder="Razão Social"></div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_cnpj' id='juridica_cnpj' placeholder="Cnpj" onkeypress="Mascara(this,Integer)"></div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_ie' id='juridica_ie' placeholder="Inscrição Estadual"></div>

						<div class="div_form"><input type="text" class="form-control cadastro_form" name='juridica_responsavel' id='juridica_responsavel' placeholder="Responsável"></div>

					</div>

				</div>

			</div>

			<div class='col-xs-12 col-sm-6 col-md-6'>

				<div class="cadastro_div <?= $classes_css ?>">

					<div style="font-size:14px; text-align:left; font-weight: bold;">DADOS DE ENDEREÇO</div>

					<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_cep" name="cadastro_cep" placeholder="Digite seu Cep" onkeypress="Mascara(this,ceppp)" onKeyDown="Mascara(this,ceppp)" size="9" maxlength="9" onblur="buscar_endereco()"></div>
					<div class="div_form">
						<div style="text-align:left;">
							<div><a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank" style="font-size:13px;">Não sei meu CEP</a></div>
						</div>
					</div>

					<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_endereco" name="endereco" placeholder="Endereço"></div>

					<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_numero" name="numero" placeholder="Número"></div>

					<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_complemento" name="complemento" placeholder="Complemento"></div>

					<div class="div_form"><input type="text" class="form-control cadastro_form" id="cadastro_bairro" name="bairro" placeholder="Bairro"></div>

					<div class="div_form">
						<select name="estado" id="cadastro_estado" class="form-control select2 cadastro_select" onChange="cadastro_cidades(this.value)">
							<?php

							foreach ($estados as $key => $value) {

								if ($value['selected']) {
									$select = "selected";
								} else {
									$select = "";
								}
								echo "<option value='" . $value['uf'] . "' $select >" . $value['nome'] . "</option>";
							}

							?>
						</select>
					</div>

					<div class="div_form" id="cadastro_cidade_div">
						<select id="cidade" name="cidade" class="form-control select2 cadastro_form">
							<option value=''>Selecione</option>
						</select>
					</div>

					<div class="div_form" style="text-align:left; margin-top:5px;">
						<div>Deseja receber nossas promoções por e-mail?</div>
						<input type="radio" name="promocoes" id="receber_s" value="1" checked=""> <label for="receber_s" style="font-weight:normal;"> Sim</label> &nbsp; &nbsp;
						<input type="radio" name="promocoes" id="receber_n" value="0"> <label for="receber_n" style="font-weight:normal;"> Não</label>
					</div>

					<div class="botao_padrao_div">
						<?php

						$botao = str_replace("aquivaiolink", " onclick=\"finalizar_cadastro();\" ", $conteudo_sessao['botao']);

						echo $botao;
						?>
					</div>

				</div>

			</div>

		</form>


	</div>

	</div>