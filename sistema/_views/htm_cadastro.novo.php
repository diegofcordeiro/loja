<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post" >

  <fieldset>

    <div class="form-group">
      <label class="col-md-12">Tipo</label>
      <div class="col-md-12">
        <select class="form-control select2" name="tipo" style="width: 100%;">
          <option value="J" >Pessoa Jurídica</option>
          <option value="F" >Pessoa Física</option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label class="col-md-12" >Nome</label>
      <div class="col-md-12">
        <input name="nome" type="text" class="form-control" >
      </div>
    </div>

  </fieldset>

  <button type="submit" class="btn btn-primary">Salvar</button>

</form>

<script>
  $(function () {

    $(".select2").select2();

  });
</script>
<script src="<?=LAYOUT?>js/ajuda.js"></script>
