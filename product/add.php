<?php
  $errors = [];
  require_once("../config.php");
  session_start();
  if (!$_SESSION['username'] || !$_SESSION['id']) {
    header("Location: login.php");
    die();
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

  // create a new product
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['name'];
    $image = $_POST['image'];
    $price = intval($_POST['price']);
    $stock = intval($_POST['stock']);
    $description = $_POST['description'];

    if (empty($product_name)) array_push($errors, 'Product name is required');
    if (empty($_POST['stock'])) array_push($errors, 'Product Stock is required');
    if (empty($image)) array_push($errors, 'Product Image is required');
    if (empty($price)) array_push($errors, 'Product Price is required');
    if (empty($description)) array_push($errors, 'Product Description is required');

    if (count($errors) == 0) {
      $sql = "insert into products(name, description, price, stock, owner, image) VALUES ('$product_name', '$description', $price, $stock, $user_id, '$image')";
      if ( mysqli_query($con, $sql) ) {
        header("location: ../dashboard.php");
        die();
      }
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
        <a class="ml-4" href="redirect.php?page=dashboard"> Dashboard </a>
        <a class="border-b ml-4" href="logout.php"> Logout </a>
      </div>
    </div>
  </header>


  <section class="container mx-auto px-6 mt-20">
    <div class="grid grid-cols-2 gap-20">
      <div>
        <h3 class="text-3xl font-semibold mb-8">Add product</h3>

        <?php if (count($errors) > 0) : ?>
          <ul class="list-disc ml-10 mb-8">
            <?php
              for ($i = 0; $i < count($errors); ++$i) {
                echo '<li>' . $errors[$i] . '</li>';
              }
            ?>
          </ul>
        <?php endif; ?>

        <form class="space-y-4" action="add.php" method="POST"> 
          <input class="rounded bg-gray-200 p-4 h-12 w-full focus:outline-none" type="text" name="name" placeholder="Product Name">
          <input class="rounded bg-gray-200 p-4 h-12 w-full focus:outline-none" type="text" name="image" placeholder="Product Image URL">  
          <input class="rounded bg-gray-200 p-4 h-12 w-full focus:outline-none" type="number" name="price" placeholder="Price"> 
          <input class="rounded bg-gray-200 p-4 h-12 w-full focus:outline-none" type="number" name="stock" placeholder="Stock">
          <textarea class="rounded bg-gray-200 p-4 h-12 w-full focus:outline-none h-64" name="description"></textarea>
          <input type="submit" value="Submit" class="bg-blue-500 text-white w-full h-12 rounded">  
        </form>
      </div>
    </div>
  </section>

</body>
</html>