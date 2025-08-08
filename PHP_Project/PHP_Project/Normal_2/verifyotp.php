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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$msg = "";

// Function to send OTP via email
function sendOTPEmail($to, $otp)
{
    $mail = new PHPMailer(true);
    try { 
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gondaliyameet37@gmail.com'; // Your email
        $mail->Password   = 'xznn vnit yoxi cfss';  // Use an App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->SetFrom('gondaliyameet37@gmail.com', 'Student Demo Website'); //from
        $mail->AddReplyTo("gondaliyameet37@gmail.com", "Student Demo Website"); //to
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = "Your OTP Code";
        $mail->Body    = "<h3>Your OTP code for verification is: <strong>$otp</strong></h3>";

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

// Generate and send OTP
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $_SESSION['otp'] = rand(100000, 999999);
    $_SESSION['email'] = $email;

    if (sendOTPEmail($email, $_SESSION['otp'])) {
        $msg = "OTP has been sent to your email.";
    } else {
        $msg = "Failed to send OTP. Try again!";
    }
}

// Verify OTP
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'] . $_POST['otp6'];

    if ($_SESSION['otp'] == $entered_otp) {
        header("Location: reset.php");
        exit();
    } else {
        $msg = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .otp-container { display: flex; gap: 10px; justify-content: center; margin-bottom: 20px; }
        .otp-input { width: 50px; height: 50px; text-align: center; font-size: 24px; border: 2px solidrgb(53, 195, 220); border-radius: 10px; }
        .otp-input:focus { outline: none; box-shadow: 0 0 8px rgba(53, 170, 220, 0.5); }
        body{
            background-image: url(images/background1.jpg);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <h1 class="text-center mb-3">Enter OTP</h1>
                <h2><p class="text-muted text-center mb-4">Please enter the verification code sent to your email</p></h2>
                <?php if ($msg) { echo "<p class='text-center text-danger'>$msg</p>"; } ?>


                <!-- Verify OTP Form -->
                <form method="POST">
                    <div class="otp-container">
                        <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 0)" name="otp1" required>
                        <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 1)" name="otp2" required>
                        <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 2)" name="otp3" required>
                        <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 3)" name="otp4" required>
                        <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 4)" name="otp5" required>
                        <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 5)" name="otp6" required>
                    </div>
                    <button type="submit" name="verify_otp" class="btn  w-100 mt-3" style="font-size: medium;">Verify OTP</button>
                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="text-black" style="text-decoration: none; font-size: medium;">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function moveToNext(current, index) {
            const inputs = document.querySelectorAll('.otp-input');
            if (current.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            } else if (!current.value && index > 0) {
                inputs[index - 1].focus();
            }
        }
    </script>
<?php
include('footer.php');
?>