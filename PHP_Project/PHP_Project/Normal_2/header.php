<?php
// Start session if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "urban");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Furniture</title>

    <!-- CSS Links -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="FA/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- JS Scripts -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/additional-methods.min.js"></script>
    <script src="jquery/validation.js"></script>

    <style>
        .btn-profile {
            font-size: medium;
            border-radius: 8%;
            background-color: transparent;
            border: 2px solid #5e473e;
            padding: 6px 12px;
            color: #5e473e;
            text-decoration: none;
            margin-left: 50px;
            transition: 0.3s ease;
        }

        .btn-profile:hover {
            background-color: #5e473e;
            color: #fff;
        }

        .icons {
            display: flex;
            align-items: center;
        }

        .cart-icon {
            font-size: 28px;
            color: #caab9f;
            margin-left: 20px;
            transition: 0.3s ease;
        }

        .cart-icon:hover {
            color: #5e473e;
        }
    </style>
</head>

<body>

    <!-- Header Start -->
    <header class="header">
        <a href="home.php" class="logo"><img src="img/logo.png" height="80px"></a>

        <div class="icons">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping cart-icon"></i></a>
            <a href="profile.php" class="btn-profile">
                <i class="fa-solid fa-user"></i> Profile
            </a>
        </div>
    </header>
    <!-- Header End -->

    <!-- Close Button -->
    <div id="closer"><i class="fa-solid fa-xmark"></i></div>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <?php
                    // Fetch navigation items
                    $sql = "SELECT name, link FROM navigation ORDER BY order_no ASC";
                    $result = $conn->query($sql);
                    $inserted = false;

                    while ($row = $result->fetch_assoc()) {
                        $name = $row['name'];
                        $link = $row['link'];

                        echo '<li class="nav-item">
                                <a class="nav-link" href="' . $link . '" style="color: #5e473e; font-size: 25px; margin-right: 20px;">' . $name . '</a>
                              </li>';

                        // Add "Browse" link after "Shop"
                        if (strtolower(trim($name)) === 'shop' && !$inserted) {
                            echo '<li class="nav-item">
                                  </li>';
                            $inserted = true;
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

</body>
</html>

<?php
// Close DB connection
$conn->close();
?>
