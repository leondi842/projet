<?php
if (!isset($_GET['id_utilisateur'])) {
    echo "<div class='alert alert-danger text-center mt-5'>❌ ID utilisateur manquant dans l'URL.</div>";
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

$id_utilisateur = intval($_GET['id_utilisateur']);

$sql = "SELECT r.*, u.nom, u.email, c.numero 
        FROM reservations r 
        JOIN utilisateurs u ON r.utilisateur_id = u.id 
        JOIN chambres c ON r.numero_chambre = c.numero 
        WHERE r.utilisateur_id = $id_utilisateur
        ORDER BY r.date_reservation DESC";

$res = $mysqli->query($sql);

if (!$res || $res->num_rows == 0) {
    echo "<div class='container mt-5 alert alert-warning text-center'>🚫 Aucune facture trouvée pour cet utilisateur (ID = $id_utilisateur).</div>";
    echo "<div class='text-center'><a href='factures.php' class='btn btn-secondary mt-3'>⬅ Retour à toutes les factures</a></div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Factures utilisateur #<?= $id_utilisateur ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">🧾 Factures de l'utilisateur #<?= $id_utilisateur ?></h3>

    <?php while ($row = $res->fetch_assoc()) : ?>
        <div class="border p-4 mb-4 shadow-sm rounded">
            <p><strong>Client :</strong> <?= htmlspecialchars($row['nom']) ?> (<?= htmlspecialchars($row['email']) ?>)</p>
            <p><strong>Chambre :</strong> <?= htmlspecialchars($row['numero']) ?></p>
            <p><strong>Date de réservation :</strong> <?= htmlspecialchars($row['date_reservation']) ?></p>
            <p><strong>Période :</strong> du <?= htmlspecialchars($row['date_debut']) ?> au <?= htmlspecialchars($row['date_fin']) ?></p>
            <p><strong>Moyen de paiement :</strong> <?= htmlspecialchars($row['moyen_paiement']) ?></p>
            <p><strong>Montant :</strong> <span class="text-primary font-weight-bold"><?= number_format($row['montant'], 0, ',', ' ') ?> FCFA</span></p>
        </div>
    <?php endwhile; ?>

    <div class="text-center no-print">
        <button onclick="window.print()" class="btn btn-success">🖨️ Imprimer</button>
        <a href="factures.php" class="btn btn-secondary">⬅ Retour à toutes les factures</a>
    </div>
</div>
</body>
</html>
