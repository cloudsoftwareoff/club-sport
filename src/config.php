<?php


$host = 'localhost'; 
$db = 'sport'; 
$user = 'admin';  
$pass = 'cloudsoftware';  

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

// PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
?>
