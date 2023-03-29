<?php

class model_produtos extends model
{

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// tabelas

	private $tab_produtos 			= "produto";
	private $tab_icone_categoria 	= "icone_categoria";
	private $tab_categorias 		= "produto_categoria";
	private $tab_canal 				= "canal";
	private $produto_canal 			= "produto_canal";
	private $tab_categorias_ordem 	= "produto_categoria_ordem";
	private $tab_categorias_prod 	= "produto_categoria_sel";
	private $tab_curso_categoria_sel 	= "curso_categoria_sel";
	private $tab_imagem 			= "produto_imagem";
	private $tab_imagem_ordem 		= "produto_imagem_ordem";
	private $tab_mascara 			= "produto_marcadagua";
	private $tab_marcas				= "marcas";
	private $tab_cores 				= "produto_cor";
	private $tab_cores_sel 			= "produto_cor_sel";
	private $tab_tamanhos 			= "produto_tamanho";
	private $tab_tamanhos_sel 		= "produto_tamanho_sel";
	private $tab_variacoes 			= "produto_variacao";
	private $tab_variacoes_sel 		= "produto_variacao_sel";
	private $tab_estoque 			= "produto_estoque";
	private $tab_estoque_registro 	= "produto_estoque_registro";
	private $tab_entrega			= "produto_entrega_auto";
	private $tab_gabaritos 			= "produto_gabaritos";
	private $curso_produto 			= "curso_produto";
	private $combo_produto 			= "combo_produto";


	// LISTA

	public function lista()
	{

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_produtos . " order by titulo asc ");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['ref'] = $data->ref;

