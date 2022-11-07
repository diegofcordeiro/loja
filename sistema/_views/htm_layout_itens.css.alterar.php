<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>css_alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

  <fieldset>

    <div class="form-group">
      <label class="col-md-12" >Titulo</label>
      <div class="col-md-12">
        <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
      </div>
    </div> 

    <div class="form-group">
      <label class="col-md-12" >Conteúdo da classe</label>
      <div class="col-md-12">
        <textarea name="conteudo" class="form-control" style="height: 100px;" ><?=$data->conteudo?></textarea>
      </div>
    </div>

  </fieldset>

  <div>
    <button type="submit" class="btn btn-primary">Salvar</button> 
    <input name="codigo" type="hidden" value="<?=$data->codigo?>" >
  </div>

</form>