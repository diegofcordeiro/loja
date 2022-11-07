<?php

class imagens extends controller {
	
	protected $_modulo_nome = "Imagens";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(28);
	}

	public function inicial(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		// instancia
		$imagens = new model_imagens();
		$dados['lista'] = $imagens->lista();
		
		$this->view('imagens', $dados);
	}

	public function enviadas(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Enviadas";

		// instancia
		$imagens = new model_imagens();
		$dados['lista'] = $imagens->enviadas();
		
		$this->view('imagens.enviadas', $dados);
	}

	public function criar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Criar";

		$dados['aba_selecionada'] = "dados";

		$this->view('imagens.enviadas.nova', $dados);
	}

	public function criar_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);

		// instancia
		$arquivo = new model_arquivos_imagens();

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$diretorio = "../arquivos/imagens/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				$codigo = $this->gera_codigo();

				// executa
				$db = new mysql();
				$db->inserir("imagem_enviadas", array(
					'codigo'=>$codigo,
					'titulo'=>$titulo,
					'imagem'=>$nome_arquivo
				));
				
				$this->irpara(DOMINIO.$this->_controller."/enviadas");

			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/enviadas");
				
			}
		}	
	}

	public function apagar_enviada(){
		
		$codigo = $this->get('codigo');

		if($codigo){

			// instancia
			
			$db = new mysql();
			$coisas = $db->executar("SELECT * FROM imagem_enviadas where codigo='$codigo' ");
			$data = $coisas->fetch_object();

			if($data->imagem){
				unlink('../arquivos/imagens/'.$data->imagem);
			}

			// executa
			$db = new mysql();
			$db->apagar("imagem_enviadas", " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/enviadas');
	}

	public function nova(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova";

		$dados['aba_selecionada'] = "dados";

		$this->view('imagens.nova', $dados);
	}

	public function nova_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);

		// instancia
		$imagens = new model_imagens();

		$codigo = $this->gera_codigo();

		$imagens->adiciona(array(
			$codigo,
			$titulo
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
		
 		// instancia
		$imagens = new model_imagens();
		$dados['data'] = $imagens->carrega($codigo);		 
		
		$this->view('imagens.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		
		$this->valida($codigo);
		$this->valida($titulo);
		
		// instancia
		$imagens = new model_imagens();
		
		$imagens->altera_titulo($titulo, $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}
	
	public function imagem(){
		
		// instancia
		$imagens = new model_imagens();
		$arquivo = new model_arquivos_imagens();

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$codigo = $this->get('codigo');
		
		$diretorio = "../arquivos/imagens/";
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				$imagens->altera_imagem($nome_arquivo, $codigo);
				
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

			// instancia
			$imagens = new model_imagens();

			$data = $imagens->carrega($codigo);
			if($data->imagem){
				unlink('../arquivos/imagens/'.$data->imagem);
			}
			$imagens->altera_imagem("", $codigo);

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}
	
	public function apagar_varios(){

		// instancia
		$imagens = new model_imagens();

		foreach ($imagens->lista() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){
				
				if($value['imagem']){
					unlink('../arquivos/imagens/'.$value['imagem']);
				}
				$imagens->apagar($value['codigo']);
			}

		}
		
		$this->irpara(DOMINIO.$this->_controller);		
	}

	public function imagem2(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$arquivo = new model_arquivos_imagens();

		$codigo = $this->get('codigo');
		
		$diretorio = "../arquivos/imagens/";
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				$db = new mysql();
				$db->inserir("imagem_itens", array(
					"codigo"=>"$codigo",
					"imagem"=>"$nome_arquivo"
				));
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
				
			}
		}		
	}

	public function apagar_imagem2(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($codigo AND $id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imagem_itens where codigo='$codigo' AND id='$id'");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/imagens/'.$data->imagem);
			}
			
			$db = new mysql();
			$db->apagar("imagem_itens", " codigo='$codigo' AND id='$id' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

}