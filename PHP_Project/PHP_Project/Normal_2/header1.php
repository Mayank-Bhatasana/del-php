

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Furniture</title>
<style>
    body { font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; }
    .container { max-width: 600px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); position: relative; }
    .profile-pic { width: 100px; height: 100px; border-radius: 50%; margin-bottom: 20px; }
    .btn { padding: 5px 10px; margin-top: 10px; cursor: pointer; }
    .popup { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; }
    .popup-content { background: #fff; padding: 20px; border-radius: 8px; width: 400px; }
    .close-btn { float: right; cursor: pointer; }
</style>
   
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>

    <!-- remix icon cdn link  -->
    <link rel="stylesheet" href="FA/css/all.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery-3.7.1.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


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
            border: 4px solid green;
        }
    </style>

</head>

<body>

    <!-- header section starts  -->

    <header class="header">
        <a href="home.php" class="logo"><img src="img/logo.png" height="80px"></a>
        <form action="#" class="search-form">
            <input type="search" id="search-box" placeholder="Search here...">
            <label for="search-box" class="fa-solid fa-magnifying-glass"></label>
        </form>

        <div class="icons">
            <div id="search-btn"><i class="fa-solid fa-magnifying-glass"  style=" color: #caab9f;"></i></div>
            <div id="cart-btn"><a href="cart.php"><i class="fa-solid fa-cart-shopping" style=" color: #caab9f;"></i></a></div>
            
            

            <nav class="navbar navbar-expand-lg  sticky-top">
            
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <div class="nav-item dropdown">
                            <a class="btn btn-outline-light dropdown-toggle"  href="#" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false" style="font-size: medium; border-radius: 8%">
                                <i class="fa-solid fa-user" ></i> Profile
                            </a>
                            <?php
                                // Database connection
                                $conn = new mysqli("localhost", "root", "", "urban");

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch user menu items
                                $sql = "SELECT name, link FROM dropd ORDER BY order_no ASC";
                                $result = $conn->query($sql);

                                // Generate dropdown menu dynamically
                                echo '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="border-radius: 10%;">';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<li><a class="dropdown-item" href="' . $row['link'] . '" style="font-size: medium;">' . $row['name'] . '</a></li>';
                                }
                                echo '</ul>';

                                // Close connection
                                $conn->close();
                                ?>
                            </ul>
                        </div>
                    </div>
                
            </nav>
        </div>
            
        </div>
            
    </header>


    <!-- header section ends  -->