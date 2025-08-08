<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $price = $_POST['price'];

    $query = "UPDATE products SET name='$name', category='$category', status='$status', price='$price' WHERE id='$id'";
    if ($con->query($query) === TRUE) {
        header("Location: Products.php");
    } else {
        echo "Error updating record: " . $con->error;
    }
}
?>
