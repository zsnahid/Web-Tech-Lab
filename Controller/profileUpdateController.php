<?php
  session_start();

  require_once('../Model/alldb.php');

if(isset($_POST['updateProfile'])){
  $email = $_SESSION['user'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];

  $res = updateUserData($email, $name, $password, $phone);
  if($res){
      header('location: ../View/profileView.php');
  }    
  else{
      $_SESSION['error'] = 'There was an error updating your profile';
      header('location: ../View/profileView.php');
  }
}
?>