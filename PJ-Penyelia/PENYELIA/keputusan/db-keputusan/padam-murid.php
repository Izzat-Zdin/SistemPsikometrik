<?php
include('../includes/connect.php');

if ($condb->connect_error) {
    die("Connection failed: " . $condb->connect_error);
}

$sql = "DELETE FROM keputusan WHERE markah_id = ?";

// Assuming you are handling POST request from form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate markah_id value
    $markah_id = isset($_POST['markah_id']) ? $_POST['markah_id'] : null;

    if ($markah_id !== null) {
        // Prepare and bind parameters
        $stmt = $condb->prepare($sql);
        $stmt->bind_param("i", $markah_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Records deleted successfully for markah_id = $markah_id.'); window.location.href = '../keputusan.php';</script>";
        } else {
            echo "<script>alert('Error deleting records: " . $stmt->error . "'); window.location.href = '../keputusan.php';</script>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<script>alert('Invalid markah_id value.'); window.location.href = '../keputusan.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = '../keputusan.php';</script>";
}

// Close connection
$condb->close();
?>