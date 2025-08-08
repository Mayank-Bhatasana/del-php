<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // First, fetch the image path to delete the associated file
    $query = "SELECT image FROM orders WHERE id = $order_id";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image'];

        // Delete the image file if it exists
        if (!empty($image_path) && file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete the order from the database
        $delete_query = "DELETE FROM orders WHERE id = $order_id";
        if ($con->query($delete_query) === TRUE) {
            echo "<script>alert('Order deleted successfully!'); window.location.href='orders.php';</script>";
        } else {
            echo "Error deleting order: " . $con->error;
        }
    } else {
        echo "<script>alert('Order not found.'); window.location.href='orders.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='orders.php';</script>";
}
?>
