<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>alterar_imagem_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

  <fieldset>

    <div class="form-group">
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

  </fieldset>
  
  <button type="submit" class="btn btn-primary">Enviar</button>
  <button type="button" class="btn btn-default" onClick="confirma('<?=$_base['objeto']?>apagar_imagem/codigo/<?=$codigo?>');"  >Remover Imagem</button>
  <input type="hidden" name="codigo" value="<?=$codigo?>">

</form>