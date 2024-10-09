<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // User is logged in, so you can access their username
    $username = $_SESSION['name'];  // Corrected from $_SESSION['loggedin'] to $_SESSION['name']
    $mail = $_SESSION['mail'];
} else {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit;
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

// Fetch data from database with optional search
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $search = strtolower($conn->real_escape_string($search));  // Sanitize input
    $sql = "SELECT * FROM phone WHERE LOWER(brand) LIKE '%$search%' OR LOWER(model) LIKE '%$search%' OR LOWER(phone_variant) LIKE '%$search%' OR LOWER(conditions) LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM phone";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Reselling Website</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .search {
            height: 3em;
            background-color: white;
            display: flex;
            justify-content: center;
            text-align: center;
            align-items: center;
        }

        .search .search-box {
            border: 0px solid white;
            border-radius: 40px;
            display: flex;
        }

        .search-box input[type="text"] {
            height: 30px;
            width: 500px;
            border-radius: 10px;
            box-shadow: 0 0 5px black;
            padding-left: 10px;
            position: relative;
        }

        .search-box input[type="submit"] {
            width: 100px;
            margin-left: 5px;
            height: 30px;
            border-radius: 10px;
            background: url('search.png') no-repeat center center;
            background-size: contain;
            border: none;
            text-indent: -9999px;
            cursor: pointer;
        }

        .search-box input[type="submit"]:hover {
            border: 1px solid black;
            background-color: gainsboro;
            transition: 1s ease;
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
            filter: drop-shadow(1px 1px 1px black);
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

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            transform: scale(1.05);
        }

        .card h3 {
            text-align: left;
        }

        .card p {
            text-align: left;
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
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="profile.php">Home</a></li>
                    <li><a href="buy.php">Buy</a></li>
                    <li><a href="sell.php">Sell </a></li>
                    <li><a href="Contact.php">Contact</a></li>
                    <li>
                        <div class="profile">
                            <button id="profile-btn"><img src="profile.png" height="20px"
                                    width="20px"><span><?php echo htmlspecialchars($username); ?></span></button>
                            <div class="profile-dropdown">
                                <a href="my.php">My Profile</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>

    </header>

    <div class="search">
        <div class="search-box">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search For Mobiles"
                    value="<?php echo htmlspecialchars($search); ?>">
                <input type="submit" value="search">
            </form>
        </div>
    </div>

    <section class="buyclass">
        <div class="card-container">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    if($row['status'] == 1){
                    echo "<div class='card'>";
                    echo "<img src='" . $row["image"] . "' alt='Phone Image'>"; // Corrected image path
                    echo "<div class='flex'><span class='label'>Brand Name:</span><span>" . htmlspecialchars($row["brand"]) . "</span></div>";
                    echo "<div class='flex'><span class='label'>Model:</span><span>" . htmlspecialchars($row["model"]) . "</span></div>";
                    echo "<div class='flex'><span class='label'>Variant:</span><span>" . htmlspecialchars($row["phone_variant"]) . "</span></div>";
                    echo "<div class='flex'><span class='label'>Months Used:</span><span>" . htmlspecialchars($row["years_used"]) . "</span></div>";
                    echo "<div class='flex'><span class='label'>Condition:</span><span>" . htmlspecialchars($row["conditions"]) . "</span></div>";
                    echo "<div class='flex'><span class='label'>Price:</span><span>" . htmlspecialchars($row["price"]) . "/-</span></div>"; // Added price
                    echo "<br><div class='bu'><a href='purchase.php?phone_id=" . htmlspecialchars($row["id"]) . "'><button>Buy Now</button></a></div>";
                    echo "</div>";
                }}
            } else {
                echo "No results found.";
            }
            $conn->close();
            ?>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 Phone Reselling Website. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        var typed = new Typed('#element', {
            strings: ['<i>Sell A Phone </i>', 'Buy A Phone '],
            typeSpeed: 80,
            cursorClass: 'typed-cursor',
            loop: true
        });
    </script>
</body>

</html>