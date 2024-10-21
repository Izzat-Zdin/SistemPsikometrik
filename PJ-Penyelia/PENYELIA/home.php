<?php
session_start();

include 'action/connect.php';
include 'guard-penyelia.php';

// Fetch total number of classes
$query1 = "SELECT COUNT(*) as total_classes FROM kelas";
$result1 = $condb->query($query1);
$row1 = $result1->fetch_assoc();
$total_classes = $row1['total_classes'];

// Fetch total number of question sets
$query2 = "SELECT COUNT(*) as total_sets FROM exam_set";
$result2 = $condb->query($query2);
$row2 = $result2->fetch_assoc();
$total_sets = $row2['total_sets'];

// Fetch total number of students
$query3 = "SELECT COUNT(*) as total_students FROM murid_acc";
$result3 = $condb->query($query3);
$row3 = $result3->fetch_assoc();
$total_students = $row3['total_students'];

// Fetch total number of recorded answers
$query4 = "SELECT COUNT(*) as total_answers FROM keputusan";
$result4 = $condb->query($query4);
$row4 = $result4->fetch_assoc();
$total_answers = $row4['total_answers'];

// Calculate the number of students who haven't answered yet
$belum_duduki = $total_students - $total_answers;

// Fetch class names and the count of students in each class
$query5 = "SELECT kelas.kelas_nama, COUNT(murid_acc.murid_id) as jumlah_murid 
           FROM kelas 
           LEFT JOIN murid_acc ON kelas.kelas_id = murid_acc.kelas_id 
           GROUP BY kelas.kelas_nama";
$result5 = $condb->query($query5);

// Initialize arrays to hold class names and student counts
$kelas_nama = [];
$jumlah_murid = [];

// Fetch data into arrays
while($row5 = $result5->fetch_assoc()) {
    $kelas_nama[] = $row5['kelas_nama'];
    $jumlah_murid[] = $row5['jumlah_murid'];
}

// Fetch student data and exam status
$query6 = "SELECT murid_acc.murid_id, murid_acc.murid_nama, kelas.kelas_nama, 
           CASE WHEN keputusan.murid_id IS NULL THEN 'Belum' ELSE 'Sudah' END as ujian_status
           FROM murid_acc 
           LEFT JOIN kelas ON murid_acc.kelas_id = kelas.kelas_id 
           LEFT JOIN keputusan ON murid_acc.murid_id = keputusan.murid_id
           ORDER BY murid_acc.murid_id";
$result6 = $condb->query($query6);

// Initialize an array to hold student data
$students_data = [];

while ($row6 = $result6->fetch_assoc()) {
    $students_data[] = [
        'murid_id' => $row6['murid_id'],
        'nama' => $row6['murid_nama'],
        'kelas' => $row6['kelas_nama'],
        'ujian_status' => $row6['ujian_status']
    ];
}

$condb->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="mpp.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="dashboard/css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">

    <title>Penyelia • Laman Utama</title>
    <style>
    /* Stylish Scrollbar */
    ::-webkit-scrollbar {
        width: 20px;
        /* Width of the scrollbar */
    }

    ::-webkit-scrollbar-track {
        background: #1f1f1f;
        /* Background of the scrollbar track */
        border-radius: 10px;
        /* Rounded corners of the track */
        padding-top: 40%;
    }

    ::-webkit-scrollbar-thumb {
        background: gray;
        /* Color of the scrollbar thumb */
        border-radius: 10px;
        /* Rounded corners of the thumb */
        border: 3px solid #1f1f1f;
        /* Adds space around the thumb */
    }

    ::-webkit-scrollbar-thumb:active {
        background: white;
        /* Active color for the scrollbar thumb */
    }

    .student-container {
        background-color: #2c2c2c;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        max-height: 400px;
        overflow-y: auto;
    }

    .class-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: uppercase;
        border-bottom: 2px solid #ffffff;
        padding-bottom: 5px;
    }

    .student-list {
        list-style-type: none;
        padding-left: 0;
    }

    .student-list li {
        margin: 5px 0;
        padding: 5px 10px;
        background-color: #3a3a3a;
        border-radius: 5px;
    }

    .student-table {
        width: 100%;
        border-collapse: collapse;
    }

    .student-table th,
    .student-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        color: #fff;
    }

    .student-table th {
        background-color: #333;
    }

    .student-table tr:nth-child(even) {
        background-color: #3a3a3a;
    }

    .student-table tr:nth-child(odd) {
        background-color: #2c2c2c;
    }

    .btn-status {
        padding: 5px 10px;
        border-radius: 5px;
        text-align: center;
        width: 80px;
        display: inline-block;
    }

    .status-belum {
        background-color: red;
        color: white;
    }

    .status-sudah {
        background-color: green;
        color: white;
    }
    </style>
