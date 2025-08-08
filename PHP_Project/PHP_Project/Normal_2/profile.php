<?php
include('db_connect.php');
session_start();
include('header.php');

$email = $_SESSION['user'];

// Fetch current user details
$q = "SELECT * FROM furniture WHERE email='$email'";
$result = $con->query($q);
$row = mysqli_fetch_assoc($result);
$profilePicture = !empty($row['profile_pic']) ? "img/profile_pictures/" . $row['profile_pic'] : "img/team-6.jpg";

if (isset($_POST['save'])) {
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);

    // Ensure the target directory exists
    $targetDir = "img/profile_pictures/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Check if a new profile picture is uploaded
    if (!empty($_FILES['profile_pic']['name'])) {
        $fileName = basename($_FILES['profile_pic']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

        if (in_array($fileType, $allowTypes)) {
            if (is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFilePath)) {
                    $updateQuery = "UPDATE furniture SET firstname='$firstName', lastname='$lastName', profile_pic='$fileName' WHERE email='$email'";
                } else {
                    echo "<script>alert('File upload failed. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Possible file upload attack.');</script>";
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
        }
    } else {
        $updateQuery = "UPDATE furniture SET firstname='$firstName', lastname='$lastName' WHERE email='$email'";
    }

    if (isset($updateQuery) && $con->query($updateQuery) === TRUE) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }
}
?>

<script>
    $(document).ready(function() {
        $('#profileForm').validate({
            rules: {
                firstName: { required: true, minlength: 2 },
                lastName: { required: true, minlength: 2 }
            },
            messages: {
                firstName: { required: "Please enter your first name", minlength: "First name must be at least 2 characters" },
                lastName: { required: "Please enter your last name", minlength: "Last name must be at least 2 characters" }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });
    });
</script>

<div class="container py-5" data-aos="flip-left" data-aos-duration="2000">
    <div class="card profile-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h1 class="mb-1"><?php echo $row['firstname'] . " " . $row['lastname']; ?></h1>
                <h2><p class="text-muted"><?php echo $row['email']; ?></p></h2>
            </div>

            <form id="profileForm" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label" style="font-size: medium;">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" style="font-size: medium;" value="<?php echo $row['firstname']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label" style="font-size: medium;">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" style="font-size: medium;" value="<?php echo $row['lastname']; ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label" style="font-size: medium;">Email address</label>
                    <input type="email" class="form-control" id="email" style="font-size: medium;" value="<?php echo $row['email']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="profilePicture" class="form-label" style="font-size: medium;">Update Profile Picture</label>
                    <input type="file" class="form-control" id="profilePicture" name="profile_pic" style="font-size: medium;">
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-outline-danger me-md-2" onclick="window.history.back();">Cancel</button>
                    <button type="submit" class="btn btn-outline-danger" name="save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
