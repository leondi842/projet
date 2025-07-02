<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $description = trim($_POST['description'] ?? '');
    $statut = $_POST['statut'] ?? '';

    if (!$id || empty($description) || empty($statut)) {
        echo "Tous les champs sont requis.";
        exit();
    }

    // Préparation de la requête
    $stmt = $conn->prepare("UPDATE chambres SET description = ?, statut = ? WHERE id = ?");
    if (!$stmt) {
        echo "Erreur lors de la préparation : " . $conn->error;
        exit();
    }

    $stmt->bind_param("ssi", $description, $statut, $id);

    if ($stmt->execute()) {
        // Succès, redirection ou message
        header("Location: liste_chambres.php?msg=modification_success");
        exit();
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Méthode non autorisée.";
}
