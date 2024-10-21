<?php
session_start();
include '../action/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $tugasan_id = $data['task_id'];
    $guru_id = $_SESSION['guru_id']; // Assuming you store the guru_id in session

    if (!$guru_id) {
        die('Session expired or guru_id not set. Please log in again.');
    }

    $query = "DELETE FROM tugasan WHERE tugasan_id = ? AND guru_id = ?";
    $stmt = $condb->prepare($query);
    $stmt->bind_param("ii", $tugasan_id, $guru_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}
?>