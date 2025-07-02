<?php
// export_reservations_csv.php

// Connexion à la BDD
$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Préparation de la requête
$sql = "SELECT r.id, u.nom, u.prenom, u.email, r.numero_chambre, r.date_reservation, r.statut
        FROM reservations r
        JOIN utilisateurs u ON r.utilisateur_id = u.id
        ORDER BY r.date_reservation DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Erreur lors de la récupération des données.");
}

// En-têtes HTTP pour forcer le téléchargement du fichier CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=export_reservations.csv');
header('Pragma: no-cache');
header('Expires: 0');

// Ouverture du flux de sortie
$output = fopen('php://output', 'w');

// Écriture de la ligne d'en-tête
fputcsv($output, ['ID', 'Nom', 'Prénom', 'Email', 'Numéro de chambre', 'Date réservation', 'Statut']);

// Écriture des données ligne par ligne
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['nom'],
        $row['prenom'],
        $row['email'],
        $row['numero_chambre'],
        $row['date_reservation'],
        $row['statut']
    ]);
}

// Fermeture de la connexion et du flux
fclose($output);
$conn->close();
exit;
