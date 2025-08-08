<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

$success_msg = $error_msg = "";
$link = isset($_POST['link']) ? trim($_POST['link']) : "";

// Add category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    if (!empty($name) && isset($_FILES['Pimage']) && $_FILES['Pimage']['error'] === 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_path = $target_dir . basename($_FILES["Pimage"]["name"]);
        if (move_uploaded_file($_FILES["Pimage"]["tmp_name"], $image_path)) {
            $stmt = $con->prepare("INSERT INTO categories (name, image_path, link) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $image_path, $link);
            if ($stmt->execute()) {
                $success_msg = "Category added successfully.";
            } else {
                $error_msg = "Insert failed: " . $stmt->error;
            }
        } else {
            $error_msg = "Image upload failed.";
        }
    } else {
        $error_msg = "All fields are required.";
    }
}

// Edit category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $link = trim($_POST['link']);

    $query = "UPDATE categories SET name = ?, link = ?";
    $types = "ss";
    $params = [$name, $link];

    if (isset($_FILES['Pimage']) && $_FILES['Pimage']['error'] === 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $image_path = $target_dir . basename($_FILES["Pimage"]["name"]);
        if (move_uploaded_file($_FILES["Pimage"]["tmp_name"], $image_path)) {
            $query .= ", image_path = ?";
            $types .= "s";
            $params[] = $image_path;
        }
    }

    $query .= " WHERE id = ?";
    $types .= "i";
    $params[] = $id;

    $stmt = $con->prepare($query);
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        $success_msg = "Category updated successfully.";
    } else {
        $error_msg = "Update failed: " . $stmt->error;
    }
}

// Delete category
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $con->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success_msg = "Category deleted.";
    } else {
        $error_msg = "Delete failed.";
    }
}
?>

<!DOCTYPE html>
<html>
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
</div>

<!-- Main Content -->
<div class="content">
    <div class="container mt-5">
        <?php if ($success_msg): ?>
            <div class="alert alert-success"><?= $success_msg ?></div>
        <?php elseif ($error_msg): ?>
            <div class="alert alert-danger"><?= $error_msg ?></div>
        <?php endif; ?>

        <!-- Add Category Button -->
<div class="ps-0"> <!-- Adds left padding -->
    <h2>Category List</h2>
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
      Add Category
  </button>

  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="add_category" value="1">
          <div class="modal-body">
            <div class="mb-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Image</label>
              <input type="file" name="Pimage" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


    </div>
        <!-- Category Table -->
        <table class="table table-bordered bg-white">            
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $result = $con->query("SELECT * FROM categories");
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><img src="<?= $row['image_path'] ?>" width="50"></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Add Category Button
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add Category</button>

Modal for Add Category 
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="add_category" value="1">
        <div class="modal-body">
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Image</label>
            <input type="file" name="Pimage" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Link</label>
            <input type="text" name="link" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add Category</button>
        </div>
      </form>
    </div>
  </div>
</div> -->


<!-- Offcanvas for Edit Category -->
<?php if (isset($_GET['edit'])):
    $edit_id = $_GET['edit'];
    $stmt = $con->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
?>
<div class="offcanvas offcanvas-top show" tabindex="-1" style="visibility: visible; height: 70vh; background-color: white; z-index: 1050;">
    <div class="offcanvas-header">
        <h5>Edit Category</h5>
        <a href="category.php" class="btn-close"></a>
    </div>
    <div class="offcanvas-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_category" value="1">
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= $edit_data['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Image (leave blank to keep existing)</label>
                <input type="file" name="Pimage" class="form-control">
                <img src="<?= $edit_data['image_path'] ?>" height="50" class="mt-2">
            </div>
            <div class="mb-3">
                <label>Link</label>
                <input type="text" name="link" class="form-control" value="<?= $edit_data['link'] ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update Category</button>
            <a href="category.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
