<?php include_once('base.php'); ?>
<aside class="main-sidebar">
  <section class="sidebar">

    <div style="text-align: center; width: 100%;margin-top: 15px;">
      <input type="text" name="filtro_menu" id="filtro_menu" class="form-control" style="border-radius:4px; border-color:#666; display:inline-block; width:90%; background-color: transparent; color:#fff;" >
    </div>
    
    <ul class="sidebar-menu">
      
      <li class="header">NAVEGAÇÃO</li>
      
      <?php
      foreach ($_base['menu_lateral'] as $key => $value) {
// echo '<pre>';print_r($_base['menu_lateral']);exit;
        if($value['ativo']){ $menu_ativo = "active"; } else { $menu_ativo = ""; }
        
        echo "
        <li class='menulateralfiltro treeview ".$menu_ativo."' >
        <a href='".DOMINIO.$value['endereco']."'>
        <i class='".$value['icone']."'></i> <span>".$value['titulo']."</span>
        </a>
        </li>
        ";
        
      }
      ?>
      
    </ul>
  </section>
</aside>
 