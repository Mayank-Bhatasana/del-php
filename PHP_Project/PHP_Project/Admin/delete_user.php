<?php
$conn = new mysqli("localhost", "root", "", "urban");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_POST['id'];
$sql = "DELETE FROM pra WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

echo json_encode(["success" => true]);
$conn->close();
?>
