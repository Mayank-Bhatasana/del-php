<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $order_time = $_POST['order_time'];
    $customer = $_POST['customer'];
    $status = $_POST['status'];

    $query = "UPDATE orders SET 
              product_name='$product_name', product_id='$product_id', quantity='$quantity', price='$price', 
              order_time='$order_time', customer='$customer', status='$status' 
              WHERE id='$id'";

    if ($con->query($query) === TRUE) {
        echo "<script>alert('Order updated successfully!'); window.location.href='orders.php';</script>";
    } else {
        echo "Error updating order: " . $con->error;
    }
}
?>
