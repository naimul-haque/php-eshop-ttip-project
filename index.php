<?php

require_once("config.php");
$result = mysqli_query($con, "select * from products");

if (mysqli_num_rows($result) > 0) {
  while( $data = mysqli_fetch_array($result) ) {
    
  }
}


?>