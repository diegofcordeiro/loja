<?php

class garagem extends controller {
	
	protected $_modulo_nome = "Garagem";

	public function init(){		
		$this->autenticacao();
		$this->nivel_acesso(141);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		//lista
		$garagem = new model_garagem(); 
		$dados['lista'] = $garagem->lista();
		
		$this->view('garagem', $dados);
	}	

	public function novo(){
		
		$dados['_base'] = $this->base();

		$this->view('garagem.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$this->valida($titulo);
		
		$codigo = $this->gera_codigo();
		
		$db = new mysql();
		$db->inserir("garagem", array(
			"codigo"=>$codigo,
			"titulo"=>$titulo
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/dados/codigo/'.$codigo);
	}

	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);

 		//categorias
		$garagem = new model_garagem();
		$dados['categorias'] = $garagem->categorias();
		$dados['marcas'] = $garagem->marcas();
		$dados['cores'] = $garagem->cores();
		$dados['transmissao'] = $garagem->transmissao();
		$dados['combustivel'] = $garagem->combustivel();
		$dados['motor'] = $garagem->motor();

		$dados['opcionais'] = $garagem->opcionais_selecionados($codigo);

		//imagens
		$imagens = $garagem->imagens($dados['data']->codigo);
		$dados['imagens'] = $imagens['lista'];

		$this->view('garagem.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$ref = $this->post('ref');
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$destaque = $this->post('destaque');
		$categoria = $this->post('categoria');
		$marca = $this->post('marca');
		$modelo = $this->post('modelo');
		$cor = $this->post('cor');
		$combustivel = $this->post('combustivel');
		$transmissao = $this->post('transmissao');
		$motor = $this->post('motor');
		$km = $this->post('km');
		$placa = $this->post('placa');
		$obs = $this->post('obs');
		$ano_fab = $this->post('ano_fab');
		$ano_modelo = $this->post('ano_modelo');
		$valor = $this->post('valor');
		$tipo = $this->post('tipo');

		$this->valida($codigo);
		$this->valida($titulo);
		
		$valores = new model_valores();
		$valor_final = $valores->trata_valor_banco($valor);

		// categoria
		if($categoria){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_categorias where codigo='$categoria' ");
			$data = $exec->fetch_object();

			$categoria_nome = $data->titulo;

		} else {
			$categoria_nome = "";
		}

		// marca
		if($marca){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_marcas where codigo='$marca' ");
			$data = $exec->fetch_object();

			$marca_nome = $data->titulo;
		} else {
			$marca_nome = "";
		}

		if($modelo){

			// modelo
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_modelos where codigo='$modelo' ");
			$data = $exec->fetch_object();

			$modelo_nome = $data->titulo;

		} else {
			$modelo_nome = "";
		}

		// cor
		if($cor){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_cores where codigo='$cor' ");
			$data = $exec->fetch_object();

			$cor_nome = $data->titulo;

		} else {
			$cor_nome = "";
		}

		// combustivel
		if($combustivel){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_combustivel where codigo='$combustivel' ");
			$data = $exec->fetch_object();

			$combustivel_nome = $data->titulo;

		} else {
			$combustivel_nome = "";
		}

		// transmissao
		if($transmissao){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_transmissao where codigo='$transmissao' ");
			$data = $exec->fetch_object();

			$transmissao_nome = $data->titulo;
		} else {
			$transmissao_nome = "";
		}

		// transmissao
		if($motor){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_motor where codigo='$motor' ");
			$data = $exec->fetch_object();

			$motor_nome = $data->titulo;
		} else {
			$motor_nome = "";
		}
		
		$db = new mysql();
		$db->alterar("garagem", array(
			"ref"=>$ref,
			"tipo"=>$tipo,
			"categoria_cod"=>$categoria,
			"categoria_nome"=>$categoria_nome,
			"titulo"=>$titulo,
			"destaque"=>$destaque,
			"marca_cod"=>$marca,
			"marca_nome"=>$marca_nome,
			"modelo_cod"=>$modelo,
			"modelo_nome"=>$modelo_nome,
			"cor_cod"=>$cor,
			"cor_nome"=>$cor_nome,
			"combustivel_cod"=>$combustivel,
			"combustivel_nome"=>$combustivel_nome,
			"transmissao_cod"=>$transmissao,
			"transmissao_nome"=>$transmissao_nome,
			"motor_cod"=>$motor,
			"motor_nome"=>$motor_nome,
			"ano_fab"=>$ano_fab,
			"ano_modelo"=>$ano_modelo,
			"obs"=>$obs,
			"km"=>$km,
			"placa"=>$placa,
			"valor"=>$valor_final
		), " codigo='$codigo' ");
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}
	
	public function marcar_opcionais(){

		$dados['_base'] = $this->base();

		$codigo = $this->post('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_opcionais ");
		while($data = $exec->fetch_object()){

			if($this->post('opcional_'.$data->id) == 1){

				$db = new mysql();
				$exec2 = $db->executar("SELECT * FROM garagem_opcionais_sel where codigo='$codigo' AND opcional='$data->codigo' ");
				if($exec2->num_rows == 0){
					$db = new mysql();
					$db->inserir("garagem_opcionais_sel", array(
						"codigo"=>$codigo,
						"opcional"=>$data->codigo
					));
				}

			} else {

				$db = new mysql();
				$exec2 = $db->executar("SELECT * FROM garagem_opcionais_sel where codigo='$codigo' AND opcional='$data->codigo' ");
				if($exec2->num_rows != 0){
					$db = new mysql();
					$db->apagar("garagem_opcionais_sel", " codigo='$codigo' AND opcional='$data->codigo' ");
				}

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/opcionais');
	}

	public function apagar_imagem(){

		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_imagem where id='$id' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_veiculos_g/'.$codigo.'/'.$data->imagem);
				unlink('../arquivos/img_veiculos_p/'.$codigo.'/'.$data->imagem);
			}

			$conexao = new mysql();
			$conexao->apagar("garagem_imagem", " id='$id' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function ordenar_imagem(){

		$codigo = $this->post('codigo');
		$list = $_POST['list'];

		$this->valida($codigo);
		$this->valida($list);

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$db->inserir("garagem_imagem_ordem", array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));

	}

	public function legenda(){

		$dados['_base'] = $this->base();

		$id = $this->get('id');
		$codigo = $this->get('codigo');

		$dados['codigo'] = $codigo;
		$dados['id'] = $id;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$dados['legenda'] = $data->legenda;
		} else {
			$dados['legenda'] = '';
		}

		$this->view('garagem.legenda', $dados);
	}


	public function legenda_grv(){

		$id = $this->post('id');
		$legenda = $this->post('legenda');
		$codigo = $this->post('codigo');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$db = new mysql();
			$db->alterar("garagem_imagem_legenda", array(
				"legenda"=>"$legenda"
			), " id='$data->id' ");
		} else {
			$db = new mysql();
			$db->inserir("garagem_imagem_legenda", array(
				"id_img"=>"$id",
				"legenda"=>"$legenda"
			));
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$db = new mysql();
				$exec_img = $db->executar("SELECT * FROM garagem_imagem where codigo='$data->codigo' ");
				while($data_img = $exec_img->fetch_object()){

					if($data_img->imagem){
						unlink('../arquivos/img_veiculos_g/'.$data->codigo.'/'.$data_img->imagem);
						unlink('../arquivos/img_veiculos_p/'.$data->codigo.'/'.$data_img->imagem);
					}

				}

				$conexao = new mysql();
				$conexao->apagar("garagem_imagem", " codigo='$data->codigo' ");

				$conexao = new mysql();
				$conexao->apagar("garagem", " codigo='$data->codigo' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller);

	}

	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function categorias(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->categorias();		

		$this->view('garagem.categorias', $dados);
	}

	public function categorias_nova(){

		$dados['_base'] = $this->base();

		$this->view('garagem.categorias.nova', $dados);
	}

	public function categorias_nova_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_categorias", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/categorias');
	}

	public function categorias_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Categoria";

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_categorias WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('garagem.categorias.alterar', $dados);
	}

	public function categorias_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("garagem_categorias", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/categorias');
	}

	public function categorias_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_categorias ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("garagem_categorias", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/categorias');
	}

	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function marcas(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Marcas";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->marcas();		

		$this->view('garagem.marcas', $dados);
	}

	public function marcas_nova(){

		$dados['_base'] = $this->base();

		$this->view('garagem.marcas.nova', $dados);
	}

	public function marcas_nova_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_marcas", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/marcas_alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function marcas_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Marca";

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_marcas WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('garagem.marcas.alterar', $dados);
	}

	public function marcas_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("garagem_marcas", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/marcas');
	}

	public function marcas_imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$banners = new model_banners();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_marcas/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				$db = new mysql();
				$db->alterar("garagem_marcas", array(
					"imagem"=>$nome_arquivo
				), " codigo='$codigo' ");

				$this->irpara(DOMINIO.$this->_controller.'/marcas_alterar/codigo/'.$codigo.'/aba/imagem');

			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/marcas_alterar/codigo/".$codigo."/aba/imagem");

			}

		}

	}

	public function marcas_apagar_imagem(){

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_marcas WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_marcas/'.$data->imagem);
			}

			$db = new mysql();
			$db->alterar("garagem_marcas", array(
				"imagem"=>''
			), " codigo='$codigo' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/marcas_alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function marcas_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_marcas ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				if($data->imagem){
					unlink('../arquivos/img_marcas/'.$data->imagem);
				}

				$conexao = new mysql();
				$conexao->apagar("garagem_marcas", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/marcas');
	}

	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function modelos_select(){

		$marca = $this->post('marca');
		$modelos = $this->modelos_select_lista($marca);

		$selecionado = $this->post('selecionado');

		echo '<select data-plugin-selectTwo class="form-control populate" name="modelo" >';
		echo "<option value='' >Selecione</option>";

		foreach ($modelos as $key => $value) {

			if($selecionado == $value['codigo']){ $select = " selected "; } else { $select = ""; }

			echo "<option value='".$value['codigo']."' $select >".$value['titulo']."</option>";

		}

		echo "</select>";

		echo "
		<script>
		$('select').select2();
		</script>
		";

	}

	public function modelos_select_lista($marca){

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_modelos where marca='$marca' order by titulo asc ");
		$n = 0;
		while($data = $exec->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;

			$n++;
		}

		return $lista;
	}

	public function modelos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Modelos";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->modelos();

		$this->view('garagem.modelos', $dados);
	}

	public function modelos_novo(){

		$dados['_base'] = $this->base();

		$garagem = new model_garagem();		 
		$dados['marcas'] = $garagem->marcas();

		$this->view('garagem.modelos.novo', $dados);
	}

	public function modelos_novo_grv(){

		$titulo = $this->post('titulo');
		$marca = $this->post('marca');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_modelos", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"marca"=>"$marca"
		));

		$this->irpara(DOMINIO.$this->_controller.'/modelos');
	}

	public function modelos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Modelo";

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_modelos WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$garagem = new model_garagem();		 
		$dados['marcas'] = $garagem->marcas();

		$this->view('garagem.modelos.alterar', $dados);
	}

	public function modelos_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 
		$marca = $this->post('marca');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($marca);

		$db = new mysql();
		$db->alterar("garagem_modelos", array(
			"titulo"=>"$titulo",
			"marca"=>"$marca"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/modelos');
	}

	public function modelos_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_modelos ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("garagem_modelos", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/modelos');
	}

	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function combustivel(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Combustivel";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->combustivel();		

		$this->view('garagem.combustivel', $dados);
	}

	public function combustivel_novo(){

		$dados['_base'] = $this->base();

		$this->view('garagem.combustivel.novo', $dados);
	}

	public function combustivel_novo_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_combustivel", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/combustivel');
	}

	public function combustivel_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Combustivel";

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_combustivel WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('garagem.combustivel.alterar', $dados);
	}

	public function combustivel_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("garagem_combustivel", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/combustivel');
	}

	public function combustivel_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_combustivel ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("garagem_combustivel", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/combustivel');
	}

	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function cores(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Cores";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->cores();		

		$this->view('garagem.cores', $dados);
	}

	public function cores_novo(){

		$dados['_base'] = $this->base();

		$this->view('garagem.cores.novo', $dados);
	}

	public function cores_novo_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_cores", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/cores');
	}

	public function cores_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Cor";

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_cores WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('garagem.cores.alterar', $dados);
	}

	public function cores_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("garagem_cores", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/cores');
	}

	public function cores_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_cores ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("garagem_cores", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/cores');
	}

	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function transmissao(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Transmissão";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->transmissao();		

		$this->view('garagem.transmissao', $dados);
	}

	public function transmissao_novo(){

		$dados['_base'] = $this->base();

		$this->view('garagem.transmissao.novo', $dados);
	}

	public function transmissao_novo_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_transmissao", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/transmissao');
	}

	public function transmissao_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Transmissão";

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_transmissao WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('garagem.transmissao.alterar', $dados);
	}

	public function transmissao_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("garagem_transmissao", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/transmissao');
	}

	public function transmissao_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_transmissao ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("garagem_transmissao", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/transmissao');
	}

	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function opcionais(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Opcionais";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->opcionais();		

		$this->view('garagem.opcionais', $dados);
	}

	public function opcionais_novo(){

		$dados['_base'] = $this->base();

		$this->view('garagem.opcionais.novo', $dados);
	}

	public function opcionais_novo_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_opcionais", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/opcionais');
	}

	public function opcionais_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Transmissão";

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_opcionais WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('garagem.opcionais.alterar', $dados);
	}

	public function opcionais_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("garagem_opcionais", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/opcionais');
	}

	public function opcionais_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_opcionais ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("garagem_opcionais", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/opcionais');
	}


	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function motor(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Motor";

		$garagem = new model_garagem();		 
		$dados['lista'] = $garagem->motor();		

		$this->view('garagem.motor', $dados);
	}

	public function motor_novo(){

		$dados['_base'] = $this->base();

		$this->view('garagem.motor.novo', $dados);
	}

	public function motor_novo_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("garagem_motor", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/motor');
	}

	public function motor_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Transmissão";

		$codigo = $this->get('codigo');
		$this->valida($codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM garagem_motor WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('garagem.motor.alterar', $dados);
	}

	public function motor_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("garagem_motor", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/motor');
	}

	public function motor_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM garagem_motor ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("garagem_motor", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/motor');
	}





	public function upload(){

		//carrega normal
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');
		$dados['codigo'] = $codigo;

		$this->view('enviar_imagens', $dados);
	}


	public function imagem_redimencionada(){

		$codigo = $this->post('codigo');

		//pasta onde vai ser salvo os arquivos
		$pasta = "veiculos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";

		//confere e cria pasta se necessario
		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}

		//carrega model de gestao de imagens
		$img = new model_arquivos_imagens();

		// Recuperando imagem em base64
		// Exemplo: data:image/png;base64,AAAFBfj42Pj4
		$imagem = $this->post_htm('imagem');
		$nome_original = $this->post('nomeimagem');

		$nome_foto  = $img->trata_nome($nome_original);
		$extensao = $img->extensao($nome_original);

		// Separando tipo dos dados da imagem
		// $tipo: data:image/png
		// $dados: base64,AAAFBfj42Pj4
		list($tipo, $dados) = explode(';', $imagem);

		// Isolando apenas o tipo da imagem
		// $tipo: image/png
		list(, $tipo) = explode(':', $tipo);

		// Isolando apenas os dados da imagem
		// $dados: AAAFBfj42Pj4
		list(, $dados) = explode(',', $dados);

		// Convertendo base64 para imagem
		$dados = base64_decode($dados);

		// Gerando nome aleatório para a imagem
		$nome = md5(uniqid(time()));

		// Salvando imagem em disco
		if(file_put_contents($diretorio_g.$nome_foto, $dados)) {			

				//confere e se jpg reduz a miniatura
			if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

				copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

					// foto grande
				$largura_g = 1200;
				$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);

					// foto minuatura
				$largura_p = 300;
				$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
				
					//redimenciona
				$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);
				$img->jpg($diretorio_p.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto);

			} else {

					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
				copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

			}

			//grava banco
			$db = new mysql();
			$db->inserir("garagem_imagem", array(
				"codigo"=>"$codigo",
				"imagem"=>"$nome_foto"
			));					
			$ultid = $db->ultimo_id();

			//ordem
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_imagem_ordem where codigo='$codigo' order by id desc limit 1");
			$data = $exec->fetch_object();

			if(isset($data->data)){
				$novaordem = $data->data.",".$ultid;
			} else {
				$novaordem = $ultid;
			}

			$db = new mysql();
			$db->inserir("garagem_imagem_ordem", array(
				"codigo"=>"$codigo",
				"data"=>"$novaordem"
			));

		}

	}


	public function imagem_manual(){

		$arquivo = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$codigo = $this->get('codigo');		

		$nome_original = $_FILES['arquivo']['name'];

		//definições de pasta
		$pasta = "veiculos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";

		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}

		$img = new model_arquivos_imagens();

		if($tmp_name) {

			$nome_foto  = $img->trata_nome($nome_original);
			$extensao = $img->extensao($nome_original);

			if(copy($tmp_name, $diretorio_g.$nome_foto)){

				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					// foto grande
					$largura_g = 1000;
					$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);
					$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto);

				} else {

					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

				}

				//grava banco
				$db = new mysql();
				$db->inserir("garagem_imagem", array(
					"codigo"=>"$codigo",
					"imagem"=>"$nome_foto"
				));				
				$ultid = $db->ultimo_id();

				//ordem
				$db = new mysql();
				$exec = $db->executar("SELECT * FROM garagem_imagem_ordem where codigo='$codigo' order by id desc limit 1");
				$data = $exec->fetch_object();

				if(isset($data->data)){
					$novaordem = $data->data.",".$ultid;
				} else {
					$novaordem = $ultid;
				}

				$db = new mysql();
				$db->inserir("garagem_imagem_ordem", array(
					"codigo"=>"$codigo",
					"data"=>"$novaordem"
				));

			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
		}

	}

 	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	private function trata_amigavel($titulo){

		$titulo = utf8_decode($titulo);
		$titulo = utf8_encode($titulo);

		//remove acentos
		$titulo_tratado = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a a e e i i o o u u n n c c"), $titulo);

		//remove caracteres indesejados
		$titulo_tratado = str_replace(array("?", ",", ".", "'", "/", "(", ")", "[", "]", "{", "}", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$", "~"), "", $titulo_tratado);

		//coloca ifen para separar palavras
		$titulo_tratado = str_replace(array("-", "_", "+"), " ", $titulo_tratado);

		$explode = explode(' ', $titulo_tratado);		
		$titulo = '';
		foreach ($explode as $key => $value) {
			if(strlen($value) >= 2){
				$titulo .= $value.'-';
			}
		}
		$size = strlen($titulo);
		$titulo = substr($titulo,0, $size-1);
		$titulo = strtolower($titulo); 
		return $titulo;
	}











// grupos


	public function grupos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		$garagem = new model_garagem();
		$dados['grupos'] = $garagem->lista_grupos();

		$this->view('garagem.grupos', $dados);
	}

	public function grupos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('garagem.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);

		// Instancia
		$garagem = new model_garagem();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('garagem_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "garagem";
		$titulo_pagina = "Garagem - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$garagem = new model_garagem();
		$dados['categorias'] = $garagem->categorias();

		$codigo = $this->get('codigo');

		$dados['data'] = $garagem->carrega_grupo($codigo);
		$dados['imagens'] = $garagem->carrega_grupo_img($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['lista_css'] = $layout->lista_css();

		$destinos = array();
		$n = 0;
		
		$db = new mysql();
		$exec_des = $db->executar("SELECT * FROM layout_paginas order by titulo asc");
		while($data_des = $exec_des->fetch_object()){
			
			$destinos[$n]['titulo'] = $data_des->titulo;
			$destinos[$n]['chave'] = $data_des->chave;

			$n++;
		}
		$dados['destinos'] = $destinos;


		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();

		$this->view('garagem.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post_html('titulo');
		$itens_por_linha = $this->post('itens_por_linha');
		$tipo = $this->post('tipo');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$itens_por_pagina = $this->post('itens_por_pagina'); 
		$marcados = $this->post('marcados');
		$max_itens = $this->post('max_itens');
		$categoria = $this->post('categoria');
		$mostrar_categorias = $this->post('mostrar_categorias');
		$slogan = $this->post_html('slogan');
		$busca_pagina = $this->post('busca_pagina');
		$novo_usado = $this->post('novo_usado');
		
		$this->valida($codigo);
		$this->valida($titulo);
		
		if(isset($_POST['lista_css'])){
			$lista_css = $_POST['lista_css'];
			$lista_css_tratada = implode(' ', $lista_css);
		} else {
			$lista_css_tratada = "";
		}

		if(isset($_POST['lista_css_img'])){
			$lista_css_img = $_POST['lista_css_img'];
			$lista_css_img_tratada = implode(' ', $lista_css_img);
		} else {
			$lista_css_img_tratada = "";
		}

		$fonte = $this->post('fonte');
		$this->valida($fonte);

		$fontes = new model_fontes(); 
		$font_family = $fontes->font_family($fonte);
		
		$db = new mysql();
		$db->alterar("garagem_grupos", array(
			'titulo'=>$titulo,
			'tipo'=>$tipo,
			'itens_por_linha'=>$itens_por_linha,
			'mostrar_titulo'=>$mostrar_titulo,
			'itens_por_pagina'=>$itens_por_pagina,
			'max_itens'=>$max_itens,
			'categoria'=>$categoria,
			'slogan'=>$slogan,
			'busca_pagina'=>$busca_pagina,
			'font'=>$fonte,
			'font_family'=>$font_family,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada,
			'novo_usado'=>$novo_usado
		), " codigo='$codigo' ");
		
		
		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pgaina = "Garagem - $titulo";
		$tipo = "garagem";
		$layout->altera_paginas($codigo, $titulo_pgaina);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$arquivo = new model_arquivos_imagens();

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_garagem_grupos/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				$db = new mysql();
				$db->inserir('garagem_grupos_imagens', array(
					'codigo'=>$codigo,
					'imagem'=>$nome_arquivo
				));
				
				$this->irpara(DOMINIO.$this->_controller.'/grupos');	

			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller.'/grupos');	
				
			}
		}		
	}

	public function grupos_imagem_apagar(){
		
		$id = $this->get('id');
		
		if($id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM garagem_grupos_imagens WHERE id='$id' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_garagem_grupos/'.$data->imagem);
			}
			
			$db->apagar("garagem_grupos_imagens", "  id='$id' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');	
	}

	public function grupos_alterar_cores_grv(){

		$codigo = $this->post('codigo');

		$this->valida($codigo);

		$layout = new model_layout();
		$cores = $layout->lista_cores($codigo);
		foreach ($cores as $key => $value) {
			$cor_nova = $this->post('cor_'.$value['id']);
			if($cor_nova){
				$db = new mysql();
				$db->alterar("layout_itens_cores_sel", array(
					'cor'=>$cor_nova
				), " id='".$value['id']."' ");
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_apagar(){

		// Instancia
		$garagem = new model_garagem();

		foreach ($garagem->lista_grupos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == $value['codigo']){

				$db = new mysql();
				$db->apagar('garagem_grupos', " codigo='".$value['codigo']."' ");

				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}
	
	public function pg_detalhes(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Detalhes";


		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();

		$destinos = array();
		$n = 0;

		$db = new mysql();
		$exec_des = $db->executar("SELECT * FROM layout_paginas order by titulo asc");
		while($data_des = $exec_des->fetch_object()){

			$destinos[$n]['titulo'] = $data_des->titulo;
			$destinos[$n]['chave'] = $data_des->chave;

			$n++;
		}
		$dados['destinos'] = $destinos;


		$db = new mysql();
		$exec_det = $db->executar("SELECT * FROM garagem_detalhes where id='1' ");
		$dados['data'] = $exec_det->fetch_object();

		$layout = new model_layout(); 

		$dados['cores'] = $layout->lista_cores('garagem_detalhes');

		$layout = new model_layout();		
		$dados['botoes'] = $layout->lista_botoes();


		$this->view('garagem.detalhes.alterar', $dados);
	}

	public function pg_detalhes_grv(){

		$destino_voltar = $this->post('destino_voltar');
		$font_codigo = $this->post('font_codigo');

		$fontes = new model_fontes(); 
		$font_family = $fontes->font_family($font_codigo);

		$db = new mysql();
		$db->alterar("garagem_detalhes", array( 
			'destino_voltar'=>$destino_voltar, 
			'font_codigo'=>$font_codigo,
			'font_family'=>$font_family
		), " id='1' ");

		$this->irpara(DOMINIO.$this->_controller.'/pg_detalhes');	
	}

	public function pg_detalhes_cores(){

		$layout = new model_layout();
		$layout->adiciona_cores('garagem_detalhes', 'garagem_detalhes');

		$cores = $layout->lista_cores('garagem_detalhes');
		foreach ($cores as $key => $value) {
			$cor_nova = $this->post('cor_'.$value['id']);
			if($cor_nova){
				$db = new mysql();
				$db->alterar("layout_itens_cores_sel", array(
					'cor'=>$cor_nova
				), " id='".$value['id']."' ");
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/pg_detalhes/aba/cores');	
	}
//termina classe
}