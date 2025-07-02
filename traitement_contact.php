<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connexion à la BDD
    $conn = new mysqli("localhost", "root", "", "maison_des_hotes");
    if ($conn->connect_error) {
        die("Erreur de connexion à la BDD : " . $conn->connect_error);
    }

    // Protection contre injection
    $nom = $conn->real_escape_string(trim($_POST['nom']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    if (empty($nom) || empty($message)) {
        die("Le nom et le message sont obligatoires.");
    }

    // Insertion sécurisée via requête préparée
    $sql = "INSERT INTO messages_contact (nom, message, date_envoi) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nom, $message);

    if ($stmt->execute()) {
        // Redirection vers contact.php avec succès
        header("Location: contact.php?success=1");
        exit();
    } else {
        echo "Erreur lors de l'enregistrement : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Accès non autorisé.";
}
?>
