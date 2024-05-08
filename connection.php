<?php
  $con = mysqli_connect('localhost','root','rootroot');
  if(!$con){
    die(mysqli_error());
  }

  $db_select = mysqli_select_db($con, 'cms');
  if(!$db_select){
    die(mysqli_error());
  }
?>
