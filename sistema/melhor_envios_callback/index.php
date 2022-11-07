<?php

function get($string) {
	$string = str_replace(array("<", ">", "\\", "?", "#"), "", $_GET[$string]);
	$string = strip_tags($string);
	$string = addslashes($string);
	$string = ($string == null ? 'inicial' : $string);
	$string = trim($string);
	return $string;
}

$code = get('code');

if($code){
	$new_url = "https://" . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$explode = explode('melhor_envios_callback', $new_url);
	$new_url = $explode[0].'entrega/melhor_envios_callback/code/'.$code;
	header('Location: '.$new_url);
}