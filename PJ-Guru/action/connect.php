<?php	

$host = "smkpl.h.filess.io"; // Remote database host
$dbusername = "pj_creaturehe"; // Your database username
$dbpassword = "05b97a4fe0b4d15e14f861aa1399b8280237659a"; // Your database password
$dbname = "pj_creaturehe"; // Your database name
$port = 3307; // The port number

// Database connection
$condb = mysqli_connect($host, $dbusername, $dbpassword, $dbname, $port);

// Check connection
if (!$condb) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully!";
}

?>
