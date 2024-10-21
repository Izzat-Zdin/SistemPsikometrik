<?php
include('../includes/connect.php');

if ($condb->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM keputusan WHERE markah = ?";

// Assuming you are handling POST request from AJAX call or other form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate markah value
    $markah = isset($_POST['markah']) ? $_POST['markah'] : null;

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $markah);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Records deleted successfully for markah = $markah.";
    } else {
        echo "Error deleting records: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close connection
$condb>close();
?>