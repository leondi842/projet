<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Connexion base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupération et validation des données
if (!isset($_POST['chambre'], $_POST['debut'], $_POST['fin'])) {
    die("Veuillez remplir tous les champs.");
}

$numero_chambre = $conn->real_escape_string(trim($_POST['chambre']));
$date_debut = $_POST['debut'];
$date_fin = $_POST['fin'];

// Vérifier que date_fin est après date_debut
if ($date_fin < $date_debut) {
    die("La date de fin doit être postérieure à la date de début.");
}

// Vérifier disponibilité
$sql_check = "SELECT * FROM reservations 
              WHERE numero_chambre = '$numero_chambre' 
              AND (
                ('$date_debut' BETWEEN date_debut AND date_fin) 
                OR ('$date_fin' BETWEEN date_debut AND date_fin)
                OR (date_debut BETWEEN '$date_debut' AND '$date_fin')
                OR (date_fin BETWEEN '$date_debut' AND '$date_fin')
              )";

$result = $conn->query($sql_check);

if ($result === false) {
    die("Erreur SQL : " . $conn->error);
}

if ($result->num_rows > 0) {
    die("Désolé, la chambre $numero_chambre n'est pas disponible entre $date_debut et $date_fin.");
}

// Si dispo, redirige vers la page réservation avec paramètres GET
header("Location: reservation.php?chambre=$numero_chambre&debut=$date_debut&fin=$date_fin");
exit();
?>
