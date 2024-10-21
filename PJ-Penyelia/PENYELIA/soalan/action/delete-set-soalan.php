<?php
include('connect.php');

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ex_id = mysqli_real_escape_string($condb, $_POST['ex_id']);

    // Begin transaction
    mysqli_begin_transaction($condb);

    try {
        // Delete related records from exam_soalan
        $sql_delete_soalan = "DELETE FROM exam_soalan WHERE ex_id = '$ex_id'";
        if (!mysqli_query($condb, $sql_delete_soalan)) {
            throw new Exception(mysqli_error($condb));
        }

        // Delete the record from exam_set
        $sql_delete_set = "DELETE FROM exam_set WHERE ex_id = '$ex_id'";
        if (!mysqli_query($condb, $sql_delete_set)) {
            throw new Exception(mysqli_error($condb));
        }

        // Commit transaction
        mysqli_commit($condb);

        $response['status'] = 'success';
        $response['message'] = 'Rekod berjaya dipadam!!';
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        mysqli_rollback($condb);
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit();
}

mysqli_close($condb);
?>