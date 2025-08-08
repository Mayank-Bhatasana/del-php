<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "urban");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Get user ID (Replace with session ID if using authentication)
$user_id = 1;

// Get form data
$firstName = $conn->real_escape_string($_POST['firstName']);
$lastName = $conn->real_escape_string($_POST['lastName']);
$email = $conn->real_escape_string($_POST['email']);

// Handle Profile Picture Upload
if (!empty($_FILES['profile_picture']['name'])) {
    $target_dir = "uploads/";
    $file_name = basename($_FILES["profile_picture"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);

    // Update profile picture in DB
    $conn->query("UPDATE admin SET profile_picture='$target_file' WHERE id=$user_id");
}

// Update user details
$sql = "UPDATE admin SET firstname='$firstName', lastname='$lastName', email='$email' WHERE id=$user_id";

if ($conn->query($sql) === TRUE) {
    header("Location: profile.php?success=1"); // Redirect with success message
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
