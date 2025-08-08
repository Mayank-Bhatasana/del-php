<?php
include('db_connect.php');

// Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';

// Database Connection
$conn = new mysqli("localhost", "root", "", "urban");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!-- Category Section Start -->
<?php
$sql = "SELECT name, image_path, link FROM categories";
$result = $conn->query($sql);
?>
<section class="category">
    <h1 class="title"><span>Our Category</span></h1>
    <div class="box-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a href="' . $row["link"] . '" class="box">
                        <img src="' . $row["image_path"] . '" alt="' . $row["name"] . '" class="img-fluid">
                        <h3>' . $row["name"] . '</h3>
                      </a>';
            }
        } else {
            echo "<p>No categories found</p>";
        }
        ?>
    </div>
</section>
<!-- Category Section End -->

<!-- Filter Form -->
<form method="GET" action="">
    <div class="row mb-4">
        <div class="col-md-2 mb-2">
            <select class="form-select" name="category" style="font-size: small;">
                <option value="">Category</option>
                <option value="Sofa">Sofa</option>
                <option value="Chair">Chair</option>
                <option value="Working Table">Working Table</option>
                <option value="Corner Table">Corner Table</option>
                <option value="Wardrobe">Wardrobe</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <select class="form-select" name="price_range" style="font-size: small;">
                <option value="">Price Range</option>
                <option value="0-500">Under ₹500</option>
                <option value="500-1000">₹500 - ₹1000</option>
                <option value="1000-2000">₹1000 - ₹2000</option>
                <option value="2000-999999">Above ₹2000</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <select class="form-select" name="sort_by" style="font-size: small;">
                <option value="">Sort By</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                <option value="newest">Newest First</option>
            </select>
        </div>

        <div class="col-md-4 mb-4 d-flex gap-2">
            <button type="submit" class="btn btn-outline-danger w-100" style="font-size: small;">Apply Filters</button>
            <a href="?" class="btn btn-outline-secondary w-100" style="font-size: small;">Cancel</a>
        </div>
    </div>
</form>

<!-- Product Section -->
<?php
$sql = "SELECT * FROM products WHERE 1";

if (!empty($_GET['category'])) {
    $category = $conn->real_escape_string($_GET['category']);
    $sql .= " AND category = '$category'";
}

if (!empty($_GET['price_range'])) {
    list($min_price, $max_price) = explode("-", $_GET['price_range']);
    $sql .= " AND price BETWEEN $min_price AND $max_price";
}

if (!empty($_GET['sort_by'])) {
    if ($_GET['sort_by'] === "price_asc") {
        $sql .= " ORDER BY price ASC";
    } elseif ($_GET['sort_by'] === "price_desc") {
        $sql .= " ORDER BY price DESC";
    } elseif ($_GET['sort_by'] === "newest") {
        $sql .= " ORDER BY created_at DESC";
    }
}

$result = $conn->query($sql);
?>

<section class="products">
    <div class="box-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="box">
   <div class="icons">
    <form method="POST" action="add_to_cart.php" style="display: inline;">
        <input type="hidden" name="add_to_cart" value="1">
        <input type="hidden" name="product_id" value="' . $row['id'] . '">
        <input type="hidden" name="product_name" value="' . htmlspecialchars($row['name']) . '">
        <input type="hidden" name="price" value="' . $row['price'] . '">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="image" value="' . htmlspecialchars($row['image']) . '">
        <button type="submit" class="fa-solid fa-cart-shopping" style="height: 4rem; width: 4rem; line-height: 4rem; font-size: 1.5rem; color: var(--black); background: rgba(0,0,0,0.05); border: none; border-radius: 50%; cursor: pointer;"></button>
    </form>
    
    <form method="POST" action="add_to_wishlist.php" style="display: inline;">
        <input type="hidden" name="product_id" value="' . $row['id'] . '">
        <input type="hidden" name="product_name" value="' . htmlspecialchars($row['name']) . '">
        <input type="hidden" name="price" value="' . $row['price'] . '">
        <input type="hidden" name="image" value="' . htmlspecialchars($row['image']) . '">
        <button type="submit" class="fa fa-heart" style="height: 4rem; width: 4rem; line-height: 4rem; font-size: 1.5rem; color: var(--black); background: rgba(0,0,0,0.05); border: none; border-radius: 50%; cursor: pointer;"></button>
    </form>
    
    <a href="chair1.php?id=' . $row['id'] . '" class="fas fa-eye" style="height: 4rem; width: 4rem; line-height: 4rem; font-size: 1.5rem; color: var(--black); background: rgba(0,0,0,0.05); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;"></a>
</div>

    <div class="image">
        ' . (file_exists('img/' . $row['image']) 
            ? '<img src="img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" class="img-fluid">'
            : '<img src="./img/default.png" alt="Default product image" class="img-fluid">'
        ) . '
    </div>
    
    <div class="content">
        <div class="price">₹' . $row['price'] . '</div>
        <h3>' . $row['name'] . '</h3>
        <p class="product-description" style="font-size: 13px; color: #444; margin-top: 5px;">' . htmlspecialchars($row['description']) . '</p>
    </div>
</div>';
            }
        } else {
            echo '<p>No products found matching your criteria.</p>';
        }
        ?>
    </div>
</section>

<!-- Wishlist Handling -->
<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    if (!in_array($product_id, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $product_id;
    }

    header("Location: wish.php");
    exit();
}
$conn->close();
include 'footer.php';
?>
