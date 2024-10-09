<?php
// Define the isLoggedIn function
session_start();
function isLoggedIn() {
    // Check if the user is logged in (you need to implement this logic)
    // For demonstration purpose, let's assume there's a session variable named 'user_id'
    // If 'user_id' exists in the session, the user is considered logged in
    return isset($_SESSION['loggedin']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>
<link rel="stylesheet" href="style.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .C1 {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"],
    input[type="email"],
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    textarea {
        resize: vertical;
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
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
          <li><a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true? 'profile.php' : 'index.html'; ?>">Home</a></li>
          <li><a href="<?php echo isLoggedIn() ? 'buy.php' : 'buynot.php'; ?>">Buy</a></li>
          <li><a href="sell.php">Sell</a></li>
          <li><a href="Contact.html">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

<div class="C1">
    <h2>Contact Us</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Send Message">
        </div>
    </form>
</div>

</body>
</html>
