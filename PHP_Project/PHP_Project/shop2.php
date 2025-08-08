<?php
include('db_connect.php');

// Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
?>

<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "urban");

// Check Connection
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
                echo '<a href="'.$row["link"].'" class="box">
                        <img src="'.$row["image_path"].'" alt="'.$row["name"].'">
                        <h3>'.$row["name"].'</h3>
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
<!-- Filter Form -->
<form method="GET" action="" class="mb-4">
    <div class="row">
        <div class="col-md-3 mb-2">
            <select class="form-select" name="category" style="font-size: small;">
                <option value="">Category</option>
                <option value="Sofa" <?= (isset($_GET['category']) && $_GET['category'] == 'Sofa') ? 'selected' : '' ?>>Sofa</option>
                <option value="Chair" <?= (isset($_GET['category']) && $_GET['category'] == 'Chair') ? 'selected' : '' ?>>Chair</option>
                <option value="Working Table" <?= (isset($_GET['category']) && $_GET['category'] == 'Working Table') ? 'selected' : '' ?>>Working Table</option>
                <option value="Corner Table" <?= (isset($_GET['category']) && $_GET['category'] == 'Corner Table') ? 'selected' : '' ?>>Corner Table</option>
                <option value="Wardrobe" <?= (isset($_GET['category']) && $_GET['category'] == 'Wardrobe') ? 'selected' : '' ?>>Wardrobe</option>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select class="form-select" name="price_range" style="font-size: small;">
                <option value="">Price Range</option>
                <option value="0-500" <?= (isset($_GET['price_range']) && $_GET['price_range'] == '0-500') ? 'selected' : '' ?>>Under $500</option>
                <option value="500-1000" <?= (isset($_GET['price_range']) && $_GET['price_range'] == '500-1000') ? 'selected' : '' ?>>$500 - $1000</option>
                <option value="1000-2000" <?= (isset($_GET['price_range']) && $_GET['price_range'] == '1000-2000') ? 'selected' : '' ?>>$1000 - $2000</option>
                <option value="2000-999999" <?= (isset($_GET['price_range']) && $_GET['price_range'] == '2000-999999') ? 'selected' : '' ?>>Above $2000</option>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select class="form-select" name="sort_by" style="font-size: small;">
                <option value="">Sort By</option>
                <option value="price_asc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_asc') ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="price_desc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_desc') ? 'selected' : '' ?>>Price: High to Low</option>
                <option value="newest" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'newest') ? 'selected' : '' ?>>Newest First</option>
                <option value="popular" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'popular') ? 'selected' : '' ?>>Popular</option>
            </select>
        </div>

        <div class="col-md-3 mb-2 d-flex">
            <button type="submit" class="btn btn-outline-danger w-50 me-2" style="font-size: small;">Apply Filters</button>
            <a href="?" class="btn btn-outline-secondary w-50" style="font-size: small;">Cancel</a>
        </div>
    </div>
</form>

<!-- Product Section -->
<?php
// Build SQL Query with Filters
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
    } elseif ($_GET['sort_by'] === "popular") {
        $sql .= " ORDER BY rating DESC";
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
                            <a href="cart.php" class="fa-solid fa-cart-shopping"></a>
                            <a href="?id='.$row['id'].'" class="fa fa-heart"></a>
                            <a href="chair1.php?id='.$row['id'].'" class="fas fa-eye"></a>
                        </div>
                        <div class="image">
                            <img src="img/'.$row['image'].'" alt="'.$row['name'].'">
                        </div>
                        <div class="content">
                            <div class="price">$'.$row['price'].'</div>
                            <h3>'.$row['name'].'</h3>
                            <div class="star">';
                
                for ($i = 0; $i < $row['rating']; $i++) {
                    echo '<i class="fas fa-star"></i>';
                }

                echo '<span> ('.$row['rating'].') </span>
                            </div>
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
?>

<?php
$conn->close();
include 'footer.php';
?>
