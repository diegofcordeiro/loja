<?php
class recuperar extends controller {
	
	public function init(){
	}

	public function inicial(){
		
		$dados = array();
		$dados['_base'] = $this->base();
		
		$this->view('recuperar', $dados);		
	}
	
	protected function enviar(){
		
		//confere se foi digitado
		$valida = new model_valida();
		
		$email = $this->post('email');
		if(!$valida->email($email)){
			$this->msg('E-mail inválido!');
			$this->volta(1);
		}
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM adm_usuario WHERE email_recuperacao='$email' ");
		if($exec->num_rows != 0){

			$lista_de_contas = '';
			$conta_n = 0;
			while($data_users = $exec->fetch_object()){
				
				$rand = rand(1000, 10000);
				$cod_recuperacao = md5($data_users->codigo.$rand);
				$cod_recuperacao = str_replace(array("/"," ","?","#","="), "", $cod_recuperacao);
				
				$db = new mysql();
				$altera = $db->alterar("adm_usuario", array(
					"recuperacao"=>$cod_recuperacao
				), " id='$data_users->id' ");
				
				$conta_n++;
				
				$link_recuperacao = DOMINIO."recuperar/alterar_senha/key/".$cod_recuperacao;

				$lista_de_contas .= "
				<div style='font-size:13px; color:#000;'><p></p></div>
				<div style='font-size:13px; color:#000;'><p>---</p></div>
				<div style='font-size:13px; color:#000;'><p><strong>Link Para Recuperação Conta $conta_n:</strong> $link_recuperacao</p></div>
				";

			}

			$msg = "
			<div style='font-size:13px; color:#000;'><p><strong>Solicitação de recuperação de senha </strong></p></div>
			<div style='font-size:13px; color:#000;'><p></p></div>
			<div style='font-size:13px; color:#000;'><p>Foram emcontrada(s) $conta_n conta(s) vinculadas a este e-mail!</p></div>
			$lista_de_contas
			<div style='font-size:13px; color:#000;'><p>-</p></div>
			<div style='font-size:13px; color:#000;'><p>Caso não tenha solicitado esta recuperação de conta. não se preocupe basta ignorar este e-mail</p></div>
			<div style='font-size:13px; color:#000;'><p>-</p></div>
			<div style='font-size:13px; color:#000;'><p>Este e-mail foi gerado automáticamente, por favor não responda.</p></div>
			";

			$enviar = new model_envia_email();
			$enviar->destino($email);
			$enviar->assunto("Alterar Senha");
			$enviar->conteudo($msg);

			if($enviar->enviar()){
				$this->msg('O email de recuperação de conta foi enviado com sucesso!');
			} else {
				$this->msg('Ocorreu um erro ao enviar email, tente novamente mais tarde!');
			}

			$this->irpara(DOMINIO."autenticacao");

		} else {
			$this->msg('Não encontramos nenhuma conta vinculada a este e-mail!');
			$this->volta(1);
		}

 	}

 	public function alterar_senha(){
 		
 		$dados = array();
		$dados['_base'] = $this->base();

 		$key = $this->get('key');
 		$this->valida($key);

 		$db = new mysql();
		$exec = $db->executar("SELECT * FROM adm_usuario WHERE recuperacao='".$key."' ");
		if($exec->num_rows == 1){

			$dados['key'] = $key;			
			$this->view('recuperar.alterar.senha', $dados);	

		} else {
			$this->msg('Endereço inválido!');
			$this->irpara(DOMINIO);
		}
 	}

 	public function alterar_senha_grv(){
 		
 		$key = $this->post('key');
 		$usuario = $this->post('usuario');
 		$senha1 = $this->post('senha1');
 		$senha2 = $this->post('senha2');

 		$this->valida($key);
 		$this->valida($usuario);
 		$this->valida($senha1);
 		$this->valida($senha2);

 		// confere senhas

 		if($senha1 != $senha2){
 			$this->msg('As senhas não coincidem!');
			$this->volta(1);
 		}

 		$db = new mysql();
		$exec = $db->executar("SELECT * FROM adm_usuario WHERE recuperacao='$key' ");
		if($exec->num_rows == 1){
			
			$usuario_md5 = md5($usuario);
			$senha_md5 = md5($senha1);
			
			$db = new mysql();
			$exec = $db->executar("SELECT * FROM adm_usuario WHERE usuario='$usuario_md5' AND recuperacao!='$key' ");
			if($exec->num_rows == 0){
				
				$db = new mysql();
				$altera = $db->alterar("adm_usuario", array(
					"usuario"=>$usuario_md5,
					"senha"=>$senha_md5,
					"recuperacao"=>""
				), " recuperacao='$key' ");
				
				$this->msg('Senha alterada com sucesso!');
				$this->irpara(DOMINIO);
				
			} else {
				$this->msg('Este usuário já esta sendo utilziado!');
				$this->volta(1);
			}
			
		} else {
			$this->msg('Algo deu errado!');
			$this->irpara(DOMINIO);
		}
 	}
}