<?php
include('db_connect.php');
ob_start();
session_start();
unset($_SESSION['admin']);
unset($_SESSION['user']);

$em = $pwd = "";
$em_err = $pwd_err = "";
$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $em = trim($_POST['em']);
    $pwd = trim($_POST['ps']);

    // Email validation
    if (empty($em)) {
        $em_err = "Email field cannot be empty";
    } elseif (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        $em_err = "Invalid email format";
    }

    // Password validation
    if (empty($pwd)) {
        $pwd_err = "Password field cannot be empty";
    } elseif (strlen($pwd) < 8) {
        $pwd_err = "Password must be at least 8 characters long";
    } elseif (strlen($pwd) > 25) {
        $pwd_err = "Password must not exceed 25 characters";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$%&!*#?])[a-zA-Z\d@$%&!*#?]{8,25}$/', $pwd)) {
        $pwd_err = "Password must contain at least one Uppercase letter, one Number, and one special Character";
    }

    // If validation passed
    if (empty($em_err) && empty($pwd_err)) {
        $q = "SELECT * FROM furniture WHERE email=? AND password=?";
        $stmt = $con->prepare($q);
        $stmt->bind_param("ss", $em, $pwd);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if ($row['Status'] === 'Active') {
                $role = isset($row['role']) ? $row['role'] : '';

                if ($role === 'Admin') {
                    $_SESSION['admin'] = $em;
                    header("Location: Admin/Products.php");
                    exit;
                } else {
                    // Default fallback for 'User' or unknown roles
                    $_SESSION['user'] = $em;
                    header("Location: Normal_2/home.php");
                    exit;
                }
            } else {
                $login_error = "Your account is inactive.";
            }
        } else {
            $login_error = "Invalid email or password.";
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

    <br><br>

    <!-- PHP-only login form -->
    <div class="login-form" style="margin: 0 auto; max-width: 400px;">
        <form method="POST" action="">
            <h3>Login Form</h3>

            <?php if (!empty($login_error)) : ?>
                <p style="color:red;"><?php echo $login_error; ?></p>
            <?php endif; ?>

            <input type="email" class="box" name="em" value="<?php echo htmlspecialchars($em); ?>" placeholder="Enter Email" required>
            <span style="color:red;"><?php echo $em_err; ?></span>

            <input type="password" class="box" name="ps" placeholder="Enter Password" required>
            <span style="color:red;"><?php echo $pwd_err; ?></span>

            <div class="remember">
                <input type="checkbox" id="remember-me" name="remember">
                <label for="remember-me"> Remember Me</label>
            </div>

            <button class="btn" type="submit" name="login_btn">Login Now</button>

            <p><a href="sign-in_forget.php" style="text-decoration: none;">Forgot password?</a></p>
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
