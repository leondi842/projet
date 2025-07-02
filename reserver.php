<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['chambre'])) {
    die("Aucune chambre sélectionnée.");
}

$numero_chambre = $_GET['chambre'];
$date_debut = $_SESSION['date_debut'] ?? null;
$date_fin = $_SESSION['date_fin'] ?? null;

if (!$date_debut || !$date_fin) {
    die("Dates de réservation manquantes.");
}

// Connexion BDD (ajuste selon ton config)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur connexion BDD: " . $conn->connect_error);
}

$utilisateur_id = $_SESSION['user_id'];

// Récupérer le rôle utilisateur
$stmt = $conn->prepare("SELECT role FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $utilisateur_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

// Calcul du nombre de nuits
$diff = (new DateTime($date_debut))->diff(new DateTime($date_fin));
$nights = $diff->days;
if ($nights <= 0) {
    die("La date de fin doit être après la date de début.");
}

$prix_par_nuit = 7500;
$montant = ($role === 'intervenant') ? $prix_par_nuit * $nights : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $moyen_paiement = null;
    if ($role === 'intervenant') {
        $moyen_paiement = $_POST['moyen_paiement'] ?? null;
        if (!$moyen_paiement) {
            echo "<div class='alert alert-danger'>Veuillez sélectionner un moyen de paiement.</div>";
            exit();
        }
    }

    $date_reservation = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO reservations (utilisateur_id, numero_chambre, date_debut, date_fin, date_reservation, moyen_paiement, montant) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssi", $utilisateur_id, $numero_chambre, $date_debut, $date_fin, $date_reservation, $moyen_paiement, $montant);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Réservation confirmée ! Montant payé : " . number_format($montant, 0, ',', ' ') . " FCFA</div>";
        // Tu peux faire une redirection ou afficher un lien vers la page d'accueil ou autre
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la réservation : " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Réservation chambre n°<?= htmlspecialchars($numero_chambre) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Réserver la chambre n°<?= htmlspecialchars($numero_chambre) ?></h2>
    <p>Du <strong><?= htmlspecialchars($date_debut) ?></strong> au <strong><?= htmlspecialchars($date_fin) ?></strong> (<?= $nights ?> nuits)</p>
    <p>Montant total : <strong><?= number_format($montant, 0, ',', ' ') ?> FCFA</strong></p>

    <form method="POST">
        <?php if ($role === 'intervenant'): ?>
        <div class="mb-3">
            <label for="moyen_paiement" class="form-label">Choisissez un moyen de paiement</label>
            <select name="moyen_paiement" id="moyen_paiement" class="form-select" required>
                <option value="">-- Sélectionnez --</option>
                <option value="Orange Money">Orange Money</option>
                <option value="Moov Money">Moov Money</option>
                <option value="Coris">Coris</option>
            </select>
        </div>
        <?php else: ?>
        <p>Votre rôle vous permet de réserver gratuitement.</p>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Confirmer la réservation</button>
        <a href="recherche_dispo.php" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>
</body>
</html>
