<?php
include 'db_connection.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $customer = $_POST['customer'];
    $status = $_POST['status'];
    $image = $_POST['image']; // Image path

    // Insert query
    $query = "INSERT INTO orders (product_name, product_id, quantity, price, customer, status, image) 
              VALUES ('$product_name', '$product_id', '$quantity', '$price', '$customer', '$status', '$image')";

    if ($conn->query($query) === TRUE) {
        echo "Order added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
