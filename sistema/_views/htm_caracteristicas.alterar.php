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
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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

    <?php require_once('htm_modal.php'); ?>
    
    <?php require_once('htm_topo.php'); ?>
    
    <?php require_once('htm_menu.php'); ?>
    
    <div class="content-wrapper">

      <section class="content-header">
        <h1>
          <?=$_titulo?>
          <small><?=$_subtitulo?></small>
        </h1> 
      </section>

      <section class="content">
        <div class="row">        	
          <div class="col-xs-12">

            <div class="nav-tabs-custom">

              <ul class="nav nav-tabs">

                <li <?php if($aba_selecionada == "dados"){ echo "class='active'"; } ?> >
                  <a href="#dados" data-toggle="tab">Dados</a>
                </li>
                <li <?php if($aba_selecionada == "imagem"){ echo "class='active'"; } ?> >
                  <a href="#imagem" data-toggle="tab">Imagens</a>
                </li>

              </ul>

              <div class="tab-content" >

                <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">  						

                    <fieldset> 

                      <div class="form-group">
                        <label class="col-md-12" >Titulo</label>
                        <div class="col-md-7">
                          <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-md-12" >Icone</label>
                        <div class="col-md-7">
                          <textarea name="icone" class="form-control" style="height: 32px;"><?=$data->icone?></textarea>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-md-12" >Alinhamento</label>
                        <div class="col-md-7">
                          <select name="alinhamento" class="form-control select2" style="width: 100%;" >
                            <option value='center' <?php if($data->alinhamento == 'center'){ echo " selected='' "; } ?> >Centro</option>
                            <option value='left' <?php if($data->alinhamento == 'left'){ echo " selected='' "; } ?> >Esquerda</option>
                            <option value='right' <?php if($data->alinhamento == 'right'){ echo " selected='' "; } ?> >Direita</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-md-12">Conteúdo</label>
                        <div class="col-md-12">
                          <textarea name="conteudo" class="summernote"  ><?=$data->conteudo?></textarea>
                        </div>
                      </div>

                    </fieldset>

                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  </form>
                </div>

                <div id="imagem" class="tab-pane <?php if($aba_selecionada == "imagem"){ echo "active"; } ?>" >
                  <?php if(!$data->imagem){ ?>
                    <form action="<?=$_base['objeto']?>imagem/codigo/<?=$data->codigo?>" method="post" enctype="multipart/form-data">

                      <fieldset> 
                        <label>Arquivo</label> 
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                          <div class="input-append">
                            <div class="uneditable-input">
                              <i class="fa fa-file fileupload-exists"></i>
                              <span class="fileupload-preview"></span>
                            </div>
                            <span class="btn btn-default btn-file">
                              <span class="fileupload-exists">Alterar</span>
                              <span class="fileupload-new">Procurar arquivo</span>
                              <input type="file" name="arquivo" />
                            </span>
                            <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
                          </div>
                        </div>
                      </fieldset>

                      <div style="text-align:left; padding-top:10px;">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                      </div>

                    </form>
                  <?php } else { ?>

                    <div style="text-align:left;">
                      <img src="<?=PASTA_CLIENTE?>img_caracteristicas/<?=$data->imagem?>" style="max-width:300px;" >
                    </div>
                    
                    <div style="text-align:left; padding-top:10px;">
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>apagar_imagem/codigo/<?=$data->codigo?>');" >Apagar Imagem</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                    
                  <?php } ?>

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
    <script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
    <script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
    <script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
    <script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="<?=LAYOUT?>dist/js/app.min.js"></script>
    <script src="<?=LAYOUT?>dist/js/demo.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    
    <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
    <script src="<?=LAYOUT?>js/funcoes.js"></script>
    <script src="<?=LAYOUT?>js/ajuda.js"></script> 

    <?php include_once('js_summernote.php'); ?>

  </body>
  </html>