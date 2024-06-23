<?php
class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function readAll() {
        $stmt = $this->pdo->query('SELECT id, username, email, first_name, last_name, date_of_birth, gender, phone_number, address, is_active, role, isVerified FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readUser($id) {
        $stmt = $this->pdo->prepare('SELECT id, username, email, first_name, last_name, date_of_birth, gender, phone_number, address, is_active, role, isVerified FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $email, $password_hash, $first_name = null, $last_name = null, $date_of_birth = null, $gender = null, $phone_number = null, $address = null, $role = 'user', $is_active = 1, $isVerified = 0) {
        $stmt = $this->pdo->prepare('INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, gender, phone_number, address, role, is_active, isVerified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$username, $email, $password_hash, $first_name, $last_name, $date_of_birth, $gender, $phone_number, $address, $role, $is_active, $isVerified]);
    }

    public function updateUser($id, $username, $email, $password_hash = null, $first_name = null, $last_name = null, $date_of_birth = null, $gender = null, $phone_number = null, $address = null, $role = 'user', $is_active = 1, $isVerified = 0) {
        if ($password_hash) {
            $stmt = $this->pdo->prepare('UPDATE users SET username = ?, email = ?, password_hash = ?, first_name = ?, last_name = ?, date_of_birth = ?, gender = ?, phone_number = ?, address = ?, role = ?, is_active = ?, isVerified = ? WHERE id = ?');
            return $stmt->execute([$username, $email, $password_hash, $first_name, $last_name, $date_of_birth, $gender, $phone_number, $address, $role, $is_active, $isVerified, $id]);
        } else {
            $stmt = $this->pdo->prepare('UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, date_of_birth = ?, gender = ?, phone_number = ?, address = ?, role = ?, is_active = ?, isVerified = ? WHERE id = ?');
            return $stmt->execute([$username, $email, $first_name, $last_name, $date_of_birth, $gender, $phone_number, $address, $role, $is_active, $isVerified, $id]);
        }
    }

    public function deleteUseAr($id) {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>
