<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

@include 'config.php';

$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

$user_query = mysqli_query($conn, "SELECT * FROM `admin` WHERE admin_id='$admin_id' AND admin_name='$admin_name'");

if(mysqli_num_rows($user_query) == 0){
   header("Location: admin_login.php");
   exit();
}

    if(isset($_SESSION['admin_id']) && $_SESSION['admin_name'] == true) {
      
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        if(isset($_POST['product_id']) && isset($_POST['visibility'])) {
            $product_id = $_POST['product_id'];
            $visibility = $_POST['visibility'];
    
            $sql = "UPDATE products SET visibility='$visibility' WHERE id='$product_id'";
    
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Product visibility changed successfully!');</script>";
                echo "<script>window.location.reload();</script>";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    }
    else {
        echo "You are not authorized to view this page.";
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
  integrity="sha512-dyNYSHPp0d9/0ki6UoH6ZejQ2g+sB0nqC3HwuJ5+k24+QbHzg8z5nkgRMtbRfuE+7Zp5A8BogxtSjpY+YtysyQ==" 
  crossorigin="anonymous" referrerpolicy="no-referrer" />



  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style_table.css">
  <style>

  .success-message {
    background-color: #33ff58;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    opacity: 1;
    transition: opacity 0.5s ease;
    font-size: 12px;
    max-width: 20%;
    text-align: center;
  }
  
  </style>
</head>
<body>

<div class="user-info">
  <div class="info-container">
  <?php if (isset($admin_name)): ?>

        <h1><?php echo 'Welcome  ' . $admin_name . ''; ?></h1>
        <h2><?php echo 'Admin Id : ' . $admin_id . '';?></h2>
    <?php else: ?>
        <h1>Welcome!</h1>
    <?php endif; ?>
    <p>This is the admin page.</p>
  </div>
  <img src="images/image-admin.png" alt="Food image">
</div>


<div class="container">

<?php 
include 'admin_header.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];
    $product_stock = $_POST['product_stock'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'upload_img/' . $product_image;

    // Insert the product into the database
    $insert_query = mysqli_query($conn, "INSERT INTO `products` (name, price, category, stocks, image) 
                                         VALUES ('$product_name', $product_price, '$product_category', $product_stock, '$product_image')");
                                         

    if ($insert_query) {
        move_uploaded_file($product_image_tmp_name, $product_image_folder);
        echo '<div class="success-message">Product added successfully!</div>';
        header('Refresh: .5; url=' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo '<div class="error-message">Product insertion failed. Please try again.</div>';
    }
}
?>

  <!-- Button trigger modal -->
  <button type="button" class="add-product-button" data-bs-toggle="modal" data-bs-target="#ProductModal">Add Product</button>

  <!-- Modal -->
  <div class="modal fade" id="ProductModal" tabindex="-1" aria-labelledby="ProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
  
            <h3>Add a new product</h3>
            <hr>
            <div class="form-group">
              <label for="product-name">NAME</label>
              <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter the product name" required>
            </div>
            <br>
            <div class="form-group">
              <label for="product-price">PRICE</label>
              <input type="number" class="form-control" id="product_price" name="product_price" placeholder="Enter the product price" required>
            </div>
            <br>
            <div class="form-group">
    <label for="product-category">Category</label>
    <select class="form-control" id="product_category" name="product_category" required>
      <option value="">Select a category</option>
      <option value="veg">Veg</option>
      <option value="non-veg">Non-Veg</option>
      <option value="snacks">Snacks</option>
      <option value="beverages">Beverages</option>
      <option value="others">Others</optioin>
    </select>
  </div>
  <br>
  <div class="form-group">
    <label for="product-stocks">stocks</label>
    <input type="number" class="form-control" id="product_stock" name="product_stock" placeholder="Enter the product stocks" required>
  </div>
  <br>
            <div class="form-group">
              <label for="product-image">IMAGE</label>
              <input type="file" class="form-control" id="product_image" name="product_image" accept="image/png , image/jpg , image/jpeg" required>
            </div>
            <br>
            <button type="button" class="btn-exit" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn-save" name="add_product">Save</button>
            <br>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<br>
<?php
include 'config.php';

// Fetch products by category
$categories_query = mysqli_query($conn, "SELECT DISTINCT category FROM products") or die('Query failed');
while ($category_row = mysqli_fetch_assoc($categories_query)) {
   $category = ucwords($category_row['category']);
   if ($category == 'veg') {
      $text_color = 'green';
   } elseif ($category == 'non-veg') {
      $text_color = 'red';
   }elseif ($category == 'beverages') {
        $text_color = 'blue';
   }elseif ($category == 'snacks') {
        $text_color = 'orange';
   } else {
      $text_color = 'brown';
   }
   echo "<h2 class='product-title'>$category Product List</h2>";

   // Fetch products by category
   $products_query = mysqli_query($conn, "SELECT * FROM products WHERE category='$category'") or die('Query failed');
   echo "<div class='table-responsive'>";
   echo "<table class='product-table'>";
   echo "<thead>";
   echo "<tr>";
   echo "<th>Image</th>";
   echo "<th>Name</th>";
   echo "<th>Price</th>";
   echo "<th>Category</th>";
   echo "<th>stocks</th>";
   echo "<th>Actions</th>";
   echo "</tr>";
   echo "</thead>";
   echo "<tbody>";
   echo "<br>";
   while ($product_row = mysqli_fetch_assoc($products_query)) {
      $product_id = $product_row['id'];
      $product_name = $product_row['name'];
      $product_price = $product_row['price'];
      $product_stock = $product_row['stocks'];
      $product_image = $product_row['image'];
      $product_category = $product_row['category'];
      $product_visibility = $product_row['visibility'];

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

  // Set visibility button text and value and color class
  if ($product_visibility == 0) {
    $visibility_text = 'unhide';
    $visibility_icon = 'far fa-eye-slash';
    $visibility_value = 1;
  } else {
    $visibility_text = 'Hide';
    $visibility_icon = 'far fa-eye';
    $visibility_value = 0;
  }

  // Display product details and hide/unhide button
  echo "<tr>";
  echo "<td><img src='upload_img/$product_image' height='50' width='50'></td>";
  echo "<td><b>$product_name</b></td>";
  echo "<td>RS: $product_price/-</td>";
  echo "<td style='color: $text_color;'>".ucfirst($product_category)."</td>";
  echo "<td><i class='fa-solid fa-layer-group'></i>  $product_stock</td>";
  echo "<td>  
        <a href='edit_product.php?id=$product_id' class='edit-btn'><i class='fa-solid fa-pen-to-square'></i></a>
        <a href='delete_product.php?id=$product_id' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this product?\");'><i class='fa fa-trash'></i></a>
        <a href='hide_product.php?id=$product_id&visibility=$visibility_value' class='visibility-btn' onclick='event.preventDefault(); window.location.href = this.href;'><i class='$visibility_icon'></i>   <!-- $visibility_text  --> </a>
        </td>";
  echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "<br>";
echo "<br>";
}
?>



  <!-- custom js -->   
  <script src="js/script.js"></script>
  
</body>
</html>