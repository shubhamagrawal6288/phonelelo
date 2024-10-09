<?php
session_start();

if(isset($_SESSION['loggedin']) == true) {
    // User is logged in, so you can access their username
    $username = $_SESSION['name'];
    $mail = $_SESSION['mail'];
} else {
    // User is not logged in
    header("location: login.php");
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

$id = $_GET['phone_id']; 

// Fetch data from database with parameterized query to prevent SQL injection
$sql = "SELECT * FROM phone WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "Phone not found.";
    exit;
}

// Close the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Reselling Website</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .purchase{
            display: flex;
        }
        .leftimg img{
            height: 35em;
            width: 40em;
            margin: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px black;
        }
        .details-container{
            margin: 20px;
        }
        .form-container{
            margin-top: 30px;
        }
        .form-container form{
            display: flex;
            flex-direction: column;
        }
        .form-container label{
            font-size: 2em;
            
        }
        .form-container input{
            height:50px;
            width: 500px;
        }
        .form-container select{
            height:30px;
            width: 500px;
        }
        .form-container button{
            height:50px;
            width: 500px;
            background-color: #82eac7;
            color:white;
            font-size: 2em;
            border-radius: 10px;
            border: 0 solid ;
        }
        .form-container button:hover{
            background-color: #5daa90;
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
                    <li><a href="Buy.php">Buy</a></li>
                    <li><a href="sell.php">SELL</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li>
                        <div class="profile">
                            <button id="profile-btn"><img src="profile.png" height="20px" width="20px"><span><?php echo $username ?></span></button>
                            <div class="profile-dropdown">
                                <a href="my.php">My Profile</a>
                                <a href="logout.php"></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
       
    </header>

    <section class="purchase">
        <div class="leftimg"><img src="<?php echo $row['image']?>" alt="Phone Image" /></div>
        <div class="details-container">
            <h2><?php echo $row['brand'] . " " . $row['model']; ?></h2>
            <p><strong>Variant:</strong> <?php echo $row['phone_variant']; ?></p>
            <p><strong>Months Used:</strong> <?php echo $row['years_used']; ?></p>
            <p><strong>Condition:</strong> <?php echo $row['conditions']; ?></p>
            <p><strong>Price:</strong> 100000/-</p>

            <div class="form-container">
                <form action="process_purchase.php" method="POST">
                    <input type="hidden" name="phone_id" value="<?php echo $id; ?>">
                    <label for="address">Delivery Address:</label><br>
                    <input type="text" id="address" name="address" required>
                    <br>

                    <label for="payment">Payment Mode:</label><br>
                    <select id="payment" name="payment_mode" required>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="net_banking">Net Banking</option>
                        <option value="upi">UPI</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                    <br><br>

                    <button type="submit">Purchase</button>
                </form>
            </div>
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
            cursorClass: 'typed-cursor'
        });
    </script>
</body>
</html>
