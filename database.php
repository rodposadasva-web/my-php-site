<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host     = getenv('DB_HOST')     ?: 'mysql-2f5b2346-calasiao-portal.l.aivencloud.com';
$user     = getenv('DB_USER')     ?: 'avnadmin';
$password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME')     ?: 'defaultdb';
$port     = (int)(getenv('DB_PORT') ?: 14539);

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

$connected = @mysqli_real_connect(
    $conn, 
    $host, 
    $user, 
    $password, 
    $database, 
    $port, 
    NULL, 
    MYSQLI_CLIENT_SSL
);

if (!$connected) {
    die("Connection failed: " . mysqli_connect_error());
}
?>