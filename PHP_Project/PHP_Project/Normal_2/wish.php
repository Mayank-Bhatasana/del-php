<?php
// Enable strict error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and include files
session_start();
require_once('db_connect.php'); // Use require_once to ensure the file exists

// Verify database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Process removal action
if (isset($_GET['remove_id']) && is_numeric($_GET['remove_id'])) {
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE product_id = ?");
    $stmt->bind_param("i", $_GET['remove_id']);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Item removed successfully";
    } else {
        $_SESSION['error'] = "Error removing item: " . $conn->error;
    }
    $stmt->close();
    header("Location: wish.php");
    exit;
}

// Fetch wishlist items
$items = [];
$sql = "SELECT * FROM wishlist ORDER BY id DESC";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    $result->free();
}

// Start output
include('header.php');
?>

<div class="container mt-5">
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (!empty($items)): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <img src="img/<?= htmlspecialchars($item['image']) ?>" 
                                 alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                 width="80"
                                 onerror="this.onerror=null;this.src='img/default.png'">
                        </td>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td>₹<?= number_format($item['price'], 2) ?></td>
                        <td>
                            <a href="wish.php?remove_id=<?= $item['product_id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure?')">
                                Remove
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Your wishlist is empty. <a href="shop.php" class="alert-link">Browse products</a> to add items.
        </div>
    <?php endif; ?>
</div>

<?php
include 'footer.php';
?>