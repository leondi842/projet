<?php
// Connexion à la base
$mysqli = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

// Récupérer les filtres (optionnels)
$filtre_nom = isset($_GET['filtre_nom']) ? $mysqli->real_escape_string($_GET['filtre_nom']) : '';
$filtre_date = isset($_GET['filtre_date']) ? $_GET['filtre_date'] : '';
$filtre_paiement = isset($_GET['filtre_paiement']) ? $mysqli->real_escape_string($_GET['filtre_paiement']) : '';

// Construire la requête SQL avec filtres
$sql = "SELECT r.*, u.nom, u.email, c.numero 
        FROM reservations r
        JOIN utilisateurs u ON r.utilisateur_id = u.id
        JOIN chambres c ON r.numero_chambre = c.numero
        WHERE 1";

if ($filtre_nom !== '') {
    $sql .= " AND (u.nom LIKE '%$filtre_nom%' OR u.email LIKE '%$filtre_nom%')";
}
if ($filtre_date !== '') {
    $sql .= " AND DATE(r.date_reservation) = '$filtre_date'";
}
if ($filtre_paiement !== '') {
    $sql .= " AND r.moyen_paiement = '$filtre_paiement'";
}

$sql .= " ORDER BY r.date_reservation DESC";

$res = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Factures - Administration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">🧾 Toutes les factures enregistrées</h3>

    <!-- Formulaire de filtre -->
    <form method="GET" class="form-inline justify-content-center mb-4 no-print">
        <input type="text" name="filtre_nom" class="form-control mr-2 mb-2" placeholder="Nom ou Email" value="<?= htmlspecialchars($filtre_nom) ?>">
        <input type="date" name="filtre_date" class="form-control mr-2 mb-2" value="<?= htmlspecialchars($filtre_date) ?>">
        <select name="filtre_paiement" class="form-control mr-2 mb-2">
            <option value="">-- Moyen de paiement --</option>
            <option value="Orange Money" <?= $filtre_paiement == 'Orange Money' ? 'selected' : '' ?>>Orange Money</option>
            <option value="Moov Money" <?= $filtre_paiement == 'Moov Money' ? 'selected' : '' ?>>Moov Money</option>
            <option value="Coris" <?= $filtre_paiement == 'Coris' ? 'selected' : '' ?>>Coris</option>
        </select>
        <button type="submit" class="btn btn-primary mb-2">🔍 Filtrer</button>
        <a href="factures_admin.php" class="btn btn-secondary ml-2 mb-2">♻ Réinitialiser</a>
    </form>

    <?php if (!$res || $res->num_rows == 0) : ?>
        <div class="alert alert-warning text-center">🚫 Aucune facture trouvée.</div>
    <?php else : ?>
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
            <button onclick="window.print()" class="btn btn-success">🖨️ Imprimer toutes les factures</button>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
