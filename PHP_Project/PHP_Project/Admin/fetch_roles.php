<?php
include 'db_connect.php'; // Include database connection

$query = "SELECT id, name FROM role"; // Change 'roles' to your actual table name
$result = mysqli_query($conn, $query);

$roles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $roles[] = $row;
}

echo json_encode($roles);
?>
