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
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

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

      <section class="content">
        <div class="row">        	
          <div class="col-xs-12">

            <div class="nav-tabs-custom">

              <ul class="nav nav-tabs">

                <li <?php if($aba_selecionada == "dados"){ echo "class='active'"; } ?> >
                  <a href="#dados" data-toggle="tab">Dados</a>
                </li>
                <!-- <li <?php if($aba_selecionada == "menu"){ echo "class='active'"; } ?> >
                  <a href="#menu" data-toggle="tab">Menu</a>
                </li> -->
                <li <?php if($aba_selecionada == "imagem_fundo"){ echo "class='active'"; } ?> >
                  <a href="#imagem_fundo" data-toggle="tab">Logo do rodapé</a>
                </li>
                <!-- <li <?php if($aba_selecionada == "cores"){ echo "class='active'"; } ?> >
                  <a href="#cores" data-toggle="tab">Cores</a>
                </li> -->

              </ul>

              <div class="tab-content" >


                <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">  						

                    <fieldset> 

                      <div class="form-group" style="display:none">
                        <label class="col-md-12" >Titulo</label>
                        <div class="col-md-6">
                          <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
                        </div>
                      </div>

                      <div class="form-group" style="display:none">
                        <label class="col-md-12">Modelo</label>
                        <div class="col-md-6">
                          <select name="modelo" class="form-control select2" style="width: 100%;" >
                            <option value='' selected >Selecione</option>
                            <?php
                            foreach ($modelos as $key => $value) {

                              if($value['codigo'] == $data->modelo){
                                $selected = "selected=''";
                              } else {
                                $selected = "";
                              }

                              echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";

                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group" style="display:none">
                        <label class="col-md-12" >Fonte Padrão</label>
                        <div class="col-md-6">
                          <select name="font_codigo" class="form-control select2" style="width: 100%;" >
                            <?php

                            foreach ($fontes as $key => $value) {

                              if($value['codigo'] == $data->font_codigo){
                                $selected = " selected=''; ";
                              } else {
                                $selected = "";              
                              }

                              echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";

                            }

                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Copyright</label>
                        <div class="col-md-6">
                          <input name="copy" type="text" class="form-control" value="<?=$data->copy?>" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12">Sobre a empresa</label>
                        <div class="col-md-6">
                          <textarea  class="summernote" name="sobre_a_empresa" rows="5" style="width:100%"><?=$data->sobre_a_empresa?></textarea>
                        </div>
                      </div>

                      <hr><br>
                      <h4>Endereço</h4>
                      <div class="form-group">
                        <label class="col-md-12" >Endereço Linha 1</label>
                        <div class="col-md-6">
                          <input name="endereco1" type="text" class="form-control" value="<?=$data->endereco1?>" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Endereço Linha 2</label>
                        <div class="col-md-6">
                          <input name="endereco2" type="text" class="form-control" value="<?=$data->endereco2?>" >
                        </div>
                      </div>

                      <hr><br>
                      <h4>Dados Pessoais</h4>      
                      <div class="form-group">
                        <label class="col-md-12" >E-mail</label>
                        <div class="col-md-6">
                          <input name="email" type="text" class="form-control" value="<?=$data->email?>" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Fone 1</label>
                        <div class="col-md-6">
                          <input name="fone1" type="text" class="form-control" value="<?=$data->fone1?>" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Fone 2</label>
                        <div class="col-md-6">
                          <input name="fone2" type="text" class="form-control" value="<?=$data->fone2?>" >
                        </div>
                      </div>

                      <hr><br>
                      <h4>Redes sociais</h4>
                      <div class="form-group">
                        <label class="col-md-12">Instagram</label>
                        <div class="col-md-6">
                          <input name="insta" type="text" class="form-control" value="<?=$data->insta?>" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-12">Facebook</label>
                        <div class="col-md-6">
                          <input name="insta" type="text" class="form-control" value="<?=$data->face?>" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-12">Linkedin</label>
                        <div class="col-md-6">
                          <input name="insta" type="text" class="form-control" value="<?=$data->linkedin?>" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-12">Youtube</label>
                        <div class="col-md-6">
                          <input name="insta" type="text" class="form-control" value="<?=$data->youtube?>" >
                        </div>
                      </div>


                      <hr><br>
                      <h4>Configuração do Whatsapp</h4>        
                      <div class="form-group">
                        <label class="col-md-12">Mostrar Whatsapp Chat</label>
                        <div class="col-md-4">
                          <select name="mostrar_whats" class="form-control select2" style="width: 100%;" >
                            <option value='0' <?php if($data->mostrar_whats == 0){ echo " selected='' "; } ?> >Não</option>
                            <option value='1' <?php if($data->mostrar_whats == 1){ echo " selected='' "; } ?> >Sim</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Whatsapp Chat</label>
                        <div class="col-md-6">
                          <input name="whatsapp" type="text" class="form-control" value="<?=$data->whatsapp?>" >
                        </div>
                      </div>

                      <hr><br>
                      <h4>Configuração da Mensagem de cookie</h4>    

                      <div class="form-group">
                        <label class="col-md-12">Mostrar aviso de uso de dados</label>
                        <div class="col-md-4">
                          <select name="mostrar_aviso" class="form-control select2" style="width: 100%;" >
                            <option value='0' <?php if($data->mostrar_aviso == 0){ echo " selected='' "; } ?> >Não</option>
                            <option value='1' <?php if($data->mostrar_aviso == 1){ echo " selected='' "; } ?> >Sim</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Estilo do botão aviso</label>
                        <div class="col-md-4">
                          <select name="botao_aviso" class="form-control select2" style="width: 100%;" > 
                            <?php
                            foreach ($botoes as $key => $value) {

                              if($data->botao_aviso == $value['codigo']){ $selected = " selected='' "; } else { $selected = ""; }

                              echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12">Conteúdo do aviso <?=ajuda('Conteudo da pagina pode incluir tags em html.')?></label>
                        <div class="col-md-6">
                          <textarea  class="summernote" name="aviso_conteudo" rows="5" style="width:100%"><?=$data->aviso_conteudo?></textarea>
                        </div>
                      </div>

                    </fieldset>

                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-danger" onClick="confirma('<?=$_base['objeto']?>apagar_rodape/codigo/<?=$data->codigo?>');">Remover</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  </form>
                </div>


                <div id="menu" class="tab-pane <?php if($aba_selecionada == "menu"){ echo "active"; } ?>" >

                  <div>
                    <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>menu_novo/codigo/<?=$data->codigo?>', 'Novo Menu');" >Novo Menu</button>
                  </div>

                  <hr>

                  <div style="padding-bottom:15px;" >Ordene movendo para cima e para baixo e transforme em sub-menus movendo para os lados.</div>

                  <div class="dd" id="nestable" >
                    <?=$listamenu?>
                  </div>

                  <div style="clear:both; padding-top:15px;">
                    <form action="<?=$_base['objeto']?>menu_salvar_ordem" method="post" >
                      <input type="hidden" name="ordem" id="nestable-output" >
                      <input type="hidden" name="rodape_codigo" value="<?=$data->codigo?>" >
                      <button type="submit" class="btn btn-primary" >Salvar Ordem</button>          
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </form>
                  </div>

                </div>


                <div id="cores" class="tab-pane <?php if($aba_selecionada == "cores"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_cores_grv" class="form-horizontal" method="post">              

                    <fieldset>
                      <?php

                      foreach ($cores as $key => $value) {

                        echo "
                        <div class='form-group'>
                        <label class='col-md-12' >".$value['titulo']."</label>
                        <div class='col-md-4'>
                        <input name='cor_".$value['id']."' type='text' class='form-control my-colorpicker1' value='".$value['cor']."' autocomplete='off' >
                        </div>
                        </div>
                        ";

                      }

                      ?>


                    </fieldset>

                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <input type="hidden" name="modelo" value="<?=$data->modelo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  </form>
                </div>


                <div id="imagem_fundo" class="tab-pane <?php if($aba_selecionada == "imagem_fundo"){ echo "active"; } ?>" >
                  <?php if(!$data->imagem_fundo){ ?>
                    <form action="<?=$_base['objeto']?>imagem_fundo/codigo/<?=$data->codigo?>" method="post" enctype="multipart/form-data">

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
                        <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                      </div>

                    </form>
                  <?php } else { ?>

                    <div style="text-align:left;">
                      <img src="<?=PASTA_CLIENTE?>img_rodape/<?=$data->imagem_fundo?>" style="max-width:300px;background: #e0e0e0;padding: 20px;" >
                    </div>

                    <div style="text-align:left; padding-top:10px;">
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>imagem_fundo_apagar/codigo/<?=$data->codigo?>');" >Apagar Imagem</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
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
    <script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
    <script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>     
    <script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
    <script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
    <script src="<?=LAYOUT?>dist/js/app.min.js"></script>

    <script src="<?=LAYOUT?>api/nestable/jquery.nestable.js"></script> 
    <script>

      $(function(){

        $(".select2").select2();

        $(".my-colorpicker1").colorpicker();

      });

      (function( $ ) {

        'use strict';

        var updateOutput = function (e) {
          var list = e.length ? e : $(e.target),
          output = list.data('output');
          if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));
          } else {
            output.val('JSON browser support required for this demo.');
          }
        };

        $('#nestable').nestable({
          group: 1
        }).on('change', updateOutput);  

        $(function() {
          updateOutput($('#nestable').data('output', $('#nestable-output')));
        });

      }).apply(this, [ jQuery ]);

    </script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <?php include_once('js_summernote.php'); ?>

    <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
    <script src="<?=LAYOUT?>js/funcoes.js"></script>
    <script src="<?=LAYOUT?>js/ajuda.js"></script> 

  </body>
  </html>