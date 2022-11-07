<?php include_once('base.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title><?=TITULO_VIEW?></title>
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
  body {
    background: #FFF;
  }
  .info{
    font-size:12px;
    color:#000;
    margin-top:10px;
  }  
</style>

</head>
<body onload="self.print();" style="width:700px;" >
 
  <section class="panel">
   
    <div class="panel-body">

      <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-6">

          <div class="info" >Pedido: <?=$data->id?></div>
          <div class="info" >Data: <?=date('d/m/y H:i', $data->data)?></div>
          <div class="info" >Valor de Produtos: R$ <?=$valor_produtos?></div>
          <div class="info" >Descontos: R$ <?=$descontos?></div>
          <div class="info" >Cupom de Desconto: <?=$data->cupom?></div>
          <div class="info" >Promoção: <?=$data->cupom_promocao?></div>
          
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
          
          <div class="info" >Frete: <?=$data->frete_titulo?></div>
          <div class="info" >Valor do Frete: <?=$data->frete_valor?></div>
          <div class="info" >Cep Consultado: <?=$data->cep_destino?></div>
          <div class="info" >Código de Envio (Rastreamento): <?=$data->codigo_envio?></div>

        </div>

      </div>

      <div style="padding-top:10px;" ><hr></div>

      <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-6">

          <div class="info" >Valor Pago: R$ <?=$valor_pago?></div>
          <div class="info" >Forma de Pagamento: <?=$data->forma_pagamento?></div>
          <div class="info" >Codigo da Transação: <?=$data->id_transacao?></div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
         
          <div class="info" >Status: 
            <?php
            foreach ($lista_status as $key => $value) {
              if($value['selected']){
                echo $value['status'];
              }
            }
            ?>
          </div> 

        </div>

      </div>

      <div style="padding-top:10px;" ><hr></div>     
      
    </div>

  </section>


  <section class="panel"> 

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

    

  </section>

  <section class="panel">

    <hr>
    
    <h2 class="panel-title" style="font-size:16px; padding-bottom: 20px; padding-top: 10px;">Informações do Cliente</h2>
    
    <div class="row">    

      <div class="col-xs-6 col-sm-6 col-md-6">

        <div class="infos"><strong>E-mail:</strong> <?=$data_cadastro->email?> </div>
        
        <?php if($data_cadastro->fisica_nome){ ?>
          <div class="infos"><strong>Nome:</strong> <?=$data_cadastro->fisica_nome?> </div>
        <?php } ?>

        <?php if($data_cadastro->fisica_sexo){ ?>
          <div class="infos"><strong>Sexo:</strong> <?=$data_cadastro->fisica_sexo?> </div>
        <?php } ?>

        <?php if($data_cadastro->fisica_nascimento){ ?>
          <div class="infos"><strong>Nascimento:</strong> <?=date('d/m/Y', $data_cadastro->fisica_nascimento)?> </div>
        <?php } ?>

        <?php if($data_cadastro->fisica_cpf){ ?>
          <div class="infos"><strong>CPF:</strong> <?=$data_cadastro->fisica_cpf?> </div>
        <?php } ?>

        <?php if($data_cadastro->juridica_nome){ ?>
          <div class="infos"><strong>Nome Fantasia:</strong> <?=$data_cadastro->juridica_nome?> </div>
        <?php } ?>

        <?php if($data_cadastro->juridica_razao){ ?>
          <div class="infos"><strong>Razão Social:</strong> <?=$data_cadastro->juridica_razao?> </div>
        <?php } ?>

        <?php if($data_cadastro->juridica_responsavel){ ?>
          <div class="infos"><strong>Responsável:</strong> <?=$data_cadastro->juridica_responsavel?> </div>
        <?php } ?>

        <?php if($data_cadastro->juridica_cnpj){ ?>
          <div class="infos"><strong>CNPJ:</strong> <?=$data_cadastro->juridica_cnpj?> </div>
        <?php } ?>

        <?php if($data_cadastro->juridica_ie){ ?>
          <div class="infos"><strong>IE:</strong> <?=$data_cadastro->juridica_ie?>" > </div>
        <?php } ?>

      </div>

      <div class="col-xs-6 col-sm-6 col-md-6">

        <div class="infos"><strong>Cep:</strong> <?=$data_cadastro->cep?> </div>
        
        <div class="infos"><strong>Endereço:</strong> <?=$data_cadastro->endereco?> </div>

        <div class="infos"><strong>Número:</strong> <?=$data_cadastro->numero?> </div>

        <div class="infos"><strong>Complemento:</strong> <?=$data_cadastro->complemento?> </div>

        <div class="infos"><strong>Bairro:</strong> <?=$data_cadastro->bairro?> </div>
        
        <div class="infos"><strong>Cidade/Estado:</strong> <?=$data_cadastro->cidade?> - <?=$data_cadastro->estado?> </div>
        
        <div class="infos"><strong>Telefone:</strong> <?=$data_cadastro->telefone?> </div>     

      </div>

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