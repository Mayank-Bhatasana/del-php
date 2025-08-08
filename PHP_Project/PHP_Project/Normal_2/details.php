<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);

    // Fetch details from the database
    $query = "SELECT * FROM dropd WHERE id = '$id'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<h2>" . $row['name'] . "</h2>";
    } else {
        echo "No record found!";
    }
} else {
    echo "Invalid request!";
}
?>
