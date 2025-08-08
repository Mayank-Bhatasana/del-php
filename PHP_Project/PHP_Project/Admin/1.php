<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Table Vertical</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 30px 0;
      font-family: Arial, sans-serif;
    }

    td, th {
      border: 1px solid #555;
      padding: 10px;
      text-align: left;
    }

    img {
      max-width: 100px;
      height: auto;
    }

    button {
      padding: 6px 10px;
      margin-right: 5px;
    }
  </style>
</head>
<body>

  <h2>Product Table (Vertical Format)</h2>

  <table>
    <tr>
      <th>Product Image</th>
      <td><img src="https://via.placeholder.com/100" alt="Product"></td>
    </tr>
    <tr>
      <th>Product ID</th>
      <td>P001</td>
    </tr>
    <tr>
      <th>Product Name</th>
      <td>Example Product</td>
    </tr>
    <tr>
      <th>Quantity</th>
      <td>5</td>
    </tr>
    <tr>
      <th>Price</th>
      <td>₹999</td>
    </tr>
    <tr>
      <th>Actions</th>
      <td>
        <button>Edit</button>
        <button>Delete</button>
      </td>
    </tr>
  </table>

</body>
</html>