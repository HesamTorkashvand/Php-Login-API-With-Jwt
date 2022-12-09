<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('enc.php');
require __DIR__.'/classes/Database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();


$data1 = json_decode(file_get_contents("php://input"));
$Action = trim(htmlentities($data1->Action,ENT_QUOTES));

if($Action=="GetToken"){

    if($data1->email){
      $email= trim(htmlentities($data1->email,ENT_QUOTES));
      $check_email = "SELECT `email` FROM `users` WHERE `email`=:email";
      $check_email_stmt = $conn->prepare($check_email);
      $check_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
      $check_email_stmt->execute();
      
      if($check_email_stmt->rowCount()):
  
         $data = $conn->query('SELECT * FROM `users` WHERE email="'.$email.'"')->fetchAll(PDO::FETCH_ASSOC);
         $payload = $data[0]['id']."_".$data[0]['name']."_".$data[0]['email']."_".$data[0]['password'];
         $reset_token = encrypt($payload);
         
         $message = array("Message"=>"valid email","status"=>"ok","code"=>"200","token"=>"$reset_token");
         echo json_encode($message);
  
      else:
         $message = array("Message"=>"invalid email","status"=>"fail","code"=>"400");
         echo json_encode($message);
      
      endif;

    }
    else{
      $message = array("Message"=>"please enter your email","status"=>"fail","code"=>"400");
      echo json_encode($message);
    }
}


else if($Action=="ResetPassword")
{
    if($data1->token && $data1->newpass){
        $token = trim(htmlentities($data1->token,ENT_QUOTES));
        $newpass=trim(htmlentities($data1->newpass,ENT_QUOTES));
          $payload0 = decrypt($token);
          $fixdata = explode('_',$payload0);
          $email = $fixdata[2];
        $data = $conn->query('SELECT * FROM `users` WHERE email="'.$email.'"')->fetchAll(PDO::FETCH_ASSOC);
        $payload1 = $data[0]['id']."_".$data[0]['name']."_".$data[0]['email']."_".$data[0]['password'];
        if($payload0 == $payload1){
      
          $sql =  $conn->prepare("UPDATE users set password = :password where email = :email");
          $sql->execute(array(':password' => password_hash($newpass,PASSWORD_DEFAULT), ':email' => $email));
      
          $message = array("Message"=>"password changed successfully","status"=>"ok","code"=>"200");
          echo json_encode($message);
        }
        else{
          $message = array("Message"=>"invalid token","status"=>"fail","code"=>"400");
          echo json_encode($message);
      
        }

    }
    

   else{
    $message = array("Message"=>"invalid token","status"=>"fail","code"=>"400");
    echo json_encode($message);
   }


}
else{
  $message = array("Message"=>"invalid parametrs please check your parametrs","status"=>"fail","code"=>"400");
  echo json_encode($message);
}


?>
