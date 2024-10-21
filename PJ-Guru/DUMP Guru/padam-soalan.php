<?php
include 'connect.php';  // Database connection

$data = json_decode(urldecode($_POST['data']), true);
$action = $_POST['action'];

if ($action == 'add') {
    $stmt = $conn->prepare("INSERT INTO questions (lecturer, course, question, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $data['lecturer'], $data['course'], $data['question'], $data['date']);
} elseif ($action == 'edit') {
    $id = ...;  // Get the ID for the question to be edited
    $stmt = $conn->prepare("UPDATE questions SET lecturer=?, course=?, question=?, date=? WHERE id=?");
    $stmt->bind_param("ssssi", $data['lecturer'], $data['course'], $data['question'], $data['date'], $id);
}

if ($stmt->execute()) {
    echo "Question saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>