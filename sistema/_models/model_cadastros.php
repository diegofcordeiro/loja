<?php

class model_cadastros extends model
{

	public function lista()
	{

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro ");
		$n = 0;
		while ($data = $exec->fetch_object()) {

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['tipo'] = $data->tipo;

			if ($data->tipo == 'F') {
				$lista[$n]['documento'] = $data->fisica_cpf;
				$lista[$n]['nome'] = $data->fisica_nome;
			} else {
				$lista[$n]['documento'] = $data->juridica_cnpj;
				$lista[$n]['nome'] = $data->juridica_razao;
			}

			$lista[$n]['fone'] = $data->telefone;
			$lista[$n]['email'] = $data->email;

			$n++;
		}

		return $lista;
	}

	public function aniversariantes()
	{

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro WHERE tipo='F' AND fisica_nascimento!='0' ");
		$n = 0;
		while ($data = $exec->fetch_object()) {

			if (date('m', $data->fisica_nascimento) == date('m')) {

				$lista[$n]['id'] = $data->id;
				$lista[$n]['codigo'] = $data->codigo;
				$lista[$n]['tipo'] = $data->tipo;
				$lista[$n]['documento'] = $data->fisica_cpf;
				$lista[$n]['nome'] = $data->fisica_nome;

				$lista[$n]['fone'] = $data->telefone;
				$lista[$n]['email'] = $data->email;

				$n++;
			}
		}

		return $lista;
	}

	public function seleciona($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	public function carrega($codigo, $query = null)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro where codigo='$codigo' $query");
		return $exec->fetch_object();
	}

	public function comentarios($codigo)
	{

		$comentarios = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro_comentarios WHERE cadastro='$codigo' order by data desc");
		$n = 0;
		while ($data = $exec->fetch_object()) {

			$db = new mysql();
			$exec_usu = $db->executar("SELECT * FROM adm_usuario WHERE codigo='$data->usuario' ");
			$data_usu = $exec_usu->fetch_object();

			$comentarios[$n]['id'] = $data->id;
			$comentarios[$n]['comentario'] = $data->comentario;
			$comentarios[$n]['usuario'] = $data_usu->nome;
			$comentarios[$n]['data'] = date('d/m/Y H:i', $data->data);

			$n++;
		}

		return $comentarios;
	}


	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_grupos()
	{

		$categorias = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro_grupos order by titulo asc");
		while ($data = $exec->fetch_object()) {

			$categorias[$i]['id'] = $data->id;
			$categorias[$i]['codigo'] = $data->codigo;
			$categorias[$i]['titulo'] = strip_tags($data->titulo);

			$i++;
		}
		return $categorias;
	}

	public function carrega_grupo($codigo)
	{
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro_grupos where codigo='$codigo' ");
		return $exec->fetch_object();
	}
}
