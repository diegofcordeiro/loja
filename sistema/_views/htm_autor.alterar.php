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
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?=LAYOUT?>docsupport/style.css">
  <link rel="stylesheet" href="<?=LAYOUT?>docsupport/prism.css">
  <link rel="stylesheet" href="<?=LAYOUT?>chosen.css">


  <?php include_once('css.php'); ?>
  <style>
    .conteudo_lista{padding: 10px;border-bottom: 1px #222d32 solid;;margin: 10px 0px;}
    .back_gray{background: #e2e2e2;padding: 6px 0px;}
    .chosen-container{
      width:100% !important;
    }
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
          <small><?=$_subtitulo?> [ID CURSO <?=$data->id?>]</small>
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
              </ul>
              <div class="tab-content" >
                <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_autor_dados" class="form-horizontal" method="post">  						
                    <fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12" >Nome</label>
                                    <div class="col-md-12">
                                        <input name="nome" type="text" class="form-control" value="<?=$data->nome?>" >
                                        <input name="id" type="hidden" class="form-control" value="<?=$data->id?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12" >Email</label>
                                    <div class="col-md-12">
                                        <input name="email" type="text" class="form-control" value="<?=$data->email?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12" >Telefone</label>
                                    <div class="col-md-12">
                                        <input name="telefone" type="text" class="form-control" value="<?=$data->telefone?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12" >Documento</label>
                                    <div class="col-md-12">
                                        <input name="documento" type="text" class="form-control" value="<?=$data->documento?>" >
                                    </div>
                                </div>
                            </div>
                        <div>    
                    </fieldset>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->id?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
            <!-- /.row -->
          </section>

        </div>

        <?php require_once('htm_rodape.php'); ?>
      </div>
      <!-- ./wrapper -->

      <script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
      <script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
      <script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
      <script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
      <script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
      <script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
      <script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
      <script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
      <script src="<?=LAYOUT?>dist/js/app.min.js"></script> 
      <script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
      <script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script> 
      <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
      <script src="<?=LAYOUT?>js/funcoes.js"></script>   
      
      <script src="<?=LAYOUT?>chosen.jquery.js" type="text/javascript"></script>
      <script src="<?=LAYOUT?>docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?=LAYOUT?>docsupport/init.js" type="text/javascript" charset="utf-8"></script>

      <script>
        $(document).ready(function() {

          $(".select2").select2();

          // $('input').iCheck({
          //   checkboxClass: 'icheckbox_square-blue',
          //   radioClass: 'iradio_square-blue'
          // });

          $( "#sortable_imagem" ).sortable({
            update: function(event, ui){
              var postData = $(this).sortable('serialize');
              console.log(postData);

              $.post('<?=$_base['objeto']?>ordenar_imagem', {list: postData, codigo: '<?=$data->codigo?>'}, function(o){
                console.log(o);
              }, 'json');
            }
          });

        });
      </script>
      <script src="<?=LAYOUT?>js/ajuda.js"></script> 

      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <script>
          $(document).on('click', '.limited', function(){
            var limit = 3;
            var counter = $('.limited:checked').length;
            if(counter > limit) {
                this.checked = false;
                alert('Limite atingido');
            }
          });
            $(document).ready(function(){
                $(document).on('click', '.add_conteudo_btn', function(e){
                    e.preventDefault();
                    let row_item = $(this).parent().parent().parent();
                    $(row_item).append(`<div class="row" style="margin-top:10px">
                              <div class="col-md-3 mb-12">
                                <select name="icon[]" id="icon" class="form-control">
                                  <option value="0">Curso SCORM</option>
                                  <option value="1">Video Youtube</option>
                                  <option value="2">Videoaula</option>
                                  <option value="3">Podcast</option>
                                  <option value="4">PDF</option>
                                  <option value="5">Avaliação</option>
                                </select>
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="nome_conteudo[]" class="form-control" placeholder="Nome do Conteudo">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="duracao[]" class="form-control" placeholder="Duracao">
                              </div>
                              <div class="col-md-3 mb-12">
                                  <input type="text" name="visualizaca[]" class="form-control" placeholder="Insira o Link">
                              </div>
                              <div class="col-md-2 mb-2 d-grid">
                                  <button class="btn btn-success add_conteudo_btn"><i class="fas fa-plus-circle"></i></button>
                              </div>
                          </div>`);
                });
                $(document).on('click', '.add_conteudo_btn2', function(e){
                    e.preventDefault();
                    let row_item = $(this).parent().parent().parent();
                    $(row_item).append(`<div class="row" style="margin-top:10px">
                              <div class="col-md-3 mb-12">
                                <select name="icon[]" id="icon" class="form-control">
                                  <option value="0">Curso SCORM</option>
                                  <option value="1">Video Youtube</option>
                                  <option value="2">Videoaula</option>
                                  <option value="3">Podcast</option>
                                  <option value="4">PDF</option>
                                  <option value="5">Avaliação</option>
                                </select>
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="nome_conteudo[]" class="form-control" placeholder="Nome do Conteudo">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="duracao[]" class="form-control" placeholder="Duracao">
                              </div>
                              <div class="col-md-3 mb-12">
                                  <input type="text" name="visualizaca[]" class="form-control" placeholder="Insira o Link">
                              </div>
                              <div class="col-md-2 mb-2 d-grid">
                                  <button class="btn btn-success add_conteudo_btn"><i class="fas fa-plus-circle"></i></button>
                              </div>
                          </div>`);
                });
                $(document).on('click', '.remove_conteudo_btn', function(e){
                    e.preventDefault();
                    let row_item = $(this).parent().parent();
                    $(row_item).remove();
                });
                // 
                $(document).on('click', '.delete_topico', function(e){
                  var link = <?php echo "'$link'"?>;
                  if (confirm("Deseja mesmo deletar o topico?")) {
                      e.preventDefault();
                      var id = $(this).attr('data');
                      $.ajax({
                      url:'<?=$_base['objeto']?>deletar_topico',
                      method: 'post',
                      data: {id_topico: id},
                      success: function(response){
                        $("#show_alert").html(`<div class="alert alert-success" role="alert">${response}</div>`);
                        setTimeout(window.location.replace(link), 1000);
                      }
                    });
                  }
                  return false;
                });
                $(document).on('click', '.delete_feedback', function(e){
                  var link = <?php echo "'$link_feedback'"?>;
                  if (confirm("Deseja mesmo deletar o feedback?")) {
                      e.preventDefault();
                      var id = $(this).attr('data');
                      $.ajax({
                      url:'<?=$_base['objeto']?>deletar_feedback',
                      method: 'post',
                      data: {id_feedback: id},
                      success: function(response){
                        $("#show_alert_feedback").html(`<div class="alert alert-success" role="alert">${response}</div>`);
                        setTimeout(window.location.replace(link), 1000);
                      }
                    });
                  }
                  return false;
                });
                $("#add_form").submit(function(e){
                  var link = <?php echo "'$link'"?>;
                  e.preventDefault();
                  $("#add_btn").val('adicionando');
                  $.ajax({
                    url:'<?=$_base['objeto']?>alterar_produto_conteudo_curso',
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(response){
                      $("#add_btn").val('Adicionar');
                      $("#add_form")[0].reset();
                      $(".append_item").remove();
                      $("#show_alert").html(`<div class="alert alert-success" role="alert">${response}</div>`);
                      setTimeout(window.location.replace(link), 1000);
                    }
                  });
                });
            });
        </script>

      <?php include_once('js_summernote.php'); ?>

    </body>
    </html>