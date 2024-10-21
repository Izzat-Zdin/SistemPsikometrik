<?php
session_start();

include 'guard-guru.php';
include 'action/connect.php';

// Ensure guru_id is set in session
if (!isset($_SESSION['guru_id'])) {
    die('Session expired or not authenticated. Please log in again.');
}

// Fetch total number of students for the logged-in teacher
$query3 = "SELECT COUNT(*) as total_students 
           FROM murid_acc 
           WHERE kelas_id IN (SELECT kelas_id FROM kelas WHERE guru_id = ?)";
$stmt3 = $condb->prepare($query3);
$stmt3->bind_param("i", $_SESSION['guru_id']);
$stmt3->execute();
$result3 = $stmt3->get_result();
$row3 = $result3->fetch_assoc();
$total_students = $row3['total_students'];
$stmt3->close();

// Fetch total number of recorded answers for the logged-in teacher
$query4 = "SELECT COUNT(*) as total_answers 
           FROM keputusan 
           WHERE murid_id IN (SELECT murid_id FROM murid_acc WHERE kelas_id IN (SELECT kelas_id FROM kelas WHERE guru_id = ?))";
$stmt4 = $condb->prepare($query4);
$stmt4->bind_param("i", $_SESSION['guru_id']);
$stmt4->execute();
$result4 = $stmt4->get_result();
$row4 = $result4->fetch_assoc();
$total_answers = $row4['total_answers'];
$stmt4->close();

// Calculate the number of students who haven't answered yet
$belum_duduki = $total_students - $total_answers;

// Fetch class names and the count of students in each class for the logged-in teacher
$query5 = "SELECT kelas.kelas_nama, COUNT(murid_acc.murid_id) as jumlah_murid 
           FROM kelas 
           LEFT JOIN murid_acc ON kelas.kelas_id = murid_acc.kelas_id 
           WHERE kelas.guru_id = ?
           GROUP BY kelas.kelas_nama";
$stmt5 = $condb->prepare($query5);
$stmt5->bind_param("i", $_SESSION['guru_id']);
$stmt5->execute();
$result5 = $stmt5->get_result();

// Initialize arrays to hold class names and student counts
$kelas_nama = [];
$jumlah_murid = [];

// Fetch data into arrays
while($row5 = $result5->fetch_assoc()) {
    $kelas_nama[] = $row5['kelas_nama'];
    $jumlah_murid[] = $row5['jumlah_murid'];
}
$stmt5->close();

// Fetch tasks from the database for the logged-in teacher
$query6 = "SELECT tugasan_id, tugasan FROM tugasan WHERE guru_id = ?";
$stmt6 = $condb->prepare($query6);
$stmt6->bind_param("i", $_SESSION['guru_id']);
$stmt6->execute();
$result6 = $stmt6->get_result();
$tugasan_list = $result6->fetch_all(MYSQLI_ASSOC);
$stmt6->close();

$condb->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/mpp.png">
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
    <title>Guru • Laman Utama</title>
    <style>
    body {
        background-color: #051622;
    }

    ::-webkit-scrollbar {
        width: 20px;
    }

    ::-webkit-scrollbar-track {
        background: #1f1f1f;
        border-radius: 10px;
        padding-top: 40%;
    }

    ::-webkit-scrollbar-thumb {
        background: gray;
        border-radius: 10px;
        border: 3px solid #1f1f1f;
    }

    ::-webkit-scrollbar-thumb:active {
        background: white;
    }

    .todo-list {
        background-color: #1f1f1f;
        padding: 20px;
        border-radius: 10px;
        color: white;
        margin-top: 20px;
    }

    .todo-list form {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .todo-list input[type="text"] {
        width: 80%;
        padding: 5px;
        border: none;
        border-radius: 5px;
        color: white;
        background-color: #333;
    }

    .todo-list button {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }

    .todo-list ul {
        list-style-type: none;
        padding: 0;
    }

    .todo-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #333;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .todo-list li input[type="checkbox"] {
        margin-right: 10px;
    }

    .todo-list li .edit-task {
        flex-grow: 1;
        background: none;
        border: none;
        color: white;
        font-size: 16px;
        margin-left: 10px;
    }

    .todo-list li .edit-task:focus {
        outline: none;
        border-bottom: 2px solid #4CAF50;
    }

    .todo-list li .delete-task {
        background: none;
        border: none;
        cursor: pointer;
        color: red;
    }
    </style>
