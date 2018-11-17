<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Search {
    private $connect;
    private $url = 'http://localhost/cars/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function get_suggestions($keyword) {
      $data = array();
      $query = "SELECT category_name FROM categories WHERE category_name LIKE ?";
      $params = array("%$keyword%");
      $statement = $this->connect->prepare($query);
      $statement->execute($params);
      $row = $statement->rowCount();
      $result = $statement->fetchAll();
      if($row > 0) {
        foreach ($result as $row) {
          $data[] = '<a class="dropdown-item searchSuggestion" data-searchval="'.$row['category_name'].'">'.$row['category_name'].'</a>';
        }
      }

      $query2 = "SELECT brand_name FROM brands WHERE brand_name LIKE ?";
      $params2 = array("%$keyword%");
      $statement2 = $this->connect->prepare($query2);
      $statement2->execute($params2);
      $row2 = $statement2->rowCount();
      $result2 = $statement2->fetchAll();
      if($row2 > 0) {
        foreach ($result2 as $row2) {
          $data[] = '<a class="dropdown-item searchSuggestion" data-searchval="'.$row2['brand_name'].'">'.$row2['brand_name'].'</a>';
        }
      }

      $query3 = "SELECT model_name FROM models WHERE model_name LIKE ?";
      $params3 = array("%$keyword%");
      $statement3 = $this->connect->prepare($query3);
      $statement3->execute($params3);
      $row3 = $statement3->rowCount();
      $result3 = $statement3->fetchAll();
      if($row3 > 0) {
        foreach ($result3 as $row3) {
          $data[] = '<a class="dropdown-item searchSuggestion" data-searchval="'.$row3['model_name'].'" href="#">'.$row3['model_name'].'</a>';
        }
      }
      return json_encode($data);
    }

    public function basic_search($searchString) {
      $query = "SELECT * FROM vehicle LEFT JOIN users ON users.user_id = vehicle.user_id WHERE title LIKE ?";
      $params = array("%$searchString%");
      $statement = $this->connect->prepare($query);
      $statement->execute($params);
      $result = $statement->fetchAll();
      //return json_encode($result);
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
        $price = $row["price"];
        if($price == 0) {
          $price_to_display = $row['price_other'];
        } else {
          $price_to_display = $price .' '. $monet_txt;
        }
        $data[] = '
        <div class="col-md-6 mb-4">
          <div class="card flex-row flex-wrap">
            <div class="card-header border-0">
              <img class="card-img-top" src="images/vehicle_images/'.$row["featured_image"].'" alt="">
            </div>
            <div class="card-block px-2">
              <h4 class="text-warning">'.$row["title"].'</h4>
              <p class="text-primary"><strong>Cena: '.$price_to_display.'</strong></p>
              <p class="text-primary"><strong>Godiste: '.$row["year"].'</strong></p>
              <a href="oglas.php?naziv='.$titleUrl.'&id='.$row['vehicle_id'].'" class="btn btn-warning" style="">Pogledaj oglas</a>
            </div>
            <div class="w-100"></div>
            <div class="card-footer w-100 text-muted mt-1">
              Oglas postavljen '.$newDate.'
              <span class="float-right">'.$row["name"].' '.$row["last_name"].'</span>
            </div>
          </div>
        </div><br>
        ';
      }
      return json_encode($data);
    }

    public function advanced_search($searchData) {
      $searchDetails = json_decode($searchData);
      $selling_adds = array();
      $params = array();
      $data = array();
      $query = "SELECT * FROM vehicle LEFT JOIN users ON users.user_id = vehicle.user_id LEFT JOIN vehicle_additional ON vehicle_additional.vehicle_id = vehicle.vehicle_id WHERE status = 1 ";

      if(!empty($searchDetails->price_min)) {
        $query .= "AND price BETWEEN ? AND ? ";
        $params[] = "$searchDetails->price_min";
        $params[] = "$searchDetails->price_max";
      }

      if(!empty($searchDetails->volume)) {
        $query .= "AND volume < ? ";
        $params[] = "$searchDetails->volume";
      }

      if(!empty($searchDetails->category)) {
        $query .= "AND category_id = ? ";
        $params[] = "$searchDetails->category";
      }

      if(!empty($searchDetails->brand)) {
        $query .= "AND brand_id = ? ";
        $params[] = "$searchDetails->brand";
      }

      if(!empty($searchDetails->model)) {
        $query .= "AND model_id = ? ";
        $params[] = "$searchDetails->model";
      }

      if(!empty($searchDetails->power)) {
        $query .= "AND power < ? AND power_units = ?";
        $params[] = "$searchDetails->power";
        $params[] = "$searchDetails->power_units";
      }

      if(!empty($searchDetails->fuel)) {
        $query .= "AND fuel = ? ";
        $params[] = "$searchDetails->fuel";
      }

      if(!empty($searchDetails->engine_emission)) {
        $query .= "AND engine_emission = ? ";
        $params[] = "$searchDetails->engine_emission";
      }

      if(!empty($searchDetails->transmission)) {
        $query .= "AND transmission = ? ";
        $params[] = "$searchDetails->transmission";
      }

      if(!empty($searchDetails->drive)) {
        $query .= "AND drive = ? ";
        $params[] = "$searchDetails->drive";
      }

      if(!empty($searchDetails->steer_w)) {
        $query .= "AND steer_w = ? ";
        $params[] = "$searchDetails->steer_w";
      }

      if(!empty($searchDetails->driven)) {
        $query .= "AND driven < ? ";
        $params[] = "$searchDetails->driven";
      }

      if($searchDetails->metalic == true) {
        $query .= "AND metalic = ? ";
        $params[] = 1;
      }

      if($searchDetails->servo == true) {
        $query .= "AND servo = ? ";
        $params[] = 1;
      }

      if($searchDetails->tempomat == true) {
        $query .= "AND tempomat = ? ";
        $params[] = 1;
      }

      if($searchDetails->el_window == true) {
        $query .= "AND el_window = ? ";
        $params[] = 1;
      }

      if($searchDetails->computer == true) {
        $query .= "AND computer = ? ";
        $params[] = 1;
      }

      if($searchDetails->xenon == true) {
        $query .= "AND xenon = ? ";
        $params[] = 1;
      }

      $statement = $this->connect->prepare($query);
      $statement->execute($params);
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $originalDate = $row['date_added'];
        $newDate = date("d.m.Y.", strtotime($originalDate));
        $title = $row["title"];
        $titleArr = explode(" ", $title);
        $titleUrl = strtolower(implode("-",$titleArr));
        $price = $row["price"];
        $monet = $row['monet'];
        if($monet != '') {
          if($monet == 'evro') {
            $monet_txt = 'evra';
          } else {
            $monet_txt = 'dinara';
          }
        }
        if($price == 0) {
          $price_to_display = $row['price_other'];
        } else {
          $price_to_display = $price .' '. $monet_txt;
        }
        $data[] = '
        <div class="col-md-6 mb-4">
          <div class="card flex-row flex-wrap">
            <div class="card-header border-0">
              <img class="card-img-top" src="images/vehicle_images/'.$row["featured_image"].'" alt="">
            </div>
            <div class="card-block px-2">
              <h4 class="text-warning">'.$row["title"].'</h4>
              <p class="text-primary"><strong>Cena: '.$price_to_display.'</strong></p>
              <p class="text-primary"><strong>Godiste: '.$row["year"].'</strong></p>
              <a href="oglas.php?naziv='.$titleUrl.'&id='.$row['vehicle_id'].'" class="btn btn-warning" style="">Pogledaj oglas</a>
            </div>
            <div class="w-100"></div>
            <div class="card-footer w-100 text-muted mt-1">
              Oglas postavljen '.$newDate.'
              <span class="float-right">'.$row["name"].' '.$row["last_name"].'</span>
            </div>
          </div>
        </div><br>
        ';
      }
      return json_encode($data);
    }
  }
?>
