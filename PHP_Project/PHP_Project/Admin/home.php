<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <title>Admin Panel - Manage Slider</title>
    <style>
        body {
            background-color: #faf7f6;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: rgb(249, 222, 211);
            padding-top: 20px;
            display: none; /* Hide sidebar by default on small screens */
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #5e473e;
            display: block;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .footer {
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        @media (min-width: 768px) {
            .sidebar {
                display: block;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar Toggle Button -->
<button id="sidebarToggle" class="btn btn-primary d-md-none" style="position: fixed; top: 10px; left: 10px;">
    ☰
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="index.php" class="d-block text-center"><img src="img/logo.png" class="img-fluid" height="100px"></a>
   <!-- <a href="index.php" class="d-block" style="padding-left: 50px;"><i class="fa fa-tachometer-alt"></i> Dashboard</a> -->
    <a href="Products.php" class="d-block" style="padding-left: 50px;"><i class="fa fa-box"></i> Products</a>
    <a href="orders.php" class="d-block" style="padding-left: 50px;"><i class="fa fa-shopping-cart"></i> Orders</a>
    <a href="users.php" class="d-block" style="padding-left: 50px;"><i class="fa fa-users"></i> Users</a>
    <a href="profile.php" class="d-block" style="padding-left: 50px;"><i class="fa fa-user"></i> Profile</a>
    <a href="../login.php" class="d-block" style="padding-left: 50px;"><i class="fa fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <div class="container mt-4">
        <h2 class="text-center">Manage Slider</h2>
        
        <?php
        $conn = new mysqli("localhost", "root", "", "urban");

        $target_dir = "uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            
        // Save the full URL in the database
        $image_url = "" . $target_file; // Replace with your domain
        $sql = "UPDATE slider SET name='$name', image_path='$image_url' WHERE id=1";
        $conn->query($sql);


        $result = $conn->query("SELECT * FROM slider WHERE id=1");
        $row = $result->fetch_assoc();
        ?>

        <!-- Form starts here -->
        <div class="card p-4">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Upload Image:</label>
                    <input type="file" class="form-control-file" name="image" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

            <div class="mt-3">
                <img src="<?php echo $row['image_path']; ?>" width="200" class="img-thumbnail">
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer mt-4 py-3 bg-light">
    <div class="container text-center">
        <p>Designed by Urban Furniture</p>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script>
    $(document).ready(function() {
        $('#sidebarToggle').click(function() {
            $('#sidebar').slideToggle();
        });
    });
</script>

</body>
</html>
