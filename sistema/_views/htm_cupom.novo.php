<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
  <title><?=$_titulo?> - <?=TITULO_VIEW?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<?php include_once('css.php'); ?>

</head>
<body class="hold-transition skin-blue <?php if($_base['menu_fechado'] == 1){ echo "sidebar-collapse"; } ?> sidebar-mini">
  <div class="wrapper">

   <?php require_once('htm_topo.php'); ?>

   <?php require_once('htm_menu.php'); ?>

   <div class="content-wrapper">

     <section class="content-header">
       <h1>
         <?=$_titulo?>
         <small><?=$_subtitulo?></small>
       </h1> 
     </section>

     <!-- Main content -->
     <section class="content">
       <div class="row">        	
         <div class="col-xs-12">
           



           <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
             
             <li <?php if($aba_selecionada == "dados"){ echo "class='active'"; } ?> >
              <a href="#dados" data-toggle="tab">Dados</a>
            </li>

          </ul>

          <div class="tab-content" >

           <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
             <form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">
              
              <fieldset>
                
                <div class="form-group">
                  <label class="col-md-12" >Titulo da Promoção</label>
                  <div class="col-md-6">
                    <input name="titulo" type="text" class="form-control" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12" >Valor Mínimo da Compra (R$)</label>
                  <div class="col-md-3">
                    <input name="valor_minimo" type="text" class="form-control" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" value="0,00" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12" >Desconto fixo (R$) no pedido</label>
                  <div class="col-md-3">
                    <input name="desconto_fixo" type="text" class="form-control" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" value="0,00">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12" >Desconto (%) no pedido</label>
                  <div class="col-md-3">
                    <input name="desconto_porc" ="text" class="form-control" size="5" maxlength="5" onkeypress="Mascara(this,porcentagem)" onKeyDown="Mascara(this,porcentagem)" value="0.00" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Utilizar somente 1 vez cada cupom</label>
                  <div class="col-md-3">
                    <select data-plugin-selectTwo class="form-control" name="tipo" >
                      <option value='0' selected >Sim</option>
                      <option value='1' >Não</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Enviar cupom quando o usuário se cadastrar</label>
                  <div class="col-md-3">
                    <select data-plugin-selectTwo class="form-control" name="cadastro" >
                      <option value='1' >Sim</option>
                      <option value='0' selected >Não</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12" >Usar Prefíxo</label>
                  <div class="col-md-6">
                    <input name="prefixo" type="text" class="form-control" >
                  </div>
                </div>

              </fieldset>

              <div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
              </div>
              
            </form>
          </div>

        </div>

      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<?php require_once('htm_rodape.php'); ?>

</div>
<!-- ./wrapper -->

<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
  <script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
  <script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
  <script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
  <script src="<?=LAYOUT?>dist/js/app.min.js"></script>
  <script src="<?=LAYOUT?>dist/js/demo.js"></script>
  <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
  <script src="<?=LAYOUT?>js/funcoes.js"></script>
  <script src="<?=LAYOUT?>js/ajuda.js"></script> 
  
</body>
</html>