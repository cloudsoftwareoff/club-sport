<?php
// public/login.php

require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$authController = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = $_POST['username_or_email'];
    $password = $_POST['password'];
    $result = $authController->login($usernameOrEmail, $password);
    echo $result;
    echo $_SESSION['role'];
    session_start();
    if ($_SESSION['user_id'] != null) {
        header("Location: ../index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Connexion</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="loginUsername">Nom d'utilisateur ou Email</label>
            <input type="text" class="form-control" id="loginUsername" name="username_or_email" required>
        </div>
        <div class="form-group">
            <label for="loginPassword">Mot de passe</label>
            <input type="password" class="form-control" id="loginPassword" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <p class="mt-3">Vous n'avez pas de compte ? <a href="signup.php">Créez-en un</a></p>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
