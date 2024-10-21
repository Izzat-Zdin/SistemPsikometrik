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

if(!empty($_POST)) {
    $jadual = "guru_acc";
    $fullname = mysqli_real_escape_string($condb, $_POST['guru_nama']);
    $email = mysqli_real_escape_string($condb, $_POST['guru_email']);
    $password = mysqli_real_escape_string($condb, $_POST['guru_pass']);
    $kelas_id = mysqli_real_escape_string($condb, $_POST['kelas']); // Changed to kelas_id
    
    if(empty($fullname) or empty($password) or empty($email) or empty($kelas_id)) {
        die("<script> alert('Sila Lengkapkan Pendaftaran');
        window.history.back();</script>");
    }
    
    $simpan = "INSERT INTO guru_acc (guru_nama, guru_email, guru_pass, kelas_id) 
               VALUES ('$fullname', '$email', '$password', '$kelas_id')";
    
    if(mysqli_query($condb, $simpan)) {
        echo ("<script> alert('berjaya');
        window.location.href = '../login-guru.php';</script>");
    } else {
        echo "<script>alert('gagal')</script>";
    }
    
    $arahanpenyewa = "SELECT * FROM guru_acc
                      WHERE guru_acc.guru_email = '".$_SESSION['guru_email']."'
                      ORDER BY guru_acc.guru_nama ASC";
    
    $laksanapenyewa = mysqli_query($condb, $arahanpenyewa);
    
    while($data = mysqli_fetch_array($laksanapenyewa)) {
        $dataguru = array(
            'guru_nama' => $data['guru_nama'],
            'guru_email' => $data['guru_email'],
            'guru_pass' => $data['guru_pass'],
            'kelas_id' => $data['kelas_id'],
        );
    }
}

include('SignUpGuru.html');
?>