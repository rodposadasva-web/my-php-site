<?php
$host     = getenv('DB_HOST')     ?: 'mysql-2f5b2346-calasiao-portal.l.aivencloud.com';
$port     = getenv('DB_PORT')     ?: 14539;
$user     = getenv('DB_USER')     ?: 'avnadmin';
$password = getenv('DB_PASSWORD') ?: '';
$dbname   = getenv('DB_NAME')     ?: 'defaultdb';

$conn = mysqli_connect($host, $user, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
