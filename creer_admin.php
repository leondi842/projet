<?php
// Connexion à la base
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

// Infos de l'admin
$nom = "Admin";
$prenom = "UNZ";
$email = "admin@gmail.com";
$telephone = "00000000";
$cnib = "ADMIN-CNIB-0001";
$mdp = password_hash("dima", PASSWORD_DEFAULT); // mot de passe : dima
$role = "admin";
$type_utilisateur = "professeur"; // ou intervenant

// Vérifie si l'admin existe déjà
$stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "❗L'administrateur existe déjà.";
} else {
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, role, type_utilisateur, cnib) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nom, $prenom, $email, $mdp, $telephone, $role, $type_utilisateur, $cnib);

    if ($stmt->execute()) {
        echo "✅ Compte admin créé avec succès !";
    } else {
        echo "❌ Erreur : " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
