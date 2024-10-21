<?php
include('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['murid_id'])) {
        $murid_id = $_SESSION['murid_id'];
        $murid_nama = mysqli_real_escape_string($condb, $_POST['murid_nama']);
        $murid_ic = mysqli_real_escape_string($condb, $_POST['murid_ic']);
        $murid_email = mysqli_real_escape_string($condb, $_POST['murid_email']);
        $murid_pass = mysqli_real_escape_string($condb, $_POST['murid_pass']);

        // Initialize variable to hold the new image name
        $murid_gambar = '';

        // Fetch existing image name
        $sql = "SELECT murid_gambar FROM murid_acc WHERE murid_id = ?";
        $stmt = $condb->prepare($sql);
        $stmt->bind_param("i", $murid_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existing_image = $row['murid_gambar'];
        } else {
            $existing_image = '';
        }
        $stmt->close();

        // Handle file upload
        if (!empty($_FILES['murid_gambar']['name'])) {
            $target_dir = "../img-profil/$murid_id/";

            // Create directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . basename($_FILES["murid_gambar"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES["murid_gambar"]["tmp_name"]);
            if ($check !== false) {
                // Delete the old image if it exists
                if ($existing_image && file_exists($target_dir . $existing_image)) {
                    unlink($target_dir . $existing_image);
                }

                // Move the new image to the directory
                if (move_uploaded_file($_FILES["murid_gambar"]["tmp_name"], $target_file)) {
                    $murid_gambar = "$murid_id/" . basename($_FILES["murid_gambar"]["name"]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        } else {
            $murid_gambar = $existing_image; // Keep the old image if no new image is uploaded
        }

        if ($murid_gambar) {
            $sql = "UPDATE murid_acc SET murid_nama='$murid_nama', murid_ic='$murid_ic', murid_email='$murid_email', murid_pass='$murid_pass', murid_gambar='$murid_gambar' WHERE murid_id='$murid_id'";
        } else {
            $sql = "UPDATE murid_acc SET murid_nama='$murid_nama', murid_ic='$murid_ic', murid_email='$murid_email', murid_pass='$murid_pass' WHERE murid_id='$murid_id'";
        }

        if (mysqli_query($condb, $sql)) {
            echo "<script>
                    alert('Rekop berjaya dikemaskini');
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