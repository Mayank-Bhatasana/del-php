<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    
    <title>Home</title>
</head>
<style>
    body {
        background-color: #faf7f6;
    }
</style>
<body>
    
    <style>
        body {
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
            display: none; /* Hide sidebar by default */
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
                display: block; /* Show sidebar on larger screens */
            }
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 50px;
            left: 10px;
            background: rgb(249, 222, 211);
            width: 250px;
            z-index: 1000;
        }
        .dropdown-menu a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: #5e473e;
            display: block;
        }
    </style>
    
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="btn btn-primary d-md-none" style="position: fixed; top: 10px; left: 10px;">
        -
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="index.php" class="d-block text-center"><img src="img/logo.png" class="img-fluid" height="100px"></a>
       <!-- <a href="index.php" class="d-block " style="padding-left: 50px;"><i class="fa fa-tachometer-alt"></i> Dashboard</a> -->
       <a href="category.php" class="d-block" style="padding-left: 50px;"><i class="fa fa-box"></i> Category</a>
        <a href="Products.php" class="d-block " style="padding-left: 50px;"><i class="fa fa-box"></i> Products</a>
        <a href="orders.php" class="d-block " style="padding-left: 50px;"><i class="fa fa-shopping-cart"></i> Orders</a>
        <a href="users.php" class="d-block " style="padding-left: 50px;"><i class="fa fa-users"></i> Users</a>
        <a href="profile.php" class="d-block " style="padding-left: 50px;"><i class="fa fa-users"></i>Profile</a>
        <a href="../login.php" class="d-block " style="padding-left: 50px;"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>


<?php
include('db_connect.php');
session_start();

$email = $_SESSION['admin'];

// Fetch current user details
$q = "SELECT * FROM furniture WHERE email='$email'";
$result = $con->query($q);
$row = mysqli_fetch_assoc($result);
$profilePicture = !empty($row['profile_pic']) ? "img/profile_pictures/" . $row['profile_pic'] : "img/team-6.jpg";

if (isset($_POST['save'])) {
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);

    // Ensure the target directory exists
    $targetDir = "img/profile_pictures/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Check if a new profile picture is uploaded
    if (!empty($_FILES['profile_pic']['name'])) {
        $fileName = basename($_FILES['profile_pic']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

        if (in_array($fileType, $allowTypes)) {
            if (is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFilePath)) {
                    $updateQuery = "UPDATE furniture SET firstname='$firstName', lastname='$lastName', profile_pic='$fileName' WHERE email='$email'";
                } else {
                    echo "<script>alert('File upload failed. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Possible file upload attack.');</script>";
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
        }
    } else {
        $updateQuery = "UPDATE furniture SET firstname='$firstName', lastname='$lastName' WHERE email='$email'";
    }

    if (isset($updateQuery) && $con->query($updateQuery) === TRUE) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }
}
?>

<script>
    $(document).ready(function() {
        $('#profileForm').validate({
            rules: {
                firstName: { required: true, minlength: 2 },
                lastName: { required: true, minlength: 2 }
            },
            messages: {
                firstName: { required: "Please enter your first name", minlength: "First name must be at least 2 characters" },
                lastName: { required: "Please enter your last name", minlength: "Last name must be at least 2 characters" }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });
    });
</script>

<div class="container py-5 col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 text-right" data-aos="flip-left" data-aos-duration="2000">
    <div class="card profile-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h1 class="mb-1"><?php echo $row['firstname'] . " " . $row['lastname']; ?></h1>
                <h2><p class="text-muted"><?php echo $row['email']; ?></p></h2>
            </div>

            <form id="profileForm" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label" style="font-size: medium; padding-right: 230px;">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" style="font-size: medium;" value="<?php echo $row['firstname']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label" style="font-size: medium; padding-right: 230px;">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" style="font-size: medium;" value="<?php echo $row['lastname']; ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label" style="font-size: medium; padding-right: 550px;">Email address</label>
                    <input type="email" class="form-control" id="email" style="font-size: medium;" value="<?php echo $row['email']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="profilePicture" class="form-label" style="font-size: medium; padding-right: 500px;">Update Profile Picture</label>
                    <input type="file" class="form-control" id="profilePicture" name="profile_pic" style="font-size: medium;">
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-outline-danger me-md-2" onclick="window.history.back();">Cancel</button>
                    <button type="submit" class="btn btn-outline-danger" name="save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="footer">
                <div class="container-fluid">
                    <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                            <p> Designed by Urban Furniture </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
   
        <!-- jquery 3.3.1 -->
        <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
        <!-- bootstap bundle js -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <!-- slimscroll js -->
        <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
        <!-- main js -->
        <script src="assets/libs/js/main-js.js"></script>
        <!-- chart chartist js -->
        <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
        <!-- sparkline js -->
        <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
        <!-- morris js -->
        <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
        <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
        <!-- chart c3 js -->
        <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
        <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
        <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
        <script src="assets/libs/js/dashboard-ecommerce.js"></script>
        <script>
            $(document).ready(function() {
                $('#sidebarToggle').click(function() {
                    $('#sidebar').slideToggle();
                });
            });
        </script>
</body>
 
</html>

