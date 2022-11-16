<?php
$mysqli = new mysqli("tasdev.vpshost5501.mysql.dbaas.com.br","tasdev","TasDEV495051@","tasdev");

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}

// $sql = "SELECT * FROM usuario ";
// echo'<pre>';
// if ($result = $mysqli->query($sql)) {
//   while ($obj = $result->fetch_object()) {
//     printf("%s (%s)\n", $obj->nome, $obj->cpf);
//   }
//   $result->free_result();
// }

// $mysqli->close();
?>