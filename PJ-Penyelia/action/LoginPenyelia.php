<?php
session_start();
include('connect.php');

if (!empty($_POST)) {
    $email = mysqli_real_escape_string($condb, $_POST['email']);
    $password = mysqli_real_escape_string($condb, $_POST['password']);

    if (empty($email) or empty($password)) {
        die("<script> alert('Sila lengkapkan pendaftaran.');
             window.history.back();</script>");
    }

    $arahan_login = "SELECT * FROM penyelia_acc
                     WHERE
                     penyelia_email = '$email'
                     AND penyelia_pass = '$password'
                     LIMIT 1";

    $laksana_login = mysqli_query($condb, $arahan_login);

    if (mysqli_num_rows($laksana_login) == 1) {
        $data = mysqli_fetch_array($laksana_login);
        $_SESSION['penyelia_id'] = $data['penyelia_id'];
        $_SESSION['penyelia_nama'] = $data['penyelia_nama'];
        echo ("<script> window.location.href = '../Penyelia/home.php';</script>");
    } else {
        echo ("<script> alert('Gagal log masuk.');
               window.location.href = '../../PJ-Guru/login-guru.php';</script>");
    }
}

mysqli_close($condb);
?>