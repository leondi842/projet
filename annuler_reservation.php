<?php
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // ou ta page de connexion utilisateur
    exit();
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier que l'id est passé en GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Vérifier que cette réservation appartient bien à l'utilisateur connecté
    $stmt = $conn->prepare("SELECT id FROM reservations WHERE id = ? AND utilisateur_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // L'utilisateur peut annuler sa réservation
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: mes_reservations.php?msg=reservation_annulee");
            exit();
        } else {
            echo "Erreur lors de la suppression de la réservation.";
        }
        $stmt->close();
    } else {
        echo "Cette réservation ne vous appartient pas ou n'existe pas.";
    }
} else {
    echo "ID de réservation invalide.";
}

$conn->close();
?>
