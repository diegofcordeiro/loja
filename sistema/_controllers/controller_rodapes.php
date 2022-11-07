<?php

class rodapes extends controller {
	
	protected $_modulo_nome = "Layout - Rodapés";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(125);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$rodapes = new model_rodapes();
		$dados['lista'] = $rodapes->lista();	
		
		$this->view('layout_rodapes', $dados);
	}

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('layout_rodapes.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("layout_rodapes", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"modelo"=>1
		));

		// adiciona cores
		$rodapes = new model_rodapes();
		$rodapes->adiciona_cores(1, $codigo);

		// layout
		$layout = new model_layout();
		$tipo = "rodape";
		$titulo_pagina = "Rodapé - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}

	public function alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro!');
			$this->volta(1);
			exit;
		}

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_rodapes WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$modelos = new model_rodapes();
		$dados['modelos'] = $modelos->modelos();
		
		$objeto_end = DOMINIO.$this->_controller.'/';
		
		function montaCategorias($id_pai, $rodape_cod, $objeto_end){

			$lista = '';

			$conexao = new mysql();
			$exec = $conexao->Executar("SELECT * FROM layout_menu_rodape_ordem WHERE rodape_codigo='$rodape_cod' AND id_pai='$id_pai' ORDER BY id desc limit 1");
			$data_ordem = $exec->fetch_object();

			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$lista .= '<ol class="dd-list">';

				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM layout_menu_rodape WHERE id='$value' AND rodape_codigo='$rodape_cod' ");
					$data = $coisas->fetch_object();

					if(isset($data->titulo)){

						$lista .= '<li class="dd-item dd3-item" data-id="'.$value.'" >';

						$lista .= '
						<div class="dd-handle dd3-handle" ><i class="far fa-hand-rock"></i></div>
						<div class="dd3-content-editar" onClick="modal(\''.$objeto_end.'menu_alterar/codigo/'.$data->codigo.'/rodape/'.$rodape_cod.'\', \'Alterar Menu\');" ><i class="far fa-edit"></i></div>						 
						<div class="dd3-content">'.$data->titulo.'</div>';

						$lista .= montaCategorias($value, $rodape_cod, $objeto_end);

						$lista .= '</li>';

					}
				}

				$lista .= '</ol>';
			}
			return $lista;
		}
		$lista = montaCategorias(0, $codigo, $objeto_end);		
		$dados['listamenu'] = $lista;
		

		// cores
		$cores = array();
		$n = 0;
		$db = new mysql();
		$exec_cores = $db->executar("SELECT * FROM layout_rodapes_cores_sel WHERE rodape_codigo='$codigo' AND rodape_modelo='".$dados['data']->modelo."' ");
		while($data_cores = $exec_cores->fetch_object()){

			$cores[$n]['id'] = $data_cores->id;
			$cores[$n]['titulo'] = $data_cores->titulo;
			$cores[$n]['cor'] = $data_cores->cor;

			$n++;
		}	
		$dados['cores'] = $cores;


		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();

		$layout = new model_layout();
		$dados['botoes'] = $layout->lista_botoes();

		$this->view('layout_rodapes.alterar', $dados);
	}

	public function alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$modelo = $this->post('modelo'); 
		$font_codigo = $this->post('font_codigo');

		$email = $this->post('email');
		$sobre_a_empresa = $this->post('sobre_a_empresa');
		$fone1 = $this->post('fone1');
		$fone2 = $this->post('fone2');
		$endereco1 = $this->post('endereco1');
		$endereco2 = $this->post('endereco2');
		$mostrar_aviso = $this->post('mostrar_aviso');
		$botao_aviso = $this->post('botao_aviso');
		$copy = $this->post('copy');
		$aviso_conteudo = $this->post_htm('aviso_conteudo');

		$whatsapp = $this->post('whatsapp');
		$whatsapp = str_replace(array("(", ")", " ", "-", ".", " "), "", $whatsapp);

		$mostrar_whats = $this->post('mostrar_whats');

		$this->valida($codigo);
		$this->valida($modelo);
		$this->valida($titulo);
		$this->valida($font_codigo); 
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_fontes WHERE codigo='$font_codigo' ");
		$data_fonte = $exec->fetch_object();
		$font_family = addslashes($data_fonte->family);
		
		$db = new mysql();
		$db->alterar("layout_rodapes", array(
			"titulo"=>$titulo,
			"modelo"=>$modelo,
			"font_codigo"=>$font_codigo,
			"font_family"=>$font_family,
			"email"=>$email,
			"fone1"=>$fone1,
			"fone2"=>$fone2,
			"sobre_a_empresa"=>$sobre_a_empresa,
			"endereco1"=>$endereco1,
			"endereco2"=>$endereco2,
			"copy"=>$copy,
			"mostrar_aviso"=>$mostrar_aviso,
			"botao_aviso"=>$botao_aviso,
			"aviso_conteudo"=>$aviso_conteudo,
			"whatsapp"=>$whatsapp,
			"mostrar_whats"=>$mostrar_whats
		), " codigo='$codigo' ");
			
		// adiciona cores
		$rodapes = new model_rodapes();
		$rodapes->adiciona_cores($modelo, $codigo);	

		// layout
		$layout = new model_layout();
		$titulo_pagina = "Rodapé - $titulo";
		$layout->altera_paginas($codigo, $titulo_pagina);


		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function alterar_cores_grv(){

		$codigo = $this->post('codigo');
		$modelo = $this->post('modelo');

		$this->valida($codigo);
		$this->valida($modelo);

		$db = new mysql();
		$exec_cores = $db->executar("SELECT * FROM layout_rodapes_cores_sel WHERE rodape_codigo='$codigo' AND rodape_modelo='".$modelo."' ");
		while($data_cores = $exec_cores->fetch_object()){

			$cor = $this->post_htm('cor_'.$data_cores->id);
			if($cor){
				$db = new mysql();
				$db->alterar("layout_rodapes_cores_sel", array(
					"cor"=>$cor
				), " id='$data_cores->id' ");
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/cores');		
	}


	public function imagem_fundo(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		
		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_rodape/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					//redimenciona					
					$arquivo->jpg($diretorio.$nome_arquivo, 2500 , 2500, $diretorio.$nome_arquivo);
					
				}
				

				$db = new mysql();
				$db->alterar("layout_rodapes", array(
					"imagem_fundo"=>$nome_arquivo
				), " codigo='$codigo' ");

				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem_fundo');
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem_fundo");
				
			}

		}

	}


	public function imagem_fundo_apagar(){
		
		$codigo = $this->get('codigo');
		
		if($codigo){


			$db = new mysql();
			$exec = $db->executar("SELECT * FROM layout_rodapes WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem_fundo){
				unlink('../arquivos/img_rodape/'.$data->imagem_fundo);
			}

			$db = new mysql();
			$db->alterar("layout_rodapes", array(
				"imagem_fundo"=>''
			), " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem_fundo');
	}


	public function apagar_rodape(){

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Item inválido');
			$this->volta(1);
			exit;
		}

		$conexao = new mysql();
		$conexao->apagar("layout_rodapes", " codigo='$codigo' ");

		$conexao = new mysql();
		$conexao->apagar("layout_menu_rodape", " rodape_codigo='$codigo' ");

		$conexao = new mysql();
		$conexao->apagar("layout_menu_rodape_ordem", " rodape_codigo='$codigo' ");

		$conexao = new mysql();
		$conexao->apagar("layout_rodapes_cores_sel", " rodape_codigo='$codigo' "); 

 		// layout
		$layout = new model_layout(); 
		$layout->apagar_pagina($codigo);

		$this->irpara(DOMINIO.$this->_controller.'/inicial');
	}



	public function menu_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$codigo = $this->get('codigo');
		if(!$codigo){
			echo "erro!";
			exit;
		}
		$dados['codigo_rodape'] = $codigo;

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

		$this->view('layout_rodapes.menu.novo', $dados);
	}

	public function menu_novo_grv(){

		$rodape_codigo = $this->post('rodape_codigo');
		$titulo = $this->post('titulo'); 
		$destino = $this->post_htm('destino');

		$this->valida($titulo);
		$this->valida($rodape_codigo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("layout_menu_rodape", array(
			"rodape_codigo"=>"$rodape_codigo",
			"codigo"=>"$codigo",			 
			"titulo"=>"$titulo",
			"endereco"=>"$destino"
		));

		$ultid = $db->ultimo_id();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM layout_menu_rodape_ordem where id_pai='0' AND rodape_codigo='$rodape_codigo' order by id desc limit 1");
		$data = $coisas->fetch_object();

		if(isset($data->data)){
			$novaordem = $data->data.",".$ultid;
		} else {
			$novaordem = $ultid;
		}

		$db = new mysql();
		$db->apagar("layout_menu_rodape_ordem", " rodape_codigo='$rodape_codigo' AND id_pai='0' ");

		$db = new mysql();
		$db->inserir("layout_menu_rodape_ordem", array(
			"rodape_codigo"=>"$rodape_codigo",
			"id_pai"=>"0",
			"data"=>"$novaordem"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$rodape_codigo.'/aba/menu');
	}

	public function menu_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$codigo_rodape = $this->get('rodape');
		$codigo = $this->get('codigo');

		if(!$codigo_rodape){
			echo "Erro!";
			exit;
		}
		if(!$codigo){
			echo "Erro!";
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_menu_rodape WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

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

		$this->view('layout_rodapes.menu.alterar', $dados);
	}

	public function menu_alterar_grv(){

		$dados['_base'] = $this->base();

		$rodape_codigo = $this->post('rodape_codigo');
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo'); 
		$destino = $this->post_htm('destino');
		$visivel = $this->post('visivel');

		$this->valida($rodape_codigo);
		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("layout_menu_rodape", array(
			"titulo"=>"$titulo", 
			"endereco"=>"$destino",
			"visivel"=>"$visivel"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$rodape_codigo.'/aba/menu');
	}

	public function menu_apagar(){

		$rodape_codigo = $this->get('rodape_codigo');
		$codigo = $this->get('codigo');

		$this->valida($rodape_codigo);
		$this->valida($codigo);

		function remove_menu_e_filhos($rodape_codigo, $codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM layout_menu_rodape WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			// descobre o idpai

			$processo = 0;
			$db = new mysql();
			$exec_ordem = $db->executar("SELECT * FROM layout_menu_rodape_ordem WHERE rodape_codigo='$rodape_codigo' ");
			while($data_ordem = $exec_ordem->fetch_object()){
				if($processo == 0){
					$achou = 0;
					$explode = explode(',', $data_ordem->data);
					foreach ($explode as $key => $value) {
						if($data->id == $value){
							$achou = 1;
						}
					}
					if($achou == 1){
						$novaordem = "";
						$id_pai = $data_ordem->id_pai;
						foreach ($explode as $key_ordem => $value_ordem) {
							if($value_ordem != $data->id){
								$novaordem .= $value_ordem.",";
							}
						}
						$novaordem = substr($novaordem, 0, strlen($novaordem)-1);
						$processo = 1;
					}
				}
			}

			// verifica se tem filhos

			$db = new mysql();
			$exec_filhos = $db->executar("SELECT * FROM layout_menu_rodape_ordem WHERE id_pai='$data->id' ");
			if($exec_filhos->num_rows != 0){

				$data_filhos = $exec_filhos->fetch_object();

				$explode_filhos = explode(',', $data_filhos->data);
				foreach ($explode_filhos as $key_filhos => $value_filhos) {

					$db = new mysql();
					$exec_filho2 = $db->executar("SELECT codigo FROM layout_menu_rodape WHERE id='$value_filhos' ");
					$data_filho2 = $exec_filho2->fetch_object();

					if($data_filho2->codigo){
						remove_menu_e_filhos($rodape_codigo, $data_filho2->codigo);
					}
				}
			}

			// altera ordem
			$db = new mysql();
			$db->apagar("layout_menu_rodape_ordem", " rodape_codigo='$rodape_codigo' AND id_pai='$id_pai' ");

			if($novaordem){
				$db = new mysql();
				$db->inserir("layout_menu_rodape_ordem", array(
					"rodape_codigo"=>"$rodape_codigo",
					"id_pai"=>"$id_pai",
					"data"=>"$novaordem"
				));
			}

			// remove 
			$db = new mysql();
			$db->apagar("layout_menu_rodape", " codigo='$codigo' ");

		}
		remove_menu_e_filhos($rodape_codigo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$rodape_codigo.'/aba/menu');
	}

	public function menu_salvar_ordem(){

		$rodape_codigo = $this->post('rodape_codigo');	
		$ordem = stripcslashes($_POST['ordem']);

		if($ordem AND $rodape_codigo){

			$json = json_decode($ordem, true);

			function converte_array_para_banco($jsonArray, $rodape, $id_pai = 0) {

				$lista = "";

				foreach ($jsonArray as $subArray) {

					$lista .= $subArray['id'].",";

					if (isset($subArray['children'])) {
						converte_array_para_banco($subArray['children'], $rodape, $subArray['id']);
					} else {
						$pai_remover = $subArray['id'];
						$db = new mysql();
						$db->apagar("layout_menu_rodape_ordem", "  rodape_codigo='$rodape' AND id_pai='$pai_remover' ");
					}

				}

				$novaordem = substr($lista,0,-1);

				$db = new mysql();
				$db->apagar("layout_menu_rodape_ordem", "  rodape_codigo='$rodape' AND id_pai='$id_pai' ");

				$db = new mysql();
				$db->inserir("layout_menu_rodape_ordem", array(
					"rodape_codigo"=>"$rodape",
					"id_pai"=>"$id_pai",
					"data"=>"$novaordem"
				));

			}
			converte_array_para_banco($json, $rodape_codigo, 0);

			$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$rodape_codigo.'/aba/menu');

		} else {
			$this->msg('Ocorreu um erro ao carregar ordem!');
			$this->volta(1);
		}

	}

	public function menu_imagem(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$codigo = $this->get('codigo');
		$rodape_codigo = $this->get('rodape');

		if(!$codigo){
			echo "Iten inválido!";
			exit;
		}
		if(!$rodape_codigo){
			echo "Iten inválido!";
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_menu_rodape WHERE codigo='$codigo' AND rodape_codigo='$rodape_codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('layout_rodapes.menu.imagem', $dados);
	}

	public function menu_imagem_grv(){

		$codigo = $this->post('codigo');
		$rodape_codigo = $this->post('rodape_codigo');

		$this->valida($codigo);
		$this->valida($rodape_codigo);

		// carrega model
		$arquivos_imagens = new model_arquivos_imagens();

		if(!$arquivos_imagens->filtro($_FILES['arquivo'])){

			$this->msg('Arquivo com formato inválido ou inexistente!');
			$this->volta(1);

		} else {

			$arquivo_original = $_FILES['arquivo'];
			$tmp_name = $_FILES['arquivo']['tmp_name'];

			//// Definicao de Diretorios / 
			$diretorio = "../arquivos/imagens/";

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivos_imagens->extensao($nome_original);
			$nome_arquivo = $arquivos_imagens->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				$db = new mysql();
				$db->alterar("layout_menu_rodape", array(
					"imagem"=>$nome_arquivo
				), " codigo='$codigo' AND rodape_codigo='$rodape_codigo' ");

				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$rodape_codigo.'/aba/menu');

			} else {

				$this->msg('Não foi possível copiar o arquivo!');
				$this->volta(1);

			}
		}
	}

	public function menu_imagem_apagar(){

		$codigo = $this->get('codigo');
		$rodape_codigo = $this->get('rodape_codigo');

		$this->valida($codigo);
		$this->valida($rodape_codigo);

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_menu_rodape WHERE codigo='$codigo' AND rodape_codigo='$rodape_codigo' ");
		$data = $exec->fetch_object();

		if($data->imagem){
			unlink('../arquivos/imagens/'.$data->imagem);
		}

		$db = new mysql();
		$db->alterar("layout_menu_rodape", array(
			"imagem"=>""
		), " codigo='$codigo' AND rodape_codigo='$rodape_codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$rodape_codigo.'/aba/menu');
	}

}