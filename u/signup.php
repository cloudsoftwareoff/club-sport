<?php
// public/signup.php

require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

// Fetch associations for the dropdown
$query = $pdo->query('SELECT id, username FROM users WHERE role = "association"');
$associations = $query->fetchAll(PDO::FETCH_ASSOC);

// Capture the type parameter from the GET request
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';

// Process the form submission
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
        'role' => htmlspecialchars($_POST['role']),
        'association_id' => isset($_POST['association_id']) && !empty($_POST['association_id']) ? htmlspecialchars($_POST['association_id']) : null
    ];

    $authController = new AuthController($pdo);
    if ($authController->signup($data)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Erreur lors de l'enregistrement de l'utilisateur.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
        }
        .form-title {
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            padding: 10px;
        }
        .btn-primary {
            padding: 10px 20px;
        }
        .row .col-md-6 {
            padding: 0 15px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="form-title">Inscription</h2>
    <form action="signup.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="signupUsername">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="signupUsername" name="username" required>
                </div>
                <div class="form-group">
                    <label for="signupEmail">Email</label>
                    <input type="email" class="form-control" id="signupEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="signupPassword">Mot de passe</label>
                    <input type="password" class="form-control" id="signupPassword" name="password" required>
                </div>
                <div class="form-group">
                    <label for="signupFirstName">Prénom</label>
                    <input type="text" class="form-control" id="signupFirstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="signupLastName">Nom</label>
                    <input type="text" class="form-control" id="signupLastName" name="last_name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="signupDOB">Date de naissance</label>
                    <input type="date" class="form-control" id="signupDOB" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label for="signupGender">Genre</label>
                    <select class="form-control" id="signupGender" name="gender" required>
                        <option value="Male">Homme</option>
                        <option value="Female">Femme</option>
                        <option value="Other">Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="signupPhone">Numéro de téléphone</label>
                    <input type="text" class="form-control" id="signupPhone" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="signupAddress">Adresse</label>
                    <textarea class="form-control" id="signupAddress" name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="signupRole">Rôle</label>
                    <select class="form-control" id="signupRole" name="role" required>
                        <option value="association" <?php echo $type == 'association' ? 'selected' : ''; ?>>Association</option>
                        <option value="athlete" <?php echo $type == 'athlete' ? 'selected' : ''; ?>>Athlète</option>
                    </select>
                </div>
                <div class="form-group" id="associationSelect" style="display: <?php echo $type == 'athlete' ? 'block' : 'none'; ?>;">
                    <label for="signupAssociation">Sélectionnez une association</label>
                    <select class="form-control" id="signupAssociation" name="association_id">
                        <option value="">Aucune</option>
                        <?php foreach ($associations as $association): ?>
                            <option value="<?php echo $association['id']; ?>"><?php echo htmlspecialchars($association['username']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
    </form>
    <p class="mt-3">Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a></p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.getElementById('signupRole').addEventListener('change', function() {
        var role = this.value;
        var associationSelect = document.getElementById('associationSelect');
        if (role === 'athlete') {
            associationSelect.style.display = 'block';
        } else {
            associationSelect.style.display = 'none';
        }
    });
</script>
</body>
</html>
