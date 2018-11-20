<div class="" id="searchVehicles">
  <form class="" method="post" id="advancedSearchForm">
    <div class="row">
      <div class="form-group col-md-3">
        <label for="price" style="" class="text-primary">Cena od</label>
        <input type="range" min="0" max="50000" step="200" value="0" data-monet="evro" name="price_min" class="form-control custom-range" id="price_min">
        <input type="hidden" name="" id="price_from" value="">
        <span class="text-info" id="price_min_val" data-price=""></span>
      </div>

      <div class="form-group col-md-3">
        <label for="monet" class="text-primary">Cena do</label>
        <input type="range" step="200" value="" data-monet="evro" name="price_max" class="form-control custom-range" id="price_max">
        <input type="hidden" name="" id="price_to" value="">
        <span class="text-info" id="price_max_val" data-price=""></span>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Zapremina</label>
        <select class="form-control" name="volume" id="volume">
          <option value="">Izaberite</option>
          <option value="1000">Do 1000</option>
          <option value="2000">Do 2000</option>
          <option value="3000">Do 3000</option>
          <option value="4000">Do 4000</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Snaga</label>
        <select class="form-control" name="power" id="power">
          <option value="">Izaberite</option>
          <option value="50">Do 50</option>
          <option value="100">Do 100</option>
          <option value="200">Do 200</option>
          <option value="300">Do 300</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Snaga</label>
        <select class="form-control" name="power_units" id="power_units">
          <option value="KS">KS</option>
          <option value="kW">kW</option>
        </select>
      </div>

      <div class="form-group col-md-4">
        <label for="category" class="text-primary">Kategorija</label>
        <select class="form-control" name="category" id="category">

        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="brand" class="text-primary">Proizvodjac</label>
        <select class="form-control" name="brand" id="brand">

        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="model" class="text-primary">Model</label>
        <select class="form-control" name="model" id="model">

        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Gorivo</label>
        <select class="form-control" name="fuel" id="fuel">
          <option value="">Izaberite</option>
          <option value="benzin">Benzin</option>
          <option value="dizel">Dizel</option>
          <option value="TNG">TNG</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Klasa</label>
        <select class="form-control" name="engine_emission" id="engine_emission">
          <option value="">Izaberite</option>
          <option value="Euro 2">Euro 2</option>
          <option value="Euro 3">Euro 3</option>
          <option value="Euro 5">Euro 5</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Menjac</label>
        <select class="form-control" name="transmission" id="transmission">
          <option value="">Izaberite</option>
          <option value="Manuelni">Manuelni</option>
          <option value="Automatski">Automatski</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Pogon</label>
        <select class="form-control" name="drive" id="drive">
          <option value="">Izaberite</option>
          <option value="Prednji">Prednji</option>
          <option value="Zadnji">Zadnji</option>
          <option value="4x4">4x4</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Volan</label>
        <select class="form-control" name="steering_wheel" id="steering_wheel">
          <option value="">Izaberite</option>
          <option value="Levi">Levi</option>
          <option value="Desni">Desni</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label for="monet" class="text-primary">Kilometraza</label>
        <select class="form-control" name="driven" id="driven">
          <option value="">Izaberite</option>
          <option value="100000">Do 50000</option>
          <option value="100000">Do 100000</option>
          <option value="150000">Do 150000</option>
          <option value="200000">Do 200000</option>
          <option value="300000">Do 200000</option>
        </select>
      </div>

      <div class="col-md-12">
        <h5 style="color:gold">Dodatna oprema</h5>
      </div>

      <div class="col-md-2">
        <span class="text-info">Metalik boja</span> <input type="checkbox" name="metalic" id="metalic" value="metalik boja">
      </div>
      <div class="col-md-2">
        <span class="text-info">Servo volan</span> <input type="checkbox" name="servo" id="servo" value="servo volan">
      </div>
      <div class="col-md-2">
        <span class="text-info">Tempomat</span> <input type="checkbox" name="tempomat" id="tempomat" value="tempomat">
      </div>
      <div class="col-md-2">
        <span class="text-info">Podizaci</span> <input type="checkbox" name="el_window" id="el_window" value="podizaci">
      </div>
      <div class="col-md-2">
        <span class="text-info">Racunar</span> <input type="checkbox" name="computer" id="computer" value="racunar">
      </div>
      <div class="col-md-2">
        <span class="text-info">Ksenon</span> <input type="checkbox" name="xenon" id="xenon" value="ksenon farovi" class="">
      </div>
    </div>
    <div class="mt-2">
      <button type="submit" id="submit_advancedSearchForm" class="btn btn-success pl-2 pr-2" name="submit_advancedSearchForm"><i class="fas fa-search"></i> Pretrazi oglase</button>
      <button type="button" class="btn btn-secondary pl-2 pr-2" name="formReset" id="formReset">Resetuj</button>
    </div>
  </form>
</div>
