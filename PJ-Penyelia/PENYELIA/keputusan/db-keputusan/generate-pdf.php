<?php
require('../tcpdf/tcpdf.php'); // Adjust the path if needed
include '../../action/connect.php'; // Include your database connection file

// Retrieve murid_id from URL
if (isset($_GET['murid_id'])) {
    $murid_id = $_GET['murid_id'];
    
    // Fetch student data
    $sql = "SELECT murid_acc.murid_ic AS ic, murid_acc.murid_nama AS name, kelas.kelas_nama AS class, keputusan.markah AS mark, keputusan.komen AS komen
            FROM keputusan 
            JOIN murid_acc ON keputusan.murid_id = murid_acc.murid_id 
            JOIN kelas ON murid_acc.kelas_id = kelas.kelas_id 
            WHERE keputusan.murid_id = $murid_id";
    $result = $condb->query($sql);

    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();

        // Convert pixels to millimeters for the template image dimensions (1024px width and 650px height)
        $image_width_px = 1024;
        $image_height_px = 650;
        $width_mm = $image_width_px * 0.264583; // 270.93 mm
        $height_mm = $image_height_px * 0.264583; // 172.98 mm

        // Calculate individual marks
        $total_mark = $studentData['mark'];
        $individual_mark = $total_mark / 4;

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

        // Set the position for the murid_ic
        $pdf->SetXY(82, 53); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
        $pdf->Cell(0, 10, htmlspecialchars($studentData['ic']), 0, 1, 'L');

        // Set the position for the name
        $pdf->SetXY(82, 35); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
        $pdf->Cell(0, 10, htmlspecialchars($studentData['name']), 0, 1, 'L');

        // Set the position for the class
        $pdf->SetXY(82, 44); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
        $pdf->Cell(0, 10, htmlspecialchars($studentData['class']), 0, 1, 'L');

        // Set the position for the komen (comment)
        $pdf->SetXY(81, 62); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
        $pdf->Cell(0, 10, htmlspecialchars($studentData['komen']), 0, 1, 'L');

        // Set the position for the mark (TOTAL) 
        $pdf->SetXY(230, 120); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 14); // Set font size to 14
        $pdf->Cell(0, 10, htmlspecialchars($studentData['mark']).'%', 0, 1, 'L');

        // Set the positions and values for the marks
        $pdf->SetXY(200, 84.5); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 13); // Set font size to 13
        $pdf->Cell(0, 10, number_format($individual_mark, 2), 0, 1, 'C');

        $pdf->SetXY(200, 93.5); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 13); // Set font size to 13
        $pdf->Cell(0, 10, number_format($individual_mark, 2), 0, 1, 'C');

        $pdf->SetXY(200, 102); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 13); // Set font size to 13
        $pdf->Cell(0, 10, number_format($individual_mark, 2), 0, 1, 'C');

        $pdf->SetXY(200, 111); // Adjust the coordinates as per your template
        $pdf->SetFont('Helvetica', '', 13); // Set font size to 13
        $pdf->Cell(0, 10, number_format($individual_mark, 2), 0, 1, 'C');

        // Output PDF to browser
        $pdf->Output('student_results.pdf', 'I'); // 'I' for inline display
    } else {
        echo "No data found for the given murid_id.";
    }
} else {
    echo "Invalid request.";
}

$condb->close();
?>