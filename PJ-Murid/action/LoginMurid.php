<?php
session_start();
include('connect.php');

if (!empty($_POST)) {
    $email = mysqli_real_escape_string($condb, $_POST['email']);
    $password = mysqli_real_escape_string($condb, $_POST['password']);
    
    if (empty($email) || empty($password)) {
        die("<script> alert('Sila Lengkapkan Pendaftaran');
        window.history.back();</script>");
    }

    $arahan_login = "SELECT * FROM murid_acc
                     WHERE murid_email = '$email'
                     AND murid_pass = '$password'
                     LIMIT 1";

    $laksana_login = mysqli_query($condb, $arahan_login);

    if (mysqli_num_rows($laksana_login) == 1) {
        $data = mysqli_fetch_array($laksana_login);
        $_SESSION['murid_nama'] = $data['murid_nama'];
        $_SESSION['murid_id'] = $data['murid_id']; // Store murid_id in session
        echo ("<script> window.location.href = '../../PJ-Murid/Murid/home.php';</script>");
    } else {
        echo ("<script> alert('Gagal');
               window.location.href = '../login-murid.php';</script>");
    }
}

mysqli_close($condb);
?>