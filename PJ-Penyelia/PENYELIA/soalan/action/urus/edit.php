<?php
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $soalan_id = $_POST['soalan_id'];
    $tajuk = $_POST['tajuk'];
    $soalan = $_POST['soalan'];
    $exam_jawapan = $_POST['exam_jawapan'];
    $pilihan_1 = $_POST['pilihan_1'];
    $pilihan_2 = $_POST['pilihan_2'];
    $pilihan_3 = $_POST['pilihan_3'];
    $pilihan_4 = $_POST['pilihan_4'];

    $query = "UPDATE exam_soalan SET 
        tajuk='$tajuk',
        soalan='$soalan',
        exam_jawapan='$exam_jawapan',
        pilihan_1='$pilihan_1',
        pilihan_2='$pilihan_2',
        pilihan_3='$pilihan_3',
        pilihan_4='$pilihan_4' 
        WHERE soalan_id='$soalan_id'";

    if (mysqli_query($condb, $query)) {
        echo "<script>alert('Rekod berjaya dikemaskini'); window.location.href = '../../urus-soalan.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($condb);
    }
}
?>