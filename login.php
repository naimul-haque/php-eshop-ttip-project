<?php 

// for tracking validation errors
$errors = [];
require_once("config.php");

// redirect to dashboard if already logged in
session_start();
if (isset($_SESSION['username'])) {
  header("location: dashboard.php");
}

// if a post request is sent in the /login route
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "select id, password FROM users WHERE username = '$username'";
  $result = mysqli_query($con, $sql);

  if (mysqli_num_rows($result) == 1) {
    while( $data = mysqli_fetch_array($result) ) {
      $hashed_password = $data['password'];
      $id = $data['id'];
      // validate the password
      if(password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        header("location: dashboard.php");
      } else {
        array_push($errors, 'Password Invalid');
      }
    }
  } else {
    array_push($errors, 'User not found');
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
<body>

  <div class="min-h-screen text-white flex items-center justify-center">
    <div class="max-w-md bg-blue-600 p-8 rounded shadow-lg w-full mx-auto">
      <h3 class="font-bold text-3xl mb-4"> Login </h3>
      <p class="mb-8"> Don't have an account? Register <a class="border-b" href="register.php"> here </a>

      <?php if (count($errors) > 0) : ?>
        <ul class="list-disc ml-10 mb-8">
          <?php
            for ($i = 0; $i < count($errors); ++$i) {
              echo '<li>' . $errors[$i] . '</li>';
            }
          ?>
        </ul>
      <?php endif; ?>
      
      <form class="text-gray-700 space-y-5" method="POST" action="login.php">
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="text" name="username" placeholder="Username"> 
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="password" name="password" placeholder="Password"> 
        <input type="submit" class="h-12 rounded bg-blue-900 w-full text-white" value="Login">
      </div>
    </div>
  </div>
  
</body>
</html>