<?php
session_start();
require_once('../Model/alldb.php');

if(isset($_POST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email || $password)){
    $_SESSION['error'] = 'Email or password is empty';
    header('location: ../index.php');
  }
  else{
    $res = auth($email, $password);
    if(mysqli_num_rows($res) === 1){
      $_SESSION['user'] = $email;
      header('location: ../View/profileView.php');
    }
    else{
      $_SESSION['error'] = 'Invalid email or password';
      header('location: ../index.php');
    }
  }
}

?>