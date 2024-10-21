<?php
include 'action/connect.php';

session_start();
include 'guard-murid.php';

// Retrieve the ex_id from the URL
$ex_id = isset($_GET['ex_id']) ? intval($_GET['ex_id']) : 0;

// Fetch questions and duration specific to the ex_id
$sql = "SELECT s.*, e.ex_minit FROM exam_soalan s JOIN exam_set e ON s.ex_id = e.ex_id WHERE s.ex_id = ?";
$stmt = $condb->prepare($sql);
$stmt->bind_param("i", $ex_id);
$stmt->execute();
$result = $stmt->get_result();
$questions = [];
$exam_duration = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
        $exam_duration = $row['ex_minit']; // Get the duration from the first row (assuming it's the same for all questions in the same exam)
    }
} else {
    echo "No questions found.";
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/soalan.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Murid • Ujian</title>
</head>

<body>
    <img src="assets/img/blue.png" alt="sidebar img">

    <?php include 'includes/header-murid.php'; ?>
    <?php include 'includes/sidebar-murid.php'; ?>

    <main class="main container" id="main" style="margin-top: -117%; margin-left: 0%;">
        <div class="row">
            <div class="col-md-8">
                <form action="db-jawapan/jawapan-murid.php" method="POST" class="quiz-container murid"
                    style="width: 650px; transform: translateX(20%); border: 1px solid white;">
                    <input type="hidden" name="ex_id" value="<?= $ex_id; ?>">

                    <?php
                    $question_number = 1;

                    if (count($questions) > 0) {
                        // Directory where images are stored
                        $imageDirectory = 'gambar-soalan/';

                        // Initialize an array to hold image file names
                        $imageLibrary = [];

                        // Open the directory
                        if ($handle = opendir($imageDirectory)) {
                            // Loop through directory entries
                            while (false !== ($entry = readdir($handle))) {
                                // Check if the entry is a file
                                if (is_file($imageDirectory . $entry)) {
                                    // Check if the file is an image (you can add more image extensions if needed)
                                    $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
                                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        // Add the file to the image library array
                                        $imageLibrary[] = $entry;
                                    }
                                }
                            }
                            closedir($handle);
                        }

                        // Check if there are any images found
                        if (count($imageLibrary) > 0) {
                            foreach ($questions as $row) {
                                // Select a random image from the library
                                $randomImage = $imageDirectory . $imageLibrary[array_rand($imageLibrary)];

                                // Create an array of choices and shuffle it
                                $choices = array(
                                    $row["pilihan_1"],
                                    $row["pilihan_2"],
                                    $row["pilihan_3"],
                                    $row["pilihan_4"]
                                );
                                shuffle($choices);

                                echo '<div class="question-container murid">';
                                echo '<div class="question-number murid" style="font-family: \'Montserrat\', sans-serif; font-size: 24px;">Soalan ' . $question_number . '</div>';
                                echo '<div class="quiz-content murid">';
                                echo '<div class="question-image murid">';
                                echo '<img src="' . $randomImage . '" alt="Question Image" class="murid">';
                                echo '</div>';
                                echo '<div class="question-text murid">';
                                echo '<p>' . $row["soalan"] . '</p>';
                                echo '<div class="choices murid">';
                                foreach ($choices as $choice) {
                                    echo '<button type="button" class="choice murid" data-question="' . $row['soalan_id'] . '" data-choice="' . $choice . '">' . $choice . '</button>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<input type="hidden" name="answers[' . $row['soalan_id'] . ']" id="answer_' . $row['soalan_id'] . '" value="">';
                                $question_number++;
                            }
                        } else {
                            echo "No images found in folder 'gambar/'.";
                        }
                    } else {
                        echo "No questions found.";
                    }
                    ?>

                    <div class="submit-button-container">
                        <button type="submit" class="submit-button murid"
                            style="position: absolute; top: 98.8%; left:80%; background-color:green;">Sahkan</button>
                    </div>
                </form>
                <div id="overlay" class="overlay" style="display: none;">
                    <div class="overlay-content">
                        <p style="color:black;">Masa telah tamat. Sila tekan butang Kembali untuk kembali ke halaman
                            utama.</p>
                        <a href="jawab.php" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="question-progress"
                    style="width: 350px; transform: translate(44%, 20%) scale(0.9); position: fixed; border: 1px solid white; background-color: #333333;">
                    <h3 style="font-size:22px; color: white; font-family: 'Montserrat', sans-serif; font-weight: bold;">
                        Bil. Soalan</h3>
                    <ul id="question-list">
                        <?php
                        for ($i = 1; $i <= count($questions); $i++) {
                            echo '<li id="progress-question-' . $i . '" class="not-answered"><a href="#question-' . $i . '">' . $i . '</a></li>';
                        }
                        ?>
                    </ul>
                    <div class="timer-container"
                        style="transform: scale(0.7); width:50%; margin-left:26%; background-color: green;">
                        <div id="timer">
                            <?php echo $exam_duration; ?>:00
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const choices = document.querySelectorAll(".choice");
        const questionListItems = document.querySelectorAll("#question-list li");
        let timerElement = document.getElementById("timer");
        let timeRemaining = <?php echo $exam_duration * 60; ?>;

        // Timer function
        function startTimer(duration, display) {
            let timer = duration,
                minutes, seconds;
            const interval = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent =
                    minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    display.textContent = "Masa telah habis!";
                    blockPage();
                }
            }, 1000);
        }

        function blockPage() {
            document.querySelectorAll('input, button').forEach(function(element) {
                element.disabled = true;
            });
            document.getElementById('overlay').style.display = 'flex';
        }

        startTimer(timeRemaining, timerElement);

        choices.forEach(choice => {
            choice.addEventListener("click", function() {
                if (this.classList.contains("selected")) {
                    this.classList.remove("selected");
                } else {
                    const questionContainer = this.closest('.question-container');
                    const choicesInSameQuestion = questionContainer.querySelectorAll(".choice");

                    choicesInSameQuestion.forEach(c => c.classList.remove("selected"));
                    this.classList.add("selected");

                    // Set the hidden input value to the selected choice
                    const questionId = this.getAttribute("data-question");
                    const selectedChoice = this.getAttribute("data-choice");
                    document.getElementById('answer_' + questionId).value = selectedChoice;

                    // Update progress box color
                    const questionNumber = this.closest('.question-container').querySelector(
                        '.question-number').textContent.split(' ')[1];
                    document.getElementById('progress-question-' + questionNumber).classList
                        .remove("not-answered");
                    document.getElementById('progress-question-' + questionNumber).classList
                        .add("answered");
                }
            });
        });
    });
    </script>

    <style>
    .question-progress {
        background: black;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .question-progress ul {
        margin-top: 10px;
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .question-progress li {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
        text-align: center;
        background-color: #dc3545;
        /* Red background for not answered */
        color: white;
    }

    .question-progress li a {
        color: white;
        text-decoration: none;
        display: block;
    }

    .question-progress li.answered {
        background-color: #28a745;
        /* Green background for answered */
        color: white;
    }

    .timer-container {
        background: black;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .timer-container h3 {
        margin-bottom: 10px;
    }

    #timer {
        font-size: 2em;
        font-weight: bold;
    }

    .pagination-container {
        text-align: center;
        margin-top: 20px;
    }

    .pagination-submit-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination-submit-container .pagination {
        margin-bottom: 0;
    }

    .submit-button-container {
        margin-left: 20px;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .overlay-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .overlay-content p {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .overlay-content .btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
    }
    </style>
</body>

</html>