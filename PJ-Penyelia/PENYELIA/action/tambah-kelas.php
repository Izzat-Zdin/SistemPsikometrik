<?php
include('connect.php');

header('Content-Type: application/json');

$response = array();

if (!empty($_POST)) {
    $kelas_nama = mysqli_real_escape_string($condb, $_POST['kelas_nama']);
    $guru_nama = mysqli_real_escape_string($condb, $_POST['guru_nama']);

    if (empty($kelas_nama)) {
        $response['status'] = 'error';
        $response['message'] = 'Please complete the class name';
    } else {
        $sql = "INSERT INTO kelas (kelas_nama, guru_nama) VALUES ('$kelas_nama', '$guru_nama')";

        if (mysqli_query($condb, $sql)) {
            $response['status'] = 'success';
            $response['message'] = 'Kelas Berjaya ditambah';
            $response['new_id'] = mysqli_insert_id($condb); // Return new id
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add class: ' . mysqli_error($condb); // Include the SQL error
        }
    }

    echo json_encode($response);
    exit();
}

mysqli_close($condb);
?>