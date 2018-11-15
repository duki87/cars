<?php
  require_once('db/db.php');
  require_once('db/baseurl.php');
  $baseurl = baseurl();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dusan Marinkovic">
    <title>Auto berza</title>
    <link rel="shortcut icon" type="image/jpg" href="../images/porsche.jpg">
    <script src="<?=$baseurl.'assets/jquery/jquery-3.3.1.min.js';?>"></script>
    <script src="<?=$baseurl.'assets/bootstrap/js/bootstrap.min.js';?>"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/datatables.min.js"></script>
    <link rel="stylesheet" href="<?=$baseurl.'assets/bootstrap/css/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?=$baseurl.'assets/bootstrap/css/bootstrap-grid.min.css';?>">
    <link rel="stylesheet" href="<?=$baseurl.'assets/styles/style.css';?>">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/datatables.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

  </head>
  <body style="background-color:#00264d;">
    <div class="container">
      <header class="header-background custom-header" style="width: 100%;height: 400px;background-image: url('<?=$baseurl.'images/porsche.jpg';?>');background-position: top; background-size: 100% 99%; background-repeat:no-repeat; position:relative">
        <nav class="navbar navbar-expand-md navbar-dark nav-custom">
          <a class="navbar-brand" href="#">Auto berza</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <?php if(isset($_SESSION['admin']['admin_id'])) { ?>
            <ul class="navbar-nav">
              <li class="nav-item dropdown" style="">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-list-ul"></i> Kategorije
                </a>
                <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item dropdown-item-custom" href="manage_categories.php">Upravljaj kategorijama</a>
                  <a class="dropdown-item dropdown-item-custom" href="add_category.php">Dodaj kategoriju</a>
                </div>
              </li>

              <li class="nav-item dropdown" style="">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-industry"></i> Brendovi
                </a>
                <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item dropdown-item-custom" href="manage_brands.php">Upravljaj brendovima</a>
                  <a class="dropdown-item dropdown-item-custom" href="add_brand.php">Dodaj brend</a>
                </div>
              </li>

              <li class="nav-item dropdown" style="">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-car"></i> Modeli
                </a>
                <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item dropdown-item-custom" href="manage_models.php">Upravljaj modelima</a>
                  <a class="dropdown-item dropdown-item-custom" href="add_model.php">Dodaj model</a>
                </div>
              </li>

              <li class="nav-item dropdown" style="">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fab fa-adversal"></i> Oglasi
                </a>
                <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item dropdown-item-custom" href="#">Upravljaj oglasima</a>
                  <a class="dropdown-item dropdown-item-custom" href="#">Dodaj oglas</a>
                </div>
              </li>

              <li class="nav-item dropdown" style="">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user"></i> Korisnici
                </a>
                <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item dropdown-item-custom" href="#">Upravljaj korisnicima</a>
                </div>
              </li>
            </ul>
            <ul class="navbar-nav ul-custom ml-auto">
              <li class="nav-item">
                <span class="nav-link disabled">Korisnik: <?=$_SESSION['admin']['admin_username'];?></span>
              </li>
              <li class="nav-item">
                <button type="button" name="admin_profile" value="" class="btn btn-primary"><i class="fas fa-users-cog"></i></button>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li>
              <li class="nav-item">
                <form action="process/admin_process.php" method="post">
                  <button type="submit" name="logout" value="" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i></button>
                </form>
              </li>
            </ul>
            <?php } ?>
          </div>
        </nav>
      </header>
      <div class="container main-content">
