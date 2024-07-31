<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit;
}
$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>
    <link rel="icon" type="image/png" href="logo/logo-PNG.png">

  <!--  bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" 
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
            
  <!--font awesome -->
  <link rel="stylesheet" href="https://kit.fontawesome.com/37384cedc2.css" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/37384cedc2.js" crossorigin="anonymous"></script>


  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style_table.css">
  <style>
    .success-message {
  background-color: #dff0d8;
  border-color: #d6e9c6;
  color: #3c763d;
  padding: 10px;
  margin-top: 10px;
}

  </style>
</head>

<body>

<?php
include 'header.php';
include 'config.php';

if(isset($_POST['update_product'])){
  $cart_items = $_POST['cart_items'];

  foreach($cart_items as $key => $value){
    $update_query = mysqli_query($conn, "UPDATE `cart` SET quantity='$value' WHERE id='$key' AND user_id='$user_id'");

    if($update_query){
      echo '<div id="message" class="success-message">Cart updated successfully</div>';
      echo '<script>setTimeout(function(){ document.querySelector(".success-message").style.display = "none"; }, 3000);</script>';

    } else {
      echo '<div id="message" class="error-message">Error updating cart</div>';
      echo '<script>setTimeout(function(){ document.querySelector(".error-message").style.display = "none"; }, 3000);</script>';
    }
  }
}


if(isset($_POST['delete_product'])){
  $product_id = $_POST['product_id'];

  $delete_query = mysqli_query($conn, "DELETE FROM `cart` WHERE id='$product_id' AND user_id='$user_id'");

  if($delete_query){
    echo '<div id="message" class="success-message">Product deleted successfully</div>';
    echo '<script>setTimeout(function(){ document.querySelector(".success-message").style.display = "none"; }, 3000);</script>';
    header('Refresh: .5; url=' . $_SERVER['PHP_SELF']);

  } else {
    echo '<div id="message" class="error-message">Error deleting product</div>';
    echo '<script>setTimeout(function(){ document.querySelector(".error-message").style.display = "none"; }, 3000);</script>';
    header('Refresh: .5; url=' . $_SERVER['PHP_SELF']);
  }
}




if(!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Fetch products in cart for the logged in user
$cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('Query failed');
$total_price = 0;

if(mysqli_num_rows($cart_query) > 0){
  echo "<div class='table-responsive'>";
  echo "<table class='product-table'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Name</th>";
  echo "<th>Price</th>";
  echo "<th>Category</th>";
  echo "<th>Stocks</th>";
  echo "<th>Quantity</th>";
  echo "<th>Total Price</th>";
  echo "<th>Actions</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  while ($cart_row = mysqli_fetch_assoc($cart_query)) {
    $product_id = $cart_row['id'];
    $product_name = $cart_row['name'];
    $product_price = $cart_row['price'];
    $product_qty = $cart_row['quantity'];
    $product_category = $cart_row['category'];
    $product_total_price = $product_price * $product_qty;
    $total_price += $product_total_price;
    $product_stock = $cart_row['stocks'];

    // Display cart item details with quantity form
    echo "<tr>";
    echo "<td>$product_name</td>";
    echo "<td>RS: $product_price/-</td>";
    echo "<td>".ucfirst($product_category)."</td>";
    echo "<td>$product_stock</td>";
    echo "<td>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='number' name='cart_items[$product_id]' value='$product_qty' min='1' max='$product_stock'>";
    echo "</td>";
    echo "<td><b>RS: $product_total_price/-</b></td>";
    echo "<td>";
    echo "<input type='submit'class='update_product' name='update_product' value='Update'>";
    echo "<input type='submit'class='delete_product' name='delete_product' value='Delete'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "<tfoot>";
  echo "<tr>";
  echo "<td>  <a href='order_product.php' class='link-btn'>Continue shopping</a></td>";
  echo "<td colspan='4' style='text-align:right'><b>Grand Total :</b></td>";
  echo "<td><b>RS: $total_price/-</b></td>";
  echo '<td>';
  echo '<a href="check_out.php" class="check-btn ';
  echo ($total_price > 1) ? '' : 'disabled';
  echo '">Checkout</a>';
  echo '</td>';


  echo "</tr>";
  echo "</tfoot>";
  echo "</table>";
  echo "</div>"; // Close table-responsive div
}
 else {
  echo '<div class="error-message">Your cart is empty!</div>';
}
?>



 <!-- custom js -->   
 <script src="js/script.js"></script>
</body>
</html>