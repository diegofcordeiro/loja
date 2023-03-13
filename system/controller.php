<?php

class controller extends system
{

	protected $_acesso = false;
	protected $_cod_usuario = false;
	protected $_dados_usuario = false;
	protected $_nome_usuario = 'Visitante';
	protected $_carrinho_itens = 0;
	protected $_sessao_principal = false;
	protected $_sessao = false;

	protected function inicializacao()
	{ //inicialização

		if (isset($_SESSION['sessaouserloja'])) {
			$this->_sessao_principal = $_SESSION['sessaouserloja'];
		} else {
			$this->_sessao_principal = 'seso_' . $this->gera_codigo();
			$_SESSION['sessaouserloja'] = $this->_sessao_principal;
		}


		// se ta tudo certo verifica se existe uma sessao de pedido
		if (!isset($_SESSION[$this->_sessao_principal]['loja_cod_sessao'])) {
			$_SESSION[$this->_sessao_principal]['loja_cod_sessao'] = $this->gera_codigo();
		}
		$this->_sessao = $_SESSION[$this->_sessao_principal]['loja_cod_sessao'];

		// sessao de login - qui verifica através da merda de sessão se o boneco ta logado ou não
		if (isset($_SESSION[$this->_sessao_principal]) and isset($_SESSION[$this->_sessao_principal]['loja_cod_usuario']) and isset($_SESSION[$this->_sessao_principal]['loja_cod_sessao'])) {

			$this->_acesso = $_SESSION[$this->_sessao_principal]['loja_acesso'];
			$this->_cod_usuario = $_SESSION[$this->_sessao_principal]['loja_cod_usuario'];

			// model_cadastro
			$cadastro = new model_cadastro();
			if ($data = $cadastro->dados_usuario($_SESSION[$this->_sessao_principal]['loja_cod_usuario'])) {

				if ($data->tipo == 'F') {
					$nome_usuario = $data->fisica_nome;
				} else {
					$nome_usuario = $data->juridica_nome;
				}
				$this->_nome_usuario = $nome_usuario;
			} else {
				$this->finaliza_sessao();
				$this->msg('E6662 - A sessão expirou!');
				$this->irpara(DOMINIO);
			}
		} else {

			if (!isset($_SESSION[$this->_sessao_principal]['loja_cod_sessao'])) {
				$_SESSION[$this->_sessao_principal]['loja_cod_sessao'] = $this->_sessao;
			}
		}

		// carrinho
		$carrinho = new model_carrinho();
		$this->_carrinho_itens = $carrinho->itens_carrinho($this->_sessao);
	}

	protected function finaliza_sessao()
	{
		unset($_SESSION[$this->_sessao_principal]);
		unset($_SESSION['usuario_cpf']);
	}

	protected function autenticado()
	{ // caso a pagina tenha que estar logado

		if (isset($_SESSION[$this->_sessao_principal]['loja_acesso']) and isset($_SESSION[$this->_sessao_principal]['loja_cod_usuario']) and isset($_SESSION[$this->_sessao_principal]['loja_cod_sessao'])) {
		} else {
			$_SESSION['acesso_controller'] = $this->_controller;
			$_SESSION['acesso_action'] = $this->_action;
			$this->irpara(DOMINIO . 'index/entrar');
			exit;
		}
	}
	protected function curlExec($url, $post = NULL, array $header = array())
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (count($header) > 0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		if ($post !== null) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post, '', '&'));
		}
		//Ignore SSL
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($ch);

		curl_close($ch);

		return $data;
	}

	protected function _base()
	{

		$dados = array();
		$dados['libera_views'] = true;

		//detecta navegador 
		$navegador = new model_navegador();
		$dados['navegador'] = $navegador->nome();

		$dados['nome_usuario'] = $this->_nome_usuario;
		$dados['_acesso'] = $this->_acesso;

		//informações basicas de metan
		$db = new mysql();
		$config = $db->executar("select * from adm_config where id='1' ")->fetch_object();

		if ($config->analytcs) {
			$dados['analytics'] = htmlspecialchars_decode(base64_decode($config->analytcs));
		} else {
			$dados['analytics'] = "";
		}

		//imagens fixas
		$imagem = new model_imagem();
		$dados['favicon'] = $imagem->codigo('147193111415927');

		//carrega imagens do setadas no painel de controle
		$db = new mysql();
		$exec = $db->executar("select codigo, imagem from imagem ");
		while ($data = $exec->fetch_object()) {
			if ($data->imagem) {
				$dados['imagem'][$data->codigo] = PASTA_CLIENTE . 'imagens/' . $data->imagem;
			} else {
				$dados['imagem'][$data->codigo] = '';
			}
		}

		// redes sociais
		$dados['facebook'] = "";
		$dados['whatsapp'] = "";
		$redessociais = new model_redes_sociais();
		$dados['redessociais'] = $redessociais->lista();
		foreach ($dados['redessociais'] as $key => $value) {
			if (($value['titulo'] == 'facebook') or ($value['titulo'] == 'Facebook')) {
				$dados['facebook'] = $value['endereco'];
			}
			if (($value['titulo'] == 'whatsapp') or ($value['titulo'] == 'Whatsapp')) {
				$dados['whatsapp'] = $value['endereco'];
			}
		}

		// carrinho
		if ($this->_carrinho_itens == 1) {
			$dados['itens_carrinho'] = $this->_carrinho_itens . ' Item';
		} else {
			$dados['itens_carrinho'] = $this->_carrinho_itens . ' Itens';
		}

		$fontes = new model_fontes();
		$dados['fontes_utilizadas'] = $fontes->lista();

		$layout = new model_layout();
		$dados['css_personalizados'] = $layout->lista_css();


		//retorna para a pagina a array com todos as informações
		return $dados;
	}

	//carrega o html 
	protected function view($arquivo, $vars = null)
	{

		if (is_array($vars) && count($vars) > 0) {
			//transforma array em variavel
			//com prefixo
			//extract($vars, EXTR_PREFIX_ALL, 'htm_');
			//se ouver variaveis iguais adiciona prefixo
			extract($vars, EXTR_PREFIX_SAME, 'htm_');
		}

		$url_view = VIEWS . "htm_" . $arquivo . ".php";

		if (!file_exists($url_view)) {
			echo "Arquivo inválido (" . $url_view . ")";
			exit;
		} else {
			return require_once($url_view);
		}
	}

	//gera codigo que nunca se repete
	protected function gera_codigo()
	{
		return substr(time() . rand(10000, 99999), -15);
	}

	//confere se foi preenchido um campo post ou get
	protected function valida($var, $msg = null)
	{
		if (!$var) {
			if ($msg) {
				$this->msg($msg);
				$this->volta(1);
			} else {
				$this->msg('Preencha todos os campos e tente novamente!');
				$this->volta(1);
			}
		}
	}
}
