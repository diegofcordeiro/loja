<?php

class perfil extends controller {
	
	protected $_modulo_nome = "Perfil";
	
	public function init(){
		$this->autenticacao();
	}
	
	public function inicial(){
			
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "";
 		
 		// abas
		if($this->get('aba')){
			$dados['aba_selecionada'] = $this->get('aba');
		} else {
			$dados['aba_selecionada'] = 'informacoes';	
		}
		
		//envia para view as informaçoes do usuario
 		$dados['data'] = $this->_dados_usuario;
		
		// menu
		$dados['listamenu'] = $this->lista_menu();
		
		// carrega view
		$this->view('perfil', $dados);
	}

	public function alterar_grv(){

		$nome = $this->post('nome');
		$email_recuperacao = $this->post('email_recuperacao');
		
		$valida = new model_valida();
		if(!$valida->email($email_recuperacao)){
			$this->msg('E-mail inválido!');
		}
		$this->valida($nome);

		$perfil = new model_perfil();
		$perfil->alterar_info(array(
			$nome,
			$email_recuperacao
		), $this->_cod_usuario );

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/informacoes');
	}

	public function apagar_imagem(){

		if($this->_dados_usuario->imagem){
			unlink('../arquivos/img_usuarios/'.$this->_dados_usuario->imagem);
		}

		$perfil = new model_perfil();
		$perfil->alterar_imagem("", $this->_cod_usuario);

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/imagem');
	}

	public function alterar_senha(){
		
		$usuario = $this->post('usuario');
		$senha = $this->post('senha');
	 	
		$this->valida($usuario);
		$this->valida($senha);

		$perfil = new model_perfil();
		$usuarios = new model_usuarios();

		if(!$usuarios->confere_usuario($usuario, $this->_cod_usuario)){
			$this->msg('O usuário escolhido esta sendo utilizado por outro cadastro!');
			$this->volta(1);
		}
		
		$usuario_md5 = md5($usuario);
		$senha_md5 = md5($senha);
		
		$perfil->alterar_senha(array(
			$usuario_md5,
			$senha_md5
		), $this->_cod_usuario);

		$this->msg('Senha alterada com sucesso!');
		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/senha');
	}
		
	public function imagem(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$arquivo = new model_arquivos_imagens();
		$perfil = new model_perfil();

		//// Definicao de Diretorios / 
		$diretorio = "../arquivos/img_usuarios/";
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

				//pega a exteção
				$nome_original = $arquivo_original['name'];
				$extensao = $arquivo->extensao($nome_original);
				$nome_arquivo = $arquivo->trata_nome($nome_original);
				
				if(copy($tmp_name, $diretorio.$nome_arquivo)){
					
					if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
						
						// foto grande
						$largura_g = 600;
						$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);
						
						//redimenciona
						$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g, $diretorio.$nome_arquivo);
						
					}

					// grava no banco 
					$perfil->alterar_imagem($nome_arquivo, $this->_cod_usuario);					 
					
					$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/imagem');
					
				} else {
					
					$this->msg('Não foi possível copiar o arquivo!');
					$this->volta(1);
					
				}
				
		}
	}
	
	public function ordem(){

		$list = $_POST['list'];
		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$perfil = new model_perfil();
		$perfil->alterar_ordem_menu($ordem, $this->_cod_usuario);
		
	}
	
	
}