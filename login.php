<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['uname']) && isset($_GET['pass'])) {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "shubham";

    $conn = new mysqli($server, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $uname = $_GET['uname'];
    $pass = $_GET['pass'];

    $sql = "SELECT * FROM login";
    $result = $conn->query($sql);
    $validUser = false;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($uname == $row['email'] && $pass == $row['pass']) {
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $row['name'];
                $_SESSION['mail'] = $row['email'];
                $_SESSION['mobile'] = $row['mobile'];
                $_SESSION['userid'] = $row['userid']; // Assuming your user ID column in the database is named 'userid'
                
                // Redirect to the profile page
                header("Location: profile.php");
                exit();
            }
        }

        if (!$validUser) {
            $error = "Invalid details";
        }
    } else {
        $error = "Please signup first";
    }

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
  <div class="login">
    <div class="login-head">
      <h1>Login</h1>
      <?php
      if (isset($error)) {
          echo "<p style='color:red;'>$error</p>";
      }
      ?>
      <form method="GET" action="">
        <div class="un">
          <h2>Email</h2> <input type="email" name="uname" required>
        </div>
        <div class="un">
          <h2>Password</h2><input type="password" name="pass" required><br><br>
        </div>
        <div class="su">
          <input type="submit" value="Login">
        </div>
      </form>
      <br><br><br>
      <div class="link">
        <a href="signup.html" target="_blank">To Create A New Account SIGN UP</a>
      </div>
    </div>
  </div>
</body>
</html>
