<?php
session_start();

include '../action/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['murid_id'])) {
        $murid_id = $_SESSION['murid_id'];
        $answers = $_POST['answers'];
        $ex_id = isset($_POST['ex_id']) ? intval($_POST['ex_id']) : 0;

        $total_questions = count($answers);
        $correct_answers = 0;

        foreach ($answers as $soalan_id => $jawapan) {
            // Fetch the correct answer (pilihan_1) from the exam_soalan table
            $query = "SELECT pilihan_1 FROM exam_soalan WHERE soalan_id = ?";
            $stmt = $condb->prepare($query);
            if (!$stmt) {
                die("Prepare failed: (" . $condb->errno . ") " . $condb->error);
            }
            $stmt->bind_param("i", $soalan_id);
            if (!$stmt->execute()) {
                die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
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
                $insert_query = "INSERT INTO exam_jawapan (soalan_id, murid_id, jawapan, status_jawapan, ex_id) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $condb->prepare($insert_query);
                if (!$insert_stmt) {
                    die("Prepare failed: (" . $condb->errno . ") " . $condb->error);
                }
                $insert_stmt->bind_param("iissi", $soalan_id, $murid_id, $jawapan, $status_jawapan, $ex_id);
                if (!$insert_stmt->execute()) {
                    echo "Error: " . $insert_stmt->error . "<br>";
                }
                $insert_stmt->close();
            } else {
                echo "Error: Invalid soalan_id for soalan_id: $soalan_id.<br>";
            }
            $stmt->close();
        }

        // Calculate total marks
        $total_marks = ($correct_answers / $total_questions) * 100;

        // Before inserting total marks, fetch the correct kelas_id for the murid_id
        $kelas_query = "SELECT kelas_id FROM murid_acc WHERE murid_id = ?";
        $kelas_stmt = $condb->prepare($kelas_query);
        if (!$kelas_stmt) {
            die("Prepare failed: (" . $condb->errno . ") " . $condb->error);
        }
        $kelas_stmt->bind_param("i", $murid_id);
        if (!$kelas_stmt->execute()) {
            die("Execute failed: (" . $kelas_stmt->errno . ") " . $kelas_stmt->error);
        }
        $kelas_stmt->store_result();
        $kelas_stmt->bind_result($kelas_id);
        $kelas_stmt->fetch();

        if ($kelas_stmt->num_rows > 0) {
            // Insert total marks into the keputusan table along with the correct kelas_id
            $markah_query = "INSERT INTO keputusan (murid_id, kelas_id, markah, ex_id) VALUES (?, ?, ?, ?)";
            $markah_stmt = $condb->prepare($markah_query);
            if (!$markah_stmt) {
                die("Prepare failed: (" . $condb->errno . ") " . $condb->error);
            }
            $markah_stmt->bind_param("iisi", $murid_id, $kelas_id, $total_marks, $ex_id);
            if (!$markah_stmt->execute()) {
                echo "Error: " . $markah_stmt->error . "<br>";
            }
            $markah_stmt->close();
        } else {
            echo "Error: Invalid murid_id or kelas_id not found.<br>";
        }
        
        $kelas_stmt->close();

        echo "<script>alert('Jawapan berjaya dihantar.');</script>";
        echo "<script>window.location = '../jawab.php';</script>"; // Redirect to a specific page after submission
    } else {
        echo "Error: User not logged in.<br>";
    }
} else {
    echo "Invalid request method.<br>";
}
?>