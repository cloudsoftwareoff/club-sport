<?php


require '../config.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $date_of_birth = htmlspecialchars($_POST['date_of_birth']);
    $gender = htmlspecialchars($_POST['gender']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Prepare an SQL statement to prevent SQL injection
    $sql = "INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, gender, phone_number, address, created_at, is_active, role) 
            VALUES (:username, :email, :password_hash, :first_name, :last_name, :date_of_birth, :gender, :phone_number, :address, NOW(), 1, 'user')";

    try {
        // Create a new PDO instance
        $pdo = new PDO($dsn, $user, $pass, $options);
        
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':address', $address);
        
        // Execute the statement
        $stmt->execute();
        
        echo "User registered successfully!";
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
}
?>
