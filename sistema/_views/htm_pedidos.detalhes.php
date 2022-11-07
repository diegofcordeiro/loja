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
  
  <style>

  .form-group label{
    margin-top:10px;
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
         <small><?=$_subtitulo?></small>
       </h1> 
     </section>

     <!-- Main content -->
     <section class="content">


      <div class="row">


        <div class="col-xs-7">          
          <section class="panel">

            <header class="panel-heading" style="background-color:#ddd">      
              <h2 class="panel-title" style="font-size:16px; padding-top: 5px; padding-bottom: 5px; text-align: center;">
                <strong>DETALHES DO PEDIDO <?=$data->id?></strong> - Realizado em: <?=date('d/m/y H:i', $data->data)?></h2> 
              </header>

              <div class="panel-body"> 

                <div style="margin-top:-10px;">
                  <?php

                  $n = 0;
                  foreach ($mensagens as $key => $value) {

                    if($value['usuario'] == 1){
                      $quemenviou = 'Atendimento';
                    } else {
                      $quemenviou = 'Cliente: '.$data_cadastro->fisica_nome;
                    }

                    if($value['anexo']){
                      $anexo = "
                      <div class='pedido_anexo' ><a href='".$value['anexo']."' target='_blank' >Anexo</a></div>
                      ";
                    } else {
                      $anexo = '';
                    }

                    if(!($n % 2)) { $bg = " style='background-color:#f2f2f2;' "; } else { $bg = ""; }  

                    echo "
                    <div class='pedido_msg' $bg >
                    <div class='pedido_usuario'><strong>".$quemenviou."</strong> em: ".$value['data']."</div>
                    <div style='color:#000;'>".$value['msg']." </div>
                    ".$anexo."
                    </div>
                    ";

                    $n++;
                  }                    

                  ?>
                </div>

              </div>

            </section>
          </div>


          <div class="col-xs-5">
            <section class="panel">

              <header class="panel-heading" style="background-color:#ddd">      
                <h2 class="panel-title" style="font-size:16px; padding-top: 5px; padding-bottom: 5px; text-align: center;"><strong>ENVIAR MENSAGEM</strong>
                </h2> 
              </header>

              <div class="panel-body">
                <form action="<?=DOMINIO?>pedidos/envia_msg" method="post" enctype="multipart/form-data" >

                  <fieldset>

                    <div class="form-group">
                      <div class="col-md-12">
                        <textarea class="form-control" name="mensagem" placeholder="Digite uma mensagem" style="border-radius:0px; margin-bottom:15px; height: 120px;" ></textarea>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-md-12" >Anexo</label>
                      <div class="col-md-12">
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
                      </div>
                    </div>
                    
                    <div class="form-group"> 
                      <div class="col-md-12" style="margin-top:15px;">
                        <button type="button" class="btn btn-primary" onClick="submit()">Enviar</button>
                        <input type="hidden" name="pedido" value="<?=$data->codigo?>">
                        <input type="hidden" name="email_cliente" value="<?=$data_cadastro->email?>">
                      </div>
                    </div>

                  </fieldset>

                </form>
              </div>

            </section>
          </div>



        </div>



        <div class="row">
          <div class="col-xs-7">




            <section class="panel">

              <header class="panel-heading" style="background-color:#ddd">      
                <h2 class="panel-title" style="font-size:16px; padding-top: 5px; padding-bottom: 5px; text-align: center;">
                  <strong>ITENS DO PEDIDO</strong></h2> 
                </header>     

                <div class="panel-body">      

                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                      <thead>
                        <tr>
                          <th>Produto</th>
                          <th>Preço</th>
                          <th>Quantidade</th>
                          <th>Total</th>
                        </tr>
                      </thead>

                      <?php

                      foreach ($lista_carrinho as $key => $value) {
                        
                        echo "
                        <tr>
                        <td>".$value['produto_nome']."</td>
                        <td>R$ ".$value['valor_total_tratado']."</td>
                        <td>".$value['quantidade']."</td>
                        <td style='text-align:center;'>R$ ".$value['total_calculo_tratado']."</td>
                        </tr>
                        ";
                      }

                      echo "
                      <tr>
                      <td colspan='3' style='text-align:right; ' >Sub-total</td>
                      <td style='text-align:center; font-weight:bold;' >R$ ".$valor_subtotal."</td>
                      </tr>
                      ";

                      echo "
                      <tr>
                      <td colspan='3' style='text-align:right; ' >Descontos</td>
                      <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$descontos."</td>
                      </tr>
                      ";

                      echo "
                      <tr>
                      <td colspan='3' style='text-align:right; ' >Frete</td>
                      <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$frete_valor."</td>
                      </tr>
                      ";

                      echo "
                      <tr>
                      <td colspan='3' style='text-align:right; ' >Valor Total</td>
                      <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$valor_total."</td>
                      </tr>
                      ";

                      ?>
                    </table>
                  </div>
                </div>

              </section>




              <section class="panel">
                <form action="<?=$_base['objeto']?>salvar_pedido/codigo/<?=$data->codigo?>" method="post" >

                  <header class="panel-heading" style="background-color:#ddd">      
                    <h2 class="panel-title" style="font-size:16px; padding-top: 5px; padding-bottom: 5px; font-weight: bold; text-align: center;">
                    INFORMAÇÕES DO PEDIDO</h2> 
                  </header>

                  <div class="panel-body">      

                    <div class="row">

                      <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group" >
                          <label class="col-md-12" >Cupom de Desconto:</label>
                          <div class="col-md-12">
                            <input name="cupom" type="text" class="form-control" value="<?=$data->cupom?>" disabled >
                          </div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group" >
                          <label class="col-md-12" >Promoção:</label>
                          <div class="col-md-12">
                            <input name="cupom_promocao" type="text" class="form-control" value="<?=$data->cupom_promocao?>" disabled >
                          </div>
                        </div>
                      </div>

                    </div>

                    <div style="padding-top:10px;" ><hr></div>

                    <div class="row">

                      <div class="col-xs-12 col-sm-6 col-md-6">         

                        <div class="form-group" >
                          <label class="col-md-12" >Total do Pedido:</label>
                          <div class="col-md-12">
                            <input name="valor_total" type="text" class="form-control" value="<?=$valor_total?>" disabled >
                          </div>
                        </div>

                        <div class="form-group" >
                          <label class="col-md-12" >Valor Pago:</label>
                          <div class="col-md-12">
                            <input name="valor_pago" type="text" class="form-control" value="<?=$valor_pago?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                          </div>
                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-6 col-md-6">


                        <div class="form-group" >
                          <label class="col-md-12" >Forma de Pagamento:</label>
                          <div class="col-md-12">
                            <input name="forma_pagamento" type="text" class="form-control" value="<?=$forma_pagamento?>" disabled >
                            <?php
                            if($data->comprovante){
                              echo "<div class='pedido_anexo' ><a href='".PASTA_CLIENTE."anexos_pedidos/".$data->codigo."/".$data->comprovante."' target='_blank' >COMPROVANTE</a></div>
                              ";
                            }
                            ?>

                          </div>
                        </div>
                        
                        <div class="form-group" >
                          <label class="col-md-12" >Codigo da Transação:</label>
                          <div class="col-md-12">
                            <input name="id_transacao" type="text" class="form-control" value="<?=$data->id_transacao?>" >
                          </div>
                        </div>

                      </div>

                    </div>

                    <div style="padding-top:10px;" ><hr></div>
                    
                    <div class="row">

                      <?php if($data->frete_balcao){ ?>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group" >
                            <label class="col-md-12" >Frete:</label>
                            <div class="col-md-12">
                              <input name="frete_titulo" type="text" class="form-control" value="Retirada em balcão - <?=$data->frete_titulo?>" disabled >
                            </div>
                          </div>
                        </div>

                      <?php } else { ?>

                        <div class="col-xs-12 col-sm-6 col-md-6">
                          <div class="form-group" >
                            <label class="col-md-12" >Frete:</label>
                            <div class="col-md-12">
                              <input name="frete_titulo" type="text" class="form-control" value="<?=$data->frete_titulo?>" disabled >
                            </div>
                          </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6">
                          <div class="form-group" >
                            <label class="col-md-12" >Cep Consultado:</label>
                            <div class="col-md-12">
                              <input name="cep_destino" type="text" class="form-control" value="<?=$data->cep_destino?>" disabled >
                            </div>
                          </div>
                        </div>

                      <?php } ?>

                    </div>

                    <div class="row">

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" >
                          <label class="col-md-12" >Código de Envio (Rastreamento): </label>
                          <div class="col-md-12">
                            <input name="codigo_envio" type="text" class="form-control" value="<?=$data->codigo_envio?>" >
                          </div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" >
                          <label class="col-md-12" >Observações de envio: </label>
                          <div class="col-md-12"> 
                            <?php
                            echo $data->frete_obs;
                            ?> 
                          </div>
                        </div>
                      </div>

                    </div>

                    <div style="padding-top:10px;" ><hr></div>

                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">         

                        <div class="form-group" >
                          <label class="col-md-12" >Status:</label>
                          <div class="col-md-12">
                            <select data-plugin-selectTwo class="form-control" name="status" >
                              <?php
                              
                              foreach ($lista_status as $key => $value) {                 
                                
                                if($value['selected']){ $sel = "selected"; } else { $sel = ""; }
                                echo "<option value='".$value['codigo']."' $sel >".$value['status']."</option>";

                              }

                              ?>
                            </select>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div style="padding-top:10px;" ><hr></div>

                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">  
                        <?php if($data->cadastro){ ?>

                          <button type="button" class="btn btn-primary" onClick="submit()">Salvar Alterações</button>

                        <?php } ?>

                        <button type="button" class="btn btn-default" onClick="window.open('<?=$_base['objeto']?>imprimir/pedido/<?=$data->codigo?>', '_blank');">Imprimir</button>

                        <button type="button" class="btn btn-default" onClick="window.open('<?=$_base['objeto']?>etiqueta/pedido/<?=$data->codigo?>', '_blank');">Imprimir Etiqueta</button>

                        <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>
                      </div>
                    </div>

                  </div>

                </form>
              </section> 





            </div>
            <div class="col-md-5">



              <section class="panel">

                <header class="panel-heading" style="background-color:#ddd">      
                  <h2 class="panel-title" style="font-size:16px; padding-top: 5px; padding-bottom: 5px; font-weight: bold; text-align: center;">
                  INFORMAÇÕES DO CLIENTE</h2>
                </header>

                <div class="panel-body">

                  <fieldset>

                    <?php if(isset($data_cadastro->email)){ ?>

                      <div class="form-group" >
                        <label class="col-md-12" >E-mail</label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" value="<?=$data_cadastro->email?>" >
                        </div>
                      </div>

                      <?php if($data_cadastro->fisica_nome){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >Nome</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->fisica_nome?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <div class="row" >
                        <div class="col-md-6" >

                          <?php if($data_cadastro->fisica_sexo){ ?>
                            <div class="form-group" >
                              <label class="col-md-12" >Sexo</label>
                              <div class="col-md-12">
                                <input type="text" class="form-control" value="<?=$data_cadastro->fisica_sexo?>" >
                              </div>
                            </div>
                          <?php } ?>

                        </div>
                        <div class="col-md-6" >

                          <?php if($data_cadastro->fisica_nascimento){ ?>
                            <div class="form-group" >
                              <label class="col-md-12" >Nascimento</label>
                              <div class="col-md-12">
                                <input type="text" class="form-control" value="<?=date('d/m/Y', $data_cadastro->fisica_nascimento)?>" >
                              </div>
                            </div>
                          <?php } ?>

                        </div>
                      </div>

                      <?php if($data_cadastro->fisica_cpf){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >CPF</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->fisica_cpf?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($data_cadastro->fisica_rg){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >RG</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->fisica_rg?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($data_cadastro->juridica_nome){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >Nome Fantasia</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->juridica_nome?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($data_cadastro->juridica_razao){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >Razão Social</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->juridica_razao?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($data_cadastro->juridica_responsavel){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >Responsável</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->juridica_responsavel?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($data_cadastro->juridica_cnpj){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >CNPJ</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->juridica_cnpj?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($data_cadastro->juridica_ie){ ?>
                        <div class="form-group" >
                          <label class="col-md-12" >IE</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" value="<?=$data_cadastro->juridica_ie?>" >
                          </div>
                        </div>
                      <?php } ?>

                      <div class="form-group" >
                        <label class="col-md-12" >Cep</label>
                        <div class="col-md-12">
                          <input id="cep" type="text" class="form-control" value="<?=$data_cadastro->cep?>" >
                        </div>
                      </div>

                      <div class="form-group" >
                        <label class="col-md-12" >Endereço</label>
                        <div class="col-md-12">
                          <input name="endereco" type="text" class="form-control" value="<?=$data_cadastro->endereco?>" >
                        </div>
                      </div>

                      <div class="row" >
                        <div class="col-md-5" >

                          <div class="form-group" >
                            <label class="col-md-12" >Número</label>
                            <div class="col-md-12">
                              <input name="numero" type="text" class="form-control" value="<?=$data_cadastro->numero?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-7" >

                          <div class="form-group" >
                            <label class="col-md-12" >Complemento</label>
                            <div class="col-md-12">
                              <input name="complemento" type="text" class="form-control" value="<?=$data_cadastro->complemento?>" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="form-group" >
                        <label class="col-md-12" >Bairro</label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" value="<?=$data_cadastro->bairro?>" >
                        </div>
                      </div>

                      <div class="form-group" >
                        <label class="col-md-12" >Cidade/Estado</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" value="<?=$data_cadastro->cidade?>">
                        </div>
                        <div class="col-md-4">
                          <input type="text" class="form-control" value="<?=$data_cadastro->estado?>" >
                        </div>
                      </div>

                      <div class="form-group" >
                        <label class="col-md-12" >Telefone</label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" value="<?=$data_cadastro->telefone?>" >
                        </div>
                      </div>

                    <?php } else { ?>

                      <div style="padding-top: 40px; padding-bottom: 40px; text-align:center;">Este cliente não fez o login</div>

                    <?php } ?>

                  </fieldset>

                </div>

                <div class="panel-footer">
                  <div class="row">
                    <div class="col-md-6">
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
    <script src="<?=LAYOUT?>api/nestable/examples.nestable.js"></script>s
    <script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
    <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
    <script src="<?=LAYOUT?>js/funcoes.js"></script>

    <script src="<?=LAYOUT?>js/ajuda.js"></script> 

  </body>
  </html>