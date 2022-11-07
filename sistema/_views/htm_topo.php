<?php include_once('base.php'); ?>

<header class="main-header">

  <a href="<?=DOMINIO?>" class="logo">
    <span class="logo-mini"><img src="<?=LAYOUT?>img/favicon.png" style="width:25px;" ></span>
    <span class="logo-lg" style="text-align:left;"><img src="<?=$_base['logo']?>" style="height:36px;"></span>
  </a>

  <nav class="navbar navbar-static-top">

    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" onclick="altera_menu();" style="font-size:16px; padding-top: 15px; padding-bottom: 10px;">
       <i class="fas fa-bars"></i>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <li class="dropdown user user-menu">

          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?=$_base['conta_imagem']?>" class="user-image">
            <span class="hidden-xs"><?=$_base['conta_nome']?></span>
          </a>

          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header" onclick="window.location='<?=DOMINIO?>perfil/inicial/aba/imagem';" style="cursor: pointer;">
              <img src="<?=$_base['conta_imagem']?>" class="img-circle" alt="Usuario">

              <p>
                <?=$_base['conta_nome']?>
                <small><?=$_base['conta_email']?></small>
              </p>
            </li>
            <div style="margin-top:0px; width: 100%; text-align: center;">
              <a href="<?=DOMINIO?>perfil" class="btn btn-default btn-flat"><i class="fa fa-edit"></i> Alterar Perfil</a>
            </div>
            <div style="margin-top:10px; padding-bottom:20px; width: 100%; text-align: center;">
              <a href="<?=DOMINIO?>autenticacao/logout" class="btn btn-default btn-flat"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>