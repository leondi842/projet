<?php
session_start();
require_once 'connexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $user_id = $_SESSION['user_id'];
    $photo = $_FILES['photo'];

    // Extensions autorisées
    $extensions_valides = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    // Infos sur le fichier
    $file_info = pathinfo($photo['name']);
    $extension = strtolower($file_info['extension']);

    if (!in_array($extension, $extensions_valides)) {
        $_SESSION['flash_message'] = "Format non autorisé. Utilisez jpg, jpeg, png, gif ou webp.";
        $_SESSION['flash_type'] = "danger";
        header("Location: profil.php");
        exit();
    }

    // Nom unique pour éviter conflits
    $nom_fichier = uniqid('profile_', true) . '.' . $extension;
    $chemin_upload = 'uploads/' . $nom_fichier;

    // Déplacer fichier uploadé
    if (move_uploaded_file($photo['tmp_name'], $chemin_upload)) {
        // Supprimer ancienne photo si ce n'est pas le défaut
        $stmt = $conn->prepare("SELECT photo FROM utilisateurs WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $ancienne_photo = $user['photo'] ?? null;
        $stmt->close();

        if ($ancienne_photo && $ancienne_photo !== 'default_avatar.png' && file_exists('uploads/' . $ancienne_photo)) {
            unlink('uploads/' . $ancienne_photo);
        }

        // Mettre à jour en base
        $stmt = $conn->prepare("UPDATE utilisateurs SET photo = ? WHERE id = ?");
        $stmt->bind_param("si", $nom_fichier, $user_id);
        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "Photo de profil mise à jour avec succès !";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Erreur lors de la mise à jour en base.";
            $_SESSION['flash_type'] = "danger";
        }
        $stmt->close();
    } else {
        $_SESSION['flash_message'] = "Erreur lors de l'upload du fichier.";
        $_SESSION['flash_type'] = "danger";
    }
} else {
    $_SESSION['flash_message'] = "Aucun fichier sélectionné ou erreur d’upload.";
    $_SESSION['flash_type'] = "danger";
}

header("Location: profil.php");
exit();
