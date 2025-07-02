<?php
session_start();
require_once 'connexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['annee_naissance'])) {
    $annee = intval($_POST['annee_naissance']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE utilisateurs SET annee_naissance = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $annee, $user_id);
        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "Année de naissance mise à jour avec succès 🎉";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Erreur lors de la mise à jour.";
            $_SESSION['flash_type'] = "danger";
        }
        $stmt->close();
    } else {
        $_SESSION['flash_message'] = "Erreur SQL : " . $conn->error;
        $_SESSION['flash_type'] = "danger";
    }
}

header("Location: profil.php");
exit();
