<?php

Class model_logs extends model{	
     
	public function gravar($arquivo, $texto){
		
		$data = date('d-m-y');
		$hora = date('H:i:s');
		//Nome do arquivo:
		$arquivo = "../arquivos/logs/$arquivo";
		//Texto a ser impresso no log:
		$texto = "[$data][$hora] > ".utf8_decode($texto)." \n";
		$manipular = fopen("$arquivo", "a+b");
		fwrite($manipular, $texto);
		fclose($manipular);   
	}
    
}