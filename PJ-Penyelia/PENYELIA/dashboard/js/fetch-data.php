<?php
// Include file koneksi database
include 'connect.php';

// Pastikan koneksi berhasil
if ($condb->connect_error) {
    die("Koneksi gagal: " . $condb->connect_error);
}

// Query untuk menghitung jumlah total kelas
$query = "SELECT COUNT(*) AS total_kelas FROM kelas";

// Menjalankan query
$result = $condb->query($query);

if ($result->num_rows > 0) {
    // Mengambil hasil query
    $row = $result->fetch_assoc();
    $totalKelas = $row['total_kelas'];
} else {
    $totalKelas = 0; // Jika tidak ada data, setel ke 0
}

// Mengembalikan data sebagai JSON
echo json_encode(array("total_kelas" => $totalKelas));

$condb->close();
?>