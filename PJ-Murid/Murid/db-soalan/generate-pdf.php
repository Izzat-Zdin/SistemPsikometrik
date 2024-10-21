<?php
require('../tcpdf/tcpdf.php'); // Adjust the path if needed
include('../action/connect.php'); // Include your database connection file
session_start();

// Check if murid_id and markah_id are set in the session or GET request
if (isset($_SESSION['murid_id']) && isset($_GET['markah_id'])) {
    $murid_id = $_SESSION['murid_id'];
    $markah_id = $_GET['markah_id'];

    // Fetch student data from the database
    $query = "SELECT murid_acc.murid_nama AS name, murid_acc.murid_ic AS ic, kelas.kelas_nama AS class, keputusan.markah AS mark, keputusan.ex_id AS ex_id, keputusan.komen AS komen
              FROM keputusan 
              JOIN murid_acc ON keputusan.murid_id = murid_acc.murid_id 
              JOIN kelas ON murid_acc.kelas_id = kelas.kelas_id 
              WHERE keputusan.murid_id = ? AND keputusan.markah_id = ?";
    $stmt = $condb->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ii", $murid_id, $markah_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $studentData = $result->fetch_assoc();
            
            // Fetch ex_tajuk from exam_set table using ex_id
            $examQuery = "SELECT ex_tajuk FROM exam_set WHERE ex_id = ?";
            $examStmt = $condb->prepare($examQuery);

            if ($examStmt) {
                $examStmt->bind_param("i", $studentData['ex_id']);
                $examStmt->execute();
                $examResult = $examStmt->get_result();

                if ($examResult->num_rows > 0) {
                    $examData = $examResult->fetch_assoc();
                    $exTajuk = $examData['ex_tajuk'];
                }
            }

            // Calculate individual marks by dividing the total mark by 4
            $totalMark = $studentData['mark'];
            $individualMarks = array_fill(0, 4, round($totalMark / 4));

            // Convert pixels to millimeters for the template image dimensions (1024px width and 650px height)
            $image_width_px = 1024;
            $image_height_px = 650;
            $width_mm = $image_width_px * 0.264583; // 270.93 mm
            $height_mm = $image_height_px * 0.264583; // 172.98 mm

            // Create new PDF document with custom size based on the image dimensions
            $pdf = new TCPDF('L', PDF_UNIT, [$width_mm, $height_mm], true, 'UTF-8', false);

            // Remove default TCPDF header and footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set margins to zero
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false, 0);

            $pdf->AddPage();
            $pdf->SetFont('Helvetica', '', 12);

            // Add the background image (Canva template) to fit the PDF dimensions exactly
            $template = 'slip.png'; // Path to the uploaded image
            $pdf->Image($template, 0, 0, $width_mm, $height_mm, '', '', '', false, 300, '', false, false, 0);

            // Overlay text on the image

            // Set the position for the name
            $pdf->SetXY(82, 35); // Adjust the coordinates as per your template
            $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
            $pdf->Cell(0, 10, htmlspecialchars($studentData['name']), 0, 1, 'L');

            // Set the position for the IC
            $pdf->SetXY(82, 44); // Adjust the coordinates as per your template
            $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
            $pdf->Cell(0, 10, htmlspecialchars($studentData['class']), 0, 1, 'L');

            // Set the position for the class
            $pdf->SetXY(82, 53); // Adjust the coordinates as per your template
            $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
            $pdf->Cell(0, 10, htmlspecialchars($studentData['ic']), 0, 1, 'L');

            // Set the position for the komen (comment)
            $pdf->SetXY(81, 62); // Adjust the coordinates as per your template
            $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
            $pdf->Cell(0, 10, htmlspecialchars($studentData['komen']), 0, 1, 'L');

            $pdf->SetXY(230, 120); // Adjust the coordinates as per your template
            $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
            $pdf->Cell(0, 10, $totalMark . '%', 0, 1, 'L');

            // Set the positions for the individual marks
            $positions = [
                ['x' => 230, 'y' => 84.5], // First mark position
                ['x' => 230, 'y' => 93.5], // Second mark position
                ['x' => 230, 'y' => 102], // Third mark position
                ['x' => 230, 'y' => 111]  // Fourth mark position
            ];

            foreach ($individualMarks as $index => $mark) {
                $pdf->SetFont('Helvetica', '', 13); // Set font size to 14
                $pdf->SetXY($positions[$index]['x'], $positions[$index]['y']);
                $pdf->Cell(0, 10,  $mark . '.00', 0, 1, 'L');
            }

            // Output PDF to browser
            $filename = 'SlipPsikometrik_'.$studentData['name'] .'_'. $studentData['ic'] . '.pdf';
            $pdf->Output($filename, 'I'); // 'I' for inline display
        } else {
            echo "No data found for the given murid_id and markah_id.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
} else {
    echo "Invalid request.";
}

$condb->close();
?>