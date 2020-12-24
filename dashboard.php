<?php
  $errors = [];
  require_once("config.php");
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

  $result = mysqli_query($con, "select * from products where owner = $user_id ORDER BY id DESC");
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
      <h3 class="text-2xl font-semibold"> <a href="index.php"> eShop </a> </h3>
      <div class="flex items-center">
        <div class="h-10 w-10 bg-green-500 rounded-full flex items-center justify-center"> <?php echo $name[0] ?> </div>
        <h4 class="ml-3"> <?php echo $name; ?> </h4>
        <a class="ml-10" href="index.php"> Home </a>
        <a class="border-b ml-4" href="logout.php"> Logout </a>
      </div>
    </div>
  </header>

  <section class="mt-20 mb-20 container px-6 mx-auto">

    <div class="mb-10">
      <a href="product/add.php" class="inline-block rounded bg-green-500 text-white px-4 py-2"> Add Product </a>
    </div>

    <div class="border rounded border-gray-200">
      <table class="table-auto w-full">
        <thead class="border-b border-gray  -200">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Image</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Price</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Stock</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Description</th>
          </tr>
        </thead>
        <tbody>

        <?php  if (mysqli_num_rows($result) > 0): 
          while( $data = mysqli_fetch_array($result) ) : ?>
            <tr class="text-left text-xl font-medium text-gray-900">
              <td class="px-6 py-3"> 
                <p> <?php echo $data['name']; ?>  </p>
                <div class="text-sm space-x-4 mt-4">
                  <a href="product/delete.php?id=<?php echo $data['id']; ?>" class="inline-block rounded bg-red-500 text-white px-4 py-2"> Delete Product </a>
                  <a href="product/edit.php?id=<?php echo $data['id']; ?>" class="inline-block rounded bg-blue-500 text-white px-4 py-2"> Edit Product </a>
                </div>
              </td>
              <td class="px-6 py-3"> <img class="h-32" src="<?php echo $data['image']; ?>"> </td>
              <td class="px-6 py-3"> <?php echo $data['price']; ?> </td>
              <td class="px-6 py-3"> <?php echo $data['stock']; ?> </td>
              <td class="px-6 py-3"> <?php echo $data['description']; ?> </td>
            </tr>
            <?php endwhile; ?>
          <?php endif; ?>

        </tbody>
      </table>
    </div>
  </section>

  <footer class="bg-gray-900 py-8 text-white">
    <div class="contatiner mx-auto px-6 text-center">
      <p>Developed by Naimul Haque. <a class="border-b" href="https://github.com/naimul-haque/php-eshop-ttip-project"> Github Repo </a> </p>
    </div>
  </footer>
</body>

</html>