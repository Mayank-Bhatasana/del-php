<?php
$con = new mysqli("localhost", "root", "", "urban");
if ($con->connect_error) die("Connection failed: " . $con->connect_error);

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $con->query("DELETE FROM wishlist WHERE product_id = $product_id");
}

header("Location: wish.php");
?>
