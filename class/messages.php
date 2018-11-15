<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Message {
    private $connect;
    private $url = 'http://localhost/cars/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function send_message($message_data) {
      $message_details = json_decode($message_data);
      $sender_id = $_SESSION['user']['user_id'];
      $receiver_id = $message_details->receiver_id;
      $vehicle_id = $message_details->vehicle_id;
      $chat_id = '';

      $findQuery = "SELECT * FROM chats WHERE user_starter = '$sender_id' AND user_other = '$receiver_id' OR user_starter = '$receiver_id' AND user_other = '$sender_id' AND vehicle_id = '$vehicle_id'";
      // $findQuery = "SELECT id
      // CASE
      //   WHEN user_starter = '$sender_id' AND user_other = '$receiver_id' AND vehicle_id = '$vehicle_id' THEN 'FOUND'
      //   WHEN user_starter = '$receiver_id' AND user_other = '$sender_id' AND vehicle_id = '$vehicle_id' THEN 'FOUND'
      //   ELSE 'NOT_FOUND'
      // END
      // FROM chats";
      $findStatement = $this->connect->prepare($findQuery);
      $findStatement->execute();
      $findResult = $findStatement->fetch();
      if($findResult) {
        $chat_id = $findResult['id'];
      } else {
        $chatQuery = "INSERT INTO chats (user_starter, user_other, vehicle_id) VALUES (:sender_id, :receiver_id, :vehicle_id)";
        $chatStatement = $this->connect->prepare($chatQuery);
        $chatStatement->execute(
          array(
            ':sender_id'            =>  $sender_id,
            ':receiver_id'          =>  $receiver_id,
            ':vehicle_id'           =>  $vehicle_id
          )
        );
        $chatResult = $chatStatement->fetchAll();
        $chat_id = $this->connect->lastInsertId();
      }
      $date_sent = date("Y-m-d h:i:s");
      $unread = 1;
      $messageQuery = "INSERT INTO messages (chat_id, sender_id, receiver_id, text, date_sent, unread) VALUES (:chat_id, :sender_id, :receiver_id, :text, :date_sent, :unread)";
      $messageStatement = $this->connect->prepare($messageQuery);
      $messageStatement->execute(
        array(
          ':chat_id'                =>  $chat_id,
          ':sender_id'              =>  $sender_id,
          ':receiver_id'            =>  $receiver_id,
          ':text'                   =>  $message_details->message_text,
          ':date_sent'              =>  $date_sent,
          ':unread'                 =>  $unread
        )
      );
      $messageResult = $messageStatement->fetchAll();
      if(isset($messageResult)) {
        echo 'MESSAGE_ADD';
      } else {
        echo 'ERROR';
      }
    }

    public function check_messages() {  
      if(isset($_SESSION['user']['user_id'])) {
        $user_id = $_SESSION['user']['user_id'];
        $query = "SELECT * FROM messages WHERE receiver_id = '$user_id' AND unread = 1";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $result = $statement->rowCount();
        if($result > 0) {
          echo '<span class="badge badge-danger">'.$result.'</span>';
        } else {
          echo '';
        }
      } else {
          echo '';
      }
    }

    public function get_inbox_content() {
      $unreadClass = '';
      $inbox_content = '
        <table class="table" style="color:white">
          <thead>
            <tr>
              <th scope="col">Korisnik</th>
              <th scope="col">Oglas</th>
              <th scope="col">Poruka</th>
              <th scope="col">Vreme</th>
            </tr>
          </thead>
          <tbody>';

      $user_id = $_SESSION['user']['user_id'];
      $query = "SELECT * FROM chats WHERE user_starter = '$user_id' OR user_other = '$user_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();

      foreach ($result as $row) {
        $chat_id = $row['id'];
        $messageQuery = "SELECT * FROM messages LEFT JOIN chats ON chats.id = messages.chat_id WHERE chat_id = '$chat_id' ORDER BY date_sent DESC LIMIT 1";
        $messageStatement = $this->connect->prepare($messageQuery);
        $messageStatement->execute();
        $messageResult = $messageStatement->fetchAll();

        foreach ($messageResult as $message) {
          $senderClass = '';

          $user_starter = $message['user_starter'];
          $user_other = $message['user_other'];

          $sender_id = $message['sender_id'];
          $receiver_id =  $message['receiver_id'];
          if($sender_id == $user_id) {
            $senderQuery = "SELECT * FROM users WHERE user_id = '$receiver_id'";
            $senderStatement = $this->connect->prepare($senderQuery);
            $senderStatement->execute();
            $senderDetails = $senderStatement->fetch();
            $senderClass = 'text-info';
          } else {
            $senderQuery = "SELECT * FROM users WHERE user_id = '$sender_id'";
            $senderStatement = $this->connect->prepare($senderQuery);
            $senderStatement->execute();
            $senderDetails = $senderStatement->fetch();
            $senderClass = 'text-warning';
          }

          if($message['unread'] == 1 && $receiver_id == $user_id) {
            $unreadClass = 'bg-primary';
          } else {
            $unreadClass = '';
          }

          $vehicle_id = $message['vehicle_id'];
          $vehicleQuery = "SELECT * FROM vehicle WHERE vehicle_id = '$vehicle_id'";
          $vehicleStatement = $this->connect->prepare($vehicleQuery);
          $vehicleStatement->execute();
          $vehicleDetails = $vehicleStatement->fetch();

          $inbox_content .= '
            <tr class="clickable-row '.$senderClass.' '.$unreadClass.'" data-href="'.$message['chat_id'].'" style="cursor:pointer">
              <th scope="row">'.$senderDetails['name'].' '.$senderDetails['last_name'].'</th>
              <td>'.$vehicleDetails['title'].'</td>
              <td>'.substr($message['text'], 0, 10) .'</td>
              <td>'.$message['date_sent'].'</td>
            </tr>
          ';
        }
      }
    $inbox_content .= '
      </tbody>
    </table>';
    echo $inbox_content;
  }

  public function get_chat_content($chat_id) {
    $message = '';
    $messageArray = array();
    $unreadClass = '';
    $user_other = '';
    $chatQuery = "SELECT * FROM chats WHERE id = '$chat_id'";
    $chatStatement = $this->connect->prepare($chatQuery);
    $chatStatement->execute();
    $chatResult = $chatStatement->fetch();
    $user_id = $_SESSION['user']['user_id'];
    if($user_id == $chatResult['user_starter']) {
      $user_other = $chatResult['user_other'];
    } else {
      $user_other = $chatResult['user_starter'];
    }

    $senderQuery = "SELECT * FROM users WHERE user_id = '$user_other'";
    $senderStatement = $this->connect->prepare($senderQuery);
    $senderStatement->execute();
    $senderDetails = $senderStatement->fetch();
    $sender_name = $senderDetails['name'].' '.$senderDetails['last_name'];

    $query = "SELECT * FROM messages INNER JOIN chats ON chats.id = messages.chat_id WHERE chat_id = '$chat_id' ORDER BY date_sent ASC";
    $statement = $this->connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
      if($row['unread'] == 0) {
        $unread = '<span class="float-right"><i class="far fa-eye"></i></span>';
        $unreadClass = '';
      } else {
        $unread = '';
        $unreadClass = 'unread';
      }

      if($row['sender_id'] == $user_id) {
        $message = '<div class="col-md-12"><div id="mid'.$row[0].'" data-messageId="'.$row[0].'" class="col-md-6 bg-primary float-lg-right mt-2 mb-1 p-3 rounded '.$unreadClass.'">'.$row['text'].$unread.'</div></div>';
        $messageArray[] = $message;
      } else {
        $message = '<div class="col-md-12"><div id="mid'.$row[0].'" data-messageId="'.$row[0].'" class="col-md-6 bg-warning float-lg-left mt-2 mb-1 p-3 rounded" style="color:black">'.$row['text'].'</div></div>';
        $messageArray[] = $message;
      }
    }
    $sender_id = $row['sender_id'];
    $data['messageArray'] = $messageArray;
    $data['chat_id'] = $chat_id;
    $data['sender_name'] = $sender_name;
    $data['receiver_id'] = $user_other;
    echo json_encode($data);
  }

  public function send_message_from_chat($message_data) {
    $user_id = $_SESSION['user']['user_id'];
    $message_details = json_decode($message_data);
    $receiver_id = $message_details->receiver_id;
    $chat_id = $message_details->chat_id;
    $unread = 1;
    $date_sent = date("Y-m-d h:i:s");

    $messageQuery = "INSERT INTO messages (chat_id, sender_id, receiver_id, text, date_sent, unread) VALUES (:chat_id, :sender_id, :receiver_id, :text, :date_sent, :unread)";
    $messageStatement = $this->connect->prepare($messageQuery);
    $messageStatement->execute(
      array(
        ':chat_id'                =>  $chat_id,
        ':sender_id'              =>  $user_id,
        ':receiver_id'            =>  $receiver_id,
        ':text'                   =>  $message_details->message_content,
        ':date_sent'              =>  $date_sent,
        ':unread'                 =>  $unread
      )
    );
    $messageResult = $messageStatement->fetchAll();
    $message_id = $this->connect->lastInsertId();
    if(isset($messageResult)) {
      echo $message_id;
    } else {
      echo 'ERROR';
    }
  }

  public function uncheck_read_messages($chat_id) {
    $user_id = $_SESSION['user']['user_id'];
    $updateQuery = "UPDATE messages SET unread = 0 WHERE chat_id = '$chat_id' AND receiver_id = '$user_id'";
    $updateStatement = $this->connect->prepare($updateQuery);
    $updateStatement->execute();
    $updateResult = $updateStatement->fetch();
    $rowResult = $updateStatement->rowCount();
    if($rowResult > 0) {
      echo 'UNREAD';
    }
  }

  public function load_new_message($message_id) {
    $query = "SELECT * FROM messages WHERE id = '$message_id'";
    $statement = $this->connect->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    $message = '<div class="col-md-12"><div id="mid'.$result['id'].'" data-messageId="'.$result['id'].'" class="col-md-6 bg-primary float-lg-right mt-2 mb-1 p-3 rounded unread">'.$result['text'].'</div></div>';
    echo $message;
  }

  public function check_income_messages($chat_id) {
    $user_id = $_SESSION['user']['user_id'];
    $message = '';
    $query = "SELECT * FROM messages WHERE chat_id = '$chat_id' AND unread = 1 AND receiver_id = '$user_id'";
    $statement = $this->connect->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
      $message = '<div class="col-md-12"><div id="mid'.$result['id'].'" data-messageId="'.$result['id'].'" class="col-md-6 bg-warning float-lg-left mt-2 mb-1 p-3 rounded" style="color:black">'.$result['text'].'</div></div>';
    }

    $messageId = $result['id'];
    $updateQuery = "UPDATE messages SET unread = 0 WHERE id = '$messageId'";
    $updateStatement = $this->connect->prepare($updateQuery);
    $updateStatement->execute();
    $updateResult = $updateStatement->fetch();
    echo $message;
  }

  public function is_unread($check_ids) {
    $task_array = json_decode($check_ids, true);
    $data = array();
    foreach ($task_array as $key) {
      $readQuery = "SELECT * FROM messages WHERE id = '$key'";
      $readStatement = $this->connect->prepare($readQuery);
      $readStatement->execute();
      $readResult = $readStatement->fetch();
      if($readResult['unread'] == 0) {
        $data[] = $key;
      }
    }
    echo json_encode($data);
  }
}
?>
