<?php

require_once('config.php');
session_start();
if (!$_SESSION['username'] || !$_SESSION['id']) {
  header("Location: login.php");
  die();
}

$username = $_SESSION['username'];
$user_id = intval($_SESSION['id']);

$product_id = $_GET['id'];
$sql_get = "select cart from users where id =$user_id";
$result = mysqli_query($con, $sql_get);

$current_cart;
if (mysqli_num_rows($result) > 0) {
  while( $data = mysqli_fetch_array($result) ) {
    $current_cart = $data['cart'];
  }
}

// check if there is enough stock
$sql_check_stock = "select stock from products where id=$product_id";
$result_check = mysqli_query($con, $sql_check_stock);
if (mysqli_num_rows($result_check) > 0) {
  while( $data = mysqli_fetch_array($result_check) ) {
    if ( $data['stock'] < 1) {
      header("Location: index.php");
      die();
    }
  }
}

// check if already on users cart
require_once('cart_functions.php');
if ( onCart($current_cart, $product_id) ) {
  header("Location: index.php");
  die();
}

// update the cart
$cart = $current_cart."[".$product_id."]";

$sql = "update users set cart='$cart' where id=$user_id";
if (mysqli_query($con, $sql)) {
  header("Location: index.php");
} else {
  echo "something wrong";
}

?>