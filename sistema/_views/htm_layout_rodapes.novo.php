<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">

  <fieldset>

    <div class="form-group">
      <label class="col-md-12" >Titulo</label>
      <div class="col-md-12">
        <input name="titulo" type="text" class="form-control" >
      </div>
    </div>
    
  </fieldset>
  
  <div>
    <button type="submit" class="btn btn-primary">Salvar</button> 
  </div>

</form>