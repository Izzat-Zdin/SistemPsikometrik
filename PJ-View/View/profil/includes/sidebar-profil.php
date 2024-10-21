 <?php
include('../action/connect.php');

$error_message = ''; // Variable to store error messages

// Initialize variables to avoid undefined variable warnings
$murid_nama = '';
$murid_email = '';


// Check if murid_id is set in the session
if (isset($_SESSION['murid_id'])) {
    $murid_id = $_SESSION['murid_id'];

    // Prepare the SQL query
    $query = "SELECT * FROM murid_acc WHERE murid_id = ?";
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
            $murid_email = $row['murid_email'];

        } else {
            // No rows returned for the given murid_id
            $murid_nama = 'aa';
            $murid_email = 'aa';
            $murid_kelas = 'aa';
            $error_message = "No data found for murid_id: $murid_id";
        }

        $stmt->close();
    } else {
        // Error preparing the statement
        $murid_nama = 'bb';
        $murid_email = 'bb';
        $murid_kelas = 'bb';
        $error_message = "Failed to prepare the SQL statement.";
    }
} else {
    // murid_id is not set in the session
    $murid_nama = 'cc';
    $murid_email = 'cc';
    $murid_kelas = 'cc';
    $error_message = "Session murid_id is not set.";
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
     .sidebar__email,
     .sidebar__kelas {
         color: white;
     }
     </style>
 </head>

 <body>
     <div class="sidebar" id="sidebar">
         <nav class="sidebar__container">
             <div class="sidebar__logo">

                 <img src="../assets/img/mppp.png" alt="" class="sidebar__logo-img">
                 <img src="../assets/img/logo-murid.png" alt="" class="sidebar__logo-text">

             </div>

             <div class="sidebar__account">
                 <img src="../assets/img/ijat.jpg" alt="sidebar image" class="sidebar__perfil">

                 <div class="sidebar__names">
                     <h3 class="sidebar__name"><?php echo htmlspecialchars($murid_nama); ?></h3>
                     <span class="sidebar__email"><?php echo htmlspecialchars($murid_email); ?></span>

                 </div>
             </div>

             <div class="sidebar__content">
                 <div class="sidebar__list">
                     <a href="../home.php" class="sidebar__link">
                         <i class="ri-home-5-line"></i>
                         <span class="sidebar__link-name">Home</span>
                         <span class="sidebar__link-floating">Home</span>
                     </a>

                     <a href="profil.php" class="sidebar__link">
                         <i class="ri-compass-3-line"></i>
                         <span class="sidebar__link-name">Edit Profil</span>
                         <span class="sidebar__link-floating">Edit Profil</span>
                     </a>


                 </div>

                 <h3 class="sidebar__title">
                     <span>Soalan</span>
                 </h3>

                 <div class="sidebar__list">
                     <a href="../jawab.php" class="sidebar__link">
                         <i class="ri-notification-2-line"></i>
                         <span class="sidebar__link-name">Jawab Soalan</span>
                         <span class="sidebar__link-floating">Jawab Soalan</span>
                     </a>

                     <h3 class="sidebar__title">
                         <span>Keputusan</span>
                     </h3>


                     <a href="../keputusan.php" class="sidebar__link">
                         <i class="ri-settings-3-line"></i>
                         <span class="sidebar__link-name">Keputusan</span>
                         <span class="sidebar__link-floating">Keputusan</span>
                     </a>
                     <br>

                 </div>
             </div>
     </div>
     </div>
     </nav>
     </div>