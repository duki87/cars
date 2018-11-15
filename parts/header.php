<?php
  require_once('db/db.php');
  require_once('db/baseurl.php');
  $baseurl = baseurl();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dusan Marinkovic">
    <title>Auto berza</title>
    <link rel="shortcut icon" type="image/jpg" href="images/porsche.jpg">
    <script src="<?=$baseurl.'assets/jquery/jquery-3.3.1.min.js';?>"></script>
    <link rel="stylesheet" href="<?=$baseurl.'assets/bootstrap/css/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?=$baseurl.'assets/bootstrap/css/bootstrap-grid.min.css';?>">
    <link rel="stylesheet" href="<?=$baseurl.'assets/styles/style.css';?>">
    <link rel="stylesheet" href="<?=$baseurl.'assets/styles/vehicle_gallery.css';?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  </head>
  <body style="background-color:#00264d;">
    <div class="container">
      <header class="header-background custom-header" style="width: 100%;height: 400px;background-image: url('<?=$baseurl.'images/porsche.jpg';?>');background-position: top; background-size: 100% 99%; background-repeat:no-repeat">
        <nav class="navbar navbar-expand-sm navbar-dark nav-custom" style="z-index:999">
          <a class="navbar-brand" href="#">Auto berza</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar" style="z-index:999">
            <ul class="navbar-nav">
              <li class="nav-item ul-custom">
                <a class="nav-link" href="#"><i class="fas fa-industry"></i> Novosti</a>
              </li>
              <li class="nav-item ul-custom">
                <a class="nav-link" href="add_vehicle.php"><i class="fas fa-write"></i> Postavi oglas</a>
              </li>

              <li class="nav-item dropdown ul-custom">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-car"></i> Oglasi
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item custom-drop" href="selling_adds.php">Vozila</a>
                  <a class="dropdown-item custom-drop" href="#">Delovi</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item ul-custom">
                <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Osiguranje</a>
              </li>
              <?php if(!isset($_SESSION['user']['user_id'])) { ?>
              <li class="nav-item ul-custom">
                <a class="nav-link" href="signin.php"><i class="fas fa-user-alt"></i> Prijavi se</a>
              </li>
            <?php } else { ?>
              <li class="nav-item ul-custom">
                <a class="nav-link" href="#"><i class="fas fa-user-alt"></i> Profil</a>
              </li>
              <li class="nav-item ul-custom">
                <a class="nav-link" href="poruke.php" id="user_messages"><i class="fas fa-envelope"></i> Poruke
                  <?php // if(isset($_SESSION['user']['messages'])) { ?>
                  <?php //} ?></a>
              </li>
              <li class="nav-item ul-custom">
                <form action="process/user_process.php" method="post" id="logout_form">
                  <button type="submit" class="nav-link" name="logout_user" name="button" style="background:none; border:0; cursor:pointer"><i class="fas fa-sign-out-alt"></i> Odjavi se</button>
                </form>
              </li>
            <?php } ?>
            </ul>

            <ul class="navbar-nav ul-custom ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fab fa-facebook-square fa-2x"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fab fa-instagram fa-2x"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <div class="container main-content">
