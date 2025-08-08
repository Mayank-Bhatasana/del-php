<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $id = $_POST['id'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $target_dir = "uploads/";
    $image_name = basename($_FILES["Pimage"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["Pimage"]["tmp_name"]);
    if ($check === false) die("File is not an image.");
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) die("Invalid file format.");
    if (!move_uploaded_file($_FILES["Pimage"]["tmp_name"], $target_file)) die("File upload error.");

    $query = "INSERT INTO products (id, name, price, category, image) 
              VALUES ('$id', '$name', '$price', '$category', '$target_file')";
    if ($con->query($query) === TRUE) {
        header("Location: Products.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $con->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    $delete_id = $_POST['delete_id'];
    $con->query("DELETE FROM products WHERE id='$delete_id'");
    header("Location: Products.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];

    $query = "UPDATE products SET name='$name', category='$category', rating='$rating', price='$price' WHERE id='$id'";
    $con->query($query);
    header("Location: Products.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">

    <style>
        body {
            background-color: #faf7f6;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: rgb(249, 222, 211);
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #5e473e;
            display: block;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .footer {
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>

</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
        <a href="index.php" class="d-block text-center"><img src="img/logo.png" height="100px"></a>
        <a href="category.php" class="d-block" style="padding-left: 67px;"><i class="fa fa-box"></i> Category</a>
        <a href="Products.php"><i class="fa fa-box" style="padding-left: 50px;"></i> Products</a>
        <a href="orders.php"><i class="fa fa-shopping-cart" style="padding-left: 50px;"></i> Orders</a>
        <a href="users.php"><i class="fa fa-users" style="padding-left: 50px;"></i> Users</a>
        <a href="profile.php"><i class="fa fa-user" style="padding-left: 50px;"></i> Profile</a>
        <a href="../login.php"><i class="fa fa-sign-out-alt" style="padding-left: 50px;"></i> Logout</a>
    </div>


<!-- Main Content -->
<div class="content">
    <h2>Product List</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addOrderModal">Add Product</button>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header"><h5>Add Product</h5></div>
                <div class="modal-body">
                    <input type="hidden" name="add_product" value="1">
                    <div class="mb-3"><label>Product ID</label><input type="text" name="id" class="form-control" required></div>
                    <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label>Category</label><input type="text" name="category" class="form-control" required></div>
                    <div class="mb-3"><label>Price</label><input type="number" name="price" class="form-control" required></div>
                    <div class="mb-3"><label>Image</label><input type="file" name="Pimage" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success">Add</button></div>
            </form>
        </div>
    </div>

    <!-- Product Table -->
    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr><th>#</th><th>Image</th><th>Name</th><th>Category</th><th>Rating</th><th>Price</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php
$result = $con->query("SELECT * FROM Products");
$modals = ""; // store modals to render later
if ($result->num_rows > 0) {
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>$i</td>
            <td><img src='{$row['image']}' width='60'></td>
            <td>{$row['name']}</td>
            <td>{$row['category']}</td>
            <td>{$row['rating']}</td>
            <td>₹{$row['price']}</td>
            <td>
                <form method='POST' style='display:inline-block'>
                    <input type='hidden' name='delete_id' value='{$row['id']}'>
                    <button type='submit' name='delete_product' class='btn btn-danger btn-sm'>Delete</button>
                </form>
                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row['id']}'>Edit</button>
            </td>
        </tr>";

        // Store the modal HTML outside of <table>
        $modals .= "
        <div class='modal fade' id='editModal{$row['id']}' tabindex='-1'>
            <div class='modal-dialog'>
                <form method='POST' class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>Edit Product</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                    </div>
                    <div class='modal-body'>
                        <input type='hidden' name='update_product' value='1'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <div class='mb-3'>
                            <label>Name</label>
                            <input type='text' name='name' class='form-control' value='{$row['name']}' required>
                        </div>
                        <div class='mb-3'>
                            <label>Category</label>
                            <input type='text' name='category' class='form-control' value='{$row['category']}' required>
                        </div>
                        <div class='mb-3'>
                            <label>Rating</label>
                            <input type='text' name='rating' class='form-control' value='{$row['rating']}'>
                        </div>
                        <div class='mb-3'>
                            <label>Price</label>
                            <input type='number' name='price' class='form-control' value='{$row['price']}' required>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-success'>Update</button>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        ";
        $i++;
    }
} else {
    echo "<tr><td colspan='7'>No products found</td></tr>";
}
?>

        </tbody>
    </table>
    </table>
<!-- Now echo the modals below the table -->
<?= $modals ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
