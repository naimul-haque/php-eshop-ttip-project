<?php 

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

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
      <h3 class="font-bold text-3xl mb-8"> Register </h3>
      <form class="text-gray-700 space-y-5" method="POST" action="login.php">
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="text" name="name" placeholder="Full Name">
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="text" name="email" placeholder="Email">  
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="text" name="username" placeholder="Username"> 
        <input class="rounded bg-white p-4 h-12 w-full focus:outline-none" type="text" name="password" placeholder="Password"> 
        <input type="submit" class="h-12 rounded bg-blue-900 w-full text-white" value="Register">
      </div>
    </div>
  </div>
  
</body>
</html>