<?php
$host = getenv('DB_HOST') ?: 'smkpl.h.filess.io';
$dbname = getenv('DB_NAME') ?: 'pj_creaturehe';
$user = getenv('DB_USER') ?: 'pj_creaturehe';
$pass = getenv('DB_PASS') ?: '05b97a4fe0b4d15e14f861aa1399b8280237659a';
$port = getenv('DB_PORT') ?: '3307';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Database Connected!"; // Uncomment to debug
} catch (PDOException $e) {
    die("❌ Database Connection Failed: " . $e->getMessage());
}
?>
