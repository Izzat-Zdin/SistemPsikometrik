<?php
include('connect.php');

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ex_id = mysqli_real_escape_string($condb, $_POST['ex_id']);
    $ex_guru = mysqli_real_escape_string($condb, $_POST['ex_guru']);
    $kelas_id = mysqli_real_escape_string($condb, $_POST['kelas_id']);
    $ex_tajuk = mysqli_real_escape_string($condb, $_POST['ex_tajuk']);
    $ex_desc = mysqli_real_escape_string($condb, $_POST['ex_desc']);
    $ex_tarikh = mysqli_real_escape_string($condb, $_POST['ex_tarikh']);
    $ex_minit = mysqli_real_escape_string($condb, $_POST['ex_minit']);

    $sql = "UPDATE exam_set 
            SET ex_guru='$ex_guru', kelas_id='$kelas_id', ex_tajuk='$ex_tajuk', ex_desc='$ex_desc', ex_tarikh='$ex_tarikh', ex_minit='$ex_minit' 
            WHERE ex_id='$ex_id'";

    if (mysqli_query($condb, $sql)) {
        $kelasQuery = mysqli_query($condb, "SELECT kelas_nama FROM kelas WHERE kelas_id = '$kelas_id'");
        $kelasData = mysqli_fetch_assoc($kelasQuery);
        $kelas_nama = $kelasData['kelas_nama'];

        $response['status'] = 'success';
        $response['message'] = 'Data berjaya dikemaskini';
        $response['updated_data'] = array(
            'ex_guru' => $ex_guru,
            'kelas_id' => $kelas_id,
            'kelas_nama' => $kelas_nama,
            'ex_tajuk' => $ex_tajuk,
            'ex_desc' => $ex_desc,
            'ex_tarikh' => $ex_tarikh,
            'ex_minit' => $ex_minit
        );
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . mysqli_error($condb);
    }

    echo json_encode($response);
    exit();
}

mysqli_close($condb);
?>