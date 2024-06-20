<?php
// public/create_event.php

require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/EventController.php';

session_start();

$pdo = new PDO($dsn, $user, $pass, $options);
$eventController = new EventController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'date' => $_POST['date'],
        'time' => $_POST['time'],
        'location' => $_POST['location'],
        'createdBy' => $_POST['createdBy']
    ];
    $result = $eventController->create($data);

    if ($result) {
        echo "Event created successfully!";
    } else {
        echo "Failed to create event.";
    }
}
?>
