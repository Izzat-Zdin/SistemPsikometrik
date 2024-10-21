<?php
include('connect.php');
session_start();

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kelas_id = mysqli_real_escape_string($condb, $_POST['kelas_id']);
    $kelas_nama = mysqli_real_escape_string($condb, $_POST['kelas_nama']);
    $guru_nama = mysqli_real_escape_string($condb, $_POST['guru_nama']);

    $sql = "UPDATE kelas SET kelas_nama='$kelas_nama', guru_nama='$guru_nama' WHERE kelas_id='$kelas_id'";

    if (mysqli_query($condb, $sql)) {
        $response['status'] = 'success';
        $response['message'] = 'Rekod berjaya dikemaskini';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $sql . '<br>' . mysqli_error($condb);
    }

    mysqli_close($condb);
    echo json_encode($response);
    exit();
}
?>