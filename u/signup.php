<?php
// public/signup.php

require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'username' => htmlspecialchars($_POST['username']),
        'email' => htmlspecialchars($_POST['email']),
        'password' => htmlspecialchars($_POST['password']),
        'first_name' => htmlspecialchars($_POST['first_name']),
        'last_name' => htmlspecialchars($_POST['last_name']),
        'date_of_birth' => htmlspecialchars($_POST['date_of_birth']),
        'gender' => htmlspecialchars($_POST['gender']),
        'phone_number' => htmlspecialchars($_POST['phone_number']),
        'address' => htmlspecialchars($_POST['address']),
    ];

    $authController = new AuthController($pdo);
    if ($authController->signup($data)) {
        header("Location: login.php");
    } else {
        echo "Error registering user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Signup</h2>
    <form action="signup.php" method="POST">
        <div class="form-group">
            <label for="signupUsername">Username</label>
            <input type="text" class="form-control" id="signupUsername" name="username" required>
        </div>
        <div class="form-group">
            <label for="signupEmail">Email</label>
            <input type="email" class="form-control" id="signupEmail" name="email" required>
        </div>
        <div class="form-group">
            <label for="signupPassword">Password</label>
            <input type="password" class="form-control" id="signupPassword" name="password" required>
        </div>
        <div class="form-group">
            <label for="signupFirstName">First Name</label>
            <input type="text" class="form-control" id="signupFirstName" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="signupLastName">Last Name</label>
            <input type="text" class="form-control" id="signupLastName" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="signupDOB">Date of Birth</label>
            <input type="date" class="form-control" id="signupDOB" name="date_of_birth" required>
        </div>
        <div class="form-group">
            <label for="signupGender">Gender</label>
            <select class="form-control" id="signupGender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="signupPhone">Phone Number</label>
            <input type="text" class="form-control" id="signupPhone" name="phone_number" required>
        </div>
        <div class="form-group">
            <label for="signupAddress">Address</label>
            <textarea class="form-control" id="signupAddress" name="address" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Signup</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
