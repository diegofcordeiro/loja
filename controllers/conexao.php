<?php
$mysqli = new mysqli("localhost", "root", "root", "webapp");

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
$mysqli->set_charset("utf8");

$conn = new mysqli("localhost", "root", "root", "loja");

if ($conn->connect_errno) {
  echo "Failed to connect to MySQL: " . $conn->connect_error;
  exit();
}
$conn->set_charset("utf8");

// $sql = "SELECT * FROM usuario ";
// echo'<pre>';
// if ($result = $mysqli->query($sql)) {
//   while ($obj = $result->fetch_object()) {
//     printf("%s (%s)\n", $obj->nome, $obj->cpf);
//   }
//   $result->free_result();
// }

// $mysqli->close();