</head>

<body>
    <img src="assets/img/red.png">
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <main class="main container" id="main" style="margin-top: -117%;">
        <div class="grid-container">
            <main class="main-container-dashboard">
                <h2 style="font-size: 33px;">LAMAN UTAMA</h2>
                <div class="main-cards">
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
                <div class="carta"
                    style="background-color: #333333; padding: 20px; border-radius: 10px;  margin-top:3%; width:50%;">
                    <div class="carta-card">
                        <h2 class="carta-title">Jumlah Murid (Kelas)</h2>
                        <canvas id="bar-chart"></canvas>
                    </div>
                </div>

            </main>
            <div class="todo-list"
                style="width:40%; position:absolute; left:57%; top:20%; background-color:#333333; transform-scale:0.9;">
                <h1 class="carta-title" style="font-size:25px;">Senarai yang akan dibuat</h1>
                <br>
                <form id="todo-form" action="tugasan/hantar.php" method="POST">
                    <input type="text" name="task" id="new-task" placeholder="Tambah tugasan baharu"
                        style="color: black; background-color:white; font-weight:900;">
                    <button type="submit">Tambah</button>
                </form>
                <ul id="tasks">
                    <?php foreach ($tugasan_list as $tugasan) : ?>
                    <li data-id="<?php echo $tugasan['tugasan_id']; ?>">
                        <input type="checkbox" class="task-checkbox">
                        <span class="edit-task"
                            contenteditable="true"><?php echo htmlspecialchars($tugasan['tugasan']); ?></span>
                        <button class="delete-task" style="background-color:maroon; color:white;">Padam</button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('bar-chart').getContext('2d');
        const startYear = 2024;
        const numberOfLabels =
            <?php echo count($jumlah_murid); ?>; // Assuming jumlah_murid array has the number of labels needed
        const labels = Array.from({
            length: numberOfLabels
        }, (v, i) => startYear + i);

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Murid',
                    data: <?php echo json_encode($jumlah_murid); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    barThickness: 50 // Set bar width to 50

                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#FFFFFF'
                        },
                        title: {
                            display: true,
                            text: 'Jumlah',
                            color: '#FFFFFF'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#FFFFFF'
                        },
                        title: {
                            display: true,
                            text: 'Tahun',
                            color: '#FFFFFF'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#FFFFFF'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#333333',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF'
                    }
                }
            }
        });
    });
    </script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tasks = document.getElementById('tasks');

        function deleteTask(taskId) {
            fetch('tugasan/delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        task_id: taskId
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Task deleted successfully');
                    } else {
                        alert('Failed to delete task from the database');
                    }
                });
        }

        tasks.addEventListener('click', function(e) {
            if (e.target.closest('.delete-task')) {
                const li = e.target.closest('li');
                const taskId = li.dataset.id;
                deleteTask(taskId);
                li.remove();
            }
        });

        tasks.addEventListener('change', function(e) {
            if (e.target.closest('.task-checkbox')) {
                const checkbox = e.target;
                const editTask = checkbox.nextElementSibling;
                if (checkbox.checked) {
                    editTask.style.textDecoration = 'line-through';
                } else {
                    editTask.style.textDecoration = 'none';
                }
            }
        });

        tasks.addEventListener('focusin', function(e) {
            if (e.target.closest('.edit-task')) {
                e.target.style.borderBottom = '2px solid #4CAF50';
            }
        });

        tasks.addEventListener('focusout', function(e) {
            if (e.target.closest('.edit-task')) {
                const li = e.target.closest('li');
                const taskId = li.dataset.id;
                const newTaskText = e.target.textContent;

                // Update the task in the database
                fetch('tugasan/update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            task_id: taskId,
                            task: newTaskText
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Task updated successfully');
                        } else {
                            alert('Failed to update task in the database');
                        }
                    });

                e.target.style.borderBottom = 'none';
            }
        });
    });
    </script>
</body>

</html>