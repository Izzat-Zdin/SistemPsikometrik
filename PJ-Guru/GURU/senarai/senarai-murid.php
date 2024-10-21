<?php
include 'connect.php';

session_start(); // Start the session
include '../guard-guru.php';

// Check if the user is logged in and has a guru_id
if (!isset($_SESSION['guru_id'])) {
    die("Unauthorized access. Please log in.");
}

$guru_id = $_SESSION['guru_id'];

// Fetch the kelas_id associated with the logged-in guru_id
$query_kelas = "SELECT kelas_id FROM guru_acc WHERE guru_id = ?";
$stmt_kelas = $condb->prepare($query_kelas);

if (!$stmt_kelas) {
    die("Prepare failed: " . $condb->error);
}

$stmt_kelas->bind_param('i', $guru_id);
$stmt_kelas->execute();
$result_kelas = $stmt_kelas->get_result();

if ($result_kelas->num_rows > 0) {
    $row_kelas = $result_kelas->fetch_assoc();
    $kelas_id = $row_kelas['kelas_id'];
} else {
    die("No class assigned to this teacher.");
}

// Fetch students from the specified class
$query_students = "SELECT m.murid_id, m.murid_nama, m.murid_ic, c.kelas_nama 
                   FROM murid_acc m 
                   JOIN kelas c ON m.kelas_id = c.kelas_id
                   WHERE m.kelas_id = ?";
$stmt_students = $condb->prepare($query_students);

if (!$stmt_students) {
    die("Prepare failed: " . $condb->error);
}

$stmt_students->bind_param('i', $kelas_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/mpp.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="senarai-murid.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">

    <title>Guru • Senarai Murid</title>
    <style>
    body {
        background-color: #051622;
        font-family: 'Roboto', sans-serif;
    }

    .table-container {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        background-color: #343a40;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .table-container h2 {
        color: #fff;
        text-align: center;
        margin-bottom: 20px;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
        color: #fff;
    }

    .table-container th,
    .table-container td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #454d55;
    }

    .table-container th {
        font-weight: bold;
        text-transform: uppercase;
        background-color: #444;
    }

    .table-container tr:nth-child(odd) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table-container tr:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .bg-image {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }
    </style>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="red.png" alt="sidebar img" class="bg-image">

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>
    <?php include 'sidebar-senarai.php'; ?>


    <!-- MAIN -->
    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 14%; left:20%">
            SENARAI MURID KELAS</h1>
        <div class="table-container"
            style=" font-size: 18px; font-family: 'Montserrat' , sans-serif; position:absolute; top:25%; width:700px;">
            <table>
                <thead>
                    <tr>
                        <th>Bil</th>
                        <th>Nama</th>
                        <th>No Kad Pengenalan</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_students->num_rows > 0) {
                        $bil = 1;
                        while ($row = $result_students->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$bil}</td>";
                            echo "<td>{$row['murid_nama']}</td>";
                            echo "<td>{$row['murid_ic']}</td>";
                            echo "<td>{$row['kelas_nama']}</td>";
                            echo "</tr>";
                            $bil++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tiada data yang ditemukan</td></tr>";
                    }
                    $stmt_students->close();
                    $condb->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>