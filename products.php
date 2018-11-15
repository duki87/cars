<?php
  require_once('db/db.php');
  require_once('process/domain.php');
  include('parts/header.php');
?>
    <br>
    <div class="row row-custom">
      <div class="col-md-12">
        <h2 class="text-warning" style="font-weight:bold;">Proizvodi nase pivare</h2>
        <hr>
      </div>
      <div class="col-md-4 col-sm-4">
        <div class="card card-custom" style="">
          <img class="card-img-top" src="images/hom.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Homoljsko pivo</h5>
            <p class="card-text">Svetlo homoljsko pivo veoma izrazenog ukusa. Savrseno u svakoj prilici!</p>
            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" style="background-color:#996633 ">Procitaj jos</a>
            <a href="#" class="btn btn-warning" style="background-color:#663300">Kupi</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-sm-4">
        <div class="card card-custom" style="">
          <img class="card-img-top" src="images/hom.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Homoljsko pivo</h5>
            <p class="card-text">Svetlo homoljsko pivo veoma izrazenog ukusa. Savrseno u svakoj prilici!</p>
            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" style="background-color:#996633 ">Procitaj jos</a>
            <a href="#" class="btn btn-warning" style="background-color:#663300">Kupi</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-sm-4">
        <div class="card card-custom" style="">
          <img class="card-img-top" src="images/hom.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Homoljsko pivo</h5>
            <p class="card-text">Svetlo homoljsko pivo veoma izrazenog ukusa. Savrseno u svakoj prilici!</p>
            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" style="background-color:#996633 ">Procitaj jos</a>
            <a href="#" class="btn btn-warning" style="background-color:#663300">Kupi</a>
          </div>
        </div>
      </div>
    </div>
    <?php include('parts/product-details.php'); ?>
<?php
  include('parts/footer.php');
?>
