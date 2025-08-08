<?php
include('db_connect.php');
ob_start();
session_start();

// Initialize variables
$firstname = $email = $password = "";
$fn_err = $em_err = $pwd_err = "";
$success_msg = "";

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['fn']);
    $email = trim($_POST['em']);
    $password = trim($_POST['ps']);

    // Name validation
    if (empty($firstname)) {
        $fn_err = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z ]{2,20}$/", $firstname)) {
        $fn_err = "Name must contain only letters and be 2-20 characters long";
    }

    // Email validation
    if (empty($email)) {
        $em_err = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $em_err = "Invalid email format";
    }

    // Password validation
    if (empty($password)) {
        $pwd_err = "Password is required";
    } elseif (strlen($password) < 8) {
        $pwd_err = "Password must be at least 8 characters";
    } elseif (strlen($password) > 25) {
        $pwd_err = "Password must not exceed 25 characters";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$%&!*#?])[a-zA-Z\d@$%&!*#?]{8,25}$/', $password)) {
        $pwd_err = "Password must include uppercase, number, and special character";
    }

    // Save if valid
    if (empty($fn_err) && empty($em_err) && empty($pwd_err)) {
        $id = uniqid();
        $firstname = mysqli_real_escape_string($con, $firstname);
        $email = mysqli_real_escape_string($con, $email);
        $password = mysqli_real_escape_string($con, $password); // Use hash in production!

        $query = "INSERT INTO furniture (id, firstname, email, password) VALUES ('$id', '$firstname', '$email', '$password')";
        if (mysqli_query($con, $query)) {
            $success_msg = "Registration successful! Redirecting to login...";
            header("refresh:2;url=login.php");
        } else {
            $success_msg = "Error: Unable to register.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Urban Furniture</title>
    <link rel="stylesheet" href="FA/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <a href="home.php" class="logo"><img src="img/logo.png" height="80px" alt="Logo"></a>

    <!-- PHP-only search form -->
    <form action="search.php" method="GET" class="search-form">
        <input type="search" name="query" placeholder="Search here..." required>
        <button type="submit" class="fa fa-search" style="border: none; background: none; color: #caab9f;"></button>
    </form>

    <!-- Non-JS Icon Navigation -->
    <div class="icons">
        <a href="search.php"><i class="fa fa-search" style="color: #caab9f;"></i></a>
        <a href="cart.php"><i class="fa fa-shopping-cart" style="color: #caab9f;"></i></a>
        <a href="login.php"><i class="fa fa-sign-in" style="color: #caab9f;"></i></a>
    </div>
</header>

<!-- Registration Form -->
<div class="registration-form">
    <form action="" method="POST">
        <h1>Registration Form</h1><br>

        <?php if (!empty($success_msg)) : ?>
            <p style="color: green;"><?= $success_msg ?></p>
        <?php endif; ?>

        <input type="text" class="box" name="fn" value="<?= htmlspecialchars($firstname) ?>" placeholder="Enter Name">
        <span style="color: red;"><?= $fn_err ?></span><br>

        <input type="email" class="box" name="em" value="<?= htmlspecialchars($email) ?>" placeholder="Enter Email">
        <span style="color: red;"><?= $em_err ?></span><br>

        <input type="password" class="box" name="ps" placeholder="Enter Password">
        <span style="color: red;"><?= $pwd_err ?></span><br>

        <div class="remember">
            <input type="checkbox" id="remember-me">
            <label for="remember-me"> Remember Me</label>
        </div>

        <button class="btn" type="submit">Register Now</button>
        <p>Already have an account? <a href="login.php">Sign In</a></p>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
