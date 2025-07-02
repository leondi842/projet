<?php
// Connexion base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier paramètres
if (!isset($_GET['debut']) || !isset($_GET['fin'])) {
    die("Paramètres de période manquants.");
}

$date_debut = $_GET['debut'];
$date_fin = $_GET['fin'];

// Requête pour trouver les chambres indisponibles
$sql_indispo = "SELECT DISTINCT numero_chambre FROM reservations 
                WHERE (
                    (? BETWEEN date_debut AND date_fin) OR 
                    (? BETWEEN date_debut AND date_fin) OR
                    (date_debut BETWEEN ? AND ?) OR
                    (date_fin BETWEEN ? AND ?)
                )";

$stmt_indispo = $conn->prepare($sql_indispo);
$stmt_indispo->bind_param("ssssss", $date_debut, $date_fin, $date_debut, $date_fin, $date_debut, $date_fin);
$stmt_indispo->execute();
$result_indispo = $stmt_indispo->get_result();

$chambres_indispo = [];
while ($row = $result_indispo->fetch_assoc()) {
    $chambres_indispo[] = $row['numero_chambre'];
}

// Requête pour récupérer toutes les chambres
$sql_all = "SELECT numero, description FROM chambres";
$result_all = $conn->query($sql_all);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chambres disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Chambres disponibles du <?= htmlspecialchars($date_debut) ?> au <?= htmlspecialchars($date_fin) ?></h2>
    <?php if ($result_all->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($chambre = $result_all->fetch_assoc()): ?>
                <?php if (!in_array($chambre['numero'], $chambres_indispo)): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Chambre n°<?= htmlspecialchars($chambre['numero']) ?> - <?= htmlspecialchars($chambre['description']) ?>
                        <a href="reservation.php?chambre=<?= urlencode($chambre['numero']) ?>&debut=<?= urlencode($date_debut) ?>&fin=<?= urlencode($date_fin) ?>" class="btn btn-success btn-sm">Réserver</a>
                    </li>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Aucune chambre trouvée.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
