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

                <!-- <li <?php if($aba_selecionada == "dados"){ echo "class='active'"; } ?> >
                  <a href="#dados" data-toggle="tab">Dados</a>
                </li> -->
                <!-- <li <?php if($aba_selecionada == "menu"){ echo "class='active'"; } ?> >
                  <a href="#menu" data-toggle="tab">Menu</a>
                </li> -->
                <li <?php if($aba_selecionada == "cores"){ echo "class='active'"; } ?> >
                  <a href="#cores" data-toggle="tab">Cores</a>
                </li>
                <!-- <li <?php if($aba_selecionada == "fundo"){ echo "class='active'"; } ?> >
                  <a href="#fundo" data-toggle="tab">Imagem de Fundo</a>
                </li> -->
                <li <?php if($aba_selecionada == "logo"){ echo "class='active'"; } ?> >
                  <a href="#logo" data-toggle="tab">Logo</a>
                </li>
                <li <?php if($aba_selecionada == "fundo"){ echo "class='active'"; } ?> >
                  <a href="#fundo" data-toggle="tab">Banner</a>
                </li>
                <li <?php if($aba_selecionada == "senha"){ echo "class='active'"; } ?> >
                  <a href="#senha" data-toggle="tab">Alterar Senha</a>
                </li>
                <li <?php if($aba_selecionada == "banner_admin"){ echo "class='active'"; } ?> >
                  <a href="#banner_admin" data-toggle="tab">Alterar Banner admin</a>
                </li>
                <li <?php if($aba_selecionada == "logo_admin"){ echo "class='active'"; } ?> >
                  <a href="#logo_admin" data-toggle="tab">Alterar Logo admin</a>
                </li>
                <!-- <li <?php if($aba_selecionada == "icones"){ echo "class='active'"; } ?> >
                  <a href="#icones" data-toggle="tab">Icos/Atalhos</a>
                </li> -->
                <!-- <li <?php if($aba_selecionada == "botoes"){ echo "class='active'"; } ?> >
                  <a href="#botoes" data-toggle="tab">Botões</a>
                </li> -->
                <li <?php if($aba_selecionada == "analytics"){ echo "class='active'"; } ?> >
                  <a href="#analytics" data-toggle="tab">Facebook Pixel</a>
                </li>

              </ul>

              <div class="tab-content" >


                <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">  						

                    <fieldset> 

                      <div class="form-group">
                        <label class="col-md-12" >Titulo</label>
                        <div class="col-md-6">
                          <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12">Modelo</label>
                        <div class="col-md-6">
                          <select name="modelo" class="form-control select2" style="width: 100%;" >
                            <option value='' selected >Selecione</option>
                            <?php
                            foreach ($modelos as $key => $value) {

                              if($value['codigo'] == $modelo){
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
                      
                      <div class="form-group">
                        <label class="col-md-12">Posição</label>
                        <div class="col-md-6">
                          <select name="posicao" class="form-control select2" style="width: 100%;" >
                            <option value='0' <?php if($data->posicao == 0){ echo "selected=''"; } ?> >Normal</option>
                            <option value='1' <?php if($data->posicao == 1){ echo "selected=''"; } ?> >Fixo</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-md-12" >Página de busca</label>
                        <div class="col-md-6">
                          <select name="busca_pagina" class="form-control select2" style="width: 100%;" >
                            <option value='' selected >Busca Geral</option>
                            <?php
                            foreach ($destinos as $key => $value) {

                              if($data->busca_pagina == $value['chave']){ $selected = " selected='' "; } else { $selected = ""; }

                              echo "<option value='".$value['chave']."' $selected >".$value['titulo']."</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      


                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-md-12" >Fonte Padrão</label>
                            <div class="col-md-12">
                              <select name="textos_fonte" class="form-control select2" style="width: 100%;" >
                                <?php

                                foreach ($fontes as $key => $value) {

                                  if($value['codigo'] == $data->textos_fonte){
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
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="col-md-12" >Fonte Padrão Tamanho</label>
                            <div class="col-md-12">
                              <input name="textos_fonte_tam" type="text" class="form-control" value="<?=$data->textos_fonte_tam?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-md-12" >Fonte do Menu</label>
                            <div class="col-md-12">
                              <select name="menu_fonte" class="form-control select2" style="width: 100%;" >
                                <?php

                                foreach ($fontes as $key => $value) {

                                  if($value['codigo'] == $data->menu_fonte){
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
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="col-md-12" >Fonte do Menu Tamanho</label>
                            <div class="col-md-12">
                              <input name="menu_fonte_tam" type="text" class="form-control" value="<?=$data->menu_fonte_tam?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
                            </div>
                          </div>
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
                      
                      <div class="form-group">
                        <label class="col-md-12" >E-mail</label>
                        <div class="col-md-6">
                          <input name="email" type="text" class="form-control" value="<?=$data->email?>" >
                        </div>
                      </div>
                      
                    </fieldset>



                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$codigo?>" >
                      <button type="button" class="btn btn-danger" onClick="confirma('<?=$_base['objeto']?>apagar_topo/codigo/<?=$codigo?>');">Remover</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  </form>
                </div>

                <div id="menu" class="tab-pane <?php if($aba_selecionada == "menu"){ echo "active"; } ?>" >

                  <div>
                    <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>menu_novo/codigo/<?=$codigo?>', 'Novo Menu');" >Novo Menu</button>
                  </div>

                  <hr>

                  <div style="padding-bottom:15px;" >Ordene movendo para cima e para baixo e transforme em sub-menus movendo para os lados.</div>

                  <div class="dd" id="nestable" >
                    <?=$listamenu?>
                  </div>

                  <div style="clear:both; padding-top:15px;">
                    <form action="<?=$_base['objeto']?>menu_salvar_ordem" method="post" >
                      <input type="hidden" name="ordem" id="nestable-output" >
                      <input type="hidden" name="topo_codigo" value="<?=$codigo?>" >
                      <button type="submit" class="btn btn-primary" >Salvar Ordem</button>          
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </form>
                  </div>

                </div>

                <div id="senha" class="tab-pane <?php if($aba_selecionada == "senha"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_senha_grv" class="form-horizontal" method="post">              
                    <fieldset>
                        <div class='form-group'>
                        <label class='col-md-12' >Nova Senha</label>
                          <div class='col-md-4'>
                            <input name='senha' type='password' class='form-control' autocomplete='off' >
                          </div>  
                        </div>
                    </fieldset>

                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$codigo?>" >
                      <input type="hidden" name="modelo" value="<?=$modelo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  </form>
                </div>

                <div id="analytics" class="tab-pane <?php if($aba_selecionada == "analytics"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>analytics_grv" class="form-horizontal" method="post">
											<fieldset>
												<div class="form-group">
													<label class="col-md-12" >Código de acompanhamento</label>
													<div class="col-md-7">
														<textarea name="acompanhamento" class="form-control" style="height:250px;"><?=htmlspecialchars_decode(base64_decode($data->analytcs));?></textarea>
													</div>
												</div>
											</fieldset>
											<div>
												<button type="submit" class="btn btn-primary">Salvar</button>
											</div>
										</form>
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
                      <input type="hidden" name="codigo" value="<?=$codigo?>" >
                      <input type="hidden" name="modelo" value="<?=$modelo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  </form>
                </div>
                <div id="fundo" class="tab-pane <?php if($aba_selecionada == "fundo"){ echo "active"; } ?>" >
                  <?php if(!$data->fundo){ ?>
                    <form action="<?=$_base['objeto']?>fundo/codigo/<?=$codigo?>" method="post" enctype="multipart/form-data">

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
                        <span>Link do Banner</span>
                        <input type="text" name="link_banner" value="<?=$data->link_banner?>" >
                      </fieldset>

                      <div style="text-align:left; padding-top:10px;">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                      </div>

                    </form>
                  <?php } else { ?>
                  <form action="<?=$_base['objeto']?>link_banner/codigo/<?=$codigo?>" method="post" enctype="multipart/form-data">
                    <div style="text-align:left;">
                      <img src="<?=PASTA_CLIENTE?>imagens/<?=$data->fundo?>" style="max-width:300px;" >
                    </div>
                    <br>
                    <span>Link do Banner - inclua o link completo <i>https://seulink.com.br</i></span><br>
                    <input type="text" name="link_banner" value="<?=$data->link_banner?>" style="min-width: 500px;">

                    <div style="text-align:left; padding-top:10px;">
                      <button type="submit" class="btn btn-primary">Enviar</button>
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>fundo_apagar/codigo/<?=$codigo?>');" >Apagar Imagem</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>
                  </form>
                  <?php } ?>
                </div>

                <div id="logo" class="tab-pane <?php if($aba_selecionada == "logo"){ echo "active"; } ?>" >
                  <?php if(!$data->logo){ ?>
                    <form action="<?=$_base['objeto']?>logo/codigo/<?=$codigo?>" method="post" enctype="multipart/form-data">

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
                      <img src="<?=PASTA_CLIENTE?>imagens/<?=$data->logo?>" style="max-width:300px;" >
                    </div>

                    <div style="text-align:left; padding-top:10px;">
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>logo_apagar/codigo/<?=$codigo?>');" >Apagar Imagem</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  <?php } ?>
                </div>

                <div id="banner_admin" class="tab-pane <?php if($aba_selecionada == "banner_admin"){ echo "active"; } ?>" >
                  <?php if(!$data->logo){ ?>
                    <form action="<?=$_base['objeto']?>banner_admin/codigo/<?=$codigo?>" method="post" enctype="multipart/form-data">

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
                      <img src="<?=PASTA_CLIENTE?>imagens/<?=$data->logo?>" style="max-width:300px;" >
                    </div>

                    <div style="text-align:left; padding-top:10px;">
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>logo_apagar/codigo/<?=$codigo?>');" >Apagar Imagem</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  <?php } ?>
                </div>

                <div id="logo_admin" class="tab-pane <?php if($aba_selecionada == "logo_admin"){ echo "active"; } ?>" >
                  <?php if(!$data->logo){ ?>
                    <form action="<?=$_base['objeto']?>logo_admin/codigo/<?=$codigo?>" method="post" enctype="multipart/form-data">

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
                      <img src="<?=PASTA_CLIENTE?>imagens/<?=$data->logo?>" style="max-width:300px;" >
                    </div>

                    <div style="text-align:left; padding-top:10px;">
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>logo_apagar/codigo/<?=$codigo?>');" >Apagar Imagem</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  <?php } ?>
                </div>

                <div id="banner" class="tab-pane <?php if($aba_selecionada == "banner"){ echo "active"; } ?>" >
                  <?php if(!$data->logo){ ?>
                    <form action="<?=$_base['objeto']?>logo/codigo/<?=$codigo?>" method="post" enctype="multipart/form-data">

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
                      <img src="<?=PASTA_CLIENTE?>imagens/<?=$data->logo?>" style="max-width:300px;" >
                    </div>

                    <div style="text-align:left; padding-top:10px;">
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>logo_apagar/codigo/<?=$codigo?>');" >Apagar Imagem</button>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial';" >Voltar</button>
                    </div>

                  <?php } ?>
                </div>

                <div id="icones" class="tab-pane <?php if($aba_selecionada == "icones"){ echo "active"; } ?>" >

                  <div>
                    <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>icone_novo/codigo/<?=$codigo?>', 'Novo Icone');" >Novo Icone</button>
                  </div>

                  <hr>                   

                  <div style="font-size: 14px; color:#666; padding-bottom: 20px; text-align: center; ">Arraste para ordenar.</div>

                  <div style="text-align:center;">
                    <ul id="sortable_icones" >
                      <?php

                      $n = 0;
                      foreach ($icones as $key => $value) {

                        echo "
                        <li id='item_".$value['id']."' >

                        <div class='quadro_icone'>
                        ".$value['icone']."<br>
                        <span>".$value['titulo']."</span>
                        </div>

                        <div style='padding-top:5px; text-align:center;'>
                        <button class='btn btn-default' onClick=\"modal('".$_base['objeto']."icone_alterar/codigo/".$value['codigo']."/codigo_topo/$codigo', 'Alterar Legenda');\" title='Editar' ><i class='fas fa-edit'></i></button>
                        <button class='btn btn-default' onClick=\"confirma_apagar('".$_base['objeto']."icone_apagar/topo_codigo/$codigo/codigo/".$value['codigo']."');\" title='Remover' ><i class='fas fa-trash-alt'></i></button>
                        </div>

                        </li>
                        ";

                        $n++;
                      }

                      ?>
                    </ul>
                  </div>

                  <?php if($n == 0){ ?>

                    <div style="text-align:center; padding-top:100px; padding-bottom:100px;">Nenhuma imagem adicionada!</div>

                  <?php } ?>

                  <div>
                    <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                  </div>


                </div>

                <div id="botoes" class="tab-pane <?php if($aba_selecionada == "botoes"){ echo "active"; } ?>" >

                  <div>
                    <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>botao_novo/codigo/<?=$codigo?>', 'Novo Botão');" >Novo Botão</button>
                  </div>

                  <hr>                   

                  <div style="font-size: 14px; color:#666; padding-bottom: 20px; text-align: center; ">Arraste para ordenar.</div>

                  <div style="text-align:center;">
                    <ul id="sortable_botoes" >
                      <?php

                      $n = 0;
                      foreach ($botoes as $key => $value) {

                        echo "
                        <li id='item_".$value['id']."' >

                        <div class='quadro_botao_topo'>
                        <span>".$value['titulo']."</span>
                        </div>

                        <div style='padding-top:5px; text-align:center;'>
                        <button class='btn btn-default' onClick=\"modal('".$_base['objeto']."botao_alterar/codigo/".$value['codigo']."/codigo_topo/$codigo', 'Alterar Botão');\" title='Editar' ><i class='fas fa-edit'></i></button>
                        <button class='btn btn-default' onClick=\"confirma_apagar('".$_base['objeto']."botao_apagar/topo_codigo/$codigo/codigo/".$value['codigo']."');\" title='Remover' ><i class='fas fa-trash-alt'></i></button>
                        </div>

                        </li>
                        ";

                        $n++;
                      }

                      ?>
                    </ul>
                  </div>

                  <?php if($n == 0){ ?>

                    <div style="text-align:center; padding-top:100px; padding-bottom:100px;">Nenhuma imagem adicionada!</div>

                  <?php } ?>

                  <div>
                    <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                  </div>


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

        $( "#sortable_icones" ).sortable({
          update: function(event, ui){
            var postData = $(this).sortable('serialize');
            console.log(postData);

            $.post('<?=$_base['objeto']?>icone_ordem', {list: postData, codigo: '<?=$codigo?>'}, function(o){
              console.log(o);
            }, 'json');
          }
        });

        $( "#sortable_botoes" ).sortable({
          update: function(event, ui){
            var postData = $(this).sortable('serialize');
            console.log(postData);

            $.post('<?=$_base['objeto']?>botao_ordem', {list: postData, codigo: '<?=$codigo?>'}, function(o){
              console.log(o);
            }, 'json');
          }
        });

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

    <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
    <script src="<?=LAYOUT?>js/funcoes.js"></script>
    <script src="<?=LAYOUT?>js/ajuda.js"></script> 

  </body>
  </html>