<?php include_once('base.php');
// echo '<pre>'; print_r($data); 
?>
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
    .chosen-container{width:100% !important;}
    ul li {list-style: disc;margin-left: 0px !important;margin-bottom: 0px !important; list-style: none;}
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
                <li class='active'>
                  <a href="#dados" data-toggle="tab">Dados</a>
                </li>
                <!-- <li <?php if($aba_selecionada == "imagem"){ echo "class='active'"; } ?> >
                  <a href="#imagem" data-toggle="tab">Imagens</a>
                </li> -->
                <!-- <li <?php if($aba_selecionada == "categorias"){ echo "class='active'"; } ?> >
                  <a href="#categorias" data-toggle="tab">Categorias</a>
                </li> -->
                <!-- <li <?php if($aba_selecionada == "conteudo_curso"){ echo "class='active'"; } ?> >
                  <a href="#conteudo_curso" data-toggle="tab">Conteudo do curso</a>
                </li>
                 <li <?php if($aba_selecionada == "feedback"){ echo "class='active'"; } ?> >
                  <a href="#feedback" data-toggle="tab">Feedback</a>
                </li> -->
                <!--
                <li <?php if($aba_selecionada == "tamanhos"){ echo "class='active'"; } ?> >
                  <a href="#tamanhos" data-toggle="tab">Tam.</a>
                </li>
                <li <?php if($aba_selecionada == "cores"){ echo "class='active'"; } ?> >
                  <a href="#cores" data-toggle="tab">Cores</a>
                </li>
                <li <?php if($aba_selecionada == "variacoes"){ echo "class='active'"; } ?> >
                  <a href="#variacoes" data-toggle="tab">Variações</a>
                </li>
                <li <?php if($aba_selecionada == "frete"){ echo "class='active'"; } ?> >
                  <a href="#frete" data-toggle="tab">Frete</a>
                </li>
                <li <?php if($aba_selecionada == "estoque"){ echo "class='active'"; } ?> >
                  <a href="#estoque" data-toggle="tab">Estoque</a>
                </li>
                <li <?php if($aba_selecionada == "layoutsmodelos"){ echo "class='active'"; } ?> >
                  <a href="#layoutsmodelos" data-toggle="tab">Modelos</a>
                </li>
                <li <?php if($aba_selecionada == "entrega_auto"){ echo "class='active'"; } ?> >
                  <a href="#entrega_auto" data-toggle="tab">Envio Automático</a>
                </li>
                <li <?php if($aba_selecionada == "gabarito"){ echo "class='active'"; } ?> >
                  <a href="#gabarito" data-toggle="tab">Gabaritos</a>
                </li> -->

              </ul>
              <div class="tab-content" >
                <!-- <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" > -->
                <div id="dados" class="tab-pane active">
                  <form action="<?=$_base['objeto']?>alterar_plano_dados" class="form-horizontal" method="post">  						
                    <fieldset>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-12" >*Titulo</label>
                                <div class="col-md-12">
                                    <input name="titulo" type="text" class="form-control" value="<?=$data->name?>" >
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">


                          <div class="col-md-3">                   
                            <div class="form-group">
                              <label class="col-md-12">Ativar/Desativar</label>
                              <div class="col-md-12">
                                  <select class="form-control select2" name="status" >
                                      <option value='1' <?php if($data->status == 'active'){ echo "selected"; } ?> >Ativo</option>
                                      <option value='0' <?php if($data->status == 'inactive'){ echo "selected"; } ?> >Inativo</option>
                                  </select>
                              </div>
                            </div>                   
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12" >Intervalo</label>
                              <div class="col-md-12">
                                  <input name="intervalo" type="text" class="form-control" value="<?=$data->interval_count?>" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12" >Descricao</label>
                              <div class="col-md-12">
                                <input name="description" type="text" class="form-control" value="<?=$data->description?>" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="col-md-12" >Preço</label>
                              <div class="col-md-12">
                                <?php if(isset($data->description['plan_items'][0]->product->pricing_schema->price)){
                                  $price = $data->description['plan_items'][0]->product->pricing_schema->price;
                                }else{
                                  $price = 0;
                                } 
                                ?>
                                <input name="description" type="text" class="form-control" value="<?=$price?>" >
                              </div>
                            </div>
                          </div>


                        </div>
                    </fieldset>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->id?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>


                <div id="imagem" class="tab-pane <?php if($aba_selecionada == "imagem"){ echo "active"; } ?>" >
                  <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>upload/codigo/<?=$data->id?>', 'Enviar Imagens');" >Carregar Imagens</button>
                  <hr>
                  <div style="text-align:center;">
                  <!-- ../arquivos/img_".$pasta."_g/".$codigo."/ -->
                  
                    <ul id="sortable_imagem" >
                      <?php
                      $n = 0;
                        echo "
                        <li id='item_".$value['id']."' >
                          <div class='quadro_img' style='background-image:url(".URL."arquivos/img_combos_g/".$data->id."/".$data->banner."); '></div>
                            <div style='padding-top:5px; text-align:center;'>                         
                          </div>
                        </li>
                        ";
                      ?>
                    </ul>
                  </div>
                  <div>
                    <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                  </div>
                </div>
                <div id="categorias" class="tab-pane <?php if($aba_selecionada == "categorias"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_curso_categorias" class="form-horizontal" method="post">   
                    <div>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>categorias';" >Alterar Categorias</button>
                    </div>
                    <hr>
                    <div style="font-size:15px; padding-bottom:20px; ">Marque as categorias que se enquadram neste produto.</div>
                    <div>
                      <?php
                      function montaCategoriasView($id_pai, $categorias, $padding){
                        foreach ($categorias as $key => $value) {
                          // echo'<pre>';print_r($categorias);
                          if($value['id_pai'] == $id_pai){

                            if($value['check_prod']){
                              $sel = "checked";
                            } else {
                              $sel = "";
                            }

                            echo '
                            <div style="margin-top:5px; margin-left:'.$padding.'px;" >
                            <div class="categoria_produto">
                            <input type="checkbox" class="limited marcar" '.$sel.' id="categoria_'.$value['id'].'" name="categoria_'.$value['id'].'"  value="1" >
                            <label for="categoria_'.$value['id'].'">'.$value['titulo'].'</label>
                            </div>
                            </div>
                            ';

                            montaCategoriasView($value['id'], $value['subcategorias'], $padding+20);
                          }
                        }
                      }
                      montaCategoriasview(0, $categorias, 0);
                      ?>
                    </div>
                    <hr>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->id?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>

                <div id="conteudo_curso" class="tab-pane <?php if($aba_selecionada == "conteudo_curso"){ echo "active"; } ?>" >
                  <h3>Adicionar nova Etapa</h3>
                  <div id="show_item">
                    <div id="show_alert"></div>
                    <form action="<?=$_base['objeto']?>alterar_produto_conteudo_curso" id="add_form" class="form-horizontal" method="post">   
                      <div class="conteudo_lista">
                        <div class="row ">
                            <div class="col-md-12 mb-12">
                                <input type="hidden" name="codigo" value="<?=$data->id?>">
                                <input type="text" name="nome_topico" class="form-control" placeholder="Nome do Topico">
                            </div>
                        </div>
                        <div id="show_conteudo">
                          <div class="row" style="margin-top:10px">
                              <div class="col-md-2 mb-12">
                                <select name="icon[]" id="icon" class="form-control">
                                  <option value="0">Tipo de aula</option>
                                  <option value="1">Introdução</option>
                                  <option value="2">Video</option>
                                  <option value="3">Podcast</option>
                                  <option value="4">PDF</option>
                                  <option value="5">Prova</option>
                                </select>
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="nome_conteudo[]" class="form-control" placeholder="Nome do Conteudo">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="duracao[]" class="form-control" placeholder="Duracao">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="visualizaca[]" class="form-control" placeholder="Vizualizcao">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="perguntas[]" class="form-control" placeholder="Quantidade">
                              </div>
                              <div class="col-md-2 mb-2 d-grid">
                                  <button class="btn btn-success add_conteudo_btn"><i class="fas fa-plus-circle"></i></button>
                              </div>
                          </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                          <div class="col-md-12 mb-12">
                            <input type="submit" class="btn btn-primary" id="add_btn" value="Salvar">
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>

                  <br>
                  

                  <?php 
                    // echo'<pre>';print_r($curso_conteudo);
                    if($curso_conteudo[0]['nome'] != ''){
                      echo '<h3>Lista de Etapas</h3>';
                    foreach($curso_conteudo as $value){
                      // echo'<pre>';print_r($value['conteudo']);
                  ?>
                    <form action="<?=$_base['objeto']?>alterar_produto_conteudo_curso" id="add_form2" class="form-horizontal" method="post">   
                        <div class="conteudo_lista">
                          <div class="row ">
                              <div class="col-md-10 mb-10">
                                  <input type="hidden" name="codigo" value="<?=$data->id?>">
                                  <input type="hidden" name="id_topico" value="<?=$value['id']?>">

                                  <input type="text" name="nome_topico" class="form-control" placeholder="Nome do Topico" value="<?=$value['nome']?>">
                              </div>
                              <div class="col-md-2 mb-2 d-grid">
                                <button class="btn btn-danger delete_topico" data="<?=$value['id']?>"><i class="fas fa-trash-alt"></i></button>
                            </div>
                          </div>
                        <?php
                        foreach($value['conteudo'] as $row){
                          ?>
                          <div id="show_conteudo2">
                            <div class="row" style="margin-top:10px">
                              <div class="col-md-2 mb-12">
                                    <select name="icon[]" id="icon" class="form-control">
                                      <option value="0">Tipo de aula</option>
                                      <option value="1" <?php if($row['icon']==1) echo 'selected'?>>Introdução</option>
                                      <option value="2" <?php if($row['icon']==2) echo 'selected'?>>Video</option>
                                      <option value="3" <?php if($row['icon']==3) echo 'selected'?>>Podcast</option>
                                      <option value="4" <?php if($row['icon']==4) echo 'selected'?>>PDF</option>
                                      <option value="5" <?php if($row['icon']==5) echo 'selected'?>>Prova</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-12">
                                    <input type="text" name="nome_conteudo[]" class="form-control" placeholder="Nome do Conteudo" value="<?=$row['nome']?>">
                                </div>
                                <div class="col-md-2 mb-12">
                                    <input type="text" name="duracao[]" class="form-control" placeholder="Duracao" value="<?=$row['duracao']?>">
                                </div>
                                <div class="col-md-2 mb-12">
                                    <input type="text" name="visualizaca[]" class="form-control" placeholder="Vizualizcao" value="<?=$row['visualizar']?>">
                                </div>
                                <div class="col-md-2 mb-12">
                                    <input type="text" name="perguntas[]" class="form-control" placeholder="Quantidade" value="<?=$row['perguntas']?>">
                                </div>
                                <div class="col-md-2 mb-2 d-grid">
                                    <button class="btn btn-success add_conteudo_btn2"><i class="fas fa-plus-circle"></i></button>
                                    <button class="btn btn-danger remove_conteudo_btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                          </div>
                          <?php } ?>
                          <div class="row" style="margin-top:10px">
                            <div class="col-md-12 mb-12">
                              <input type="submit" class="btn btn-primary" id="add_btn2" value="Salvar">
                            </div>
                          </div>
                        </div>
                      </form>
                  <?php }
                    } 
                  ?>
                    <hr>
                    <div>
                      <!-- <button type="submit" class="btn btn-primary" id="add_btn">Salvar</button> -->
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                </div>

                <div id="feedback" class="tab-pane <?php if($aba_selecionada == "feedback"){ echo "active"; } ?>" >
                <h3>Quantidade de Feedback</h3>
                  <form action="<?=$_base['objeto']?>add_curso_qtd_feedback" id="curso_feedback" class="form-horizontal" method="post">   
                      <div class="conteudo_lista">
                        <div class="row ">
                            <div class="col-md-12 mb-12">
                                <input type="hidden" name="codigo" value="<?=$data->id?>">
                                <input type="text" name="qtd_feedback" class="form-control" placeholder="Quantidade de feedback" value="<?=$data->qtd_feedback?>">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                          <div class="col-md-12 mb-12">
                            <input type="submit" class="btn btn-primary" id="add_btn" value="Salvar">
                          </div>
                        </div>
                      </div>
                    </form>
                  <h3>Adicionar novo Feedback</h3>
                  <div id="show_item">
                    <div id="show_alert_feedback"></div>
                    <form action="<?=$_base['objeto']?>add_curso_feedback" id="curso_feedback" class="form-horizontal" method="post">   
                      <div class="conteudo_lista">
                        <div class="row ">
                            <div class="col-md-8 mb-8">
                                <input type="hidden" name="codigo" value="<?=$data->id?>">
                                <input type="text" name="nome" class="form-control" placeholder="Nome">
                            </div>
                            <div class="col-md-4 mb-4">
                                <select name="estrelas" id="estrelas" class="form-control">
                                  <option value="0">Estrelas</option>
                                  <option value="1">1 estrela</option>
                                  <option value="2">2 estrelas</option>
                                  <option value="3">3 estrelas</option>
                                  <option value="4">4 estrelas</option>
                                  <option value="5">5 estrelas</option>
                                </select>
                              </div>
                        </div>
                        <div id="show_conteudo">
                          <div class="row" style="margin-top:10px">
                              <div class="col-md-12 mb-12">
                                  <textarea name="feedback" rows="5" class="form-control" ></textarea>
                              </div>
                          </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                          <div class="col-md-12 mb-12">
                            <input type="submit" class="btn btn-primary" id="add_btn" value="Salvar">
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <br>
                  <?php 
                    // echo'<pre>';print_r($curso_conteudo);
                    if($lista_feedback[0]['nome'] != ''){
                      echo '<h3>Lista de Feedbacks</h3>';
                    foreach($lista_feedback as $value){
                      // echo'<pre>';print_r($value['conteudo']);
                  ?>
                    <form action="<?=$_base['objeto']?>alterar_curso_feedback" id="feddback_form" class="form-horizontal" method="post">   
                        <div class="conteudo_lista">
                          <div class="row ">
                              <div class="col-md-10 mb-12">
                                  <input type="hidden" name="codigo" value="<?=$data->id?>">
                                  <input type="hidden" name="id_feedback" value="<?=$value['id']?>">
                                  <input type="text" name="nome" class="form-control" placeholder="Nome" value="<?=$value['nome']?>">
                              </div>
                              <div class="col-md-2 mb-12">
                                <select name="estrelas" id="estrelas" class="form-control">
                                  <option value="0">Tipo de aula</option>
                                  <option value="1" <?php if($value['estrela']==1) echo 'selected'?>>1 estrela</option>
                                  <option value="2" <?php if($value['estrela']==2) echo 'selected'?>>2 estrelas</option>
                                  <option value="3" <?php if($value['estrela']==3) echo 'selected'?>>3 estrelas</option>
                                  <option value="4" <?php if($value['estrela']==4) echo 'selected'?>>4 estrelas</option>
                                  <option value="5" <?php if($value['estrela']==5) echo 'selected'?>>5 estrelas</option>
                                </select>
                              </div>
                          </div>
                          <div id="show_conteudo2">
                            <div class="row" style="margin-top:10px">
                              <div class="col-md-12 mb-12">
                                  <textarea name="feedback" rows="5" class="form-control" ><?=$value['texto']?></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row" style="margin-top:10px">
                            <div class="col-md-12 mb-12">
                              <input type="submit" class="btn btn-primary" id="add_btn2" value="Salvar">
                              <button class="btn btn-danger delete_feedback" data="<?=$value['id']?>"><i class="fas fa-trash-alt"></i></button>
                            </div>
                          </div>
                        </div>
                      </form>
                  <?php }
                    } 
                  ?>
                    <hr>
                    <div>
                      <!-- <button type="submit" class="btn btn-primary" id="add_btn">Salvar</button> -->
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
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
            console.log('aqui');
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
                              <div class="col-md-2 mb-12">
                                <select name="icon[]" id="icon" class="form-control">
                                  <option value="0">Tipo de aula</option>
                                  <option value="1">Introdução</option>
                                  <option value="2">Video</option>
                                  <option value="3">Podcast</option>
                                  <option value="4">PDF</option>
                                  <option value="5">Prova</option>
                                </select>
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="nome_conteudo[]" class="form-control" placeholder="Nome do Conteudo">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="duracao[]" class="form-control" placeholder="Duracao">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="visualizaca[]" class="form-control" placeholder="Vizualizcao">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="perguntas[]" class="form-control" placeholder="Quantidade">
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
                              <div class="col-md-2 mb-12">
                                <select name="icon[]" id="icon" class="form-control">
                                  <option value="0">Tipo de aula</option>
                                  <option value="1">Introdução</option>
                                  <option value="2">Video</option>
                                  <option value="3">Podcast</option>
                                  <option value="4">PDF</option>
                                  <option value="5">Prova</option>
                                </select>
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="nome_conteudo[]" class="form-control" placeholder="Nome do Conteudo">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="duracao[]" class="form-control" placeholder="Duracao">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="visualizaca[]" class="form-control" placeholder="Vizualizcao">
                              </div>
                              <div class="col-md-2 mb-12">
                                  <input type="text" name="perguntas[]" class="form-control" placeholder="Quantidade">
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