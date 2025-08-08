<?php
session_start();
$conn = new mysqli("localhost", "root", "", "your_database_name");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "You need to log in first!"]);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];
    $confirm_password = $_POST['confirmPassword'];

    // Fetch the user's current password from the database
    $sql = "SELECT password FROM furniture WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_password);
    $stmt->fetch();

    // Validate current password
    if (!password_verify($current_password, $db_password)) {
        echo json_encode(["status" => "error", "message" => "Current password is incorrect!"]);
    } elseif ($new_password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "New passwords do not match!"]);
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update_sql = "UPDATE furniture SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Password updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update password. Try again."]);
        }
        $update_stmt->close();
    }
    $stmt->close();
}

$conn->close();
?>
