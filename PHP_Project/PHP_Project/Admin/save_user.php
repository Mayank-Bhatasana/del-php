<?php
$conn = new mysqli("localhost", "root", "", "urban");

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

$userId = $_POST['id'] ?? null;
$userName = $_POST['userName'] ?? '';
$userEmail = $_POST['userEmail'] ?? '';
$userPassword = $_POST['userPassword'] ?? '';
$profilePicture = $_POST['profilePicture'] ?? 'default-avatar.png';

if (empty($userName) || empty($userEmail) || empty($userPassword)) {
    echo json_encode(["success" => false, "error" => "All fields are required!"]);
    exit;
}

if ($userId) {
    $sql = "UPDATE pra SET userName=?, userEmail=?, userPassword=?, profilePicture=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $userName, $userEmail, $userPassword, $profilePicture, $userId);
} else {
    $sql = "INSERT INTO pra (userName, userEmail, userPassword, profilePicture) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $userName, $userEmail, $userPassword, $profilePicture);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
$conn->close();
?>
