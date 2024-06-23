<?php
require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/UserController.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admins') {
    header("Location: ../u/index.php");
    exit();
}

// Establish a database connection
$pdo = new PDO($dsn, $user, $pass, $options);
$userController = new UserController($pdo);

// Handle actions like add, edit, delete
$action = $_GET['action'] ?? '';
$userId = $_GET['id'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $first_name = $_POST['first_name'] ?? null;
        $last_name = $_POST['last_name'] ?? null;
        $date_of_birth = $_POST['date_of_birth'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $phone_number = $_POST['phone_number'] ?? null;
        $address = $_POST['address'] ?? null;
        $role = $_POST['role'] ?? 'user';
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $isVerified = isset($_POST['isVerified']) ? 1 : 0;
        $userController->createUser($username, $email, $password_hash, $first_name, $last_name, $date_of_birth, $gender, $phone_number, $address, $role, $is_active, $isVerified);
        $message = 'User added successfully.';
    } elseif ($action === 'edit' && $userId) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $first_name = $_POST['first_name'] ?? null;
        $last_name = $_POST['last_name'] ?? null;
        $date_of_birth = $_POST['date_of_birth'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $phone_number = $_POST['phone_number'] ?? null;
        $address = $_POST['address'] ?? null;
        $role = $_POST['role'] ?? 'user';
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $isVerified = isset($_POST['isVerified']) ? 1 : 0;
        if (!empty($_POST['password'])) {
            $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $userController->updateUser($userId, $username, $email, $password_hash, $first_name, $last_name, $date_of_birth, $gender, $phone_number, $address, $role, $is_active, $isVerified);
        } else {
            $userController->updateUser($userId, $username, $email, null, $first_name, $last_name, $date_of_birth, $gender, $phone_number, $address, $role, $is_active, $isVerified);
        }
        $message = 'User updated successfully.';
    } elseif ($action === 'delete' && $userId) {
        $userController->deleteUser($userId);
        $message = 'User deleted successfully.';
    }
}

// Fetch all users
$users = $userController->readAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Manage Users</h1>
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- User List -->
    <h2>Users</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Active</th>
            <th>Role</th>
            <th>Verified</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                <td><?php echo htmlspecialchars($user['date_of_birth']); ?></td>
                <td><?php echo htmlspecialchars($user['gender']); ?></td>
                <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
                <td><?php echo htmlspecialchars($user['is_active'] ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td><?php echo htmlspecialchars($user['isVerified'] ? 'Yes' : 'No'); ?></td>
                <td>
                    <a href="manageusers.php?action=edit&id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="manageusers.php?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add/Edit User Form -->
    <h2><?php echo $action === 'edit' && $userId ? 'Edit User' : 'Add User'; ?></h2>
    <form action="manageusers.php?action=<?php echo $action; ?><?php echo $userId ? '&id=' . $userId : ''; ?>" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['username']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['email']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['first_name']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['last_name']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['date_of_birth']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="Male" <?php echo $action === 'edit' && $userId && $userController->readUser($userId)['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $action === 'edit' && $userId && $userController->readUser($userId)['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo $action === 'edit' && $userId && $userController->readUser($userId)['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['phone_number']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control"><?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['address']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" name="role" id="role" class="form-control" value="<?php echo $action === 'edit' && $userId ? htmlspecialchars($userController->readUser($userId)['role']) : 'user'; ?>">
        </div>
        <div class="form-group">
            <label for="is_active">Active</label>
            <input type="checkbox" name="is_active" id="is_active" <?php echo $action === 'edit' && $userId && $userController->readUser($userId)['is_active'] ? 'checked' : ''; ?>>
        </div>
        <div class="form-group">
            <label for="isVerified">Verified</label>
            <input type="checkbox" name="isVerified" id="isVerified" <?php echo $action === 'edit' && $userId && $userController->readUser($userId)['isVerified'] ? 'checked' : ''; ?>>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" <?php echo $action === 'edit' && $userId ? '' : 'required'; ?>>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $action === 'edit' && $userId ? 'Update' : 'Add'; ?> User</button>
    </form>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
