<?php
include('db_connect.php');
ob_start();
session_start();
?>
<?php
include 'header.php';
?>

    

   <!-- blog section start -->
   <?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "urban");

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Blog Data
$sql = "SELECT * FROM blogs ORDER BY date DESC";
$result = $conn->query($sql);
?>

<section class="blog">
    <h1 class="title"><span>Our Blog</span><a href="#">View all >></a></h1>

    <div class="box-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="box">
                <div class="image">
                    <img src="img/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                </div>
                <div class="content">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <a href="<?php echo $row['link']; ?>" class="btn">Read more...</a>
                    <div class="icons">
                        <a href="#"><i class="fas fa-calendar"></i> <?php echo date("jS M, Y", strtotime($row['date'])); ?> </a>
                        <a href="#"><i class="fas fa-user"></i> by <?php echo $row['author']; ?> </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<?php
$conn->close();
?>

    <!-- blog section end -->


 



    <?php
include 'footer.php';
?>