$(document).ready(function() {
  get_categories();
  var findMatches = '';

  //Get all categories
  function get_categories() {
    var get_categories = true;
    $.ajax({
      url: "process/vehicle_process.php",
      method: 'post',
      data: {get_categories:get_categories},
      dataType: 'json',
      success: function(data) {
        $('#category').html(data);
      }
    });
  }

  $(document).on('change', '#category', function(e) {
    e.preventDefault();
    var category_id = $('#category').val();
    var get_brands = true;
    var check_models = $('#model').val();
      $('#model').prop('selectedIndex',0);
      $('#brand').prop('selectedIndex',0);
      $.ajax({
        url: "process/vehicle_process.php",
        method: 'post',
        data: {get_brands:get_brands,category_id:category_id},
        dataType: 'json',
        success: function(data) {
          $('#brand').html(data);
        }
      });
  });

  $(document).on('change', '#brand', function(e) {
    e.preventDefault();
    var brand_id = $('#brand').val();
    var get_models = true;
    $.ajax({
      url: "process/vehicle_process.php",
      method: 'post',
      data: {get_models:get_models,brand_id:brand_id},
      dataType: 'json',
      success: function(data) {
        $('#model').html(data);
      }
    });
  });

  $(document).on('keyup', '#searchByText', function(e) {
    e.preventDefault();
    if(e.which == 13) {
      var searchValue = $('#searchByText').val();
      basic_search(searchValue);
    }
    searchByText();
  });

  $(document).on('click', '#searchByText', function(e) {
    e.preventDefault();
    add_button();
    var keywords = $('#searchByText').val();
    if(keywords !== '') {
      searchByText();
    }
  });

  $(document).on('click', '#remove_suggestion', function(e) {
    $('#remove_suggestion').remove();
    $('#dresults').addClass('d-none');
    $('#searchByText').val('');
    $('#other_adds').html('');
    get_selling_adds();
  });

  function add_button() {
    if($("#remove_suggestion").length == 1) {
      return false;
    }
    var button = '<button type="button" id="remove_suggestion" title="Obrisi tekst" class="btn btn-danger btn-sm" style="position:absolute;right:18px;bottom:4px">x</button>';
    $('#searchByText').after(button);
  }

  function searchByText() {
    var keyword = $('#searchByText').val();
    if(keyword == '') {
      $('#dresults').addClass('d-none');
      return false;
    }
    var get_suggestions = true;
    $.ajax({
      url: "process/search_process.php",
      method: 'post',
      data: {get_suggestions:get_suggestions,keyword:keyword},
      dataType: 'json',
      success: function(data) {
        console.log(data);
        $('#dresults').removeClass('d-none');
        $('#dresults').attr('style', '');
        $('#dresults').html(data);
      }
    });
  }

  $(document).on('click', function(e) {
    var $menu = $('#dresults');
    if (!$menu.is(e.target) // if the target of the click isn't the container...
      && $menu.has(e.target).length === 0) // ... nor a descendant of the container
      {
        $menu.hide();
      } else {
        return false;
      }
  });

  $(document).on('click', '.searchSuggestion', function(e) {
    e.preventDefault();
    var textValue = $(this).attr('data-searchval');
    $('#searchByText').val('');
    $('#searchByText').val(textValue);
    $('#dresults').addClass('d-none');
    basic_search(textValue);
  });

  function basic_search(findMatches) {
    var get_results = true;
    $.ajax({
      url: "process/search_process.php",
      method: 'post',
      data: {get_results:get_results,findMatches:findMatches},
      dataType: 'json',
      success: function(data) {
        $('#other_adds').html('');
        $('#other_adds').html(data);
      }
    });
  }

  //select suggestion
  $(document).on('click', '#searchByTextSubmit', function(e) {
    e.preventDefault();
    var searchValue = $('#searchByText').val();
    if(searchValue !== '') {
      basic_search(searchValue);
    }
  });

  $(document).on('submit', '#advancedSearchForm', function(e) {
    e.preventDefault();
    var price_min = $('#price_from').val();
    var price_max = $('#price_to').val();
    var category = $('#category').val();
    var brand = $('#brand').val();
    var model = $('#model').val();
    var volume = $('#volume').val();
    var power = $('#power').val();
    var power_units = $('#power_units').val();
    var fuel = $('#fuel').val();
    var engine_emission = $('#engine_emission').val();
    var transmission = $('#transmission').val();
    var drive = $('#drive').val();
    var driven = $('#driven').val();
    var steer_w = $('#steering_wheel').val();
    var metalic = $('#metalic').is(':checked');
    var servo = $('#servo').is(':checked');
    var tempomat = $('#tempomat').is(':checked');
    var el_window = $('#el_window').is(':checked');
    var computer = $('#computer').is(':checked');
    var xenon = $('#xenon').is(':checked');
    var search_details = new searchModel(price_min, price_max, category, brand, model, volume, power, power_units, fuel, engine_emission, transmission, drive, driven, steer_w, driven, metalic, servo, tempomat, el_window, computer, xenon);
    var searchData = JSON.stringify(search_details);
    var advanced_search = true;
    console.log(searchData);
    $.ajax({
      url: "process/search_process.php",
      method: 'post',
      data: {advanced_search:advanced_search,searchData:searchData},
      dataType: 'json',
      success: function(data) {
        //alert(data);
        console.log(data);
      }
    });
  });

  //get selling_adds_with_pagination
  function get_selling_adds() {
    var get_selling_adds = true;
    var per_page = 4;
    var chunk_to_display = 0;
    var sqlTable = 'vehicle';
    var pagination = {
      "per_page" : per_page,
      "chunk_to_display" : chunk_to_display,
      "sqlTable" : sqlTable
    };
    var pagination_data = JSON.stringify(pagination);
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {get_selling_adds:get_selling_adds,pagination_data:pagination_data},
      dataType: 'json',
      success: function(data) {
        $('#other_adds').append(data.data);
        $('#pagination_area').append(data.paginations);
      }
    });
  }

  function searchModel(price_min, price_max, category, brand, model, volume, power, power_units, fuel, engine_emission, transmission, drive, driven, steer_w, driven, metalic, servo, tempomat, el_window, computer, xenon) {
    this.price_min = price_min,
    this.price_max = price_max,
    this.category = category,
    this.brand = brand,
    this.model = model,
    this.volume = volume,
    this.power = power,
    this.power_units = power_units,
    this.fuel = fuel,
    this.engine_emission = engine_emission,
    this.transmission = transmission,
    this.drive = drive,
    this.driven = driven,
    this.steer_w = steer_w,
    this.metalic = metalic,
    this.servo = servo,
    this.tempomat = tempomat,
    this.el_window = el_window,
    this.computer = computer,
    this.xenon = xenon
  };

});
