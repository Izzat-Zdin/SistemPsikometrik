<?php
include('connect.php');

$error_message = ''; // Variable to store error messages

// Initialize variables to avoid undefined variable warnings
$guru_nama = '';
$guru_email = '';
$guru_id = ''; // Initialize the variable for the guru_id
$guru_gambar = '';
$kelas_nama = ''; // Variable to store kelas_nama

// Check if guru_id is set in the session
if (isset($_SESSION['guru_id'])) {
    $guru_id = $_SESSION['guru_id'];

    // Prepare the SQL query
    $query = "SELECT guru_acc.*, kelas.kelas_nama FROM guru_acc 
              LEFT JOIN kelas ON guru_acc.kelas_id = kelas.kelas_id 
              WHERE guru_acc.guru_id = ?";
    $stmt = $condb->prepare($query);

    // Check if the statement was prepared successfully
    if ($stmt) {
        $stmt->bind_param("i", $guru_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $guru_nama = $row['guru_nama'];
            $guru_gambar = $row['guru_gambar']; // Retrieve guru_gambar from the database
            $kelas_nama = $row['kelas_nama']; // Retrieve kelas_nama from the database
        } else {
            // No rows returned for the given guru_id
            $error_message = "No data found for guru_id: $guru_id";
        }

        $stmt->close();
    } else {
        // Error preparing the statement
        $error_message = "Failed to prepare the SQL statement.";
    }
} else {
    $error_message = "Session guru_id is not set.";
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
    .sidebar__kelas {
        color: white;
    }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <nav class="sidebar__container">
            <div class="sidebar__logo">
            </div>

            <div class="sidebar__account">
                <!-- Profile Picture -->
                <img src="<?php echo $guru_gambar ? '../profil/img-profil/'.$guru_gambar : 'https://www.pngkey.com/png/full/73-730477_first-name-profile-image-placeholder-png.png'; ?>"
                    alt="Profile Picture" class="sidebar__perfil">
                <div class="sidebar__names">
                    <!-- Guru Name -->
                    <h3 class="sidebar__name"><?php echo htmlspecialchars($guru_nama); ?></h3>
                    <!-- Kelas Name -->
                    <span class="sidebar__kelas"><?php echo htmlspecialchars($kelas_nama); ?></span>
                </div>
            </div>

            <div class="sidebar__content">
                <div class="sidebar__list">

                    <a href="../home.php" class="sidebar__link">
                        <i class="ri-home-5-line"></i>
                        <span class="sidebar__link-name">Laman Utama</span>
                        <span class="sidebar__link-floating">Laman Utama</span>
                    </a>

                    <a href="../profil/profil.php" class="sidebar__link">
                        <i class="ri-account-box-fill"></i>
                        <span class="sidebar__link-name">Edit Profil</span>
                        <span class="sidebar__link-floating">Edit Profil</span>
                    </a>

                    <h3 class="sidebar__title">
                        <span>Senarai</span>
                    </h3>

                    <div class="sidebar__list">
                        <a href="senarai-murid.php" class="sidebar__link">
                            <i class="ri-team-fill"></i>
                            <span class="sidebar__link-name">Senarai Murid</span>
                            <span class="sidebar__link-floating">Senarai Murid</span>
                        </a>

                        <h3 class="sidebar__title">
                            <span>Keputusan</span>
                        </h3>
                        <a href="../keputusan/keputusan.php" class="sidebar__link">
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