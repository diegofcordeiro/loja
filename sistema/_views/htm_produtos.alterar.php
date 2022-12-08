<?php include_once('base.php');
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
function get_plans(){
$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://app.vindi.com.br/api/v1/plans?page=1&per_page=200&sort_by=created_at&sort_order=asc',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_POSTFIELDS =>'',
    CURLOPT_HTTPHEADER => array(
      'accept: application/json',
      'authorization: Basic N2FGMXktTW1uX2N5SE13QVhOaEhpdE5pNk1NaGFlNk9OdlFhSlg5TGJCYzp1bmRlZmluZWQ=',
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);
  $response = json_decode($response, true);
  curl_close($curl);
  // echo '<pre>';print_r($response);exit;
  return $response;
}
// echo '<pre>';
// $plans = get_plans();
//   foreach($plans['plans'] as $plan){
//     print_r($plan['id']);
//     print_r($plan['name']);
//   }
//   exit;


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

  <link rel="stylesheet" href="<?=LAYOUT?>docsupport/style.css">
  <link rel="stylesheet" href="<?=LAYOUT?>docsupport/prism.css">
  <link rel="stylesheet" href="<?=LAYOUT?>chosen.css">

  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

  <?php include_once('css.php'); ?>
  <style>
    .chosen-container{
      width:100% !important;
    }
    ul li{
      list-style-type: none;
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
          <?='Trilhas'?>
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
                <li <?php if($aba_selecionada == "imagem"){ echo "class='active'"; } ?> onClick="carrega_envio_imagens();" >
                  <a href="#imagem" data-toggle="tab">Imagens</a>
                </li>
                <li <?php if($aba_selecionada == "categorias"){ echo "class='active'"; } ?> >
                  <a href="#categorias" data-toggle="tab">Categorias</a>
                </li>
                <li <?php if($aba_selecionada == "canais"){ echo "class='active'"; } ?> >
                  <a href="#canais" data-toggle="tab">Canais</a>
                </li>
                <!-- <li <?php if($aba_selecionada == "destaques"){ echo "class='active'"; } ?> >
                  <a href="#destaques" data-toggle="tab">Destaque</a>
                </li>
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
                <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_produto_dados" class="form-horizontal" method="post" enctype="multipart/form-data">  
                  <?php //print_r($data->banner); ?>						
                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-md-12" >Trilha</label>
                            <div class="col-md-12">
                              <select class="form-control select2" id="ref" name="ref">
                                <?php foreach($lista_trilha_lms as $trilha){ ?>
                                  <option data-title="<?=$trilha['nome_trilha']?>" value='<?=$trilha['id_trilha']?>' <?php if($trilha['checked'] == 1){ echo "selected"; } ?>><?=$trilha['id_trilha'].' - '.$trilha['nome_trilha']?></option>
                                <?php }?>
                              </select>
                              <input name="titulo" type="text" id="titulo" class="form-control" value="<?=$data->titulo?>" >
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="col-md-12">Valor do produto</label>
                            <div class="col-md-12">
                              <input name="valor_falso" type="text" class="form-control" value="<?=$valor_falso?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="col-md-12">Valor com desconto</label>
                            <div class="col-md-12">
                              <input name="valor" type="text" class="form-control" value="<?=$valor?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                            </div>
                          </div>
                        </div>  
                      </div>
                      <!-- ////////////////////////////////////////////////////// -->
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label class="col-md-12">Cursos</label>
                            <div class="col-md-12">
                              <select data-placeholder="Selecione o curso..." multiple class="chosen-select" name="cursos[]">
                                <?php foreach($trilha_curso as $curso){ ?>
                                   <option value='<?=$curso['id']?>' <?php if($curso['checked'] == 1){ echo "selected"; } ?>><?=$curso['titulo']?></option>
                                <?php }?>
                              </select> 
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-md-12">Trilha apenas no combo</label>
                            <div class="col-md-12">
                              <select class="form-control" name="only_combo">
                                <option value='1' <?php if($data->only_combo == 1){ echo "selected"; } ?>>Sim</option>
                                <option value='0' <?php if($data->only_combo == 0){ echo "selected"; } ?>>Não</option>
                              </select> 
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ////////////////////////////////////////////////////// -->
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="col-md-12">Autor</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="autor" >
                                <option value='0'>Selecione um autor</option>
                                <?php if (isset($autor)){
                                      foreach($autor as $row_autor){ ?>
                                      <option value='<?=$row_autor['id']?>' <?php if($data->autor == $row_autor['id']){ echo "selected"; } ?>><?=$row_autor['nome']?></option>
                                <?php } 
                                  }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="col-md-12">Ativar/Desativar</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="status" >
                                <option value='0' <?php if($data->status == 1){ echo "selected"; } ?> >Ativo</option>
                                <option value='1' <?php if($data->status == 0){ echo "selected"; } ?> >Inativo</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="col-md-2">
                          <div class="form-group">
                            <label class="col-md-12">Tipo de venda</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="assinatura" >
                                <option value='0' <?php if($data->assinatura == 0){ echo "selected"; } ?> >Venda</option>
                                
                                <?php 
                                $plans = get_plans();
                                  foreach($plans['plans'] as $plan){
                                ?>
                                  <option value='<?=$plan['id']?>' <?php if($data->assinatura == $plan['id']){ echo "selected"; } ?> ><?=$plan['name']?></option>
                                
                                <?php } ?>

                              </select>
                            </div>
                          </div>
                        </div> -->
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="col-md-12">Última atualização</label>
                            <div class="col-md-12">
                              <input type="date" name="data_atualizacao" class="form-control" value="<?=date('Y-m-d', $data->data_atualizacao)?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-md-12">Vencimento do curso</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="data_vencimento" >
                                <option value='0' <?php if($data->data_vencimento == 0){ echo "selected"; } ?> >selecione</option>
                                <option value='1' <?php if($data->data_vencimento == 1){ echo "selected"; } ?> >1 Mês</option>
                                <option value='2' <?php if($data->data_vencimento == 2){ echo "selected"; } ?> >2 Meses</option>
                                <option value='3' <?php if($data->data_vencimento == 3){ echo "selected"; } ?> >3 Meses</option>
                                <option value='4' <?php if($data->data_vencimento == 4){ echo "selected"; } ?> >4 Meses</option>
                                <option value='5' <?php if($data->data_vencimento == 5){ echo "selected"; } ?> >5 Meses</option>
                                <option value='6' <?php if($data->data_vencimento == 6){ echo "selected"; } ?> >6 Meses</option>
                                <option value='7' <?php if($data->data_vencimento == 7){ echo "selected"; } ?> >7 Meses</option>
                                <option value='8' <?php if($data->data_vencimento == 8){ echo "selected"; } ?> >8 Meses</option>
                                <option value='9' <?php if($data->data_vencimento == 9){ echo "selected"; } ?> >9 Meses</option>
                                <option value='10' <?php if($data->data_vencimento == 10){ echo "selected"; } ?> >10 Meses</option>
                                <option value='11' <?php if($data->data_vencimento == 11){ echo "selected"; } ?> >11 Meses</option>
                                <option value='12' <?php if($data->data_vencimento == 12){ echo "selected"; } ?> >12 Meses</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                       <div class="form-group">
                        <label class="col-md-12">Banner promoção:</label>
                        <div class="col-md-12">
                          <img width="150" src="<?php echo URL."/arquivos/banner_img_produto_g/".$data->codigo."/".$data->banner ?>" alt="">
                          <input type="file" name="arquivo" />
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <label class="col-md-12">Selecione a seção que a trilha deverá ser exibida</label>
                        <div class="col-md-12">
                          <input type="checkbox" name="mais_vendidos" value="mais_vendidos" <?php if($data->mais_vendidos == 1){ echo "checked"; } ?>>
                          <label for="mais_vendidos"> Mais vendidos</label><br>
                          <input type="checkbox" name="novidades" value="novidades" <?php if($data->novidades == 1){ echo "checked"; } ?>>
                          <label for="novidades"> Novidades</label><br>
                          <input type="checkbox" name="melhor_qualificado" value="melhor_qualificado" <?php if($data->melhor_qualificado == 1){ echo "checked"; } ?>>
                          <label for="melhor_qualificado"> Melhor Qualificado</label><br>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <label class="col-md-12">Prévia (utilizado para descrição rapida nos motores de busca)</label>
                        <div class="col-md-12">
                          <textarea name="previa" rows="5" class="form-control" ><?=$data->previa?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-12">Sobre a Trilha</label>
                        <div class="col-md-12">
                          <textarea class="summernote2" name="summary"><?=$data->summary?></textarea>
                        </div>
                      </div>
                      <!-- <div class="form-group">
                        <label class="col-md-12">O que voçê aprenderá</label>
                        <div class="col-md-12">
                          <textarea class="summernote3" name="aprendera" ><?=$data->aprendera?></textarea>
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label class="col-md-12">Descrição</label>
                        <div class="col-md-12">
                          <textarea class="summernote1" name="descricao"><?=$data->descricao?></textarea>
                        </div>
                      </div>
                    </fieldset>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <input type="hidden" name="id" value="<?=$data->id?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>
                <div id="imagem" class="tab-pane <?php if($aba_selecionada == "imagem"){ echo "active"; } ?>" >
                  <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>upload/codigo/<?=$data->codigo?>', 'Enviar Imagens');" >Carregar Imagens</button>
                  <hr>
                  <div style="text-align:center;">
                    <ul id="sortable_imagem" >
                      <?php
                      $n = 0;
                      foreach ($imagens as $key => $value) {
                        // echo "
                        // <li id='item_".$value['id']."' >
                        // <div class='quadro_img' style='background-image:url(".$value['imagem_p']."); '></div>
                        // <div style='padding-top:5px; text-align:center;'>                         
                        // <button class='btn btn-default fa fa-times-circle' onClick=\"confirma_apagar('".$_base['objeto']."apagar_imagem/codigo/$data->codigo/id/".$value['id']."');\" title='Remover imagem' ></button>
                        // <button class='btn btn-default fas fa-redo-alt' onClick=\"window.location='".$_base['objeto']."girar_imagem/codigo/$data->codigo/id/".$value['id']."';\" title='Girar imagem' ></button>
                        // </div>
                        // </li>
                        // ";
                        // $n++;
                         echo "
                        <li id='item_".$value['id']."' >
                        <div class='quadro_img' style='background-image:url(".$value['imagem_p']."); '></div>
                        <div style='padding-top:5px; text-align:center;'>                         
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
                <div id="categorias" class="tab-pane <?php if($aba_selecionada == "categorias"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_produto_categorias" class="form-horizontal" method="post">   
                    <div>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>categorias';" >Alterar Categorias</button>
                    </div>
                    <hr>
                    <div style="font-size:15px; padding-bottom:20px; ">Marque as categorias que se enquadram neste produto.</div>
                    <div>
                      <?php
                      function montaCategoriasView($id_pai, $categorias, $padding){
                        foreach ($categorias as $key => $value) {
                          // echo'<pre>';print_r($categorias);exit;
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
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>
                <div id="canais" class="tab-pane <?php if($aba_selecionada == "canais"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_produto_canais" class="form-horizontal" method="post">   
                    <div>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>canais';" >Alterar canais</button>
                    </div>
                    <hr>
                    <div style="font-size:15px; padding-bottom:20px; ">Marque as canais que se enquadram neste produto.</div>
                    <div>
                      <?php
                      function montacanaisView($id_pai, $canais, $padding){
                        foreach ($canais as $key => $value) {
                          // echo'<pre>';print_r($canais);
                          if($value['check_prod']){
                            $sel = "checked";
                          } else {
                            $sel = "";
                          }
                          echo '
                          <div style="margin-top:5px; margin-left:'.$padding.'px;" >
                          <div class="canal_produto">
                          <input type="checkbox" class="marcar" '.$sel.' id="canal_'.$value['id'].'" name="canal_'.$value['id'].'"  value="1" >
                          <label for="canal_'.$value['id'].'">'.$value['nome'].'</label>
                          </div>
                          </div>
                          ';
                          // montacanaisView($value['id'], $value['subcanais'], $padding+20);
                        }
                      }
                      montacanaisview(0, $canais, 0);
                      ?>
                    </div>
                    <hr>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>
                <div id="destaques" class="tab-pane <?php if($aba_selecionada == "destaques"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_destaques" class="form-horizontal" method="post">   

                    <div>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>grupos';" >Alterar Grupos/Páginas</button>
                    </div>

                    <hr>

                    <div style="font-size:15px; padding-bottom:20px; ">Marque em quais destaques este item vai aparecer.</div>
                    <div>
                      <?php 
                      foreach ($grupos_marcados as $key => $value) {
                        if($value['checked']){
                          $checked = "checked";
                        } else {
                          $checked = "";
                        }
                        echo '
                        <div style="margin-top:5px; " >
                        <div>
                        <input type="checkbox" class="marcar" '.$checked.' id="grupo_'.$value['id'].'" name="grupo_'.$value['id'].'"  value="1" >
                        <label for="grupo_'.$value['id'].'">'.$value['titulo'].'</label>
                        </div>
                        </div>
                        ';
                      }                     
                      ?>
                    </div>
                    <hr>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>
                <div id="tamanhos" class="tab-pane <?php if($aba_selecionada == "tamanhos"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_produto_tamanhos" class="form-horizontal" method="post">   
                    <div>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>tamanhos';" >Alterar Tamanhos</button>
                    </div>
                    <hr>
                    <div style="font-size:15px; padding-bottom:20px; ">Marque os tamanhos que se enquadram neste produto e se necessário coloque o valor adicional no produto.</div>
                    <div>
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Sel.</th>
                            <th>Titulo</th>
                            <th>Valor Adicional</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($tamanhos as $key => $value) {
                            if($value['check_prod']){
                              $sel = "checked";
                            } else {
                              $sel = "";
                            }
                            echo "
                            <tr id='item_".$value['id']."' >
                            <td style='width:30px;' ><input type='checkbox' class='marcar' name='tamanho_".$value['id']."' value='1' $sel ></td>
                            <td>".$value['titulo']."</td>
                            <td>
                            <input name='valor_".$value['id']."' type='text' class='form-control' value='".$value['valor']."' onkeypress=\"Mascara(this,MaskMonetario)\" onKeyDown=\"Mascara(this,MaskMonetario)\" >
                            </td>
                            </tr>
                            ";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <hr>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>
                <div id="cores" class="tab-pane <?php if($aba_selecionada == "cores"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_produto_cores" class="form-horizontal" method="post">   
                    <div>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>cores';" >Alterar Cores</button>
                    </div>
                    <hr>
                    <div style="font-size:15px; padding-bottom:20px; ">Marque as cores que se enquadram neste produto e se necessário coloque o valor adicional no produto.</div>
                    <div>
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Sel.</th>
                            <th>Titulo</th>
                            <th>Valor Adicional</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($cores as $key => $value) {
                            if($value['check_prod']){
                              $sel = "checked";
                            } else {
                              $sel = "";
                            }
                            echo "
                            <tr id='item_".$value['id']."' >
                            <td style='width:30px;' ><input type='checkbox' class='marcar' name='cor_".$value['id']."' value='1' $sel ></td>
                            <td>".$value['titulo']."</td>
                            <td>
                            <input name='valor_".$value['id']."' type='text' class='form-control' value='".$value['valor']."' onkeypress=\"Mascara(this,MaskMonetario)\" onKeyDown=\"Mascara(this,MaskMonetario)\" >
                            </td>
                            </tr>
                            ";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <hr>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>
                <div id="variacoes" class="tab-pane <?php if($aba_selecionada == "variacoes"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_produto_variacoes" class="form-horizontal" method="post">   
                    <div>
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>variacoes';" >Alterar Variações</button>
                    </div>
                    <hr>
                    <div style="font-size:15px; padding-bottom:20px; ">Marque as variações que se enquadram neste produto e se necessário coloque o valor adicional no produto.</div>
                    <div>
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Sel.</th>
                            <th>Titulo</th>
                            <th>Valor</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($variacoes as $key => $value) {
                            if($value['check_prod']){
                              $sel = "checked";
                            } else {
                              $sel = "";
                            }
                            echo "
                            <tr id='item_".$value['id']."' >
                            <td style='width:30px;' ><input type='checkbox' class='marcar' name='variacao_".$value['id']."' value='1' $sel ></td>
                            <td>".$value['titulo']."</td>
                            <td>
                            <input name='valor_".$value['id']."' type='text' class='form-control' value='".$value['valor']."' onkeypress=\"Mascara(this,MaskMonetario)\" onKeyDown=\"Mascara(this,MaskMonetario)\" >
                            </td>
                            </tr>
                            ";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <hr>
                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>
                  </form>
                </div>
                <div id="frete" class="tab-pane <?php if($aba_selecionada == "frete"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_produto_frete" class="form-horizontal" method="post">
                    <fieldset>

                      <div class="form-group">
                        <label class="col-md-12">Cobrar Frete</label>
                        <div class="col-md-3">
                          <select class="form-control select2" name="fretegratis" >
                            <option value='0' <?php if($data->fretegratis == 0){ echo "selected"; } ?> >Sim</option>
                            <option value='1' <?php if($data->fretegratis == 1){ echo "selected"; } ?> >Não</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >*Peso em gramas (1000 para 1kg)</label>
                        <div class="col-md-2">
                          <input name="peso" type="text" class="form-control" value="<?=$data->peso?>" onkeypress="Mascara(this,Integer)" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Largura em Centímetros (opcional)</label>
                        <div class="col-md-2">
                          <input name="largura" type="text" class="form-control" value="<?=$data->largura?>" onkeypress="Mascara(this,Integer)" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Comprimento em Centímetros (opcional)</label>
                        <div class="col-md-2">
                          <input name="comprimento" type="text" class="form-control" value="<?=$data->comprimento?>" onkeypress="Mascara(this,Integer)" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-12" >Altura em Centímetros (opcional)</label>
                        <div class="col-md-2">
                          <input name="altura" type="text" class="form-control" value="<?=$data->altura?>" onkeypress="Mascara(this,Integer)" >
                        </div>
                      </div>

                    </fieldset>

                    <hr>

                    <div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
                    </div>

                  </form>
                </div>



                <div id="estoque" class="tab-pane <?php if($aba_selecionada == "estoque"){ echo "active"; } ?>" >

                  <div>
                    <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>alterar_estoque/produto/<?=$data->codigo?>/retorno/2', 'Alterar Estoque');">Alterar Estoque</button>
                  </div>

                  <hr>

                  <div>
                    <table class="table table-bordered table-striped">

                      <thead>
                        <tr>
                          <th>Produto</th>
                          <th>Tamanho</th>
                          <th>Cor</th>
                          <th>Variação</th>
                          <th>Quantidade</th>
                          <th></th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php

                        foreach ($estoque as $key => $value) {

                          $linklinha = "onClick=\"modal('".$_base['objeto']."alterar_estoque/produto/".$value['produto']."/tamanho/".$value['tamanho']."/cor/".$value['cor']."/variacao/".$value['variacao']."/retorno/2', 'Alterar Estoque');\"style='cursor:pointer;' ";

                          $extrato = "onClick=\"modal('".$_base['objeto']."extrato_estoque/registro/".$value['registro']."/', 'Extrato');\"style='cursor:pointer;' ";

                          echo "
                          <tr>
                          <td $linklinha >".$value['produto_titulo']."</td>
                          <td $linklinha >".$value['tamanho_titulo']."</td>
                          <td $linklinha >".$value['cor_titulo']."</td>
                          <td $linklinha >".$value['variacao_titulo']."</td>
                          <td $linklinha >".$value['quantidade']."</td>
                          <td $extrato >Extrato</td>
                          </tr>
                          ";

                        }

                        ?>
                      </tbody>

                    </table>
                  </div>              

                </div>



                <div id="layoutsmodelos" class="tab-pane <?php if($aba_selecionada == "layoutsmodelos"){ echo "active"; } ?>" >

                  <div>
                    <button type="button" class="btn btn-primary" onClick="window.location='<?=$_base['objeto']?>modelos';">Alterar Modelos</button>
                  </div>

                  <hr>

                  <div style="text-align:left;">
                    <select class="form-control select2" name="categoria" onChange="window.location='<?=$_base['objeto']?>alterar_produto/codigo/<?=$data->codigo?>/aba/layoutsmodelos/layoutcat/'+this.value;"; >
                      <?php
                      foreach ($layouts_categorias as $key => $value) {

                        if($value['codigo'] == $layoutcat){
                          $selected = " selected='' ";
                        } else {
                          $selected = "";
                        }

                        echo "<option value='".$value['codigo']."' ".$selected." >".$value['titulo']."</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <hr>

                  <form action="<?=$_base['objeto']?>alterar_layouts_grv" method="post">

                    <table id="tabela1" class="table table-bordered table-striped">

                      <thead>
                        <th>Sel.</th>
                        <th>Titulo</th>
                      </thead>

                      <tbody>
                        <?php

                        foreach ($lista_layouts as $key => $value) {

                          if($value['check_prod']){
                            $check = " checked='' ";
                          } else {
                            $check = "";
                          }

                          echo "
                          <tr>
                          <td class='center' style='width:30px;' ><input type='checkbox' class='marcar' name='layout_".$value['id']."' value='1' $check ></td>
                          <td>".$value['titulo']."</td>
                          </tr>
                          ";

                        }

                        ?>
                      </tbody>

                    </table>

                    <div>
                      <button type="submit" class="btn btn-primary" >Salvar</button>
                      <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                      <input type="hidden" name="layoutcat" value="<?=$layoutcat?>" >
                    </div>

                  </form>

                </div>



                <div id="entrega_auto" class="tab-pane <?php if($aba_selecionada == "entrega_auto"){ echo "active"; } ?>" >

                  <div>
                    <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>alterar_entrega_auto/produto/<?=$data->codigo?>/retorno/2', 'Alterar Mensagem de Entrega');">Alterar</button>
                  </div>

                  <hr>

                  <div>
                    <table class="table table-bordered table-striped">

                      <thead>
                        <tr>
                          <th>Produto</th>
                          <th>Tamanho</th>
                          <th>Cor</th>
                          <th>Variação</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php

                        foreach ($lista_entrega_auto as $key => $value) {

                          $linklinha = "onClick=\"modal('".$_base['objeto']."alterar_entrega_auto/produto/".$value['produto']."/tamanho/".$value['tamanho']."/cor/".$value['cor']."/variacao/".$value['variacao']."/retorno/2', 'Alterar Estoque');\"style='cursor:pointer;' ";

                          echo "
                          <tr>
                          <td $linklinha >".$value['produto_titulo']."</td>
                          <td $linklinha >".$value['tamanho_titulo']."</td>
                          <td $linklinha >".$value['cor_titulo']."</td>
                          <td $linklinha >".$value['variacao_titulo']."</td>
                          </tr>
                          ";

                        }

                        ?>
                      </tbody>

                    </table>
                  </div>

                </div>


                <div id="gabarito" class="tab-pane <?php if($aba_selecionada == "gabarito"){ echo "active"; } ?>" > 

                  <div>
                    <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>gabarito_novo/codigo/<?=$data->codigo?>', 'Novo');" >Novo Gabarito</button>
                  </div>

                  <hr>

                  <div>
                    <table class="table table-bordered table-striped">

                      <thead>
                        <tr>
                          <th>Op.</th>
                          <th>Titulo</th>
                          <th>Link</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php

                        foreach ($gabaritos as $key => $value) {

                          echo "
                          <tr>
                          <td style='width:30px;' >
                          <a href='#' onclick=\"confirma('".DOMINIO."produtos/gabarito_apagar/id/".$value['id']."')\" >Apagar</a>
                          </td>
                          <td>".$value['titulo']."</td>
                          <td>".$value['link']."</td>
                          </tr>
                          ";

                        }

                        ?>
                      </tbody>

                    </table>
                  </div>

                  <hr>

                  <div>
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

      <!-- <script src="<?=LAYOUT?>docsupport/jquery-3.2.1.min.js" type="text/javascript"></script> -->
      <script src="<?=LAYOUT?>chosen.jquery.js" type="text/javascript"></script>
      <script src="<?=LAYOUT?>docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?=LAYOUT?>docsupport/init.js" type="text/javascript" charset="utf-8"></script>


      <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
      <script src="<?=LAYOUT?>js/funcoes.js"></script>      

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

        $(document).ready(function() {

          var title = $("select#ref option:selected").attr('data-title');
            $('#titulo').val(title);

          $("#ref").change(function(){
            var title = $("select#ref option:selected").attr('data-title');
            $('#titulo').val(title);
          });

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

      <?php include_once('js_summernote.php'); ?>

    </body>
    </html>