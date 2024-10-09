<?php

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "shubham";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
  // Retrieve the id of the phone to be deleted
  $phone_id = $_POST['id'];

  // Construct SQL query to update the status column
  $sql = "UPDATE phone SET status = 0 WHERE id = ?";

  // Prepare the statement
  $stmt = $conn->prepare($sql);

  // Bind parameters
  $stmt->bind_param("i", $phone_id);

  // Execute the statement
  if ($stmt->execute()) {
    echo "<script>alert('Phone record deleted successfully!');</script>";
  } else {
    echo "Error deleting record: " . $conn->error;
  }

  // Close the statement
  $stmt->close();
}

// Fetch sell history data
$sql = "SELECT * FROM phone";
$result = $conn->query($sql);

// Fetch buy history data
$sql1 = "SELECT phone.*, purchases.purchase_date, login.name AS buyer_name
FROM purchases 
JOIN phone ON purchases.phone_id = phone.id
JOIN login ON purchases.user_id = login.userid";
$result1 = $conn->query($sql1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Dashboard styles */
    .main {}

    header {
      position: sticky;
      top: 0;
    }

    .details h1 {
      margin: 20px;
    }

    .details h2 {
      margin-left: 50px;
      font-size: 2em;
    }

    .bt {
      display: flex;
      background-color: white;
    }

    .bt button {
      font-size: 1em;
      margin-left: 3em;
      margin-top: 2em;
      padding: 7px;
      padding-right: 2em;
      padding-left: 2em;
      border-radius: 50px;
      border: 0px solid;
      background-color: #11eedf;
      color: white;
      font-weight: bolder;
    }

    .bt button:hover {
      cursor: pointer;
      background-color: #088f85;
      transition: 0.3s ease;
    }

    .buyclass {
      height: auto;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin: 20px;
    }

    .card {
      background-color: white;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      width: 300px;
      margin: 10px;
      border-radius: 5px;
      padding: 30px;
    }

    .card img {
      width: 100%;
      border-radius: 5px;
    }

    .card h3,
    .card p {
      margin: 5px 0;
    }

    .card .flex {
      display: flex;
      justify-content: space-between;
    }

    .card .label {
      font-weight: bold;
    }

    .card h3 {
      text-align: left;
    }

    .card p {
      text-align: left;
    }

    .h2 h1 {
      margin-left: 2em;
    }

    .sellhistory h2 {
      margin-left: 2em;
    }

    .buyhistory h2 {
      margin-left: 2em;
    }

    .foot {
      height: 2.3em;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .foot h1 {
      margin-left: 38em;
      align-items: center;
    }

    .foot a {
      text-decoration: none;
      color: white;
    }

    .foot a:hover {
      color: aquamarine;
    }

    .bu {
      text-align: right;
    }

    .bu button {
      padding: 5px;
      padding-left: 10px;
      padding-right: 10px;
      background-color: grey;
      color: white;
      border-radius: 10px;
    }

    .bu button:hover {
      background-color: greenyellow;
      transition: 0.5s ease;
    }
  </style>
</head>

<body>
  <div class="logo">
    Phone lelo.com
    <br>
    <span id="element"></span>
  </div>
  <div class="h2">
    <h1>Dashboard</h1>
  </div>

  <header class="bt">
    <nav>
      <button onclick="scrollToSell()">Sell History</button>
      <button onclick="scrollToBuy()">Buy History</button>
    </nav>
  </header>
  <div id="sellSection" class="sellhistory">
    <h2>Sell History</h2>
    <section class="buyclass">
      <div class="card-container">
        <?php
        if ($result->num_rows > 0) {
          // Output data of each row
          while ($row = $result->fetch_assoc()) {
            if($row['status']==1){
            
            echo "<div class='card'>";
            echo "<img src='" . $row["image"] . "' alt='Phone Image'>";
            echo "<div class='flex'><span class='label'>Seller Name:</span><span>" . htmlspecialchars($row["username"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Brand Name:</span><span>" . htmlspecialchars($row["brand"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Model:</span><span>" . htmlspecialchars($row["model"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Variant:</span><span>" . htmlspecialchars($row["phone_variant"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Months Used:</span><span>" . htmlspecialchars($row["years_used"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Condition:</span><span>" . htmlspecialchars($row["conditions"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Price:</span><span>" . htmlspecialchars($row["price"]) . "/-</span></div><br>";
            echo "<form class='bu' method='POST' action='adminpage.php' onsubmit='return confirm(\"Are you sure you want to delete this record?\");'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<button type='submit' >Delete</button>";
            echo "</form>";
            echo "</div>";
          }}
        } else {
          echo "No results found.";
        }
        ?>
      </div>
    </section>

  </div>
  <div id="buySection" class="buyhistory">
    <h2> Buy History</h2>
    <section class="buyclass">
      <div class="card-container">
        <?php
        if ($result1->num_rows > 0) {
          // Output data of each row
          while ($row = $result1->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<img src='" . $row["image"] . "' alt='Phone Image'>";
            echo "<div class='flex'><span class='label'>Seller Name:</span><span>" . htmlspecialchars($row["username"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Buyer Name:</span><span>" . htmlspecialchars($row["buyer_name"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Brand Name:</span><span>" . htmlspecialchars($row["brand"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Model:</span><span>" . htmlspecialchars($row["model"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Variant:</span><span>" . htmlspecialchars($row["phone_variant"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Months Used:</span><span>" . htmlspecialchars($row["years_used"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Condition:</span><span>" . htmlspecialchars($row["conditions"]) . "</span></div>";
            echo "<div class='flex'><span class='label'>Price:</span><span>" . htmlspecialchars($row["price"]) . "/-</span></div>";
            echo "<div class='flex'><span class='label'>Purchase Date</span><span>" . htmlspecialchars($row["purchase_date"]) . "/-</span></div>";
            echo "</div>";
          }
        } else {
          echo "No results found.";
        }
        ?>
      </div>
    </section>
  </div>
  </div>
  </section>
  <footer class="foot">
    <a href="index.html">
      <h1> Home</h1>
    </a>
  </footer>
  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script>
    var typed = new Typed('#element', {
      strings: ['<i>Sell A Phone </i>', 'Buy A Phone '],
      typeSpeed: 80,
      cursorClass: 'typed-cursor',
      loop: true
    });
    // Function to scroll to the sell section
    function scrollToSell() {
      var sellSection = document.getElementById("sellSection");
      sellSection.scrollIntoView({ behavior: 'smooth' });
    }

    // Function to scroll to the buy section
    function scrollToBuy() {
      var buySection = document.getElementById("buySection");
      buySection.scrollIntoView({ behavior: 'smooth' });
    }
  </script>
</body>

</html>