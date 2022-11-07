<?php

class layout extends controller {
	
	protected $_modulo_nome = "Layout";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(80);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$lista = array();
		$n = 0;
		
		$site = str_replace("/sistema", "", DOMINIO);
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_paginas ORDER BY id asc");
		while($data = $exec->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['url'] = $site.$data->chave;
			$lista[$n]['chave'] = $data->chave;
			$lista[$n]['status'] = $data->status;

			$n++;
		}
		$dados['lista'] = $lista;
		
		$this->view('layout', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$this->view('layout.paginas.nova', $dados);
	}	
	
	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$chave = $this->post('chave');
		
		$this->valida($titulo);
		$this->valida($chave);
		
		$chave = str_replace(" ", "", $chave);
		$chave = str_replace("/", "", $chave);
		$chave = str_replace("$", "", $chave);
		$chave = str_replace("&", "", $chave);

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' ");
		if($exec->num_rows != 0){
			$this->msg('Este endereço já foi utilizado!');
			$this->volta(1);
		}
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("layout_paginas", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"chave"=>"$chave",
			"status"=>"0"
		));

		// cores
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM layout_cores order by id asc ");
		while($data = $exec->fetch_object()){
			
			$db = new mysql();
			$db->inserir("layout_cores_sel", array(
				"codigo"=>$data->id,
				"titulo"=>$data->titulo,
				"pagina"=>$codigo,
				"cor"=>$data->cor
			));
			
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial');
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$codigo = $this->get('codigo');
		
		if(!$codigo){
			$this->msg('Página ínválida');
			$this->volta(1);
			exit;
		}
		
		if($this->get('aba')){
			$dados['aba_selecionada'] = $this->get('aba');
		} else {
			$dados['aba_selecionada'] = 'dados';
		}
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_paginas WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		
		$listacores = array();
		$n_cores = 0;
		
		$db = new mysql();
		$exec_cores = $db->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo' order by id asc ");
		while($data_cores = $exec_cores->fetch_object()){
			
			$listacores[$n_cores]['id'] = $data_cores->id;
			$listacores[$n_cores]['codigo'] = $data_cores->codigo;
			$listacores[$n_cores]['titulo'] = $data_cores->titulo;
			$listacores[$n_cores]['cor'] = $data_cores->cor;

			$n_cores++;
		}

		$dados['listacores'] = $listacores;
		

		$lista = array();
		$n = 0;

		$db = new mysql();
		$exec_blocos_ord = $db->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$codigo' order by id desc limit 1");
		$data_blocos_ord = $exec_blocos_ord->fetch_object();
		
		if(isset($data_blocos_ord->data)){

			$ordem = explode(',', $data_blocos_ord->data);
			foreach ($ordem as $key => $value) {

				$db = new mysql();
				$exec_blocos = $db->Executar("SELECT * FROM layout_blocos WHERE id='".$value."' ");
				$data_blocos = $exec_blocos->fetch_object();

				if(isset($data_blocos->id)){

					$lista[$n]['id'] = $data_blocos->id;
					$lista[$n]['codigo'] = $data_blocos->codigo;
					$lista[$n]['colunas'] = $data_blocos->colunas;
					$lista[$n]['formato'] = $data_blocos->formato;

					if($data_blocos->coluna1){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna1."' ");
						$data_item = $exec_item->fetch_object();
						if(isset($data_item->titulo)){
							$lista[$n]['coluna1'] = $data_item->titulo;
						} else {
							$lista[$n]['coluna1'] = "Indisponível";
						}
					} else {
						$lista[$n]['coluna1'] = "Nenhum";
					}

					if($data_blocos->coluna2){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna2."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna2'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna2'] = "Nenhum";
					}

					if($data_blocos->coluna3){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna3."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna3'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna3'] = "Nenhum";
					}

					if($data_blocos->coluna4){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna4."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna4'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna4'] = "Nenhum";
					}

					if($data_blocos->coluna5){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna5."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna5'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna5'] = "Nenhum";
					}

					if($data_blocos->coluna6){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna6."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna6'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna6'] = "Nenhum";
					}

					if($data_blocos->coluna7){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna7."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna7'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna7'] = "Nenhum";
					}

					if($data_blocos->coluna8){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna8."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna8'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna8'] = "Nenhum";
					}

					if($data_blocos->coluna9){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna9."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna9'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna9'] = "Nenhum";
					}

					if($data_blocos->coluna10){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna10."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna10'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna10'] = "Nenhum";
					}

					if($data_blocos->coluna11){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna11."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna11'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna11'] = "Nenhum";
					}

					if($data_blocos->coluna12){
						$db = new mysql();
						$exec_item = $db->Executar("SELECT titulo FROM layout_itens WHERE codigo='".$data_blocos->coluna12."' ");
						$data_item = $exec_item->fetch_object();
						$lista[$n]['coluna12'] = $data_item->titulo;
					} else {
						$lista[$n]['coluna12'] = "Nenhum";
					}

					$n++;
				}
			}
		}
		$dados['blocos'] = $lista;


		$bloco_selecionado = $this->get('bloco');
		$dados['bloco_selecionado'] = $bloco_selecionado;


		$this->view('layout.paginas.alterar', $dados);
	}

	public function alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$chave = $this->post('chave');
		$bloqueio = $this->post('bloqueio');
		$status = $this->post('status'); 

		$meta_titulo = $this->post('meta_titulo');
		$meta_descricao = $this->post('meta_descricao');		 

		$this->valida($codigo);
		$this->valida($chave);
		$this->valida($titulo);

		$chave = str_replace(" ", "", $chave);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_paginas WHERE codigo='$codigo' ");
		$data = $exec->fetch_object();

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM layout_paginas WHERE chave='$chave' AND codigo!='$codigo' ");
		if($exec->num_rows != 0){
			$this->msg('Este endereço já foi utilizado!');
			$this->volta(1);
			exit();
		}

		$db = new mysql();
		$db->alterar("layout_paginas", array(
			"titulo"=>"$titulo",
			"chave"=>"$chave",
			"bloqueio"=>"$bloqueio",
			"meta_titulo"=>"$meta_titulo",
			"meta_descricao"=>"$meta_descricao",
			"status"=>"$status"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}

	public function alterar_itens_grv(){

		$pagina = $this->post('pagina');
		$item = $this->post('item');

		if($pagina AND $item){

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM layout_itens WHERE pagina='$pagina' AND id='$item' ");
			$data = $exec->fetch_object();

			if($data->ativo == 0){

				$conexao = new mysql();
				$conexao->alterar("layout_itens", array(
					"ativo"=>1
				), " id='".$item."' AND pagina='".$pagina."' ");

			} else {

				$conexao = new mysql();
				$conexao->alterar("layout_itens", array(
					"ativo"=>0
				), " id='".$item."' AND pagina='".$pagina."' ");

			}

		}
	}

	public function apagar_pagina(){

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Página inválida');
			$this->volta();
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_paginas WHERE codigo='$codigo' ");
		$data = $exec->fetch_object();

		$conexao = new mysql();
		$conexao->apagar("layout_blocos", " pagina='$codigo' ");

		$conexao = new mysql();
		$conexao->apagar("layout_cores_sel", " pagina='$codigo' ");

		$conexao = new mysql();
		$conexao->apagar("layout_paginas", " codigo='$codigo' ");

		$conexao = new mysql();
		$conexao->apagar("layout_blocos_ordem", " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/inicial');
	}

	public function salvar_ordem(){

		$list = $_POST['list'];
		$codigo = $this->post('codigo');

		if($codigo AND $list){

			$output = array();
			parse_str($list, $output);
			$ordem = implode(',', $output['item']);

			$db = new mysql();
			$db->apagar("layout_blocos_ordem", " codigo='$codigo' ");

			$db = new mysql();
			$db->inserir('layout_blocos_ordem', array(
				"pagina"=>$codigo,
				"data"=>"$ordem"
			));
		}		
	}

	public function cores_grv(){

		$codigo = $this->post('pagina');

		if(!$codigo){
			$this->msg('Página inválida!');
			$this->volta(1);
		}


		$conexao = new mysql();
		$coisas_cores = $conexao->Executar("SELECT * FROM layout_cores order by id asc ");
		while($data_cores = $coisas_cores->fetch_object()){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM layout_cores_sel WHERE pagina='$codigo' AND codigo='$data_cores->id' ");
			if($coisas->num_rows == 0){

				$db = new mysql();
				$db->inserir("layout_cores_sel", array(
					"codigo"=>$data_cores->id,
					"titulo"=>$data_cores->titulo,
					"pagina"=>$codigo,
					"cor"=>$data_cores->cor
				));

			} else {

				if($_POST['cor_'.$data_cores->id]){

					$cor = $_POST['cor_'.$data_cores->id]; 

					$conexao = new mysql();
					$conexao->alterar("layout_cores_sel", array(
						"cor"=>"$cor"
					), " pagina='$codigo' AND codigo='$data_cores->id' ");
				}

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/cores');
	}

	function definir_pg_inicial(){

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Página inválida!');
			$this->volta(1);
		}

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_paginas WHERE chave='index'");
		$data = $exec->fetch_object();
		if($data->codigo){

			$atual = $data->codigo;

			$conexao = new mysql();
			$conexao->alterar("layout_paginas", array(
				"chave"=>"$atual"
			), " codigo='$atual' ");

			$conexao = new mysql();
			$conexao->alterar("layout_paginas", array(
				"chave"=>"index"
			), " codigo='$codigo' ");

			$this->irpara(DOMINIO.$this->_controller);

		} else {
			echo "Ocorreu um erro";
			$this->volta(1);
		}

	}


	public function blocos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Página ínválida');
			$this->volta(1);
			exit;
		}
		$dados['pagina'] = $codigo;


		$this->view('layout_blocos.novo', $dados);
	}


	public function blocos_novo_grv(){

		$dados['_base'] = $this->base();

		$pagina = $this->post('pagina');
		$colunas = $this->post('colunas');

		if($pagina AND $colunas){

			$codigo = $this->gera_codigo();

			$db = new mysql();
			$db->inserir('layout_blocos', array(
				"codigo"=>$codigo,
				"pagina"=>$pagina,
				"colunas"=>$colunas
			));
			$ultid = $db->ultimo_id();

			$conexao = new mysql();
			$exec = $conexao->Executar("SELECT * FROM layout_blocos_ordem WHERE pagina='$pagina'");
			$data = $exec->fetch_object();

			if(isset($data->data)){
				$novaordem = $data->data.",".$ultid;
			} else {
				$novaordem = $ultid;
			}

			$db = new mysql();
			$db->apagar("layout_blocos_ordem", " pagina='$pagina' ");

			$db = new mysql();
			$db->inserir('layout_blocos_ordem', array(
				"pagina"=>$pagina,
				"data"=>$novaordem
			));

			$this->irpara(DOMINIO.'layout/alterar/codigo/'.$pagina.'/bloco/'.$codigo);

		} else {
			$this->msg('Preencha todos os campos!');
			$this->volta(1);
		}

	}


	public function blocos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$codigo = $this->get('codigo');

		if(!$codigo){
			echo "Bloco inválido!";
			exit;
		}

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_blocos WHERE codigo='$codigo' order by id asc ");
		$dados['data'] = $coisas->fetch_object();


		$layout = new model_layout();
		$itens = $layout->lista_itens(1);

		$modulositens = array();
		$n = 0;
		foreach ($itens as $key => $value) {
			if($value['tipo'] != 'bloco'){
				$modulositens[$n]['codigo'] = $value['codigo'];
				$modulositens[$n]['titulo'] = $value['titulo'];

				$n++;
			}
		}
		$dados['modulos_itens'] = $modulositens;


		$this->view('layout_blocos.alterar', $dados);
	}


	public function blocos_alterar_grv(){

		$codigo = $this->post('codigo');
		$pagina = $this->post('pagina'); 
		$full = $this->post('full');
		$formato = $this->post('formato');

		$cor_fundo = $this->post_htm('cor_fundo');

		$coluna1 = $this->post('coluna1');
		$coluna2 = $this->post('coluna2');
		$coluna3 = $this->post('coluna3');
		$coluna4 = $this->post('coluna4');
		$coluna5 = $this->post('coluna5');
		$coluna6 = $this->post('coluna6');

		$this->valida($codigo);

		$tmp_name = $_FILES['arquivo']['tmp_name'];

		if(isset($tmp_name)){

			$arquivo_original = $_FILES['arquivo'];

			$arquivo = new model_arquivos_imagens();
			
			$diretorio = "../arquivos/imagens/";

			if($arquivo->filtro($arquivo_original)){

				$nome_original = $arquivo_original['name'];
				$extensao = $arquivo->extensao($nome_original);
				$nome_arquivo  = $arquivo->trata_nome($nome_original);

				if(copy($tmp_name, $diretorio.$nome_arquivo)){

					$db = new mysql();
					$db->alterar("layout_blocos", array(
						"img_fundo"=>$nome_arquivo
					), " codigo='".$codigo."' ");

				} else {

					$this->msg('Erro ao gravar imagem!');
					$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");

				}

			}

		}

		$db = new mysql();
		$db->alterar("layout_blocos", array(
			"full"=>$full,
			"formato"=>$formato,
			"coluna1"=>$coluna1,
			"coluna2"=>$coluna2,
			"coluna3"=>$coluna3,
			"coluna4"=>$coluna4,
			"coluna5"=>$coluna5,
			"coluna6"=>$coluna6,
			"cor_fundo"=>$cor_fundo
		), " codigo='".$codigo."' ");



		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$pagina.'/aba/conteudos');		
	}

	public function apagar_fundo(){

		$codigo = $this->get('codigo');
		$pagina = $this->get('pagina');

		if(!$codigo){
			$this->msg('Ocorreu um erro!');
			$this->volta(1);
		}

		if(!$pagina){
			$this->msg('Ocorreu um erro!');
			$this->volta(1);
		}

		$conexao = new mysql();	
		$coisas = $conexao->Executar("SELECT * FROM layout_blocos WHERE codigo='$codigo' order by id asc ");
		$data = $coisas->fetch_object();

		if($data->img_fundo){
			unlink('../arquivos/imagens/'.$data->img_fundo);
		}

		$db = new mysql();
		$db->alterar("layout_blocos", array(
			"img_fundo"=>""
		), " codigo='".$codigo."' ");


		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$pagina.'/aba/conteudos');	
	}


	public function blocos_apagar(){

		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');
		$pagina = $this->get('pagina');  

		if($codigo AND $pagina){

			$db = new mysql();
			$db->apagar("layout_blocos", " codigo='".$codigo."' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$pagina.'/aba/conteudos');		
	}


}