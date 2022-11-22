<?php
$mysqli = new mysqli("dbdentalguru.cgxcqb2rk2kb.us-east-1.rds.amazonaws.com","dtguru","DtGURU495051","dentalguru");

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
 $mysqli->set_charset("utf8");

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