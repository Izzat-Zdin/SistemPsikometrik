<?php 
session_start();
include '../guard-penyelia.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="../mpp.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/home-soalan.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">

    <title>Penyelia • Laman Soalan</title>
</head>

<style>
/* Stylish Scrollbar */
::-webkit-scrollbar {
    width: 20px;
    /* Width of the scrollbar */
}

::-webkit-scrollbar-track {
    background: #1f1f1f;
    /* Background of the scrollbar track */
    border-radius: 10px;
    /* Rounded corners of the track */
    padding-top: 40%;
}

::-webkit-scrollbar-thumb {
    background: gray;
    /* Color of the scrollbar thumb */
    border-radius: 10px;
    /* Rounded corners of the thumb */
    border: 3px solid #1f1f1f;
    /* Adds space around the thumb */
}

::-webkit-scrollbar-thumb:active {
    background: white;
    /* Active color for the scrollbar thumb */
}
</style>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/green.png">
    <!--=============== HEADER ===============-->
    <?php include 'includes/header-soalan-home.php'; ?>
    <!--=============== SIDEBAR ===============-->
    <?php include 'includes/sidebar-soalan.php'; ?>
    <!--=============== MAIN ===============-->
    <main class="main container" id="main" style="position:absolute; top:7%;">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 11%; left:27.5%">
            SET SOALAN</h1>
        <br><br><br>

        <div class="card-container-murid" style="font-size: ; font-family: 'Montserrat', sans-serif;">
            <?php
            include 'action/connect.php';

            // SQL query to select specific columns including ex_guru and join with kelas table
            $sql = "SELECT exam_set.ex_id, kelas.kelas_nama, exam_set.ex_tajuk, exam_set.ex_desc, exam_set.ex_tarikh, exam_set.ex_minit, exam_set.ex_guru 
                    FROM exam_set 
                    JOIN kelas ON exam_set.kelas_id = kelas.kelas_id";
            $result = $condb->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="card-murid" style="color:white;" onclick="selectExam(' . $row['ex_id'] . ')">
                        <div class="card-body-murid">
                            <div class="badge-murid">' . $row['ex_tajuk'] . '</div>
                            <h style="font-size:17px; color:white;">Kelas : ' . $row['kelas_nama'] . '</h>
                            <h style="font-size:17px; color:white;">Guru : ' . $row['ex_guru'] . '</h12><br>
                            <h style="font-size:17px; color:white;">Masa : ' . $row['ex_minit'] . ' Minit</h12>
                        </div>
                    </div>';
                }
            } else {
                echo "0 results";
            }

            // Close connection
            $condb->close();
            ?>
        </div>
    </main>
    <!--=============== MAIN JS ===============-->
    <script>
    function selectExam(exId) {
        // Store ex_id in the session and redirect
        window.location.href = 'store-exam-session.php?ex_id=' + exId;
    }
    </script>
    <script src="../assets/js/main.js"></script>
</body>

</html>