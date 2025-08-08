<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Furniture</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- remix icon cdn link  -->
    <link rel="stylesheet" href="FA/css/all.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- header section starts  -->

    <header class="header">
        <a href="home.php" class="logo"><img src="img/logo.png" height="80px"></a>
        <form action="#" class="search-form">
            <input type="search" id="search-box" placeholder="Search here...">
            <label for="search-box" class="fa-solid fa-magnifying-glass"></label>
        </form>

        <div class="icons">
            <div id="search-btn"><i class="fa-solid fa-magnifying-glass"  style=" color: #caab9f;"></i></div>
            <div id="cart-btn"><a href="login.php"><i class="fa-solid fa-cart-shopping" style=" color: #caab9f;"></i></a></div>
            <div id="login-btn"><a href="login.php"><i class="fa-solid fa-user" style="color: #caab9f;"></i></a></div>


        </div>
    </header>


    <!-- header section ends  -->

<?php
session_start();
include_once('db_connect.php'); // Your database connection file

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email from the session (set during OTP verification)
    if (!isset($_SESSION['email'])) {
        $msg = "Session expired. Please try the reset process again.";
    } else {
        $email = $_SESSION['email'];
        // Get new password and confirm password from the form
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        
        // Check if both passwords match
        if ($newPassword !== $confirmPassword) {
            $msg = "Passwords do not match!";
        } else {    
            // Update both the password and confirm_password columns in the database
            $update_query = "UPDATE furniture SET password='$newPassword' WHERE email='$email'";
            
            if (mysqli_query($con, $update_query)) {
                header("Location: ../login.php?message=Password updated successfully!");
                exit();
            } else {
                $msg = "Error updating password: " . mysqli_error($con);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url(images/b3.jpg);
      background-size: cover;
    }
    .card {
      background-color: rgb(201, 184, 165);
      color: rgb(20, 20, 20);
    }
    .reset-card {
      max-width: 400px;
      margin: 100px auto;
      background-color: #f8f9fa;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .reset-card .card-body {
      padding: 40px;
    }
    .btn-primary {
      border: none;
      border-radius: 30px;
      padding: 10px 0;
    }
    .btn-primary:hover {
      background-color: rgb(115, 106, 196);
    }
    .form-label {
      font-weight: bold;
    }
    input.form-control {
      border-radius: 10px;
      border: 1px solid #ced4da;
      padding: 12px 15px;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card reset-card">
      <div class="card-body">
        <h1 class="text-center text-primary mb-4">Change Password</h1>
        <h2><p class="text-muted text-center mb-4">Please enter your new password below.</p></h2>
        <?php if ($msg != "") { echo '<div class="alert alert-danger">' . $msg . '</div>'; } ?>
        <form action="" method="POST">
          <div class="mb-4">
            <label for="newPassword" class="form-label" style="font-size: medium;">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" style="font-size: medium;" required>
          </div>
          <div class="mb-4">
            <label for="confirmPassword" class="form-label" style="font-size: medium;">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" style="font-size: medium;" required>
          </div>
          <button type="submit" class="btn w-100" style="font-size: medium;">Update Password</button>
          <div class="text-center mt-3">
            <a href="home.php" class="text-black text-decoration-none" style="font-size: medium;">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
<


<?php
include('footer.php');
?>