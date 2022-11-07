<?php 
date_default_timezone_set('America/Sao_Paulo');
function curlExec($url, $post = NULL, array $header = array()){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if(count($header) > 0) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    if($post !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post, '', '&'));
    }
    //Ignore SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);

    curl_close($ch);

    return $data;
}
?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<?php 

// echo '<pre>';
$pref = $_POST['telefone'];
$tel  = $_POST['telefone'];
$pref = $pref[1].$pref[2];
$tel  = substr($tel, 5); 
$tel  = str_replace("-","",$tel);
$cpf  = str_replace("-","",$_POST['cpf']);
$cpf  = str_replace(".","",$cpf);

    $creditCardToken = htmlspecialchars($_POST["token"]);
    $senderHash = htmlspecialchars($_POST["senderHash"]);
    $id_transacao = htmlspecialchars($_POST["id_transacao"]);

    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    $shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
    $installmentValue = number_format($_POST["installmentValue"], 2, '.', '');
    $installmentsQty = $_POST["installments"];
    $PAGSEGURO_EMAIL = 'financeiro@zoombusiness.com.br';
    $PAGSEGURO_TOKEN = '0FA44F019F824AFF9917B863CB3C1B1C';


    $params = array(
        'email'                     => $PAGSEGURO_EMAIL,  
        'token'                     => $PAGSEGURO_TOKEN,
        'creditCardToken'           => $creditCardToken,
        'senderHash'                => $senderHash,
        'receiverEmail'             => $PAGSEGURO_EMAIL,
        'paymentMode'               => 'default', 
        'paymentMethod'             => 'creditCard', 
        'currency'                  => 'BRL',
        'itemId1'                   => '0001',
        'itemDescription1'          => 'Test',  
        'itemAmount1'               => $itemAmount,  
        'itemQuantity1'             => 1,
        'reference'                 => $id_transacao,
        'senderName'                => $_POST['nomeCompleto'],
        'senderCPF'                 => $cpf,
        'senderAreaCode'            => $pref,
        'senderPhone'               => $tel,
        'senderEmail'               => $_POST['email'],
        'shippingAddressStreet'     => $_POST['endereco'],
        'shippingAddressNumber'     => $_POST['numero'],
        'shippingAddressDistrict'   => $_POST['bairro'],
        'shippingAddressPostalCode' => $_POST['cep'],
        'shippingAddressCity'       => $_POST['estado'],
        'shippingAddressState'      => $_POST['cidade'],
        'shippingAddressCountry'    => 'BRA',
        'shippingType'              => 1,
        'shippingCost'              => $shippingCoast,
        'maxInstallmentNoInterest'      => 2,
        'noInterestInstallmentQuantity' => 2,
        'installmentQuantity'       => $installmentsQty,
        'installmentValue'          => $installmentValue,
        'creditCardHolderName'      => 'Chuck Norris',
        'creditCardHolderCPF'       => $cpf,
        'creditCardHolderBirthDate' => '01/01/1990',
        'creditCardHolderAreaCode'  => $pref,
        'creditCardHolderPhone'     => $tel,
        'billingAddressStreet'     => $_POST['endereco'],
        'billingAddressNumber'     => $_POST['numero'],
        'billingAddressDistrict'   => $_POST['bairro'],
        'billingAddressPostalCode' => $_POST['cep'],
        'billingAddressCity'       => $_POST['estado'],
        'billingAddressState'      => $_POST['cidade'],
        'billingAddressCountry'    => 'BRA'
    );
    // print_r($params);exit;
    $header = array('Content-Type' => 'application/json; charset=UTF-8;');
    $PAGSEGURO_API_URL = 'https://ws.sandbox.pagseguro.uol.com.br/v2';
    $response = curlExec($PAGSEGURO_API_URL."/transactions", $params, $header);
    // echo '<pre>';
    // print_r($response);
    // exit; 
    $json = json_decode(json_encode(simplexml_load_string($response)));
?>
<body>
    <h1>Pagseguro Test</h1>
    <h3><?php echo $_POST["installments"] . ' x R$ ' .$_POST["installmentValue"];?></h3>
    <h3>Code: <?php echo $json->code;?></h3>
    <h3>Status: <?php echo $json->status;?></h3>
    <p>Response: <?php print_r($json);  ?></p>
</body>
</html>