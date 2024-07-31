<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
$user_name = $_SESSION['admin_name'];
$user_id = $_SESSION['admin_id'];

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
  <link rel="stylesheet" href="css/style_table.css">\
  <link rel="stylesheet" href="css/view.css">
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
include 'admin_header.php';
include 'config.php';

if(isset($_POST['delete_order'])){
  $order_id = $_POST['order_id'];

  $delete_query = mysqli_query($conn, "DELETE FROM `order` WHERE order_id='$order_id'");

  if($delete_query){
    echo '<div id="message" class="success-message">Order deleted successfully</div>';
    echo '<script>setTimeout(function(){ document.querySelector(".success-message").style.display = "none"; }, 3000);</script>';
    header('Refresh: .5; url=' . $_SERVER['PHP_SELF']);

  } else {
    echo '<div id="message" class="error-message">Error deleting order</div>';
    echo '<script>setTimeout(function(){ document.querySelector(".error-message").style.display = "none"; }, 3000);</script>';
    header('Refresh: .5; url=' . $_SERVER['PHP_SELF']);
  }
}

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Fetch all orders for the logged in user
$order_query = mysqli_query($conn, "SELECT * FROM `order`") or die('Query failed');
$total_price = 0;

if(mysqli_num_rows($order_query) > 0){

  while ($order_row = mysqli_fetch_assoc($order_query)) {
    echo "<div class='product-container'>";
    $order_id = $order_row['order_id'];
    $order_date = $order_row['date'];
    $order_time = $order_row['time'];
    $order_products = $order_row['total_products'];
    $order_total_price = $order_row['total_price'];

    // Display order details with link to delete order
    echo "<br>";
    echo "<div class='product-box'>";
    echo "<h3> ORDER ID: $order_id</h3>";
    echo "<p>DATE: $order_date</p>";
    echo "<p>TIME: $order_time</p>";
    echo "<p>PRODUCTS: $order_products</p>";
    echo "<p><b>RS: $order_total_price/-</b></p>";
    echo"<br>";
    echo "<td>
          <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this order?\")'>
            <input type='hidden' name='order_id' value='$order_id'>
            <button type='submit' name='delete_order' class='btn btn-danger'>ORDER COMPLETED</button>
          </form>
          </td>";
          echo "</div>";
  }

  echo "</div>"; // Close table-responsive div
}
?>

 <!-- custom js -->   
 <script src="js/script.js"></script>
</body>
</html>