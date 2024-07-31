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
   .checkout-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f5f5f5;
}

.checkout-form {
  width: 80%;
  max-width: 600px;
  background-color: #fff;
  padding: 40px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.checkout-form .heading {
  font-size: 28px;
  font-weight: 600;
  margin-bottom: 30px;
}

.checkout-form .inputBox {
  margin-bottom: 20px;
}

.checkout-form .inputBox span {
  display: block;
  font-size: 18px;
  font-weight: 500;
  margin-bottom: 10px;
}

.checkout-form select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 16px;
  font-weight: 500;
  color: #333;
  background-color: #fff;
  appearance: none;
}

.checkout-form .btn {
  display: block;
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 3px;
  font-size: 18px;
  font-weight: 600;
  color: #fff;
  background-color: #007bff;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.checkout-form .btn:hover {
  background-color: #0069d9;
}

.checkout-form .display-order {
  margin-bottom: 30px;
}

.checkout-form .display-order span {
  display: block;
  font-size: 18px;
  font-weight: 500;
  margin-bottom: 10px;
}

.checkout-form .grand-total {
  font-size: 24px;
  font-weight: 600;
  margin-top: 30px;
}   


/* Checkout form styles */

.checkout-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.checkout-form {
  background-color: #f5f5f5;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
}

.heading {
  text-align: center;
  font-size: 24px;
  margin-bottom: 20px;
}

.display-order {
  margin-bottom: 20px;
}

.display-order span {
  display: block;
  margin-bottom: 10px;
}

.grand-total {
  display: block;
  font-size: 18px;
  font-weight: bold;
  margin-top: 10px;
}

.flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.inputBox {
  width: 100%;
  margin-right: 20px;
}

.inputBox span {
  display: block;
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 5px;
}

select {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: none;
  background-color: #fff;
}

.btn {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

/* Order message container styles */

.order-message-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.message-container {
  background-color: #f5f5f5;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
}

.order-detail {
  margin-bottom: 20px;
}

.order-detail span {
  display: block;
  margin-bottom: 10px;
}

.total {
  display: block;
  font-size: 18px;
  font-weight: bold;
  margin-top: 10px;
}

.customer-details {
  margin-bottom: 20px;
}

.customer-details p {
  font-size: 16px;
  margin-bottom: 5px;
}

.customer-details p span {
  font-weight: bold;
}

.order-message-container a {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  margin-top: 20px;
  text-decoration: none;
  cursor: pointer;
}

.order-message-container a:hover {
  background-color: #0056b3;
}

  </style>
</head>
<body>

<?php include 'header.php'; ?>
<?php
@include 'config.php';

if(isset($_POST['order_btn'])){
  $payment_mode = $_POST['payment_mode'];

  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'");

  $price_total = 0;
  if(mysqli_num_rows($cart_query) > 0){
    $product_name = array(); // initialize the $product_name array
    while($product_item = mysqli_fetch_assoc($cart_query)){
      $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
      $product_price = (float) $product_item['price'] * (int) $product_item['quantity'];
      $price_total += $product_price;
    }
  }
    
  if(empty($product_name)) {
    echo "There was an error retrieving your order details.";
  } else {
    // Retrieve the user's department and number from the database
    $user_query = mysqli_query($conn, "SELECT department, number FROM user WHERE user_id='$user_id'") or die('Query failed');
    $user_data = mysqli_fetch_assoc($user_query);
    $department = $user_data['department'];
    $number = $user_data['number'];
  
    // Insert the order details into the database
    $total_product = implode(', ',$product_name);
    $detail_query = mysqli_query($conn, "INSERT INTO `order`(user_id, user_name, number, department, total_products, total_price, payment_mode) 
    VALUES('$user_id','$user_name','$number','$department','$total_product','$price_total', '$payment_mode')") or die('Query failed');
  
    if($detail_query){
      // delete cart items
      mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'") or die('Query failed');
      // show success message
      echo "
        <div class='order-message-container'>
          <div class='message-container'>
            <h3>thank you for shopping!</h3>
            <div class='order-detail'>
              <span>".$total_product."</span>
              <span class='total'> total : $".$price_total."/-  </span>
            </div>
            <div class='customer-details'>
              <p> your name : <span>".$user_name."</span> </p>
              <p> your id : <span>".$user_id."</span> </p>
              <p> your number : <span>".$number."</span> </p>
              <p> your department : <span>".$department."</span> </p>
              <p> your payment mode : <span>".$payment_mode."</span> </p>
              <p>(*pay on the cash counter*)</p>
            </div>
            <a href='order_product.php' class='btn'>continue shopping</a>
          </div>
        </div>
      ";
    }
  }
}    
?>

<div class="checkout-container">
  <section class="checkout-form">
    <h1 class="heading">complete your order</h1>

    <form action="" method="post">
      <div class="display-order">
        <?php
          $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('Query failed');
          $total = 0;
          $grand_total = 0;

          if(mysqli_num_rows($select_cart) > 0) {
            while($fetch_cart = mysqli_fetch_assoc($select_cart)) {
              $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
              $grand_total = $total += $total_price;
        ?>
          <span><?= $fetch_cart['name']; ?> (qty: <?= $fetch_cart['quantity']; ?>) - Price: $<?= $fetch_cart['price'] * $fetch_cart['quantity']; ?></span>
        <?php
            }
          } else {
            echo "<div class='display-order'><span>your cart is empty!</span></div>";
          }
        ?>
        <span class="grand-total"> grand total : $<?= $grand_total; ?>/- </span>
      </div>

      <div class="flex">
        <div class="inputBox">
          <span>payment method</span>
          <select name="payment_mode" id="payment_mode">
            <option value="cash on delivery" selected>cash on delivery</option>
            <option value="credit cart">credit card</option>
            <option value="paypal">paypal</option>
          </select>
        </div>

        <input type="submit" value="order now" name="order_btn" class="btn">
      </div>
    </form>
  </section>
</div>


<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>