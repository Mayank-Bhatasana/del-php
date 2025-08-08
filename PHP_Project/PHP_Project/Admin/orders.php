<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders</title>

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
        <a href="products.php"><i class="fa fa-box" style="padding-left: 50px;"></i> Products</a>
        <a href="orders.php"><i class="fa fa-shopping-cart" style="padding-left: 50px;"></i> Orders</a>
        <a href="users.php"><i class="fa fa-users" style="padding-left: 50px;"></i> Users</a>
        <a href="profile.php"><i class="fa fa-user" style="padding-left: 50px;"></i> Profile</a>
        <a href="../login.php"><i class="fa fa-sign-out-alt" style="padding-left: 50px;"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h5 class="mb-4">Recent Orders</h5>

        <?php
        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $product_name = $_POST['product_name'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $customer = $_POST['customer'];
            $status = trim($_POST['status']);

            $valid_statuses = ['Pending', 'Delivered', 'Cancelled'];
            if (!in_array($status, $valid_statuses)) {
                die("Invalid status value: " . htmlspecialchars($status));
            }

            $target_dir = "uploads/";
            $image_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . time() . "_" . $image_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                die("File is not an image.");
            }

            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowed_types)) {
                die("Only JPG, JPEG, PNG & GIF files are allowed.");
            }

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                die("Error uploading file.");
            }

            $query = "INSERT INTO orders (product_name, product_id, quantity, price, customer, status, image) 
                      VALUES ('$product_name', '$product_id', '$quantity', '$price', '$customer', '$status', '$target_file')";

            if ($con->query($query) === TRUE) {
                echo "<div class='alert alert-success'>Order added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $con->error . "</div>";
            }
        }
        ?>

        <!-- Order Form -->
        <!-- <div class="card mb-4">
            <div class="card-header">Add New Order</div>
            <div class="card-body">
                <form action="orders.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product ID</label>
                        <input type="text" class="form-control" name="product_id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Order</button>
                </form>
            </div>
        </div> -->

        <!-- Orders Table -->
        <div class="card">
            <h5 class="card-header">Recent Orders</h5>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Product ID</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Customer</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM orders";
                            $result = $con->query($query);
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>$i</td>
                                        <td><img src='" . $row['image'] . "' width='45' class='rounded'></td>
                                        <td>" . $row['product_name'] . "</td>
                                        <td>" . $row['product_id'] . "</td>
                                        <td>" . $row['quantity'] . "</td>
                                        <td>$" . $row['price'] . "</td>
                                        <td>" . $row['customer'] . "</td>
                                        <td><span class='badge bg-" . ($row['status'] == 'Pending' ? 'warning' : ($row['status'] == 'Delivered' ? 'success' : 'danger')) . "'>" . $row['status'] . "</span></td>
                                    </tr>";
                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='8'>No orders found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer mt-4">
            <p>Designed by Urban Furniture</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


