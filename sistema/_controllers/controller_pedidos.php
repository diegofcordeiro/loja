<?php

class pedidos extends controller
{

	protected $_modulo_nome = "Pedidos";

	public function init()
	{
		$this->autenticacao();
		$this->nivel_acesso(78);
	}

	public function inicial()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$aba = $this->get('aba');
		if ($aba) {
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'aprovados';
		}

		// instancia
		$pedidos = new model_pedidos();

		// $dados['incompletos'] = $pedidos->lista_incompletos();
		// $dados['estornados'] = $pedidos->lista_estornado();
		// $dados['aguardando'] = $pedidos->lista_aguardando();
		// $dados['condicionais'] = $pedidos->lista_aguardando_cond();
		// $dados['aprovados'] = $pedidos->lista_aprovados();
		// $dados['entregues'] = $pedidos->lista_entregues();
		// $dados['cancelados'] = $pedidos->lista_cancelados();

		$this->view('pedidos', $dados);
	}

	public function ajaxpedidos()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		require('../controllers/conexao.php');
		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$tipo = $_POST['tipo'];
		$rowperpage = $_POST['length']; // Rows display per page
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		// $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$columnSortOrder = 'desc'; // asc or desc
		$searchValue = mysqli_real_escape_string($conn, $_POST['search']['value']); // Search value

		$pedidos = new model_pedidos();
		$valores = new model_valores();
		## Search 
		$searchQuery = " ";
		if ($searchValue != '') {
			$searchQuery .= " and (cadastro.fisica_nome like '%" . $searchValue . "%' or
            cadastro.fisica_cpf like '%" . $searchValue . "%' or
            cadastro.email like'%" . $searchValue . "%' ) ";
		}

		## Total number of records without filtering
		$sel = mysqli_query($conn, "select count(*) as allcount from pedido_loja where status=$tipo ");
		$records = mysqli_fetch_assoc($sel);
		$totalRecords = $records['allcount'];

		## Total number of records with filtering
		$sel = mysqli_query($conn, "select count(*) as allcount from pedido_loja p inner join cadastro on cadastro.codigo = p.cadastro WHERE p.status=$tipo " . $searchQuery);
		$records = mysqli_fetch_assoc($sel);
		$totalRecordwithFilter = $records['allcount'];

		## Fetch records
		// $empRecords = $pedidos->lista_aprovados($searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);

		// $empQuery = "select * from cadastro WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
		$empQuery = "select p.id, p.codigo, p.`data`,cadastro.fisica_nome, cadastro.email, p.valor_total, p.status from pedido_loja p inner join cadastro on cadastro.codigo = p.cadastro WHERE p.status=$tipo " . $searchQuery . " order by p." . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
		$empRecords = mysqli_query($conn, $empQuery);

		$data = array();

		// foreach ($empRecords as $row) {
		while ($row = mysqli_fetch_assoc($empRecords)) {
			// $estorno = DOMINIO . $this->_controller . "estorno/vindi_estorno/codigo/" . $row['charger_id'] . "/" . "usuario_id/" . $row['cadastro'];
			// $estorno = DOMINIO . $this->_controller . "estorno/vindi_estorno/codigo/" . $row['charger_id'] . "/" . "usuario_id/" . $row['cadastro'];
			$url = "<a onClick=\"window.location='" . DOMINIO . $this->_controller  . "/detalhes/codigo/" . $row['codigo'] . "';\" style='cursor:pointer;' >";

			$data[] = array(
				"id" => $row['id'],
				"data" => $url . date('d/m/y H:i', $row['data']) . '</a>',
				"nome" => $url . $row['fisica_nome'] . '</a>',
				"email" => $url . $row['email'] . '</a>',
				"valor" => $url . 'R$ ' . $valores->trata_valor($row['valor_total']) . '</a>',
				"status" => $url . $pedidos->status($row['status']) . '</a>',
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
	public function detalhes()
	{

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Detalhes";

		$codigo = $this->get('codigo');

		$this->valida($codigo);

		// instancia
		$pedidos = new model_pedidos();
		$cadastro = new model_cadastros();
		$valores = new model_valores();
		$forma_pg = new model_formas_pagamento();

		// zera mensagens nao lidas
		$pedidos->limpa_mensagens_n_lidas($codigo);
		$dados['mensagens'] = $pedidos->lista_mensagens($codigo);

		$dados['data'] = $pedidos->carrega($codigo);

		$dados['valor_produtos'] = $valores->trata_valor($dados['data']->valor_produtos);
		$dados['descontos'] = $valores->trata_valor($dados['data']->valor_produtos_desc);
		$dados['frete_valor'] = $valores->trata_valor($dados['data']->frete_valor);
		$dados['valor_total'] = $valores->trata_valor($dados['data']->valor_total);
		$dados['valor_pago'] = $valores->trata_valor($dados['data']->valor_pago);

		if (isset($dados['data']->forma_pagamento->titulo)) {
			$dados['forma_pagamento'] = $forma_pg->carrega($dados['data']->forma_pagamento)->titulo;
		} else {
			$dados['forma_pagamento'] = "";
		}
		$dados['lista_status'] = $pedidos->lista_status($dados['data']->status);
		$dados['lista_carrinho'] = $pedidos->lista_carrinho($dados['data']->codigo);

		$valor_subtotal = 0;
		foreach ($dados['lista_carrinho'] as $key => $value) {
			$valor_subtotal = $valor_subtotal + $value['total_calculo'];
		}
		$dados['valor_subtotal'] = $valores->trata_valor($valor_subtotal);

		$dados['data_cadastro'] = $cadastro->carrega($dados['data']->cadastro);


		$this->view('pedidos.detalhes', $dados);
	}

	public function dados_arte()
	{

		$dados['_base'] = $this->base();
		$id = $this->get('id');

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT dados_arte FROM pedido_loja_carrinho WHERE id='$id' ");
		$data = $coisas->fetch_object();

		echo "
		<div style='padding:20px;'>$data->dados_arte</div>
		";
	}

	public function salvar_pedido()
	{

		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');

		$this->valida($codigo);

		// instancia
		$pedidos = new model_pedidos();
		$valores = new model_valores();

		$codigo_envio = $this->post('codigo_envio');
		$valor_pago = $this->post('valor_pago');
		$valor_pago_tratado = $valores->trata_valor_banco($valor_pago);
		$status = $this->post('status');
		// echo '<pre>';
		// print_r($status);
		// exit;
		if ($status >= 1) {

			$pedidos->altera_pedido(array(
				$valor_pago_tratado,
				$codigo_envio,
				$status
			), $codigo);

			$db = new mysql();
			$exec = $db->executar("SELECT id, cadastro FROM pedido_loja WHERE codigo='$codigo' ");
			$data_pedido = $exec->fetch_object();

			$db = new mysql();
			$exec = $db->executar("SELECT email FROM cadastro WHERE codigo='$data_pedido->cadastro' ");
			$data_cadastro = $exec->fetch_object();

			// envia email
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM conteudos WHERE codigo='157609094736033' ");
			$data_texto = $exec->fetch_object();

			$msg = $data_texto->conteudo;

			$envio = new model_envio();
			$envio->enviar("Nova interação no Pedido $data_pedido->id", $msg, array("0" => "$data_cadastro->email"));


			$this->irpara(DOMINIO . $this->_controller . '/detalhes/codigo/' . $codigo);
		} else {
			$this->msg("Selecione um status válido!");
			$this->volta(1);
		}
	}

	public function imprimir()
	{

		$dados['_base'] = $this->base();

		$codigo = $this->get('pedido');

		$this->valida($codigo);

		// instancia
		$pedidos = new model_pedidos();
		$cadastro = new model_cadastros();
		$valores = new model_valores();

		$dados['data'] = $pedidos->carrega($codigo);

		$dados['valor_produtos'] = $valores->trata_valor($dados['data']->valor_produtos);
		$dados['descontos'] = $valores->trata_valor($dados['data']->valor_produtos_desc);
		$dados['frete_valor'] = $valores->trata_valor($dados['data']->frete_valor);
		$dados['valor_total'] = $valores->trata_valor($dados['data']->valor_total);
		$dados['valor_pago'] = $valores->trata_valor($dados['data']->valor_pago);

		$dados['lista_status'] = $pedidos->lista_status($dados['data']->status);
		$dados['lista_carrinho'] = $pedidos->lista_carrinho($dados['data']->codigo);

		$valor_subtotal = 0;
		foreach ($dados['lista_carrinho'] as $key => $value) {
			$valor_subtotal = $valor_subtotal + $value['total_calculo'];
		}
		$dados['valor_subtotal'] = $valores->trata_valor($valor_subtotal);

		$dados['data_cadastro'] = $cadastro->carrega($dados['data']->cadastro);

		$this->view('pedidos.imprimir', $dados);
	}

	public function etiqueta()
	{

		$dados['_base'] = $this->base();

		$codigo = $this->get('pedido');

		$this->valida($codigo);

		// instancia
		$pedidos = new model_pedidos();
		$cadastro = new model_cadastros();

		$dados['data'] = $pedidos->carrega($codigo);
		$dados['data_cadastro'] = $cadastro->carrega($dados['data']->cadastro);

		$this->view('pedidos.etiqueta', $dados);
	}

	public function envia_msg()
	{

		$pedido = $this->post('pedido');
		$pedido_id = $this->post('pedido_id');
		$mensagem = $this->post('mensagem');
		$email_cliente = $this->post('email_cliente');

		// validacoes
		$this->valida($pedido);
		if (!$mensagem) {
			$this->msg('Digite uma mensagem para continuar...');
			$this->volta(1);
		}

		// arquivo
		$nome_arquivo = "";

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		if ($tmp_name) {

			//carrega model de gestao de imagens
			$arquivo = new model_arquivos_imagens();

			//// Definicao de Diretorios / 
			$diretorio = "arquivos/anexos_pedidos/$pedido/";
			// verifica se exite a pasta
			if (!is_dir($diretorio)) {
				mkdir($diretorio);
			}

			if (!$arquivo->filtro($arquivo_original)) {
				$this->msg('Arquivo com formato inválido ou inexistente!');
				$this->volta(1);
			} else {

				$nome_original = $_FILES['arquivo']['name'];
				$nome_arquivo  = $arquivo->trata_nome($nome_original);
				$destino = $diretorio . $nome_arquivo;

				if (!copy($tmp_name, $destino)) {
					$this->msg('Não foi possível anexar o arquivo, verifique o tamanho e o nome do seu arquivo!');
					$this->volta(1);
				}
			}
		}

		$time = time();

		$db = new mysql();
		$db->inserir("pedido_loja_mensagens", array(
			"pedido" => "$pedido",
			"usuario" => '1',
			"data" => $time,
			"msg" => "$mensagem",
			"anexo" => "$nome_arquivo",
			"lida" => 0
		));

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM conteudos WHERE codigo='150432279044656' ");
		$data_texto = $exec->fetch_object();

		$msg = $data_texto->conteudo;

		// envia o email
		$envio = new model_envio();
		$envio->enviar("Nova mensagem no Pedido $pedido_id", $msg, array("0" => "$email_cliente"));

		$this->irpara(DOMINIO . 'pedidos/detalhes/codigo/' . $pedido);
	}
}
