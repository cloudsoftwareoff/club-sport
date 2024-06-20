<?php

require 'config.php';

try {
    // PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    
    echo "Database connection failed: " . $e->getMessage();
}
?>
