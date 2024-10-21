<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Redirect to home.php
header("Location: home.php");
exit();
?>
