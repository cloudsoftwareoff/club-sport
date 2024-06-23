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
            $_SESSION['role'] = $user['role'] ?? NULL;

            return "Login successful!";
        } else {
            return "Invalid username/email or password.";
        }
    }

    public function signup($data) {
        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['profile_picture']="https://i.pinimg.com/564x/91/ef/c7/91efc7494a6f79cde815f4bb473d2a9c.jpg";
        unset($data['password']);
        echo $data['password'];
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
