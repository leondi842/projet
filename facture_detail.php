<?php
// Connexion à la base
$mysqli = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de facture invalide.");
}

$id = (int)$_GET['id'];

// Récupérer les données de la facture
$sql = "SELECT r.*, u.nom, u.email, u.telephone, c.numero, c.description 
        FROM reservations r
        JOIN utilisateurs u ON r.utilisateur_id = u.id
        JOIN chambres c ON r.numero_chambre = c.numero
        WHERE r.id = $id";

$res = $mysqli->query($sql);

if (!$res || $res->num_rows == 0) {
    die("Facture introuvable.");
}

$facture = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #<?= $facture['id'] ?> - Maison des Hôtes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            background: #f9f9f9;
        }
        .facture-container {
            background: #fff;
            padding: 30px 40px;
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .logo {
            max-height: 80px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        h2 {
            margin-bottom: 0;
        }
        .info-client, .info-facture {
            margin-bottom: 20px;
        }
        .info-client p, .info-facture p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            border: 1px solid #aaa;
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
        }
        .total {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 40px;
        }
        .footer {
            font-size: 0.9rem;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            text-align: center;
        }
        @media print {
            body {
                margin: 0;
                background: #fff;
            }
            .no-print {
                display: none;
            }
            .facture-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
<div class="facture-container">
    <div class="header">
        <img src="R.jpeg" alt="Logo Maison des Hôtes" class="logo">
        <div>
            <h2>Maison des Hôtes</h2>
            <p>Contact: kere@gmail.com</p>
        </div>
    </div>

    <h4 class="text-center mb-4">Facture N° <?= $facture['id'] ?></h4>

    <div class="info-client">
        <strong>Client :</strong>
        <p><?= htmlspecialchars($facture['nom']) ?> (<?= htmlspecialchars($facture['email']) ?>)</p>
        <?php if (!empty($facture['telephone'])) : ?>
            <p>Téléphone : <?= htmlspecialchars($facture['telephone']) ?></p>
        <?php endif; ?>
    </div>

    <div class="info-facture">
        <p><strong>Date de réservation :</strong> <?= htmlspecialchars($facture['date_reservation']) ?></p>
        <p><strong>Période :</strong> du <?= htmlspecialchars($facture['date_debut']) ?> au <?= htmlspecialchars($facture['date_fin']) ?></p>
        <p><strong>Chambre :</strong> <?= htmlspecialchars($facture['numero']) ?> - <?= htmlspecialchars($facture['description']) ?></p>
        <p><strong>Moyen de paiement :</strong> <?= htmlspecialchars($facture['moyen_paiement']) ?></p>
    </div>

    <table>
        <thead>
        <tr>
            <th>Description</th>
            <th>Quantité</th>
            <th>Prix unitaire (FCFA)</th>
            <th>Total (FCFA)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Calculer nombre de nuits
        $date_debut = new DateTime($facture['date_debut']);
        $date_fin = new DateTime($facture['date_fin']);
        $diff = $date_fin->diff($date_debut);
        $nb_nuits = $diff->days;

        // Si 0 nuit (même jour), on met 1
        if ($nb_nuits == 0) $nb_nuits = 1;

        $prix_unitaire = $facture['montant'] / $nb_nuits;
        $total = $facture['montant'];
        ?>

        <tr>
            <td>Location chambre <?= htmlspecialchars($facture['numero']) ?></td>
            <td><?= $nb_nuits ?></td>
            <td><?= number_format($prix_unitaire, 0, ',', ' ') ?></td>
            <td><?= number_format($total, 0, ',', ' ') ?></td>
        </tr>
        </tbody>
    </table>

    <div class="total">
        Montant total à payer : <?= number_format($total, 0, ',', ' ') ?> FCFA
    </div>

    <div class="footer">
        Merci pour votre confiance.<br>
        Maison des Hôtes &copy; <?= date('Y') ?>
    </div>

    <div class="text-center no-print">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimer la facture</button>
    </div>
</div>
</body>
</html>
