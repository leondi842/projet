<?php
// confirmation_reservation.php

if (!isset($_GET['chambre'], $_GET['debut'], $_GET['fin'])) {
    header("Location: accueil.php");
    exit();
}

$numero_chambre = htmlspecialchars($_GET['chambre']);
$date_debut = htmlspecialchars($_GET['debut']);
$date_fin = htmlspecialchars($_GET['fin']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Réservation confirmée</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-success-subtle d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="accueil.php">Maison des Hôtes</a>
    </div>
</nav>

<div class="container my-auto d-flex justify-content-center align-items-center flex-grow-1">
    <div class="alert alert-success text-center shadow p-5 rounded" style="max-width: 600px;">
        <h2 class="alert-heading mb-3">Réservation confirmée !</h2>
        <p class="fs-5">
            Vous avez réservé la chambre <strong><?= $numero_chambre ?></strong><br>
            du <strong><?= $date_debut ?></strong> au <strong><?= $date_fin ?></strong>.
        </p>
        <p class="text-success">Un e-mail de confirmation vous a été envoyé.</p>
        <a href="accueil.php" class="btn btn-success mt-3">Retour à l'accueil</a>
    </div>
</div>

<footer class="bg-primary text-white text-center py-3">
    &copy; <?= date('Y') ?> Maison des Hôtes - Université Norbert Zongo
</footer>

</body>
</html>
