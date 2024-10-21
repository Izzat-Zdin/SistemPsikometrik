<?php
session_start();
include '../action/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tugasan = $_POST['task'];
    $guru_id = $_SESSION['guru_id']; // Assuming you store the guru_id in session

    $query = "INSERT INTO tugasan (guru_id, tugasan) VALUES (?, ?)";
    $stmt = $condb->prepare($query);
    $stmt->bind_param("is", $guru_id, $tugasan);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: ../home.php'); // Redirect back to the main page
        exit();
    } else {
        echo "Failed to add task to the database";
    }

    $stmt->close();
}
?>