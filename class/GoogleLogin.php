<?php
require_once('./db/db.php');
require_once('./db/baseurl.php');
$baseurl = baseurl();

class GoogleLogin {
	private $connect;
	private $userTbl = 'google_users';
	private $url = 'http://localhost/cars/';

	function __construct() {
		$db = new Database();
		$this->connect = $db->connect();
	}

	function checkUser($userData = array()) {
		$response = '';
	  if(!empty($userData)){
      //Check whether user data already exists in database
			$oauth_provider = $userData['oauth_provider'];
			$oauth_uid = $userData['oauth_uid'];
      $prevQuery = "SELECT * FROM google_users WHERE oauth_provider = '$oauth_provider' AND oauth_uid = '$oauth_uid'";
      $prevStatement = $this->connect->prepare($prevQuery);
      $prevStatement->execute();
      $prevResult = $prevStatement->rowCount();

      if($prevResult > 0){
				$response = 'EXISTS';
        //Update user data if already exists
        $updateQuery = "UPDATE ".$this->userTbl." SET first_name = '".$userData['first_name']."',
				last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."',
				locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."',
				modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$userData['oauth_provider']."'
				AND oauth_uid = '".$userData['oauth_uid']."'";
				$updateStatement = $this->connect->prepare($updateQuery);
				$updateStatement->execute();
				$updateResult = $prevStatement->fetch();

				//find user
				$email = $userData['email'];
				$selectUserQuery = "SELECT user_id FROM users WHERE email = '$email'";
				$selectUserStatement = $this->connect->prepare($selectUserQuery);
				$selectUserStatement->execute();
				$selectUserResult = $selectUserStatement->fetch();

				$user_id = $selectUserResult['user_id'];
				//Update users table
				$date = date("Y-m-d H:i:s");

				$updateUserQuery = "UPDATE users SET last_login = '$date' WHERE user_id = '$user_id'";
				$updateUserStatement = $this->connect->prepare($updateUserQuery);
				$updateUserStatement->execute();
				$updateUserResult = $updateUserStatement->fetch();

				$user_array['user_id'] = $user_id;
				$user_array['email'] = $userData['email'];
				$user_array['user_name'] = $userData['first_name'];
				$user_array["user_last_name"] = $userData['last_name'];

				$_SESSION['user'] = $user_array;
      } else {
        //Insert user data
        $insertQuery = "INSERT INTO google_users (oauth_provider, oauth_uid, first_name, last_name, email, gender, locale, picture, link, created, modified) VALUES (:oauth_provider, :oauth_uid, :first_name, :last_name, :email, :gender, :locale, :picture, :link, :created, :modified)";
				$insertStatement = $this->connect->prepare($insertQuery);
				$insertStatement->execute(
					array(
						':oauth_provider'		=> $userData['oauth_provider'],
						':oauth_uid'				=> $userData['oauth_uid'],
						':first_name'				=> $userData['first_name'],
						':last_name'				=> $userData['last_name'],
						':email'						=> $userData['email'],
						':gender'						=> $userData['gender'],
						':locale'						=> $userData['locale'],
						':picture'					=> $userData['picture'],
						':link'							=> $userData['link'],
						':created'					=> date("Y-m-d H:i:s"),
						':modified'					=> date("Y-m-d H:i:s")
					)
				);
				$insertResult = $insertStatement->fetchAll();

				$user_array = array();

				$insertUserQuery = "INSERT INTO users (email, password, name, last_name, address, city, phone, photo, active, date_joined, last_login) VALUES (:email, :password, :name, :last_name, :address, :city, :phone, :photo, :active, :date_joined, :last_login)";
				$insertUserStatement = $this->connect->prepare($insertUserQuery);
				$insertUserStatement->execute(
					array(
						':email'					=> $userData['email'],
						':password'				=> password_hash('googleuser',PASSWORD_BCRYPT),
						':name'						=> $userData['first_name'],
						':last_name'			=> $userData['last_name'],
						':address'				=> 'setlater',
						':city'						=> 'setlater',
						':phone'					=> 'setlater',
						':photo'					=> $userData['picture'],
						':active'					=> 1,
						':date_joined'		=> date("Y-m-d H:i:s"),
						':last_login'			=> date("Y-m-d H:i:s")
					)
				);
				$insertUserResult = $insertUserStatement->fetchAll();
				$user_id = $this->connect->lastInsertId();

				$user_array['user_id'] = $user_id;
				$user_array['email'] = $userData['email'];
				$user_array['user_name'] = $userData['first_name'];
				$user_array["user_last_name"] = $userData['last_name'];

				$_SESSION['user'] = $user_array;
				$response = 'NEW_USER';
      }

      //Get user data from the database
      $result = $prevStatement->fetchAll();
	  }

    //Return response
    return $response;
  }
}
?>
