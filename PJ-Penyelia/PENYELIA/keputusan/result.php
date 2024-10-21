<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="modal/modal.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/keputusan.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Keputusan Murid</title>
    <style>
    .low-mark {
        color: red;
    }

    .download-btn {
        float: right;
        margin-top: 10px;
    }

    #table-preview {
        margin-top: 20px;
    }

    .button-container {
        margin-top: 10%;
    }
    </style>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="../assets/img/dark-bg.jpg" alt="sidebar img" class="bg-image">

    <!--=============== HEADER ===============-->
    <?php include 'includes/sidebar-keputusan.php'; ?>
    <?php include 'includes/header-keputusan.php'; ?>

    <!--=============== MAIN ===============-->
    <main class="main container" id="main">
        <!-- Filter Form -->
        <form method="get" action="" class="filter-form">
            <label for="filter-type">Filter by :</label>
            <select id="filter-type" name="filter-type">
                <option value="all"
                    <?php if(isset($_GET['filter-type']) && $_GET['filter-type'] == 'all') echo 'selected'; ?>>Semua
                    Murid</option>
                <option value="kelas"
                    <?php if(isset($_GET['filter-type']) && $_GET['filter-type'] == 'kelas') echo 'selected'; ?>>Kelas
                </option>
                <option value="nama"
                    <?php if(isset($_GET['filter-type']) && $_GET['filter-type'] == 'nama') echo 'selected'; ?>>Nama
                    Murid</option>
                <option value="markah"
                    <?php if(isset($_GET['filter-type']) && $_GET['filter-type'] == 'markah') echo 'selected'; ?>>Markah
                </option>
            </select>
            <input type="text" name="filter-value" placeholder="Enter value"
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

        <button class="download-btn" onclick="downloadPDF()">Download Table</button>

        <div class="table-responsive" id="table-preview">
            <table class="table table-dark table-striped">
                <!-- Added 'table-dark' class for dark mode -->
                <thead>
                    <tr>
                        <th>Bil</th>
                        <th>Nama</th>
                        <th>IC</th>
                        <th>Kelas
                            <button onclick="sortTable('kelas', 'asc')">▲</button>
                            <button onclick="sortTable('kelas', 'desc')">▼</button>
                        </th>
                        <th>Set Soalan</th>
                        <th>Markah
                            <button onclick="sortTable('markah', 'desc')">▲</button>
                            <button onclick="sortTable('markah', 'asc')">▼</button>
                        </th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php
                    include 'connect.php';

                    $filterType = isset($_GET['filter-type']) ? $_GET['filter-type'] : 'all';
                    $filterValue = isset($_GET['filter-value']) ? $_GET['filter-value'] : '';

                    $sql = "SELECT k.murid_id, k.kelas_id, k.markah, m.murid_nama, m.murid_ic, c.kelas_nama 
                            FROM keputusan k 
                            JOIN murid_acc m ON k.murid_id = m.murid_id 
                            JOIN kelas c ON m.kelas_id = c.kelas_id";

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
                                $nama = $row['murid_nama'];
                                $ic = $row['murid_ic'];
                                $kelas = $row['kelas_nama'];
                                $set_soalan = "Psikometrik"; // Assuming set_soalan is "Psikometrik"
                                $markah = $row['markah'];

                                $rowClass = $markah < 50 ? 'class="low-mark"' : '';

                                echo "<tr data-murid-id='{$murid_id}' $rowClass>"; // Added data-murid-id attribute
                                echo "<td>{$bil}</td>";
                                echo "<td>{$nama}</td>";
                                echo "<td>{$ic}</td>";
                                echo "<td>{$kelas}</td>";
                                echo "<td>{$set_soalan}</td>";
                                echo "<td>{$markah} %</td>";
                                echo "<td>
                                        <a href='db-keputusan/generate-pdf.php?murid_id={$murid_id}' class='btn-details'>Download</a>
                                        <button class='btn-delete' data-murid-id='{$markah}'>Delete</button>                                    
                                    </td>";
                                echo "</tr>";

                                $bil++;
                            }
                        } else {
                            echo "<tr><td colspan='7'>No data available</td></tr>";
                        }
                        $condb->close();
                        ?>
                </tbody>
            </table>
        </div>

        <form action="db-keputusan/padam-murid.php" method="POST">
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <img src="../gambar/danger.svg" alt="Example Image" style="width: 100px; height: 100px;">
                    <button class="modal-button">Close</button>
                    <form action="db-keputusan/padam-murid.php" method="POST">
                        <input type="hidden" id="murid_id" name="murid_id">
                        <button type="submit" id="customButton" class="custom-button" name="delete">Ya</button>
                        <!-- Added button -->
                    </form>
                </div>
            </div>
        </form>

        <script src="modal/modal.js"></script>

        <script>
        // Add event listener to all table rows
        document.querySelectorAll('#table-body tr').forEach(row => {
            row.addEventListener('click', function() {
                const muridId = this.getAttribute('data-murid-id');
                // Assuming the modal ID is 'myModal', you can adjust accordingly
                const modal = document.getElementById('myModal');
                modal.style.display = "block";
                modal.classList.add("show");
                // You can fetch and display data associated with this muridId in the modal if needed
            });
        });

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
    </main>
</body>

</html>