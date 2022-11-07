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
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">

  <?php include_once('css.php'); ?>

  <style type="text/css">

/**
 * Nestable
 */
 .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
 .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
 .dd-list .dd-list { padding-left: 30px; }
 .dd-collapsed .dd-list { display: none; }
 .dd-item,
 .dd-empty,
 .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
 .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
  background: #fafafa;
  background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
  background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
  background:         linear-gradient(top, #fafafa 0%, #eee 100%);
  -webkit-border-radius: 3px;
  border-radius: 3px;
  box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }
.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }
.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
  background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
  -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
  -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
  linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-size: 60px 60px;
  background-position: 0 0, 30px 30px;
}
.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
  -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
  box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}
/**
 * Nestable Extras
 */
 .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }
 #nestable-menu { padding: 0; margin: 20px 0; }
 #nestable-output,
 #nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }
 #nestable2 .dd-handle {
  color: #fff;
  border: 1px solid #999;
  background: #bbb;
  background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
  background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
  background:         linear-gradient(top, #bbb 0%, #999 100%);
}
#nestable2 .dd-handle:hover { background: #bbb; }
#nestable2 .dd-item > button:before { color: #fff; }
@media only screen and (min-width: 700px) {
  .dd { float: left; width: 48%; }
  .dd + .dd { margin-left: 2%; }
}
.dd-hover > .dd-handle { background: #2ea8e5 !important; }
/**
 * Nestable Draggable Handles
 */
 .dd3-content {
   display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 120px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
   background: #fafafa;
   background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
   background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
   background:         linear-gradient(top, #fafafa 0%, #eee 100%);
   -webkit-border-radius: 3px;
   border-radius: 3px;
   box-sizing: border-box; -moz-box-sizing: border-box;
 }
 .dd3-content:hover { color: #2ea8e5; background: #fff; }
 .dd-dragel > .dd3-item > .dd3-content { margin: 0; }
 .dd3-item > button { margin-left: 30px; }
 .dd3-handle {
   position: absolute;
   margin: 0;
   left: 0;
   top: 0;
   cursor: pointer;
   width: 35px;
   white-space: nowrap;
   overflow: hidden;
   border: 1px solid #aaa;
   background: #CCC;
   border-top-right-radius: 0;
   border-bottom-right-radius: 0;
   color:#FFF;
   text-align: center;
   font-size: 11px;
 }
 .dd3-handle:hover { background: #ddd; }

 .dd3-content-editar {
   position: absolute;
   margin: 0;
   left: 34px;
   top: 0;
   cursor: pointer;
   width: 35px;
   height: 30px;
   padding: 5px 10px 5px 10px;
   white-space: nowrap;
   overflow: hidden;
   border: 1px solid #aaa;
   background: #CCC;
   border-top-right-radius: 0;
   border-bottom-right-radius: 0;
   color:#FFF;
   text-align: center;
   font-size: 11px;
 }
 .dd3-content-editar:hover { color: #2ea8e5; background: #ddd; }

 .dd3-content-apagar {
   position: absolute;
   margin: 0;
   left: 67px;
   top: 0;
   cursor: pointer;
   width: 35px;
   height: 30px;
   padding: 5px 10px 5px 10px;
   white-space: nowrap;
   overflow: hidden;
   border: 1px solid #aaa;
   background: #CCC;
   border-top-right-radius: 0;
   border-bottom-right-radius: 0;
   color:#FFF;
   text-align: center;
   font-size: 12px;
 }
 .dd3-content-apagar:hover { color: #2ea8e5; background: #ddd; }

</style>

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
        <div class="col-md-12">
          <!-- box -->
          <div class="box">
            <div class="box-body">

              <div>
               <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>nova_categoria', 'Nova Categoria');">Nova Categoria</button>
               <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
             </div>

             <hr>

             <div style="padding-bottom:20px;" >Voc&ecirc; pode arrastar para cima e para baixo para ordenar e para os lados para sub-categoria.</div>

             <div class="dd" id="nestable">                    
              <?php

              function montaCategoriasView($id_pai, $categorias){

                echo '<ol class="dd-list">';

                foreach ($categorias as $key => $value) {

                  if($value['id_pai'] == $id_pai){

                   echo '<li class="dd-item dd3-item" data-id="'.$value['id'].'" >';

                   echo '
                   <div class="dd-handle dd3-handle" ><i class="fas fa-arrows-alt"></i></div>
                   <div class="dd3-content-editar" onClick="modal(\''.DOMINIO.'produtos/alterar_categoria/codigo/'.$value['codigo'].'\', \'Alterar Categoria\');" ><i class="far fa-edit"></i></div>
                   <div class="dd3-content-apagar" onClick="confirma(\''.DOMINIO.'produtos/apagar_categoria/codigo/'.$value['codigo'].'\');" ><i class="fas fa-trash"></i></div>
                   <div class="dd3-content">'.$value['titulo'].'</div>';

                   montaCategoriasView($value['id'], $value['subcategorias']);

                   echo '</li>';
                 }

               }

               echo '</ol>';
             }
             montaCategoriasview(0, $categorias);

             ?>
           </div>

           <div style="clear: both; padding-top:5px;"><hr></div>

           <div>
            <form action="<?=$_base['objeto']?>salva_ordem_categorias" method="post" >
              <input type="hidden" name="ordem" id="nestable-output" class="form-control">
              <button type="submit" class="btn btn-primary" >Salvar Ordem</button>
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

<!-- jQuery 2.2.3 -->
<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?=LAYOUT?>api/nestable/jquery.nestable.js"></script>
<script src="<?=LAYOUT?>api/nestable/examples.nestable.js"></script>
<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>
<script src="<?=LAYOUT?>api/jquery-nestable/jquery.nestable.js"></script>
<script src="<?=LAYOUT?>api/jquery-nestable/examples.nestable.js"></script>
<script src="<?=LAYOUT?>js/ajuda.js"></script>
</body>
</html>