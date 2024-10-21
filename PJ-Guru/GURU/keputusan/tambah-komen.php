<?php
include 'connect.php';
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST['comment'];
    $markah_id = $_POST['markah_id']; // Use markah_id to uniquely identify the row

    // Update the comment in the database
    $query = "UPDATE keputusan SET komen = ? WHERE markah_id = ?";
    $stmt = $condb->prepare($query);

    if (!$stmt) {
        die("Prepare failed: " . $condb->error);
    }

    $stmt->bind_param('si', $comment, $markah_id);

    if ($stmt->execute()) {
        $_SESSION['comment_update'] = "Komen berjaya dihantar.";
    } else {
        $_SESSION['comment_update'] = "Error updating comment: " . $stmt->error;
    }

    $stmt->close();
    $condb->close();

    // Redirect back to the previous page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}
?>