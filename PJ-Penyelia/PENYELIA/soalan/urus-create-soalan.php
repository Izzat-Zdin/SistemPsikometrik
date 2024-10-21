<?php
// Include the database connection
include 'action/connect.php';
session_start();
include '../guard-penyelia.php';

// Retrieve ex_id from the session
$current_ex_id = $_SESSION['current_ex_id'] ?? null;

if (!$current_ex_id) {
    // Redirect to home page if ex_id is not set
    header("Location: home-soalan.php");
    exit();
}

// Fetch ex_tajuk based on the current ex_id
$query = "SELECT ex_tajuk FROM exam_set WHERE ex_id = ?";
$stmt = $condb->prepare($query);
$stmt->bind_param("i", $current_ex_id);
$stmt->execute();
$stmt->bind_result($ex_tajuk);
$stmt->fetch();
$stmt->close();

// If no valid ex_id in the session, fetch the most recent ex_tajuk from exam_set as a fallback
if (!$ex_tajuk) {
    $query = "SELECT ex_id, ex_tajuk FROM exam_set ORDER BY ex_id DESC LIMIT 1";
    $result = mysqli_query($condb, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_ex_id = $row['ex_id']; // Set the most recent ex_id
        $ex_tajuk = $row['ex_tajuk'];
        
        // Update the session with the most recent ex_id
        $_SESSION['current_ex_id'] = $current_ex_id;
    } else {
        $ex_tajuk = "No Exam Available"; // Fallback message if no exams are available
    }
}

// Close the database connection
mysqli_close($condb);

// Example form action using the current ex_id
$form_action = "action/hantar-create-soalan.php?ex_id=" . urlencode($current_ex_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../mpp.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/create.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <title>Penyelia • Tambah Soalan</title>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/green.png" alt="sidebar img" class="bg-image">

    <!--=============== HEADER ===============-->
    <?php include 'includes/header-soalan.php'; ?>
    <?php include 'includes/sidebar-soalan.php'; ?>

    <!--=============== MAIN ===============-->
    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: fixed; top: 14%; left: 20%; z-index: 2;">
            SET <?php echo htmlspecialchars($ex_tajuk); ?></h1>
        <div class="box"
            style="height: 62%;  font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400; position: relative; left: 30%; transform: translate(-50%, 10%); background-color: black;">
            <form action="<?php echo $form_action; ?>" method="post">
                <div class="form-group">
                    <label for="tajuk">Tajuk :</label>
                    <input type="text" id="tajuk" name="tajuk" value="<?php echo htmlspecialchars($ex_tajuk); ?>"
                        readonly style="background-color: #333333;">
                </div>

                <div class="form-group">
                    <label for="question">Soalan :</label>
                    <input type="text" id="question" name="question" style="background-color: #333333;">
                </div>
                <div class="form-group">
                    <label for="question">Pilihan Jawapan :</label>
                    <div class="options-container">
                        <div class="option-row">
                            <span class="icon">A</span>
                            <input type="text" id="option1" name="option1" placeholder="Pilihan Jawapan 1"
                                style="background-color: #333333;">
                            <span class="icon">B</span>
                            <input type="text" id="option2" name="option2" placeholder="Pilihan Jawapan 2"
                                style="background-color: #333333;">
                        </div>
                        <div class="option-row">
                            <span class="icon">C</span>
                            <input type="text" id="option3" name="option3" placeholder="Pilihan Jawapan 3"
                                style="background-color: #333333;">
                            <span class="icon">D</span>
                            <input type="text" id="option4" name="option4" placeholder="Pilihan Jawapan 4"
                                style="background-color: #333333;">
                        </div>
                    </div>
                </div>

                <div class="form-group-1">
                    <label for="correct_answer">Jawapan Sebenar :</label>
                    <input style="width: 80%; background-color: #333333;" type="text" id="correct_answer"
                        name="correct_answer" class="jawapan-input" value="Pilihan A" readonly>
                </div>
                <input type="submit" value="Sahkan">
            </form>
        </div>
    </main>

    <!--=============== MAIN JS ===============-->
    <script src="../assets/js/main.js"></script>

</body>

</html>