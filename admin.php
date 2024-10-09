
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
      <h1>Admin Login</h1>
      <form method="GET" action="">
        <div class="un">
          <h2>User name</h2> <input type="text" name="uname">
        </div>
        <div class="un">
          <h2>PASSWORD</h2><input type="password" name="pass"><br><br>
        </div>
        <div class="su">
          <input type="submit" value="Login">
        </div>
      </form>
    </div> 
  </div>
</body>
</html>
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if username and password are provided and match the admin credentials
    if (isset($_GET['uname']) && isset($_GET['pass']) && $_GET['uname'] === 'admin' && $_GET['pass'] === 'admin') {
        // Redirect to the admin page
        header("Location: adminpage.php");
        exit();
    } else {
        // Display an error message if the credentials are incorrect
        echo "<p>Invalid username or password. Please try again.</p>";
    }
}
?>
