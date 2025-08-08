<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "urban");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data (replace with session-based user ID)
$user_id = 1;
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-card {
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid red;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card profile-card">
            <div class="text-center">
                <img src="uploads/<?php echo $row['profile_picture']; ?>" alt="Profile Picture" class="profile-image">
                <h2 class="mt-3"><?php echo $row['firstname'] . " " . $row['lastname']; ?></h2>
                <p class="text-muted"><?php echo $row['email']; ?></p>
            </div>

            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $row['firstname']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row['lastname']; ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-danger me-2" onclick="window.history.back();">Cancel</button>
                    <button type="submit" class="btn btn-outline-danger">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
