<?php include_once('base.php'); ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post">

  <fieldset>

    <div class="form-group">
      <label class="col-md-12">Setor <?=ajuda('Posição do banner');?></label>
      <div class="col-md-12">
        <select name="grupo" class="form-control select2" style="width: 100%;" >
          <option value='' selected >Selecione</option>
          <?php
          foreach ($grupos as $key => $value) {

            if($value['codigo'] == $grupo_selecionado){
              $selected = " selected ";
            } else {
              $selected = "";
            }

            echo "<option value='".$value['codigo']."' ".$selected." >".$value['titulo']."</option>";

          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Titulo <?=ajuda('O titulo não aparece no site');?></label>
      <div class="col-md-12">
        <input name="titulo" type="text" class="form-control" >
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-12" >Frase (opcional)</label>
      <div class="col-md-12">
        <textarea name="texto" class="summernote" ></textarea>
     </div>
   </div>

   <div class="form-group">
    <label class="col-md-12" >Endereço <?=ajuda('Link de destino quando clicar no banner (opcional).')?></label>
    <div class="col-md-12">
      <input name="endereco" type="text" class="form-control" >
    </div>
  </div>

</fieldset>

<div>
  <button type="submit" class="btn btn-primary">Salvar</button>
  <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>inicial/grupo/<?=$grupo?>';" >Voltar</button>
</div>

</form>
<script>
  $(function(){

    $(".select2").select2();

  });
</script>

<script src="<?=LAYOUT?>js/ajuda.js"></script> 

<?php include_once('js_summernote.php'); ?>