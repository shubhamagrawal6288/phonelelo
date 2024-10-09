<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Retrieve session data
$username = $_SESSION['name'];
$mail = $_SESSION['mail'];
$mobile = $_SESSION['mobile'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $phoneVariant = $_POST['phoneVariant'];
    $yearsUsed = $_POST['use'];
    $conditions = $_POST['condition'];
    $price = $_POST['price'];
    $image = $_FILES['imageUpload']['name']; // Get the filename of the uploaded image

    // Database connection details
    $server = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "shubham";

    // Create connection
    $conn = new mysqli($server, $dbUsername, $dbPassword, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into the table
    $sql = "INSERT INTO phone (username, email, mobile, brand, model, phone_variant, years_used, conditions, price, image)
    VALUES ('$username', '$mail', '$mobile', '$brand', '$model', '$phoneVariant', '$yearsUsed', '$conditions', '$price', '$image')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Upload the image to a directory
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["imageUpload"]["name"]);
        move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFile);
        echo "<script>
                alert('Your Request Has Been Recorded');
                window.location.href = 'profile.php';
            </script>";


        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Reselling Website</title>
    <link rel="stylesheet" href="style.css">
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
                    <li><a href="sell.php">Sell</a></li>
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

    <section class="sell">
        <div class="sell-a">
            <h1>Details to Sell your PHONE</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="s">
                    <label for="brand">Brand Name:</label>
                    <select id="brand" name="brand">
                        <option value="Choose Your Phone Brand">Choose Your Phone Brand</option>
                        <option value="Apple">Apple</option>
                        <option value="Xiaomi">Xiaomi</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Vivo">Vivo</option>
                        <option value="OnePlus">OnePlus</option>
                        <option value="Realme">Realme</option>
                        <option value="Motorola">Motorola</option>
                        <option value="Lenovo">Lenovo</option>
                        <option value="Nokia">Nokia</option>
                        <option value="Honor">Honor</option>
                        <option value="Google">Google</option>
                        <option value="Poco">Poco</option>
                        <option value="Infinix">Infinix</option>
                        <option value="Tecno">Tecno</option>
                        <option value="iQOO">iQOO</option>
                        <option value="Nothing">Nothing</option>
                    </select>
                </div>
                <div class="s">
                    <label for="model">Model:</label>
                    <input type="text" id="model" name="model" placeholder="Enter the Model Name " required>
                </div>
                <div class="s">
                    <label for="Variant">Choose a phone variant:</label>
                    <select id="Variant" name="phoneVariant">
                        <option value="Choose Your Variant">Choose Your Variant</option>
                        <option value="32GB">32GB</option>
                        <option value="64GB">64GB</option>
                        <option value="128GB">128GB</option>
                        <option value="256GB">256GB</option>
                        <option value="512GB">512GB</option>
                        <option value="1TB">1TB</option>
                    </select>
                </div>
                <div class="s">
                    <label for="use">Month Used:</label>
                    <input type="number" id="use" name="use" placeholder="Enter the Month Used">
                </div>
                <div class="s">
                    <label for="condition">Condition:</label>
                    <select id="condition" name="condition">
                        <option value="Poor">Poor</option>
                        <option value="Average">Average</option>
                        <option value="Good">Good</option>
                        <option value="New">New</option>
                    </select>
                </div>
                <div class="s">
                    <label for="imageUpload">Upload an image:</label>
                    <input type="file" id="imageUpload" name="imageUpload" accept="image/*"
                        placeholder="Upload a Photo of the Phone" required>
                </div>
                <div class="s">
                    <label for="price">Price: </label>
                    <input type="number" id="price" name="price"
                        placeholder="Enter the Expected Price Of the Phone in Rs" required>
                </div>
                <div class="se">
                    <input type="submit" value="Submit">
                </div>
            </form>
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