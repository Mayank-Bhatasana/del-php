<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #faf7f6;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(249, 222, 211);
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
        .user-table thead {
            background-color: black;
            color: white;
        }
        .user-table th, .user-table td {
            text-align: center;
            vertical-align: middle;
        }
        .user-table tbody tr:hover {
            background-color: #f1f1f1;
        }
        tr {
            background-color: #faf7f6;
            color: black;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="index.php" style="padding-left: 50px;"><img src="img/logo.png" height="100px"></a>
    <a href="index.php" style="padding-left: 50px;"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
    <a href="Products.php" style="padding-left: 50px;"><i class="fa fa-box"></i> Products</a>
    <a href="orders.php" style="padding-left: 50px;"><i class="fa fa-shopping-cart"></i> Orders</a>
    <a href="users.php" style="padding-left: 50px;"><i class="fa fa-users"></i> Users</a>
    <a href="profile.php" style="padding-left: 50px;"><i class="fa fa-user"></i> Profile</a>
    <a href="../login.php" style="padding-left: 50px;"><i class="fa fa-sign-out-alt"></i> Logout</a>
</div>

<div class="container mt-5" style="margin-left: 250px;">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productDialog">
                Add New Product
            </button>

            <table class="table table-bordered table-striped user-table" id="productsTable">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <!-- Dynamic rows here -->
                </tbody>
            </table>
            <div id="noProducts" class="alert alert-info">No products added yet.</div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="productDialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="newProductName" name="productName">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="newProductQuantity" name="productQuantity">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" id="newProductPrice" name="productPrice" step="0.01">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addProductForm" class="btn btn-primary">Save Product</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal (if needed later) -->
<!-- You can keep this modal if you plan to implement editing -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    function fetchProducts() {
        $.ajax({
            url: 'fetch_products.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#productTableBody').empty();
                if (response.length > 0) {
                    response.forEach(function (product) {
                        let newRow = `
                            <tr>
                                <td>${product.productName}</td>
                                <td>${product.quantity}</td>
                                <td>$${parseFloat(product.price).toFixed(2)}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id}">Delete</button>
                                    <button class="btn btn-success btn-sm edit-btn" data-id="${product.id}">Edit</button>
                                </td>
                            </tr>`;
                        $('#productTableBody').append(newRow);
                    });
                    $('#productsTable').show();
                    $('#noProducts').hide();
                } else {
                    $('#productsTable').hide();
                    $('#noProducts').show();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching products:", error);
            }
        });
    }

    fetchProducts(); // Load on page load

    $('#addProductForm').validate({
        rules: {
            productName: { required: true },
            productQuantity: { required: true, number: true, min: 1 },
            productPrice: { required: true, number: true, min: 0.01 }
        },
        messages: {
            productName: "Please enter a product name",
            productQuantity: "Enter a valid quantity (min: 1)",
            productPrice: "Enter a valid price (min: 0.01)"
        },
        submitHandler: function (form) {
            const formData = {
                productName: $('#newProductName').val(),
                productQuantity: $('#newProductQuantity').val(),
                productPrice: $('#newProductPrice').val()
            };
            $.ajax({
                url: 'add_product.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Product added successfully!');
                        $('#productDialog').modal('hide');
                        $('#addProductForm')[0].reset();
                        fetchProducts();
                    } else {
                        alert('Failed to add product: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error adding product:", xhr.responseText);
                }
            });
            return false;
        }
    });

    $('.btn-close, .btn-secondary').click(function () {
        $('#addProductForm')[0].reset();
    });
});
</script>

</body>
</html>
