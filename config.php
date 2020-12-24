<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'eshop');
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($con === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$query = "select id from users";
$result = mysqli_query($con, $query);

if(empty($result)) {
  $query = "create table users (
    id int(11) NOT NULL AUTO_INCREMENT,
    name vachar(100) NOT NULL,
    username varchar(100) NOT NULL,
    password varchar(255) NOT NULL,
    email varchar(100) NOT NULL,
    cart varchar(10000) NOT NULL,
    PRIMARY KEY (id)
   )";
  $result = mysqli_query($con, $query);
}

$query = "select id from products";
$result = mysqli_query($con, $query);

if(empty($result)) {
  $query = "create table product (
   id int(11) NOT NULL AUTO_INCREMENT,
   name` varchar(200) NOT NULL,
   description varchar(10000) NOT NULL,
   price int NOT NULL,
   stock int NOT NULL,
   owner int NOT NULL,
   image varchar(2000) NOT NULL,
   PRIMARY KEY (id)";
  $result = mysqli_query($con, $query);
}

?>