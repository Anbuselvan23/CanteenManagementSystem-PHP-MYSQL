<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

@include 'config.php';

$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

$user_query = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id='$admin_id' AND admin_name='$admin_name'");

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

  </style>
</head>
<body>

<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: admin_page.php');
    exit();
}

$product_query = "SELECT * FROM products WHERE id='$id'";
$product_result = mysqli_query($conn, $product_query);
$product_row = mysqli_fetch_assoc($product_result);

if (!$product_row) {
    header('Location: admin_page.php');
    exit();
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];
    $category = $_POST['category'];

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = uniqid().'.'.pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['image']['tmp_name'], 'upload_img/'.$image);
    } else {
        $image = $product_row['image'];
    }

    $update_query = "UPDATE products SET name='$name', price='$price', stocks='$stocks', image='$image', category='$category' WHERE id='$id'";
    mysqli_query($conn, $update_query);
    header('Location: admin_page.php');
    exit();
}
?>


<div class="edit-product-form">
  <form action="edit_product.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
  <center><h2>Edit Product</h2></center>
  <hr>
    <div class="form-group">
        <label for="name">Product Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $product_row['name'] ?>" required>
    </div>
    <div class="form-group">
        <label for="price">Product Price:</label>
        <input type="number" class="form-control" id="price" name="price" value="<?= $product_row['price'] ?>" required>
    </div>
    <div class="form-group">
        <label for="stocks">Product stocks:</label>
        <input type="number" class="form-control" id="stocks" name="stocks" value="<?= $product_row['stocks'] ?>" required>
    </div>
    <div class="form-group">
        <label for="category">Product Category:</label>
        <select class="form-control" id="category" name="category" required>
            <?php
            $categories = ['veg', 'non-veg', 'beverages', 'snacks', 'others'];
            foreach ($categories as $category) {
                $selected = $product_row['category'] == $category ? 'selected' : '';
                echo "<option value='$category' $selected>$category</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for
        ="image">Product Image:</label>
        <?php if ($product_row['image']) { ?>
            <div class="image-preview">
                <img src="upload_img/<?= htmlspecialchars($product_row['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Product Image">
            </div>
        <?php } ?>
        <input type="file" class="form-control" id="image" name="image">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($product_row['image'], ENT_QUOTES, 'UTF-8') ?>">
    </div>
    <div><button type="submit" class="btn btn-primary" name="update">Update</button>
    <button type="button" class="btn btn-secondary" onclick="goToAdminPage()">Cancel</button></div>
    
  </form>
</div>
</body>

<script>
function goToAdminPage() {
  window.location.href = "admin_page.php";
}
</script>

<!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>


<style>
/* Default styles */

body {
  background-image: url('images/background2.jpg');
}

.edit-product-form {
  max-width: 500px;
  margin: 0 auto;
  padding: 20px;
  background-color: #d4d4d4;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.edit-product-form form {
  display: flex;
  flex-direction: column;
}

.edit-product-form .form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 30px;
}

.edit-product-form label {
  font-weight: bold;
  margin-bottom: 10px;
}

.edit-product-form input[type="text"],
.edit-product-form input[type="number"],
.edit-product-form select {
  width: 100%;
  padding: 12px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 16px;
  transition: border-color 0.2s ease-in-out;
  margin-bottom: 20px;
}

.edit-product-form input[type="text"]:focus,
.edit-product-form input[type="number"]:focus,
.edit-product-form select:focus {
  outline: none;
  border-color: #007bff;
}

.edit-product-form .form-group label {
  margin-bottom: 5px;
}

.edit-product-form .form-group input[type="text"],
.edit-product-form .form-group input[type="number"],
.edit-product-form .form-group select {
  margin-bottom: 0;
}

.edit-product-form .form-group:last-child {
  margin-bottom: 0;
}

.edit-product-form .btn-primary {
  background-color: #004080;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 12px 28px;
  font-size: 12px;
  cursor: pointer;
  margin-top: 20px;
  margin-right:20px;
  float: right;
}

.edit-product-form .btn-primary:hover {
  background-color: #0069d9;
}

.edit-product-form .btn-secondary {
  background-color:  #ff3333;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 12px 28px;
  font-size: 12px;
  cursor: pointer;
  margin-top: 20px;
  margin-left:20px;
  float: left;
}

.edit-product-form .btn-secondary:hover {
  background-color:#ff0000;
}

.edit-product-form .image-preview {
  margin-bottom: 30px;
  text-align: center;
}

.edit-product-form .image-preview img {
  max-width: 250px;
  max-height: 250px;
  border-radius: 5px;
  border: 1px solid #ffffff;
  padding: 10px;
  margin-bottom: 10px;
}





</style>
 <!-- custom js -->   
 <script src="js/script.js"></script>
</body>
</html>