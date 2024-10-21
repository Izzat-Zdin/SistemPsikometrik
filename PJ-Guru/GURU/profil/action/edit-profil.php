<?php
include('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['guru_id'])) {
        $guru_id = $_SESSION['guru_id']; // Assuming guru_id is stored in session
        $guru_nama = mysqli_real_escape_string($condb, $_POST['guru_nama']);
        $guru_email = mysqli_real_escape_string($condb, $_POST['guru_email']);
        $guru_pass = mysqli_real_escape_string($condb, $_POST['guru_pass']);
        $guru_ic = mysqli_real_escape_string($condb, $_POST['guru_ic']);
        
        // Handle file upload
        $guru_gambar = '';
        if (!empty($_FILES['guru_gambar']['name'])) {
            $target_dir = "../img-profil/$guru_id/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Create directory if it does not exist
            }
            $original_file_name = basename($_FILES["guru_gambar"]["name"]);
            $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
            $target_file = $target_dir . $original_file_name;

            // Check if file is an actual image
            $check = getimagesize($_FILES["guru_gambar"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["guru_gambar"]["tmp_name"], $target_file)) {
                    $guru_gambar = $guru_id . '/' . $original_file_name;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        }

        if ($guru_gambar) {
            $sql = "UPDATE guru_acc SET guru_nama='$guru_nama', guru_email='$guru_email', guru_pass='$guru_pass', guru_ic='$guru_ic', guru_gambar='$guru_gambar' WHERE guru_id='$guru_id'";
        } else {
            $sql = "UPDATE guru_acc SET guru_nama='$guru_nama', guru_email='$guru_email', guru_pass='$guru_pass', guru_ic='$guru_ic' WHERE guru_id='$guru_id'";
        }

        if (mysqli_query($condb, $sql)) {
            $_SESSION['update_success'] = "Rekod berjaya dikemaskini";
            header("Location: ../profil.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($condb);
        }

        mysqli_close($condb);
    } else {
        echo "guru_id not found in session.";
    }
}
?>