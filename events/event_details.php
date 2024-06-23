<?php
// public/event_details.php

require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/EventController.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$eventController = new EventController($pdo);

$event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$event = $eventController->read($event_id);

if (!$event) {
    echo "Event not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Event Details</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($event['id']); ?></td>
        </tr>
        <tr>
            <th>Title</th>
            <td><?php echo htmlspecialchars($event['title']); ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?php echo htmlspecialchars($event['description']); ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?php echo htmlspecialchars($event['date']); ?></td>
        </tr>
        <tr>
            <th>Time</th>
            <td><?php echo htmlspecialchars($event['time']); ?></td>
        </tr>
        <tr>
            <th>Location</th>
            <td><?php echo htmlspecialchars($event['location']); ?></td>
        </tr>
        <tr>
            <th>Created By</th>
            <td><?php echo htmlspecialchars($event['createdBy']); ?></td>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?php echo htmlspecialchars($event['created_at']); ?></td>
        </tr>
    </table>
    <a href="list_events.php" class="btn btn-primary">Back to Events</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
