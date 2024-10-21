<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../mpp.png">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="assets/css/soalan.css">
    <link rel="stylesheet" href="assets/css/tambah-kelas.css">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Penyelia • Soalan</title>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/green.png" alt="sidebar img" class="bg-image">

    <!--=============== SIDEBAR ===============-->
    <?php include 'includes/sidebar-soalan.php'; ?>
    <!--=============== HEADER ===============-->
    <?php include 'includes/header-soalan.php'; ?>

    <!--=============== MAIN ===============-->
    <?php
    include('action/connect.php');
    session_start();
    $result = mysqli_query($condb, "SELECT * FROM exam_set");
    $kelasResult = mysqli_query($condb, "SELECT kelas_id, kelas_nama FROM kelas");
    $guruResult = mysqli_query($condb, "SELECT DISTINCT guru_nama FROM kelas");
    ?>

    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: fixed; top: 14%; left:20%">
            SET SOALAN</h1>
        <br>
        <br><br>
        <button onclick="document.getElementById('id01').style.display='block'" class="button-plus-soalan"
            style="font-family: 'Montserrat', sans-serif; width: 18%;">
            <span class="text" style="font-family: 'Montserrat', sans-serif;">Tambah Set Soalan</span>
            <span class="icon" style="font-family: 'Montserrat', sans-serif; position:absolute; left: 21.4%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 8 8" id="plus">
                    <path d="M3 0v3H0v2h3v3h2V5h3V3H5V0H3z"></path>
                </svg>
            </span>
        </button>

        <div class="box-l" style="font-family: 'Montserrat', sans-serif; font-size:17px;">
            <table id="exam-set-table">
                <tr>
                    <th>Bil</th>
                    <th>Nama Guru</th>
                    <th>Nama Kelas</th>
                    <th>Topik</th>
                    <th>Arahan</th>
                    <th>Tarikh</th>
                    <th>Masa</th>
                    <th>Tindakan</th>
                </tr>
                <?php
                $bil = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $kelasQuery = mysqli_query($condb, "SELECT kelas_nama FROM kelas WHERE kelas_id = '".$row['kelas_id']."'");
                    $kelasData = mysqli_fetch_assoc($kelasQuery);
                    echo "<tr class='f-1' id='row-" . $row['ex_id'] . "'>";
                    echo "<td>$bil</td>";
                    echo "<td id='guru-" . $row['ex_id'] . "'>" . htmlspecialchars($row['ex_guru']) . "</td>";
                    echo "<td id='kelas-" . $row['ex_id'] . "'>" . htmlspecialchars($kelasData['kelas_nama']) . "</td>";
                    echo "<td id='tajuk-" . $row['ex_id'] . "'>" . htmlspecialchars($row['ex_tajuk']) . "</td>";
                    echo "<td id='desc-" . $row['ex_id'] . "'>" . htmlspecialchars($row['ex_desc']) . "</td>";
                    echo "<td id='tarikh-" . $row['ex_id'] . "'>" . htmlspecialchars($row['ex_tarikh']) . "</td>";
                    echo "<td id='minit-" . $row['ex_id'] . "'>" . htmlspecialchars($row['ex_minit']) . " Minit</td>";
                    echo "<td>
                        <button onclick=\"document.getElementById('id02').style.display='block';document.getElementById('delete-id').value='" . $row['ex_id'] . "'\" class=\"button-delete\">
                            <i class=\"ri-delete-bin-2-fill\" style=\"font-size: 26px;\"></i>
                        </button>
                        <button onclick=\"document.getElementById('id03').style.display='block';document.getElementById('edit-id').value='" . $row['ex_id'] . "';document.getElementById('edit-guru').value='" . htmlspecialchars($row['ex_guru']) . "';document.getElementById('edit-kelas').value='" . htmlspecialchars($row['kelas_id']) . "';document.getElementById('edit-tajuk').value='" . htmlspecialchars($row['ex_tajuk']) . "';document.getElementById('edit-desc').value='" . htmlspecialchars($row['ex_desc']) . "';document.getElementById('edit-tarikh').value='" . htmlspecialchars($row['ex_tarikh']) . "';document.getElementById('edit-minit').value='" . htmlspecialchars($row['ex_minit']) . "';\" class=\"button-edit\">
                            <i class=\"ri-pencil-fill\" style=\"font-size: 26px;\"></i>
                        </button>
                    </td>";
                    echo "</tr>";
                    $bil++;
                }
                ?>
            </table>
        </div>

        <!-- Modal Add -->
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">
                <div class="w3-center"><br>
                    <span onclick="document.getElementById('id01').style.display='none'"
                        class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                </div>
                <div class="w3-container" style="padding: 20px; font-weight:500; color:black;">
                    <form id="add-form" action="action/set-soalan.php" method="POST">
                        <div class="input-area">
                            <label class="label-kelas"><b>Nama Guru</b></label>
                            <select class="w3-input w3-border w3-margin-bottom" name="ex_guru" required>
                                <option value="" disabled selected>Pilih Nama Guru</option>
                                <?php while ($guru = mysqli_fetch_assoc($guruResult)) { ?>
                                <option value="<?php echo htmlspecialchars($guru['guru_nama']); ?>">
                                    <?php echo htmlspecialchars($guru['guru_nama']); ?></option>
                                <?php } ?>
                            </select>
                            <label class="label-kelas"><b>Nama Kelas</b></label>
                            <select class="w3-input w3-border w3-margin-bottom" name="kelas_id" required>
                                <option value="" disabled selected>Pilih Nama Kelas</option>
                                <?php while ($kelas = mysqli_fetch_assoc($kelasResult)) { ?>
                                <option value="<?php echo $kelas['kelas_id']; ?>">
                                    <?php echo htmlspecialchars($kelas['kelas_nama']); ?></option>
                                <?php } ?>
                            </select>
                            <label class="label-kelas"><b>Topik</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Masukkan Topik"
                                name="ex_tajuk" required>
                            <label class="label-kelas"><b>Arahan</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Masukkan Arahan"
                                name="ex_desc" required>
                            <label class="label-kelas"><b>Tarikh</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="date" name="ex_tarikh" required>
                            <label class="label-kelas"><b>Masa (Masa untuk menjawab)</b></label>
                            <div class="timer-inputs">
                                <input class="w3-input w3-border" type="number" name="ex_minit" placeholder="Minit"
                                    min="0" max="120" required>
                            </div>
                            <button class="w3-button w3-block" type="submit"
                                style="background-color: #4CAF50; color: white; margin-top: 20px;">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Additional CSS for custom styling -->
        <style>
        .timer-inputs {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .timer-inputs input {
            flex: 1;
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        </style>

        <!-- Modal Delete -->
        <div id="id02" class="w3-modal">
            <div class="w3-modal-content w3-card-2 w3-animate-zoom kotak-putih" style="width:400px">
                <div class="w3-center">
                    <span onclick="document.getElementById('id02').style.display='none'"
                        class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                    <p>
                        <i class='fas fa-exclamation-triangle' style='font-size:48px; color:red; margin-top:20px;'></i>
                    </p>
                </div>
                <form id="delete-form" class="w3-container" action="action/delete-set-soalan.php" method="POST">
                    <div class="w3-section">
                        <input type="hidden" id="delete-id" name="ex_id" value="">
                        <label class="danger-lbl"><b>Adakah anda pasti untuk memadam !!</b></label>
                        <div class="button-container">
                            <button class="w3-button w3-red yes-button" type="submit">Ya</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="id03" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">
                <div class="w3-center"><br>
                    <span onclick="document.getElementById('id03').style.display='none'"
                        class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                </div>
                <div class="w3-container" style="padding: 20px; font-weight:500; color:black;">
                    <form id="edit-form" action="action/edit-set-soalan.php" method="POST">
                        <div class="input-area">
                            <input type="hidden" id="edit-id" name="ex_id" value="">
                            <label class="label-kelas"><b>Nama Guru</b></label>
                            <select class="w3-input w3-border w3-margin-bottom" id="edit-guru" name="ex_guru" required>
                                <?php
                                mysqli_data_seek($guruResult, 0);
                                while ($guru = mysqli_fetch_assoc($guruResult)) { ?>
                                <option value="<?php echo htmlspecialchars($guru['guru_nama']); ?>">
                                    <?php echo htmlspecialchars($guru['guru_nama']); ?></option>
                                <?php } ?>
                            </select>
                            <label class="label-kelas"><b>Nama Kelas</b></label>
                            <select class="w3-input w3-border w3-margin-bottom" id="edit-kelas" name="kelas_id"
                                required>
                                <?php
                                mysqli_data_seek($kelasResult, 0);
                                while ($kelas = mysqli_fetch_assoc($kelasResult)) { ?>
                                <option value="<?php echo $kelas['kelas_id']; ?>">
                                    <?php echo htmlspecialchars($kelas['kelas_nama']); ?></option>
                                <?php } ?>
                            </select>
                            <label class="label-kelas"><b>Topik</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-tajuk"
                                placeholder="Masukkan Topik" name="ex_tajuk" required>
                            <label class="label-kelas"><b>Arahan</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-desc"
                                placeholder="Masukkan Arahan" name="ex_desc" required>
                            <label class="label-kelas"><b>Tarikh</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="date" id="edit-tarikh"
                                name="ex_tarikh" required>
                            <label class="label-kelas"><b>Masa</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-minit"
                                name="ex_minit" placeholder="Minit" required>
                            <button class="w3-button w3-block" type="submit"
                                style="background-color: #4CAF50; color: white; margin-top: 20px;">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="../assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>
    <script>
    document.getElementById('add-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        fetch('action/set-soalan.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json()).then(data => {
            if (data.status === 'success') {
                const newRow = document.createElement('tr');
                newRow.classList.add('f-1');
                newRow.id = 'row-' + data.new_id;
                newRow.innerHTML = `
                    <td></td>
                    <td id='guru-${data.new_id}'>${data.new_data.ex_guru}</td>
                    <td id='kelas-${data.new_id}'>${data.new_data.kelas_nama}</td>
                    <td id='tajuk-${data.new_id}'>${data.new_data.ex_tajuk}</td>
                    <td id='desc-${data.new_id}'>${data.new_data.ex_desc}</td>
                    <td id='tarikh-${data.new_id}'>${data.new_data.ex_tarikh}</td>
                    <td id='minit-${data.new_id}'>${data.new_data.ex_minit} Minit</td>
                    <td>
                        <button onclick="document.getElementById('id02').style.display='block';document.getElementById('delete-id').value='${data.new_id}'" class="button-delete">
                            <i class="ri-delete-bin-2-fill" style="font-size: 26px;"></i>
                        </button>
                        <button onclick="document.getElementById('id03').style.display='block';document.getElementById('edit-id').value='${data.new_id}';document.getElementById('edit-guru').value='${data.new_data.ex_guru}';document.getElementById('edit-kelas').value='${data.new_data.kelas_id}';document.getElementById('edit-tajuk').value='${data.new_data.ex_tajuk}';document.getElementById('edit-desc').value='${data.new_data.ex_desc}';document.getElementById('edit-tarikh').value='${data.new_data.ex_tarikh}';document.getElementById('edit-minit').value='${data.new_data.ex_minit}';" class="button-edit">
                            <i class="ri-pencil-fill" style="font-size: 26px;"></i>
                        </button>
                    </td>
                `;
                document.querySelector('#exam-set-table').appendChild(newRow);
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
                document.querySelector('#exam-set-table tr:last-child td:first-child').innerText =
                    document.querySelectorAll('#exam-set-table tr').length - 1;
                document.getElementById('id01').style.display = 'none'; // Close modal
                document.getElementById('add-form').reset(); // Reset form
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
        }).catch(error => {
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

    document.getElementById('edit-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        fetch('action/edit-set-soalan.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json()).then(data => {
            if (data.status === 'success') {
                var id = document.getElementById('edit-id').value;
                document.getElementById('guru-' + id).textContent = document.querySelector(
                    '#edit-guru option:checked').textContent;
                document.getElementById('kelas-' + id).textContent = document.querySelector(
                    '#edit-kelas option:checked').textContent;
                document.getElementById('tajuk-' + id).textContent = document.getElementById(
                    'edit-tajuk').value;
                document.getElementById('desc-' + id).textContent = document.getElementById('edit-desc')
                    .value;
                document.getElementById('tarikh-' + id).textContent = document.getElementById(
                    'edit-tarikh').value;
                document.getElementById('minit-' + id).textContent = document.getElementById(
                    'edit-minit').value + " Minit";
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
        }).catch(error => {
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
        fetch('action/delete-set-soalan.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json()).then(data => {
            if (data.status === 'success') {
                var id = document.getElementById('delete-id').value;
                document.getElementById('row-' + id).remove();
                Swal.fire({
                    icon: 'error',
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
                document.getElementById('id02').style.display = 'none'; // Close modal
                document.querySelectorAll('#exam-set-table tr').forEach((tr, index) => {
                    if (index > 0) {
                        tr.children[0].innerText = index;
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
        }).catch(error => {
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
</body>

</html>