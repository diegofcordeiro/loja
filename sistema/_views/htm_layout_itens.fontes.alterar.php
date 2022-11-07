<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>fontes_alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

  <fieldset>

    <div class="form-group">
      <label class="col-md-12" >Titulo</label>
      <div class="col-md-12">
        <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
      </div>
    </div>
    
    <div class="form-group">
      <label class="col-md-12" >Fonte Family</label>
      <div class="col-md-12">
        <input name="family" type="text" class="form-control" value="<?=$data->family?>"  >
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Tipo</label>
      <div class="col-md-12">
        <select name="tipo" class="form-control select2" style="width: 100%;" >
          <option value="arquivo" <?php if($data->tipo == 'arquivo'){ echo " selected='' "; } ?> >Arquivo</option>
          <option value="css" <?php if($data->tipo == 'css'){ echo " selected='' "; } ?> >Link CSS</option>
        </select>
      </div>
    </div> 

    <div class="form-group">
      <label class="col-md-12" >Link do css</label>
      <div class="col-md-12">
        <textarea name="endereco" class="form-control" style="height: 50px;" ><?=$data->endereco?></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12">Arquivo</label> 
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

  <div>
    <button type="submit" class="btn btn-primary">Salvar</button> 
    <input name="codigo" type="hidden" value="<?=$data->codigo?>" >
  </div>

</form>