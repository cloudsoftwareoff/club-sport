<?php
// src/controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $pdo;
    private $userModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }

    public function login($usernameOrEmail, $password) {
        $user = $this->userModel->getUserData($usernameOrEmail);

        if ($user && password_verify($password, $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            return "Login successful!";
        } else {
            return "Invalid username/email or password.";
        }
    }

    public function signup($data) {
        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['password']);
        return $this->userModel->create($data);
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /public/login.php");
        exit;
    }
}

?>
