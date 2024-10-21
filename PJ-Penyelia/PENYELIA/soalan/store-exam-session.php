<?php
session_start();

// Check if ex_id is passed and set it in session
if (isset($_GET['ex_id'])) {
    $_SESSION['current_ex_id'] = $_GET['ex_id'];
    header("Location: urus-soalan.php");
    exit();
} else {
    // If ex_id is not set, redirect to home page or an error page
    header("Location: home-soalan.php");
    exit();
}
?>