</head>

<body>
    <img src="assets/img/green.png">

    <!-- Sidebar and Header inclusion -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/header.php'; ?>

    <main class="main container" id="main" style="margin-top: -117%;">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 10%; left:20%">
            LAMAN UTAMA
        </h1>
        <br><br>
        <div class="grid-container" style="margin-top: 3.5%;">
            <main class="main-container-dashboard">
                <div class="main-cards">
                    <div class="card">
                        <div class="card-inner">
                            <h3>Kelas</h3>
                            <span class="material-icons-outlined">inventory_2</span>
                        </div>
                        <h1><?php echo $total_classes; ?></h1>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <h3>SET SOALAN</h3>
                            <span class="material-icons-outlined">category</span>
                        </div>
                        <h1><?php echo $total_sets; ?></h1>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <h3>MURID</h3>
                            <span class="material-icons-outlined">groups</span>
                        </div>
                        <h1><?php echo $total_students; ?></h1>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <h3>BELUM DUDUKI</h3>
                            <span class="material-icons-outlined">notification_important</span>
                        </div>
                        <h1><?php echo $belum_duduki; ?></h1>
                    </div>
                </div>
                <div class="charts"
                    style="margin-top: 1.5%; transform: scale(0.8); position: relative; left: -10%; top: -6%;">
                    <div class="charts-card">
                        <h2 class="chart-title">Jumlah Murid (Kelas)</h2>
                        <div id="bar-chart"></div>
                    </div>
                </div>
                <!-- Student data table -->
                <div class="student-container" style="width:49.5%; position:absolute; left:50.5%; top:36%;">
                    <h2 class="class-title">Senarai Murid</h2>
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th>Bil</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students_data as $index => $student): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $student['nama']; ?></td>
                                <td><?php echo $student['kelas']; ?></td>
                                <td>
                                    <span
                                        class="btn-status <?php echo $student['ujian_status'] == 'Sudah' ? 'status-sudah' : 'status-belum'; ?>">
                                        <?php echo $student['ujian_status']; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </main>

    <!-- Your existing script inclusions -->
    <script src="assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>

    <!-- ApexCharts configuration for the bar chart -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: [{
                name: 'Jumlah Murid',
                data: <?php echo json_encode($jumlah_murid); ?> // Data jumlah murid untuk setiap kelas
            }],
            chart: {
                type: 'bar',
                height: 350,
                foreColor: '#FFFFFF' // Set the default font color to white
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($kelas_nama); ?>, // Nama kelas untuk setiap bar
                labels: {
                    style: {
                        colors: '#FFFFFF' // Tukar warna teks kepada putih
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah',
                    style: {
                        color: '#FFFFFF' // Tukar warna teks tajuk y-axis kepada putih
                    }
                },
                labels: {
                    style: {
                        colors: '#FFFFFF' // Tukar warna teks y-axis kepada putih
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                theme: 'dark', // Optional: Set the tooltip theme to dark for better visibility with white text
                y: {
                    formatter: function(val) {
                        return val
                    }
                },
                style: {
                    color: '#FFFFFF' // Tukar warna teks tooltip kepada putih
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#bar-chart"), options);
        chart.render();
    });
    </script>

</body>

</html>