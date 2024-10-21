<?php
// Start or resume a session

include('connect.php');

$error_message = ''; // Variable to store error messages

// Initialize variables to avoid undefined variable warnings
$penyelia_nama = '';
$penyelia_email = '';
$penyelia_id = ''; // Initialize the variable for the penyelia_id
$penyelia_gambar = '';


// Check if penyelia_id is set in the session
if (isset($_SESSION['penyelia_id'])) {
    $penyelia_id = $_SESSION['penyelia_id'];

    // Prepare the SQL query
    $query = "SELECT * FROM penyelia_acc WHERE penyelia_id = ?";
    $stmt = $condb->prepare($query);

    // Check if the statement was prepared successfully
    if ($stmt) {
        $stmt->bind_param("i", $penyelia_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $penyelia_nama = $row['penyelia_nama'];
            $penyelia_email = $row['penyelia_email'];
            $penyelia_gambar = $row['penyelia_gambar']; // Retrieve penyelia_gambar from the database            
        } else {
            // No rows returned for the given penyelia_id
            $error_message = "No data found for penyelia_id: $penyelia_id";
        }

        $stmt->close();
    } else {
        // Error preparing the statement
        $error_message = "Failed to prepare the SQL statement.";
    }
} else {
    $error_message = "Session penyelia_id is not set.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sidebar</title>
    <link rel="stylesheet" href="path/to/your/css/file.css" />
    <style>
    .sidebar__name,
    .sidebar__email {
        color: white;
    }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <nav class="sidebar__container">
            <div class="sidebar__logo">
                <!---<img src="../assets/img/mpp.png" alt="" class="sidebar__logo-img">
                <img src="../assets/img/yt-logo-text.svg" alt="" class="sidebar__logo-text">-->
            </div>

            <div class="sidebar__account">
                <!-- Profile Picture -->
                <img src="<?php echo $penyelia_gambar ? 'img-profil/'.$penyelia_gambar : 'https://www.pngkey.com/png/full/73-730477_first-name-profile-image-placeholder-png.png'; ?>"
                    alt="Profile Picture" class="sidebar__perfil">
                <div class="sidebar__names">
                    <!-- Penyelia Name -->
                    <h3 class="sidebar__name"><?php echo htmlspecialchars($penyelia_nama); ?></h3>
                    <!-- Penyelia Email -->
                    <span class="sidebar__email"><?php echo htmlspecialchars($penyelia_email); ?></span>
                </div>
            </div>

            <div class="sidebar__content">
                <div class="sidebar__list">
                    <a href="../home.php" class="sidebar__link">
                        <i class="ri-home-5-line"></i>
                        <span class="sidebar__link-name">Laman Utama</span>
                        <span class="sidebar__link-floating">Laman Utama</span>
                    </a>

                    <a href="profil.php" class="sidebar__link">
                        <i class="ri-account-box-fill"></i>
                        <span class="sidebar__link-name">Edit Profil</span>
                        <span class="sidebar__link-floating">Edit Profil</span>
                    </a>

                    <h3 class="sidebar__title">
                        <span>Kelas</span>
                    </h3>

                    <div class="sidebar__list">
                        <a href="../kelas.php" class="sidebar__link ">
                            <i class="ri-layout-4-line"></i>
                            <span class="sidebar__link-name">Tambah & Urus Kelas</span>
                            <span class="sidebar__link-floating">Tambah Kelas</span>
                        </a>
                    </div>

                    <h3 class="sidebar__title">
                        <span>Soalan</span>
                    </h3>

                    <div class="sidebar__list">
                        <a href="../soalan/soalan.php" class="sidebar__link">
                            <i class="ri-file-add-fill"></i>
                            <span class="sidebar__link-name">Tambah Set Soalan</span>
                            <span class="sidebar__link-floating">Tambah Set Soalan</span>
                        </a>

                        <a href="../soalan/home-soalan.php" class="sidebar__link">
                            <i class="ri-settings-4-fill"></i>
                            <span class="sidebar__link-name">Urus Soalan</span>
                            <span class="sidebar__link-floating">Urus Soalan</span>
                        </a>

                        <div class="sidebar__content">
                            <a href="../keputusan/keputusan.php" class="sidebar__link">
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
                </div>
            </div>
        </nav>
    </div>
    <?php if ($error_message) : ?>
    <div class="error-message">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
    <?php endif; ?>
</body>

</html>