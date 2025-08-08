<?php
include 'db_connect.php';

if (isset($_POST['editProductId'])) {
    $productId = $_POST['editProductId'];
    $productName = $_POST['editProductName'];
    $price = $_POST['editPrice'];
    $quantity = $_POST['editQuantity'];
    $discount = $_POST['editDiscount'];

    $query = "UPDATE cart SET product_name=?, price=?, quantity=?, discount=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdiid", $productName, $price, $quantity, $discount, $productId);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "data" => [
            "id" => $productId,
            "product_name" => $productName,
            "price" => $price,
            "quantity" => $quantity,
            "discount" => $discount
        ]]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}
?>
