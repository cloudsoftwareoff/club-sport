<?php
// src/models/User.php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByUsernameOrEmail($usernameOrEmail) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :usernameOrEmail OR email = :usernameOrEmail LIMIT 1");
        $stmt->execute(['usernameOrEmail' => $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserData($usernameOrEmail) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1");
        $stmt->execute(['username' => $usernameOrEmail, 'email' => $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, gender, phone_number, address, created_at, is_active, role) 
                                     VALUES (:username, :email, :password_hash, :first_name, :last_name, :date_of_birth, :gender, :phone_number, :address, NOW(), 1, 'user')");
        return $stmt->execute($data);
    }

    public function update($data) {
        $stmt = $this->pdo->prepare("UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name WHERE id = :id");
        return $stmt->execute($data);
    }
}
?>