			$i++;
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function check_exist($id, $codigo)
	{

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM combo_produto WHERE id_combo != '$codigo' and id_produto = '" . $id . "' ");

		$data = $exec->num_rows;

		return $data;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function carrega_produto($codigo)
	{

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_produtos . " WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function get_icone_categoria()
	{

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_icone_categoria . " ");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['url'] = $data->url;

			$i++;
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function alterar_image_icone($codigo, $nome_foto)
	{

		$db = new mysql();
		$db->alterar($this->tab_categorias, array(
			"imagem"			=> $nome_foto
		), " id='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function novo_produto($codigo, $titulo, $ref)
	{

		$db = new mysql();
		$db->inserir($this->tab_produtos, array(
			"codigo"	=> $codigo,
			"ref"	    => $ref,
			"titulo"	=> $titulo,
			"status"	=> 0
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function verifica_ref($ref, $codigo)
	{

		$conexao = new mysql();
		$coisas_ref = $conexao->Executar("select id from " . $this->tab_produtos . " where ref='$ref' AND codigo!='$codigo' ");
		$linhas_ref = $coisas_ref->num_rows;
		if ($linhas_ref != 0) {
			return false;
		} else {
			return true;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_produto_frete($vars, $codigo)
	{

		$db = new mysql();
		$db->alterar($this->tab_produtos, array(
			"peso"			=> $vars[0],
			"largura"		=> $vars[1],
			"comprimento"	=> $vars[2],
			"altura"		=> $vars[3],
			"fretegratis"	=> $vars[4]
		), " codigo='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apagar_produto($codigo)
	{

		$db = new mysql();
		$db->apagar($this->tab_produtos, " codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_categorias_prod, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_imagem, " codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_imagem_ordem, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_tamanhos_sel, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_cores_sel, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_variacoes_sel, " produto_codigo='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function apagar_produto_combo($id)
	{
		$db = new mysql();
		$db->apagar($this->combo_produto, " id_produto='$id' ");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function apagar_produto_curso($id)
	{
		$db = new mysql();
		$db->apagar($this->curso_produto, " id_produto='$id' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function confere_canal($canal, $codigo)
	{

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM " . $this->produto_canal . " where id_produto='$codigo' AND id_canal='$canal' ");
		$linhas = $exec->num_rows;

		if ($linhas == 0) {
			return false;
		} else {
			return true;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_produto_canal($canal, $codigo)
	{
		$db = new mysql();
		$db->inserir($this->produto_canal, array(
			"id_produto" => "$codigo",
			"id_canal" => "$canal"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_produto_canal($canal, $codigo)
	{
		$db = new mysql();
		$db->apagar($this->produto_canal, " id_produto='$codigo' AND id_canal='$canal' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function confere_categoria($categoria, $codigo)
	{

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM " . $this->tab_categorias_prod . " where produto_codigo='$codigo' AND categoria_codigo='$categoria' ");
		$linhas = $exec->num_rows;

		if ($linhas == 0) {
			return false;
		} else {
			return true;
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_produto_categoria($categoria, $codigo)
	{
		$db = new mysql();
		$db->inserir($this->tab_categorias_prod, array(
			"produto_codigo" => "$codigo",
			"categoria_codigo" => "$categoria"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//


	public function confere_curso_categoria($categoria, $codigo)
	{

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM " . $this->tab_curso_categoria_sel . " where curso_id='$codigo' AND categoria_codigo='$categoria' ");
		$linhas = $exec->num_rows;

		if ($linhas == 0) {
			return false;
		} else {
			return true;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_curso_categoria($categoria, $codigo)
	{
		$db = new mysql();
		$db->inserir($this->tab_curso_categoria_sel, array(
			"curso_id" => "$codigo",
			"categoria_codigo" => "$categoria"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_produto_categoria($categoria, $codigo)
	{
		$db = new mysql();
		$db->apagar($this->tab_categorias_prod, " produto_codigo='$codigo' AND categoria_codigo='$categoria' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	public function apaga_curso_categoria($categoria, $codigo)
	{
		$db = new mysql();
		$db->apagar($this->tab_curso_categoria_sel, " curso_id='$codigo' AND categoria_codigo='$categoria' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_produto_tamanho($tamanho, $codigo, $valor)
	{
		$db = new mysql();
		$db->inserir($this->tab_tamanhos_sel, array(
			"produto_codigo" => "$codigo",
			"tamanho_codigo" => "$tamanho",
			"valor" => "$valor"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_produto_tamanho($tamanho, $codigo, $valor)
	{
		$db = new mysql();
		$db->alterar($this->tab_tamanhos_sel, array(
			"valor" => "$valor"
		), " produto_codigo='$codigo' AND tamanho_codigo='$tamanho' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_produto_tamanho($tamanho, $codigo)
	{
		$db = new mysql();
		$db->apagar($this->tab_tamanhos_sel, " produto_codigo='$codigo' AND tamanho_codigo='$tamanho' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_produto_cor($cor, $codigo, $valor)
	{
		$db = new mysql();
		$db->inserir($this->tab_cores_sel, array(
			"produto_codigo" => "$codigo",
			"cor_codigo" => "$cor",
			"valor" => "$valor"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_produto_cor($cor, $codigo, $valor)
	{
		$db = new mysql();
		$db->alterar($this->tab_cores_sel, array(
			"valor" => "$valor"
		), " produto_codigo='$codigo' AND cor_codigo='$cor' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_produto_cor($cor, $codigo)
	{
		$db = new mysql();
		$db->apagar($this->tab_cores_sel, " produto_codigo='$codigo' AND cor_codigo='$cor' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_produto_variacao($variacao, $codigo, $valor)
	{
		$db = new mysql();
		$db->inserir($this->tab_variacoes_sel, array(
			"produto_codigo" => "$codigo",
			"variacao_codigo" => "$variacao",
			"valor" => "$valor"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_produto_variacao($variacao, $codigo, $valor)
	{
		$db = new mysql();
		$db->alterar($this->tab_variacoes_sel, array(
			"valor" => "$valor"
		), " produto_codigo='$codigo' AND variacao_codigo='$variacao' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_produto_variacao($variacao, $codigo)
	{
		$db = new mysql();
		$db->apagar($this->tab_variacoes_sel, " produto_codigo='$codigo' AND variacao_codigo='$variacao' ");
	}




	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// IMAGENS

	public function lista_imagens($codigo)
	{

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM " . $this->tab_imagem_ordem . " WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		$n = 0;
		$dados = array();
		$imagens = array();
		if (isset($data_ordem->data)) {

			$order = explode(',', $data_ordem->data);

			foreach ($order as $key => $value) {

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM " . $this->tab_imagem . " WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();

				if (isset($data_img->imagem)) {

					if ($n == 0) {
						$dados['principal'] = PASTA_CLIENTE . 'img_produtos_g/' . $codigo . '/' . $data_img->imagem;
					}

					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem'] = $data_img->imagem;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE . 'img_produtos_p/' . $codigo . '/' . $data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE . 'img_produtos_g/' . $codigo . '/' . $data_img->imagem;

					$n++;
				}
			}
		}

		return $imagens;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function ordem_imagens($codigo)
	{

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM " . $this->tab_imagem_ordem . " WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		if (isset($data_ordem->data)) {
			return $data_ordem->data;
		} else {
			return false;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function salva_ordem_imagem($codigo, $ordem)
	{

		$db = new mysql();
		$db->inserir($this->tab_imagem_ordem, array(
			"codigo" => "$codigo",
			"data" => "$ordem"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function seleciona_imagem($id)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_imagem . " WHERE id='$id' ");
		return $exec->fetch_object();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_imagem($vars)
	{

		$db = new mysql();
		$db->inserir($this->tab_imagem, array(
			"codigo"	=> $vars[0],
			"imagem"	=> $vars[1]
		));
		$ultid = $db->ultimo_id();

		return $ultid;
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apagar_imagem_codigo($codigo)
	{

		$db = new mysql();
		$db->apagar($this->tab_imagem, " codigo='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apagar_imagem($codigo)
	{

		$db = new mysql();
		$db->apagar($this->tab_imagem, " id='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_imagem($imagem, $id)
	{

		$db = new mysql();
		$db->alterar($this->tab_imagem, array(
			"imagem"	=> $imagem
		), " id='$id' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_imagem_produto($imagem, $id)
	{

		$db = new mysql();
		$db->alterar($this->tab_imagem, array(
			"imagem"	=> $imagem
		), " codigo='$id' ");
	}



	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MASCARA IMAGEM

	public function carrega_mascara()
	{

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_mascara . " WHERE id='1' ");
		$data_masc = $exec->fetch_object();
		return $data_masc->codigo;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_mascara($codigo)
	{

		$db = new mysql();
		$db->alterar($this->tab_mascara, array(
			"codigo"	=> $codigo
		), " id='1' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CANAL

	public function lista_canal($produto = 0)
	{

		$tab_canal = $this->tab_canal;
		$tab_produto_canal = $this->produto_canal;

		function montacanal($id_pai, $tab_canal, $tab_produto_canal, $produto)
		{

			$i = 0;
			$lista = array();

			$db = new mysql();
			$result2 = $db->query("SELECT * FROM " . $tab_canal . " ORDER BY status asc");

			while ($obj = $result2->fetch_object()) {
				$db = new mysql();
				$lista[$i]['id'] = $obj->id_canal;
				$lista[$i]['nome'] = $obj->nm_canal;
				$lista[$i]['status'] = $obj->status;

				$coisas_confere = $db->query("SELECT id_produto_canal FROM " . $tab_produto_canal . " WHERE id_canal='$obj->id_canal' AND id_produto='$produto' ");
				$data_confere = $coisas_confere->fetch_object();

				if (isset($data_confere->id_produto_canal)) {
					$lista[$i]['check_prod'] = true;
				} else {
					$lista[$i]['check_prod'] = false;
				}
				$i++;
			}
			return $lista;
		}
		$lista = montacanal(0, $tab_canal, $tab_produto_canal, $produto);

		//echo "<pre>"; print_r($lista); echo "</pre>"; exit;

		return $lista;
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function altera_canal_ordem($id_canal, $ordem)
	{
		// $db = new mysql();
		// $result = $db->alterar($this->tab_canal, array(
		// 	"status"=>"$ordem"
		// ),  " WHERE id_canal = '$id_canal' ");
		$db = new mysql();
		$db->query("UPDATE `canal` SET `status`='$ordem' WHERE `id_canal` = '$id_canal' ");
		// print_r($exec->num_rows);
		// exit;

	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CATEGORIAS

	public function lista_categorias($produto = 0)
	{

		$tab_categorias_ordem = $this->tab_categorias_ordem;
		$tab_categorias = $this->tab_categorias;
		$tab_categorias_prod = $this->tab_categorias_prod;

		function montaCategorias($id_pai, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto)
		{

			$i = 0;
			$lista = array();

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM " . $tab_categorias_ordem . " WHERE id_pai='$id_pai' ORDER BY id desc limit 1");
			$data = $exec->fetch_object();
			if (isset($data->data)) {

				$order = explode(',', $data->data);
				foreach ($order as $key => $value) {

					$db = new mysql();
					$exec = $db->Executar("SELECT * FROM " . $tab_categorias . " WHERE id='$value' ");
					$data = $exec->fetch_object();

					if (isset($data->titulo)) {

						$lista[$i]['id'] = $value;
						$lista[$i]['id_pai'] = $id_pai;
						$lista[$i]['codigo'] = $data->codigo;
						$lista[$i]['titulo'] = $data->titulo;
						$lista[$i]['subcategorias'] = montaCategorias($value, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto);

						if ($produto != 0) {

							$exec = new mysql();
							$coisas_confere = $exec->Executar("SELECT id FROM " . $tab_categorias_prod . " WHERE categoria_codigo='$data->codigo' AND produto_codigo='$produto' ");
							$data_confere = $coisas_confere->fetch_object();

							if (isset($data_confere->id)) {
								$lista[$i]['check_prod'] = true;
							} else {
								$lista[$i]['check_prod'] = false;
							}
						}

						$i++;
					}
				}
			}
			return $lista;
		}
		$lista = montaCategorias(0, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto);

		//echo "<pre>"; print_r($lista); echo "</pre>"; exit;

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function lista_categorias_cursos($produto = 0)
	{

		$tab_categorias_ordem = $this->tab_categorias_ordem;
		$tab_categorias = $this->tab_categorias;
		$tab_categorias_prod = $this->tab_categorias_prod;

		function montaCategorias($id_pai, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto)
		{

			$i = 0;
			$lista = array();

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM " . $tab_categorias_ordem . " WHERE id_pai='$id_pai' ORDER BY id desc limit 1");
			$data = $exec->fetch_object();
			if (isset($data->data)) {

				$order = explode(',', $data->data);
				foreach ($order as $key => $value) {

					$db = new mysql();
					$exec = $db->Executar("SELECT * FROM " . $tab_categorias . " WHERE id='$value' ");
					$data = $exec->fetch_object();

					if (isset($data->titulo)) {

						$lista[$i]['id'] = $value;
						$lista[$i]['id_pai'] = $id_pai;
						$lista[$i]['codigo'] = $data->codigo;
						$lista[$i]['titulo'] = $data->titulo;
						$lista[$i]['subcategorias'] = montaCategorias($value, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto);

						if ($produto != 0) {

							$exec = new mysql();
							$coisas_confere = $exec->Executar("SELECT id FROM curso_categoria_sel WHERE categoria_codigo='$data->codigo' AND curso_id='$produto' ");
							$data_confere = $coisas_confere->fetch_object();

							if (isset($data_confere->id)) {
								$lista[$i]['check_prod'] = true;
							} else {
								$lista[$i]['check_prod'] = false;
							}
						}

						$i++;
					}
				}
			}
			return $lista;
		}
		$lista = montaCategorias(0, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto);

		//echo "<pre>"; print_r($lista); echo "</pre>"; exit;

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function lista_categorias_todas()
	{

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_categorias . " order by titulo asc");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['id_pai'] = $data->id_pai;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$i++;
		}

		return $lista;
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function lista_canais_todos()
	{

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_canal . " order by nm_canal asc");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id_canal;
			$lista[$i]['titulo'] = $data->nm_canal;

			$i++;
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function ordem_categorias($id_pai)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_categorias_ordem . " WHERE id_pai='$id_pai' order by id desc limit 1");
		return $exec->fetch_object()->data;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function carrega_categoria($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_categorias . " WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_ordem_categoria($id_pai)
	{
		$db = new mysql();
		$db->apagar($this->tab_categorias_ordem, " id_pai='$id_pai' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_ordem_categoria($ordem, $id_pai)
	{
		$db = new mysql();
		$db->inserir($this->tab_categorias_ordem, array(
			"id_pai" => "$id_pai",
			"data" => "$ordem"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 

	public function adiciona_categoria($vars)
	{

		$db = new mysql();
		$db->inserir($this->tab_categorias, array(
			"id_pai"	=> '0',
			"codigo"	=> $vars[0],
			"titulo"	=> $vars[1]
		));
		$ultid = $db->ultimo_id();
		return $ultid;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function alterar_categoria($titulo, $cor_texto, $cor_fundo, $codigo)
	{

		$db = new mysql();
		$db->alterar($this->tab_categorias, array(
			"titulo"	=> $titulo,
			"cor_texto"	=> $cor_texto,
			"cor_fundo"	=> $cor_fundo,
		), " codigo='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_categoria($codigo)
	{

		$db = new mysql();
		$db->apagar($this->tab_categorias,  " codigo='$codigo' ");
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 

	public function adiciona_canal($nome)
	{

		$db = new mysql();
		$db->inserir($this->tab_canal, array(
			"nm_canal"	=> $nome,
			"status" => 1
		));
		$ultid = $db->ultimo_id();
		return $ultid;
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function alterar_canal($titulo, $codigo, $bio, $email)
	{

		$db = new mysql();
		$db->alterar($this->tab_canal, array(
			"nm_canal" => $titulo,
			"email" => $email,
			"bio" => $bio
		), " id_canal ='$codigo' ");
	}
	public function alterar_canal_profile($titulo, $codigo, $profile)
	{

		$db = new mysql();

		$db->alterar($this->tab_canal, array(
			"nm_canal" => $titulo,
			"profile" => $profile
		), " id_canal ='$codigo' ");
	}
	public function alterar_canal_banner($titulo, $codigo, $banner)
	{

		$db = new mysql();

		$db->alterar($this->tab_canal, array(
			"nm_canal" => $titulo,
			"banner" => $banner
		), " id_canal ='$codigo' ");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_canal($codigo)
	{

		$db = new mysql();
		$db->apagar($this->tab_canal,  " id_canal ='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function carrega_canal($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_canal . " WHERE id_canal='$codigo' ");
		return $exec->fetch_object();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// TAMANHOS

	public function lista_tamanhos($codigo = null)
	{  // o codigo é do produto

		$lista = array();

		$valores = new model_valores();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_tamanhos . " order by titulo asc");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$exec2 = new mysql();
			$confere = $exec2->Executar("SELECT id, valor FROM " . $this->tab_tamanhos_sel . " WHERE tamanho_codigo='$data->codigo' AND produto_codigo='$codigo' ");
			$data_confere = $confere->fetch_object();

			if (isset($data_confere->id)) {
				$lista[$i]['check_prod'] = true;
				$lista[$i]['valor'] = $valores->trata_valor($data_confere->valor);
			} else {
				$lista[$i]['check_prod'] = false;
				$lista[$i]['valor'] = "0,00";
			}

			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_tamanho($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_tamanhos . " where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_tamanho($vars)
	{

		$dados = array(
			'codigo' => $vars[0],
			'titulo' => $vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_tamanhos, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_tamanho($vars, $codigo)
	{

		$dados = array(
			'titulo'	=> $vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_tamanhos, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_tamanho($codigo)
	{

		// executa
		$db = new mysql();
		$db->apagar($this->tab_tamanhos, " codigo='$codigo' ");
	}



	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MARCAS

	public function lista_marcas($codigo = null)
	{  // o codigo é do produto

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_marcas . " order by titulo asc");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			if ($codigo == $data->codigo) {
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}

			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_marca($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_marcas . " where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_marca($vars)
	{

		$dados = array(
			'codigo' => $vars[0],
			'titulo' => $vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_marcas, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_marca($vars, $codigo)
	{

		$dados = array(
			'titulo'	=> $vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_marcas, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_marca($codigo)
	{

		// executa
		$db = new mysql();
		$db->apagar($this->tab_marcas, " codigo='$codigo' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CORES

	public function lista_cores($codigo = null)
	{  // o codigo é do produto

		$lista = array();

		$valores = new model_valores();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_cores . " order by titulo asc");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$exec2 = new mysql();
			$confere = $exec2->Executar("SELECT id, valor FROM " . $this->tab_cores_sel . " WHERE cor_codigo='$data->codigo' AND produto_codigo='$codigo' ");
			$data_confere = $confere->fetch_object();

			if (isset($data_confere->id)) {
				$lista[$i]['check_prod'] = true;
				$lista[$i]['valor'] = $valores->trata_valor($data_confere->valor);
			} else {
				$lista[$i]['check_prod'] = false;
				$lista[$i]['valor'] = "0,00";
			}

			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_cor($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_cores . " where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_cor($vars)
	{

		$dados = array(
			'codigo' => $vars[0],
			'titulo' => $vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_cores, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_cor($vars, $codigo)
	{

		$dados = array(
			'titulo'	=> $vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_cores, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_cor($codigo)
	{

		// executa
		$db = new mysql();
		$db->apagar($this->tab_cores, " codigo='$codigo' ");
	}




	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// VARIAÇÕES

	public function lista_variacoes($codigo = null)
	{ // o codigo é do produto

		$lista = array();

		$valores = new model_valores();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_variacoes . " order by titulo asc");
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$exec2 = new mysql();
			$confere = $exec2->Executar("SELECT id, valor FROM " . $this->tab_variacoes_sel . " WHERE variacao_codigo='$data->codigo' AND produto_codigo='$codigo' ");
			$data_confere = $confere->fetch_object();

			if (isset($data_confere->id)) {
				$lista[$i]['check_prod'] = true;
				$lista[$i]['valor'] = $valores->trata_valor($data_confere->valor);
			} else {
				$lista[$i]['check_prod'] = false;
				$lista[$i]['valor'] = "0,00";
			}

			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_variacao($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_variacoes . " where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_variacao($vars)
	{

		$dados = array(
			'codigo' => $vars[0],
			'titulo' => $vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_variacoes, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_variacao($vars, $codigo)
	{

		$dados = array(
			'titulo'	=> $vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_variacoes, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_variacao($codigo)
	{

		// executa
		$db = new mysql();
		$db->apagar($this->tab_variacoes, " codigo='$codigo' ");
	}





	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ESTOQUE

	public function listar_estoque($produto = null)
	{

		$lista = array();
		$i = 0;

		$db = new mysql();
		if (!$produto) {
			$exec = $db->executar("SELECT * FROM " . $this->tab_estoque . " order by produto asc");
		} else {
			$exec = $db->executar("SELECT * FROM " . $this->tab_estoque . " where produto='$produto' order by produto asc");
		}

		while ($data = $exec->fetch_object()) {

			$produto = $this->carrega_produto($data->produto);

			if ($produto) {

				$lista[$i]['id'] = $data->id;
				$lista[$i]['registro'] = $data->registro;
				$lista[$i]['produto'] = $data->produto;
				$lista[$i]['produto_titulo'] = $produto->titulo;
				$lista[$i]['produto_ref'] = $produto->ref;

				if (($data->tamanho) and ($data->tamanho != '-')) {
					$tamanho = $this->carrega_tamanho($data->tamanho);
					$lista[$i]['tamanho_titulo'] = $tamanho->titulo;
					$lista[$i]['tamanho'] = $data->tamanho;
				} else {
					$lista[$i]['tamanho_titulo'] = "-";
					$lista[$i]['tamanho'] = "-";
				}

				if (($data->cor) and ($data->cor != '-')) {
					$cor = $this->carrega_cor($data->cor);
					$lista[$i]['cor_titulo'] = $cor->titulo;
					$lista[$i]['cor'] = $data->cor;
				} else {
					$lista[$i]['cor_titulo'] = "-";
					$lista[$i]['cor'] = "-";
				}

				if (($data->variacao) and ($data->variacao != '-')) {
					$variacao = $this->carrega_variacao($data->variacao);
					$lista[$i]['variacao_titulo'] = $variacao->titulo;
					$lista[$i]['variacao'] = $data->variacao;
				} else {
					$lista[$i]['variacao_titulo'] = "-";
					$lista[$i]['variacao'] = "-";
				}

				$lista[$i]['quantidade'] = $data->quantidade;

				$i++;
			}
		}
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function estoque_extrato($registro)
	{

		$lista = array();
		$i = 0;

		if ($registro) {

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM " . $this->tab_estoque_registro . " where registro='$registro' order by data desc");
			while ($data = $exec->fetch_object()) {

				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['quant_anterior'] = $data->quant_anterior;
				$lista[$i]['quant_final'] = $data->quant_final;
				$lista[$i]['descricao'] = $data->descricao;

				$i++;
			}
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function estoque_quantidade($produto, $tamanho, $cor, $variacao)
	{

		$db = new mysql();
		$exec = $db->executar("SELECT quantidade FROM " . $this->tab_estoque . " where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$data = $exec->fetch_object();

		if (isset($data->quantidade)) {
			return $data->quantidade;
		} else {
			return 0;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_estoque($produto, $tamanho, $cor, $variacao, $quantidade)
	{

		$db = new mysql();
		$exec = $db->executar("SELECT id, registro, quantidade FROM " . $this->tab_estoque . " where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$linhas = $exec->num_rows;

		if ($linhas != 0) {

			$data = $exec->fetch_object();
			$quant_anterior = $data->quantidade;
			$registro = $data->registro;

			if ($quantidade == $data->quantidade) {
				$quant = 0;
				$descricao = "Registro Manual - Sem alterações";
			} else {
				if ($quantidade > $data->quantidade) {
					$quant = $quantidade - $data->quantidade;
					$descricao = "Registro Manual - Adicionado $quant item(s)";
				} else {
					$quant = $data->quantidade - $quantidade;
					$descricao = "Registro Manual - Removido $quant item(s)";
				}
			}

			$db = new mysql();
			$db->alterar($this->tab_estoque, array(
				"quantidade" => "$quantidade"
			), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		} else {

			$registro = substr(time() . rand(10000, 99999), -15);

			$quant_anterior = 0;
			$quant = $quantidade;
			$descricao = "Registro Manual - Adicionado $quant item(s)";

			$db = new mysql();
			$db->inserir($this->tab_estoque, array(
				"registro" => "$registro",
				"produto" => "$produto",
				"tamanho" => "$tamanho",
				"cor" => "$cor",
				"variacao" => "$variacao",
				"quantidade" => "$quantidade"
			));
		}

		$time = time();

		// registra alteracao
		$db = new mysql();
		$db->inserir($this->tab_estoque_registro, array(
			"registro" => "$registro",
			"data" => "$time",
			"quant" => "$quant",
			"quant_anterior" => "$quant_anterior",
			"quant_final" => "$quantidade",
			"descricao" => "$descricao"
		));
	}

	public function add_estoque_auto($produto, $tamanho, $cor, $variacao, $quant, $descricao)
	{

		$db = new mysql();
		$exec = $db->executar("SELECT id, registro, quantidade FROM " . $this->tab_estoque . " where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$linhas = $exec->num_rows;

		if ($linhas != 0) {

			$data = $exec->fetch_object();
			$quant_anterior = $data->quantidade;
			$registro = $data->registro;

			$quantidade = $quant_anterior + $quant;

			$db = new mysql();
			$db->alterar($this->tab_estoque, array(
				"quantidade" => "$quantidade"
			), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");

			$time = time();

			// registra alteracao
			$db = new mysql();
			$db->inserir($this->tab_estoque_registro, array(
				"registro" => "$registro",
				"data" => "$time",
				"quant" => "$quant",
				"quant_anterior" => "$quant_anterior",
				"quant_final" => "$quantidade",
				"descricao" => "$descricao"
			));
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ESTOQUE TOTAL POR PRODUTO

	public function estoque_total($codigo)
	{

		$total = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT quantidade FROM " . $this->tab_estoque . " where produto='$codigo' ");
		while ($data = $exec->fetch_object()) {

			$total = $total + $data->quantidade;
		}

		return $total;
	}



	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ENTREGA AUTOMATICA

	public function entrega_auto($produto = null)
	{

		$lista = array();

		$db = new mysql();
		if (!$produto) {
			$exec = $db->executar("SELECT * FROM " . $this->tab_entrega . " order by produto asc");
		} else {
			$exec = $db->executar("SELECT * FROM " . $this->tab_entrega . " where produto='$produto' order by produto asc");
		}
		$i = 0;
		while ($data = $exec->fetch_object()) {

			$produto = $this->carrega_produto($data->produto);

			if ($produto) {

				$lista[$i]['id'] = $data->id;
				$lista[$i]['produto'] = $data->produto;
				$lista[$i]['produto_titulo'] = $produto->titulo;
				$lista[$i]['produto_ref'] = $produto->ref;

				if (($data->tamanho) and ($data->tamanho != '-')) {
					$tamanho = $this->carrega_tamanho($data->tamanho);
					$lista[$i]['tamanho_titulo'] = $tamanho->titulo;
					$lista[$i]['tamanho'] = $data->tamanho;
				} else {
					$lista[$i]['tamanho_titulo'] = "-";
					$lista[$i]['tamanho'] = "-";
				}

				if (($data->cor) and ($data->cor != '-')) {
					$cor = $this->carrega_cor($data->cor);
					$lista[$i]['cor_titulo'] = $cor->titulo;
					$lista[$i]['cor'] = $data->cor;
				} else {
					$lista[$i]['cor_titulo'] = "-";
					$lista[$i]['cor'] = "-";
				}

				if (($data->variacao) and ($data->variacao != '-')) {
					$variacao = $this->carrega_variacao($data->variacao);
					$lista[$i]['variacao_titulo'] = $variacao->titulo;
					$lista[$i]['variacao'] = $data->variacao;
				} else {
					$lista[$i]['variacao_titulo'] = "-";
					$lista[$i]['variacao'] = "-";
				}

				$lista[$i]['texto'] = $data->texto;

				$i++;
			}
		}
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function entrega_auto_texto($produto, $tamanho, $cor, $variacao)
	{

		$db = new mysql();
		$exec = $db->executar("SELECT texto FROM " . $this->tab_entrega . " where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$data = $exec->fetch_object();

		if (isset($data->texto)) {
			return $data->texto;
		} else {
			return '';
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_entrega_texto($produto, $tamanho, $cor, $variacao, $texto)
	{

		$db = new mysql();
		$exec = $db->executar("SELECT id FROM " . $this->tab_entrega . " where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$linhas = $exec->num_rows;

		if ($linhas != 0) {

			$db = new mysql();
			$db->alterar($this->tab_entrega, array(
				"texto" => "$texto"
			), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		} else {

			$db = new mysql();
			$db->inserir($this->tab_entrega, array(
				"produto" => "$produto",
				"tamanho" => "$tamanho",
				"cor" => "$cor",
				"variacao" => "$variacao",
				"texto" => "$texto"
			));
		}
	}


	public function lista_layouts($categoria)
	{  // o codigo é do produto

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_modelos WHERE categoria='$categoria' order by titulo asc");
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['imagem'] = $data->imagem;

			$i++;
		}
		return $lista;
	}

	public function lista_layouts_prod($categoria, $produto)
	{  // o codigo é do produto

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_modelos WHERE categoria='$categoria' order by titulo asc");
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['imagem'] = $data->imagem;

			$exec2 = new mysql();
			$confere = $exec2->Executar("SELECT id FROM produto_modelos_sel WHERE layout_codigo='$data->codigo' AND produto_codigo='$produto' ");
			$data_confere = $confere->fetch_object();

			if (isset($data_confere->id)) {
				$lista[$i]['check_prod'] = true;
			} else {
				$lista[$i]['check_prod'] = false;
			}

			$i++;
		}
		return $lista;
	}

	public function carrega_layout($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_modelos WHERE codigo='$codigo'");
		return $exec->fetch_object();
	}

	public function lista_layout_categoria()
	{  // o codigo é do produto

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_modelos_categorias order by titulo asc");
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$i++;
		}
		return $lista;
	}

	public function carrega_layout_categoria($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_modelos_categorias WHERE codigo='$codigo'");
		return $exec->fetch_object();
	}


	public function acabamentos()
	{

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_acabamentos order by titulo asc");
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$i++;
		}
		return $lista;
	}

	public function carrega_acabamentos($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_acabamentos WHERE codigo='$codigo'");
		return $exec->fetch_object();
	}


	///////////////////////////////////////////////////////////////////////////
	// GRUPOS


	public function lista_grupos()
	{

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_grupos order by titulo asc");
		while ($data = $exec->fetch_object()) {

			$categorias[$i]['id'] = $data->id;
			$categorias[$i]['codigo'] = $data->codigo;
			$categorias[$i]['titulo'] = strip_tags($data->titulo);

			$i++;
		}
		return $categorias;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_grupo($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM produto_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}


	public function gabaritos($produto)
	{

		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_gabaritos . " WHERE produto='$produto' order by titulo asc");
		while ($data = $exec->fetch_object()) {

			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['link'] = $data->link;

			$i++;
		}

		return $lista;
	}

	public function carrega_gabarito($id)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM " . $this->tab_gabaritos . " where id='$id' ");
		return $exec->fetch_object();
	}
}
