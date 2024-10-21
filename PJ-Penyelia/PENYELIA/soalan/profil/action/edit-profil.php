<?php
include('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['penyelia_id'])) {
        $penyelia_id = $_SESSION['penyelia_id']; // Assuming penyelia_id is stored in session
        $penyelia_nama = mysqli_real_escape_string($condb, $_POST['penyelia_nama']);
        $penyelia_email = mysqli_real_escape_string($condb, $_POST['penyelia_email']);
        $penyelia_pass = mysqli_real_escape_string($condb, $_POST['penyelia_pass']);
        
        // Handle file upload
        $penyelia_gambar = '';
        if (!empty($_FILES['penyelia_gambar']['name'])) {
            $target_dir = "../img-profil/$penyelia_id/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Create directory if it does not exist
            }
            $original_file_name = basename($_FILES["penyelia_gambar"]["name"]);
            $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
            $target_file = $target_dir . $original_file_name;

            // Check if file is an actual image
            $check = getimagesize($_FILES["penyelia_gambar"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["penyelia_gambar"]["tmp_name"], $target_file)) {
                    $penyelia_gambar = $penyelia_id . '/' . $original_file_name;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        }

        if ($penyelia_gambar) {
            $sql = "UPDATE penyelia_acc SET penyelia_nama='$penyelia_nama', penyelia_email='$penyelia_email', penyelia_pass='$penyelia_pass', penyelia_gambar='$penyelia_gambar' WHERE penyelia_id='$penyelia_id'";
        } else {
            $sql = "UPDATE penyelia_acc SET penyelia_nama='$penyelia_nama', penyelia_email='$penyelia_email', penyelia_pass='$penyelia_pass' WHERE penyelia_id='$penyelia_id'";
        }

        if (mysqli_query($condb, $sql)) {
            $_SESSION['update_success'] = "Rekod berjaya dikemasini";
            header("Location: ../profil.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($condb);
        }

        mysqli_close($condb);
    } else {
        echo "penyelia_id not found in session.";
    }
}
?>