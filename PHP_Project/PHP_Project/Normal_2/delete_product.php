<?php
include 'db_connection.php'; // Ensure this connects to your database

header('Content-Type: application/json'); // Set response type to JSON

if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Prepare delete query
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "SQL Prepare failed"]);
        exit;
    }

    $stmt->bind_param("i", $productId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No ID provided"]);
}
?>
