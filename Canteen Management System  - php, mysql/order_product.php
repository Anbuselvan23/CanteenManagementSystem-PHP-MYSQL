<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit;
}

@include 'config.php';

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$user_query = mysqli_query($conn, "SELECT * FROM user WHERE user_id='$user_id' AND user_name='$user_name'");

if(mysqli_num_rows($user_query) == 0){
   header("Location: register.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Admin</title>
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

.product-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  text-align: center;
  margin: 0 auto;
  max-width: 1200px; /* set a maximum width for the container */
}

.product-box {
  flex-basis: calc(20% - 20px); /* calculate the width for 5 products in a row */
  margin: 10px;
  padding: 10px;
  box-sizing: border-box;
  border: 1px solid #ddd;
  border-radius: 5px;
  transition: all 0.3s ease-in-out;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  max-width: 220px;
}

.product-box:hover {
  box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.3);
  z-index: 1;
}

.product-box img {
  display: block;
  margin: 0 auto;
  height: 150px;
  width: 150px;
  object-fit: cover;
  border-radius: 50%;
}

.product-box h3 {
  margin: 10px 0;
  font-size: 18px;
  font-weight: 600;
}

.product-box p {
  margin: 5px 0;
  font-size: 16px;
}

.product-box label {
  font-size: 16px;
  font-weight: 600;
}

.product-box input[type="number"] {
  width: 50px;
  margin-right: 10px;
  padding: 5px;
  font-size: 16px;
  text-align: center;
  border-radius: 5px;
  border: 1px solid #ddd;
}

.product-box input[type="submit"] {
  padding: 5px 15px;
  font-size: 16px;
  font-weight: 600;
  text-transform: uppercase;
  color: #fff;
  background-color: #333;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
@media screen and (max-width: 767px) {
  .product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: stretch;
    text-align: center;
    margin: 0 auto;
    max-width: 95%; /* set a maximum width for the container */
    
  }

  .product-box {
    flex-basis: calc(33.33% - 10px); /* calculate the width for 3 products in a row */
    margin-bottom: 30px;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
    text-align: center;
  }

  .product-box:hover {
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.3);
  }

  .product-box img {
    display: block;
    margin: 0 auto;
    height: 150px;
    width: 100%;
  }

  .product-box h3 {
    margin: 5px 0;
    font-size: 16px;
    font-weight: 600;
  }

  .product-box p {
    margin: 3px 0;
    font-size: 14px;
  }

  .product-box label {
    font-size: 14px;
    font-weight: 600;
  }

  .product-box input[type="number"] {
    width: 40px;
    margin-right: 5px;
    padding: 3px;
    font-size: 14px;
    text-align: center;
    border-radius: 5px;
    border: 1px solid #ddd;
  }

  .product-box input[type="submit"] {
    padding: 3px 10px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    color: #fff;
    background-color: #333;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
}


