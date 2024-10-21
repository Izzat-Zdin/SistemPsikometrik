<?php 
session_start();
include '../guard-penyelia.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="../mpp.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/keputusan.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Penyelia • Keputusan Murid</title>
    <style>
    .low-mark {
        color: red;
        font-weight: bolder;
        font-weight: ;
        font-size: 26px;
        /* Saiz font yang lebih besar */
    }

    .download-btn,
    .delete-btn {
        float: right;
        margin-top: 55px;
        margin-right: 29%;
    }

    #table-preview {
        margin-top: 20px;
    }

    .button-container {
        margin-top: 10%;
    }

    .sortable-header {
        cursor: pointer;
    }

    .sortable-header i {
        margin-left: 5px;
    }

    /* Hover effect for Details button */
    .btn-details-delete:hover {
        background-color: red;
        transform: scale(1.05);
    }

    /* Focus effect for accessibility */
    .btn-details-delete:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
    }

    /* Styling for Details button */
    .btn-details-delete {
        display: inline-block;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: red;
        border: none;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.3s;
    }
    </style>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/green.png" alt="sidebar img" class="bg-image">

    <!-- HEADER -->
    <?php include 'includes/sidebar-keputusan.php'; ?>
    <?php include 'includes/header-keputusan.php'; ?>

    <!-- MAIN -->
    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: 700; color: white; position: fixed; top: 14%; left:20%">
            KEPUTUSAN</h1>

        <!-- Filter Form -->
        <form method="get" action="" class="filter-form"
            style="font-family: 'Montserrat', sans-serif;  font-size: 20px; margin-top: 4%;">
            <label for="filter-type"></label>
            <select id="filter-type" name="filter-type">
                <option value="all"
                    <?php if (isset($_GET['filter-type']) && $_GET['filter-type'] == 'all') echo 'selected'; ?>>Semua
                    Murid</option>
                <option value="kelas"
                    <?php if (isset($_GET['filter-type']) && $_GET['filter-type'] == 'kelas') echo 'selected'; ?>>Kelas
                </option>
                <option value="nama"
                    <?php if (isset($_GET['filter-type']) && $_GET['filter-type'] == 'nama') echo 'selected'; ?>>Nama
                    Murid</option>
                <option value="markah"
                    <?php if (isset($_GET['filter-type']) && $_GET['filter-type'] == 'markah') echo 'selected'; ?>>
                    Markah</option>
            </select>
            <input type="text" name="filter-value" placeholder="Masukkan nilai"
                value="<?php echo isset($_GET['filter-value']) ? htmlspecialchars($_GET['filter-value']) : ''; ?>" />
            <select id="filter-markah" name="filter-markah">
                <option value="">Pilih Markah</option>
                <option value="10-20">10-20%</option>
                <option value="21-40">21-40%</option>
                <option value="41-60">41-60%</option>
                <option value="61-100">61-100%</option>
            </select>
            <button type="submit">Carian</button>
        </form>


        <button class="download-btn" onclick="downloadPDF()" style="position:absolute; top:20.5%; left:60%;">Muat Turun
            Jadual</button>

        <div class="table-responsive" id="table-preview" style="margin-top: 4%;">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Bil</th>
                        <th>Nama</th>
                        <th>No Kad Pengenalan</th>
                        <th class="sortable-header" onclick="sortTable('kelas')">Kelas <i
                                class="ri-arrow-up-s-line"></i></th>
                        <th>Set Soalan</th>
                        <th class="sortable-header" onclick="sortTable('markah')">Markah <i
                                class="ri-arrow-up-s-line"></i></th>
                        <th>Tindakan</th>
                    </tr>
                </thead>

                <tbody id="table-body" style="font-family: 'Montserrat', sans-serif; font-size: 32px; ">
                    <?php
                include('../includes/connect.php');

                if ($condb->connect_error) {
                    die("Connection failed: " . $condb->connect_error);
                }

                $sql = "SELECT k.murid_id, k.markah_id, k.kelas_id, k.markah, m.murid_nama, m.murid_ic, c.kelas_nama, e.ex_tajuk 
                        FROM keputusan k 
                        JOIN murid_acc m ON k.murid_id = m.murid_id 
                        JOIN kelas c ON m.kelas_id = c.kelas_id
                        JOIN exam_set e ON k.ex_id = e.ex_id";

                $filterType = isset($_GET['filter-type']) ? $_GET['filter-type'] : 'all';
                $filterValue = isset($_GET['filter-value']) ? $_GET['filter-value'] : '';

                if ($filterType == 'kelas' && !empty($filterValue)) {
                    $sql .= " WHERE c.kelas_nama LIKE ?";
                    $stmt = $condb->prepare($sql);
                    $filterValue = "%$filterValue%";
                    $stmt->bind_param("s", $filterValue);
                } elseif ($filterType == 'nama' && !empty($filterValue)) {
                    $sql .= " WHERE m.murid_nama LIKE ?";
                    $stmt = $condb->prepare($sql);
                    $filterValue = "%$filterValue%";
                    $stmt->bind_param("s", $filterValue);
                } elseif ($filterType == 'markah' && !empty($_GET['filter-markah'])) {
                    $markahRange = explode('-', $_GET['filter-markah']);
                    $minMarkah = intval($markahRange[0]);
                    $maxMarkah = intval($markahRange[1]);
                    $sql .= " WHERE k.markah BETWEEN ? AND ?";
                    $stmt = $condb->prepare($sql);
                    $stmt->bind_param("ii", $minMarkah, $maxMarkah);
                } else {
                    $stmt = $condb->prepare($sql);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $bil = 1;
                    while ($row = $result->fetch_assoc()) {
                        $murid_id = $row['murid_id'];
                        $markah_id = $row['markah_id'];
                        $nama = $row['murid_nama'];
                        $ic = $row['murid_ic'];
                        $kelas = $row['kelas_nama'];
                        $set_soalan = $row['ex_tajuk'];
                        $markah = $row['markah'];

                        $rowClass = $markah < 50 ? 'class="low-mark"' : '';

                        echo "<tr data-murid-id='{$murid_id}' style='font-size: 40px; color: white;'>";
                        echo "<td>{$bil}</td>";
                        echo "<td>{$nama}</td>";
                        echo "<td>{$ic}</td>";
                        echo "<td>{$kelas}</td>";
                        echo "<td>{$set_soalan}</td>";
                        echo "<td {$rowClass} style='font-size:26px'>{$markah} %</td>";
                        echo "<td>
                                <a href='db-keputusan/generate-pdf.php?murid_id={$murid_id}' class='btn-details'>Muat Turun</a>
                                <a href='#' class='btn-details-delete' onclick=\"document.getElementById('id01').style.display='block'; document.getElementById('delete-id').value='{$markah_id}';\" style='background-color: red; color: white; padding: 5px 10px; margin-top: 5px; display: inline-block;'>
                                    <i class='fa fa-trash'></i> Padam
                                </a>
                            </td>";
                        echo "</tr>";

                        $bil++;
                    }
                } else {
                    echo "<tr><td colspan='8'>Tiada data ditemukan</td></tr>";
                }
                $condb->close();
                ?>


                </tbody>
            </table>
        </div>

        <script>
        let sortDirection = {
            kelas: 'asc', // Default sort direction for kelas
            markah: 'desc' // Default sort direction for markah
        };

        function sortTable(column) {
            let rows = Array.from(document.querySelectorAll("#table-body tr"));

            rows.sort((a, b) => {
                let valueA, valueB;

                if (column === 'kelas') {
                    valueA = a.cells[3].textContent.trim().toUpperCase();
                    valueB = b.cells[3].textContent.trim().toUpperCase();
                    return sortDirection[column] === 'asc' ? valueA.localeCompare(valueB) : valueB
                        .localeCompare(valueA);
                } else if (column === 'markah') {
                    valueA = parseInt(a.cells[5].textContent);
                    valueB = parseInt(b.cells[5].textContent);
                    return sortDirection[column] === 'asc' ? valueA - valueB : valueB - valueA;
                }
            });

            let tableBody = document.querySelector("#table-body");
            tableBody.innerHTML = "";

            rows.forEach(row => {
                tableBody.appendChild(row);
            });

            // Update bil column
            let bilCounter = 1;
            document.querySelectorAll("#table-body tr td:first-child").forEach(td => {
                td.textContent = bilCounter++;
            });

            // Update arrow icons
            updateSortIcons(column);

            // Toggle sort direction
            sortDirection[column] = sortDirection[column] === 'asc' ? 'desc' : 'asc';
        }

        function updateSortIcons(column) {
            // Reset all arrow icons to default
            document.querySelectorAll(".sortable-header i").forEach(icon => {
                icon.className = 'ri-arrow-up-s-line';
            });

            // Update arrow icon for the sorted column
            let currentHeader = document.querySelector(`.sortable-header:nth-child(${column === 'kelas' ? 4 : 6})`);
            currentHeader.querySelector("i").className = sortDirection[column] === 'asc' ? 'ri-arrow-up-s-line' :
                'ri-arrow-down-s-line';
        }

        function downloadPDF() {
            const urlParams = new URLSearchParams(window.location.search);
            const filterType = urlParams.get('filter-type') || 'all';
            const filterValue = urlParams.get('filter-value') || '';
            const filterMarkah = urlParams.get('filter-markah') || '';

            let downloadUrl =
                `preview-pdf.php?filter-type=${filterType}&filter-value=${filterValue}&filter-markah=${filterMarkah}`;
            window.open(downloadUrl, '_blank');
        }
        </script>
        <script src="../assets/js/main.js"></script>

        <!-- Modal Delete -->
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content w3-card-2 w3-animate-zoom" style="width:400px">
                <div class="w3-center">
                    <span onclick="document.getElementById('id01').style.display='none'"
                        class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                    <p>
                        <i class='fas fa-exclamation-triangle' style='font-size:58px; color:red; margin-top:20px;'></i>
                    </p>
                </div>
                <form class="w3-container" action="db-keputusan/padam-murid.php" method="POST">
                    <div class="w3-section" style="height: 75px;">
                        <input type="hidden" id="delete-id" name="markah_id" value="">
                        <label class="danger-lbl"
                            style="display: block; text-align: center; font-size: 17px; "><b>Adakah anda pasti untuk
                                memadam !!</b></label>
                        <div class="button-container">
                            <button class="w3-button w3-red" type="submit"
                                style="position: absolute; bottom: 10px; right: 10px;">Ya</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </main>
</body>

</html>