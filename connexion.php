<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
