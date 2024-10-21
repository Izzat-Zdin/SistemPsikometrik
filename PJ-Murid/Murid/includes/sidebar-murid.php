<?php

include('../action/connect.php');

$murid_nama = '';
$murid_gambar = '';
$kelas_nama = '';

if (isset($_SESSION['murid_id'])) {
    $murid_id = $_SESSION['murid_id'];

    $query = "SELECT murid_acc.murid_nama, murid_acc.murid_gambar, kelas.kelas_nama 
              FROM murid_acc 
              JOIN kelas ON murid_acc.kelas_id = kelas.kelas_id 
              WHERE murid_acc.murid_id = ?";
    $stmt = $condb->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $murid_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $murid_nama = $row['murid_nama'];
            $murid_gambar = $row['murid_gambar'];
            $kelas_nama = $row['kelas_nama'];
        } else {
            die("No data found for murid_id: $murid_id");
        }

        $stmt->close();
    } else {
        die("Failed to prepare the SQL statement.");
    }
} else {
    die("Session murid_id is not set.");
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

    .sidebar__perfil {
        display: block;
    }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <nav class="sidebar__container">
            <div class="sidebar__account">
                <img src="<?php echo htmlspecialchars($murid_gambar ? 'profil/img-profil/'.$murid_gambar : 'https://www.pngkey.com/png/full/73-730477_first-name-profile-image-placeholder-png.png'); ?>"
                    alt="Profile Picture" class="sidebar__perfil">
                <div class="sidebar__names">
                    <h3 class="sidebar__name"><?php echo htmlspecialchars($murid_nama); ?></h3>
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
                <h3 class="sidebar__title"><span>Soalan</span></h3>
                <div class="sidebar__list">
                    <a href="jawab.php" class="sidebar__link">
                        <i class="ri-question-answer-fill"></i>
                        <span class="sidebar__link-name">Jawab Soalan</span>
                        <span class="sidebar__link-floating">Jawab Soalan</span>
                    </a>
                    <h3 class="sidebar__title"><span>Keputusan</span></h3>
                    <a href="keputusan.php" class="sidebar__link">
                        <i class="ri-file-list-3-fill"></i>
                        <span class="sidebar__link-name">Keputusan</span>
                        <span class="sidebar__link-floating">Keputusan</span>
                    </a>
                    <br>
                    <div class="sidebar__content">
                        <a href="../../../PJ-Home/tamat-session.php" class="sidebar__link">
                            <i class="ri-logout-box-r-line"></i>
                            <span class="sidebar__link-name">Log Keluar</span>
                            <span class="sidebar__link-floating">Log Keluar</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <?php
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
</body>

</html>