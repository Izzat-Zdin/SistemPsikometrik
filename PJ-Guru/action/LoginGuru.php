<?php
session_start();
include('connect.php');

if(!empty($_POST))
    {
        $email = mysqli_real_escape_string($condb, $_POST['email']);
        $password = mysqli_real_escape_string($condb, $_POST['password']);
    if(empty($email) or empty($password))
    {
        die("<script> alert(' Sila Lengkapkan Pendaftaran ');
        window.history.back();</script>");
    }

    $arahan_login = "SELECT * FROM guru_acc
                     WHERE
                     guru_email = '$email'
                     AND guru_pass = '$password'
                     LIMIT 1";

    $laksana_login = mysqli_query($condb, $arahan_login);

    if (mysqli_num_rows($laksana_login) == 1) {
        $data = mysqli_fetch_array($laksana_login);
        $_SESSION['guru_id'] = $data['guru_id']; // Added this line to set guru_id in the session
        $_SESSION['guru_nama'] = $data['guru_nama'];
        echo ("<script> window.location.href = '../GURU/home.php';</script>");
    } else {
        echo ("<script> alert('Gagal ');
               window.location.href = '../login-guru.php';</script>");
    }
}

mysqli_close($condb);
?>