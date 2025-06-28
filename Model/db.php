<?php
function getConnection()
{
  $serverName="localhost";
  $userName="root";
  $password="";
  $dbName="weather_db";
  $con=new mysqli( $serverName,$userName,$password,$dbName);
  return $con;
}
?>