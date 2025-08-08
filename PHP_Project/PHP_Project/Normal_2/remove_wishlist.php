<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Secure the ID input

    $conn = new mysqli("localhost", "root", "", "urban");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $delete_sql = "DELETE FROM wishlist WHERE product_id = $id";
    if ($conn->query($delete_sql)) {
        header("Location: wish.php"); // Redirect back to wishlist page
        exit();
    } else {
        echo "Error deleting item: " . $conn->error;
    }

    $conn->close();
}
?>
    