<?php
session_start();
$conn = new mysqli("localhost", "root", "", "urban");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to log in first!'); window.location.href='../login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];
    $confirm_password = $_POST['confirmPassword'];

    // Get the current password from the database
    $sql = "SELECT password FROM furniture WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_password);
    $stmt->fetch();

    // Check if current password matches
    if (!password_verify($current_password, $db_password)) {
        $msg = "Current password is incorrect!";
    } elseif ($new_password !== $confirm_password) {
        $msg = "New passwords do not match!";
    } else {
        // Hash the new password before updating
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_sql = "UPDATE furniture SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo "<script>alert('Password updated successfully! Please log in again.'); window.location.href='../login.php';</script>";
            exit();
        } else {
            $msg = "Something went wrong! Please try again.";
        }
        $update_stmt->close();
    }
    $stmt->close();
}

$conn->close();
?>