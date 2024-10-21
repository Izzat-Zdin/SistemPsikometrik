<?php
// Start the session
session_start();
include 'guard-view.php';

// Include the database connection file
include 'action/connect.php';

// Check if murid_id is set in the session
if (isset($_SESSION['murid_id'])) {
    $murid_id = $_SESSION['murid_id'];

    // Fetch student data from the database
    $query = "SELECT murid_acc.murid_nama AS name, murid_acc.murid_ic AS ic, kelas.kelas_nama AS class, keputusan.markah AS mark, keputusan.ex_id AS ex_id, keputusan.markah_id AS markah_id, keputusan.komen AS komen
              FROM keputusan 
              JOIN murid_acc ON keputusan.murid_id = murid_acc.murid_id 
              JOIN kelas ON murid_acc.kelas_id = kelas.kelas_id 
              WHERE keputusan.murid_id = ?";
    $stmt = $condb->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $murid_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $studentData = [];
        while ($row = $result->fetch_assoc()) {
            // Fetch ex_tajuk from exam_set table using ex_id
            $examQuery = "SELECT ex_tajuk FROM exam_set WHERE ex_id = ?";
            $examStmt = $condb->prepare($examQuery);

            if ($examStmt) {
                $examStmt->bind_param("i", $row['ex_id']);
                $examStmt->execute();
                $examResult = $examStmt->get_result();

                if ($examResult->num_rows > 0) {
                    $examData = $examResult->fetch_assoc();
                    $row['ex_tajuk'] = $examData['ex_tajuk'];
                }
                $examStmt->close();
            }
            $studentData[] = $row;
        }
        $stmt->close();
    }
    $condb->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/mpp.png">
    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <!--=============== GOOGLE FONTS ===============-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap">
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/keputusan.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <title>Pelawat • Keputusan Murid</title>

    <style>
    body,
    h2,
    table,
    th,
    td,
    button {
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
    }

    /* Additional CSS styles if needed */
    </style>
</head>

<body class="dark-mode">
    <!-- Sidebar bg -->
    <img src="assets/img/dark-bg.jpg" alt="sidebar img" class="bg-image">

    <!--=============== HEADER ===============-->
    <?php include 'includes/header-view.php'; ?>

    <!--=============== SIDEBAR ===============-->
    <?php include 'includes/sidebar-view.php'; ?>

    <!--=============== MAIN ===============-->
    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 11%; left:43%">
            KEPUTUSAN</h1>
        <div class="result-container" style="width:245%; transform: scale(0.65); margin-top:-20%">
            <h2 style="font-size:35px;" class="title">Keputusan Murid</h2>


            <?php if (!empty($studentData)) { 
                // Get the first row to display student's general information
                $studentInfo = $studentData[0];
            ?>
            <div class="student-info" style="font-size:22px; color: white;">
                <p>Nama : <?php echo htmlspecialchars($studentInfo['name']); ?></p>
                <p>Kelas : <?php echo htmlspecialchars($studentInfo['class']); ?></p>
                <p>No Kad Pengenalan : <?php echo htmlspecialchars($studentInfo['ic']); ?></p>
                <br>

            </div>
            <?php } ?>

            <table class="result-table">
                <thead>
                    <tr style="font-size:22px;">
                        <th>Bil</th>
                        <th>Komponen Ujian</th>
                        <th>Markah Maksima</th>
                        <th>Markah Diperoleh</th>
                        <th>Ulasan</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody style="font-size:20px;">
                    <?php
                    if (!empty($studentData)) {
                        foreach ($studentData as $index => $data) {
                            echo "<tr>
                                    <td>" . ($index + 1) . "</td>
                                    <td>" . htmlspecialchars($data['ex_tajuk']) . "</td>
                                    <td>100</td>
                                    <td>" . htmlspecialchars($data['mark']) . "</td>
                                    <td>" . htmlspecialchars($data['komen']) . "</td>
                                    <td><button style=\"width:100%;\" onclick=\"downloadPDF(" . htmlspecialchars($data['markah_id']) . ")\" class=\"download-btn\">Muat Turun Slip</button></td>
                                  </tr>";
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="font-size:20px;">JUMLAH</td>
                        <td><?php echo isset($totalMark) ? htmlspecialchars($totalMark) : ''; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </main>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    <script>
    function downloadPDF(markah_id) {
        window.location.href = 'db-soalan/generate-pdf.php?markah_id=' +
            markah_id; // Update this URL to your actual endpoint
    }
    </script>
</body>

</html>