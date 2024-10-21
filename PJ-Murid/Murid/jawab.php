<?php
session_start();
include 'guard-murid.php';

// Get the logged-in student's murid_id
$murid_id = $_SESSION['murid_id'];

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
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/jawab.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">

    <title>Murid • Jawab Ujian</title>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/blue.png" alt="sidebar img" class="bg-image">
    <!--=============== HEADER ===============-->

    <?php include 'includes/header-murid.php'; ?>

    <!--=============== SIDEBAR ===============-->

    <?php include 'includes/sidebar-murid.php'; ?>

    <!--=============== MAIN ===============-->
    <?php include 'action/connect.php'; ?>

    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 14%; left:20%">
            SENARAI UJIAN</h1>

        <div class="card-container-murid" style="position:absolute; margin-left: 18%; margin-top: 8%;">

            <?php
            // Fetch data from exam_set table where kelas_id matches murid_id's kelas_id
            $sql = "SELECT es.ex_id, es.ex_tajuk, es.kelas_id, es.ex_guru
                    FROM exam_set es
                    INNER JOIN murid_acc ma ON es.kelas_id = ma.kelas_id
                    WHERE ma.murid_id = ?";
            $stmt = $condb->prepare($sql);
            $stmt->bind_param("i", $murid_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $examData = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $examData[] = $row;
                }
            } else {
                echo "Tiada ujian tersedia";
            }
            $stmt->close();
            $condb->close();
            ?>

            <?php foreach ($examData as $exam) { ?>
            <div class="card-murid"
                onclick="window.location.href='jawab-ready.php?ex_id=<?php echo $exam['ex_id']; ?>'">
                <img src="assets/img/kiri.png" alt="Smiley Face">
                <div class="card-body-murid">
                    <div class="badge-murid">Soalan</div>
                    <h5 style="font-family: 'Montserrat', sans-serif; font-weight: bolder; font-size:20px;"
                        class="card-title-murid"><?php echo $exam['ex_tajuk']; ?></h5>
                    <!--<p class="card-text-murid">Kelas : <?php echo $exam['kelas_id']; ?> <br>
                        Nama Guru : <?php echo $exam['ex_guru']; ?>
                    </p>-->
                </div>
            </div>
            <?php } ?>
        </div>
    </main>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js"></script>
</body>

</html>