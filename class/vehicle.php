<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Vehicle {
    private $connect;
    private $url = 'http://localhost/cars/images/brand_logos/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function get_categories() {
      $data = array();
      $data[] = '<option value="">Izaberite</option>';
      $query = "SELECT * FROM categories";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $data[] = '<option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';
      }
      echo json_encode($data);
    }

    public function get_brands($category_id) {
      $data = array();
      $data[] = '<option value="">Izaberite</option>';
      $query = "SELECT * FROM brands WHERE category_id = '$category_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $data[] = '<option value="'.$row['brand_id'].'">'.$row['brand_name'].'</option>';
      }
      echo json_encode($data);
    }

    public function get_models($brand_id) {
      $data = array();
      $data[] = '<option value="">Izaberite</option>';
      $query = "SELECT * FROM models WHERE brand_id = '$brand_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $data[] = '<option value="'.$row['model_id'].'">'.$row['model_name'].'</option>';
      }
      echo json_encode($data);
    }

    public function add_vehicle($vehicle_data) {
      $vehicle_details = json_decode($vehicle_data);
      $user_id = $_SESSION['user']['user_id'];
      $date_added = date("Y-m-d h:i:s");
      $sponsored = 1;
      $query = "INSERT INTO vehicle (title, price, monet, price_other, category_id, brand_id, model_id, user_id, volume, power, power_units, fuel, engine_emission, transmission, drive, year, driven, seats, steer_w, color, color_int, int_type, owner, reg_exp, additional, img_folder, featured_image, description, sponsored, date_added)
      VALUES (:title, :price, :monet, :price_other, :category_id, :brand_id, :model_id, :user_id, :volume, :power, :power_units, :fuel, :engine_emission, :transmission, :drive, :year, :driven, :seats, :steer_w, :color, :color_int, :int_type, :owner, :reg_exp, :additional, :img_folder, :featured_image, :description, :sponsored, :date_added)";
      $statement = $this->connect->prepare($query);
      $statement->execute(
        array(
          ':title'              =>  $vehicle_details->title,
          ':price'              =>  $vehicle_details->price,
          ':monet'              =>  $vehicle_details->monet,
          ':price_other'        =>  $vehicle_details->price_other,
          ':category_id'        =>  $vehicle_details->category,
          ':brand_id'           =>  $vehicle_details->brand,
          ':model_id'           =>  $vehicle_details->model,
          ':user_id'            =>  $user_id,
          ':volume'             =>  $vehicle_details->volume,
          ':power'              =>  $vehicle_details->power,
          ':power_units'        =>  $vehicle_details->power_units,
          ':fuel'               =>  $vehicle_details->fuel,
          ':engine_emission'    => $vehicle_details->engine_emission,
          ':transmission'       => $vehicle_details->transmission,
          'drive'               => $vehicle_details->drive,
          'year'                => $vehicle_details->year,
          'driven'              => $vehicle_details->driven,
          'seats'               => $vehicle_details->seats,
          'steer_w'             => $vehicle_details->steer_w,
          'color'               => $vehicle_details->color,
          'color_int'           => $vehicle_details->color_int,
          'int_type'            => $vehicle_details->int_type,
          'owner'               => $vehicle_details->owner,
          'reg_exp'             => $vehicle_details->reg_exp,
          'additional'          => $vehicle_details->additional,
          'img_folder'          => $vehicle_details->photos_folder,
          'featured_image'      => $vehicle_details->featured_img,
          'description'         => $vehicle_details->description,
          'sponsored'           => $sponsored,
          'date_added'          => $date_added
        )
      );
      $result = $statement->fetchAll();
      $vehicle_id = $this->connect->lastInsertId();
      $addQuery = "INSERT INTO vehicle_additional (vehicle_id, metalic, servo, tempomat, el_window, computer, xenon)
      VALUES (:vehicle_id, :metalic, :servo, :tempomat, :el_window, :computer, :xenon)";
      $addStatement = $this->connect->prepare($addQuery);
      $addStatement->execute(
        array(
          ':vehicle_id'      =>  $vehicle_id,
          ':metalic'         =>  $vehicle_details->metalic,
          ':servo'           =>  $vehicle_details->servo,
          ':tempomat'        =>  $vehicle_details->tempomat,
          ':el_window'       =>  $vehicle_details->el_window,
          ':computer'        =>  $vehicle_details->computer,
          ':xenon'           =>  $vehicle_details->xenon
        )
      );
      $addResult = $addStatement->fetchAll();
      if(isset($addResult)) {
        echo 'VEHICLE_ADD';
      } else {
        echo 'ERROR';
      }
    }
  }

?>
