<?php 

$errors = [];
require_once('config.php');

function hasSpace($username) {
  for ($i = 0; $i < strlen($username); ++$i) {
    if ( $username[$i] == ' ' ) {
      return true;
    }
  }
  return false;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($name)) array_push($errors, 'Name is required');
  if (empty($username)) array_push($errors, 'Username is required');
  if (hasSpace($username)) array_push($errors, 'Username can not contain spaces');
  if (empty($email)) array_push($errors, 'Email is required');
  if (empty($password)) array_push($errors, 'Password is required');

  if (count($errors) == 0) {
    $cart = "[]";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "insert into users(name, username, password, email, cart) values ('$name', '$username', '$hashed_password', '$email', '$cart')";
    if ( mysqli_query($con, $sql) ) {
      header("location: login.php");
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>eShop - Login</title>
</head>
<body class="text-lg">

  <div class="min-h-screen text-white flex items-center justify-center">
    <div class="max-w-md bg-blue-600 p-8 rounded shadow-lg w-full mx-auto">
      <h3 class="font-bold text-3xl mb-8"> Register </h3>

      <?php if (count($errors) > 0) : ?>
        <ul class="list-disc ml-10 mb-8">
          <?php
            for ($i = 0; $i < count($errors); ++$i) {
              echo '<li>' . $errors[$i] . '</li>';
            }
          ?>
        </ul>
      <?php endif; ?>

      <form class="text-gray-700 space-y-5" method="POST" action="register.php">
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="text" name="name" placeholder="Full Name">
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="email" name="email" placeholder="Email">  
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="text" name="username" placeholder="Username"> 
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="password" name="password" placeholder="Password"> 
        <input type="submit" class="h-12 rounded bg-blue-900 w-full text-white" value="Register">
      </div>
    </div>
  </div>
  
</body>
</html>