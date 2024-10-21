<?php
include('connect.php');

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch and sanitize input data
    $ex_guru = mysqli_real_escape_string($condb, $_POST['ex_guru']);
    $kelas_id = mysqli_real_escape_string($condb, $_POST['kelas_id']);
    $ex_tajuk = mysqli_real_escape_string($condb, $_POST['ex_tajuk']);
    $ex_desc = mysqli_real_escape_string($condb, $_POST['ex_desc']);
    $ex_tarikh = mysqli_real_escape_string($condb, $_POST['ex_tarikh']);
    $ex_minit = mysqli_real_escape_string($condb, $_POST['ex_minit']);

    // Prepare an SQL statement for execution
    $stmt = $condb->prepare("INSERT INTO exam_set (ex_guru, kelas_id, ex_tajuk, ex_desc, ex_tarikh, ex_minit) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("ssssss", $ex_guru, $kelas_id, $ex_tajuk, $ex_desc, $ex_tarikh, $ex_minit);

    // Execute the statement
    if ($stmt->execute()) {
        // Fetch the class name for the inserted record
        $kelasQuery = mysqli_query($condb, "SELECT kelas_nama FROM kelas WHERE kelas_id = '$kelas_id'");
        $kelasData = mysqli_fetch_assoc($kelasQuery);
        $kelas_nama = $kelasData['kelas_nama'];

        $response['status'] = 'success';
        $response['message'] = 'Rekod berjaya dikemaskini';
        $response['new_id'] = $stmt->insert_id; // Return new id
        $response['new_data'] = array(
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
        $response['message'] = 'Failed to create new record';
    }

    // Close the statement and the database connection
    $stmt->close();
    $condb->close();

    echo json_encode($response);
    exit();
}
?>