<?php
require_once __DIR__ . '../src/db_connection.php';
require_once __DIR__ . '../src/models/User.php';

session_start();
$user_id = $_SESSION['username'] ?? null;

if (!$user_id) {
    echo "User not logged in";
    exit;
}

$userClass = new User($pdo);
$userData = $userClass->getUserData($user_id);

if (!$userData) {
    echo "User not found";
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Prepare data for update
    $updateData = [
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'id' => $userData['id']  
    ];

    // Update user information
    $result = $userClass->update($updateData);

    if ($result) {
        echo "Profile updated successfully";
        // Redirect to profile page
        header("Location: profile.php");
        exit;
    } else {
        echo "Failed to update profile";
    }
}
?>
