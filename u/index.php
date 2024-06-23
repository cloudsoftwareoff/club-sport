<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Authentification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-group-vertical .btn {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Bienvenue</h1>
    <p class="text-center">Veuillez vous connecter ou vous inscrire en tant qu'association ou athlète.</p>
    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center">Connexion</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2 class="text-center">Inscription</h2>
            <div class="btn-group-vertical d-flex justify-content-center">
                <a href="signup.php?type=association" class="btn btn-secondary btn-lg">Inscription Association</a>
                <a href="signup.php?type=athlete" class="btn btn-secondary btn-lg">Inscription Athlète</a>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
