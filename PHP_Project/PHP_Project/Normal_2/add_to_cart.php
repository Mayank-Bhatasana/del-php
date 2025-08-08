<?php
session_start();
ob_start(); // Start output buffering to allow redirection even after output

include('db_connect.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_to_cart'])) {
    // Sanitize and retrieve data
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';
    $rating = 0; // Default rating value for new cart item

    // Validate required fields
    if ($product_id > 0 && !empty($product_name) && $price > 0 && $quantity > 0) {
        // Check if product is already in the cart
        $stmt_check = $conn->prepare("SELECT id, quantity FROM cart WHERE product_id = ?");
        $stmt_check->bind_param("i", $product_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            // Product exists in cart, update quantity
            $row = $result->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;

            $stmt_update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $stmt_update->bind_param("ii", $new_quantity, $row['id']);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            // Insert new product into cart, now with rating
            $stmt_insert = $conn->prepare("INSERT INTO cart (product_id, product_name, price, quantity, image, rating) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("isdssi", $product_id, $product_name, $price, $quantity, $image, $rating);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        $stmt_check->close();
        
        // Set success message in session
        $_SESSION['message'] = "Product added to cart successfully!";
    } else {
        // Set error message in session
        $_SESSION['error'] = "Invalid product data!";
    }

    // Redirect to cart page after adding
    header("Location: cart.php");
    exit();
} else {
    // Redirect if accessed without proper POST
    header("Location: index.php");
    exit();
}
?>