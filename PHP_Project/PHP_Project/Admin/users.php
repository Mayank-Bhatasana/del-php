<?php
include 'db_connect.php'; // Make sure this file contains your DB connection ($con)

$success_msg = $error_msg = "";
$editing_user = null;

// Handle form submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;

    $profile_picture = '';
    if (!empty($_FILES['profile_picture']['name'])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $profile_picture = $upload_dir . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

    if ($user_id) {
        // Edit
        if (empty($profile_picture)) {
            $stmt = $con->prepare("UPDATE users SET username=?, email=?, password=?, role=? WHERE id=?");
            $stmt->bind_param("ssssi", $username, $email, $password, $role, $user_id);
        } else {
            $stmt = $con->prepare("UPDATE users SET username=?, email=?, password=?, role=?, profile_picture=? WHERE id=?");
            $stmt->bind_param("sssssi", $username, $email, $password, $role, $profile_picture, $user_id);
        }
        $stmt->execute();
        $success_msg = "User updated successfully.";
    } else {
        // Add
        $stmt = $con->prepare("INSERT INTO users (username, email, password, role, profile_picture) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $password, $role, $profile_picture);
        $stmt->execute();
        $success_msg = "User added successfully.";
    }
    header("Location: users.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: users.php");
    exit;
}

// Get user for editing
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $con->query("SELECT * FROM users WHERE id = $id");
    if ($result->num_rows > 0) {
        $editing_user = $result->fetch_assoc();
    }
}

// Fetch all users
$users = $con->query("SELECT * FROM users");
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


</head>
<body>
<div class="content">
    <h3 class="mb-4">User Management</h3>

    <!-- <?php if (!empty($success_msg)): ?>
        <div class="alert alert-success"><?= $success_msg ?></div>
    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <div class="alert alert-danger"><?= $error_msg ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="border p-4 bg-white mb-4">
        <input type="hidden" name="user_id" value="<?= $editing_user['id'] ?? '' ?>">
        <div class="mb-3">
            <label>User Name</label>
            <input type="text" name="username" class="form-control" required value="<?= $editing_user['username'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Email ID</label>
            <input type="email" name="email" class="form-control" required value="<?= $editing_user['email'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="password" class="form-control" required value="<?= $editing_user['password'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="Admin" <?= (isset($editing_user['role']) && $editing_user['role'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
                <option value="Normal" <?= (isset($editing_user['role']) && $editing_user['role'] == 'Normal') ? 'selected' : '' ?>>Normal</option>
                <option value="Guest" <?= (isset($editing_user['role']) && $editing_user['role'] == 'Guest') ? 'selected' : '' ?>>Guest</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
            <?php if (!empty($editing_user['profile_picture'])): ?>
                <img src="<?= $editing_user['profile_picture'] ?>" width="100" class="mt-2">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-success"><?= isset($editing_user) ? 'Update' : 'Add' ?> User</button>
        <?php if ($editing_user): ?>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </form> -->

    <table class="table table-bordered table-striped">
        <thead class="table table-bordered bg-white">
            <tr>
                <th>ID</th>
                <th>Profile Picture</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <!-- <th>Password</th> -->
                <th>Role</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody class="text-center">
            <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>

                    <td><img src="<?= $row['profile_picture'] ?>" width="80" height="80"></td>

                    <td><?= htmlspecialchars($row['firstname']) ?></td>
                    <td><?= htmlspecialchars($row['lastname']) ?></td>

                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <!-- <td><?= htmlspecialchars($row['password']) ?></td> -->
                    <td><?= $row['role'] ?></td>
                    <!-- <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                    </td> -->
                </tr>
            <?php endwhile; ?>
            <?php if ($users->num_rows == 0): ?>
                <tr><td colspan="6">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
