<?php

class postagens extends controller {
	
	protected $_modulo_nome = "Postagens";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(27);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		//categoria selecionado
		$categoria = $this->get('categoria');
		$dados['categoria_selecionada'] = $categoria;
		
		//lista categorias
		$postagens = new model_postagens();
		$dados['categorias'] = $postagens->categorias();

		//noticias
		if($categoria){
			$postagens->categoria = $categoria; //itens por pagina
		}
		$postagens->ordem = 'desc';
		$postagens_retorno = $postagens->lista();
		$dados['noticias'] = $postagens_retorno['noticias'];
		
		$this->view('postagens', $dados);
	}
	
	public function nova(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$dados['hora'] = date('H', time());
		$dados['minuto'] = date('i', time());
		$dados['dia'] = date('d', time());
		$dados['mes'] = date('m', time());
		$dados['ano'] = date('Y', time());

		$categoria = $this->get('categoria');
		$dados['categoria'] = $categoria;

 		//lista categorias
		$postagens = new model_postagens();
		$dados['categorias'] = $postagens->categorias($categoria);
		$dados['autores'] = $postagens->autores(); 

		$this->view('postagens.nova', $dados);
	}

	public function nova_grv(){
		
		$titulo = $this->post('titulo');
		$autor = $this->post('autor');
		$previa = $this->post('previa');
		$conteudo = $this->post_htm('conteudo');
		$categoria = $this->post('categoria'); 
		$hora = $this->post('hora');
		$dia = $this->post('dia');
		
		$arraydata = explode("/", $dia);		
		$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." ".$hora.":00";
		$data_final = strtotime($hora_montada);

		$this->valida($titulo);
		$this->valida($categoria);

		$codigo = $this->gera_codigo();

		$amigavel = $this->trata_amigavel($titulo);
		$db = new mysql();
		$coisas = $db->executar("SELECT * FROM noticia WHERE amigavel='$amigavel' ");
		if($coisas->num_rows != 0){
			$amigavel = $amigavel.'_'.time();
		}

		$db = new mysql();
		$db->inserir("noticia", array(
			"codigo"=>"$codigo",
			"categoria"=>"$categoria",
			"data"=>"$data_final",
			"titulo"=>"$titulo",
			"autor"=>"$autor",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo",
			"amigavel"=>"$amigavel"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/imagem/codigo/'.$codigo);
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
		$exec = $db->Executar("SELECT * FROM noticia where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
		$dados['hora'] = date('H', $dados['data']->data);
		$dados['minuto'] = date('i', $dados['data']->data);
		$dados['dia'] = date('d', $dados['data']->data);
		$dados['mes'] = date('m', $dados['data']->data);
		$dados['ano'] = date('Y', $dados['data']->data);
		
 		//categorias
		$postagens = new model_postagens();
		$dados['categorias'] = $postagens->categorias($dados['data']->categoria);
		$dados['autores'] = $postagens->autores($dados['data']->autor);
		$grupos = $postagens->lista_grupos();

		$grupos_marcados = array();
		$n = 0;
		foreach ($grupos as $key => $value) {
			
			$grupos_marcados[$n]['id'] = $value['id'];
			$grupos_marcados[$n]['codigo'] = $value['codigo'];
			$grupos_marcados[$n]['titulo'] = $value['titulo'];

			$db = new mysql();
			$coisas = $db->executar("SELECT * FROM noticia_grupos_sel WHERE noticia='$codigo' AND grupo='".$value['codigo']."' ");
			if($coisas->num_rows != 0){
				$grupos_marcados[$n]['checked'] = true;
			} else {
				$grupos_marcados[$n]['checked'] = false;
			}

			$n++;
		}
		$dados['grupos_marcados'] = $grupos_marcados;

		
 		//imagens
		$imagens = $postagens->imagens($dados['data']->codigo);
		$dados['imagens'] = $imagens['lista'];

		$this->view('postagens.alterar', $dados);
	}

	public function alterar_grv(){

		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$autor = $this->post('autor');
		$previa = $this->post('previa');
		$conteudo = $this->post_htm('conteudo');
		$categoria = $this->post('categoria');		 
		$amigavel = $this->post('amigavel');
		$hora = $this->post('hora');
		$dia = $this->post('dia');

		$arraydata = explode("/", $dia);

		$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." ".$hora.":00";
		$data_final = strtotime($hora_montada);

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($amigavel);
		$this->valida($categoria);

		$db = new mysql();
		$coisas = $db->executar("SELECT * FROM noticia WHERE amigavel='$amigavel' AND codigo!='$codigo' ");
		if($coisas->num_rows != 0){
			$this->msg('Este endereço amigavel esta em uso');
			$this->volta(1);
		}

		$db = new mysql();
		$db->alterar("noticia", array(
			"categoria"=>"$categoria",
			"data"=>"$data_final",
			"titulo"=>"$titulo",
			"autor"=>"$autor",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo",
			"amigavel"=>"$amigavel"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function alterar_destaques(){

		$codigo = $this->post('codigo');

		if($codigo){

			function marcado_desmarcado($grupo, $noticia){
				$db = new mysql();
				$coisas = $db->executar("SELECT * FROM noticia_grupos_sel WHERE noticia='$noticia' AND grupo='$grupo' ");
				if($coisas->num_rows != 0){
					return true;
				} else {
					return false;
				}
			}

			$postagens = new model_postagens();
			$grupos = $postagens->lista_grupos();

			foreach ($grupos as $key => $value) {

				if($this->post('grupo_'.$value['id']) == '1'){
					if(!marcado_desmarcado($value['codigo'], $codigo)){
						// adiciona
						$db = new mysql();
						$db->inserir("noticia_grupos_sel", array(
							"noticia"=>$codigo,
							"grupo"=>$value['codigo']
						));
					}
				} else {
					if(marcado_desmarcado($value['codigo'], $codigo)){
						//remove
						$db = new mysql();
						$db->apagar("noticia_grupos_sel", " noticia='$codigo' AND grupo='".$value['codigo']."' ");
					}
				}

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/destaques');
	}

	public function apagar_imagem(){

		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM noticia_imagem where id='$id' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_postagens_g/'.$codigo.'/'.$data->imagem);
				unlink('../arquivos/img_postagens_p/'.$codigo.'/'.$data->imagem);
			}

			$conexao = new mysql();
			$conexao->apagar("noticia_imagem", " id='$id' ");
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
		$db->inserir("noticia_imagem_ordem", array(
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
		$exec = $db->executar("SELECT * FROM noticia_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$dados['legenda'] = $data->legenda;
		} else {
			$dados['legenda'] = '';
		}

		$this->view('postagens.legenda', $dados);
	}


	public function legenda_grv(){

		$id = $this->post('id');
		$legenda = $this->post('legenda');
		$codigo = $this->post('codigo');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$db = new mysql();
			$db->alterar("noticia_imagem_legenda", array(
				"legenda"=>"$legenda"
			), " id='$data->id' ");
		} else {
			$db = new mysql();
			$db->inserir("noticia_imagem_legenda", array(
				"id_img"=>"$id",
				"legenda"=>"$legenda"
			));
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM noticia ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == $data->codigo){

				$db = new mysql();
				$exec_img = $db->executar("SELECT * FROM noticia_imagem where codigo='$data->codigo' ");
				while($data_img = $exec_img->fetch_object()){

					if($data_img->imagem){
						unlink('../arquivos/img_postagens_g/'.$data->codigo.'/'.$data_img->imagem);
						unlink('../arquivos/img_postagens_p/'.$data->codigo.'/'.$data_img->imagem);
					}

				}

				$conexao = new mysql();
				$conexao->apagar("noticia_imagem", " codigo='$data->codigo' ");

				$conexao = new mysql();
				$conexao->apagar("noticia", " codigo='$data->codigo' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller);

	}


	public function categorias(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";

		$categorias = new model_postagens();		 
		$dados['categorias'] = $categorias->categorias();		


		$this->view('postagens.categorias', $dados);
	}


	public function categorias_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova Categoria";


		$this->view('postagens.categorias.nova', $dados);
	}


	public function categorias_novo_grv(){

		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("noticia_categorias", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/categorias');

	}


	public function categorias_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar categoria";

		$codigo = $this->get('codigo');

		if(!$codigo){
			echo "Item inválido!";
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_categorias WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/categorias');
		}

		$this->view('postagens.categorias.alterar', $dados);

	}


	public function categorias_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("noticia_categorias", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/categorias');

	}

	public function categorias_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM noticia_categorias ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				$conexao = new mysql();
				$conexao->apagar("noticia_categorias", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/categorias');

	}



	public function mascara(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Marca d'água"; 		 

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_marcadagua WHERE id='1' ");
		$data_masc = $exec->fetch_object();

		$lista = new model_mascara();
		$dados['lista'] = $lista->lista($data_masc->codigo);


		$this->view('postagens.mascara', $dados);
	}


	public function mascara_grv(){

		$codigo = $this->post('codigo');

		$db = new mysql();
		$db->alterar("noticia_marcadagua", array(
			"codigo"=>"$codigo"
		), " id='1' ");

		$this->irpara(DOMINIO.$this->_controller.'/mascara');
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
		$pasta = "postagens";
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

			/////////////////////////////////////////////////////////////////////////////////////////////////
			//definições de mascara
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM noticia_marcadagua where id='1' ");						
			$data = $coisas->fetch_object();

			if($data->codigo){
				$mascara = new model_mascara();
				$mascara->aplicar($data->codigo, $diretorio_g.$nome_foto);
			}

			//grava banco
			$db = new mysql();
			$db->inserir("noticia_imagem", array(
				"codigo"=>"$codigo",
				"imagem"=>"$nome_foto"
			));					
			$ultid = $db->ultimo_id();

				//ordem
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM noticia_imagem_ordem where codigo='$codigo' order by id desc limit 1");
			$data = $exec->fetch_object();

			if(isset($data->data)){
				$novaordem = $data->data.",".$ultid;
			} else {
				$novaordem = $ultid;
			}

			$db = new mysql();
			$db->inserir("noticia_imagem_ordem", array(
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
		$pasta = "postagens";
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

				/////////////////////////////////////////////////////////////////////////////////////////////////
				//definições de mascara
				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM noticia_marcadagua where id='1' ");						
				$data = $coisas->fetch_object();
				
				if($data->codigo){
					$mascara = new model_mascara();
					$mascara->aplicar($data->codigo, $diretorio_g.$nome_foto);
				}

				//grava banco
				$db = new mysql();
				$db->inserir("noticia_imagem", array(
					"codigo"=>"$codigo",
					"imagem"=>"$nome_foto"
				));				
				$ultid = $db->ultimo_id();

				//ordem
				$db = new mysql();
				$exec = $db->executar("SELECT * FROM noticia_imagem_ordem where codigo='$codigo' order by id desc limit 1");
				$data = $exec->fetch_object();

				if(isset($data->data)){
					$novaordem = $data->data.",".$ultid;
				} else {
					$novaordem = $ultid;
				}

				$db = new mysql();
				$db->inserir("noticia_imagem_ordem", array(
					"codigo"=>"$codigo",
					"data"=>"$novaordem"
				));

			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
		}

	}


	//apartir daqui autores
	public function autores(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Autores";

		$lista = new model_postagens();		 
		$dados['lista'] = $lista->autores();		 


		$this->view('postagens.autores', $dados);
	}


	public function novo_autor(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova Autor";


		$this->view('postagens.autores.novo', $dados);
	}


	public function novo_autor_grv(){

		$nome = $this->post('nome');
		$descricao = $this->post_htm('descricao');

		$this->valida($nome);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("noticia_autores", array(
			"codigo"=>"$codigo",
			"nome"=>"$nome",
			"descricao"=>"$descricao"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar_autor/codigo/'.$codigo.'/aba/imagem/');		
	}


	public function alterar_autor(){

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Autores";

		$codigo = $this->get('codigo');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_autores WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/autores');
		}

		$this->view('postagens.autores.alterar', $dados);
	}


	public function alterar_autor_grv(){

		$codigo = $this->post('codigo');

		$nome = $this->post('nome');		 
		$descricao = $this->post_htm('descricao');

		$this->valida($codigo);
		$this->valida($nome);

		$db = new mysql();
		$db->alterar("noticia_autores", array(
			"nome"=>"$nome",
			"descricao"=>"$descricao"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/autores');

	}


	public function alterar_autor_imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$arquivo = new model_arquivos_imagens();

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/imagens/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_foto  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_foto)){

				$db = new mysql();
				$db->alterar("noticia_autores", array(
					"imagem"=>"$nome_foto"
				), " codigo='$codigo' ");

			} else {

				$this->msg('Erro ao gravar imagem!');

			}

			$this->irpara(DOMINIO.$this->_controller."/alterar_autor/codigo/".$codigo."/aba/imagem");
		}

	}


	public function apagar_autor_imagem(){

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM noticia_autores where codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/imagens/'.$data->imagem);
			}

			$db = new mysql();
			$db->alterar("noticia_autores", array(
				"imagem"=>""
			), " codigo='$codigo' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar_autor/codigo/'.$codigo.'/aba/imagem');
	}	


	public function apagar_autores(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM noticia_autores ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				if($data->imagem){
					unlink('../arquivos/imagens/'.$data->imagem);
				}

				$conexao = new mysql();
				$conexao->apagar("noticia_autores", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/autores');

	}


	// grupos


	public function grupos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		// Instancia
		$noticia = new model_postagens();

		$dados['grupos'] = $noticia->lista_grupos();

		$this->view('postagens.grupos', $dados);
	}

	public function grupos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('postagens.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);

		// Instancia
		$noticia = new model_postagens();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('noticia_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,			 
			'itens_por_linha'=>'4'
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "postagens";
		$titulo_pagina = "Postagens - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);


		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$noticia = new model_postagens();

		$codigo = $this->get('codigo');

		$dados['categorias'] = $noticia->categorias();
		$dados['data'] = $noticia->carrega_grupo($codigo);

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);		 
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('postagens.grupos.alterar', $dados);
	}

	public function grupos_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post_htm('titulo');
		$itens_por_linha = $this->post('itens_por_linha');
		$formato = $this->post('formato');
		$mostrar_titulo = $this->post('mostrar_titulo');
		$itens_por_pagina = $this->post('itens_por_pagina'); 
		$marcados = $this->post('marcados');
		$max_itens = $this->post('max_itens');
		$categoria = $this->post('categoria');
		$mostrar_categorias = $this->post('mostrar_categorias');
		$mostrar_banners = $this->post('mostrar_banners');
		$botao = $this->post('botao');

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
		$db->alterar("noticia_grupos", array(
			'titulo'=>$titulo,
			'itens_por_linha'=>$itens_por_linha,
			'formato'=>$formato,
			'mostrar_titulo'=>$mostrar_titulo,
			'mostrar_categorias'=>$mostrar_categorias,
			'itens_por_pagina'=>$itens_por_pagina,
			'marcados'=>$marcados,
			'max_itens'=>$max_itens,
			'categoria'=>$categoria,
			'mostrar_banners'=>$mostrar_banners,			 
			'botao_codigo'=>$botao,
			'font'=>$fonte,
			'font_family'=>$font_family,
			'classes'=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		// layout
		
		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pgaina = "Postagens - $titulo";
		$tipo = "postagens";
		$layout->altera_paginas($codigo, $titulo_pgaina);
		$layout->adiciona_cores($tipo, $codigo);

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
		$noticia = new model_postagens();

		foreach ($noticia->lista_grupos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == $value['codigo']){

				$db = new mysql();
				$db->apagar('noticia_grupos', " codigo='".$value['codigo']."' ");

				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($value['codigo']);
				$layout->apagar_cores($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

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


		$layout = new model_layout();		
		$dados['botoes'] = $layout->lista_botoes();


		$db = new mysql();
		$exec_det = $db->executar("SELECT * FROM noticia_detalhes where id='1' ");
		$dados['data'] = $exec_det->fetch_object();


		$this->view('postagens.detalhes.alterar', $dados);
	}

	public function pg_detalhes_grv(){

		$botao_codigo = $this->post('botao_codigo'); 

		if($botao_codigo){

			$db = new mysql();
			$db->alterar("noticia_detalhes", array(
				'botao_codigo'=>$botao_codigo
			), " id='1' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/pg_detalhes');	
	}


//termina classe
}