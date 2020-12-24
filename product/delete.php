<?php 
require_once("../config.php");
session_start();
if (!$_SESSION['username'] || !$_SESSION['id']) {
  header("Location: login.php");
}

$product_id = $_GET['id'];
$user_id = $_SESSION['id'];

$sql = "delete from products WHERE id = $product_id";
$sql_find_user = "select owner from products WHERE id = $product_id";

$result = mysqli_query($con, $sql_find_user);

if (mysqli_num_rows($result) > 0) {
  while( $data = mysqli_fetch_array($result) ) { 
    if ( $data['owner'] == $user_id && mysqli_query($con, $sql) ) {
      header("Location: index.php");
    }
  } 
} 

?>
