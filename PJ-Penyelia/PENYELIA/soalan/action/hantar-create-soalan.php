<?php
// Include the database connection with adjusted path
include '../action/connect.php';

// Get ex_id from the URL
$ex_id = isset($_GET['ex_id']) ? intval($_GET['ex_id']) : 0;

// Initialize the ex_tajuk variable
$ex_tajuk = '';

// Fetch ex_tajuk based on the ex_id
if ($ex_id) {
    $query = "SELECT ex_tajuk FROM exam_set WHERE ex_id = ?";
    $stmt = $condb->prepare($query);
    $stmt->bind_param("i", $ex_id);
    $stmt->execute();
    $stmt->bind_result($ex_tajuk);
    $stmt->fetch();
    $stmt->close();
} else {
    $ex_tajuk = "Unknown Exam"; // Fallback value if ex_id is not valid
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];

    // Store "pilihan_1" as the correct answer for simplicity
    $correct_answer = "pilihan_1";

    // Insert into exam_soalan with ex_id and ex_tajuk
    $sql = "INSERT INTO exam_soalan (ex_id, tajuk, soalan, pilihan_1, pilihan_2, pilihan_3, pilihan_4, exam_jawapan) 
            VALUES ('$ex_id', '$ex_tajuk', '$question', '$option1', '$option2', '$option3', '$option4', '$correct_answer')";

    if (mysqli_query($condb, $sql)) {
        echo "<script>alert('Soalan berjaya ditambah');</script>";
        echo "<script>window.location = '../urus-soalan.php';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($condb);
    }
}
?>