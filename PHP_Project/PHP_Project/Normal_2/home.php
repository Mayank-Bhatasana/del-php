<?php
include 'header.php';
?>


    
<?php
$host = "localhost"; // Change if needed
$user = "root"; // Default MySQL user
$pass = ""; // Default MySQL password (leave empty for XAMPP)
$dbname = "urban";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


    

    

    <!-- home section starts  -->
    <?php 
$sql = "SELECT name, image_path FROM slider WHERE id = 1"; // Change ID for different products
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = $row['image_path'];
    $productName = $row['name'];
    $new = "New Arrival";
    $dis = "Discover our latest and greatest products"; 
} else {
    $imagePath = "images/default.jpg"; // Default image
    $productName = "Unknown Product";
    $new = "Unknown Product";
}

$conn->close();
?>

<section class="home">
    <div class="slides-container">
        <div class="slide active">
            <div class="content">
                <span><?php echo $new; ?></span>
                <h3><?php echo $productName; ?></h3>
                <p><?php echo $dis; ?></p>
                <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="image">
                <img src="<?php echo $imagePath; ?>" alt="<?php echo $productName; ?>">
            </div>
        </div>
    </div>
</section>



    <!-- home section ends -->


    <!-- banner section starts  -->
    <?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "urban");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch banner data
$sql = "SELECT * FROM banners";
$result = $conn->query($sql);
?>

<div class="banner-container">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="banner">
            <img src="<?php echo $row['image']; ?>" alt="">
            <div class="content">
                <span><?php echo $row['title']; ?></span>
                <h3><?php echo $row['discount']; ?></h3>
                <a href="<?php echo $row['link']; ?>" class="btn">Shop Now</a>
            </div>
        </div>
    <?php } ?>
</div>

<?php
// Close connection
$conn->close();
?>
    <!-- banner section ends -->






    <?php
include 'footer.php';
?>