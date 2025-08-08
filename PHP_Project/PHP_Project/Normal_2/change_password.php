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
  
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-icons.css">

    <script src="css/bootstrap.bundle.min.js"></script>
    <script src="css/jquery-3.6.0.min.js"></script>
    <script src="css/jquery.validate.min.js"></script>
    <script src="css/additional-methods.min.js"></script>
    <script src="jquery/validation.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>

    <!-- remix icon cdn link  -->
    <link rel="stylesheet" href="FA/css/all.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">

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

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>
<body>

<div class="container py-5">
    <div class="card reset-card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h2 class="text-center text-primary mb-4">Change Password</h2>
            <form id="changePasswordForm">
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" required minlength="6">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Password</button>
            </form>
            <div id="message" class="mt-3 text-center"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $("#changePasswordForm").validate({
        rules: {
            currentPassword: "required",
            newPassword: {
                required: true,
                minlength: 6
            },
            confirmPassword: {
                required: true,
                equalTo: "#newPassword"
            }
        },
        messages: {
            currentPassword: "Please enter your current password",
            newPassword: {
                required: "Please enter a new password",
                minlength: "Password must be at least 6 characters"
            },
            confirmPassword: {
                required: "Please confirm your new password",
                equalTo: "Passwords do not match"
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "process_change_password.php",
                data: $(form).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#message").html('<div class="text-info">Processing...</div>');
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#message").html('<div class="alert alert-success">' + response.message + '</div>');
                        form.reset();
                    } else {
                        $("#message").html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function () {
                    $("#message").html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
                }
            });
        }
    });
});
</script>

</body>
</html>



<?php
include('footer.php');
?>