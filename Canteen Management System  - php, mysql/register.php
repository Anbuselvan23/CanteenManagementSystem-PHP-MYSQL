<?php 
include 'config.php';

ob_start(); // start output buffering

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $user_id = $_POST['user_id'];
    $number = $_POST['number'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $password = $_POST['password'];

    // Check if user already exists in the database
    $query = mysqli_query($conn, "SELECT * FROM `user` WHERE  `user_id` = '$user_id'");
    if (mysqli_num_rows($query) > 0) {
        echo '<div class="error-message"> The User name is already exists!</div>';
        header('Refresh: 0.3; URL=register.php');
        exit;
    }

    // Insert the product into the database
    $insert_query = mysqli_query($conn, "INSERT INTO `user` (user_name, user_id, number, gender, department, password) 
    VALUES ('$user_name', '$user_id','$number','$gender','$department', '$password')");

    if ($insert_query) {
        // Set a success message in the session variable
        echo '<div class="success-message">REGISTRATION DONE</div>';
        header('Refresh: 0.3; URL=user_login.php');
        exit;
    } else {
        // Set an error message in the session variable
        echo '<div class="error-message">REGISTRATION IS FAILED!!! TRY AGAIN</div>';
        header('Refresh: 0.3; URL=register.php');
        exit;
    }
}  

ob_end_flush(); // end output buffering and send the output to the browser
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

  .error-message {
  background-color: #e43449;
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


<div class="form-container">
  <form id="signup-form" method="post" action="" enctype="multipart/form-data">
    <h2>Sign Up</h2>
    <hr>
    <br>
<label for="user_name">Name:</label>
<input type="text" id="user_name" name="user_name" required>

<label for="user_id">User ID:</label>
<input type="text" id="user_id" name="user_id" required>

<label for="number">Mobile no.:</label>
<input type="tel" id="number" name="number" required>

<label for="gender">Gender:</label>
<select id="gender" name="gender" required>
  <option value="">Select</option>
  <option value="male">Male</option>
  <option value="female">Female</option>
  <option value="other">Other</option>
</select>

<label for="department">Department:</label>
<input type="text" id="department" name="department" required>

<label for="password">Password:</label>
<input type="password" id="password" name="password" required>

<button type="submit" name="register">Sign Up</button>
<br>

    <p>Already have an account? <a href="user_login.php" id="login-link">Login</a></p>
  </form>
</div>
<script src="js/script.js"></script>
</body>
</html>


