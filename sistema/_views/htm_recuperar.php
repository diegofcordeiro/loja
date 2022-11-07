<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <title>Recuperar - <?=TITULO_VIEW?></title>
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
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Entre com o e-mail cadastrado no sistema.</p>

      <form action="<?=DOMINIO?>recuperar/enviar" method="post">

        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="E-mail" name="email">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Redefinir</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>

  <script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>