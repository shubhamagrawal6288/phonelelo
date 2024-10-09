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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the phone ID from the form
    $phone_id = $_POST['id'];

    // Prepare the SQL statement to delete the phone record
    $sql = "DELETE FROM phone WHERE id = $phone_id";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the phone ID to the prepared statement
        $stmt->bind_param("i", $phone_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Record deleted successfully
            echo "<script>alert('Record deleted successfully');</script>";
            header("Location: adminpage.php"); // Redirect to the dashboard page
            exit;
        } else {
            // Error executing the statement
            echo "Error deleting record: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error preparing the statement
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
