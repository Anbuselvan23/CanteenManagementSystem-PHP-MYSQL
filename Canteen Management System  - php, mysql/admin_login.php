
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin Login</title>
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
  <link rel="stylesheet" href="css/style_login.css">
</head>

<body>
<?php 
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['admin_id'];
    $password = $_POST['password'];

    // Check if user exists in the database
    $query = mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin_id` = '$user_id' AND `password` = '$password'");
    if (mysqli_num_rows($query) > 0) {
        // Login successful, set session variable and redirect to next page
        $user_data = mysqli_fetch_assoc($query);
        session_start();
        $_SESSION['admin_id'] = $user_data['admin_id'];
        $_SESSION['admin_name'] = $user_data['admin_name'];
        header('Location: admin_page.php');
        exit;
    } else {
        // Login failed, redirect back to login page with error message
        $error_message = 'Invalid id or password. Please try again.';
        header("Location: admin_login.php?error_message=$error_message");
        exit;
    }
}  

?>




<!-- Display the login form -->
<div class="form-container">
    <form id="login-form" method="post" action="">
        <h2>Login</h2>
        <hr>
        <br>
        <label for="admin_id">Admin id:</label>
        <input type="text" id="admin_id" name="admin_id" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="login">Login</button>
        <hr>
        <br>
       <p>Go back to <a href="index.php" id="signup-link">Home</a></p>
        
        <br>
    </form>
</div>


<script src="js/script_login.js"></script>
<script src="js/script.js"></script>

</body>

</html>


