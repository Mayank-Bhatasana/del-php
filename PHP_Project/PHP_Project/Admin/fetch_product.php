<?php
include 'db_connect.php';
header('Content-Type: application/json');

$query = "SELECT * FROM products";
$result = $conn->query($query);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>
