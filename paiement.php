<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$numero_chambre = $_GET['chambre'] ?? null;
$date_debut = $_GET['debut'] ?? null;
$date_fin = $_GET['fin'] ?? null;

if (!$numero_chambre || !$date_debut || !$date_fin) {
    header("Location: recherche_dispo.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

$utilisateur_id = $_SESSION['user_id'];
$date_reservation = date('Y-m-d H:i:s');

$datetime1 = new DateTime($date_debut);
$datetime2 = new DateTime($date_fin);
$interval = $datetime1->diff($datetime2);
$nb_nuits = $interval->days;

$error = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verif = $conn->prepare("SELECT COUNT(*) FROM reservations WHERE numero_chambre = ? AND date_debut < ? AND date_fin > ?");
    $verif->bind_param("iss", $numero_chambre, $date_fin, $date_debut);
    $verif->execute();
    $verif->bind_result($count);
    $verif->fetch();
    $verif->close();

    if ($count > 0) {
        $error = "❌ Cette chambre est déjà réservée pour cette période.";
    } else {
        $stmt = $conn->prepare("INSERT INTO reservations (utilisateur_id, numero_chambre, date_debut, date_fin, date_reservation) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $utilisateur_id, $numero_chambre, $date_debut, $date_fin, $date_reservation);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "❌ Erreur lors de la réservation : " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-reservation {
            max-width: 650px;
            margin: auto;
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="card-reservation">
    <h2 class="mb-4 text-center">🛏️ Confirmation de réservation - Chambre n°<?= htmlspecialchars($numero_chambre) ?></h2>
    <p class="text-center mb-4">
        📅 Du <strong><?= htmlspecialchars($date_debut) ?></strong> au <strong><?= htmlspecialchars($date_fin) ?></strong>
        (<?= $nb_nuits ?> nuit<?= $nb_nuits > 1 ? 's' : '' ?>)
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>

    <?php elseif ($success): ?>
        <div class="alert alert-success text-center">
            ✅ Réservation confirmée avec succès !
        </div>
        <div class="text-center">
            <a href="accueil.php" class="btn btn-primary mt-3">🏠 Retour à l’accueil</a>
        </div>

    <?php else: ?>
        <form id="reservationForm" method="POST" class="text-center">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                ✅ Confirmer
            </button>
            <a href="recherche_dispo.php" class="btn btn-secondary ms-2">❌ Annuler</a>
        </form>
    <?php endif; ?>
</div>

<!-- MODALE DE CONFIRMATION -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        🔒 Êtes-vous sûr de vouloir confirmer cette réservation ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Annuler</button>
        <button type="button" class="btn btn-success" onclick="document.getElementById('reservationForm').submit();">
            ✅ Valider
        </button>
      </div>
    </div>
  </div>
</div>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
