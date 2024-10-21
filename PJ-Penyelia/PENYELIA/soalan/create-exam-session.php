<?php
session_start();

// Check if ex_id is set in the URL
if (isset($_SESSION['current_ex_id'])) {
    // Redirect to urus-create-soalan.php with the current ex_id
    header("Location: urus-create-soalan.php?ex_id=" . urlencode($_SESSION['current_ex_id']));
    exit();
} else {
    // If ex_id is not set, redirect to home-soalan.php
    header("Location: home-soalan.php");
    exit();
}