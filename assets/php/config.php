<?php
  session_start();
  
  $server="localhost";
  $username="root";
  $password="";
  $database="my_project";

  $con=mysqli_connect($server, $username, $password, $database);

  if(!$con){
    die("connection is failed due to".mysqli_connect_error());
  } 
  
  