</style>
</head>
<?php
include 'header.php';
include 'config.php';

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['add_to_cart'])){
  $product_id = $_POST['id'];
  $product_name = $_POST['name'];
  $product_price =  $_POST['price'];
  $product_qty = $_POST['quantity'];
  $product_category =  $_POST['category'];
  $user_id = $_POST['user_id'];
  $product_stock = $_POST['stocks'];


 // Check if product with same id and user id already exists in cart
 $existing_row_query = mysqli_query($conn, "SELECT * FROM cart WHERE id='$product_id' AND user_id='$user_id'");
 if(mysqli_num_rows($existing_row_query) > 0){
   // Update cart with selected quantity
   $existing_row = mysqli_fetch_assoc($existing_row_query);
   $existing_qty = $existing_row['quantity'];
   $new_qty = $existing_qty + $product_qty;
   $update_query = mysqli_query($conn, "UPDATE `cart` SET quantity='$new_qty' WHERE id='$product_id' AND user_id='$user_id'");

   if($update_query){
     echo '<div id="message" class="success-message">' . $product_name . ' quantity updated in cart successfully</div>';
     echo '<script>setTimeout(function(){ document.querySelector(".success-message").style.display = "none"; }, 3000);</script>';

     // Update cart session
     $_SESSION['cart'][$product_id] = array(
         'product_quantity' => $new_qty
     );
   } else {
     echo '<div id="message" class="error-message">Error updating product quantity in cart </div>';
     echo '<script>setTimeout(function(){ document.querySelector(".error-message").style.display = "none"; }, 3000);</script>';
   }
 } else {
   // Add product to cart with selected quantity
   $insert_query = mysqli_query($conn, "INSERT INTO `cart` (id, name, price, category, quantity, stocks, user_id) 
     VALUES ('$product_id', '$product_name', '$product_price', '$product_category', '$product_qty','$product_stock','$user_id')");

   if($insert_query){
     echo '<div id="message" class="success-message">' . $product_name . ' added to cart successfully</div>';
     echo '<script>setTimeout(function(){ document.querySelector(".success-message").style.display = "none"; }, 3000);</script>';

     // Update cart session
     $_SESSION['cart'][$product_id] = array(
         'product_quantity' => $product_qty
     );
   } else {
     echo '<div id="message" class="error-message">Error inserting product into cart </div>';
     echo '<script>setTimeout(function(){ document.querySelector(".error-message").style.display = "none"; }, 3000);</script>';
   }
 }
}

// Fetch products by category
$categories_query = mysqli_query($conn, "SELECT DISTINCT category FROM products") or die('Query failed');
while ($category_row = mysqli_fetch_assoc($categories_query)) {
   $category = ucwords($category_row['category']);
   
   // Set text color based on category
   switch ($category) {
      case 'Veg':
         $text_color = 'green';
         break;
      case 'Non-Veg':
         $text_color = 'red';
         break;
      case 'Beverages':
         $text_color = 'blue';
         break;
      case 'Snacks':
         $text_color = 'orange';
         break;
      default:
         $text_color = 'brown';
         break;
   }
   
   // Display category title
   echo "<div>";
   echo "<br>";
   echo "<br><h2 class='product-title'>$category Product List</h2>";
   echo "<br>";
   echo "</div>";

   // Fetch products by category
   $products_query = mysqli_query($conn, "SELECT * FROM products WHERE category='$category' AND visibility='1'") or die('Query failed');
   
   // Display products in a grid layout
   echo "<div class='product-container'>";
   while ($product_row = mysqli_fetch_assoc($products_query)) {
      $product_id = $product_row['id'];
      $product_name = $product_row['name'];
      $product_price = $product_row['price'];
      $product_stock = $product_row['stocks'];
      $product_image = $product_row['image'];
      $product_category = $product_row['category'];

      // Display product details with quantity form
      echo "<div class='product-box'>";
      echo "<form method='post'>";
      echo "<img src='upload_img/$product_image' height='50' width='50'>";
      echo "<h3>$product_name</h3>";
      echo "<p style='color: $text_color;'>".ucfirst($product_category)."</p>";
      echo "<p>RS: $product_price/-</p>";
      echo "<p><b>Stock: $product_stock</b></p>";
      echo "<input type='submit' name='add_to_cart' value='Add to Cart' >";
      echo "<input type='hidden' name='id' value='$product_id'>";
      echo "<input type='hidden' name='name' value='$product_name'>";
      echo "<input type='hidden' name='price' value='$product_price'>";
      echo "<input type='hidden' name='category' value='$product_category'>";
      echo "<input type='hidden' name='user_id' value='$user_id'>";
      echo "<input type='hidden' name='stocks' value='$product_stock'>";
      echo "<input type='hidden' id='product_qty' name='quantity' value='1' min='1' max='$product_stock'>";
      echo "</form>";
      echo "</div>";
      echo "<br>";
      echo "<br>";
   }
   echo "</div>"; // Close product container div
}
?>


<script>
  // Get the message element
const message = document.getElementById('message');

// Show the message for 3 seconds
message.style.display = 'block';
setTimeout(function() {
  message.style.display = 'none';
}, 3000);

</script>
  <!-- custom js -->   
  <script src="js/script.js"></script>
</body>
</html>