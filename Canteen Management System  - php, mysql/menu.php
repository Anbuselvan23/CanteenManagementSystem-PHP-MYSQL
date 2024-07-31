
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
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-gap: 20px;
}

.product-box {
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
  padding: px;
  margin: 5px;
  margin-left: 30px;
  margin-right: 30px;
  max-width: 300px;
  text-align: center;
  width: 80%;
  transition: transform 0.3s ease;
  margin-bottom: 20px;
  position: relative;
}

.product-box img {
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
  height: 200px;
  object-fit: fill;
}

.product-box:hover {
  transform: scale(1.05);
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
  z-index: 1;
}


.product-box:hover::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.5);
  z-index: -1;
}


.product-title h2{
  text-align: center;
  background-color: #586876;
  padding: 10px;
  margin-bottom: 10px;
  font-family: 'Montserrat', sans-serif;
  font-size: 24px;
  font-weight: bold;
  text-transform: uppercase;
}

.product-box h3 {
  margin-top: 10px;
  margin-bottom: 5px;
  font-family: 'Montserrat', sans-serif;
  font-size: 20px;
  font-weight: bold;
}

.product-box p {
  font-family: 'Montserrat', sans-serif;
  font-size: 20px;
  margin-bottom: 5px;
}

.product-box .price {
  font-weight: bold;
  color: #ff0000;
}

.product-box .category {
  font-weight: bold;
  text-transform: uppercase;
  color: #0066ff;
}

/* Mobile styles */
@media (max-width:760px) {
  .product-container {
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    grid-gap: 3px;
  }
  
  .product-box {
    max-width: 110px;
  }
  
  .product-box img {
    height: 90px;
  }
  
  .product-box::after {
    font-size: 10px;
    padding: 2px;
  }
  
  .product-title {
    font-size: 16px;
  }
  
  .product-box h3 {
    font-size: 14px;
  }
  
  .product-box p {
    font-size: 14px;
  }
}

</style>
</head>


<?php
include 'header.php';
include 'config.php';

// Fetch products by category
$categories_query = mysqli_query($conn, "SELECT DISTINCT category FROM products") or die('Query failed');
while ($category_row = mysqli_fetch_assoc($categories_query)) {
   $category = ucwords($category_row['category']);
   if ($category == 'veg') {
      $text_color = 'green';
   } elseif ($category == 'non-veg') {
      $text_color = 'red';
   } elseif ($category == 'beverages') {
        $text_color = 'blue';
   } elseif ($category == 'snacks') {
        $text_color = 'orange';
   } else {
      $text_color = 'brown';
   }
   echo "<br>";
   echo "<h2 class='product-title'>$category Product List</h2>";
   echo "<br>";

   // Fetch visible products by category
   $products_query = mysqli_query($conn, "SELECT * FROM products WHERE category='$category' AND visibility='1'") or die('Query failed');
   echo "<div class='product-container'>";
   while ($product_row = mysqli_fetch_assoc($products_query)) {
      $product_id = $product_row['id'];
      $product_name = $product_row['name'];
      $product_price = $product_row['price'];
      $product_stock = $product_row['stocks'];
      $product_image = $product_row['image'];
      $product_category = $product_row['category'];

      // Set text color based on category
      if ($product_category == 'veg') {
         $text_color = 'green';
      } elseif ($product_category == 'non-veg') {
         $text_color = 'red';
      } elseif ($product_category == 'beverages') {
          $text_color = 'blue';
      } elseif ($product_category == 'snacks') {
          $text_color = 'orange';
      } else {
         $text_color = 'brown';
      }
      // Display product details
      echo "<div class='product-box'>";
      echo "<img src='upload_img/$product_image' height='50' width='50'>";
      echo "<h3>$product_name</h3>";
      echo "<p style='color: $text_color;'>".ucfirst($product_category)."</p>";
      echo "<p>RS: $product_price/-</p>";
      echo "<p><b>Qty: $product_stock</b></p>";
      echo "</div>";
   }
   echo "</div>";
   echo "<br>";
   echo "<br>";
}
?>

  <script src="js/script.js"></script>
</body>
</html>