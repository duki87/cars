function vehicleModel(title, price, monet, price_other, category, brand, model, volume, power, power_units, fuel, engine_emission, transmission, transmission, drive, year, driven, seats, steer_w, color, color_int, int_type, owner, reg_exp, additional, description, photos_folder,featured_img, metalic, servo, tempomat, el_window, computer, xenon) {
  this.title = title,
  this.price = price,
  this.monet = monet,
  this.price_other = price_other,
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
  this.year = year,
  this.driven = driven,
  this.seats = seats,
  this.steer_w = steer_w,
  this.color = color,
  this.color_int = color_int,
  this.int_type = int_type,
  this.owner = owner,
  this.reg_exp = reg_exp,
  this.additional = additional,
  this.description = description,
  this.photos_folder = photos_folder,
  this.featured_img = featured_img,
  this.metalic = metalic,
  this.servo = servo,
  this.tempomat = tempomat,
  this.el_window = el_window,
  this.computer = computer,
  this.xenon = xenon
}

$(document).ready(function() {
  get_categories();

  //Get all categories
  function get_categories() {
    var get_categories = true;
    $.ajax({
      url: "process/vehicle_process.php",
      method: 'post',
      data: {get_categories:get_categories},
      dataType: 'json',
      success: function(data) {
        $('#select_category').html(data);
      }
    });
  }

  $(document).on('change', '#select_category',function() {
    var category_id = $('#select_category').val();
    var get_brands = true;
    var check_models = $('#select_model').val();
    if(check_models != '') {
      $('#select_model').prop('selectedIndex',0);
      $('#select_brand').prop('selectedIndex',0);
    } else {
      $.ajax({
        url: "process/vehicle_process.php",
        method: 'post',
        data: {get_brands:get_brands,category_id:category_id},
        dataType: 'json',
        success: function(data) {
          $('#select_brand').html(data);
        }
      });
    }

  });

  $(document).on('change', '#select_brand',function() {
    var brand_id = $('#select_brand').val();
    var get_models = true;
    $.ajax({
      url: "process/vehicle_process.php",
      method: 'post',
      data: {get_models:get_models,brand_id:brand_id},
      dataType: 'json',
      success: function(data) {
        $('#select_model').html(data);
      }
    });
  });

  $(document).on('change', '#photos', function(event) {
    event.preventDefault();
    var error_images = '';
    var photo_boxes = $('.photo_boxes').length;
    if(photo_boxes > 0) {
      var form_data_new = new FormData();
      var more_files = $('#photos')[0].files;
      var available = 6 - parseInt(photo_boxes);
      if(more_files.length > available) {
        error_images += 'Mozete dodati jos ' +available+ ' fotografija!';
        $('#error_images').html('<span class="text-danger">'+error_images+'</span>');
        document.getElementById('photos').value = "";
      } else {
        for(var j=0; j<more_files.length; j++) {
          var name = document.getElementById('photos').files[j].name;
          var ext = name.split('.').pop().toLowerCase();
          var allowed = ['gif', 'jpg', 'jpeg', 'png'];
          if(jQuery.inArray(ext, allowed) == -1) {
            error_images += 'Uneli ste fajl koji ima nedozvoljenu ekstenziju!';
          }
          var image_size = document.getElementById('photos').files[j].size;
          if(image_size > 5242880) {
            error_images += 'Velicina fotografije veca od 5 MB!';
          }
          var existing_folder = $('#preview_photos').attr('data-folderName');
          form_data_new.append('file[]', document.getElementById('photos').files[j]);
          form_data_new.append('existing_folder', existing_folder);
        }
      }
      if(error_images == '') {
        var more_img_preview = true;
        var more_images = [];
        $.ajax({
          url: "process/more_img_preview.php",
          method: 'post',
          data: form_data_new,
          contentType: false,
          cache: false,
          processData: false,
          dataType: 'json',
          beforeSend: function() {
            $('#error_images').html('<span class="text-primary">Ucitavanje fotografija...</span>');
          },
          success: function(data) {
            for(var b=0; b<data.images.length; b++) {
              var random_id = Math.floor((Math.random() * 1000) + 1);
              more_images += '<div class="col-md-2 photo_boxes" id="photo_box'+random_id+'" style="position:relative"><img src="images/vehicle_images/'+data.images[b]+'" id="image'+random_id+'" class="form-control img-responsive vehicle-photos" alt="" data-imgloc="'+data.images[b]+'"><button class="btn btn-danger btn-xs vehicle-photo" style="position:absolute;top:4px;right:20px" data-unlink="'+data.images[b]+'">&times;</button></div>';
            }
            $('#preview_photos').append(more_images);
            $('#error_images').html('<span class="text-success">Fotografije su ucitane!</span>');
            document.getElementById('photos').value = "";
          }
        });
      } else {
        $('#photos').val('');
        $('#error_images').html('<span class="text-danger">'+error_images+'</span>');
        return false;
      }
    } else {
      var form_data = new FormData();
      var files = $('#photos')[0].files;
      if(files.length > 6) {
        error_images += 'Ne mozete ucitati vise od 6 fotografija!';
      } else {
        for(var i=0; i<files.length; i++) {
          var name = document.getElementById('photos').files[i].name;
          var ext = name.split('.').pop().toLowerCase();
          var allowed = ['gif', 'jpg', 'jpeg', 'png'];
          if(jQuery.inArray(ext, allowed) == -1) {
            error_images += 'Uneli ste fajl koji ima nedozvoljenu ekstenziju!';
          }
          var image_size = document.getElementById('photos').files[i].size;
          if(image_size > 5242880) {
            error_images += 'Velicina fotografije veca od 5 MB!';
          }
          form_data.append('file[]', document.getElementById('photos').files[i]);
        }
      }
      if(error_images == '') {
        var img_preview = true;
        var images = [];
        $.ajax({
          url: "process/img_preview.php",
          method: 'post',
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          dataType: 'json',
          beforeSend: function() {
            $('#error_images').html('<span class="text-primary">Ucitavanje fotografija...</span>');
          },
          success: function(data) {
            for(var c=0; c<data.images.length; c++) {
              var random_id = Math.floor((Math.random() * 1000) + 1);
              images += '<div class="col-md-2 photo_boxes" id="photo_box'+random_id+'" style="position:relative"><img src="images/vehicle_images/'+data.images[c]+'" id="image'+random_id+'" class="form-control img-responsive vehicle-photos" alt="" data-imgloc="'+data.images[c]+'"><button class="btn btn-danger btn-xs vehicle-photo" style="position:absolute;top:4px;right:20px" data-unlink="'+data.images[c]+'">&times;</button></div>';
            }
            var folder_name = data.folder_name;
            $('#preview_photos').attr('data-folderName', folder_name);
            $('#preview_photos').html(images);
            $('#error_images').html('<span class="text-success">Fotografije su ucitane!</span>');
            document.getElementById('photos').value = "";
            $('#unlink_all').removeClass('d-none');
          }
        });
      } else {
        $('#photos').val('');
        $('#error_images').html('<span class="text-danger">'+error_images+'</span>');
        return false;
      }
    }
  });

  $(document).on('click', '.vehicle-photo', function() {
    var unlink_path = $(this).data('unlink');
    var photo_box = $(this).parent().attr('id');
    if(confirm('Da li zelite da obrisete ovu fotografiju?')) {
      $.ajax({
        url: "process/img_unlink.php",
        method: 'post',
        data: {unlink_path:unlink_path},
        success: function(data) {
          if(data == 'IMG_DELETED') {
            $('#error_images').html('<span class="text-success">Fotografija obrisana!</span>');
            $('#'+photo_box).remove();
          }
        }
      });
    } else {
      return false;
    }
  });

//delete all photos
  $(document).on('click', '#unlink_all', function() {
    var unlink_folder = $('#preview_photos').attr('data-folderName');
    var unlink_all = true;
    if(confirm('Da li zelite da obrisete sve fotografije?')) {
      $.ajax({
        url: "process/img_unlink_all.php",
        method: 'post',
        data: {unlink_folder:unlink_folder, unlink_all:unlink_all},
        success: function(data) {
          if(data == 'FOLDER_DELETED') {
            $('#error_images').html('<span class="text-success">Fotografije su izbrisane!</span>');
            $('#preview_photos').html('');
            $('#unlink_all').addClass('d-none');
          }
        }
      });
    } else {
      return false;
    }
  });

//select featured image
  $(document).on('click', '.photo_boxes', function() {
    var featured = $('.featured-img');
    if(featured.length > 0) {
      for(let f=0; f<featured.length; f++) {
        featured[f].classList.remove('featured-img');
      }
    }
    $(this).addClass('featured-img');
  });

//submit form
  $(document).on('submit', '#add_vehicle',function(event) {
    event.preventDefault();
    var title = $('#title').val();
    if(title == '') {
      let brand_name = $('#select_brand option:selected').text();
      let model_name = $('#select_model option:selected').text();
      title = brand_name + ' ' + model_name;
    }
    var price = $('#price').val();
    var monet = $('#monet').val();
    var price_other = $('#price_other').val();

    if(price == '') {
      if(price_other !== '') {
        price = price_other;
      } else {
        alert('Morati uneti cenu ili odabrati odgovarajuci opis!');
      }
    } else if (price !== '' && monet == '') {
        alert('Odaberite valutu!');
    } else if (price == '' && monet !== '') {
        alert('Unesite cenu!');
    } else {
        price = $('#price').val();
    }
    var category = $('#select_category').val();
    var brand = $('#select_brand').val();
    var model = $('#select_model').val();
    var volume = $('#volume').val();
    var power = $('#power').val();
    var power_units = $('#power_units').val();
    var fuel = $('#fuel').val();
    var engine_emission = $('#engine_emission').val();
    var transmission = $('#transmission').val();
    var drive = $('#drive').val();
    var year = $('#year').val();
    var driven = $('#driven').val();
    var seats = $('#seats').val();
    var steer_w = $('#steer_w').val();
    var color = $('#color').val();
    var color_int = $('#color_int').val();
    var int_type = $('#int_type').val();
    var owner = $('#owner').val();
    var reg_exp = $('#reg_exp').val();

    var metalic = $('#metalic').prop('checked') ? $('#metalic').val() + ',' : '';
    var servo = $('#servo').prop('checked') ? $('#servo').val() + ',' : '';
    var tempomat = $('#tempomat').prop('checked') ? $('#tempomat').val() + ',' : '';
    var el_window = $('#el_window').prop('checked') ? $('#el_window').val() + ',' : '';
    var computer = $('#computer').prop('checked') ? $('#computer').val() + ',' : '';
    var xenon = $('#xenon').prop('checked') ? $('#xenon').val() + ',' : '';

    var metalicB = $('#metalic').prop('checked');
    var servoB = $('#servo').prop('checked');
    var tempomatB = $('#tempomat').prop('checked');
    var el_windowB = $('#el_window').prop('checked');
    var computerB = $('#computer').prop('checked');
    var xenonB = $('#xenon').prop('checked');

    var additional = metalic + servo + tempomat + el_window + computer + xenon;
    var description = $('#description').val();
    var get_vehicle_photos = $('.vehicle-photos');
    var vehicle_photos = [];
    for(var v=0; v<get_vehicle_photos.length; v++) {
      vehicle_photos[v] = get_vehicle_photos[v].getAttribute("data-imgloc");
    }
    var photos_folder = $('#preview_photos').attr('data-folderName');
    var featured_img = $('.featured-img').find('.vehicle-photos').data('imgloc');
    var vehicle_data = new vehicleModel(title, price, monet, price_other, category, brand, model, volume, power, power_units, fuel, engine_emission, transmission, transmission, drive, year, driven, seats, steer_w, color, color_int, int_type, owner, reg_exp, additional, description, photos_folder, featured_img, metalicB, servoB, tempomatB, el_windowB, computerB, xenonB);
    var vehicle_details = JSON.stringify(vehicle_data);
    var new_vehicle = true;
    $.ajax({
      url: "process/vehicle_process.php",
      method: 'post',
      data: {new_vehicle:new_vehicle,vehicle_details:vehicle_details},
      success: function(data) {
        if(data == 'VEHICLE_ADD') {
          var vehicle_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
          '<strong>Oglas je uspesno dodat!</strong>'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#vehicle_message').html('<p>'+vehicle_message+'</p>');
          $('#add_vehicle')[0].reset();
        } else {
          var vehicle_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Nesto se iskundacilo!</strong>'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#vehicle_message').html('<p>'+vehicle_message+'</p>');
        }
      }
    });
  });

});
