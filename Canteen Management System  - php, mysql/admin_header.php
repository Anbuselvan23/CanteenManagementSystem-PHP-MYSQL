<?php
include 'config.php'; 

if (isset($_GET['logout'])){
  unset($admin_id);
  session_destroy();
  header('location:admin_login.php');
}
// Check if user is logged in to display cart items count
if (isset($_SESSION['admin_id'])) {
  // Query the database to retrieve the number of items in the user's cart
  $user_id = $_SESSION['admin_id'];
  $select_rows = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
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

    <?php if (isset($_SESSION['admin_id'])) { ?>
      <li><a href="admin_page.php">Admin</a></li>
      <li><a href="admin_orders.php">orders <span><?php echo $row_count; ?></span></a></li>
      <li><a href="admin_header.php?logout=<?php echo $admin_id; ?>" onclick="return confirm('Are you sure, you want to logout?')" class="button">Logout</a></li>
    <?php } else { ?>
      <li><a href="admin_login.php">Login</a></li>
    <?php } ?>
  
  </ul>

</header>



<link rel="stylesheet" href="css/style.css">
<script src="jscript.js"></script>
