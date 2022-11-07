<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">

  <fieldset>


    <div class="form-group">
      <label class="col-md-12">Grupo</label>
      <div class="col-md-12">
        <select name="grupo" class="form-control select2" style="width: 100%;" >
          <option value='' selected >Selecione</option>
          <?php
          foreach ($grupos as $key => $value) {

            echo "<option value='".$value['codigo']."' ".$selected." >".$value['titulo']."</option>";

          }
          ?>
        </select>
      </div>
    </div>

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

<script>
  $(function () {

    $(".select2").select2();

  });  
</script> 