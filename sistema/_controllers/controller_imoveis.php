<?php

class imoveis extends controller {
	
	protected $_modulo_nome = "Imóveis";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(130);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$imoveis = new model_imoveis();
		$dados['lista'] = $imoveis->lista();
		
		$this->view('imoveis', $dados);
	}
	
	public function novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		if($this->get('cadastro')){
			$dados['cod_cadastro'] = $this->get('cadastro');
		} else {
			$dados['cod_cadastro'] = 0;
		}

		$imoveis = new model_imoveis();
		$dados['categorias'] = $imoveis->lista_categorias();

		$this->view('imoveis.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$categoria = $this->post('categoria');

		if($titulo){

			$time = time();			
			$codigo = $this->gera_codigo();

			// categoria
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT titulo FROM imoveis_categorias WHERE codigo='$categoria' ");
			$data = $coisas->fetch_object();

			if(isset($data->titulo)){
				$categoria_titulo = $data->titulo;
			} else {
				$categoria_titulo = "Todas";
				$categoria = 0;
			}

			$db = new mysql();
			$db->inserir("imoveis", array(
				"data_alteracao"=>"$time",
				"codigo"=>"$codigo",
				"titulo"=>"$titulo",
				"categoria_id"=>"$categoria",
				"categoria_titulo"=>"$categoria_titulo",
				"valor"=>"0",				 
				"destaque"=>"0",
				"status"=>"0"
			));
			
		} else {
			$this->msg('Preencha todos os campos!');
			$this->volta(1);
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
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

		$dados['cadastro_get'] = $this->get('cadastro');
		
 		// instancia
		$imoveis = new model_imoveis();
		$valores = new model_valores();		

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		$dados['condominio'] = $valores->trata_valor($dados['data']->condominio);
		$dados['iptu'] = $valores->trata_valor($dados['data']->iptu);

 		//imagens
		$dados['imagens'] = $imoveis->lista_imagens($dados['data']->codigo);

		// categorias
		$dados['categorias'] = $imoveis->lista_categorias($dados['data']->categoria_id);

		//cidades
		$dados['cidades'] = $imoveis->lista_cidades($dados['data']->cidade_id);

 		// tipos
		$dados['tipos'] = $imoveis->lista_tipos($dados['data']->tipo_id);
		
		$dados['opcionais'] = $imoveis->lista_opcoes($codigo);
		
		// cadastros
		$cadastro = new model_cadastros(); 
		$dados['lista_cadastro'] = $cadastro->lista();

		$this->view('imoveis.alterar', $dados);
	}
	
	public function alterar_dados(){

		// instancia
		$imoveis = new model_imoveis();
		$valores = new model_valores();
		
		$codigo = $this->post('codigo');
		$cadastro = $this->post('cadastro'); 


		$titulo = $this->post('titulo');
		$cod_interno = $this->post('cod_interno');	

		$valor = $this->post('valor');
		$valor_formatado = $valores->trata_valor_banco($valor);

		$condominio = $this->post('condominio');
		$condominio_formatado = $valores->trata_valor_banco($condominio);

		$iptu = $this->post('iptu');
		$iptu_formatado = $valores->trata_valor_banco($iptu);

		$obs = $this->post('obs');
		$descricao = $this->post_html('descricao');

		$categoria = $this->post('categoria');
		$tipo = $this->post('tipo'); 
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');	
		$endereco = $this->post('endereco');
		$numero  = $this->post('numero');
		$complemento  = $this->post('complemento');
		$cep  = $this->post('cep');
		
		$area_util = $this->post('area_util');
		$area_total  = $this->post('area_total');
		
		$quartos = $this->post('quartos');
		$suites  = $this->post('suites');
		$banheiros  = $this->post('banheiros');
		$garagem  = $this->post('garagem');
		$churrasqueira  = $this->post('churrasqueira');
		
		$lavanderias  = $this->post('lavanderias');
		$salas  = $this->post('salas');
		$cozinhas  = $this->post('cozinhas');

		$status = $this->post('status');
		
		$this->valida($codigo);
		
		$time = time();

		// categoria
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT titulo FROM imoveis_categorias WHERE codigo='$categoria' ");
		$data = $coisas->fetch_object();
		
		if(isset($data->titulo)){
			$categoria_titulo = $data->titulo;
		} else {
			$categoria_titulo = "Todas";
			$categoria = 0;
		}
		
		// tipo

		$tipo_titulo = '';
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT titulo FROM imoveis_tipos WHERE codigo='$tipo' ");
		$data = $coisas->fetch_object();
		if(isset($data->titulo)){
			$tipo_titulo = $data->titulo;
		} else {
			$this->msg('Selecione o tipo!');
			$this->volta(1);
		}
		
		// bairro
		$bairro_titulo = '';
		if($bairro){
			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT bairro FROM imoveis_bairros WHERE codigo='$bairro' ");
			$data = $coisas->fetch_object();
			if(isset($data->bairro)){
				$bairro_titulo = $data->bairro;
			}
		}

		// cidade
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		if( isset($data->cidade) AND isset($data->estado) ){
			$cidade_nome = $data->cidade;
			$uf = $data->estado;
		} else {
			$this->msg('Selecione a cidade!');
			$this->volta(1);
		}
		
		// grava no banco
		
		$db = new mysql();
		$db->alterar("imoveis", array(
			"data_alteracao"=>"$time",
			"cadastro"=>"$cadastro", 
			"titulo"=>"$titulo",
			"cod_interno"=>"$cod_interno",
			"categoria_id"=>"$categoria",
			"categoria_titulo"=>"$categoria_titulo",
			"tipo_id"=>"$tipo",
			"tipo_titulo"=>"$tipo_titulo",
			"descricao"=>"$descricao",
			"endereco"=>"$endereco",
			"numero"=>"$numero",
			"complemento"=>"$complemento",
			"bairro_id"=>"$bairro",
			"bairro"=>"$bairro_titulo",
			"cidade_id"=>"$cidade",
			"cidade"=>"$cidade_nome",
			"uf"=>"$uf",
			"cep"=>"$cep",
			"valor"=>"$valor_formatado",
			"area_util"=>"$area_util",
			"area_total"=>"$area_total",
			"iptu"=>"$iptu_formatado",
			"condominio"=>"$condominio_formatado",
			"quartos"=>"$quartos",
			"suites"=>"$suites",
			"garagem"=>"$garagem",
			"banheiros"=>"$banheiros",
			"salas"=>"$salas",
			"cozinhas"=>"$cozinhas",
			"churrasqueira"=>"$churrasqueira",
			"lavanderias"=>"$lavanderias",
			"status"=>"$status",
			"obs"=>"$obs"
		), " codigo='$codigo' ");


		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/dados');

	}

	public function lista_bairros(){

		$dados['_base'] = $this->base();

		$cidade = $this->post('cidade');
		$selecionado = $this->post('selecionado');

		if($cidade){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
			$data = $coisas->fetch_object();

			if($data->cidade AND $data->estado){

				$imoveis = new model_imoveis();
				$listadebairros = $imoveis->lista_bairros($data->cidade, $data->estado);
				
				echo "
				<select class='form-control select2' name='bairro' >
				<option value='' >Selecione</option>
				";

				foreach ($listadebairros as $key => $value) {

					if($value['codigo'] == $selecionado){
						$selected = " selected='' ";
					} else {
						$selected = "";
					}

					echo "<option value='".$value['codigo']."' $selected >".$value['bairro']."</option>";
				}

				echo "</select>";

			} else {
				echo "erro";
			}			
		} else {
			echo "erro";
		}

	}

	public function apagar_varios(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista() as $key => $value) {			
			if($this->post('apagar_'.$value['id']) == 1){				 

				foreach ($imoveis->lista_imagens($value['codigo']) as $key3 => $value3) {

					if( $value3['imagem'] ){
						unlink('../arquivos/img_imoveis_g/'.$value['codigo'].'/'.$value3['imagem']);
						unlink('../arquivos/img_imoveis_p/'.$value['codigo'].'/'.$value3['imagem']);						 
					}

				}

				$db = new mysql();
				$db->apagar("imoveis", " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar("imoveis_imagem", " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar("imoveis_imagem_ordem", " codigo='".$value['codigo']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}

	// IMAGEM

	public function upload(){

		//carrega normal
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');
		$dados['codigo'] = $codigo;

		$this->view('enviar_imagens', $dados);
	}

	public function imagem_redimencionada(){

		$codigo = $this->post('codigo');

		//pasta onde vai ser salvo os ../arquivos
		$pasta = "imoveis";
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
		$imoveis = new model_imoveis();

		// Recuperando imagem em base64
		// Exemplo: data:image/png;base64, 
		$imagem = $this->post_html('imagem');
		$nome_original = $this->post('nomeimagem');

		$nome_foto  = $img->trata_nome($nome_original);
		$extensao = $img->extensao($nome_original);

		// Separando tipo dos dados da imagem
		// $tipo: data:image/png
		// $dados: base64, 
		list($tipo, $dados) = explode(';', $imagem);

		// Isolando apenas o tipo da imagem
		// $tipo: image/png
		list(, $tipo) = explode(':', $tipo);

		// Isolando apenas os dados da imagem
		// $dados:  
		list(, $dados) = explode(',', $dados);

		// Convertendo base64 para imagem
		$dados = base64_decode($dados);

		// Gerando nome aleatório para a imagem
		$nome = md5(uniqid(time()));

		// Salvando imagem em disco
		if(file_put_contents($diretorio_g.$nome_foto, $dados)) {			

			//confere e se jpg reduz a miniatura
			if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

				// foto grande
				$largura_g = 1200;
				$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);
				// foto minuatura
				$largura_p = 300;
				$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
				//redimenciona
				$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);

				//redimenciona miniatura 
				if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
					//se não redimencionar copia padrao
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
				}

			} else {

				//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
				copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

			}

			//definições de mascara
			$cod_mascara = $imoveis->carrega_mascara();				
			if($cod_mascara){
				$mascara = new model_mascara();
				$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
			}

			//grava banco e retorna id
			$ultid = $imoveis->adiciona_imagem(array(
				$codigo,
				$nome_foto
			));

			//ordem
			$ordem = $imoveis->ordem_imagens($codigo);								
			if($ordem){
				$novaordem = $ordem.",".$ultid;
			} else {
				$novaordem = $ultid;
			}
			// grava ordem
			$imoveis->salva_ordem_imagem($codigo, $novaordem);

		}

	}

	public function imagem_manual(){
		
		$arquivo = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$codigo = $this->get('codigo');

		$nome_original = $_FILES['arquivo']['name'];
		
		//definições de pasta
		$pasta = "imoveis";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";

		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}

		$img = new model_arquivos_imagens();
		$imoveis = new model_imoveis();
		
		if($tmp_name) {
			
			$nome_foto  = $img->trata_nome($nome_original);
			$extensao = $img->extensao($nome_original);
			
			if(copy($tmp_name, $diretorio_g.$nome_foto)){

				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					// foto grande
					$largura_g = 1200;
					$altura_g = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);

					//redimenciona miniatura 
					if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
						//se não redimencionar copia padrao
						copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					}

				} else {

					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

				}

				//definições de mascara
				$cod_mascara = $imoveis->carrega_mascara();				
				if($cod_mascara){
					$mascara = new model_mascara();
					$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
				}

				//grava banco e retorna id
				$ultid = $imoveis->adiciona_imagem(array(
					$codigo,
					$nome_foto
				));
				
				//ordem
				$ordem = $imoveis->ordem_imagens($codigo);								
				if($ordem){
					$novaordem = $ordem.",".$ultid;
				} else {
					$novaordem = $ultid;
				}

				// grava ordem
				$imoveis->salva_ordem_imagem($codigo, $novaordem);

			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
		}

	}

	public function ordenar_imagem(){
		
		$codigo = $this->post('codigo');
		$list = $this->post_html('list');
		
		$this->valida($codigo);
		$this->valida($list);
		
		// instancia
		$imoveis = new model_imoveis();
		
		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);
		
		//grava
		$imoveis->salva_ordem_imagem($codigo, $ordem);
	}

	public function apagar_imagem(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');
		
		if($id){
			
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imoveis_imagem WHERE id='$id' ");
			$data = $exec->fetch_object();

			//imagem
			if($data->imagem){
				unlink('../arquivos/img_imoveis_g/'.$data->codigo.'/'.$data->imagem);
				unlink('../arquivos/img_imoveis_p/'.$data->codigo.'/'.$data->imagem);
			}
			//apaga
			$db = new mysql();
			$db->apagar("imoveis_imagem", " id='$id' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function girar_imagem(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');
		
		$imoveis = new model_imoveis();
		$arquivos = new model_arquivos_imagens();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_imagem WHERE id='$id' ");
		$data = $exec->fetch_object();

		$nome_antigo = $data->imagem;

		$extensao = $arquivos->extensao($data->imagem);
		$novo_nome = substr($nome_antigo, 0, strlen($nome_antigo) - 25).'.'.$extensao;
		$novo_nome_tratado = $arquivos->trata_nome($novo_nome);

		$caminho = "../arquivos/img_imoveis_g/".$codigo."/".$nome_antigo;
		// destino
		$destino = "../arquivos/img_imoveis_g/".$codigo."/".$novo_nome_tratado;

		// gira a imagem
		if($arquivos->girar_imagem($caminho, $destino)){

			///////////////////////////////
			// imagem pequena

			$caminho = "../arquivos/img_imoveis_p/".$codigo."/".$nome_antigo;
			// destino
			$destino = "../arquivos/img_imoveis_p/".$codigo."/".$novo_nome_tratado;

			// gira a imagem
			if($arquivos->girar_imagem($caminho, $destino)){

				// remove imagem antiga
				unlink("../arquivos/img_imoveis_g/".$codigo."/".$nome_antigo);
				unlink("../arquivos/img_imoveis_p/".$codigo."/".$nome_antigo);
				
				// grava nova imagem
				$db = new mysql();
				$db->alterar("imoveis_imagem", array(
					"imagem"=>"$novo_nome_tratado"
				), " id='$id' ");
				
				// direciona
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
			} else {
				$this->msg('Não foi possivel girar esta imagem!'); 
				$this->volta(1);			
			}

		} else {
			$this->msg('Não foi possivel girar esta imagem!');
			$this->volta(1);
		}

	}

	// mascara Marca dgua

	public function mascara(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Marca d'água"; 		 

		$mascaras = new model_mascara();
		$imoveis = new model_imoveis();

		$mascara = $imoveis->carrega_mascara();
		$dados['lista'] = $mascaras->lista($mascara);

		$this->view('imoveis.mascara', $dados);
	}	

	public function mascara_grv(){

		$codigo = $this->post('codigo');

		$imoveis = new model_imoveis();
		$imoveis->altera_mascara($codigo);

		$this->irpara(DOMINIO.$this->_controller.'/mascara');
	}

///////////////////////////////////////////////////////////////////////////////////////

	public function categorias(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";

		$imoveis = new model_imoveis();

		$dados['lista'] = $imoveis->lista_categorias();

		$this->view('imoveis.categorias', $dados);
	}

	public function categorias_grv(){

		$dados['_base'] = $this->base();

		$imoveis = new model_imoveis();
		$lista = $imoveis->lista_categorias();
		
		foreach ($lista as $key => $value){
			
			if($this->post('linha_'.$value['id']) == 1){
				
				$db = new mysql();
				$db->alterar("imoveis_categorias", array(
					"ativo"=>1
				), " id='".$value['id']."' ");

			} else {

				$db = new mysql();
				$db->alterar("imoveis_categorias", array(
					"ativo"=>0
				), " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.'imoveis/categorias');
	}

///////////////////////////////////////////////////////////////////////////////////////


	public function cidades(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Cidades";

		$imoveis = new model_imoveis();

		$dados['lista'] = $imoveis->lista_cidades();

		$this->view('imoveis.cidades', $dados);
	}

	public function cidades_nova(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Criar Cidade";

		$this->view('imoveis.cidades.nova', $dados);
	}

	public function cidades_nova_grv(){

		$cidade = $this->post('cidade');
		$estado = $this->post('estado');
		$principal = $this->post('principal');

		$this->valida($cidade);
		$this->valida($estado);

		$codigo = $this->gera_codigo();

		// zera tudo
		if($principal == 1){
			$db = new mysql();
			$db->alterar("imoveis_cidades", array(
				"principal"=>0
			), " id!='0' ");
		}

		$db = new mysql();
		$db->inserir("imoveis_cidades", array(
			"codigo"=>$codigo,
			"cidade"=>$cidade,
			"estado"=>$estado,
			"principal"=>$principal
		));

		$this->irpara(DOMINIO.$this->_controller.'/cidades');		
	}

	public function cidades_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Cidade";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro ao identificar cidade!');
			$this->volta(1);
		}

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$codigo' ");
		$dados['data'] = $coisas->fetch_object();

		$this->view('imoveis.cidades.alterar', $dados);
	}

	public function cidades_alterar_grv(){

		$codigo = $this->post('codigo');
		$cidade = $this->post('cidade');
		$estado = $this->post('estado');
		$principal = $this->post('principal');

		$this->valida($codigo);
		$this->valida($cidade);
		$this->valida($estado);

		// zera tudo
		if($principal == 1){
			$db = new mysql();
			$db->alterar("imoveis_cidades", array(
				"principal"=>0
			), " id!='0' ");
		}
		
		$db = new mysql();
		$db->alterar("imoveis_cidades", array(
			"cidade"=>$cidade,
			"estado"=>$estado,
			"principal"=>$principal
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/cidades');		
	}

	public function cidades_apagar(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_cidades() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("imoveis_cidades", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/cidades');		
	}


///////////////////////////////////////////////////////////////////////////////////////


	public function bairros(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Bairros";

// Instancia
		$imoveis = new model_imoveis();

		$cidade = $this->get('cidade');

		$dados['cidades'] = $imoveis->lista_cidades();
		if(!$cidade){
			$cidade = $dados['cidades'][0]['codigo'];
		}
		$dados['selecionado'] = $cidade;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		$dados['lista'] = $imoveis->lista_bairros($data->cidade, $data->estado);

		$this->view('imoveis.bairros', $dados);
	}

	public function bairros_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Criar Bairro";

// Instancia
		$imoveis = new model_imoveis();
		$dados['cidades'] = $imoveis->lista_cidades();

		$this->view('imoveis.bairros.novo', $dados);
	}

	public function bairros_novo_grv(){

		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');

		$this->valida($cidade);
		$this->valida($bairro);

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		if($data->cidade AND $data->estado){

			$codigo = $this->gera_codigo();

			$db = new mysql();
			$db->inserir("imoveis_bairros", array(
				"codigo"=>$codigo,
				"bairro"=>$bairro,
				"cidade"=>$data->cidade,
				"estado"=>$data->estado
			));

		}

		$this->irpara(DOMINIO.$this->_controller.'/bairros/cidade/'.$cidade);
	}

	public function bairros_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Bairro";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro ao identificar bairro!');
			$this->volta(1);
		}

// Instancia
		$imoveis = new model_imoveis();
		$dados['cidades'] = $imoveis->lista_cidades();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_bairros WHERE codigo='$codigo' ");
		$dados['data'] = $coisas->fetch_object();

		$this->view('imoveis.bairros.alterar', $dados);
	}

	public function bairros_alterar_grv(){

		$codigo = $this->post('codigo');
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');

		$this->valida($codigo);
		$this->valida($cidade);
		$this->valida($bairro);

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		if($data->cidade AND $data->estado){

			$db = new mysql();
			$db->alterar("imoveis_bairros", array(
				"bairro"=>$bairro,
				"cidade"=>$data->cidade,
				"estado"=>$data->estado
			), " codigo='$codigo' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/bairros/cidade/'.$cidade);
	}

	public function bairros_apagar(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_bairros_all() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("imoveis_bairros", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/bairros');		
	}

///////////////////////////////////////////////////////////////////////////////////////


	public function tipos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Tipos";

		$imoveis = new model_imoveis();

		$dados['lista'] = $imoveis->lista_tipos();		

		$this->view('imoveis.tipos', $dados);
	}

	public function tipos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$this->view('imoveis.tipos.novo', $dados);
	}

	public function tipos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("imoveis_tipos", array(
			"codigo"=>"$codigo", 
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/tipos');		
	}

	public function tipos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro ao identificar o tipo!');
			$this->volta(1);
		}

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_tipos WHERE codigo='$codigo' ");
		$dados['data'] = $coisas->fetch_object();

		$this->view('imoveis.tipos.alterar', $dados);
	}

	public function tipos_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("imoveis_tipos", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/tipos');		
	}

	public function tipos_apagar(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_tipos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("imoveis_tipos", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/tipos');		
	}


	///////////////////////////////////////////////////////////////////////////////////////


	public function opcoes(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Opções";
		
		$imoveis = new model_imoveis();

		$dados['lista'] = $imoveis->lista_opcoes();		

		$this->view('imoveis.opcoes', $dados);
	}

	public function opcoes_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$this->view('imoveis.opcoes.novo', $dados);
	}

	public function opcoes_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("imoveis_opcoes", array(
			"codigo"=>"$codigo", 
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/opcoes');		
	}

	public function opcoes_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro ao identificar a opção!');
			$this->volta(1);
		}

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_opcoes WHERE codigo='$codigo' ");
		$dados['data'] = $coisas->fetch_object();

		$this->view('imoveis.opcoes.alterar', $dados);
	}

	public function opcoes_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("imoveis_opcoes", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/opcoes');		
	}

	public function opcoes_apagar(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_opcoes() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("imoveis_opcoes", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/opcoes');		
	}

	public function legenda(){

		$dados['_base'] = $this->base();

		$id = $this->get('id');
		$codigo = $this->get('codigo');

		$dados['codigo'] = $codigo;
		$dados['id'] = $id;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_imagem_legenda where id_img='$id' ");
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
		$exec = $db->executar("SELECT * FROM imoveis_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();
		
		if(isset($data->id)){
			$db = new mysql();
			$db->alterar("imoveis_imagem_legenda", array(
				"legenda"=>"$legenda"
			), " id='$data->id' ");
		} else {
			$db = new mysql();
			$db->inserir("imoveis_imagem_legenda", array(
				"id_img"=>"$id",
				"legenda"=>"$legenda"
			));
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}


	public function marcar_opcionais(){
		
		$dados['_base'] = $this->base();

		$codigo = $this->post('codigo');
		$this->valida($codigo);
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_opcoes ");
		while($data = $exec->fetch_object()){
			
			if($this->post('opcional_'.$data->id) == 1){
				
				$db = new mysql();
				$exec2 = $db->executar("SELECT * FROM imoveis_opcoes_sel where codigo='$codigo' AND opcional='$data->codigo' ");
				if($exec2->num_rows == 0){
					$db = new mysql();
					$db->inserir("imoveis_opcoes_sel", array(
						"codigo"=>$codigo,
						"opcional"=>$data->codigo
					));
				}

			} else {

				$db = new mysql();
				$exec2 = $db->executar("SELECT * FROM imoveis_opcoes_sel where codigo='$codigo' AND opcional='$data->codigo' ");
				if($exec2->num_rows != 0){
					$db = new mysql();
					$db->apagar("imoveis_opcoes_sel", " codigo='$codigo' AND opcional='$data->codigo' ");
				}

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/opcoes');
	}


	// grupos


	public function grupos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Grupos";

		$imoveis = new model_imoveis();
		$dados['grupos'] = $imoveis->lista_grupos();

		$this->view('imoveis.grupos', $dados);
	}

	public function grupos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Grupo";

		$this->view('imoveis.grupos.novo', $dados);
	}

	public function grupos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);

		// Instancia
		$imoveis = new model_imoveis();

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('imoveis_grupos', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo
		));

		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "imoveis";
		$titulo_pagina = "Imoveis - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Grupo";

 		// Instancia
		$imoveis = new model_imoveis();
		$dados['categorias'] = $imoveis->lista_categorias();

		$codigo = $this->get('codigo');

		$dados['data'] = $imoveis->carrega_grupo($codigo);
		$dados['imagens'] = $imoveis->carrega_grupo_img($codigo);

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

		$this->view('imoveis.grupos.alterar', $dados);
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
		$db->alterar("imoveis_grupos", array(
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
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		
		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$titulo_pgaina = "Imoveis - $titulo";
		$tipo = "imoveis";
		$layout->altera_paginas($codigo, $titulo_pgaina);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function grupos_imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$arquivo = new model_arquivos_imagens();

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_imoveis_grupos/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				$db = new mysql();
				$db->inserir('imoveis_grupos_imagens', array(
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
			$exec = $db->executar("SELECT * FROM imoveis_grupos_imagens WHERE id='$id' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_imoveis_grupos/'.$data->imagem);
			}
			
			$db->apagar("imoveis_grupos_imagens", "  id='$id' ");

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
		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_grupos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == $value['codigo']){

				$db = new mysql();
				$db->apagar('imoveis_grupos', " codigo='".$value['codigo']."' ");

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
		$exec_det = $db->executar("SELECT * FROM imoveis_detalhes where id='1' ");
		$dados['data'] = $exec_det->fetch_object();

		$layout = new model_layout();

		if($dados['data']->formato_pg == 1){
			$dados['cores'] = $layout->lista_cores('imoveis_detalhes1');
		} else {
			$dados['cores'] = $layout->lista_cores('imoveis_detalhes2');
		}

		$layout = new model_layout();		
		$dados['botoes'] = $layout->lista_botoes();


		$this->view('imoveis.detalhes.alterar', $dados);
	}

	public function pg_detalhes_grv(){

		$formato_pg = $this->post('formato_pg');
		$destino_form = $this->post('destino_form');
		$destino_voltar = $this->post('destino_voltar');
		$font_codigo = $this->post('font_codigo');
		$whats_destino = $this->post('whats_destino');
		$botao_codigo_ped = $this->post('botao_codigo_ped');
		
		if($destino_form AND $font_codigo){

			$fontes = new model_fontes(); 
			$font_family = $fontes->font_family($font_codigo);
			
			$db = new mysql();
			$db->alterar("imoveis_detalhes", array(
				'destino_form'=>$destino_form,
				'destino_voltar'=>$destino_voltar,
				'formato_pg'=>$formato_pg,
				'font_codigo'=>$font_codigo,
				'font_family'=>$font_family,
				'whats_destino'=>$whats_destino,
				'botao_codigo_ped'=>$botao_codigo_ped
			), " id='1' ");
			
		}

		$this->irpara(DOMINIO.$this->_controller.'/pg_detalhes');	
	}

	public function pg_detalhes_cores(){

		$formato_pg = $this->post('formato_pg');

		if($formato_pg){

			$layout = new model_layout();
			$layout->adiciona_cores('imoveis_detalhes'.$formato_pg, 'imoveis_detalhes'.$formato_pg);

			$cores = $layout->lista_cores('imoveis_detalhes'.$formato_pg);
			foreach ($cores as $key => $value) {
				$cor_nova = $this->post('cor_'.$value['id']);
				if($cor_nova){
					$db = new mysql();
					$db->alterar("layout_itens_cores_sel", array(
						'cor'=>$cor_nova
					), " id='".$value['id']."' ");
				}
			}

		}

		$this->irpara(DOMINIO.$this->_controller.'/pg_detalhes/aba/cores');	
	}


	public function relatorio(){
		
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		
		$dados['resultado'] = false;

		$categoria = $this->post('categoria');
		$tipo = $this->post('tipo');
		$cidade = $this->post('cidade');

		if($this->get('imprimir')){

			$categoria = $this->get('categoria');
			$tipo = $this->get('tipo');
			$cidade = $this->get('cidade');

		}	



		if($categoria AND $tipo AND $cidade){


			$dados['categoria_sel'] = $categoria;
			$dados['tipo_sel'] = $tipo;
			$dados['cidade_sel'] = $cidade;
			$dados['resultado'] = true;			

			$query = "SELECT * FROM imoveis WHERE id!='0' ";

			if($categoria != 'todos'){
				$query .= " AND categoria_id='$categoria' ";
			}

			if($tipo != 'todos'){ 
				$query .= " AND tipo_id='$tipo' ";
			}

			if($cidade != 'todos'){
				$query .= " AND cidade_id='$cidade' ";
			}

			$query .= " ORDER BY id desc ";

			$lista = array();
			$n = 0;

			$conexao = new mysql();
			$coisas_imoveis = $conexao->Executar($query);
			while($data_imoveis = $coisas_imoveis->fetch_object()){

				$lista[$n]['id'] = $data_imoveis->id;
				$lista[$n]['codigo_interno'] = $data_imoveis->cod_interno;
				$lista[$n]['titulo'] = $data_imoveis->titulo;
				$lista[$n]['categoria'] = $data_imoveis->categoria_titulo;
				$lista[$n]['tipo'] = $data_imoveis->tipo_titulo;
				$lista[$n]['cidade'] = $data_imoveis->cidade.' - '.$data_imoveis->uf;

				$n++;
			}

			$dados['lista'] = $lista;
			$dados['total_itens'] = $n;
		}

		if(!$this->get('imprimir')){ 

			$imoveis = new model_imoveis();
			$dados['cidades'] = $imoveis->lista_cidades($cidade);
			$dados['tipos'] = $imoveis->lista_tipos($tipo);
			$dados['categorias'] = $imoveis->lista_categorias($categoria);


			$this->view('imoveis.relatorios', $dados);

		} else {

			$this->view('imoveis.relatorios_imp', $dados);
			
		}

	}

}