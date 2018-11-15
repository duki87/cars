<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class SellingAdds {
    private $connect;
    private $url = 'http://localhost/cars/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function get_selling_adds() {
      $data = array();
      $sponsored = array();
      $other = array();
      $query = "SELECT * FROM vehicle WHERE sponsored = 1 LIMIT 4";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $originalDate = $row['date_added'];
        $newDate = date("d.m.Y.", strtotime($originalDate));
        $title = $row["title"];
        $titleArr = explode(" ", $title);
        $titleUrl = strtolower(implode("-",$titleArr));
        $monet_txt = '';
        $monet = $row['monet'];
        if($monet != '') {
          if($monet == 'evro') {
            $monet_txt = 'evra';
          } else {
            $monet_txt = 'dinara';
          }
        }
        $sponsored[] = '
        <div class="col-md-3 col-sm-3">
          <div class="card card-custom-sponsored flex-fill border border-warning">
            <h5 class="card-header bg-warning">'.$row["title"].'</h5>
            <img class="card-img-top" src="images/vehicle_images/'.$row["featured_image"].'" alt="fotografija vozila">
            <div class="card-body">
              <p class="card-text"><strong>Cena: '.$row["price"].' '.$monet_txt.'</strong></p>
              <p class="card-text"><strong>Godiste: '.$row["year"].'</strong></p>
              <a href="oglas.php?naziv='.$titleUrl.'&id='.$row['vehicle_id'].'" class="btn btn-warning" style="">Pogledaj oglas</a>
            </div>
            <div class="card-footer">
              <small class="text-muted">Oglas postavljen '.$newDate.'</small>
            </div>
          </div>
        </div>
        ';
      }
      $data['sponsored'] = $sponsored;

      $query2 = "SELECT * FROM vehicle LEFT JOIN users ON users.user_id = vehicle.user_id WHERE sponsored = 0";
      $statement2 = $this->connect->prepare($query2);
      $statement2->execute();
      $result2 = $statement2->fetchAll();
      foreach ($result2 as $row2) {
        $originalDate = $row2['date_added'];
        $newDate = date("d.m.Y.", strtotime($originalDate));
        $title = $row2["title"];
        $titleArr = explode(" ", $title);
        $titleUrl = strtolower(implode("-",$titleArr));
        $monet_txt = '';
        $monet = $row2['monet'];
        if($monet != '') {
          if($monet == 'evro') {
            $monet_txt = 'evra';
          } else {
            $monet_txt = 'dinara';
          }
        }
        $other[] = '
        <div class="col-md-6 mb-4">
          <div class="card flex-row flex-wrap">
            <div class="card-header border-0">
              <img class="card-img-top" src="images/vehicle_images/'.$row2["featured_image"].'" alt="">
            </div>
            <div class="card-block px-2">
              <h4 class="text-warning">'.$row2["title"].'</h4>
              <p class="text-primary"><strong>Cena: '.$row2["price"].' '.$monet_txt.'</strong></p>
              <p class="text-primary"><strong>Godiste: '.$row2["year"].'</strong></p>
              <a href="'.$this->url.'oglas.php?naziv='.$titleUrl.'&id='.$row2['vehicle_id'].'" class="btn btn-warning" style="">Pogledaj oglas</a>
            </div>
            <div class="w-100"></div>
            <div class="card-footer w-100 text-muted mt-1">
              Oglas postavljen '.$newDate.'
              <span class="float-right">'.$row2["name"].' '.$row2["last_name"].'</span>
            </div>
          </div>
        </div><br>
        ';
      }
      $data['other'] = $other;
      echo json_encode($data);
    }

    public function get_selling_add_details($id) {
      $query = "SELECT * FROM vehicle LEFT JOIN users ON users.user_id = vehicle.user_id LEFT JOIN brands ON brands.brand_id = vehicle.brand_id LEFT JOIN categories ON categories.category_id = vehicle.category_id LEFT JOIN models ON models.model_id = vehicle.model_id WHERE vehicle_id = '$id' ";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetch();
      $data = array();
      $originalDate = $result['date_added'];
      $newDate = date("d.m.Y.", strtotime($originalDate));
      $title = $result["title"];
      $titleArr = explode(" ", $title);
      $titleUrl = strtolower(implode("-",$titleArr));
      $monet_txt = '';
      $owner = '';
      $originalDate = $result['date_added'];
      $reg_exp = date("d.m.Y.", strtotime($originalDate));
      $monet = $result['monet'];
      if($monet != '') {
        if($monet == 'evro') {
          $monet_txt = '&euro;';
        } else {
          $monet_txt = 'din.';
        }
      }

      if($result['owner'] == 'drugo') {
        $owner = 'drugo lice';
        }else {
        $owner = 'prodavca';
      }

      //images
      $img_array = array();
      $img_folder = '../images/vehicle_images/'.$result['img_folder'];
      // Open a directory, and read images
      $scan_folder = array_diff(scandir($img_folder), array('..', '.'));
      foreach ($scan_folder as $scan_img) {
        $img_array[] = $scan_img;
      }

      $additional = substr($result['additional'], 0, -1);
      // $additional = rtrim($result['additional'], ',');

      $username = $result['name'].' '.$result['last_name'];
      $data['title'] = $result['title'];
      $data['vehicle_id'] = $result['vehicle_id'];
      $data['price'] = $result['price'].' '.$monet_txt;
      $data['category_name'] = $result['category_name'];
      $data['brand_name'] = $result['brand_name'];
      $data['model_name'] = $result['model_name'];
      $data['username'] = $username;
      $data['user_id'] = $result['user_id'];
      $data['volume'] = $result['volume'];
      $data['power'] = $result['power'].' '.$result['power_units'];
      $data['fuel'] = $result['fuel'];
      $data['engine_emission'] = $result['engine_emission'];
      $data['transmission'] = $result['transmission'];
      $data['year'] = $result['year'];
      $data['drive'] = $result['drive'];
      $data['year'] = $result['year'];
      $data['transmission'] = $result['transmission'];
      $data['driven'] = $result['driven'].' km';
      $data['steer_w'] = $result['steer_w'];
      $data['seats'] = $result['seats'];
      $data['color'] = $result['color'];
      $data['color_int'] = $result['color_int'];
      $data['int_type'] = $result['int_type'];
      $data['additional'] = $additional;
      $data['owner'] = $owner;
      $data['reg_exp'] = $reg_exp;
      $data['img_folder'] = $result['img_folder'];
      $data['img_array'] = $img_array;
      echo json_encode($data);
    }

  }
