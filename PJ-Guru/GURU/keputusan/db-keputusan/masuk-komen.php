<?php
// Start session
session_start();

// Include database connection
include '../includes/connect.php';

// Check if murid_id is set in session
if (!isset($_SESSION['murid_id'])) {
    // Redirect or handle error as needed
    header("Location: ../index.php"); // Example redirect
    exit; // Stop further execution
}

// Validate and sanitize input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    if (isset($_POST['ex_id']) && isset($_POST['komen'])) {
        $murid_id = $_SESSION['murid_id'];
        $ex_id = $_POST['ex_id'];
        $komen = mysqli_real_escape_string($condb, $_POST['komen']); // Sanitize input
        
        // Prepare the SQL query to insert into keputusan table
        $sql_insert = "INSERT INTO keputusan (murid_id, ex_id, komen) VALUES (?, ?, ?)";
        
        // Prepare statement for insertion
        $stmt = $condb->prepare($sql_insert);
        $stmt->bind_param("iis", $murid_id, $ex_id, $komen);
        
        // Execute SQL query
        try {
            $stmt->execute();
            // On success, redirect to keputusan.php or another page
            header("Location: ../keputusan.php");
            exit; // Stop further execution
        } catch (mysqli_sql_exception $e) {
            // If query execution fails
            echo "Failed to add komen: " . $e->getMessage();
            // You can handle the error further if needed
        }
    } else {
        // Handle case where 'ex_id' or 'komen' is not set
        echo "Please submit the form correctly"; // Or log the error
    }
} else {
    // If the request method is not POST, simply exit
    exit;
}

// Close statement and database connection
$condb->close();
?>