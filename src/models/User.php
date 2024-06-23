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
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, gender, phone_number, address, created_at, is_active, role, association_id) 
                                     VALUES (:username, :email, :password_hash, :first_name, :last_name, :date_of_birth, :gender, :phone_number, :address, NOW(), 1, :role, :association_id)");
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password_hash', $data['password_hash']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':date_of_birth', $data['date_of_birth']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':role', $data['role']);
    
        // Handle association_id
        if (isset($data['association_id']) && !empty($data['association_id'])) {
            $stmt->bindParam(':association_id', $data['association_id'], PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':association_id', null, PDO::PARAM_NULL);
        }
    
        return $stmt->execute();
    }
    
    
    public function update($data) {
        $stmt = $this->pdo->prepare("UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name WHERE id = :id");
        return $stmt->execute($data);
    }

    public function verifyAthlete($id) {
        $stmt = $this->pdo->prepare("UPDATE users SET isVerified = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAthletesByAssociation($association_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'athlete' AND association_id = :association_id");
        $stmt->bindParam(':association_id', $association_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
