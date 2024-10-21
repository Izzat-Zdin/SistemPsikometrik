<?php
include('connect.php');

header('Content-Type: application/json');

$response = array();

if (!empty($_POST['kelas_id'])) {
    $kelas_id = mysqli_real_escape_string($condb, $_POST['kelas_id']);

    $delete = "DELETE FROM kelas WHERE kelas_id = '$kelas_id'";

    if (mysqli_query($condb, $delete)) {
        $response['status'] = 'success';
        $response['message'] = 'Record deleted successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete record';
    }

    echo json_encode($response);
    exit();
}