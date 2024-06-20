<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Create Event</h2>
    <form action="create_event.php" method="POST">
        <div class="form-group">
            <label for="eventTitle">Title</label>
            <input type="text" class="form-control" id="eventTitle" name="title" required>
        </div>
        <div class="form-group">
            <label for="eventDescription">Description</label>
            <textarea class="form-control" id="eventDescription" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="eventDate">Date</label>
            <input type="date" class="form-control" id="eventDate" name="date" required>
        </div>
        <div class="form-group">
            <label for="eventTime">Time</label>
            <input type="time" class="form-control" id="eventTime" name="time" required>
        </div>
        <div class="form-group">
            <label for="eventLocation">Location</label>
            <input type="text" class="form-control" id="eventLocation" name="location" required>
        </div>
        <!-- Hidden field for createdBy -->
        <input type="hidden" name="createdBy" value="<?php echo $_SESSION['user_id']; ?>">
        <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
