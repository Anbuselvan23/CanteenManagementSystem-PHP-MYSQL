<?php
@include 'config.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

$user_query = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id='$admin_id' AND admin_name='$admin_name'");

if(mysqli_num_rows($user_query) == 0){
   header("Location: register.php");
   exit();
}
// Check if the product id is set and valid
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product from the database
    $delete_query = "DELETE FROM products WHERE id='$product_id'";
    if(mysqli_query($conn, $delete_query)) {
        // Redirect back to the product list page
        header("Location: admin_page.php");
        exit();
    } else {
        echo " deleting product: " . mysqli_error($conn);
    }
} else {
    echo "Invalid product id.";
}
?>
