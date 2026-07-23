<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'campus_event_hub';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('Database connection failed. Please check the settings in includes/db.php.');
}

mysqli_set_charset($conn, 'utf8mb4');
