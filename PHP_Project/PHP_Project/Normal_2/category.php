<?php
include('db_connect.php');

// Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';

// Database connection (optional if db_connect.php already handles it)
$conn = new mysqli("localhost", "root", "", "urban");

// Check connection
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
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a href="' . $row["link"] . '" class="box">
                        <img src="' . $row["image_path"] . '" alt="' . $row["name"] . '">
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

<!-- Filter Form Start -->
<form method="GET" action="">
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
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
                <option value="0-500">Under $500</option>
                <option value="500-1000">$500 - $1000</option>
                <option value="1000-2000">$1000 - $2000</option>
                <option value="2000-999999">Above $2000</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <select class="form-select" name="sort_by" style="font-size: small;">
                <option value="">Sort By</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="popular">Popular</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <button type="submit" class="btn btn-outline-danger w-100" style="font-size: small;">Apply Filters</button>
        </div>
    </div>
</form>
<!-- Filter Form End -->

<?php
$conn->close(); // ✅ Only close once, after all queries are done
include 'footer.php';
?>
