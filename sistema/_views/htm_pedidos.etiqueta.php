<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title><?=TITULO_VIEW?></title>
  <link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
  
  <link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">

  <?php include_once('css.php'); ?>

  <style>
  
  body {
    background: #FFF;
  }

  .info{
    font-size:16px;
    color:#000;
    margin-top:10px;
  }

</style>

</head>
<body onload="self.print();" style="width:700px;" >

  <h2 class="panel-title" style="font-size:18px; padding-bottom: 10px; padding-top: 20px;"><strong>DESTINATÁRIO</strong></h2>

  <?php if($data_cadastro->fisica_nome){ ?>
    <div class="infos"><strong><?=$data_cadastro->fisica_nome?></strong></div>
  <?php } ?>

  <?php if($data_cadastro->juridica_razao){ ?>
    <div class="infos"><strong><?=$data_cadastro->juridica_razao?></strong></div>
  <?php } ?>

  <div class="infos"><strong>Endereço:</strong> <?=$data_cadastro->endereco?>, <?=$data_cadastro->numero?> - <?=$data_cadastro->complemento?></div>

  <div class="infos"><strong>Bairro:</strong> <?=$data_cadastro->bairro?></div>

  <div class="infos"><strong>Cidade:</strong> <?=$data_cadastro->cidade?> - <?=$data_cadastro->estado?></div>

  <div class="infos"><strong>Cep:</strong> <?=$data_cadastro->cep?></div>

  <!-- jQuery 2.2.3 -->
  <script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
</body>
</html>