<?php
session_start();
include('db_connect.php');

if (isset($_POST['remove']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $deleteQuery = "DELETE FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $conn->query($deleteQuery);
}

// Redirect back to wishlist page
header("Location: wish.php");
exit();
?>
