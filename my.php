<?php
session_start();

if (isset($_SESSION['loggedin'])) {
  $username = $_SESSION['name'];
  $email = $_SESSION['mail'];
  $mobile = $_SESSION['mobile'];
  $id = $_SESSION['userid'];
}

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "shubham";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch sell history data
$sql = "SELECT * FROM phone WHERE email = '$email'";
$result = $conn->query($sql);

// Fetch buy history data
$sql1 = "SELECT phone.* 
         FROM purchases 
         JOIN phone ON purchases.phone_id = phone.id 
         WHERE purchases.user_id = $id";
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
  </style>
</head>

<body>
  <div class="logo">
    Phone lelo.com
    <br>
    <span id="element"></span>
  </div>
  <header>
    <div class="container">

      <nav>
        <ul>
          <li><a href="profile.php">Home</a></li>
          <li><a href="buy.php">Buy </a></li>
          <li><a href="sell.php">Sell</a></li>
          <li><a href="Contact.php">Contact</a></li>
          <li>
            <div class="profile">
              <button id="profile-btn"><img src="profile.png" height="20px"
                  width="20px"><span><?php echo $username ?></span></button>
              <div class="profile-dropdown">
                <a href="my.php">My Profile </a>
                <a href="logout.php">Logout</a>
              </div>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="main">
    <div class="details">

      <h1> Welcome To <?php echo htmlspecialchars($username); ?> 's profile</h1>

      <h2>Orders</h2>
      <header class="bt">
        <nav>
          <button onclick="scrollToSell()">Sell</button>
          <button onclick="scrollToBuy()">Buy</button>
        </nav>
      </header>
      <div id="sellSection" class="sellhistory">
        <h2> Sell History</h2>
        <section class="buyclass">
          <div class="card-container">
            <?php
            if ($result->num_rows > 0) {
              // Output data of each row
              while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<img src='" . $row["image"] . "' alt='Phone Image'>";
                echo "<div class='flex'><span class='label'>Brand Name:</span><span>" . htmlspecialchars($row["brand"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Model:</span><span>" . htmlspecialchars($row["model"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Variant:</span><span>" . htmlspecialchars($row["phone_variant"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Months Used:</span><span>" . htmlspecialchars($row["years_used"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Condition:</span><span>" . htmlspecialchars($row["conditions"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Price:</span><span>" . htmlspecialchars($row["price"]) . "/-</span></div>";
                echo "</div>";
              }
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
                echo "<div class='flex'><span class='label'>Brand Name:</span><span>" . htmlspecialchars($row["brand"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Model:</span><span>" . htmlspecialchars($row["model"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Variant:</span><span>" . htmlspecialchars($row["phone_variant"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Months Used:</span><span>" . htmlspecialchars($row["years_used"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Condition:</span><span>" . htmlspecialchars($row["conditions"]) . "</span></div>";
                echo "<div class='flex'><span class='label'>Price:</span><span>" . htmlspecialchars($row["price"]) . "/-</span></div>";
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