<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title><?=$_titulo?> - <?=TITULO_VIEW?></title>
  <link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
  
  <link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=LAYOUT?>api/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">   
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>api/uploadfy/css/uploadify.css" type="text/css" />
  <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  
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

     <!-- Main content -->
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
                  <label class="col-md-12">Setor <?=ajuda('Posição do banner, não é possível alterar.');?></label>
                  <div class="col-md-6">
                    <select name="grupo" class="form-control select2" style="width: 100%;" disabled="" >
                      <?php
                      foreach ($grupos as $key => $value) {

                        if($value['codigo'] == $data->grupo){
                          $selected = " selected ";
                        } else {
                          $selected = "";
                        }
                        
                        echo "<option value='".$value['codigo']."' ".$selected.">".$value['titulo']."</option>";
                        
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12" >Titulo <?=ajuda('O titulo não aparece no site');?></label>
                  <div class="col-md-8">
                   <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
                 </div>
               </div>

               <div class="form-group">
                <label class="col-md-12" >Frase (opcional)</label>
                <div class="col-md-8">
                  <textarea name="texto" class="summernote" ><?=$data->texto?></textarea>
                </div>
              </div>

              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-md-12" >Link Padrão</label>
                    <div class="col-md-12">
                      <select name="endereco_padrao" class="form-control select2" style="width: 100%;" >
                        <option value='' selected='' >Personalizado</option>
                        <?php
                        foreach ($destinos as $key => $value) {

                          if($data->endereco == $value['chave']){ $selected = " selected='' "; } else { $selected = ""; }

                          echo "<option value='".$value['chave']."' $selected >".$value['titulo']."</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-md-12" >Estilo do botão</label>
                    <div class="col-md-12">
                      <select name="botao_codigo" class="form-control select2" style="width: 100%;" > 
                        <option value='' selected='' >Não mostrar botão</option>
                        <?php
                        foreach ($botoes as $key => $value) {

                          if($data->botao_codigo == $value['codigo']){ $selected = " selected='' "; } else { $selected = ""; }

                          echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-md-12" >Alinhamento do botão</label>
                    <div class="col-md-12">
                      <select name="botao_alinhamento" class="form-control select2" style="width: 100%;" > 
                        <option value='left' <?php if($data->botao_alinhamento == 'left'){ echo " selected='' "; } ?> >Esquerda</option>
                        <option value='right' <?php if($data->botao_alinhamento == 'right'){ echo " selected='' "; } ?> >Direita</option>
                        <option value='center' <?php if($data->botao_alinhamento == 'center'){ echo " selected='' "; } ?> >Centro</option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>              

              <div class="form-group">
                <label class="col-md-12" >Link Personalizado <?=ajuda('Link de destino quando clicar no banner (opcional).')?></label>
                <div class="col-md-8">
                  <input name="endereco" type="text" class="form-control" value="<?=$data->endereco?>" >
                </div>
              </div>

            </fieldset>

            <div>
              <button type="submit" class="btn btn-primary">Salvar</button>
              <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
              <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial/grupo/<?=$data->grupo?>';" >Voltar</button>
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
                <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial/grupo/<?=$data->grupo?>';" >Voltar</button>
              </div>

            </form>
          <?php } else { ?>

            <div style="text-align:left;">
              <img src="<?=PASTA_CLIENTE?>img_banners/<?=$data->imagem?>" style="max-width:300px;" >
            </div>
            
            <div style="text-align:left; padding-top:10px; ">
              <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>apagar_imagem/codigo/<?=$data->codigo?>');" >Apagar Imagem</button>
              <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial/grupo/<?=$data->grupo?>';" >Voltar</button>
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
<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="<?=LAYOUT?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=LAYOUT?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?=LAYOUT?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
<script src="<?=LAYOUT?>dist/js/demo.js"></script>
<script src="<?=LAYOUT?>api/uploadfy/js/swfobject.js"></script>
<script src="<?=LAYOUT?>api/uploadfy/js/jquery.uploadify.v2.1.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>
<script>

  $(document).ready(function() {

    $(".select2").select2();

  });

</script>
<script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>

<?php include_once('js_summernote.php'); ?>