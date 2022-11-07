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

                <div class="row">

                  <div class="col-xs-12 col-sm-6 col-md-6">                     

                    <div class="form-group" >
                      <label class="col-md-12" >Anúncios Limite</label>
                      <div class="col-md-12">
                        <input name="plano_limite" type="text" class="form-control" value="<?=$data->plano_limite?>" >
                      </div>
                    </div>

                    <div class="form-group" >
                      <label class="col-md-12" >Periodo (meses)</label>
                      <div class="col-md-12">
                        <input name="plano_periodo_meses" type="text" class="form-control" value="<?=$data->plano_periodo_meses?>" >
                      </div>
                    </div>   

                    <div class="form-group" >
                      <label class="col-md-12" >Periodo (dias)</label>
                      <div class="col-md-12">
                        <input name="plano_periodo_dias" type="text" class="form-control" value="<?=$data->plano_periodo_dias?>" >
                      </div>
                    </div>                     

                    <div class="form-group" >
                      <label class="col-md-12" >Total do Pedido:</label>
                      <div class="col-md-12">
                        <input name="valor_total" type="text" class="form-control" value="<?=$valor?>" >
                      </div>
                    </div>

                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">

                    <div class="form-group" >
                      <label class="col-md-12" >Anúncios Disponíveis</label>
                      <div class="col-md-12">
                        <input name="plano_utilizado" type="text" class="form-control" value="<?=$data->plano_utilizado?>" >
                      </div>
                    </div>

                    <div class="form-group" >
                      <label class="col-md-12" >Codigo da Transação:</label>
                      <div class="col-md-12">
                        <input name="id_transacao" type="text" class="form-control" value="<?=$data->id_transacao?>" >
                      </div>
                    </div>

                    <div class="form-group" >
                      <label class="col-md-12" >Status:</label>
                      <div class="col-md-12">
                        <input name="status" type="text" class="form-control" value="<?=$status?>" >
                      </div>
                    </div>

                  </div>

                </div>


                <div style="padding-top:10px;" ><hr></div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php if($data->status != 2){ ?>
                      <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>ativar/codigo/<?=$data->codigo?>');">Ativar Manualmente</button>
                    <?php } ?>

                     
                  </div>
                </div>

              </div>

            </form>


            <header class="panel-heading" style="background-color:#ddd">      
              <h2 class="panel-title" style="font-size:16px; padding-top: 5px; padding-bottom: 5px; font-weight: bold; text-align: center;">
              INFORMAÇÕES DE UTILIZAÇÕES</h2>
            </header>

            <div class="panel-body">

              <div>
                <?php

                $n = 0;
                foreach ($utilizados as $key => $value) {
                  
                  echo "
                  <div stye='margin-top:10px;' >".$value['data']." - Ref. ".$value['ref']."</div>";

                  $n++;
                }

                if($n == 0){
                  echo "<div style='text-align:center; padding:20px;'>Nenhum resultado</div>";
                }
                ?>
              </div>

              <hr>

              <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';">Voltar</button>

            </div>

             

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