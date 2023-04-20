<?php

class cadastro extends controller
{

	protected $_modulo_nome = "Cadastros";

	public function init()
	{
		$this->autenticacao();
		$this->nivel_acesso(76);
	}

	public function inicial()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$db = new model_cadastros();
		$dados['lista'] = $db->lista();

		$dados['aniversariantes'] = false;

		$this->view('cadastro', $dados);
	}

	public function detalhes()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Detalhes";

		$codigo = $this->get('codigo');

		$cadastro = new model_cadastros();
		$dados['data'] = $cadastro->seleciona($codigo);

		if (!isset($dados['data'])) {
			$this->irpara(DOMINIO . $this->_controller);
		}

		$dados['comentarios'] = $cadastro->comentarios($codigo);
		$dados['avalistas'] = $cadastro->lista();

		$this->view('cadastro.detalhes', $dados);
	}

	public function novo()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;

		$this->view('cadastro.novo', $dados);
	}

	public function novo_grv()
	{

		$tipo = $this->post('tipo');
		$nome = $this->post('nome');

		$this->valida($tipo);
		$this->valida($nome);

		$codigo = $this->gera_codigo();

		if ($tipo == "J") {

			$db = new mysql();
			$db->inserir("cadastro", array(
				"codigo" => "$codigo",
				"tipo" => "$tipo",
				"juridica_nome" => "$nome"
			));
		} else {

			$db = new mysql();
			$db->inserir("cadastro", array(
				"codigo" => "$codigo",
				"tipo" => "$tipo",
				"fisica_nome" => "$nome"
			));
		}

		$this->irpara(DOMINIO . $this->_controller . '/alterar/codigo/' . $codigo);
	}

	public function alterar()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		//instancia cadastros
		$cadastro = new model_cadastros();

		//dados
		$dados['data'] = $cadastro->seleciona($codigo);

		if (!isset($dados['data'])) {
			$this->irpara(DOMINIO . $this->_controller);
		}

		$estado = new model_estados_cidades();
		$dados['estados'] = $estado->lista_estados();

		$this->view('cadastro.alterar', $dados);
	}

	public function alterar_grv()
	{

		$codigo = $this->post('codigo');

		$tipo = $this->post('tipo');

		$fisica_nome = $this->post('fisica_nome');
		$juridica_nome = $this->post('juridica_nome');

		$juridica_razao = $this->post('juridica_razao');
		$juridica_cnpj = $this->post('juridica_cnpj');
		$juridica_ie = $this->post('juridica_ie');
		$juridica_responsavel = $this->post('juridica_responsavel');

		$fisica_cpf = $this->post('fisica_cpf');

		$telefone = $this->post('telefone');
		$email = $this->post('email');

		$fisica_nascimento = $this->post('fisica_nascimento');
		$fisica_sexo = $this->post('fisica_sexo');

		$endereco = $this->post('endereco');
		$numero = $this->post('numero');
		$complemento = $this->post('complemento');
		$bairro = $this->post('bairro');
		$cep = $this->post('cep');
		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		$valida = new model_valida();

		require_once("_api/cpf_cnpj/cpf_cnpj.php");

		if ($tipo == 'J') {
			//validacoes
			if ($juridica_cnpj) {
				$cpf_cnpj = new valida_cpf_cnpj("$juridica_cnpj");
				if (!$cpf_cnpj->valida()) {
					$this->msg("CNPJ inválido!");
					$this->volta(1);
				}
			}
			if ($fisica_cpf) {
				$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
				if (!$cpf_cnpj->valida()) {
					$this->msg("CPF inválido!");
					$this->volta(1);
				}
			}
		} else {
			//validacoes
			if ($fisica_cpf) {
				$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
				if (!$cpf_cnpj->valida()) {
					$this->msg("CPF inválido!");
					$this->volta(1);
				}
			}
		}

		//validacoes
		$this->valida($tipo);

		if ($email) {

			if (!$valida->email($email)) {
				$this->msg('E-mail inválido');
				$this->volta(1);
			}

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE email='$email' AND codigo!='$codigo' ");
			$linhas = $coisas->num_rows;

			if ($linhas != 0) {
				$this->msg('Este e-mail já está cadastrado');
				$this->volta(1);
			}
		} else {

			$this->msg('E-mail inválido');
			$this->volta(1);
		}

		if ($fisica_nascimento) {

			// transforma data em inteiro
			$arraydata = explode("/", $fisica_nascimento);
			$hora_montada = $arraydata[2] . "-" . $arraydata[1] . "-" . $arraydata[0] . " 00:00:01";
			$fisica_nascimento = strtotime($hora_montada);
		} else {
			$fisica_nascimento = 0;
		}


		$time = time();

		$db = new mysql();
		$db->alterar("cadastro", array(
			"tipo" => "$tipo",
			"fisica_nome" => "$fisica_nome",
			"fisica_sexo" => "$fisica_sexo",
			"fisica_nascimento" => "$fisica_nascimento",
			"fisica_cpf" => "$fisica_cpf",
			"juridica_nome" => "$juridica_nome",
			"juridica_razao" => "$juridica_razao",
			"juridica_responsavel" => "$juridica_responsavel",
			"juridica_cnpj" => "$juridica_cnpj",
			"juridica_ie" => "$juridica_ie",
			"cep" => "$cep",
			"endereco" => "$endereco",
			"numero" => "$numero",
			"complemento" => "$complemento",
			"bairro" => "$bairro",
			"estado" => "$estado",
			"cidade" => "$cidade",
			"telefone" => "$telefone",
			"email" => "$email"
		), " codigo='$codigo' ");


		$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
	}

	public function avalista_grv()
	{

		$codigo = $this->post('codigo');
		$avalista = $this->post('avalista');

		if ($codigo and $avalista) {

			$db = new mysql();
			$db->alterar("cadastro", array(
				"avalista" => "$avalista"
			), " codigo='$codigo' ");

			$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
		} else {
			$this->msg('Preencha todos os campos!');
			$this->volta(1);
		}
	}

	public function apagar_varios()
	{

		$db = new mysql();
		$exec = $db->executar("SELECT id, codigo, imagem FROM cadastro ");
		while ($data = $exec->fetch_object()) {

			if ($this->post('apagar_' . $data->id) == 1) {

				if ($data->imagem) {

					unlink('../arquivos/img_clientes/' . $data->imagem);
				}

				$remove = new mysql();
				$remove->apagar("cadastro_comentarios", " cadastro='$data->codigo' ");

				$remove = new mysql();
				$remove->apagar("cadastro", " id='$data->id' ");
			}
		}

		$this->irpara(DOMINIO . $this->_controller);
	}


	public function comentario_grv()
	{

		$codigo = $this->post('codigo');
		$comentario = nl2br($this->post('comentario'));
		$time = time();

		$db = new mysql();
		$db->inserir("cadastro_comentarios", array(
			"usuario" => "$this->_cod_usuario",
			"cadastro" => "$codigo",
			"data" => "$time",
			"comentario" => "$comentario"
		));

		$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
	}

	public function ajaxfile()
	{
		require('../controllers/conexao.php');
		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length']; // Rows display per page
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = mysqli_real_escape_string($conn, $_POST['search']['value']); // Search value

		## Search 
		$searchQuery = " ";
		if ($searchValue != '') {
			$searchQuery .= " and (fisica_nome like '%" . $searchValue . "%' or
            fisica_cpf like '%" . $searchValue . "%' or
            email like'%" . $searchValue . "%' ) ";
		}

		## Total number of records without filtering
		$sel = mysqli_query($conn, "select count(*) as allcount from cadastro");
		$records = mysqli_fetch_assoc($sel);
		$totalRecords = $records['allcount'];

		## Total number of records with filtering
		$sel = mysqli_query($conn, "select count(*) as allcount from cadastro WHERE 1 " . $searchQuery);
		$records = mysqli_fetch_assoc($sel);
		$totalRecordwithFilter = $records['allcount'];

		## Fetch records
		$empQuery = "select * from cadastro WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
		$empRecords = mysqli_query($conn, $empQuery);

		$data = array();

		while ($row = mysqli_fetch_assoc($empRecords)) {
			$id = "<input type='checkbox' class='marcar' name='apagar_" . $row['id'] . "' value='1' >";
			$url = "<a onClick=\"window.location='" . DOMINIO . $this->_controller  . "/detalhes/codigo/" . $row['codigo'] . "';\" style='cursor:pointer;' >";
			$data[] = array(
				"id" => $id,
				"nome" => $url . $row['fisica_nome'] . '</a>',
				"documento" => $url . $row['fisica_cpf'] . '</a>',
				"fone" => $url . $row['telefone'] . '</a>',
				"email" => $url . $row['email'] . '</a>'
			);
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		echo json_encode($response);
	}



	public function alterar_senha_usuario()
	{
		require('../controllers/conexao.php');
		$db = new mysql();

		$codigo = $this->post('codigo');
		$senha = $this->post('senha');
		$senha_md5 = md5($senha);
		$senha_tratada = password_hash($senha, PASSWORD_DEFAULT);

		$exec = $db->executar("SELECT lms_usuario_id FROM cadastro WHERE codigo = '$codigo'");
		$res = $exec->fetch_object();

		$sql = "UPDATE usuario SET  senha = '$senha_md5' WHERE id = '$res->lms_usuario_id'";
		$mysqli->query($sql);

		$db->alterar("cadastro", array(
			"senha" => "$senha_tratada",
			"senha_md5" => "$senha_md5"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
	}

	public function comentario_apagar()
	{

		$codigo = $this->get('cadastro');
		$id = $this->get('id');

		if ($id and $codigo) {

			$remove = new mysql();
			$remove->apagar("cadastro_comentarios", " id='$id' ");
		}

		$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
	}


	public function alterar_imagem()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;

		$dados['codigo'] = $this->get('codigo');


		$this->view('cadastro.alterar.imagem', $dados);
	}

	public function alterar_imagem_grv()
	{

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();

		$codigo = $this->post('codigo');

		$diretorio = "../arquivos/img_clientes/";

		if (!$arquivo->filtro($arquivo_original)) {
			$this->msg('Arquivo com formato inválido ou inexistente!');
			$this->volta(1);
		} else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if (copy($tmp_name, $diretorio . $nome_arquivo)) {

				if (($extensao == "jpg") or ($extensao == "jpeg") or ($extensao == "JPG") or ($extensao == "JPEG")) {

					//calcula a 
					$largura_g = 1200;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio . $nome_arquivo, $largura_g);

					//redimenciona
					$arquivo->jpg($diretorio . $nome_arquivo, $largura_g, $altura_g, $diretorio . $nome_arquivo);
				}

				// remove imagem anterior

				$db = new mysql();
				$exec = $db->executar("SELECT imagem FROM cadastro where codigo='$codigo' ");
				$data = $exec->fetch_object();

				if ($data->imagem) {
					unlink('../arquivos/img_clientes/' . $data->imagem);
				}

				//grava banco

				$db = new mysql();
				$db->alterar("cadastro", array(
					"imagem" => "$nome_arquivo"
				), " codigo='$codigo' ");


				$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
			}
		}
	}

	public function apagar_imagem()
	{

		$codigo = $this->get('codigo');

		if ($codigo) {

			$db = new mysql();
			$exec = $db->executar("SELECT imagem FROM cadastro where codigo='$codigo' ");
			$data = $exec->fetch_object();

			if ($data->imagem) {

				unlink('../arquivos/img_clientes/' . $data->imagem);

				$db = new mysql();
				$db->alterar("cadastro", array(
					"imagem" => ""
				), " codigo='$codigo' ");
			}
		} else {
			$this->msg("erro");
		}

		$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
	}

	public function exportar()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Exportar";

		$dados['mostrar_lista'] = false;
		$dados['aniversariantes'] = false;

		// intancia
		$cadastro = new model_cadastros();

		$formato = $this->post('formato');
		$dados['formato'] = $formato;

		if ($formato) {

			$dados['mostrar_lista'] = true;

			if ($formato == 1) {
				$separador = ';';
			} else {
				$separador = ',';
			}

			$lista_exportada = '';
			foreach ($cadastro->lista() as $key => $value) {
				$lista_exportada .= $value['email'] . $separador;
			}

			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.exportar', $dados);
	}

	public function exportar_aniversariantes()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Exportar Aniversariantes";

		$dados['mostrar_lista'] = false;
		$dados['aniversariantes'] = true;

		// intancia
		$cadastro = new model_cadastros();

		$formato = $this->post('formato');
		$dados['formato'] = $formato;

		if ($formato) {

			$dados['mostrar_lista'] = true;

			if ($formato == 1) {
				$separador = ';';
			} else {
				$separador = ',';
			}

			$lista_exportada = '';
			foreach ($cadastro->aniversariantes() as $key => $value) {
				$lista_exportada .= $value['email'] . $separador;
			}

			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.exportar', $dados);
	}


	public function aniversariantes()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Aniversariantes";

		$db = new model_cadastros();
		$dados['lista'] = $db->aniversariantes();

		$dados['aniversariantes'] = true;

		$this->view('cadastro', $dados);
	}



	public function grupos()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$cadastro = new model_cadastros();

		$dados['grupos'] = $cadastro->lista_grupos();

		$this->view('cadastro.grupos', $dados);
	}

	public function grupos_novo()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('cadastro.grupos.novo', $dados);
	}

	public function grupos_novo_grv()
	{

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('cadastro_grupos', array(
			'codigo' => $codigo,
			'titulo' => $titulo
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "cadastro";
		$titulo_pagina = "Cadastro - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO . $this->_controller . '/grupos');
	}

	public function grupos_alterar()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

		// Instancia
		$cadastro = new model_cadastros();

		$codigo = $this->get('codigo');

		$dados['data'] = $cadastro->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();

		$this->view('cadastro.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv()
	{

		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$descricao = $this->post_htm('descricao');
		$dados_acesso = $this->post('dados_acesso');
		$botao = $this->post('botao');

		$this->valida($codigo);
		$this->valida($titulo);

		if (isset($_POST['lista_css'])) {
			$lista_css = $_POST['lista_css'];
			$lista_css_tratada = implode(' ', $lista_css);
		} else {
			$lista_css_tratada = "";
		}

		if (isset($_POST['lista_css_img'])) {
			$lista_css_img = $_POST['lista_css_img'];
			$lista_css_img_tratada = implode(' ', $lista_css_img);
		} else {
			$lista_css_img_tratada = "";
		}

		$db = new mysql();
		$db->alterar("cadastro_grupos", array(
			'titulo' => $titulo,
			'mostrar_titulo' => $mostrar_titulo,
			'descricao' => $descricao,
			'dados_acesso' => $dados_acesso,
			'botao_codigo' => $botao,
			'classes' => $lista_css_tratada,
			'classes_img' => $lista_css_img_tratada
		), " codigo='$codigo' ");

		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pagina = "Cadastro - $titulo";
		$tipo = "cadastro";
		$layout->altera_paginas($codigo, $titulo_pagina);
		$layout->adiciona_cores($tipo, $codigo);

		$cores = $layout->lista_cores($codigo);
		foreach ($cores as $key => $value) {
			$cor_nova = $this->post('cor_' . $value['id']);
			if ($cor_nova) {
				$db = new mysql();
				$db->alterar("layout_itens_cores_sel", array(
					'cor' => $cor_nova
				), " id='" . $value['id'] . "' ");
			}
		}

		$this->irpara(DOMINIO . $this->_controller . '/grupos');
	}

	public function grupos_apagar()
	{

		// Instancia
		$cadastro = new model_cadastros();

		foreach ($cadastro->lista_grupos() as $key => $value) {

			if ($this->post('apagar_' . $value['id']) == $value['codigo']) {

				$db = new mysql();
				$db->apagar('cadastro_grupos', " codigo='" . $value['codigo'] . "' ");

				// layout
				$layout = new model_layout();
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}
		}

		$this->irpara(DOMINIO . $this->_controller . '/grupos');
	}


	public function pg_detalhes()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Detalhes";


		$aba = $this->get('aba');
		if ($aba) {
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}


		$layout = new model_layout();
		$dados['botoes'] = $layout->lista_botoes();


		$db = new mysql();
		$exec_det = $db->executar("SELECT * FROM cadastro_detalhes where id='1' ");
		$dados['data'] = $exec_det->fetch_object();


		$this->view('cadastro.detalhes.alterar', $dados);
	}

	public function pg_detalhes_grv()
	{

		$botao_codigo = $this->post('botao_codigo');

		if ($botao_codigo) {

			$db = new mysql();
			$db->alterar("cadastro_detalhes", array(
				'botao_codigo' => $botao_codigo
			), " id='1' ");
		}

		$this->irpara(DOMINIO . $this->_controller . '/pg_detalhes');
	}
}
