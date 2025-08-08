<?php
include 'db_connection.php'; // Ensure this file correctly connects to the database

header('Content-Type: application/json'); // Ensure correct response type

if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Debug: Log received product ID
    error_log("Fetching product ID: " . $productId);

    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "SQL Prepare failed"]));
    }

    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["status" => "success", "data" => $row]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No ID provided"]);
}
?>
    