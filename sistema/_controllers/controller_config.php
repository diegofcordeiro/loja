<?php

class config extends controller {
	
	protected $_modulo_nome = "Configurações";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(2);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		if($this->nivel_acesso(37, false)){
			$dados['acesso_smtp'] = true;
		} else {
			$dados['acesso_smtp'] = false;
		}
		if($this->nivel_acesso(38, false)){
			$dados['acesso_logo'] = true;
		} else {
			$dados['acesso_logo'] = false;
		}

		if($this->nivel_acesso(129, false)){
			$dados['acesso_analytics'] = true;
		} else {
			$dados['acesso_analytics'] = false;
		}

		$dados['acesso_mascara'] = true;
		

		// if($this->get('aba')){
		// 	$dados['aba_selecionada'] = $this->get('aba');
		// } else {

		// 	if($dados['acesso_analytics']){
		// 		$dados['aba_selecionada'] = 'analytics';
		// 	}
		// 	if($dados['acesso_mascara']){
		// 		$dados['aba_selecionada'] = 'mascara';
		// 	}
			if($dados['acesso_smtp']){
				$dados['aba_selecionada'] = 'smtp';
			}
		// 	if($dados['acesso_logo']){
		// 		$dados['aba_selecionada'] = 'imagem';
		// 	}

		// }
		
		$config = new model_config();
		$dados['data'] = $config->carrega_config();

		//lista mascara
		$mascara = new model_mascara();
		if($dados['acesso_mascara']){			
			$dados['mascaras'] = $mascara->lista();
		}	

		$this->view('config', $dados);
	}

	public function analytics_grv(){

		$this->nivel_acesso(129);

		$acompanhamento = base64_encode(htmlspecialchars($_POST['acompanhamento']));

		// instancia
		$config = new model_config();			
		$config->altera_analytics($acompanhamento);

		$this->msg('Alterado com sucesso!');
		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/analytics');
	}

	public function smtp_grv(){

		$this->nivel_acesso(37);

		$email_nome = $this->post('email_nome');
		$email_origem = $this->post('email_origem');
		$email_retorno = $this->post('email_retorno');
		$email_porta = $this->post('email_porta');
		$email_host = $this->post('email_host');
		$email_usuario = $this->post('email_usuario');
		$email_senha = $this->post('email_senha');

		$email_testes = $this->post('email_testes');
		$email_testes_destino = $this->post('email_testes_destino');

		$this->valida($email_nome);
		$this->valida($email_origem);
		$this->valida($email_retorno);
		$this->valida($email_porta);
		$this->valida($email_host);
		$this->valida($email_usuario);
		$this->valida($email_senha);

		// instancia
		$config = new model_config();

		$config->altera_smtp(array(
			$email_nome,
			$email_origem,
			$email_retorno,
			$email_porta,
			$email_host,
			$email_usuario,
			$email_senha
		));

		// testa configuração
		if($email_testes == 'sim'){

			if(!$email_testes_destino){
				$this->msg('Digite um email diferente para enviar o teste.');
				$this->volta(1);
			}
			if($email_testes_destino == $email_origem){
				$this->msg('Digite um email diferente para enviar o teste.');
				$this->volta(1);
			}
			if($email_testes_destino == $email_usuario){
				$this->msg('Digite um email diferente para enviar o teste.');
				$this->volta(1);
			}


			// $this->send_email_($email_testes_destino);
			require_once("_api/phpmailer/class.phpmailer.php");
			
			$mail = new PHPMailer();
			$mail->SetLanguage("br", '_api/phpmailer/language/');

			$mail->IsSMTP();
			$mail->Host = $email_host;
			$mail->Port = $email_porta;
			$mail->SMTPAuth = true;
			$mail->Username = $email_usuario;
			$mail->Password = $email_senha;
			$mail->From = $email_origem;
			$mail->FromName = $email_nome;
			$mail->AddAddress($email_testes_destino, "");
			$mail->WordWrap = 50;
			$mail->IsHTML(true);
			$mail->Subject = "Teste de envio";
			$mail->Body = "<div>E-mail de teste</div>";

			
			if($mail->Send()){
				$this->msg('Teste realizado com sucesso!');
			} else {
				$this->msg('Ocorreu um erro: '.$mail->ErrorInfo);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/smtp');
	}

	function send_email_($Email){
		$sender = 'drekehrer@gmail.com';
		$recipient = 'drekehrer@gmail.com';

		$subject = "php mail test";
		$message = "php test message";
		$headers = 'From:' . $sender;

		if (mail($recipient, $subject, $message, $headers)){
			echo "Message accepted";
			exit;
		}else{
			echo "Error: Message not accepted";
			exit;
		}
	}

	public function apagar_logo(){

		$this->nivel_acesso(38);

		// instancia
		$config = new model_config();

		$data = $config->carrega_config();

		if($data->logo){
			unlink('../arquivos/img_logo/'.$data->logo);
		}

		$config->altera_logo("");

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/imagem');
	}

	public function logo(){

		$this->nivel_acesso(38);

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		// instancia
		$config = new model_config();
		$arquivo = new model_arquivos_imagens();	

		//// Definicao de Diretorios / 
		$diretorio = "../arquivos/img_logo/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {	

			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			$destino = $diretorio.$nome_arquivo;

			if(copy($tmp_name, $destino)){
				
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					// foto grande
					$largura_g = 500;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);
					
					//redimenciona
					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g, $diretorio.$nome_arquivo);					
				}

				$config->altera_logo($nome_arquivo);				

				$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/imagem');

			} else {					
				$this->msg('Não foi possível copiar o arquivo!');
				$this->volta(1);
			}

		}

	}


	// MASCARA

	public function nova_mascara(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova Marca d'água";

		$this->view('config.mascara.nova', $dados);
	}

	public function nova_mascara_grv(){

		$titulo = $this->post('titulo');
		$posicao = $this->post('posicao');
		$preencher = $this->post('preencher');
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$this->valida($titulo);

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		$mascara = new model_mascara();

		//// Definicao de Diretorios / 
		$diretorio = "../arquivos/img_mascaras/";		 
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			$nome_original = $_FILES['arquivo']['name'];
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			$destino = $diretorio.$nome_arquivo;
			
			if(copy($tmp_name, $destino)){

				$codigo = $this->gera_codigo();

				$mascara->adiciona(array(
					$codigo,
					$titulo,
					$nome_arquivo,
					$posicao,
					$preencher
				));

				$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/mascara');

			} else {
				$this->msg('Não foi possível copiar o arquivo!');
				$this->volta(1);
			}

		}
	}	

	public function alterar_mascara(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Marca d'água";

		$codigo = $this->get('codigo');

		$mascara = new model_mascara();
		$dados['data'] = $mascara->carrega($codigo);

		$this->view('config.mascara.alterar', $dados);

	}

	public function alterar_mascara_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$posicao = $this->post('posicao');
		$preencher = $this->post('preencher');
		
		$this->valida($codigo);
		$this->valida($titulo);
		
		$mascara = new model_mascara();

		$mascara->altera(array(
			$titulo,
			$posicao,
			$preencher
		), $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/mascara');
	}

	public function apagar_mascara(){
		
		$mascara = new model_mascara();

		foreach ($mascara->lista() as $key => $value) {			 
			
			if($this->post('apagar_'.$value['id']) == 1){
				
				unlink('../arquivos/img_mascaras/'.$value['imagem_nome']);
				
				$mascara->apagar($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/mascara');
	}
		
}