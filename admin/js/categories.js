$(document).ready(function() {

  //submit model
  $(document).on('submit', '#add_category', function(event) {
    event.preventDefault();
    var category_name = $('#category_name').val();
    $('#submit_category').attr('disabled','disabled');
    $.ajax({
      url: "process/category_process.php",
      method: 'post',
      data: {category_name:category_name},
      success: function(data) {
        if(data == 'CATEGORY_ADDED') {
          $('#add_category')[0].reset();
          $('#submit_category').attr('disabled',false);
          var category_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
          '<strong>Kategorija je uspesno uneta!</strong> Mozete dodati sledecu.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#category_message').html('<p>'+category_message+'</p>');
        } else {
          var category_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Doslo je do greske!</strong> Pokusajte ponovo.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#submit_category').attr('disabled',false);
          $('#category_message').html('<p>'+category_message+'</p>');
        }
      }
    });
  });

  //Clear form event
  $(document).on('click', '#dismiss_category', function(event) {
    event.preventDefault();
    clear_form();
  });

  //Clear form function
  function clear_form() {
    $('#add_category')[0].reset();
  }

  //get categories (datatables)
  var load_all_categories;
  var categorydataTable = $('#categories_table').DataTable({
    "processing"  : true,
    "serverSide"  : true,
    "order" : [],
    "ajax"  : {
      url : "process/category_process.php",
      type :  "POST",
      data: {load_all_categories:1}
    },
    "columns": [
        { data: 'number' },
        { data: 'category_name' },
        { data: 'delete' },
    ],
    "columnDefs"  : [
      {
        "defaultContent": "-",
        "targets": "_all"
      }
    ],
    "pageLength"  : 10
  });

  $(document).on('click', '.delete-category', function(event) {
    event.preventDefault();
    var category_id = $(this).attr('id');
    var delete_category = true;
    if(confirm('Da li ste sigurni da zelite trajno da obrisete ovu kategoriju?')) {
      $.ajax({
        url:  "process/category_process.php",
        method: "POST",
        data: {category_id:category_id,delete_category:delete_category},
        success: function(data) {
          if(data == 'CATEGORY_DELETED') {
            var category_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
            '<strong>Kategorija je trajno obrisana!</strong> Mozete ga ponovo dodati.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#category_message').html(category_message);
            categorydataTable.ajax.reload();
          } else {
            var category_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Doslo je do greske!</strong> Pokusajte ponovo.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#category_message').html(category_message);
          }
        }
      });
    }
  });

});
