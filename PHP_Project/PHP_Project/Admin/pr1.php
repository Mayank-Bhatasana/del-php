<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border: 1px solid black;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        label {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <button id="openModal">Add Product</button>

    <div class="modal-overlay"></div>

    <div class="modal" id="productModal">
        <h2>Product Form</h2>
        <form id="productForm">
            <label>Product Name: <input type="text" id="productName" name="productName" required></label>
            <label>Quantity: <input type="number" id="productQuantity" name="productQuantity" required></label>
            <label>Price: <input type="number" id="productPrice" name="productPrice" required></label>
            <button type="submit">Add Product</button>
            <button type="button" id="closeModal">Close</button>
        </form>
    </div>
    
    <h2>Product Table</h2>
    <table id="productTable">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    
    <script>
        $(document).ready(function () {
            $("#openModal").click(function () {
                $(".modal-overlay, #productModal").show();
            });

            $("#closeModal").click(function () {
                $(".modal-overlay, #productModal").hide();
            });

            $("#productForm").validate({
                submitHandler: function (form) {
                    let name = $("#productName").val();
                    let quantity = $("#productQuantity").val();
                    let price = $("#productPrice").val();

                    let row = `<tr>
                        <td class='name'>${name}</td>
                        <td class='quantity'>${quantity}</td>
                        <td class='price'>${price}</td>
                        <td>
                            <button class='edit'>Edit</button>
                            <button class='delete'>Delete</button>
                        </td>
                    </tr>`;

                    $("#productTable tbody").append(row);
                    form.reset();
                    $(".modal-overlay, #productModal").hide();
                }
            });

            $(document).on("click", ".delete", function () {
                $(this).closest("tr").remove();
            });

            $(document).on("click", ".edit", function () {
                let row = $(this).closest("tr");
                let name = row.find(".name").text();
                let quantity = row.find(".quantity").text();
                let price = row.find(".price").text();

                $("#productName").val(name);
                $("#productQuantity").val(quantity);
                $("#productPrice").val(price);

                row.remove();
                $(".modal-overlay, #productModal").show();
            });
        });
    </script>
</body>
</html>
