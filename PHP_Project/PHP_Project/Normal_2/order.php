<?php
include('db_connect.php');
ob_start();
session_start();
?>

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
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">

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
            <div id="cart-btn"><a href="cart.php"><i class="fa-solid fa-cart-shopping" style=" color: #caab9f;"></i></a></div>
            
            

            <nav class="navbar navbar-expand-lg  sticky-top">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <div class="nav-item dropdown">
                            <a class="btn btn-outline-light dropdown-toggle"  href="#" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user" ></i> Profile
                            </a>
                            <?php
                                // Database connection
                                $conn = new mysqli("localhost", "root", "", "urban");

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch user menu items
                                $sql = "SELECT name, link FROM dropd ORDER BY order_no ASC";
                                $result = $conn->query($sql);

                                // Generate dropdown menu dynamically
                                echo '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="border-radius: 10%;">';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<li><a class="dropdown-item" href="' . $row['link'] . '" style="font-size: medium;">' . $row['name'] . '</a></li>';
                                }
                                echo '</ul>';

                                // Close connection
                                $conn->close();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>


    <!-- header section ends  -->


    <!-- closer btn  -->

    <div id="closer"><i class="fa-solid fa-xmark"></i></div>

    <!-- navbar start -->

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php" style="color: #5e473e; font-size: 25px; text-decoration: none; margin-right: 20px;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php" style="color: #5e473e; font-size: 25px; margin-right: 20px;">Shop</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="about.php" style="color: #5e473e; font-size: 25px; margin-right: 20px;">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="team.php" style="color: #5e473e; font-size: 25px; margin-right: 20px;">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php" style="color: #5e473e; font-size: 25px; margin-right: 20px;">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php" style="color: #5e473e; font-size: 25px; margin-right: 20px;">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar end  -->


    <?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $order_time = $_POST['order_time'];
    $customer = $_POST['customer'];
    $status = trim($_POST['status']);  // Remove any whitespace

    // Validate status
    $valid_statuses = ['Pending', 'Delivered', 'Cancelled'];
    if (!in_array($status, $valid_statuses)) {
        die("Invalid status value: " . htmlspecialchars($status));
    }

    // Handle Image Upload
    $target_dir = "uploads/";  // Ensure this directory exists
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name; // Unique filename
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Allow only certain file formats
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move file to the uploads folder
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Insert data into the database
    $query = "INSERT INTO orders (product_name, product_id, quantity, price, order_time, customer, status, image) 
              VALUES ('$product_name', '$product_id', '$quantity', '$price', '$order_time', '$customer', '$status', '$target_file')";

    if ($con->query($query) === TRUE) {
        echo "<script>alert('Order added successfully!'); window.location.href='orders.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $con->error;
    }
}

?>

<div class="row" style="align-content: center;">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Recent Orders</h5>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="border-0">#</th>
                                <th class="border-0">Image</th>
                                <th class="border-0">Product Name</th>
                                <th class="border-0">Product Id</th>
                                <th class="border-0">Quantity</th>
                                <th class="border-0">Price</th>
                                <th class="border-0">Order Time</th>
                                <th class="border-0">Customer</th>
                                <th class="border-0">Status</th>
                            </tr>
                        </thead>
                        <?php
                        include 'db_connect.php';

$query = "SELECT * FROM orders";
$result = $con->query($query);

if (!$result) {
    die("Query failed: " . $con->error);
}

?>

<tbody>
    <?php 
    if ($result->num_rows > 0) {
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td style='font-size: medium;'>" . $counter . "</td>
                <td style='font-size: medium;'>
                    <div class='m-r-10'>
                        <img src='../Admin/".$row["image"]."' alt='product' class='rounded' width='45'>
                    </div>
                </td>


                <td style='font-size: medium;'>" . $row['product_name'] . "</td>
                <td style='font-size: medium;'>" . $row['product_id'] . "</td>
                <td style='font-size: medium;'>" . $row['quantity'] . "</td>
                <td style='font-size: medium;'>$" . $row['price'] . "</td>
                <td style='font-size: medium;'>" . $row['order_time'] . "</td>
                <td style='font-size: medium;'>" . $row['customer'] . "</td>
                <td style='font-size: medium;'><span class='badge-dot badge-" . ($row['status'] == "Pending" ? "brand" : ($row['status'] == "Delivered" ? "success" : "danger")) . " mr-1'></span>" . $row['status'] . "</td>
            </tr>";
            $counter++;
        }
    } else {
        echo "<tr><td colspan='9'>No orders found</td></tr>";
    }
    ?>
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$con->close(); // Close connection ONLY at the end of the script
?>








    <?php
include 'footer.php';
?>