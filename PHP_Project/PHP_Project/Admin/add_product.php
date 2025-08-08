<?php
include 'db_connect.php'; // Ensure this file establishes a database connection

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'] ?? '';
    $productId = $_POST['productId'] ?? '';
    $productQuantity = $_POST['productQuantity'] ?? '';
    $productPrice = $_POST['productPrice'] ?? '';

    if (empty($productName) || empty($productId) || empty($productQuantity) || empty($productPrice)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    // Insert into database
    $query = "INSERT INTO products (productName, productId, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $productName, $productId, $productQuantity, $productPrice);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database insert failed."]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
