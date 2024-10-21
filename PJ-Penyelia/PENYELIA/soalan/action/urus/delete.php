<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../connect.php');

if (!empty($_POST['soalan_id'])) {
    // Escape the input to prevent SQL injection
    $soalan_id = mysqli_real_escape_string($condb, $_POST['soalan_id']);

    // Begin a transaction
    mysqli_begin_transaction($condb);

    try {
        // SQL query to delete related rows in exam_jawapan
        $delete_related = "DELETE FROM exam_jawapan WHERE soalan_id = '$soalan_id'";
        mysqli_query($condb, $delete_related);

        // SQL query to delete the row in exam_soalan
        $delete = "DELETE FROM exam_soalan WHERE soalan_id = '$soalan_id'";
        mysqli_query($condb, $delete);

        // Commit the transaction
        mysqli_commit($condb);

        // Redirect with success message
        echo "<script> alert('Berjaya padam'); window.location.href = '../../urus-soalan.php'; </script>";
    } catch (mysqli_sql_exception $exception) {
        // Rollback the transaction on error
        mysqli_rollback($condb);

        // Redirect with error message
        echo "<script> alert('Gagal padam'); window.history.back(); </script>";
    }
} else {
    echo "<script> alert('ID soalan tidak diberikan'); window.history.back(); </script>";
}
?>