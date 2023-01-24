<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title><?=$data_pagina->meta_titulo?></title>
	<link rel="shortcut icon" href="<?=$_base['favicon'];?>" />

	<meta name="description" content="<?=$data_pagina->meta_descricao?>" />
	<meta property="og:description" content="<?=$data_pagina->meta_descricao?>" />
	<meta name="author" content="<?=AUTOR?>" />
	<meta name="classification" content="Website" />
	<meta name="robots" content="index, follow" />
	<meta name="Indentifier-URL" content="<?=DOMINIO?>" />
	
	<link href="<?=LAYOUT?>api/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>api/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>api/fontawesome/css/all.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>css/animate.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>api/hover-master/css/hover-min.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>css/main.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>css/custom.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>css/responsiveslides.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>api/bxslider/jquery.bxslider.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>api/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css" rel="stylesheet" type="text/css" />
  <link href="<?=LAYOUT?>api/select2/select2.min.css" rel="stylesheet" type="text/css" >
  <link href="<?=LAYOUT?>api/photobox-master/photobox/photobox.css" rel="stylesheet" type="text/css">  

  
  <?php include_once('htm_css.php'); ?>
  <?php include_once('htm_css_resp.php'); ?>
  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Roboto';
    }
  </style>
</head>
<body>

  <?=$_base['analytics']?>

  <?php include_once('htm_modal.php'); ?>

  <?php

  function monta_sub_categorias_prod($lista, $id, $controller, $conteudo_id, $selecionado){

    $retorno = array();
    $retorno['lista'] = false;
    $retorno['ativo'] = false;

    foreach ($lista as $key_subprod => $value_subprod) {

      $collapse = " collapse";

      if(!$retorno['ativo']){
        if($value_subprod['codigo'] == $selecionado){
          $retorno['ativo'] = true;
          $collapse = "";
        }
      }

      $filhos = monta_sub_categorias_prod($value_subprod['subcategorias'], $value_subprod['id'], $controller, $conteudo_id, $selecionado);

      if(!$retorno['ativo']){
        if($filhos['ativo']){
          $retorno['ativo'] = true;
          $collapse = "";
        }
      }

      if($filhos['lista']){

        $retorno['lista'] .= "
        <li id='cate_".$value_subprod['id']."' >
        <a data-toggle='collapse' data-parent='#cate_".$value_subprod['id']."' href='#catepai_".$conteudo_id."_".$value_subprod['id']."' >".$value_subprod['titulo']."</a> 

        <ul id='catepai_".$conteudo_id."_".$value_subprod['id']."' class='panel-collapse ".$collapse."'  >
        ".$filhos['lista']."
        </ul>
        </li>";

      } else {

        $endereco_cat = DOMINIO.$controller."/inicial/categoria_".$conteudo_id."/".$value_subprod['codigo'].'/#section-produtos-'.$conteudo_id;
        
        $retorno['lista'] .= "
        <li >
        <a href='".$endereco_cat."' >".$value_subprod['titulo']."</a>
        </li>";

      }
    }

    return $retorno;
  }

  foreach ($layout_lista as $key_layout => $value_layout) {
    if($value_layout['img_fundo']){
      $imgfundo = " background-image:url(".PASTA_CLIENTE."imagens/".$value_layout['img_fundo']."); background-repeat: no-repeat; background-size: cover; background-position:center; ";
    } else {
      $imgfundo = "";
    }
    echo "<div style='background-color:".$value_layout['cor_fundo']."; $imgfundo '>";
    if($value_layout['full'] != 1){
      echo "<div class='container' >";
    } else {
      echo "<div class='container-fluid' style='padding-right: 0px; padding-left: 0px;' >";
    }
    echo "<div class='row' style='padding-right: 0px; padding-left: 0px; margin-left:0px; margin-right:0px;' >";
    
    if($value_layout['colunas'] == 1){
      ?>
      <div class="col-md-12 corrige_cedulas_principais">
        <?php
        $conteudo_coluna = $value_layout['coluna1'];
        $conteudo_id = $conteudo_coluna['id'];
        $conteudo_sessao = $conteudo_coluna['conteudo'];
        // print_r($conteudo_coluna['tipo']);
        include 'htm_conteudo_'.$conteudo_coluna['tipo'].'.php';
        ?>
        <div style="clear:both; "></div>
      </div>
    <?php }

    echo "
    </div>
    ";
    echo "
    </div>
    </div>
    ";
  }

  ?>


  <script type="text/javascript" src="<?=LAYOUT?>js/jquery-2.2.4.min.js" ></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
  <script type="text/javascript" src="<?=LAYOUT?>api/jquery-ui-1.12.1/jquery-ui.min.js"></script>  
  <script type="text/javascript" src="<?=LAYOUT?>api/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
  <script type="text/javascript" >function dominio(){ return '<?=DOMINIO?>'; }</script>
  <script type="text/javascript" src="<?=LAYOUT?>js/funcoes.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script type="text/javascript" src="<?=LAYOUT?>js/animation.js"></script>
  <script type="text/javascript" src="<?=LAYOUT?>js/responsiveslides.min.js"></script>
  <script type="text/javascript" src="<?=LAYOUT?>api/select2/select2.full.min.js"></script>
  <script type="text/javascript" src="<?=LAYOUT?>api/bxslider/jquery.bxslider.js"></script>
  <script type="text/javascript" src="<?=LAYOUT?>api/photobox-master/photobox/jquery.photobox.js"></script>

  <?php 


  foreach ($layout_lista as $key_layout => $value_blocos) {
    $n_col = 1;
    while ($n_col <= $value_blocos['colunas']) {

      $value_layout = $value_blocos['coluna'.$n_col];

      if(isset($value_layout['tipo'])){

        if($value_layout['tipo'] == 'topo'){

          $conteudo_id = $value_layout['id'];
          $conteudo_sessao = $value_layout['conteudo'];
          $id_script = '#slider_topo_'.$conteudo_id;

          ?>
          <script>

            <?php if($conteudo_sessao['data_topo']->modelo  == 11){ ?>

              $("<?=$id_script?>").responsiveSlides({
                auto: true,
                pager: false,
                nav: false,
                speed: 500,
                pause: true,
                pauseControls: true,
                namespace: "callbacks",
                before: function () {
                  $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                  $('.events').append("<li>after event fired.</li>");
                }
              });

            <?php } ?>

            $(document).ready(function(){
              $(window).on('scroll', function() {
                var posicao_topo = $(window).scrollTop();


                <?php if($conteudo_sessao['data_topo']->modelo  == 6){ ?>

                  if(posicao_topo > 100){          
                    $(".topo6").addClass("topo6_decendo");
                  }
                  if(posicao_topo < 100){          
                    $(".topo6").removeClass("topo6_decendo");
                  }

                <?php } ?>

                <?php if($conteudo_sessao['data_topo']->modelo  == 7){ ?>

                  if(posicao_topo > 100){          
                    $(".topo7").addClass("topo7_decendo");
                  }
                  if(posicao_topo < 100){          
                    $(".topo7").removeClass("topo7_decendo");
                  }

                <?php } ?>

                <?php if($conteudo_sessao['data_topo']->modelo  == 8){ ?>

                  if(posicao_topo > 100){          
                    $(".topo8").addClass("topo8_decendo");
                  }
                  if(posicao_topo < 100){          
                    $(".topo8").removeClass("topo8_decendo");
                  }

                <?php } ?>

                <?php if($conteudo_sessao['data_topo']->modelo  == 9){ ?>

                  if(posicao_topo > 100){          
                    $(".topo9").addClass("topo9_decendo");
                  }
                  if(posicao_topo < 100){          
                    $(".topo9").removeClass("topo9_decendo");
                  }

                <?php } ?>

                <?php if($conteudo_sessao['data_topo']->modelo  == 10){ ?>

                  if(posicao_topo > 100){          
                    $(".topo10").addClass("topo10_decendo");
                  }
                  if(posicao_topo < 100){          
                    $(".topo10").removeClass("topo10_decendo");
                  }

                <?php } ?>
                
                <?php if($conteudo_sessao['data_topo']->modelo  == 13){ ?>

                  if(posicao_topo > 100){          
                    $(".topo13").addClass("topo13_decendo");
                  }
                  if(posicao_topo < 100){          
                    $(".topo13").removeClass("topo13_decendo");
                  }

                <?php } ?>

              });
            });

          </script>

          <?php
        }

        if($value_layout['tipo'] == 'banner'){      
          $conteudo_id = $value_layout['id'];
          $id_script = '#slider_'.$conteudo_id;
          ?>
          <script>

            $("<?=$id_script?>").responsiveSlides({
              auto: true,
              pager: true,
              nav: true,
              speed: 500,
              pause: true,
              pauseControls: true,
              namespace: "callbacks",
              before: function () {
                $('.events').append("<li>before event fired.</li>");
              },
              after: function () {
                $('.events').append("<li>after event fired.</li>");
              }
            });

          </script>
          <?php
        }


        if($value_layout['tipo'] == 'cadastro_email'){ 
          $conteudo_id = $value_layout['id'];
          ?>
          <script type="text/javascript">
            function cadastro_news_<?=$conteudo_id?>(){
              var nome = $('#news_nome_<?=$conteudo_id?>').val();
              var email = $('#news_email_<?=$conteudo_id?>').val();
              modal('<?=DOMINIO?><?=$controller?>/cadastro_email/email/'+email+'/nome/'+nome+'/grupo/<?=$value_layout['codigo']?>');
            }
          </script>
          <?php
        }


        if($value_layout['tipo'] == 'rastreamento'){ 
          $conteudo_id = $value_layout['id'];
          ?>
          <script type="text/javascript">
            function enviar_rastr_<?=$conteudo_id?>(){

              $('#modal_conteudo').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");
              $('#modal_janela').modal('show');

              var rastreio_codigo = $('#rastreio_codigo_<?=$conteudo_id?>').val();

              $.post('<?=DOMINIO?><?=$controller?>/rastreamento_detalhes', { rastreio_codigo: rastreio_codigo },function(data){
                if(data){
                  $('#modal_conteudo').html(data);
                }
              });

            }
          </script>
          <?php
        }


        if($value_layout['tipo'] == 'cadastro_fone'){ 
          $conteudo_id = $value_layout['id'];
          ?>
          <script type="text/javascript">
            function cadastro_fone_<?=$conteudo_id?>(){
              var nome = $('#news_fone_nome_<?=$conteudo_id?>').val();
              var fone = $('#news_fone_numero_<?=$conteudo_id?>').val();
              modal('<?=DOMINIO?><?=$controller?>/cadastro_fone/fone/'+fone+'/nome/'+nome+'/grupo/<?=$value_layout['codigo']?>');
            }
          </script>
          <?php
        }



        if($value_layout['tipo'] == 'contador'){ 
          $conteudo_id = $value_layout['id'];
          $contadores_lista = $value_layout['conteudo']['lista'];
          ?>

          <script type="text/javascript">

            (function ($){
              $.fn.counter = function() {
                const $this = $(this),
                numberFrom = parseInt($this.attr('data-from')),
                numberTo = parseInt($this.attr('data-to')),
                delta = numberTo - numberFrom,
                deltaPositive = delta > 0 ? 1 : 0,
                time = parseInt($this.attr('data-time')),
                changeTime = 10;

                let currentNumber = numberFrom,
                value = delta*changeTime/time;
                var interval1;
                const changeNumber = () => {
                  currentNumber += value;

                  (deltaPositive && currentNumber >= numberTo) || (!deltaPositive &&currentNumber<= numberTo) ? currentNumber=numberTo : currentNumber;
                  this.text(parseInt(currentNumber));
                  currentNumber == numberTo ? clearInterval(interval1) : currentNumber;  
                }

                interval1 = setInterval(changeNumber,changeTime);
              }
            }(jQuery));

            var iniciocont_<?=$conteudo_id?> = 0;

            $(document).ready(function(){
              $(window).on('scroll', function() {
                var pos1_<?=$conteudo_id?> = $(window).scrollTop();
                var pos2_<?=$conteudo_id?> = $('#section-contador-<?=$conteudo_id?>').offset().top;
                var pos3_<?=$conteudo_id?> = $(window).height() / 1.15;
                if( pos1_<?=$conteudo_id?> > (pos2_<?=$conteudo_id?> - pos3_<?=$conteudo_id?>) ){
                  iniciacontagem_<?=$conteudo_id?>(iniciocont_<?=$conteudo_id?>);
                  iniciocont_<?=$conteudo_id?> = 1;
                }
                if( pos1_<?=$conteudo_id?> < (pos2_<?=$conteudo_id?> - pos3_<?=$conteudo_id?>) ){
                  iniciocont_<?=$conteudo_id?> = 0;
                }      
              });
            });

            function iniciacontagem_<?=$conteudo_id?>(inicio){
              if(inicio == 0){
                <?php
                foreach ($contadores_lista as $key => $value) {
                  ?>

                  $('.count_<?=$value['codigo']?>').counter();

                <?php } ?>
              }
            }

          </script>

          <?php
        }

        if($value_layout['tipo'] == 'contato'){ 
          $conteudo_id = $value_layout['id'];
          $contato_lista = $value_layout['conteudo']['lista'];

          ?>

          <script>
            function envia_contato_<?=$conteudo_id?>(){

              $('#modal_conteudo').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");
              $('#modal_janela').modal('show');

              var dados = $("#form-contato-<?=$conteudo_id?>").serialize();

              $.post('<?=DOMINIO?><?=$controller?>/contato_enviar', dados,function(data){
                if(data){
                  $('#modal_conteudo').html(data);
                }
              });

            }
          </script>

          <?php
        }    
        ?>


        <?php
        if($value_layout['tipo'] == 'cadastro'){ 
          $conteudo_id = $value_layout['id'];
          ?>

          <script>
            function tipo_cadastro(tipo){
              if(tipo == 'J'){
                $('#fisica').hide();
                $('#juridica').show();                
              } else {
                $('#juridica').hide();
                $('#fisica').show();
              }
            }

            function cadastro_cidades(estado, cidade = null){

              $('#cadastro_cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:250px;' ></div>");

              $.post('<?=DOMINIO?><?=$controller?>/cidades', {estado: estado, cidade: cidade},function(data){
                if(data){
                  $('#cadastro_cidade_div').html(data);
                }
              });

            }
            cadastro_cidades('AC');        

            function buscar_endereco(){

              var cep = $('#cadastro_cep').val();

              $.post('<?=DOMINIO?><?=$controller?>/busca_endereco_cep', {cep: cep},function(data){
                if(data){

                  var filtro = data.replace(/^\s+|\s+$/g, "");
                  var retorno = JSON.parse(filtro); 

                  $('#cadastro_endereco').val(retorno.endereco);
                  $('#cadastro_bairro').val(retorno.bairro);
                  $('#cadastro_endereco').val(retorno.endereco);
                  $('#cadastro_estado').val(retorno.estado).trigger('change');

                  cadastro_cidades(retorno.estado, retorno.cidade);

                }
              });

            }

            function finalizar_cadastro(){

              $('#modal_janela').modal('show');
              $('#modal_conteudo').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");

              var dados = $("#cadastro_form").serialize();

              $.post('<?=DOMINIO?><?=$controller?>/finalizar_cadastro', dados,function(data){
                if(data){
                  $('#modal_conteudo').html(data);
                }
              });

            }

          </script>

          <?php
        }    
        ?> 


        <?php

        if($value_layout['tipo'] == 'duvidas'){ 
          $conteudo_id = $value_layout['id'];

          ?>

          <script>
            function duvidas_respostas_<?=$conteudo_id?>(codigo){

              $('#duvidas_div-<?=$conteudo_id?>').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");

              $.post('<?=DOMINIO?><?=$controller?>/duvidas_respostas', {codigo: codigo} ,function(data){
                if(data){
                  $('#duvidas_div-<?=$conteudo_id?>').html(data);
                }
              });

            }
            duvidas_respostas_<?=$conteudo_id?>('<?=$primeira_duvida?>');
          </script>

          <?php
        }    
        ?>


        <?php

        if($value_layout['tipo'] == 'parceiros'){ 
          $conteudo_id = $value_layout['id'];
          $conteudo_config = $value_layout['conteudo']['data_grupo'];       
          ?>

          <script type="text/javascript">
            $('#parceiros-<?=$conteudo_id?>').bxSlider({
              controls : true,
              pager : true,
              minSlides : <?=$conteudo_config->itens_por_linha?>,
              maxSlides : <?=$conteudo_config->itens_por_linha?>,
              slideWidth :300,
              slideMargin :15
            });

          </script>

          <?php 

        }

        ?>

        <?php

        if($value_layout['tipo'] == 'enquete'){ 
          $conteudo_id = $value_layout['id'];  
          ?>

          <script type="text/javascript">

            function votar_<?=$conteudo_id?>(){

              $('#modal_janela').modal('show');
              $('#modal_conteudo').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");

              var dados = $("#enquete_<?=$conteudo_id?>").serialize();

              $.post('<?=DOMINIO?><?=$controller?>/enquete_votar', dados,function(data){
                if(data){
                  $('#modal_conteudo').html(data);
                }
              });

            }

          </script>

          <?php

        }

        ?>


        <?php

        if($value_layout['tipo'] == 'videos'){ 
          $conteudo_id = $value_layout['id']; 
          $videos_config = $value_layout['conteudo']['data_grupo'];

          if($videos_config->mostrar_categorias == 1){
            ?>

            <script>
              function videos_categoria_<?=$conteudo_id?>(categoria){

                $('#videos_div-<?=$conteudo_id?>').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");

                $.post('<?=DOMINIO?><?=$controller?>/videos_categoria', {categoria: categoria, itens_por_linha: '<?=$videos_config->itens_por_linha?>', mostrar_titulo_video: '<?=$videos_config->mostrar_titulo_video?>' } ,function(data){
                  if(data){
                    $('#videos_div-<?=$conteudo_id?>').html(data);
                  }
                });

              }
              videos_categoria_<?=$conteudo_id?>('<?=$primeiro_video?>');
            </script>

            <?php
          }
        }

        ?>


        <?php

        if($value_layout['tipo'] == 'audios'){ 
          $conteudo_id = $value_layout['id']; 
          $audios_config = $value_layout['conteudo']['data_grupo'];

          if($audios_config->mostrar_categorias == 1){
            ?>

            <script>
              function audios_categoria_<?=$conteudo_id?>(categoria){

                $('#audios_div-<?=$conteudo_id?>').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");

                $.post('<?=DOMINIO?><?=$controller?>/audios_categoria', {categoria: categoria, itens_por_linha: '<?=$audios_config->itens_por_linha?>', mostrar_titulo_video: '<?=$audios_config->mostrar_titulo_video?>' } ,function(data){
                  if(data){
                    $('#audios_div-<?=$conteudo_id?>').html(data);
                  }
                });

              }
              audios_categoria_<?=$conteudo_id?>('<?=$primeiro_audio?>');
            </script>

            <?php
          }
        }

        ?>


        <?php

        if($value_layout['tipo'] == 'fotos'){ 
          $conteudo_id = $value_layout['id']; 
          $fotos_config = $value_layout['conteudo']['data_grupo'];

          if($fotos_config->mostrar_categorias == 1){
            ?>

            <script>
              function fotos_categoria_<?=$conteudo_id?>(categoria){

                $('#fotos_div-<?=$conteudo_id?>').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='width:25px;'></div>");

                $.post('<?=DOMINIO?><?=$controller?>/fotos_categoria', {categoria: categoria, itens_por_linha: '<?=$fotos_config->itens_por_linha?>', formato:'<?=$fotos_config->formato?>', max_itens:'<?=$fotos_config->max_itens?>' } ,function(data){
                  if(data){
                    $('#fotos_div-<?=$conteudo_id?>').html(data);
                  }
                });

              }
              fotos_categoria_<?=$conteudo_id?>('<?=$primeiras_fotos?>');
            </script>

            <?php
          }
        }

        ?>



        <?php

        if($value_layout['tipo'] == 'produtos'){ 
          $conteudo_id = $value_layout['id']; 
          $prod_config = $value_layout['conteudo']['data_grupo'];

          if($prod_config->formato == 2){
            ?>
            <script>

              $(document).ready(function () {

                var owl = $('.produtos_destaques_<?=$conteudo_id?>');
                owl.owlCarousel({
                  autoplay: true,
                  autoplayTimeout: 7000,
                  nav: true,
                  navText:["", ""],
                  dots: true,
                  margin:30,
                  loop: true,
                  responsive: {
                    0: {
                      items: 1
                    },
                    600: {
                      items: 2
                    },
                    1000: {
                      items: <?=$prod_config->itens_por_linha?>
                    }
                  }
                });

              });

            </script>
            <?php
          }
        }

        ?>


        <?php

        if($value_layout['tipo'] == 'imoveis'){ 
          $conteudo_id = $value_layout['id']; 
          $imo_config = $value_layout['conteudo']['data_grupo'];      
          $imovel_cidade_selecionada = $value_layout['conteudo']['cidade_selecionada'];
          $imovel_bairro_selecionado = $value_layout['conteudo']['bairro_selecionado'];
          if($imo_config->tipo == 0){
           ?>

           <script>

            function slideSwitch_<?=$conteudo_id?>() {

              var $active = $('#slideshow_<?=$conteudo_id?> DIV.active');

              if( $active.length == 0 ) $active = $('#slideshow_<?=$conteudo_id?> DIV:last');

              var $next =  $active.next().length ? $active.next() : $('#slideshow_<?=$conteudo_id?> DIV:first');

              $active.addClass('last-active');

              $next.css({opacity: 0.0})
              .addClass('active')
              .animate({opacity: 1.0}, 1000, function() {
                $active.removeClass('active last-active');
              });
            }
            setInterval("slideSwitch_<?=$conteudo_id?>()", 3000);


            function carrega_bairros_<?=$conteudo_id?>(cidade, bairro = null){
              var endereco_arquivo = '<?=DOMINIO?><?=$controller?>/carrega_bairros';
              $.post(endereco_arquivo, {cidade: cidade, bairro:bairro},function(data){
                if(data){
                  $('#bairros_lista_<?=$conteudo_id?>').html(data);
                }
              });
            }
            carrega_bairros_<?=$conteudo_id?>('<?=$imovel_cidade_selecionada?>', '<?=$imovel_bairro_selecionado?>');


            function carrega_bairros_det_<?=$conteudo_id?>(cidade, bairro = null){
              var endereco_arquivo = '<?=DOMINIO?><?=$controller?>/carrega_bairros';
              $.post(endereco_arquivo, {cidade: cidade, bairro:bairro},function(data){
                if(data){
                  $('#bairros_lista_det_<?=$conteudo_id?>').html(data);
                }
              });
            }
            carrega_bairros_det_<?=$conteudo_id?>('<?=$imovel_cidade_selecionada?>', '<?=$imovel_bairro_selecionado?>');


            function troca_faixa_preco_<?=$conteudo_id?>(tipo){
              if(tipo == '5280'){
                $('#preco_alugar_<?=$conteudo_id?>').show();
                $('#preco_comprar_<?=$conteudo_id?>').hide();
              } else {
                $('#preco_alugar_<?=$conteudo_id?>').hide();
                $('#preco_comprar_<?=$conteudo_id?>').show();
              }
            }

          </script>

          <script>
            $( function() {

              $( "#slider-range_alugar_<?=$conteudo_id?>" ).slider({
                range: true,
                min: 100,
                max: 50000,
                values: [ <?=$imo_alugar_valor_min;?>, <?=$imo_alugar_valor_max;?> ],
                slide: function( event, ui ) {

                  var min_tratado = ui.values[ 0 ].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                  var max_tratado = ui.values[ 1 ].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

                  $( "#imov_amount_alugar_<?=$conteudo_id?>" ).val(min_tratado + " - " + max_tratado );

                  $( "#alugar_valor_min_<?=$conteudo_id?>" ).val( ui.values[ 0 ] );
                  $( "#alugar_valor_max_<?=$conteudo_id?>" ).val( ui.values[ 1 ] );
                }
              });
              var min_tratado = $( "#slider-range_alugar_<?=$conteudo_id?>" ).slider( "values", 0 ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
              var max_tratado = $( "#slider-range_alugar_<?=$conteudo_id?>" ).slider( "values", 1 ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
              $( "#imov_amount_alugar_<?=$conteudo_id?>" ).val( min_tratado + " - " + max_tratado );


              $( "#slider-range_comprar_<?=$conteudo_id?>" ).slider({
                range: true,
                min: 5000,
                max: 10000000,
                values: [ <?=$imo_comprar_valor_min;?>, <?=$imo_comprar_valor_max;?> ],
                slide: function( event, ui ) {

                  var min_tratado = ui.values[ 0 ].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                  var max_tratado = ui.values[ 1 ].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

                  $( "#imov_amount_comprar_<?=$conteudo_id?>" ).val(min_tratado + " - " + max_tratado );
                  $( "#comprar_valor_min_<?=$conteudo_id?>" ).val( ui.values[ 0 ] );
                  $( "#comprar_valor_max_<?=$conteudo_id?>" ).val( ui.values[ 1 ] );
                }
              });
              var min_tratado = $( "#slider-range_comprar_<?=$conteudo_id?>" ).slider( "values", 0 ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
              var max_tratado = $( "#slider-range_comprar_<?=$conteudo_id?>" ).slider( "values", 1 ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
              $( "#imov_amount_comprar_<?=$conteudo_id?>" ).val( min_tratado + " - " + max_tratado );

            });
          </script>

          <?php
        }

        if($imo_config->tipo == 2){
          ?>
          <script>

            $('#imoveis_destaques_<?=$conteudo_id?>').bxSlider({
              controls : true,
              pager : true,
              minSlides : 1,
              maxSlides : <?=$imo_config->itens_por_linha?>,
              slideWidth :260,
              slideMargin :15
            });

          </script>
          <?php
        }

        if($imo_config->tipo == 3){
          ?>
          <script>

            $(document).ready(function () {

              var owl = $('.imoveis_destaques_<?=$conteudo_id?>');
              owl.owlCarousel({
                autoplay: true,
                autoplayTimeout: 7000,
                nav: true,
                navText:["", ""],
                dots: true,
                margin:30,
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 2
                  },
                  1000: {
                    items: 3
                  }
                }
              });

            });

          </script>
          <?php
        }


      }

      ?>



      <?php

      if($value_layout['tipo'] == 'garagem'){ 
        $conteudo_id = $value_layout['id']; 
        $gara_config = $value_layout['conteudo']['data_grupo'];      

        if($gara_config->tipo == 0){
         ?>

         <script>

          function slideSwitch_<?=$conteudo_id?>() {

            var $active = $('#slideshow_<?=$conteudo_id?> DIV.active');

            if( $active.length == 0 ) $active = $('#slideshow_<?=$conteudo_id?> DIV:last');

            var $next =  $active.next().length ? $active.next() : $('#slideshow_<?=$conteudo_id?> DIV:first');

            $active.addClass('last-active');

            $next.css({opacity: 0.0})
            .addClass('active')
            .animate({opacity: 1.0}, 1000, function() {
              $active.removeClass('active last-active');
            });
          }
          setInterval("slideSwitch_<?=$conteudo_id?>()", 3000);

        </script>

        <?php
      }


      if($gara_config->tipo == 1){
        ?>
        <script type="text/javascript">
          function garagem_filtrar_preco(filtro_url_item){


            var garagem_precoMinimo = $("#garagem_precoMinimo option:selected").val();
            var garagem_precoMaximo = $("#garagem_precoMaximo option:selected").val();

            if(garagem_precoMinimo > 0){
              if(garagem_precoMaximo > 0){

                window.location = filtro_url_item+'/gara_val_min/'+garagem_precoMinimo+'/gara_val_max/'+garagem_precoMaximo;

              } 
            }

          }
          
          function garagem_filtros() {
            $('#garagem_filtros_div').toggle(); 
          }
          
        </script> 
        <?php
      }

      if($gara_config->tipo == 2){
        ?>
        <script>

          $('#garagem_destaques_<?=$conteudo_id?>').bxSlider({
            controls : true,
            pager : true,
            minSlides : 1,
            maxSlides : <?=$gara_config->itens_por_linha?>,
            slideWidth :260,
            slideMargin :15
          });

        </script>
        <?php
      }

      if( ($gara_config->tipo == 2) OR ($gara_config->tipo == 3) ){
        ?>
        <script>

          $(document).ready(function () {

            var owl = $('.garagem_destaques_<?=$conteudo_id?>');
            owl.owlCarousel({
              autoplay: true,
              autoplayTimeout: 7000,
              nav: true,
              navText:["", ""],
              dots: true,
              margin:30,
              loop: true,
              responsive: {
                0: {
                  items: 1
                },
                600: {
                  items: 2
                },
                1000: {
                  items: 3
                }
              }
            });

          });

        </script>
        <?php
      }


    }

    ?>


    <?php

    if($value_layout['tipo'] == 'postagens'){ 
      $conteudo_id = $value_layout['id']; 
      $post_config = $value_layout['conteudo']['data_grupo'];       

      if($post_config->formato == 1){

        ?>
        <script>

          $(document).ready(function () {

            var owl = $('.postagens_destaques_<?=$conteudo_id?>');
            owl.owlCarousel({
              autoplay: true,
              autoplayTimeout: 7000,
              nav: true,
              navText:["", ""],
              dots: true,
              margin:30,
              loop: true,
              responsive: {
                0: {
                  items: 1
                },
                600: {
                  items: 2
                },
                1000: {
                  items: 3
                },
                1200: {
                  items: <?=$conteudo_config->itens_por_linha?>
                }
              }
            });

          });

        </script>
        <?php

      }

    }

    ?>




    <?php

    if($value_layout['tipo'] == 'classificados'){ 
      $conteudo_id = $value_layout['id']; 
      $clas_config = $value_layout['conteudo']['data_grupo'];      
      $anuncio_cidade_selecionada = $value_layout['conteudo']['cidade_selecionada'];

      if($clas_config->tipo == 0){
       ?>

       <script>

        function slideSwitch_<?=$conteudo_id?>() {

          var $active = $('#slideshow_<?=$conteudo_id?> DIV.active');

          if( $active.length == 0 ) $active = $('#slideshow_<?=$conteudo_id?> DIV:last');

          var $next =  $active.next().length ? $active.next() : $('#slideshow_<?=$conteudo_id?> DIV:first');

          $active.addClass('last-active');

          $next.css({opacity: 0.0})
          .addClass('active')
          .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
          });
        }
        setInterval("slideSwitch_<?=$conteudo_id?>()", 3000);

        function carrega_bairros_<?=$conteudo_id?>(cidade){
          var endereco_arquivo = '<?=DOMINIO?><?=$controller?>/carrega_bairros_cla';
          $.post(endereco_arquivo, {cidade: cidade, bairro: '<?=$classificados_bairro_selecionado?>'},function(data){
            if(data){
              $('#bairros_lista_<?=$conteudo_id?>').html(data);
            }
          });
        }
        carrega_bairros_<?=$conteudo_id?>('<?=$anuncio_cidade_selecionada?>');


        function carrega_bairros_det_<?=$conteudo_id?>(cidade){
          var endereco_arquivo = '<?=DOMINIO?><?=$controller?>/carrega_bairros_cla';
          $.post(endereco_arquivo, {cidade: cidade, bairro: '<?=$classificados_bairro_selecionado?>'},function(data){
            if(data){
              $('#bairros_lista_det_<?=$conteudo_id?>').html(data);
            }
          });
        }
        carrega_bairros_det_<?=$conteudo_id?>('<?=$classificados_cidade_selecionada?>');

        $(".classificados_opcoes").on('change', function(){
          var checked = $(this)[0].checked;
          var id = $(this)[0].value;
          if(checked)
            $('#cla_opcoes_label_'+id).addClass("classificados_opcoes_label2").removeClass("classificados_opcoes_label");
          else 
            $('#cla_opcoes_label_'+id).addClass("classificados_opcoes_label").removeClass("classificados_opcoes_label2");
        });

      </script>

      <script>
        $( function() {

          $( "#slider-range_<?=$conteudo_id?>" ).slider({
            range: true,
            min: 50,
            max: 5000,
            values: [ <?=$cla_valor_min;?>, <?=$cla_valor_max;?> ],
            slide: function( event, ui ) {

              var min_tratado = ui.values[ 0 ].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
              var max_tratado = ui.values[ 1 ].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

              $( "#cla_amount_<?=$conteudo_id?>" ).val(min_tratado + " - " + max_tratado );

              $( "#valor_min_<?=$conteudo_id?>" ).val( ui.values[ 0 ] );
              $( "#valor_max_<?=$conteudo_id?>" ).val( ui.values[ 1 ] );
            }
          });
          var min_tratado = $( "#slider-range_<?=$conteudo_id?>" ).slider( "values", 0 ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
          var max_tratado = $( "#slider-range_<?=$conteudo_id?>" ).slider( "values", 1 ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
          $( "#cla_amount_<?=$conteudo_id?>" ).val( min_tratado + " - " + max_tratado );

        });
      </script>

      <?php
    }

    if($clas_config->tipo == 2){
      ?>
      <script>

        $(document).ready(function () {

          var owl = $('.classificados_destaques_<?=$conteudo_id?>');
          owl.owlCarousel({
            autoplay: true,
            autoplayTimeout: 7000,
            nav: true,
            navText:["", ""],
            dots: true,
            margin:30,
            loop: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 2
              },
              1000: {
                items: 3
              }
            }
          });

        });

      </script>
      <?php
    }


  }

  ?>




  <?php

}

$n_col++;
}

}

?>

<script>
  $(function () {

    $(".select2").select2();

    $('.ampliar_imagem').photobox('a',{ time:0 });

  });
</script>

<?php

if(count($banner_popup) != 0){

  $popup = false;
  foreach ($banner_popup as $key => $value) {
    if(!$popup){

      if($value['link']){
        $endereco = " href='".$value['link']."' target='_blank' ";
      } else {
        $endereco = "";
      }

      $popup = "<a $endereco ><img src='".$value['imagem']."' style='width:100%;' ></a>";

    }
  }

  if(!isset($_SESSION['popinicial'])){

    ?>

    <script>
      $(document).ready(function() {
        $('#modal_conteudo').html("<div style='text-align:center;' ><?=$popup?></div>");
        $('#modal_janela').modal('show');
      });
    </script>

    <?php

    $_SESSION['popinicial'] = true;

  }

}

?>

<?php if($data_pagina->bloqueio == 1){ ?>

  <script type="text/javascript">

    $(document).ready(function(){
      $(document).bind("contextmenu",function(e){
        return false;
      });

      $('body').bind('contextmenu', function(event) {
        event.preventDefault();
      });

      $('body').bind('selectstart dragstart', function(event) {
        event.preventDefault();
        return false;
      });

      $("body").bind("cut copy paste", function() {
        return false;
      });

      $('body').focus(function() {
        $(this).blur();
      });

    });
  </script>

<?php } ?>

<script type="text/javascript">
  function ordena_lista(endereco){
    window.location=''+endereco;
  } 
</script> 


</body>
</html>