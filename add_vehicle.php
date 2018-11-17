<?php
  require_once('db/db.php');
  include('parts/header.php');
  if(!isset($_SESSION['user']['user_id'])) {
    header("Location: http://localhost/cars/signin.php");
    $_SESSION['message']['error'] = 'Morate se prijaviti da biste postavili oglas! Ukoliko nemate nalog, registrujte se.';
  }
?>

<div class=""><br>
  <div id="vehicle_message"></div>
  <form class="" id="add_vehicle" method="post" enctype="multipart/form-data">
    <h3 class="" style="color:gold; border-bottom: 1px solid gold"><i class="fas fa-car"></i> Dodaj nov oglas</h3>
    <div class="row" style="color:white">
      <div class="col-md-6">
        <div class="form-group">
          <label for="title">Naslov oglasa</label>
          <input type="text" name="title" id="title" value="" class="form-control" placeholder="Unesite naslov">
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="price">Cena</label>
          <input type="text" step="0.1" min="1" name="price" id="price" value="" class="form-control" placeholder="Unesite cenu" onkeypress = "return AllowNumbersOnly(event)">
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="monet">Valuta</label>
          <select name="monet" id="monet" value="" class="form-control">
            <option value="">Izaberite</option>
            <option value="dinar">dinar</option>
            <option value="evro">evro</option>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="monet">Ili umesto cene:</label>
          <select name="price_other" id="price_other" value="" class="form-control">
            <option value="">Izaberite</option>
            <option value="Kontakt">Kontakt</option>
            <option value="Dogovor">Dogovor</option>
          </select>
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label for="select_category">Prvo Izaberite kategoriju vozila*</label>
          <select class="form-control" id="select_category" name="select_category" ></select>
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label for="select_brand">Izaberite proizvodjaca vozila*</label>
          <select class="form-control" id="select_brand" name="select_brand" >
            <option value="">Prvo odaberite kategoriju</option>
          </select>
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label for="select_model">Izaberite model vozila*</label>
          <select class="form-control" id="select_model" name="select_model" >
            <option value="">Prvo odaberite kategoriju i proizvodjaca</option>
          </select>
        </div>
      </div>
      <hr>
      <div class="col-md-12">
        <h5 style="color:gold">Osnovni podaci o vozilu</h5>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label for="volume">Zapremina motora* (cm<sup>3</sup>)</label>
          <input type="text" name="volume" id="volume" value="" class="form-control" min="1"  onkeypress="return AllowNumbersOnly(event)">
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label for="power">Snaga motora*</label>
          <input type="text" name="power" id="power" value="" class="form-control" min="1" onkeypress="return AllowNumbersOnly(event)">
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="power-units">kW/KS*</label>
          <select class="form-control" name="power_units" id="power_units">
            <option value="kW">kW</option>
            <option value="KS">KS</option>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="fuel">Gorivo*</label>
          <select class="form-control" name="fuel" id="fuel" required>
            <option value="benzin">Benzin</option>
            <option value="dizel">Dizel</option>
            <option value="tng">TNG</option>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="engine_emission">Emisiona klasa*</label>
          <select class="form-control" name="engine_emission" id="engine_emission" required>
            <option value="Euro 2">Euro 2</option>
            <option value="Euro 3">Euro 3</option>
            <option value="Euro 5">Euro 5</option>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="transmission">Menjac*</label>
          <select class="form-control" name="transmission" id="transmission" required>
            <option value="Automatski">Automatski</option>
            <option value="Manuelni">Manuelni</option>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="driven">Pogon*</label>
          <select class="form-control" name="drive" id="drive" required>
            <option value="Prednji">Prednji</option>
            <option value="Zadnji">Zadnji</option>
            <option value="4x4">4x4</option>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="volume">Godiste*</label>
          <select class="form-control" name="year" id="year">
            <?php
              $current_year = date("Y");
              $start_year = 1900;
              for($i=$start_year; $i<=$current_year; $i++) {
            ?>
            <option value="<?=$i;?>" selected="<?=$current_year;?>"><?=$i;?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="driven">Kilometraza*</label>
          <input type="text" min="1" name="driven" id="driven" value="" class="form-control" required onkeypress="return AllowNumbersOnly(event)">
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="seats">Broj sedista*</label>
          <select name="seats" id="seats" class="form-control" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4" selected>4</option>
            <?php
              $min_seats = 5;
              $max_seats = 60;
              for($i=$min_seats; $i<=$max_seats; $i++) {
            ?>
            <option value="<?=$i;?>"><?=$i;?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="steer_w">Volan*</label>
          <select class="form-control" name="steer_w" id="steer_w" required>
            <option value="Levi">Levi</option>
            <option value="Desni">Desni</option>
          </select>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="color">Boja</label>
          <input type="color" name="color" id="color" value="" class="form-control">
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="color_int">Boja enterijera</label>
          <input type="color" name="color_int" id="color_int" value="" class="form-control">
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="int_type">Materijal enterijera</label>
          <select name="int_type" id="int_type" value="" class="form-control">
            <option value="Koza">Koza</option>
            <option value="Stof">Stof</option>
            <option value="Drugo">Drugo</option>
          </select>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label for="owner">Registrovan na</label>
          <select class="form-control" name="owner" id="owner">
            <option value="prodavac">Prodavca</option>
            <option value="drugo">Drugo lice</option>
          </select>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label for="reg_exp">Registrovan do</label>
          <input type="date" name="reg_exp" id="reg_exp" value="" class="form-control">
        </div>
      </div>

      <div class="col-md-12">
        <h5 style="color:gold">Dodatna oprema</h5>
      </div>

      <div class="col-md-2">
        Metalik boja <input type="checkbox" name="metalic" id="metalic" value="metalik boja">
      </div>
      <div class="col-md-2">
        Servo volan <input type="checkbox" name="servo" id="servo" value="servo volan">
      </div>
      <div class="col-md-2">
        Tempomat <input type="checkbox" name="tempomat" id="tempomat" value="tempomat">
      </div>
      <div class="col-md-2">
        Podizaci <input type="checkbox" name="el_window" id="el_window" value="podizaci">
      </div>
      <div class="col-md-2">
        Racunar <input type="checkbox" name="computer" id="computer" value="racunar">
      </div>
      <div class="col-md-2">
        Ksenon <input type="checkbox" name="xenon" id="xenon" value="ksenon farovi" class="">
      </div>

      <div class="col-md-12">
        <br>
        <h5 style="color:gold">Opis vozila</h5>
        <div class="form-group">
          <textarea name="description" id="description" value="" class="form-control" rows="8" cols="80"></textarea>
        </div>
      </div>

      <div class="col-md-12">
        <h5 style="color:gold">Fotografije vozila</h5>
        <br>
        <div class="row">
          <div class="col-md-6">
            <small>Dodaj do 6 fotografija koje prikazuju stanje vozila.</small>
            <small>Dozvoljeni formati fotografija: jpg, jpeg, png, gif.</small>
            <small>Maksimalna velicina fotografije: 5 MB.</small>
            <small id="error_images"></small>
          </div>
          <div class="col-md-6">
            <!--<label for="photos" class="btn btn-warning">Izaberite fotografije</label>-->
            <input type="file" style="" class="form-control" name="photos" id="photos" multiple value="">
            <button type="button" class="btn btn-danger mt-2 d-none" name="unlink_all" id="unlink_all">Obrisi sve fotografije</button>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <h5 style="color:gold">Pogledaj fotografije</h5>
        <div class="row" id="preview_photos">

        </div>
      </div>

      <div class="col-md-12">
        <br>
        <h5 style="color:gold; border-bottom: 1px solid gold"></h5>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" name="submit_vehicle" id="submit_vehicle" value="Dodaj oglas">
          <input type="button" class="btn btn-warning" name="cancel" id="cancel" value="Ponisti sve">
        </div>
      </div>

    </div>
  </form>
</div>
<script src="assets/js/vehicle.js"></script>
<script type="text/javascript">
  function AllowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
      e.preventDefault();
    }
  }
</script>
<?php
  include('parts/footer.php');
?>
