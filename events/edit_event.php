<?php
// public/edit_event.php

require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/EventController.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$eventController = new EventController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'date' => $_POST['date'],
        'time' => $_POST['time'],
        'location' => $_POST['location'],
        'createdBy' => $_POST['createdBy'] // Ensure this field is also included
    ];
    $result = $eventController->update($data);

    if ($result) {
        echo "Event updated successfully!";
    } else {
        echo "Failed to update event.";
    }
} else {
    // Retrieve and display the event for editing
    $event = $eventController->read($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Event</h2>
    <form action="edit_event.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
        <div class="form-group">
            <label for="eventTitle">Title</label>
            <input type="text" class="form-control" id="eventTitle" name="title" value="<?php echo $event['title']; ?>" required>
        </div>
        <div class="form-group">
            <label for="eventDescription">Description</label>
            <textarea class="form-control" id="eventDescription" name="description" required><?php echo $event['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="eventDate">Date</label>
            <input type="date" class="form-control" id="eventDate" name="date" value="<?php echo $event['date']; ?>" required>
        </div>
        <div class="form-group">
            <label for="eventTime">Time</label>
            <input type="time" class="form-control" id="eventTime" name="time" value="<?php echo $event['time']; ?>" required>
        </div>
        <div class="form-group">
            <label for="eventLocation">Location</label>
            <input type="text" class="form-control" id="eventLocation" name="location" value="<?php echo $event['location']; ?>" required>
        </div>
        <input type="hidden" name="createdBy" value="<?php echo $event['createdBy']; ?>">
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>
