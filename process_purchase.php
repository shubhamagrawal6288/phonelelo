<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $phone_id = $_POST['phone_id'];
    $address = $_POST['address'];
    $payment_mode = $_POST['payment_mode'];
    $purchase_date = date("Y-m-d H:i:s");

    // Database connection
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "shubham";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Directly execute the UPDATE command to set the status to 0
    $update_sql = "UPDATE phone SET status = 0 WHERE id = $phone_id";
    if ($conn->query($update_sql) === TRUE) {
        // If the update is successful, proceed with the insert operation
        
        // Prepare and execute the insert statement
        $sql = "INSERT INTO purchases (user_id, phone_id, address, payment_mode, purchase_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $_SESSION['userid'], $phone_id, $address, $payment_mode, $purchase_date);

        if ($stmt->execute()) {
            // Display a confirmation message and redirect back to buy.php
            echo "<script>alert('Your order has been confirmed!'); window.location.href='buy.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the connection
        $stmt->close();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
