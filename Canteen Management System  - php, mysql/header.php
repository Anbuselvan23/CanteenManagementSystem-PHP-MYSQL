<?php
include 'config.php'; 

if (isset($_GET['logout'])){
  unset($user_id);
  session_destroy();
  header('location:user_login.php');
}

$row_count = 0;
// Check if user is logged in to display cart items count
if (isset($_SESSION['user_id'])) {
  // Query the database to retrieve the number of items in the user's cart
  $user_id = $_SESSION['user_id'];
  $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
  $row_count = mysqli_num_rows($select_rows);
}
?>

<header class="navbar">
  <div class="navbar-brand">
    <img src="logo/logo-PNG.png" alt="logo">Canteen</img>
  </div>
  <div class="menu-toggle">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
  </div>
 
  <ul class="menu">
  <li><a href="menu.php"></a></li>
    <?php if (isset($_SESSION['user_id'])) { ?>
      <li><a href="order_product.php">Buy</a></li>
      <li><a href="cart.php">Cart <span><?php echo $row_count; ?></span></a></li>
      <li><a href="view_order.php">My Order</a></li>
      <li><a href="header.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure, you want to logout?')" class="button">Logout</a></li>
    <?php } else { ?>
      <li><a href="user_login.php">Login</a></li>
    <?php } ?>
  
  </ul>

</header>



<link rel="stylesheet" href="css/style.css">
<script src="jscript.js"></script>
