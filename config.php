<?php
// config.php

$host = 'localhost';
$db   = 'maison_des_hotes'; // Mets ici le nom de ta base de données
$user = 'root';
$pass = ''; // Si tu n’as pas mis de mot de passe MySQL dans XAMPP

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
