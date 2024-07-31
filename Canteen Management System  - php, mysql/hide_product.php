<?php
include 'config.php';

// Check if product ID and visibility value are passed in the URL
if (isset($_GET['id']) && isset($_GET['visibility'])) {
   $product_id = $_GET['id'];
   $visibility = $_GET['visibility'];

   // Update visibility status of the product in the database
   $update_query = mysqli_query($conn, "UPDATE products SET visibility='$visibility' WHERE id='$product_id'") or die('Query failed');
   if ($update_query) {
      // Redirect back to the products page
      header('Location: admin_page.php');
      exit;
   } else {
      echo "Failed to update visibility status";
   }
}
?>
