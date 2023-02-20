<?php

require_once("api/phpmailer/PHPMailer.php");
require_once("api/phpmailer/SMTP.php");
require_once("api/phpmailer/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

Class model_envio extends model{
	
	public function enviar($assunto, $msg, $emails_destino, $email_resposta = null, $anexos = array()){
		
		$retorno = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM adm_config WHERE id='1' ");
		$data_config = $exec->fetch_object();

		$mail = new PHPMailer(true);
		try {
			    //Server settings
			    $mail->SMTPDebug = 0; // usar 2 para debug 
			    $mail->isSMTP();                                      // Set mailer to use SMTP
			    $mail->Host = $data_config->email_host;  // Specify main and backup SMTP servers
			    $mail->SMTPAuth = true;                               // Enable SMTP authentication
			    $mail->Username = $data_config->email_usuario;                 // SMTP username
			    $mail->Password = $data_config->email_senha;                       // SMTP password
			    $mail->SMTPSecure = 'TLS';                         // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $data_config->email_porta;
			    $mail->setFrom($data_config->email_origem, $data_config->email_nome);
			    
			    foreach ($emails_destino as $key => $value) {
			    	$mail->addAddress($value, '');
			    }
			    
			    if($email_resposta){
			    	$mail->addReplyTo($email_resposta, '');
			    }
			    // anexos
			    foreach ($anexos as $key => $value) {
			    	$mail->addAttachment($value); 
			    } 
			    
			    //Content
			    $mail->isHTML(true); // Set email format to HTML
			    $mail->Subject = $assunto;
			    $mail->Body    = $msg;
			    //$mail->AltBody = '';

			    if($mail->send()){
			    	$retorno['msg'] = "Mensagem enviada com sucesso!";
			    	$retorno['status'] = 1;
			    } else {
			    	$retorno['msg'] = "Erro ao enviar mensagem! ".$mail->ErrorInfo;
			    	$retorno['status'] = 0;
			    }

			} catch (Exception $e) {
				$retorno['msg'] = "Erro ao enviar mensagem! ".$mail->ErrorInfo;
				$retorno['status'] = 0;
			}
			
			return $retorno;
		}

	}