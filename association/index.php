<?php
// public/dashboard.php

require_once __DIR__ . '/../src/db_connection.php';
require_once __DIR__ . '/../src/controllers/AssociationController.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'association') {
    header("Location: ../u/index.php");
    exit();
}
$logged=true;
$association_id = $_SESSION['user_id'];
$associationController = new AssociationController($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verify'])) {
        $athlete_id = $_POST['athlete_id'];
        $associationController->verifyAthlete($athlete_id);
    } elseif (isset($_POST['add_event'])) {
        $eventData = [
            'title' => htmlspecialchars($_POST['title']),
            'description' => htmlspecialchars($_POST['description']),
            'date' => htmlspecialchars($_POST['date']),
            'time' => htmlspecialchars($_POST['time']),
            'location' => htmlspecialchars($_POST['location']),
            'createdBy' => $association_id
        ];
        $associationController->createEvent($eventData);
    }
}

$athletes = $associationController->getAthletes($association_id);
$events = $associationController->getEvents($association_id);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de l'Association</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">

</head>
<body>
          <!-- header -->
          <div class="header">
         <div class="container-fluid">
            <div class="row d_flex">
               <div class=" col-md-2 col-sm-3 col logo_section">
                  <div class="full">
                     <div class="center-desk">
                        <div class="logo">
                           <a href="index.html"><img src="../images/logo.png" alt="#" /></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-8 col-sm-12">
                  <nav class="navigation navbar navbar-expand-md navbar-dark ">
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mr-auto">
                           <li class="nav-item">
                              <a class="nav-link" href="../index.php">Home</a>
                           </li>
                           <li class="nav-item active">
                              <a class="nav-link" href="#">Dashboard</a>
                           </li>
                      
                        </ul>
                     </div>
                  </nav>
               </div>
               <div class="col-md-2">
                  <ul class="email text_align_right">
                     <li class="d_none">
                     <a href="<?php echo $logged ?  '../profile.php' : '../u/signup.php'; ?>">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        </a>
                     
                     </li>
                    
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- end header inner -->

      <br/>
      <br/>
      <br/>
      <br/>
<div class="container mt-5">
    <h2>Dashboard de l'Association</h2>

    <h3>Gérer les Athlètes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Vérifié</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($athletes as $athlete): ?>
                <tr>
                    <td><?php echo htmlspecialchars($athlete['username']); ?></td>
                    <td><?php echo htmlspecialchars($athlete['email']); ?></td>
                    <td><?php echo htmlspecialchars($athlete['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($athlete['last_name']); ?></td>
                    <td><?php echo $athlete['isVerified'] ? 'Oui' : 'Non'; ?></td>
                    <td>
                        <?php if (!$athlete['isVerified']): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="athlete_id" value="<?php echo $athlete['id']; ?>">
                                <button type="submit" name="verify" class="btn btn-success">Vérifier</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Ajouter un Événement</h3>
    <form action="" method="POST">
        <div class="form-group">
            <label for="eventTitle">Titre de l'événement</label>
            <input type="text" class="form-control" id="eventTitle" name="title" required>
        </div>
        <div class="form-group">
            <label for="eventDescription">Description</label>
            <textarea class="form-control" id="eventDescription" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="eventDate">Date</label>
            <input type="date" class="form-control" id="eventDate" name="date" required>
        </div>
        <div class="form-group">
            <label for="eventTime">Heure</label>
            <input type="time" class="form-control" id="eventTime" name="time" required>
        </div>
        <div class="form-group">
            <label for="eventLocation">Lieu</label>
            <input type="text" class="form-control" id="eventLocation" name="location" required>
        </div>
        <button type="submit" name="add_event" class="btn btn-primary">Ajouter</button>
    </form>

    <h3>Événements</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Lieu</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                    <td><?php echo htmlspecialchars($event['description']); ?></td>
                    <td><?php echo htmlspecialchars($event['date']); ?></td>
                    <td><?php echo htmlspecialchars($event['time']); ?></td>
                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                    <td><?php echo htmlspecialchars($event['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
