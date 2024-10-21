<?php
include('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['murid_id'])) {
        $murid_id = $_SESSION['murid_id']; // Assuming murid_id is stored in session
        $murid_nama = mysqli_real_escape_string($condb, $_POST['murid_nama']);
        $murid_ic = mysqli_real_escape_string($condb, $_POST['murid_ic']);
        $murid_email = mysqli_real_escape_string($condb, $_POST['murid_email']);
        $murid_pass = mysqli_real_escape_string($condb, $_POST['murid_pass']);
        
        // Handle file upload
        $murid_gambar = '';
        if (!empty($_FILES['murid_gambar']['name'])) {
            $target_dir = "../img/";
            $target_file = $target_dir . basename($_FILES["murid_gambar"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES["murid_gambar"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["murid_gambar"]["tmp_name"], $target_file)) {
                    $murid_gambar = basename($_FILES["murid_gambar"]["name"]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        }

        if ($murid_gambar) {
            $sql = "UPDATE murid_acc SET murid_nama='$murid_nama', murid_ic='$murid_ic', murid_email='$murid_email', murid_pass='$murid_pass', murid_gambar='$murid_gambar' WHERE murid_id='$murid_id'";
        } else {
            $sql = "UPDATE murid_acc SET murid_nama='$murid_nama', murid_ic='$murid_ic', murid_email='$murid_email', murid_pass='$murid_pass' WHERE murid_id='$murid_id'";
        }

        if (mysqli_query($condb, $sql)) {
            echo "<script>
                    alert('Record updated successfully');
                    window.location.href = '../profil.php';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($condb);
        }

        mysqli_close($condb);
    } else {
        echo "murid_id not found in session.";
    }
}
?>