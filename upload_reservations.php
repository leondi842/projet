<?php
session_start();

// 1. Vérifie que c’est un admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: accueil.php");
    exit();
}

// 2. Connexion BDD
$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Erreur connexion : " . $conn->connect_error);
}

// 3. Récupère les réservations des visiteurs (type_utilisateur = 'visiteur')
$sql = "SELECT u.nom, u.prenom, u.email, r.numero_chambre, r.date_debut, r.date_fin, r.statut 
        FROM reservations r 
        JOIN utilisateurs u ON r.utilisateur_id = u.id
        WHERE u.type_utilisateur = 'visiteur'";

$result = $conn->query($sql);
if (!$result) {
    die("Erreur requête : " . $conn->error);
}

// 4. Prépare le nom du fichier
$filename = "reservations_visiteurs_" . date('Ymd') . ".csv";

// 5. En-têtes HTTP pour forcer le téléchargement CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// 6. Ouvre la sortie PHP comme un flux fichier
$output = fopen('php://output', 'w');

// 7. Écrit la première ligne (en-têtes)
fputcsv($output, ['Nom', 'Prénom', 'Email', 'Numéro Chambre', 'Date Début', 'Date Fin', 'Statut']);

// 8. Écrit les données ligne par ligne
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['nom'], 
        $row['prenom'], 
        $row['email'], 
        $row['numero_chambre'], 
        $row['date_debut'], 
        $row['date_fin'], 
        $row['statut']
    ]);
}

// 9. Ferme le flux
fclose($output);
exit();
