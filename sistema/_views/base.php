<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; }

function ajuda($texto){
  echo "<span class='botao_ajuda' data-content='$texto' ><i class='fa fa-question-circle'></i></span>";
}