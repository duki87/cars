<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Categories {
    private $connect;
    private $url = 'http://localhost/cars/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function add_category($category_name) {
      $query = "INSERT INTO categories (category_name) VALUES (:category_name)";
      $statement = $this->connect->prepare($query);
      $statement->execute(
        array(
          ':category_name'   =>  $_POST['category_name']
        )
      );
      $result = $statement->fetchAll();
      if(isset($result)) {
        return "CATEGORY_ADDED";
      } else {
        return "SOME_ERROR";
      }
    }

    public function get_total_all_records() {
      $statement = $this->connect->prepare("SELECT * FROM categories");
      $statement->execute();
      return $statement->rowCount();
    }

    public function load_all_categories() {
      $query = "";
      $output = array();
      $query .= "SELECT * FROM categories ";

      if(isset($_POST["search"]["value"])) {
        $query .= 'WHERE category_name LIKE "%'.$_POST["search"]["value"].'%"';
      }

      if(isset($_POST["order"])) {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
      } else {
        $query .= 'ORDER BY category_id DESC ';
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
        $sub_array['category_name'] = $row['category_name'];
        $sub_array['delete'] = '<button type="button" name="delete" id="'.$row["category_id"].'" class="btn btn-danger btn-xs delete-category mx-auto" style="display:block"><i class="fas fa-trash-alt"></i></button>';
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

    public function delete_category($category_id) {
      $query = "DELETE FROM categories WHERE category_id = '$category_id'";
      $statement = $this->connect->prepare($query);
      $result = $statement->execute();
      if($result) {
        echo 'CATEGORY_DELETED';
      } else {
        echo 'ERROR';
      }
    }

  }
