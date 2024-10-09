<?php
session_start();

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "shubham";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}





// Fetch users
$sql_users = "SELECT * FROM login";
$result_users = $conn->query($sql_users);

// Fetch products
$sql_products = "SELECT * FROM phone";
$result_products = $conn->query($sql_products);

// Fetch orders
$sql_orders = "SELECT * FROM purchases";
$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Admin Dashboard</h1>
    <nav>
      <ul>
        <li><a href="#users">Users</a></li>
        <li><a href="#products">Products</a></li>
        <li><a href="#orders">Orders</a></li>
        <li><a href="admin_logout.phjjjjjjp">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section id="users">
    <h2>User Management</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
      <?php
      if ($result_users->num_rows > 0) {
        while ($row = $result_users->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['name']}</td>
                  <td>{$row['email']}</td>
                  <td><a href='edit_user.php?id={$row['id']}'>Edit</a> | <a href='delete_user.php?id={$row['id']}'>Delete</a></td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No users found.</td></tr>";
      }
      ?>
    </table>
  </section>

  <section id="products">
    <h2>Product Management</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
      <?php
      if ($result_products->num_rows > 0) {
        while ($row = $result_products->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['brand']}</td>
                  <td>{$row['model']}</td>
                  <td>{$row['price']}</td>
                  <td><a href='edit_product.php?id={$row['id']}'>Edit</a> | <a href='delete_product.php?id={$row['id']}'>Delete</a></td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No products found.</td></tr>";
      }
      ?>
    </table>
  </section>

  <section id="orders">
    <h2>Order Management</h2>
    <table>
      <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>Product ID</th>
        <th>Status</th>
      </tr>
      <?php
      if ($result_orders->num_rows > 0) {
        while ($row = $result_orders->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['order_id']}</td>
                  <td>{$row['user_id']}</td>
                  <td>{$row['product_id']}</td>
                  <td>{$row['status']}</td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No orders found.</td></tr>";
      }
      ?>
    </table>
  </section>
</body>
</html>
