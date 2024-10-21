﻿<?php
// Start or resume a session
// Include the file to establish database connection
include('../action/connect.php');

// Variable to store error messages
$error_message = '';

// Initialize variables to avoid undefined variable warnings
$murid_nama = '';
$murid_gambar = '';
$kelas_nama = '';

// Check if murid_id is set in the session
if (isset($_SESSION['murid_id'])) {
    $murid_id = $_SESSION['murid_id'];

    // Prepare the SQL query
    $query = "SELECT murid_acc.murid_nama, murid_acc.murid_gambar, kelas.kelas_nama 
              FROM murid_acc 
              JOIN kelas ON murid_acc.kelas_id = kelas.kelas_id 
              WHERE murid_acc.murid_id = ?";
    $stmt = $condb->prepare($query);

    // Check if the statement was prepared successfully
    if ($stmt) {
        $stmt->bind_param("i", $murid_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $murid_nama = $row['murid_nama'];
            $murid_gambar = $row['murid_gambar']; // Retrieve murid_gambar from the database
            $kelas_nama = $row['kelas_nama']; // Retrieve kelas_nama from the database
        } else {
            // No rows returned for the given murid_id
            $error_message = "No data found for murid_id: $murid_id";
        }

        $stmt->close();
    } else {
        // Error preparing the statement
        $error_message = "Failed to prepare the SQL statement.";
    }
} else {
    // murid_id is not set in the session
    $error_message = "Session murid_id is not set.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="path/to/your/css/file.css">
    <style>
    .sidebar__name,
    .sidebar__email,
    .sidebar__kelas {
        color: white;
    }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <nav class="sidebar__container">

            <div class="sidebar__account">
                <!-- Profile Picture -->
                <img src="<?php echo $murid_gambar ? 'profil/img-profil/'.$murid_gambar : 'https://www.pngkey.com/png/full/73-730477_first-name-profile-image-placeholder-png.png'; ?>"
                    alt="Profile Picture" class="sidebar__perfil">
                <div class="sidebar__names">
                    <!-- Murid Name -->
                    <h3 class="sidebar__name"><?php echo htmlspecialchars($murid_nama); ?></h3>
                    <!-- Kelas Nama -->
                    <span class="sidebar__email"><?php echo htmlspecialchars($kelas_nama); ?></span>
                </div>
            </div>

            <div class="sidebar__content">
                <div class="sidebar__list">
                    <a href="home.php" class="sidebar__link">
                        <i class="ri-home-5-line"></i>
                        <span class="sidebar__link-name">Laman Utama</span>
                        <span class="sidebar__link-floating">Laman Utama</span>
                    </a>

                    <a href="profil/profil.php" class="sidebar__link">
                        <i class="ri-account-box-fill"></i>
                        <span class="sidebar__link-name">Edit Profil</span>
                        <span class="sidebar__link-floating">Edit Profil</span>
                    </a>
                </div>

                <h3 class="sidebar__title">
                    <span>Soalan</span>
                </h3>

                <div class="sidebar__list">
                    <a href="jawab.php" class="sidebar__link">
                        <i class="ri-question-answer-fill"></i>
                        <span class="sidebar__link-name">Jawab Soalan</span>
                        <span class="sidebar__link-floating">Jawab Soalan</span>
                    </a>

                    <h3 class="sidebar__title">
                        <span>Keputusan</span>
                    </h3>

                    <a href="keputusan.php" class="sidebar__link">
                        <i class="ri-file-list-3-fill"></i>
                        <span class="sidebar__link-name">Keputusan</span>
                        <span class="sidebar__link-floating">Keputusan</span>
                    </a>
                    <br>
                </div>
                <div class="sidebar__content">
                    <a href="../../../PJ-Home/tamat-session.php" class="sidebar__link">
                        <i class="ri-logout-box-r-line"></i>
                        <span class="sidebar__link-name">Log Keluar</span>
                        <span class="sidebar__link-floating">Log Keluar</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <?php
    // Display error message if any
    if ($error_message) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
</body>

</html>