<?php 
session_start();
include 'guard-penyelia.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="mpp.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/kelas.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <title>Penyelia • Kelas</title>
    <style>
    .table-row {
        background-color: white;
    }

    .table-row:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table-container {
        overflow-x: auto;
    }

    .swal2-custom-toast {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 15px !important;
        font-weight: bold !important;
        color: black !important;
    }
    </style>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/green.png" alt="sidebar img" class="bg-image">

    <!-- HEADER -->
    <!-- SIDEBAR -->
    <?php include 'includes/sidebar-kelas.php'; ?>
    <?php include 'includes/header-kelas.php'; ?>

    <!-- MAIN -->
    <?php
    include('action/connect.php');
    $result = mysqli_query($condb, "SELECT * FROM kelas");
    ?>

    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: fixed; top: 14%; left:20%">
            TAMBAH KELAS
        </h1>
        <button onclick="document.getElementById('id03').style.display='block'" class="button-plus">
            <span class="text">Tambah</span>
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 8 8" id="plus">
                    <path d="M3 0v3H0v2h3v3h2V5h3V3H5V0H3z"></path>
                </svg>
            </span>
        </button>
        <p>
        <div class="box-l table-container">
            <table id="kelas-table">
                <tr>
                    <th>Bil</th>
                    <th>Nama Guru</th>
                    <th>Nama Kelas</th>
                    <th>Tindakan</th>
                </tr>
                <?php
                $bil = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='table-row' id='row-".$row['kelas_id']."'>";
                    echo "<td>$bil</td>";
                    echo "<td id='guru-".$row['kelas_id']."'>" . htmlspecialchars($row['guru_nama']) . "</td>";
                    echo "<td id='kelas-".$row['kelas_id']."'>" . htmlspecialchars($row['kelas_nama']) . "</td>";
                    echo "<td>
                        <button onclick=\"editKelas('".$row['kelas_id']."', '".htmlspecialchars($row['guru_nama'])."', '".htmlspecialchars($row['kelas_nama'])."')\" class=\"button-edit\">
                            <i class=\"ri-pencil-fill\" style=\"font-size: 26px;\"></i>
                        </button>
                        <button onclick=\"deleteKelas('".$row['kelas_id']."')\" class=\"button-delete\">
                            <i class=\"ri-delete-bin-2-fill\" style=\"font-size: 26px;\"></i>
                        </button>
                    </td>";
                    echo "</tr>";
                    $bil++;
                }
                ?>
            </table>

            <!-- Modal Add -->
            <div id="id03" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">
                    <div class="w3-center"><br>
                        <span onclick="document.getElementById('id03').style.display='none'"
                            class="w3-button w3-xlarge w3-hover-red w3-display-topright"
                            title="Close Modal">&times;</span>
                    </div>
                    <form class="w3-container" id="add-form">
                        <div class="w3-section">
                            <label class="w3-lbl"><b>Nama Guru</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                placeholder="Masukkan nama guru" name="guru_nama" required>
                            <label class="w3-lbl"><b>Kelas</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                placeholder="Masukkan nama kelas" name="kelas_nama" required>
                            <div style="clear: both;"></div>
                            <button class="w3-button w3-section w3-padding" type="submit"
                                style="float: right; background-color: blue;">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Delete-->
            <div id="id01" class="w3-modal">
                <div class="w3-modal-content w3-card-2 w3-animate-zoom" style="width:400px">
                    <div class="w3-center">
                        <span onclick="document.getElementById('id01').style.display='none'"
                            class="w3-button w3-xlarge w3-hover-red w3-display-topright"
                            title="Close Modal">&times;</span>
                        <p>
                            <i class='fas fa-exclamation-triangle'
                                style='font-size:48px; color:red; margin-top:20px;'></i>
                        </p>
                    </div>
                    <form class="w3-container" id="delete-form">
                        <div class="w3-section">
                            <input type="hidden" id="delete-id" name="kelas_id" value="">
                            <label class="danger-lbl"><b>Adakah anda pasti untuk memadam !!</b></label>
                            <div class="button-container">
                                <button class="w3-button w3-red" type="submit">Ya</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit -->
            <div id="id02" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">
                    <div class="w3-center">
                        <span onclick="document.getElementById('id02').style.display='none'"
                            class="w3-button w3-xlarge w3-hover-red w3-display-topright"
                            title="Close Modal">&times;</span>
                    </div>
                    <form class="w3-container" id="edit-form">
                        <div class="w3-section">
                            <input type="hidden" id="edit-id" name="kelas_id" value="">
                            <label class="w3-lbl"><b>Nama Guru</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-nama-guru"
                                name="guru_nama" required>
                            <label class="w3-lbl"><b>Nama Kelas</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-nama-kelas"
                                name="kelas_nama" required>
                            <div style="clear: both;"></div>
                            <button class="w3-button w3-section w3-padding" type="submit"
                                style="float: right; background-color: green;">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
    </main>

    <script>
    function editKelas(kelas_id, guru_nama, kelas_nama) {
        document.getElementById('id02').style.display = 'block';
        document.getElementById('edit-id').value = kelas_id;
        document.getElementById('edit-nama-guru').value = guru_nama;
        document.getElementById('edit-nama-kelas').value = kelas_nama;
    }

    function deleteKelas(kelas_id) {
        document.getElementById('id01').style.display = 'block';
        document.getElementById('delete-id').value = kelas_id;
    }

    document.getElementById('edit-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        fetch('action/edit-kelas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response
                if (data.status === 'success') {
                    var id = document.getElementById('edit-id').value;
                    document.getElementById('guru-' + id).textContent = document.getElementById(
                        'edit-nama-guru').value;
                    document.getElementById('kelas-' + id).textContent = document.getElementById(
                        'edit-nama-kelas').value;
                    document.getElementById('id02').style.display = 'none';
                    Swal.fire({
                        icon: 'success',
                        title: 'Berjaya',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'swal2-custom-toast'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error(error); // Log any error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    });

    document.getElementById('delete-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        fetch('action/delete-kelas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response
                if (data.status === 'success') {
                    var id = document.getElementById('delete-id').value;
                    document.getElementById('row-' + id).remove();
                    document.getElementById('id01').style.display = 'none';
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'swal2-custom-toast'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error(error); // Log any error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    });

    document.getElementById('add-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        fetch('action/tambah-kelas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response
                if (data.status === 'success') {
                    var newRow = document.createElement('tr');
                    var newId = data.new_id; // Assuming the server returns the new id
                    var guruNama = formData.get('guru_nama');
                    var kelasNama = formData.get('kelas_nama');
                    var bil = document.getElementById('kelas-table').rows.length;

                    newRow.className = 'table-row';
                    newRow.id = 'row-' + newId;
                    newRow.innerHTML = `
                    <td>${bil}</td>
                    <td id="guru-${newId}">${guruNama}</td>
                    <td id="kelas-${newId}">${kelasNama}</td>
                    <td>
                        <button onclick="editKelas('${newId}', '${guruNama}', '${kelasNama}')" class="button-edit">
                            <i class="ri-pencil-fill" style="font-size: 26px;"></i>
                        </button>
                        <button onclick="deleteKelas('${newId}')" class="button-delete">
                            <i class="ri-delete-bin-2-fill" style="font-size: 26px;"></i>
                        </button>
                    </td>
                `;
                    document.getElementById('kelas-table').appendChild(newRow);

                    document.getElementById('id03').style.display = 'none';
                    Swal.fire({
                        icon: 'success',
                        title: 'Berjaya',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'swal2-custom-toast'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error(error); // Log any error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    });
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>