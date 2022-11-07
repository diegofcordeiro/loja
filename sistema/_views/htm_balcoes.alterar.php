<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post" >

  <fieldset>

    <div class="form-group">
      <label class="col-md-12">Estado</label>
      <div class="col-md-12">
        <select name="uf" class="form-control select2" style="width: 100%;" onChange="cidades(this.value)"  >
          <option value='' selected >Selecione</option>
          <?php
          foreach ($estados as $key => $value) {

            if($data->uf == $value['uf']){
              $selected = " selected='' ";
            } else {
              $selected = "";
            }

            echo "<option value='".$value['uf']."' $selected >".$value['nome']."</option>";

          }
          ?>  
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12">Cidade</label>
      <div class="col-md-12" id="cidade_div" >
        <select id="cidade" name="cidade" class="form-control login_form" >
          <option value='' >Selecione</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Titulo</label>
      <div class="col-md-12">
        <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Descrição</label>
      <div class="col-md-12">
        <textarea name="descricao" class="form-control" style="height: 100px;" ><?=$data->descricao?></textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label class="col-md-12" >Valor R$ (opcional)</label>
      <div class="col-md-12">
        <input name="valor" type="text" class="form-control" value="<?=$valor?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" />
      </div>
    </div>
    
  </fieldset>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
  <input type="hidden" name="codigo" value="<?=$data->codigo?>">

</form>

<script>

  function cidades(estado){

    $('#cidade_div').html("<div style='text-align:center;'><img src='<?=LAYOUT?>img/loading.gif' style='border:0px; width:30px;' ></div>");
    
    $.post('<?=DOMINIO?>balcoes/cidades', {estado: estado, cidade: '<?=$data->cidade?>'},function(data){
      if(data){
        $('#cidade_div').html(data);
      }
    });
    
  }
  cidades('<?=$data->uf?>');

</script>