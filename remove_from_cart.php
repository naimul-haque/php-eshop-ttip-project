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

// get current cart
$cart;
$result = mysqli_query($con, "select cart from users where id=$user_id");
if (mysqli_num_rows($result) > 0) {
  while( $data = mysqli_fetch_array($result) ) {
    $cart = $data['cart'];
  }
}

require_once('cart_functions.php');
$new_cart = removeFromCart($cart, $product_id);

$sql = "update users set cart='$new_cart ' where id=$user_id";
if (mysqli_query($con, $sql)) {
  header("Location: index.php");
} else {
  echo "something wrong";
}



?>