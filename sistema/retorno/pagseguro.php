<?php 
require_once("../../_config.php");
$servername = "localhost";
$username = "root";
$password = "L!IRuv9z";
$dbname = "loja";
$conn = new mysqli($servername, $username, $password, $dbname);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = 'financeiro@zoombusiness.com.br';
    $token = '0FA44F019F824AFF9917B863CB3C1B1C';
    $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/".$_POST['notificationCode']."?email=".$email."&token=".$token;
    // $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/E4427B06107B107BB0200410DF8F5B28A742?email=".$email."&token=".$token;

    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
    $transaction_curl = curl_exec($curl);
    curl_close($curl);
    $transaction = simplexml_load_string(utf8_encode($transaction_curl));

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM pedido_loja";
$result = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach($result as $pedido){
    if($transaction->reference == $pedido['id_transacao']){
        
        // if($transaction->status == 3){
            $sql2 = "UPDATE pedido_loja SET `status` = 4 WHERE id_transacao = '$transaction->reference'";
            if ($conn->query($sql2) === TRUE) {
                echo "Record updated successfully";
            }
        // }
    }
}

}


?>