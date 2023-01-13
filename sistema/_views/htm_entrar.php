<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <title>Entrar - <?=TITULO_VIEW?></title>
  <link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
  
  <link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/iCheck/square/blue.css">
  
  <?php include_once('css.php'); ?>
  <style>
    body{
    background-image: url('<?php $banner_admin ?>') !important;
    background-repeat: no-repeat !important;
    background-position: center center !important;
    background-size: cover !important;
    }
    .login-box-body, .register-box-body {
        background: #ffffffa3 !important;
        padding: 20px;
        border-top: 0;
        border-radius: 30px !important;
        color: #666;
    }
  </style>

</head>
<body class="hold-transition login-page" style="">

  <?php require_once('htm_modal.php'); ?>
  
  <div class="login-box">
    <div class="login-logo">
      <img src="<?=$_base['logo']?>" style="max-height:100px;" >
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg"></p>

      <form action="<?=DOMINIO?>autenticacao/login" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Usuário" name="usuario">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Senha" name="senha">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div style="padding-top:5px;"><a href="<?=DOMINIO?>recuperar">Esqueci minha senha!</a></div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <script src="<?=LAYOUT?>dist/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?=LAYOUT?>dist/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=LAYOUT?>dist/iCheck/icheck.min.js"></script>
  <script type="text/javascript">
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue'
    });
  </script>

  <script src="<?=LAYOUT?>js/ajuda.js"></script>

</body>
</html>
