<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Models {
    private $connect;
    private $url = 'http://localhost/cars/';

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

    public function add_model($brand_id, $category_id) {
      $query = "INSERT INTO models (category_id, brand_id, model_name) VALUES (:category_id, :brand_id, :model_name)";
      $statement = $this->connect->prepare($query);
      $statement->execute(
        array(
          ':category_id'  =>  $_POST['category_id'],
          ':brand_id'     =>  $_POST['brand_id'],
          ':model_name'   =>  $_POST['model_name']
        )
      );
      $result = $statement->fetchAll();
      if(isset($result)) {
        return "MODEL_ADDED";
      } else {
        return "SOME_ERROR";
      }
    }

    public function get_total_all_records() {
      $statement = $this->connect->prepare("SELECT * FROM models");
      $statement->execute();
      return $statement->rowCount();
    }

    public function load_all_models() {
      $query = "";
      $output = array();
      $query .= "SELECT * FROM models INNER JOIN brands ON brands.brand_id = models.brand_id INNER JOIN categories ON categories.category_id = models.category_id ";

      if(isset($_POST["search"]["value"])) {
        $query .= 'WHERE model_name LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR brand_name LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR category_name LIKE "%'.$_POST["search"]["value"].'%"';
      }

      if(isset($_POST["order"])) {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
      } else {
        $query .= 'ORDER BY model_id DESC ';
      }

      if($_POST["length"] != -1) {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
      }

      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();

      $data = array();

      $filtered_rows = $statement->rowCount();
      $counter = 1;
      foreach ($result as $row) {
        $sub_array = array();
        $sub_array['number'] = $counter++;
        $sub_array['model_name'] = $row['model_name'];
        $sub_array['category_name'] = $row['category_name'];
        $sub_array['brand_name'] = $row['brand_name'];
        $sub_array['delete'] = '<button type="button" name="delete" id="'.$row["model_id"].'" class="btn btn-danger btn-xs delete-model mx-auto" style="display:block"><i class="fas fa-trash-alt"></i></button>';
        $data[] = $sub_array;
      }

      $output = array(
        "draw"            =>  intval($_POST["draw"]),
        "recordsTotal"    =>  $filtered_rows,
        "recordsFiltered" =>  $this->get_total_all_records(),
        "data"            =>  $data
      );
      echo json_encode($output);
    }

    public function delete_model($model_id) {
      $query = "DELETE FROM models WHERE model_id = '$model_id'";
      $statement = $this->connect->prepare($query);
      $result = $statement->execute();
      if($result) {
        echo 'MODEL_DELETED';
      } else {
        echo 'ERROR';
      }
    }

  }
