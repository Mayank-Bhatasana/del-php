<?php
include('db_connect.php');
ob_start();
session_start();
?>
<?php
include 'header.php';
?>



    <!-- about section start -->

<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "urban");

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch About Section Data
$sql = "SELECT * FROM about LIMIT 1";
$result = $conn->query($sql);
$about = $result->fetch_assoc();
?>

<section class="about">
    <div class="image">
        <img src="img/<?php echo $about['image']; ?>" alt="">
    </div>

    <div class="content">
        <span><?php echo $about['title']; ?></span>
        <h3><?php echo $about['subtitle']; ?></h3>
        <p><?php echo $about['content']; ?></p>
        <p><?php echo $about['additional_content']; ?></p>
        <a href="#" class="btn">Read more...</a>
    </div>
</section>

<?php
$conn->close();
?>



    <!-- about section end -->




    <!-- services section start -->
    <?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "urban");

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Services Data
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>

<section class="services">
    <h1 class="title"><span>Our Services</span><a href="#">View all >></a></h1>

    <div class="box-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="box">
                <img src="img/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <a href="<?php echo $row['link']; ?>" class="btn">Read more...</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php
$conn->close();
?>

    <!-- services section end -->






    <?php
include 'footer.php';
?>