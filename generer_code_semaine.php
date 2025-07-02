<?php
$code = 'SEMAINE' . date('Y') . '-' . date('W'); // ex: SEMAINE2025-25

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO codes_semaine (code) VALUES (?)");
$stmt->bind_param("s", $code);

if ($stmt->execute()) {
    echo "✅ Code généré avec succès : <strong>$code</strong>";
} else {
    echo "❌ Erreur : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
