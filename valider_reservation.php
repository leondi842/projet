<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$utilisateur_id = $_SESSION['user_id'];
$type_utilisateur = $_SESSION['type_utilisateur']; // 'intervenant' ou 'professeur_invite'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_chambre = $_POST['numero_chambre'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // Calcul nombre de nuits
    $start = new DateTime($date_debut);
    $end = new DateTime($date_fin);
    $nights = $start->diff($end)->days;

    if ($nights <= 0) {
        die("Date de fin doit être après la date de début.");
    }

    // Tarif selon type utilisateur
    if ($type_utilisateur === 'intervenant') {
        $tarif_par_nuit = 7500;
    } else {
        $tarif_par_nuit = 0;
    }

    $montant = $nights * $tarif_par_nuit;

    // Connexion DB
    $conn = new mysqli("localhost", "root", "", "maison_des_hotes");
    if ($conn->connect_error) die("Erreur connexion : " . $conn->connect_error);

    $date_reservation = date('Y-m-d H:i:s');

    // Préparation requête insertion
    $sql = "INSERT INTO reservations (utilisateur_id, numero_chambre, date_debut, date_fin, date_reservation, montant) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) die("Erreur préparation requête : " . $conn->error);

    $stmt->bind_param("iisssi", $utilisateur_id, $numero_chambre, $date_debut, $date_fin, $date_reservation, $montant);

    if ($stmt->execute()) {
        echo "Réservation enregistrée avec succès ! Montant à payer : " . number_format($montant, 0, ',', ' ') . " FCFA.";
        // Ici tu peux rediriger ou afficher un lien vers la page mes_reservations.php
        echo "<br><a href='mes_reservations.php'>Voir mes réservations</a>";
    } else {
        echo "Erreur lors de la réservation : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: reservation.php");
}
