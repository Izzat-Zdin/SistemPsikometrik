<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../guard-guru.php';

// Check if guru_id is set in the session or URL parameter
if (isset($_SESSION['guru_id'])) {
    $guru_id = $_SESSION['guru_id'];
} elseif (isset($_GET['guru_id'])) {
    $guru_id = $_GET['guru_id'];
} else {
    echo "No guru_id provided.";
    exit;
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

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/profil.css">
    <link rel="stylesheet" href="../assets/css/header.css">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Guru • Edit Profil</title>
    <style>
    body {
        background-color: #051622;
    }
    </style>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/red.png" alt="sidebar img" class="bg-image">


    <!--=============== HEADER ===============-->
    <?php include 'includes/header-profil.php'; ?>

    <!--=============== SIDEBAR ===============-->
    <?php include 'includes/sidebar-profil.php'; ?>

    <!--=============== MAIN ===============-->
    <main class="main container" id="main" style="margin-left: 24%; margin-top: 6%;">

        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: fixed; top: 14%; left:20%">
            EDIT PROFIL</h1>

        <?php
        include 'action/connect.php';

        // Initialize variables
        $guru_nama = $guru_email = $guru_pass = $guru_gambar = $guru_ic = '';

        // Fetch user data based on guru_id
        $sql = "SELECT * FROM guru_acc WHERE guru_id = ?";
        $stmt = $condb->prepare($sql);
        $stmt->bind_param("i", $guru_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $guru_nama = $row["guru_nama"];
                $guru_email = $row["guru_email"];
                $guru_pass = $row["guru_pass"];
                $guru_gambar = $row["guru_gambar"];
                $guru_ic = $row["guru_ic"];
            }
        } else {
            echo "0 results";
        }
        $stmt->close();
        ?>

        <form action="action/edit-profil.php" method="post" class="box-p" autocomplete="off"
            enctype="multipart/form-data" style="height: 600px; border: 1px solid white;">

            <div class="profile-picc">
                <label class="-labell" for="file">
                    <span class="glyphicon glyphicon-camera"></span>
                    <span class="change-image">Change Image</span>
                </label>
                <input id="file" type="file" name="guru_gambar" accept=".jpg, .jpeg, .png" onchange="loadFile(event)" />
                <img src="<?php echo $guru_gambar ? 'img-profil/'.$guru_gambar : 'https://www.pngkey.com/png/full/73-730477_first-name-profile-image-placeholder-png.png'; ?>"
                    id="output" width="200" />
            </div>

            <div class="form-group" style="font-family: 'Montserrat', sans-serif; font-weight: 900;">
                <label class="font-p">Nama:</label>
                <input type="text" id="guru_nama" name="guru_nama" value="<?php echo $guru_nama; ?>"
                    style="color: black;">
                <br>
                <label class="font-p">Email:</label>
                <input type="email" id="guru_email" name="guru_email" value="<?php echo $guru_email; ?>"
                    style="color: black;">
                <br>
                <label class="font-p">No Kad Pengenalan:</label>
                <input type="text" id="guru_ic" name="guru_ic" placeholder="Sila Masukkan No Kad Pengenalan"
                    value="<?php echo $guru_ic; ?>" style="color: black;">
                <br>
                <label class="font-p">Kata Laluan:</label>
                <input type="text" id="guru_pass" name="guru_pass" value="<?php echo $guru_pass; ?>"
                    style="color: black;">
            </div>

            <button class="hover" type="submit" name="submit">Update</button>
        </form>
    </main>

    <?php
    $condb->close();
    ?>

    <!--=============== MAIN JS ===============-->
    <script src="../assets/js/main.js"></script>
    <script>
    var loadFile = function(event) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
    };
    </script>
    <script>
    <?php if (isset($_SESSION['update_success'])): ?>
    Swal.fire({
        icon: 'success',
        title: 'Berjaya',
        text: '<?php echo $_SESSION['update_success']; ?>',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'swal2-custom-toast'
        }
    });
    <?php unset($_SESSION['update_success']); endif; ?>
    </script>

    <style>
    .swal2-custom-toast {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 15px !important;
        font-weight: bold !important;
        color: black !important;
    }
    </style>

</body>

</html>