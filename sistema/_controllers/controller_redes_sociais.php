<?php

class redes_sociais extends controller {
	
	protected $_modulo_nome = "Redes Sociais";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(46);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$redes = new model_redes_sociais();
		$dados['lista'] = $redes->lista();

		$this->view('redes_sociais', $dados);
	}
	
	public function novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Novo";

 		$dados['aba_selecionada'] = "dados";

		$this->view('redes_sociais.novo', $dados);
	}

	public function nova_grv(){
		
		$titulo = $this->post('titulo');
		$endereco = $this->post_htm('endereco');	

		$this->valida($titulo);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("rede_social", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"endereco"=>"$endereco"
		));

	 	$ultid = $db->ultimo_id();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM rede_social_ordem order by id desc limit 1");
		$data = $coisas->fetch_object();

		if(isset($data->data)){
			$novaordem = $data->data.",".$ultid;
		} else {
			$novaordem = $ultid;
		}		

		$db = new mysql();
		$db->inserir("rede_social_ordem", array(
			"data"=>"$novaordem"
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
 		$exec = $db->Executar("SELECT * FROM rede_social where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();			
 		
		$this->view('redes_sociais.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$endereco = $this->post_htm('endereco');

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("rede_social", array(
			"titulo"=>"$titulo",
			"endereco"=>"$endereco"
		), " codigo='$codigo' ");
	 	
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}

	public function imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$redes = new model_redes_sociais();		

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_redes_sociais/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					$data = $redes->carrega($codigo);					 

					//calcula a 
					$largura_g = 300;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);

					//redimenciona
					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g , $diretorio.$nome_arquivo);
				}
				
				$db = new mysql();
				$db->alterar("rede_social", array(
					"imagem"=>"$nome_arquivo"
				), " codigo='$codigo' ");
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
				
			}

		}
		
	}

	public function apagar_imagem(){
		
		$codigo = $this->get('codigo');
		
		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM rede_social where codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_redes_sociais/'.$data->imagem);
			}

			$db = new mysql();
			$db->alterar("rede_social", array(
				"imagem"=>""
			), " codigo='$codigo' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function ordem(){

		$list = $_POST['list'];

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$db->inserir("rede_social_ordem", array(
			"data"=>"$ordem"
		));

	}

	public function apagar_varios(){		 
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM rede_social ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){
				
				if($data->imagem){
					unlink('../arquivos/img_redes_sociais/'.$data->imagem);
				}

				$conexao = new mysql();
				$conexao->apagar("rede_social", " codigo='$data->codigo' ");
				
			}			 
		}
		
		$this->irpara(DOMINIO.$this->_controller);
	}

}