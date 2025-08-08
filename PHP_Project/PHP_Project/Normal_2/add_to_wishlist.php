<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $product_name = $_POST['product_name'];
    $price = floatval($_POST['price']);
    $image = $_POST['image'];
    
    // Check if product already exists in wishlist
    $check_sql = "SELECT * FROM wishlist WHERE product_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Insert into wishlist
        $insert_sql = "INSERT INTO wishlist (product_id, product_name, price, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("isds", $product_id, $product_name, $price, $image);
        $stmt->execute();
        
        $_SESSION['wishlist_message'] = "Product added to wishlist!";
    } else {
        $_SESSION['wishlist_message'] = "Product already in wishlist!";
    }
    
    $stmt->close();
    $conn->close();
}

header("Location: wish.php");
exit;
?>