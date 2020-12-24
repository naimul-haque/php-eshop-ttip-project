<?php
  $errors = [];
  require_once("../config.php");
  session_start();
  if (!$_SESSION['username'] || !$_SESSION['id']) {
    header("Location: login.php");
  }
  
  $username = $_SESSION['username'];
  $user_id = intval($_SESSION['id']);

  // get full name of user
  $name = "";
  $sql = "select name FROM users WHERE username = '$username'";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) == 1) {
    while( $data = mysqli_fetch_array($result) ) {
      $name = $data['name'];
    }
  }

 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>eShop - Dashboard </title>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="text-lg">

  <header class="bg-gray-800 text-white shadow">
    <div class="container mx-auto px-6 flex h-20 justify-between items-center">
      <h3 class="text-2xl font-semibold"> <a href="redirect.php"> eShop </a> </h3>
      <div class="flex items-center">
        <div class="h-10 w-10 bg-green-500 rounded-full flex items-center justify-center"> <?php echo $name[0] ?> </div>
        <h4 class="ml-3"> <?php echo $name; ?> </h4>
        <a class="ml-10" href="index.php"> Home </a>
        <a class="border-b ml-4" href="logout.php"> Logout </a>
      </div>
    </div>
  </header>

 

</body>

</html>