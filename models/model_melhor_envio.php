<?php

Class model_melhor_envio extends model{     

	// private $endpoint = "https://sandbox.melhorenvio.com.br";
	private $endpoint = "https://www.melhorenvio.com.br";

	private function pega_token(){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM frete WHERE id='5' ");
		$data = $exec->fetch_object();

		if($data->melhor_envio_token){

			$validade = $this->validade_token($data->melhor_envio_token);

			$limitedia = strtotime('-10 days', $validade);

			if(time() <= $limitedia){
				return $data->melhor_envio_token;
			} else {
				$token_novo = $this->renova_token();
				return $token_novo;
			}
			
		} else {
			return false;
		}
	}

	private function pega_token2(){
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM frete WHERE id='5' ");
		$data = $exec->fetch_object();
		
		if($data->melhor_envio_token_fixo){		 
			return $data->melhor_envio_token_fixo;
		} else {
			echo "Ocorreu um erro, 1001!";
			exit;
		}
		
	}

	public function renova_token(){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM frete WHERE id='5' ");
		$data = $exec->fetch_object();

		if($data->melhor_envio_token_r){
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->endpoint."/oauth/token",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => array('grant_type' => 'refresh_token','refresh_token' => $data->melhor_envio_token_r,'client_id' => $data->melhor_envio_id,'client_secret' => $data->melhor_envio_secret),
				CURLOPT_HTTPHEADER => array(
					"Accept: application/json",
					"User-Agent: NuvemServ (alvanisio@gmail.com)"
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$retorno = json_decode($response);

			// echo "<pre>"; print_r($retorno); echo "</pre>";

			if(isset($retorno->access_token)){

				$token = $retorno->access_token;
				$refresh_token = $retorno->refresh_token;

				$db = new mysql();
				$db->alterar('frete', array( 
					'melhor_envio_token'=>$token,
					'melhor_envio_token_r'=>$refresh_token
				), " id='5' ");

			}

			return $token;

		} else {
			echo "Erro no token de acesso do Melhor Envios!";
			exit;
		}
	}

	public function validade_token($token){

		$tokenParts = explode('.', $token);

		$tokenHeader = json_decode(base64_decode($tokenParts[0]));
		$tokenPayload = json_decode(base64_decode($tokenParts[1]));
		$tokenSignature = $tokenParts[2];

		// $tokenExpirationDate = date('l jS \of F Y h:i:s A', $tokenPayload->exp);
		// echo 'validade: '.$tokenExpirationDate; exit;

		return $tokenPayload->exp;
	}

	public function calculo_produtos($origem, $destino, $itens){

		// echo $this->info_app();

		$token = $this->pega_token2();

		$produtos = "";
		foreach ($itens as $key => $value) {

			$produtos .= "
			\n{\n
				\"id\": \"".$value['id']."\",\n
				\"width\": ".$value['largura'].",\n
				\"height\": ".$value['altura'].",\n
				\"length\": ".$value['comprimento'].",\n
				\"weight\": ".$value['peso'].",\n
				\"insurance_value\": ".$value['valor'].",\n
				\"quantity\": ".$value['quantidade']."\n
			},";

		}

		$produtos = substr($produtos, 0, strlen($produtos)-1);

		$conteudo = "{\n    \"from\": {\n        \"postal_code\": \"$origem\"\n    },\n    \"to\": {\n        \"postal_code\": \"$destino\"\n    },\n    \"products\": [\n";
		$conteudo .= $produtos;
		$conteudo .= " ]\n}";
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL =>  $this->endpoint."/api/v2/me/shipment/calculate",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>$conteudo,
			CURLOPT_HTTPHEADER => array(
				"Accept: application/json",
				"Content-Type: application/json",
				"Authorization: Bearer {$token}",
				"User-Agent: NuvemServ (alvanisio@gmail.com)"
			),
		));		 

		$response = curl_exec($curl);
		
		curl_close($curl); 

		$retorno = json_decode($response);
		
		//echo "<pre>"; print_r($retorno); echo "</pre>";
		// exit;

		$lista = array();
		$n = 0;

		foreach ($retorno as $key => $value) {
			if(isset($value->price)){		
				if($value->price > 0){

					$lista[$n]['id'] = $value->id;
					$lista[$n]['titulo'] = $value->name;
					$lista[$n]['valor'] = $value->price;
					$lista[$n]['obs'] =  'Pacote:<br>Largura: '.$value->packages[0]->dimensions->width.'<br>Altura: '.$value->packages[0]->dimensions->height.'<br>Comprimento:'.$value->packages[0]->dimensions->length.'<br>Peso: '.$value->packages[0]->weight;

					$n++;
				}
			}
		}

		// echo "<pre>"; print_r($lista); echo "</pre>";
		return $lista;
		
	}

	public function calculo_pacote($origem, $destino, $altura, $largura, $comprimento, $peso, $valor_declarado){

		//echo $this->info_app();

		$token = $this->pega_token2(); 

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->endpoint."/api/v2/me/shipment/calculate",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>'{
				"from": {
					"postal_code": "'.$origem.'"
					},
					"to": {
						"postal_code": "'.$destino.'"
						},
						"package": {
							"height": '.$altura.',
							"width": '.$largura.',
							"length": '.$comprimento.',
							"weight": '.$peso.'
							},
							"options": {
								"insurance_value": '.$valor_declarado.',
								"receipt": false,
								"own_hand": false
							}
						}',
						CURLOPT_HTTPHEADER => array(
							"Accept: application/json",
							"Content-Type: application/json",
							"Authorization: Bearer {$token}",
							"User-Agent: NuvemServ (alvanisio@gmail.com)"
						)
					));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

		$retorno = json_decode($response);
		echo "<pre>"; print_r($retorno); echo "</pre>"; exit;


	}

	public function info_app(){

		$token = $this->pega_token();

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->endpoint."/api/v2/me/shipment/app-settings",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Accept: application/json",
				"Authorization: Bearer {$token}"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		echo $response;

	}

}