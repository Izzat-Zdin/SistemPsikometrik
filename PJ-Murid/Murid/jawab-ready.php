<?php

session_start();
include 'guard-murid.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="mpp.png">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">

    <!--=============== CSS ===============-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/jawab-ready.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Murid • Sedia Jawab</title>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/blue.png" alt="sidebar img" class="bg-image">
    <!--=============== HEADER ===============-->

    <?php include 'includes/header-murid.php'; ?>

    <!--=============== SIDEBAR ===============-->

    <?php include 'includes/sidebar-murid.php'; ?>

    <!--=============== MAIN ===============-->

    <main class="main container" id="main" style="margin-left: 17%; margin-top: 9%;">
        <div class="quiz-card-murid" style="width: 48%; height:270px;">
            <div class="quiz-header-murid">
                <img src="assets/img/kiri.png" alt="Daily Check-in" style="width: 155px; height: 155px;">
                <div class="quiz-details-murid"
                    style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight:bolder;">

                    <?php
                    include('action/connect.php');
                    // Retrieve the ex_id from the URL
                    $ex_id = isset($_GET['ex_id']) ? intval($_GET['ex_id']) : 0;

                    // Fetch data for the specific ex_id
                    $sql = "SELECT es.ex_guru, k.kelas_nama, es.ex_desc, es.ex_tajuk, es.ex_minit 
                            FROM exam_set es
                            JOIN kelas k ON es.kelas_id = k.kelas_id
                            WHERE es.ex_id = ?";
                    $stmt = $condb->prepare($sql);
                    $stmt->bind_param("i", $ex_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $tajuk = htmlspecialchars($row['ex_tajuk']);
                        $nama_guru = htmlspecialchars($row['ex_guru']);
                        $kelas = htmlspecialchars($row['kelas_nama']);
                        $arahan = htmlspecialchars($row['ex_desc']);
                        $masa = htmlspecialchars($row['ex_minit']);
                    } else {
                        $nama_guru = "N/A";
                        $kelas = "N/A";
                        $arahan = "N/A";
                        $tajuk = "N/A";
                        $masa = "N/A";
                    }
                    ?>
                    <h2 class=" badge-murid"
                        style="color: black; font-family: 'Montserrat', sans-serif; font-size:18px;">
                        <?php echo $tajuk; ?></h2>
                    <p style="color: white; font-weight: ; font-size:17.5px;">
                        Nama Guru : <?php echo $nama_guru; ?><br>
                        Kelas : <?php echo $kelas; ?><br>
                        Arahan : <?php echo $arahan; ?><br>
                    </p>
                </div>
                <div class="quiz-actions-murid">
                    <button class="btn btn-light"
                        style="color: white; font-family: 'Montserrat', sans-serif; font-weight: bold; font-size:14px; position:absolute; top:44%; left:65%;">
                        <?php echo $masa; ?> Minit</button>
                </div>
            </div>
            <div class="quiz-footer-murid">
                <button
                    style=" font-family: 'Montserrat', sans-serif; font-weight: bolder; font-size:15px; position:sticky; margin-left:78.5%; background-color:green;"
                    class="btn btn-primary start-btn-murid" onclick="openModal()">Mulakan</button>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div id="id02" class="w3-modal">
        <div class="w3-modal-content w3-card-2 w3-animate-zoom" style="width:400px">
            <div class="w3-center">
                <span onclick="document.getElementById('id02').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <p>
                    <img src="../gambar/segi.gif" style="width: 80px; margin-top: 20%; margin-left: 40%;">
                </p>
            </div>
            <form class="w3-container">
                <div class="w3-section">
                    <label class="danger-lbl" style="margin-left: 10% ; margin-top: -80% ;"><b>Adakah anda bersedia
                            untuk
                            menjawab?</b></label>
                    <div class="button-container">
                        <button style="margin-left: 85%" class="w3-button w3-red" type="button"
                            onclick="startQuiz(<?php echo $ex_id; ?>)">Ya</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js"></script>
    <script>
    function openModal() {
        document.getElementById('id02').style.display = 'block';
    }

    function startQuiz(ex_id) {
        document.getElementById('id02').style.display = 'none';
        location.href = 'soalan.php?ex_id=' + ex_id;
    }
    </script>
</body>

</html>