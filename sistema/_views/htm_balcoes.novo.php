<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post" >

  <fieldset>

    <div class="form-group">
      <label class="col-md-12">Estado</label>
      <div class="col-md-12">
        <select name="uf" class="form-control select2" style="width: 100%;" onChange="cidades(this.value)"  >
          <option value='' selected >Selecione</option>
          <?php
          foreach ($estados as $key => $value) {
            echo "<option value='".$value['uf']."' >".$value['nome']."</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12">Cidade</label>
      <div class="col-md-12" id="cidade_div" >
        <select id="cidade" name="cidade" class="form-control select2" style="width: 100%;" >
          <option value='' >Selecione</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Titulo</label>
      <div class="col-md-12">
        <input name="titulo" type="text" class="form-control" >
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Descrição</label>
      <div class="col-md-12">
        <textarea name="descricao" class="form-control" style="height: 100px;" ></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Valor R$ (opcional)</label>
      <div class="col-md-12">
        <input name="valor" type="text" class="form-control" value="0,00" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" />
      </div>
    </div>

  </fieldset>

  <button type="submit" class="btn btn-primary">Salvar</button>

</form>

<script>
  $(function () {

    $(".select2").select2();

  });

  function cidades(estado){

    $('#cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:30px;' ></div>");
    
    $.post('<?=DOMINIO?>balcoes/cidades', {estado: estado},function(data){
      if(data){
        $('#cidade_div').html(data);
      }
    });
    
  }
  
</script>