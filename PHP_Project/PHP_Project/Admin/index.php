<?php
// Start session to track sidebar toggle
session_start();

// Handle toggle via URL
if (isset($_GET['toggle'])) {
    $_SESSION['sidebar_visible'] = ($_GET['toggle'] === 'show') ? true : false;
}

// Default: show sidebar on larger screens
if (!isset($_SESSION['sidebar_visible'])) {
    $_SESSION['sidebar_visible'] = true;
}

$sidebar_visible = $_SESSION['sidebar_visible'];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Meta and CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Sidebar Toggle</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
        body { background-color: #faf7f6; font-family: Arial, sans-serif; }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: rgb(249, 222, 211);
            padding-top: 20px;
            display: block;
        }
        .sidebar a {
            padding: 15px;
            display: block;
            text-decoration: none;
            font-size: 18px;
            color: #5e473e;
        }
        .content {
            margin-left: <?= $sidebar_visible ? '250px' : '0' ?>;
            padding: 20px;
        }
        .toggle-btn {
            position: fixed;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>

<!-- Toggle Button -->
<form method="get">
    <button type="submit" name="toggle" value="<?= $sidebar_visible ? 'hide' : 'show' ?>" class="btn btn-primary toggle-btn d-md-none">
        <?= $sidebar_visible ? '-' : '☰' ?>
    </button>
</form>

<!-- Sidebar -->
<?php if ($sidebar_visible): ?>
<div class="sidebar">
        <a href="index.php" class="d-block text-center"><img src="img/logo.png" height="100px"></a>
        <a href="category.php" class="d-block" style="padding-left: 67px;"><i class="fa fa-box"></i> Category</a>
        <a href="products.php"><i class="fa fa-box" style="padding-left: 50px;"></i> Products</a>
        <a href="orders.php"><i class="fa fa-shopping-cart" style="padding-left: 50px;"></i> Orders</a>
        <a href="users.php"><i class="fa fa-users" style="padding-left: 50px;"></i> Users</a>
        <a href="profile.php"><i class="fa fa-user" style="padding-left: 50px;"></i> Profile</a>
        <a href="../login.php"><i class="fa fa-sign-out-alt" style="padding-left: 50px;"></i> Logout</a>
    </div>
<?php endif; ?>

<!-- Content -->
<div class="content">
    <h1>Welcome to Dashboard</h1>
    <p>This is the main content area.</p>
</div>

</body>
</html>
