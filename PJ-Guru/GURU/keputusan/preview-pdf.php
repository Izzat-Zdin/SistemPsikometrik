<?php
require('tcpdf/tcpdf.php');
include 'connect.php';

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// remove title and unnecessary lines
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// add a page
$pdf->AddPage();

// Set a full-page background image (template image)
$templateImage = 'table.png'; // Path to your full-page background image

// Calculate the dimensions and position to cover the entire page
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();
$pdf->Image($templateImage, 15, 8, $pageWidth, $pageHeight, '', '', '', false, 300, '', false, false, 0);

// query database
$filterType = isset($_GET['filter-type']) ? $_GET['filter-type'] : 'all';
$filterValue = isset($_GET['filter-value']) ? $_GET['filter-value'] : '';

$sql = "SELECT k.murid_id, k.kelas_id, k.markah, m.murid_nama, m.murid_ic, c.kelas_nama 
        FROM keputusan k 
        JOIN murid_acc m ON k.murid_id = m.murid_id 
        JOIN kelas c ON m.kelas_id = c.kelas_id";

if ($filterType == 'kelas' && !empty($filterValue)) {
    $sql .= " WHERE c.kelas_nama LIKE ?";
    $stmt = $condb->prepare($sql);
    $filterValue = "%$filterValue%";
    $stmt->bind_param("s", $filterValue);
} elseif ($filterType == 'nama' && !empty($filterValue)) {
    $sql .= " WHERE m.murid_nama LIKE ?";
    $stmt = $condb->prepare($sql);
    $filterValue = "%$filterValue%";
    $stmt->bind_param("s", $filterValue);
} elseif ($filterType == 'markah' && !empty($_GET['filter-markah'])) {
    $markahRange = explode('-', $_GET['filter-markah']);
    $minMarkah = intval($markahRange[0]);
    $maxMarkah = intval($markahRange[1]);
    $sql .= " WHERE k.markah BETWEEN ? AND ?";
    $stmt = $condb->prepare($sql);
    $stmt->bind_param("ii", $minMarkah, $maxMarkah);
} else {
    $stmt = $condb->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

// Set the content area for the table
$pdf->SetXY(20, 60); // Adjust the position as needed

// construct HTML table
$html = '<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse;">';

if ($result->num_rows > 0) {
    $html .= '<thead>
                <tr>
                    <th style="border: 1px solid black;">Bil</th>
                    <th style="border: 1px solid black;">Nama</th>
                    <th style="border: 1px solid black;">IC</th>
                    <th style="border: 1px solid black;">Kelas</th>
                    <th style="border: 1px solid black;">Set Soalan</th>
                    <th style="border: 1px solid black;">Markah</th>
                </tr>
            </thead>
            <tbody>';

    $bil = 1;
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td style="border: 1px solid black;">' . $bil . '</td>
                    <td style="border: 1px solid black;">' . $row['murid_nama'] . '</td>
                    <td style="border: 1px solid black;">' . $row['murid_ic'] . '</td>
                    <td style="border: 1px solid black;">' . $row['kelas_nama'] . '</td>
                    <td style="border: 1px solid black;">Psikometrik</td> <!-- Assuming set_soalan is "Psikometrik" -->
                    <td style="border: 1px solid black;">' . $row['markah'] . ' %</td>
                  </tr>';
        $bil++;
    }

    $html .= '</tbody>';
} else {
    $html .= '<tr><td colspan="6" style="border: 1px solid black; text-align: center;">No data available</td></tr>';
    $html .= '</table>';
}

$html .= '</table>';

$stmt->close();
$condb->close();

// Print text using writeHTML() for table
$pdf->writeHTML($html, true, false, true, false, '');

// output the PDF as an inline display in the browser
$pdf->Output('student_results.pdf', 'I');
?>