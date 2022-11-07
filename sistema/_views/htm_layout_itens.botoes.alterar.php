<?php include_once('base.php'); ?>

<div class="nav-tabs-custom">

  <ul class="nav nav-tabs">

    <li class='active' >
      <a href="#dados" data-toggle="tab">Dados</a>
    </li>
    <li>
      <a href="#imagem" data-toggle="tab">Imagem de fundo</a>
    </li>
    <li>
      <a href="#cores" data-toggle="tab">Cores</a>
    </li>

  </ul>

  <div class="tab-content" >

    <div id="dados" class="tab-pane active" >

      <form action="<?=$_base['objeto']?>botoes_alterar_grv" class="form-horizontal" method="post">

        <fieldset>

          <div class="form-group">
            <label class="col-md-12" >Titulo</label>
            <div class="col-md-12">
              <input type="text" class="form-control" name="titulo" value="<?=$data->titulo?>" ></input>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-12" >Texto</label>
            <div class="col-md-12">
              <textarea name="texto" class="summernote" ><?=$data->texto?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-12" >Borda largura</label>
            <div class="col-md-12">
              <input name="borda" type="text" class="form-control" value="<?=$data->borda?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-12" >Borda arredondada</label>
            <div class="col-md-12">
              <input name="borda_radius" type="text" class="form-control" value="<?=$data->borda_radius?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
            </div>
          </div>


          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-md-12" >Espaçamento Topo</label>
                <div class="col-md-12">
                  <input name="padding_top" type="text" class="form-control" value="<?=$data->padding_top?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
                </div>
              </div> 
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-md-12" >Espaçamento Esquerda</label>
                <div class="col-md-12">
                  <input name="padding_left" type="text" class="form-control" value="<?=$data->padding_left?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
                </div>
              </div> 
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-md-12" >Espaçamento Direita</label>
                <div class="col-md-12">
                  <input name="padding_right" type="text" class="form-control" value="<?=$data->padding_right?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
                </div>
              </div> 
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-md-12" >Espaçamento Baixo</label>
                <div class="col-md-12">
                  <input name="padding_bottom" type="text" class="form-control" value="<?=$data->padding_bottom?>" onkeypress="Mascara(this,Integer)" onKeyDown="Mascara(this,Integer)" >
                </div>
              </div> 
            </div>
            
          </div>

        </fieldset>

        <div>
          <button type="submit" class="btn btn-primary">Salvar</button> 
          <input name="codigo" type="hidden" value="<?=$data->codigo?>" >
        </div>

      </form>

    </div>


    <div id="imagem" class="tab-pane" >

     <?php if(!$data->imagem_fundo){ ?>    

      <form action="<?=$_base['objeto']?>botoes_imagem/codigo/<?=$data->codigo?>" method="post" enctype="multipart/form-data">

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
        </div>

      </form>

    <?php } else { ?>

      <div style="text-align:left;">
        <img src="<?=PASTA_CLIENTE?>img_botoes/<?=$data->imagem_fundo?>" style="max-width:300px;" >
      </div>

      <div style="text-align:left; padding-top:10px;">
        <button type="button" class="btn btn-primary" onClick="confirma('<?=$_base['objeto']?>botoes_imagem_apagar/codigo/<?=$data->codigo?>');" >Apagar Imagem</button>
      </div>

    <?php } ?>

  </div> 


  <div id="cores" class="tab-pane" >

    <form action="<?=$_base['objeto']?>botoes_cores_grv" class="form-horizontal" method="post" >

      <fieldset>

        <div class='form-group' >
          <label class='col-md-12' >Fundo</label>
          <div class='col-md-12'>
            <input name='cor_fundo' type='text' class='form-control my-colorpicker1' value='<?=$data->cor_fundo?>' autocomplete='off' >
          </div>
        </div>

        <div class='form-group' >
          <label class='col-md-12' >Borda</label>
          <div class='col-md-12'>
            <input name='cor_borda' type='text' class='form-control my-colorpicker1' value='<?=$data->cor_borda?>' autocomplete='off' >
          </div>
        </div>

        <div class='form-group' >
          <label class='col-md-12' >Texto</label>
          <div class='col-md-12'>
            <input name='cor_texto' type='text' class='form-control my-colorpicker1' value='<?=$data->cor_texto?>' autocomplete='off' >
          </div>
        </div>

        <div class='form-group' >
          <label class='col-md-12' >Selecionado Fundo</label>
          <div class='col-md-12'>
            <input name='cor_sel_fundo' type='text' class='form-control my-colorpicker1' value='<?=$data->cor_sel_fundo?>' autocomplete='off' >
          </div>
        </div>

        <div class='form-group' >
          <label class='col-md-12' >Selecionado Borda</label>
          <div class='col-md-12'>
            <input name='cor_sel_borda' type='text' class='form-control my-colorpicker1' value='<?=$data->cor_sel_borda?>' autocomplete='off' >
          </div>
        </div>

        <div class='form-group' >
          <label class='col-md-12' >Selecionado Texto</label>
          <div class='col-md-12'>
            <input name='cor_sel_texto' type='text' class='form-control my-colorpicker1' value='<?=$data->cor_sel_texto?>' autocomplete='off' >
          </div>
        </div>

      </fieldset>

      <button type="submit" class="btn btn-primary">Salvar</button>
      <input name="codigo" type="hidden" value="<?=$data->codigo?>" >

    </form>

  </div>


</div>

</div> 

<script>
 $(function(){

  $(".my-colorpicker1").colorpicker();


});
</script> 
<?php include_once('js_summernote.php'); ?>