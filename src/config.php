<?php


// $host = 'sql113.infinityfree.com'; 
// $db = 'if0_36757206_sport'; 
// $user = 'if0_36757206';  
// $pass = 'pflMvbKxwF6NOIJ';  

// // Data Source Name (DSN)
// $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

// // PDO
// $options = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];






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
