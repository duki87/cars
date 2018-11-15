<?php
  require_once('db/db.php');
  include('parts/header.php');
?>
<div class="row row-custom">
  <div class="col-md-12">
    <br>
    <h2 class="" id="title" style="color:gold; border-bottom: 1px solid gold"></h2>
    <p class="text-info">Oglas postavio: <span class="text-primary" id="username"></span>
      <?php if(isset($_SESSION['user']['user_id'])) { ?>
        <button type="modal" data-toggle="modal" data-target="#messageModal" class="btn btn-primary btn-sm">Posalji poruku</button></p>
      <?php } ?>
    <h4 class="" id="" style="color:gold;">Podaci o vozilu</h4>
    <div class="row">
      <div class="col-md-3">
        <p style="color:white" id="vehicle_type"><span class="text-info">Vrsta vozila: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="brand"><span class="text-info">Proizvodjac: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="model"><span class="text-info">Model: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="year"><span class="text-info">Godiste: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="volume"><span class="text-info">Zapremina: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="power"><span class="text-info">Snaga motora: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="fuel"><span class="text-info">Tip goriva: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="engine_emission"><span class="text-info">Klasa motora: </span></p>
      </div>

      <div class="col-md-3">
        <p style="color:white" id="drive"><span class="text-info">Pogon: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="transmission"><span class="text-info">Tip menjaca: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="driven"><span class="text-info">Kilometraza: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="steer_w"><span class="text-info">Volan: </span></p>
      </div>

      <div class="col-md-3">
        <p style="color:white" id="seats"><span class="text-info">Sedista: </span></p>
      </div>
      <div class="col-md-3">
        <p id="color"><span class="text-info">Boja: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="color_int"><span class="text-info">Boja enterijera: </span></p>
      </div>
      <div class="col-md-3">
        <p style="color:white" id="int_type"><span class="text-info">Tip enterijera: </span></p>
      </div>
      <div class="col-md-12">
        <p style="color:white" id="additional"><span class="text-info">Dodatna oprema: </span></p>
      </div>
      <div class="col-md-6">
        <p style="color:white" id="owner"><span class="text-info">Registrovan na: </span></p>
      </div>
      <div class="col-md-6">
        <p style="color:white" id="reg_exp"><span class="text-info">Registrovan do: </span></p>
      </div>
      <div class="col-md-6">
        <p style="color:white" id="reg_exp"><span class="text-info">Detaljan opis: </span></p>
      </div>
      <div class="col-md-12">
        <h4 class="" id="" style="color:gold;">Fotografije vozila</h4>
        <div id="vehicle_images">

        </div>
      </div>
    </div>
  </div>
</div>
<?php
  include('parts/galleryModal.php');
  include('parts/messageModal.php');
?>

<script type="text/javascript">
$(document).ready(function() {
  var id = getUrlParameter('id');

  $.ajax({
    url: "process/sadds_process.php",
    method: 'get',
    data: {id:id},
    dataType: 'json',
    success: function(data) {
      var img_gallery = '';
      var vehicle_images_slider = '';
      var img_array = data.img_array;
      var img_folder = data.img_folder;
      for(let i=0; i<img_array.length; i++) {
        img_gallery += '<div class="responsive">'+
                        '<div class="gallery">'+
                          '<a href="#galleryModal" class="a-img" data-toggle="modal" data-id="img'+i+'">'+
                            '<img src="images/vehicle_images/'+img_folder+'/'+img_array[i]+'" alt="Cinque Terre" width="600" height="400">'+
                        '</a>'+
                        '</div>'+
                      '</div>';
        vehicle_images_slider += '<div class="carousel-item slider-imgs" id="img'+i+'">'+
                        '<img class="d-block w-100" src="images/vehicle_images/'+img_folder+'/'+img_array[i]+'" alt="Second slide">'+
                      '</div>';
      }

      $('#title').html(data.title);
      $('#username').append('<a href="korisnik.php?id='+data.user_id+'">'+data.username+'</a>');
      $('#messageModalTitle').append('<span class="text-primary"> '+data.username+'</span>');
      $('#title').append('<span class="float-right bg-warning p-1" id="price" style="color:red;font-size:0.8em;font-weight:bold;">Cena: '+data.price+'</span>');
      $('#vehicle_type').append(data.category_name);
      $('#receiver_id').val(data.user_id);
      $('#vehicle_id').val(data.vehicle_id);
      $('#brand').append(data.brand_name);
      $('#model').append(data.model_name);
      $('#year').append(data.year);
      $('#volume').append(data.volume);
      $('#power').append(data.power);
      $('#fuel').append(data.fuel);
      $('#engine_emission').append(data.engine_emission);
      $('#drive').append(data.drive);
      $('#transmission').append(data.transmission);
      $('#driven').append(data.driven);
      $('#steer_w').append(data.steer_w);
      $('#seats').append(data.seats);
      $('#color').css('color', data.color);
      $('#color').append('&#9632;');
      $('#color_int').css('color', data.color_int);
      $('#color_int').append('&#9632;');
      $('#int_type').append(data.int_type);
      $('#additional').append(data.additional);
      $('#owner').append(data.owner);
      $('#reg_exp').append(data.reg_exp);
      $('#vehicle_images').html(img_gallery);
      $('#vehicle_images_slider').html(vehicle_images_slider);
    }
  });

  $(document).on('click', '.a-img', function() {
    var a_id = $(this).attr('data-id');
    var slides = $('.slider-imgs');
    var slides_ids = new Array();
    for(let i=0; i<slides.length; i++) {
      slides_ids[i] = slides[i].getAttribute("id");
      if(slides_ids[i] == a_id) {
        $('#'+slides_ids[i]).addClass('active');
      }
    }
  });

  $('#galleryModal').on('hidden.bs.modal', function () {
    console.log('hidden event fired!');
    $("#vehicle_images_slider>div.active").removeClass("active");
  });
  
  function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
            // console.log(sParameterName[1] === undefined ? true : sParameterName[1]);
        }
      }
    };
});

</script>
<?php
  include('parts/footer.php');
?>
