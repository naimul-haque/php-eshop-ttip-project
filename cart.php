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

  // get current cart
  $cart;
  $result = mysqli_query($con, "select cart from users where id=$user_id");
  if (mysqli_num_rows($result) > 0) {
    while( $data = mysqli_fetch_array($result) ) {
      $cart = $data['cart'];
    }
  }
  require_once("cart_functions.php");
  $list = getCartItems($cart);
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

  <section class="mt-20 container px-6 mx-auto">

    <div class="mb-10">
      <h3 class="text-3xl font-bold">Cart</h3>
    </div>

    <div class="border-t border-l border-r rounded border-gray-200">
      <table class="table-auto w-full">
        <thead class="border-b border-gray-200">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Image</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Price</th>
          </tr>
        </thead>
        <tbody>

        <?php $total_price = 0; ?>
        <?php for ($i = 0; $i < count($list); ++$i): ?>
          <?php 
            $product_id = $list[$i];
            $sql = "select * from products where id=$product_id"; 
            $result = mysqli_query($con, $sql);
          ?>
          <?php  if (mysqli_num_rows($result) > 0): 
            while( $data = mysqli_fetch_array($result) ) : ?>
             <?php 
              $price = $data['price'];
              $total_price = $total_price + $price;
             ?>
              <tr class="text-left text-xl font-medium text-gray-900 border-b border-gray-200">
                <td class="px-6 py-3"> 
                  <p> <?php echo $data['name']; ?>  </p>
                </td>
                <td class="px-6 py-3"> <img class="h-32" src="<?php echo $data['image']; ?>"> </td>
                <td class="px-6 py-3"> ৳ <?php echo $price; ?> </td>
              </tr>
              <?php endwhile; ?>
            <?php endif; ?>
          <?php endfor; ?>

          <tr class="text-left text-xl font-medium text-gray-900 border-b border-gray-200">
            <td class="px-6 py-3"> Total </td>
            <td class="px-6 py-3">  </td>
            <td class="px-6 py-3"> ৳ <?php echo $total_price; ?> </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

</body>

</html>