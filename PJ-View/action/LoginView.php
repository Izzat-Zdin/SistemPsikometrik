<?php
session_start();
include('connect.php');

if (!empty($_POST)) {
    // Use a single variable for murid_ic
    $murid_ic = mysqli_real_escape_string($condb, $_POST['murid_ic']);
    
    if (empty($murid_ic)) {
        die("<script> alert('Sila Lengkapkan Pendaftaran');
        window.history.back();</script>");
    }

    // Update the SQL query to match murid_ic for both email and password
    $arahan_login = "SELECT * FROM murid_acc
                     WHERE murid_ic = '$murid_ic'
                     LIMIT 1";

    $laksana_login = mysqli_query($condb, $arahan_login);

    if (mysqli_num_rows($laksana_login) == 1) {
        $data = mysqli_fetch_array($laksana_login);
        $_SESSION['murid_nama'] = $data['murid_nama'];
        $_SESSION['murid_id'] = $data['murid_id']; // Store murid_id in session
        echo ("<script> window.location.href = '../View/home.php';</script>");
    } else {
        echo ("<script> alert('Gagal');
               window.location.href = '../login-view.php';</script>");
    }
}

mysqli_close($condb);
?>