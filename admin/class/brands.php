<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Brands {
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

    public function logo_preview($name) {
      $explode = explode(".", $name);
      $extension = end($explode);
      $newName = 'logo' . rand(10,10000) . "." . $extension;
      $location = '../../images/brand_logos/' . $newName;
      $location2 = '../images/brand_logos/' . $newName;
      move_uploaded_file($_FILES['brand_logo']['tmp_name'], $location);
      echo '
      <div class="image-content">
      <img src="'.$location2.'" class="form-control img-responsive" id="brand_img" alt="" width="100px" height="auto" data-imgname="'.$newName.'">
      <button type="button" name="location" data-location="'.$location.'" class="btn btn-danger " style="position:absolute; top:5px; right:5px" id="remove_button" name="button"><i class="fas fa-times"></i></button>
      </div>';
    }

    public function logo_preview_delete($location) {
      if(unlink($location)) {
        echo 'IMG_DELETED';
      }
    }

    public function add_brand($category_id, $brand_name, $brand_logo, $brand_description) {
      $query = "INSERT INTO brands (category_id, brand_name, brand_logo, brand_description) VALUES (:category_id, :brand_name, :brand_logo, :brand_description)";
      $statement = $this->connect->prepare($query);
      $statement->execute(
        array(
          ':category_id'         =>  $category_id,
          ':brand_name'          =>  $brand_name,
          ':brand_logo'          =>  $brand_logo,
          ':brand_description'   =>  $brand_description
        )
      );
      $result = $statement->fetchAll();
      if(isset($result)) {
        return "BRAND_ADDED";
      } else {
        return "SOME_ERROR";
      }
    }

    public function update_brand($brand_id, $new_category, $brand_new_name, $brand_logo, $brand_new_description) {
      $query = "UPDATE brands SET category_id = '$new_category', brand_name = '$brand_new_name', brand_logo = '$brand_logo', brand_description = '$brand_new_description' WHERE brand_id = '$brand_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      if(isset($result)) {
        return "BRAND_UPDATED";
      } else {
        return "SOME_ERROR";
      }
    }

    public function get_total_all_records() {
      $statement = $this->connect->prepare("SELECT * FROM brands");
      $statement->execute();
      return $statement->rowCount();
    }

    public function get_brands() {
      $query = "";
      $output = array();
      $query .= "SELECT * FROM brands INNER JOIN categories ON categories.category_id = brands.category_id ";

      if(isset($_POST["search"]["value"])) {
        $query .= 'WHERE brand_name LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR category_name LIKE "%'.$_POST["search"]["value"].'%"';
      }

      if(isset($_POST["order"])) {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
      } else {
        $query .= 'ORDER BY brand_id DESC ';
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
        $status = '';
        if($row['brand_status'] == 1) {
          $status = '<button class="btn btn-success btn-xs change-status mx-auto" id="'.$row["brand_id"].'" data-brand_status="active">Aktivan</button>';
        } else {
          $status = '<button class="btn btn-danger btn-xs change-status mx-auto" id="'.$row["brand_id"].'" data-brand_status="inactive">Neaktivan</button>';
        }
        $sub_array = array();
        $sub_array['number'] = $counter++;
        $sub_array['category_name'] = $row['category_name'];
        $sub_array['brand_name'] = $row['brand_name'];
        $sub_array['brand_logo'] = $row['brand_logo'];
        $sub_array['brand_status'] = $status;
        $sub_array['edit'] = '<button type="button" name="update" id="'.$row["brand_id"].'" class="btn btn-info btn-xs edit-brand mx-auto" style="display:block" data-toggle="modal" data-target="#brandEditModal"><i class="fas fa-edit"></i></button>';
        $sub_array['delete'] = '<button type="button" name="delete" id="'.$row["brand_id"].'" class="btn btn-danger btn-xs delete-brand mx-auto" style="display:block"><i class="fas fa-trash-alt"></i></button>';
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

    public function change_brand_status($brand_id) {
      $brand_new_status = '';
      $query = "SELECT brand_status FROM brands WHERE brand_id = '$brand_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetch();
      if($result['brand_status'] == 1) {
        $brand_new_status = 0;
      } else {
        $brand_new_status = 1;
      }
      $cquery = "UPDATE brands SET brand_status = '$brand_new_status' WHERE brand_id = '$brand_id'";
      $statement = $this->connect->prepare($cquery);
      $result = $statement->execute();
      if($result) {
        echo 'STATUS_CHANGED';
      } else {
        echo 'ERROR';
      }
    }

    public function delete_brand($brand_id) {
      $find_brand = "SELECT * FROM brands WHERE brand_id = '$brand_id'";
      $statement = $this->connect->prepare($find_brand);
      $statement->execute();
      $result = $statement->fetch();
      $logo_location = '../../images/brand_logos/' . $result['brand_logo'];
      if(unlink($logo_location)) {
        $unlink = true;
      }
      $query = "DELETE FROM brands WHERE brand_id = '$brand_id'";
      $statement = $this->connect->prepare($query);
      $result = $statement->execute();
      if($result && $unlink) {
        echo 'BRAND_DELETED';
      } else {
        echo 'ERROR';
      }
    }

    public function get_brand_data($brand_id) {
      $data = array();
      $query = "SELECT * FROM brands WHERE brand_id = '$brand_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetch();
      $data['brand_name'] = $result['brand_name'];
      $data['category_id'] = $result['category_id'];
      $data['brand_description'] = $result['brand_description'];
      $data['brand_logo'] = $result['brand_logo'];
      echo json_encode($data);
    }

  }
