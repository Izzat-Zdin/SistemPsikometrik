<?php
include 'connect.php';

session_start(); // Start the session
include '../guard-guru.php';

// Check if the user is logged in and has a guru_id
if (!isset($_SESSION['guru_id'])) {
    die("Unauthorized access. Please log in.");
}

$guru_id = $_SESSION['guru_id'];

// Fetch the kelas_id associated with the logged-in guru_id
$query_kelas = "SELECT kelas_id FROM guru_acc WHERE guru_id = ?";
$stmt_kelas = $condb->prepare($query_kelas);

if (!$stmt_kelas) {
    die("Prepare failed: " . $condb->error);
}

$stmt_kelas->bind_param('i', $guru_id);
$stmt_kelas->execute();
$result_kelas = $stmt_kelas->get_result();

if ($result_kelas->num_rows > 0) {
    $row_kelas = $result_kelas->fetch_assoc();
    $kelas_id = $row_kelas['kelas_id'];
} else {
    die("No class assigned to this teacher.");
}

// Fetch students from the specified class
$query_students = "SELECT k.murid_id, k.markah_id, k.kelas_id, k.markah, m.murid_nama, m.murid_ic, c.kelas_nama, e.ex_tajuk, k.komen 
                   FROM keputusan k 
                   JOIN murid_acc m ON k.murid_id = m.murid_id 
                   JOIN kelas c ON m.kelas_id = c.kelas_id
                   JOIN exam_set e ON k.ex_id = e.ex_id
                   WHERE k.kelas_id = ?";
$stmt_students = $condb->prepare($query_students);

if (!$stmt_students) {
    die("Prepare failed: " . $condb->error);
}

$stmt_students->bind_param('i', $kelas_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/mpp.png">

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

    <title>Guru • Keputusan Murid</title>
    <style>
    .low-mark {
        color: red;
        font-weight: bolder;
        font-size: 26px;
    }

    .download-btn {
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
    .btn-details:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Focus effect for accessibility */
    .btn-details:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
    }

    /* Styling for Details button */
    .btn-details {
        display: inline-block;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.3s;
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
    <img src="assets/img/red.png" alt="sidebar img" class="bg-image">

    <!-- HEADER -->
    <?php include 'includes/sidebar-keputusan.php'; ?>
    <?php include 'includes/header-keputusan.php'; ?>

    <!-- MAIN -->
    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: 700; color: white; position: fixed; top: 14%; left:20%">
            TAMBAH KELAS</h1>

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

        <button style="position:absolute; left:58%; top:20.5%;" class="download-btn" onclick="downloadPDF()">Muat Turun
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
                        <th>Komen</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>

                <tbody id="table-body" style="font-family: 'Montserrat', sans-serif; font-size: 32px;">
                    <?php
                    include('../includes/connect.php');

                    if ($condb->connect_error) {
                        die("Connection failed: " . $condb->connect_error);
                    }

                    $sql = "SELECT k.murid_id, k.markah_id, k.kelas_id, k.markah, m.murid_nama, m.murid_ic, c.kelas_nama, e.ex_tajuk, k.komen 
                            FROM keputusan k 
                            JOIN murid_acc m ON k.murid_id = m.murid_id 
                            JOIN kelas c ON m.kelas_id = c.kelas_id
                            JOIN exam_set e ON k.ex_id = e.ex_id
                            WHERE k.kelas_id = ?";

                    $filterType = isset($_GET['filter-type']) ? $_GET['filter-type'] : 'all';
                    $filterValue = isset($_GET['filter-value']) ? $_GET['filter-value'] : '';

                    if ($filterType == 'kelas' && !empty($filterValue)) {
                        $sql .= " AND c.kelas_nama LIKE ?";
                        $stmt = $condb->prepare($sql);
                        $filterValue = "%$filterValue%";
                        $stmt->bind_param("is", $kelas_id, $filterValue);
                    } elseif ($filterType == 'nama' && !empty($filterValue)) {
                        $sql .= " AND m.murid_nama LIKE ?";
                        $stmt = $condb->prepare($sql);
                        $filterValue = "%$filterValue%";
                        $stmt->bind_param("is", $kelas_id, $filterValue);
                    } elseif ($filterType == 'markah' && !empty($_GET['filter-markah'])) {
                        $markahRange = explode('-', $_GET['filter-markah']);
                        $minMarkah = intval($markahRange[0]);
                        $maxMarkah = intval($markahRange[1]);
                        $sql .= " AND k.markah BETWEEN ? AND ?";
                        $stmt = $condb->prepare($sql);
                        $stmt->bind_param("iii", $kelas_id, $minMarkah, $maxMarkah);
                    } else {
                        $stmt = $condb->prepare($sql);
                        $stmt->bind_param("i", $kelas_id);
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
                            $komen = $row['komen'];

                            $rowClass = $markah < 50 ? 'class="low-mark"' : '';

                            echo "<tr data-murid-id='{$murid_id}' style='font-size: 40px; color: white;'>";
                            echo "<td>{$bil}</td>";
                            echo "<td>{$nama}</td>";
                            echo "<td>{$ic}</td>";
                            echo "<td>{$kelas}</td>";
                            echo "<td>{$set_soalan}</td>";
                            echo "<td {$rowClass} style='font-size:26px'>{$markah} %</td>";
                            echo "<td>
                                    <form action='tambah-komen.php' method='post' style='display: flex; align-items: center;'>
                                        <textarea name='comment' placeholder='Tambah komen di sini...' style='flex-grow: 1;'>{$komen}</textarea>
                                        <input type='hidden' name='murid_id' value='{$murid_id}'>
                                        <input type='hidden' name='markah_id' value='{$markah_id}'>
                                        <button type='submit' style='background-color: green; color: white; border: none; padding: 8px 12px; margin-left: 8px; border-radius: 5px; display: flex; align-items: center;'>
                                            <i class='fa fa-paper-plane' aria-hidden='true'></i>
                                        </button>
                                    </form>
                                  </td>";
                            echo "<td>
                                <a href='db-keputusan/generate-pdf.php?murid_id={$murid_id}' class='btn-details'>Muat Turun</a>
                                  </td>";
                            echo "</tr>";

                            $bil++;
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tiada data yang ditemukan</td></tr>";
                    }
                    $condb->close();
                    ?>
                </tbody>
            </table>
        </div>

        <script>
        <?php if (isset($_SESSION['comment_update'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berjaya',
            text: '<?php echo $_SESSION['comment_update']; ?>',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal2-custom-toast'
            }
        });
        <?php unset($_SESSION['comment_update']); endif; ?>


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
    </main>
</body>

</html>