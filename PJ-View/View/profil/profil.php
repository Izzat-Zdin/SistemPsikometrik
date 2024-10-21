<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if murid_id is set in the session or URL parameter
if (isset($_SESSION['murid_id'])) {
    $murid_id = $_SESSION['murid_id'];
} elseif (isset($_GET['murid_id'])) {
    $murid_id = $_GET['murid_id'];
} else {
    echo "No murid_id provided.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <title>Edit Profile</title>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="../assets/img/dark-bg.jpg" alt="sidebar img" class="bg-image">

    <!--=============== HEADER ===============-->
    <?php include 'includes/header-profil.php'; ?>

    <!--=============== SIDEBAR ===============-->
    <?php include 'includes/sidebar-profil.php'; ?>

    <!--=============== MAIN ===============-->
    <main class="main container" id="main">
        <h1 class="title-p">Edit Profile</h1>

        <?php
        include 'action/connect.php';

        // Initialize variables
        $murid_nama = $murid_email = $murid_pass = $murid_gambar = $murid_ic = '';

        // Fetch user data based on murid_id
        $sql = "SELECT * FROM murid_acc WHERE murid_id = ?";
        $stmt = $condb->prepare($sql);
        $stmt->bind_param("i", $murid_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $murid_nama = $row["murid_nama"];
                $murid_email = $row["murid_email"];
                $murid_pass = $row["murid_pass"];
                $murid_gambar = $row["murid_gambar"];
                $murid_ic = $row["murid_ic"]; // Assuming murid_ic is the field name in the database for Identification Number
            }
        } else {
            echo "0 results";
        }
        $stmt->close();
        ?>

        <form action="action/edit-profil.php" method="post" class="box-p" autocomplete="off"
            enctype="multipart/form-data">
            <div class="profile-picc">
                <label class="-labell" for="file">
                    <span class="glyphicon glyphicon-camera"></span>
                    <span class="change-image">Change Image</span>
                </label>
                <input id="file" type="file" name="murid_gambar" accept=".jpg, .jpeg, .png"
                    onchange="loadFile(event)" />
                <img src="<?php echo $murid_gambar ? 'img/'.$murid_gambar : 'https://cdn.pixabay.com/photo/2017/08/06/21/01/louvre-2596278_960_720.jpg'; ?>"
                    id="output" width="200" />
            </div>

            <div class="form-group">
                <label class="font-p">Nama:</label>
                <input type="text" id="murid_nama" name="murid_nama" value="<?php echo $murid_nama; ?>">
                <br>
                <label class="font-p">No. Kad Pengenalan:</label>
                <input type="text" placeholder="Sila Masukkan No Kad Pengenalan" id="murid_ic" name="murid_ic"
                    value="<?php echo $murid_ic; ?>">
                <br>
                <label class="font-p">Email:</label>
                <input type="email" id="murid_email" name="murid_email" value="<?php echo $murid_email; ?>">
                <br>
                <label class="font-p">Kata Laluan:</label>
                <input type="text" id="murid_pass" name="murid_pass" value="<?php echo $murid_pass; ?>">
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
</body>

</html>