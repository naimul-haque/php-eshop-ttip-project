<?php

  require_once("config.php");
  session_start();
  $result = mysqli_query($con, "select * from products");
  $user_id;

  // get current cart
  $cart = '[]';
  if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $result_cart = mysqli_query($con, "select cart from users where id=$user_id");
    if (mysqli_num_rows($result_cart) > 0) {
      while( $data = mysqli_fetch_array($result_cart) ) {
        $cart = $data['cart'];
      }
    }
    require_once('cart_functions.php');
    $cart_items_count = getCartItemsCount($cart);
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
    <div class="container mx-auto px-6  h-20 flex justify-between items-center">
      <h3 class="text-2xl font-semibold"> <a href="index.php"> eShop </a> </h3>
      <div class="flex items-center">
        <nav class="space-x-4">
          <a href="index.php" class=""> Home </a>
          <?php if (isset($_SESSION['username'])): ?>
          <a href="dashboard.php" class=""> Dashboard </a>
          <a class="ml-10" href="cart.php"> Cart(<?php echo $cart_items_count; ?>) </a>
          <a href="logout.php" class="border-b"> Logout </a>
          <?php else: ?>
          <a href="login.php" class=""> Login </a>
          <a href="register.php" class=""> Register </a>
          <?php endif; ?>
        </nav>
      </div>
    </div>
  </header>

  <section class="container px-6 mx-auto mt-20 mb-20">
    <div class="grid grid-cols-3 gap-20">
      <?php if (mysqli_num_rows($result) > 0): 
          while( $data = mysqli_fetch_array($result) ) : ?>
          <div class="border border-gray-200 rounded px-12 py-8">
            <img class="mx-auto block h-60" src="<?php echo $data['image']; ?>" ?>
            <h3 class="text-2xl font-bold mt-8 tracking-wider text-gray-700"> <?php echo $data['name']; ?> </h3>
            <div class="flex justify-between mt-3">
              <p class="text-xl text-blue-500 font-semibold"> ৳ <?php echo $data['price']; ?> </p>
              <p class="font-semibold text-xl <?php echo ($data['stock'] > 0) ? 'text-green-500' : 'text-red-500'; ?> ">
                <?php echo ($data['stock'] > 0) ? "In Stock" : "Out of Stock" ?>
              </p>
            </div>
            <?php 
              require_once('cart_functions.php');
            ?>
            <?php if (!onCart($cart, $data['id'])) : ?>
              <?php if ($data['stock'] > 0) : ?>
                <a href="add_to_cart.php?id=<?php echo $data['id']; ?>" class="mt-5 inline-block text-white bg-green-500 px-4 py-2 font-medium rounded"> Add to Cart </a>
              <?php else: ?>
                <button class="mt-5 inline-block text-white pointer cursor-not-allowed bg-gray-200 px-4 py-2 font-medium rounded" disabled="true"> Add to Cart </button>
              <?php endif; ?>
            <?php else: ?>
              <a href="remove_from_cart.php?id=<?php echo $data['id']; ?>" class="mt-5 inline-block text-white bg-red-500 px-4 py-2 font-medium rounded"> Remove from Cart </a>
            <?php endif; ?>
          </div>

        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </section>


  <footer class="bg-gray-900 py-8 text-white">
    <div class="contatiner mx-auto px-6 text-center">
      <p>Developed by Naimul Haque. <a class="border-b" href="https://github.com/naimul-haque/php-eshop-ttip-project"> Github Repo </a> </p>
    </div>
  </footer>
</body>

</html>