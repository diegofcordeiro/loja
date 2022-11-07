<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>
  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <title>Erro - <?=TITULO_VIEW?></title>
  <link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
  
  <link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">

  <?php include_once('css.php'); ?>
  
</head>
<body class="hold-transition login-page">

  <?php require_once('htm_modal.php'); ?>
  
  <div class="login-box">
    <div class="login-logo">
      <img src="<?=$_base['logo']?>" style="max-height:40px;" >
    </div> 
    <div style="padding-top:50px; padding-bottom: 100px; text-align:center; font-size:20px; color:#fff;">Página não disponível!</div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery 2.2.3 -->
  <script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>