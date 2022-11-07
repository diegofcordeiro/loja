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
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
  
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





           <section class="panel">

             <form action="<?=$_base['objeto']?>exportar" class="form-horizontal" method="post">

              <div class="panel-body">

               <fieldset>

                <div class="form-group">
                  <label class="col-md-12">Formato</label>
                  <div class="col-md-6">
                    <select name="formato" class="form-control select2" style="width: 100%;" >
                      <option value='' selected='' >Selecione</option>
                      <option value='1' <?php if($formato == 1){ echo "selected=''"; } ?> >Separados por ponto e virgula ( ; )</option>
                      <option value='2' <?php if($formato == 2){ echo "selected=''"; } ?> >Separados por virgula ( , )</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Grupos</label>
                  <div class="col-md-6">
                    <select name="grupo" class="form-control select2" style="width: 100%;" >
                      <?php

                      foreach ($grupos as $key => $value) {

                        if($value['codigo'] == $grupo_selecionado){
                          echo "<option value='".$value['codigo']."' selected='' >".$value['titulo']."</option>"; 
                        } else {
                          echo "<option value='".$value['codigo']."' >".$value['titulo']."</option>";
                        }

                      }

                      ?>
                    </select>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Exportar</button>

                <?php if($mostrar_lista){ ?>
                  <hr>

                  <div class="form-group">
                    <label class="col-md-12" >Lista exportada</label>
                    <div class="col-md-12">
                      <textarea name="lista" id="lista" class="form-control" style="height:150px;" ><?=$lista_exportada?></textarea>
                    </div>
                  </div>

                <?php } ?>

              </fieldset>      

            </div>

          </form>    

          <div class="panel-footer">
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>
              </div>
            </div>
          </div>

        </section>



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

<!-- jQuery 2.2.3 -->
<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
<script src="<?=LAYOUT?>dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {

    $(".select2").select2();

    $('#tabela1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
    
  });
    
  $('#lista').click(function(){
    $('#lista').select();
  });

</script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>
<script src="<?=LAYOUT?>js/ajuda.js"></script> 
</body>
</html>