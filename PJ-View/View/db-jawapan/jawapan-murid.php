<?php
session_start();

include '../action/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['murid_id'])) {
        $murid_id = $_SESSION['murid_id'];
        $answers = $_POST['answers'];
        
        $total_questions = count($answers);
        $correct_answers = 0;

        foreach ($answers as $soalan_id => $jawapan) {
            // Fetch the correct answer (pilihan_1) from the exam_soalan table
            $query = "SELECT pilihan_1 FROM exam_soalan WHERE soalan_id = ?";
            $stmt = $condb->prepare($query);
            $stmt->bind_param("i", $soalan_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($correct_answer);
            
            if ($stmt->num_rows > 0) {
                $stmt->fetch();

                // Determine if the student's answer is correct
                $status_jawapan = ($jawapan == $correct_answer) ? "BETUL" : "SALAH";
                if ($status_jawapan == "BETUL") {
                    $correct_answers++;
                }

                // Insert the student's answer into the exam_jawapan table
                $insert_query = "INSERT INTO exam_jawapan (soalan_id, murid_id, jawapan, status_jawapan) VALUES (?, ?, ?, ?)";
                $insert_stmt = $condb->prepare($insert_query);
                $insert_stmt->bind_param("iiss", $soalan_id, $murid_id, $jawapan, $status_jawapan);
                if (!$insert_stmt->execute()) {
                    echo "Error: " . $insert_stmt->error;
                }
            } else {
                echo "Error: Invalid soalan_id.";
            }
            $stmt->close();
        }

        // Calculate total marks
        $total_marks = ($correct_answers / $total_questions) * 100;

        // Insert the total marks into the keputusan table
        $kelas_id = 1; // Example class ID, you can replace this with the actual class ID if needed
        $markah_query = "INSERT INTO keputusan (murid_id, kelas_id, markah) VALUES (?, ?, ?)";
        $markah_stmt = $condb->prepare($markah_query);
        $markah_stmt->bind_param("iis", $murid_id, $kelas_id, $total_marks);
        if (!$markah_stmt->execute()) {
            echo "Error: " . $markah_stmt->error;
        }

        echo "<script>alert('Jawapan berjaya dihantar.');</script>";
        echo "<script>window.location = '../jawab.php';</script>"; // Redirect to a specific page after submission
    } else {
        echo "Error: User not logged in.";
    }
}
?>