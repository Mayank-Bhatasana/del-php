<?php
include('db_connect.php');
session_start();
include 'header.php';

// Display messages if any
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

$conn = new mysqli("localhost", "root", "", "urban");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle quantity change
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['increase'])) {
        $product_id = $_POST['product_id'];
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->close();
        header("Location: cart.php");
        exit;
    } elseif (isset($_POST['decrease'])) {
        $product_id = $_POST['product_id'];
        // First get current quantity
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $current_quantity = $row['quantity'];
        $stmt->close();
        
        if ($current_quantity > 1) {
            $stmt = $conn->prepare("UPDATE cart SET quantity = quantity - 1 WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stmt->close();
        } else {
            $_SESSION['error'] = "Quantity cannot be less than 1. Use delete to remove item.";
        }
        header("Location: cart.php");
        exit;
    } elseif (isset($_POST['delete'])) {
        $product_id = $_POST['product_id'];
        $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message'] = "Item removed from cart successfully!";
        header("Location: cart.php");
        exit;
    }
}

// Fetch products to display in cart
$result = $conn->query("SELECT * FROM cart");
?>

<div class="container mt-5 mb-5">
    <table class="table table-bordered text-center fs-6">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $grand_total = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()):
                    $total_price = $row['price'] * $row['quantity'];
                    $grand_total += $total_price;
            ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><img src="img/<?= htmlspecialchars($row['image']) ?>" alt="product" width="70"></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td>₹<?= number_format($row['price'], 2) ?></td>
                    <td>
                        <form method="POST" action="cart.php" class="d-flex justify-content-center">
                            <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                            <button type="submit" name="decrease" class="btn btn-sm btn-outline-secondary">-</button>
                            <span class="mx-2 align-self-center"><?= $row['quantity'] ?></span>
                            <button type="submit" name="increase" class="btn btn-sm btn-outline-secondary">+</button>
                        </form>
                    </td>
                    <td>₹<?= number_format($total_price, 2) ?></td>
                    <td>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this item?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php 
                endwhile; 
            ?>
                <tr class="table-secondary fw-bold">
                    <td colspan="4" class="text-end">Grand Total:</td>
                    <td colspan="3">₹<?= number_format($grand_total, 2) ?></td>
                </tr>
            <?php } else { ?>
                <tr><td colspan="7" class="text-center">Your cart is empty. <a href="shop.php">Continue shopping</a></td></tr>
            <?php } ?>
        </tbody>
    </table>
    
    <?php if ($result->num_rows > 0): ?>
    <div class="text-end">
        <a href="shop.php" class="btn btn-outline-secondary me-2">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
    </div>
    <?php endif; ?>
</div>

<?php
$conn->close();
include 'footer.php';
?>