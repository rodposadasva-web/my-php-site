<?php
$host     = 'mysql-2f5b2346-calasiao-portal.l.aivencloud.com';
$user     = 'avnadmin';
$password = 'YOUR_AIVEN_PASSWORD_HERE';
$database = 'defaultdb';
$port     = 14539;

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