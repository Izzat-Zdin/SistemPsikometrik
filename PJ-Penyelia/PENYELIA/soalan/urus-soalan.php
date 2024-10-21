<?php
include 'action/connect.php';
session_start();
include '../guard-penyelia.php';

// Get the selected ex_id from the request, if available; otherwise, use the session value
$current_ex_id = $_GET['ex_id'] ?? $_SESSION['current_ex_id'] ?? null;

if (!$current_ex_id) {
    // Redirect to home page if ex_id is not set
    header("Location: home-soalan.php");
    exit();
}

// Save the current ex_id in the session
$_SESSION['current_ex_id'] = $current_ex_id;

// Fetch ex_tajuk based on ex_id
$query = "SELECT ex_tajuk FROM exam_set WHERE ex_id = ?";
$stmt = $condb->prepare($query);
$stmt->bind_param("i", $current_ex_id);
$stmt->execute();
$stmt->bind_result($ex_tajuk);
$stmt->fetch();
$stmt->close();

$form_action = "urus-create-soalan.php?ex_id=" . urlencode($current_ex_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="../mpp.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/urus-soalan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">

    <title>Penyelia • Jadual Soalan</title>
    <style>
    .form-select-exam {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .form-select-exam label {
        font-family: 'Montserrat', sans-serif;
        font-weight: bold;
        font-size: 16px;
        margin-right: 10px;
    }

    .form-select-exam select {
        font-family: 'Montserrat', sans-serif;
        font-weight: bold;
        color: white;
        background-color: grey;
        width: 300px;
        height: 40px;
        margin-right: 10px;
    }

    .container-urus {
        margin-top: 20px;
    }

    .dark-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .dark-table th,
    .dark-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .dark-table th {
        background-color: #333;
        color: white;
    }

    .options-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 0;
        /* Remove gap between the options */
    }

    .option-box {
        border: 1px solid grey;
        /* Set border color to black */
        padding: 5px;
        text-align: center;
        margin: 0;
        /* Remove margin around the option box */
        /* Set background color to black */
        color: white;
        /* Set text color to white for contrast */
        box-sizing: border-box;
        /* Include padding and border in the element's total width and height */
    }

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
    </style>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/green.png" style="height: 200%;" alt="sidebar img" class="bg-image">

    <?php include 'includes/sidebar-soalan.php'; ?>
    <?php include 'includes/header-soalan.php'; ?>


    <!-- Main content -->
    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 14%; left:21%">
            JADUAL SOALAN</h1>
        <br><br><br>

        <div style="display: flex; align-items: center; margin-bottom: 20px; position:absolute; top:27%;">
            <!-- Dropdown for selecting different ex_id -->
            <button type="button" class="button-plus"
                onclick="location.href='create-exam-session.php?ex_id=<?php echo urlencode($current_ex_id); ?>'">
                <span class="text">Tambah<br>Soalan</span>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 8 8" id="plus">
                        <path d="M3 0v3H0v2h3v3h2V5h3V3H5V0H3z"></path>
                    </svg>
                </span>
            </button>
            <form method="GET" action="urus-soalan.php" class="form-select-exam" style="position: relative; left: 4%;">
                <label for="examSelect"
                    style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 16px; color: white;">Pilih
                    Exam:</label>
                <select id="examSelect" name="ex_id" onchange="this.form.submit()"
                    style="font-family: 'Montserrat', sans-serif; font-weight: bold; color: white; background-color: #3b3b3b; width: 300px; height: 40px;">
                    <?php
        // Fetch all ex_id and ex_tajuk from exam_set for the dropdown
        $query = "SELECT ex_id, ex_tajuk FROM exam_set ORDER BY ex_tajuk ASC";
        $result = mysqli_query($condb, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $selected = $row['ex_id'] == $current_ex_id ? 'selected' : '';
            echo "<option value='{$row['ex_id']}' {$selected} style='color: black;'>{$row['ex_tajuk']}</option>";
        }
        ?>
                </select>
            </form>


        </div>

        <div class="container-urus" style="font-size: 18px; font-family: 'Montserrat', sans-serif;">
            <!---<h1 style="font-family: 'Montserrat', sans-serif; font-weight: bolder; font-size: 23px;">Set Soalan
                <?php echo htmlspecialchars($ex_tajuk); ?></h1>-->
            <table class="dark-table">
                <thead>
                    <tr>
                        <th>Bil</th>
                        <th>Tajuk</th>
                        <th>Soalan</th>
                        <th>Jawapan</th>
                        <th>Pilihan</th>
                        <th style="width: 15%;">Tindakan</th>
                    </tr>
                </thead>
                <tbody id="questionTable">
                    <?php
                    // Fetch questions based on the current ex_id
                    $query = "SELECT * FROM exam_soalan WHERE ex_id = ?";
                    $stmt = $condb->prepare($query);
                    $stmt->bind_param("i", $current_ex_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        $option1 = $row['pilihan_1'];
                        $option2 = $row['pilihan_2'];
                        $option3 = $row['pilihan_3'];
                        $option4 = $row['pilihan_4'];

                        echo "<tr data-id='{$row['soalan_id']}' data-tajuk='{$row['tajuk']}' data-soalan='{$row['soalan']}' data-jawapan='{$row['exam_jawapan']}' data-option1='{$option1}' data-option2='{$option2}' data-option3='{$option3}' data-option4='{$option4}'>";
                        echo "<td>{$count}</td>";
                        echo "<td>{$row['tajuk']}</td>";
                        echo "<td>{$row['soalan']}</td>";
                        echo "<td>{$row['pilihan_1']}</td>";
                        echo "<td class='options-container'>";
                        echo "<div class='option-box'>{$option1}</div>";
                        echo "<div class='option-box'>{$option2}</div>";
                        echo "<div class='option-box'>{$option3}</div>";
                        echo "<div class='option-box'>{$option4}</div>";
                        echo "</td>";
                        echo "<td>
                                <button onclick=\"confirmDelete('".$row['soalan_id']."')\" class=\"button-delete\">
                                    <i class=\"ri-delete-bin-2-fill\" style=\"font-size: 30px;\"></i>
                                </button>
                                <button onclick=\"editQuestion('".$row['soalan_id']."')\" class=\"button-edit\">
                                    <i class=\"ri-pencil-fill\" style=\"font-size: 30px;\"></i>
                                </button>
                            </td>";
                        echo "</tr>";
                        $count++;
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Delete -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-card-2 w3-animate-zoom" style="width:400px">
            <div class="w3-center">
                <span onclick="document.getElementById('id01').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <p>
                    <i class='fas fa-exclamation-triangle' style='font-size:58px; color:red; margin-top:20px;'></i>
                </p>
            </div>
            <form class="w3-container" action="action/urus/delete.php" method="POST">
                <div class="w3-section" style="height: 75px;">
                    <input type="hidden" id="delete-id" name="soalan_id" value="">
                    <label class="danger-lbl" style="display: block; text-align: center; font-size: 17px; "><b>Adakah
                            anda
                            pasti untuk memadam !!</b></label>
                    <div class="button-container">
                        <button class="w3-button w3-red" type="submit"
                            style="position: absolute; bottom: 10px; right: 10px;">Ya</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="id02" class="w3-modal" style="font-size: 15px; font-family: 'Montserrat', sans-serif;">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('id02').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
            </div>

            <form class="w3-container" action="action/urus/edit.php" method="POST">
                <div class="w3-section">
                    <input type="hidden" id="edit-id" name="soalan_id" value="">
                    <label class="w3-lbl"><b>Tajuk</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-tajuk" name="tajuk"
                        required>

                    <label class="w3-lbl"><b>Soalan</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-soalan" name="soalan"
                        required>

                    <label class="w3-lbl"><b>Jawapan</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-jawapan" name="exam_jawapan"
                        required>

                    <label class="w3-lbl"><b>Pilihan 1</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-option1" name="pilihan_1"
                        required>

                    <label class="w3-lbl"><b>Pilihan 2</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-option2" name="pilihan_2"
                        required>

                    <label class="w3-lbl"><b>Pilihan 3</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-option3" name="pilihan_3"
                        required>

                    <label class="w3-lbl"><b>Pilihan 4</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="edit-option4" name="pilihan_4"
                        required>

                    <button class="w3-button w3-section w3-padding" type="submit"
                        style="float: right; background-color: green; color:white;">Edit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        window.editQuestion = function(questionId) {
            const row = document.querySelector(`[data-id='${questionId}']`);
            const tajuk = row.getAttribute('data-tajuk');
            const soalan = row.getAttribute('data-soalan');
            const jawapan = row.getAttribute('data-jawapan');
            const option1 = row.getAttribute('data-option1');
            const option2 = row.getAttribute('data-option2');
            const option3 = row.getAttribute('data-option3');
            const option4 = row.getAttribute('data-option4');

            document.getElementById('edit-id').value = questionId;
            document.getElementById('edit-tajuk').value = tajuk;
            document.getElementById('edit-soalan').value = soalan;
            document.getElementById('edit-jawapan').value = option1;
            document.getElementById('edit-option1').value = option1;
            document.getElementById('edit-option2').value = option2;
            document.getElementById('edit-option3').value = option3;
            document.getElementById('edit-option4').value = option4;

            document.getElementById('id02').style.display = 'block';
        };

        window.confirmDelete = function(questionId) {
            document.getElementById('delete-id').value = questionId;
            document.getElementById('id01').style.display = 'block';
        };
    });
    </script>

    <script src="../assets/js/main.js"></script>
</body>

</html>