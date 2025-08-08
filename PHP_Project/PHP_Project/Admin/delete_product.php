<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM products WHERE id='$id'";
    if ($con->query($query) === TRUE) {
        header("Location: Productss.php");
    } else {
        echo "Error deleting record: " . $con->error;
    }
}
?>
