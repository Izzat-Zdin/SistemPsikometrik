<?php
include('connect.php');

function getKelasOptions($condb) {
    $kelasOptions = "";
    $kelasQuery = "SELECT kelas_id, kelas_nama FROM kelas";
    $result = mysqli_query($condb, $kelasQuery);
    while ($row = mysqli_fetch_assoc($result)) {
        $kelasOptions .= "<option value='" . $row['kelas_id'] . "'>" . $row['kelas_nama'] . "</option>";
    }
    return $kelasOptions;
}

if (!empty($_POST)) {
    $jadual = "murid_acc";
    $fullname = mysqli_real_escape_string($condb, $_POST['murid_nama']);
    $email = mysqli_real_escape_string($condb, $_POST['murid_email']);
    $password = mysqli_real_escape_string($condb, $_POST['murid_pass']);
    $kelas_id = mysqli_real_escape_string($condb, $_POST['kelas']); // Changed to kelas_id

    if (empty($fullname) || empty($password) || empty($email) || empty($kelas_id)) {
        die("<script> alert('Sila Lengkapkan Pendaftaran');
        window.history.back();</script>");
    }

    // Check if kelas_id exists in the kelas table
    $kelasCheck = "SELECT kelas_id FROM kelas WHERE kelas_id = '$kelas_id'";
    $result = mysqli_query($condb, $kelasCheck);
    
    if (mysqli_num_rows($result) == 0) {
        die("<script> alert('Invalid Kelas ID');
        window.history.back();</script>");
    }

    $simpan = "INSERT INTO murid_acc (murid_nama, murid_email, murid_pass, kelas_id)
               VALUES ('$fullname', '$email', '$password', '$kelas_id')"; // Insert into kelas_id

    if (mysqli_query($condb, $simpan)) {
        echo ("<script> alert('berjaya');
        window.location.href = '../login-murid.php';</script>");
    } else {
        echo "<script>alert('Error: " . mysqli_error($condb) . "');</script>";
    }
}

include('SignUpGuru.html');
?>