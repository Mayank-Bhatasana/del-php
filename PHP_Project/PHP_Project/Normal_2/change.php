<?php
include('db_connect.php');
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Urban Furniture</title>

    <!-- remix icon cdn link  -->
    <link rel="stylesheet" href="FA/css/all.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <div id="search-btn"><i class="fa-solid fa-magnifying-glass" style="color: #caab9f;"></i></div>
            <div id="../login-btn"><i class="fa-solid fa-user" style="color: #caab9f;"></i></div>
        </div>
    </header>

    <!-- header section ends  -->

<?php
include_once('db_connect.php');

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the entered email and escape it for security
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Check if the email exists in the sign_up table and is active
    $q = "SELECT * FROM furniture WHERE email = '$email' AND status = 'active'";
    $result = $con->query($q);

    if ($result->num_rows > 0) {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Load PHPMailer classes
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';
        require 'PHPMailer/Exception.php';

        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'gondaliyameet37@gmail.com'; // Your email
            $mail->Password   = 'xznn vnit yoxi cfss';  // Use an App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
            $mail->Port       = 587;                          // TLS port number

            // Recipients
            $mail->setFrom('your-email@gmail.com', 'Your Website');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "OTP Verification Code";
            $mail->Body    = "<p>Your OTP code is: <strong>$otp</strong></p>";
            $mail->AltBody = "Your OTP code is: $otp";

            // Send the email
            $mail->send();

            // Redirect to the OTP verification page
            header("Location: verifyotp.php");
            exit();
        } catch (Exception $e) {
            echo "<script>alert('OTP could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href = 'change.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Enter a valid and active email.'); window.location.href = 'change.php';</script>";
        exit();
    }
}
?>

  
  <style>
      body {
          background: url('pexels-artempodrez-7232658.jpg') no-repeat center center fixed;
          background-size: cover;
      }
      .card {
        margin-top: 100px;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
      }
      .error {
        color: red;
        font-size: 14px;
      }
  </style>
 <div class="container mt-5">
      <div class="row justify-content-center">
          <div class="col-md-4">
              <div class="card">
                  <div class="card-header text-center">
                      <h1>Change Password</h1>
                  </div>
                  <div class="card-body">
                      <h3><p class="text-center">Enter an email to receive a verification code</p></h3>
                      <form action="change.php" method="POST" >
                        <!-- id="forgotForm" -->
                        <div class="mb-3">
                              <h2><label for="email" class="form-label">Enter Your Email</label></h2>
                              <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required style="font-size: medium;">
                              <span id="emailError" class="error"></span>
                          </div>
                          <div class="mt-3 text-center">
                              <button type="submit" class="btn btn-outline-primary w-100" name="reset" style="font-size: medium; color: white;">Send Reset Link</button>
                          </div>
                      </form>
                      <div class="mt-3 text-center">
                          <a href="login.php" style="text-decoration: none; font-size: medium; color: black;">Back to Signin</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</body>
</html>

<script>
    $(document).ready(function () {
        $("#forgotForm").submit(function (event) {
            event.preventDefault(); // Prevent form submission

            let email = $("#email").val().trim();
            let emailError = $("#emailError");

            emailError.text(""); // Clear previous error messages

            // Email validation regex
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (email === "") {
                emailError.text("Email is required.");
                return false;
            } else if (!emailPattern.test(email)) {
                emailError.text("Enter a valid email format (e.g., example@mail.com).");
                return false;
            } 

            // AJAX call to check if the email exists
            $.ajax({
                url: "check_email.php", // Create this PHP file to check email existence
                method: "POST",
                data: { email: email },
                success: function (response) {
                    if (response === "not_found") {
                        emailError.text("This email is not registered or is inactive.");
                    } else {
                        $("#forgotForm").unbind("submit").submit(); // Allow form submission
                    }
                }
            });
        });
    });
  </script>



<?php
include('footer.php');
?>