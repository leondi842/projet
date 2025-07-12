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

// Pagination
$facturesParPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $facturesParPage;

// Construire la requête SQL avec filtres (sans LIMIT pour compter le total)
$sqlCount = "SELECT COUNT(*) as total
        FROM reservations r
        JOIN utilisateurs u ON r.utilisateur_id = u.id
        JOIN chambres c ON r.numero_chambre = c.numero
        WHERE 1";

if ($filtre_nom !== '') {
    $sqlCount .= " AND (u.nom LIKE '%$filtre_nom%' OR u.email LIKE '%$filtre_nom%')";
}
if ($filtre_date !== '') {
    $sqlCount .= " AND DATE(r.date_reservation) = '$filtre_date'";
}
if ($filtre_paiement !== '') {
    $sqlCount .= " AND r.moyen_paiement = '$filtre_paiement'";
}

// Exécuter la requête pour compter le total des factures filtrées
$resultCount = $mysqli->query($sqlCount);
$totalFactures = 0;
if ($resultCount) {
    $rowCount = $resultCount->fetch_assoc();
    $totalFactures = $rowCount['total'];
}

// Calcul du nombre total de pages
$totalPages = ceil($totalFactures / $facturesParPage);

// Construire la requête SQL avec filtres et pagination
$sql = "SELECT r.*, u.*, u.type_utilisateur, c.numero 
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

$sql .= " ORDER BY r.date_reservation DESC LIMIT $facturesParPage OFFSET $offset";

$res = $mysqli->query($sql);

// Fonction pour garder les filtres dans les liens pagination
function buildQueryString($overrides = []) {
    $params = $_GET;
    foreach ($overrides as $key => $value) {
        $params[$key] = $value;
    }
    return http_build_query($params);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
     <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Administration des Factures - Maison des Hôtes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('presi1.jpg'); /* ton image */
    background-size: cover;
    background-position: center;
    opacity: 0.1; /* ajustable pour la transparence */
    z-index: -1;
}


        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
        }
        body {
            background-color: #f8f9fa;
        }
        .header-logo {
            max-height: 80px;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .header h1 {
            margin-left: 15px;
            font-weight: bold;
            font-size: 1.8rem;
            color: #007bff;
        }
        .contact-info {
            font-size: 0.9rem;
            color: #555;
            margin-top: 0;
        }
        .facture-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 720px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.15);
            color: #333;
            page-break-inside: avoid;
        }
        .facture-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .facture-header h2 {
            color: #007bff;
            margin-bottom: 0;
        }
        .facture-header .contact-details p {
            margin: 0;
            font-size: 0.85rem;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #f2f9ff;
            color: #007bff;
        }
        .total {
            font-size: 1.3rem;
            font-weight: 700;
            color: #007bff;
            text-align: right;
            margin-bottom: 25px;
        }
        footer.facture-footer {
            border-top: 2px solid #007bff;
            padding-top: 15px;
            font-size: 0.9rem;
            color: #555;
            text-align: center;
        }
        footer.facture-footer p {
            margin: 4px 0;
        }
        .btn-print {
            margin-right: 10px;
        }
        .user-info p {
            margin: 0.2rem 0;
            font-size: 1rem;
        }
        .user-info strong {
            color: #007bff;
        }
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
   <?php include 'navbar1.php'; ?>
    <div class="container mt-5">

        <div class="header no-print">
            <img src="R.jpeg" alt="Logo Maison des Hôtes" class="header-logo">
            <div>
                <h1>Maison des Hôtes</h1>
                <p class="contact-info">Administration des Factures<br>admingmail.com</p>
            </div>
        </div>

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
    
        </form>

        <?php if (!$res || $res->num_rows == 0) : ?>
            <div class="alert alert-warning text-center" style="font-size: 1.2rem; padding: 30px;">
                🚫 Aucune facture trouvée.
            </div>
        <?php else : ?>
            <?php
            $counter = 1 + $offset;
            while ($row = $res->fetch_assoc()) :
                $factureId = "facture-" . $counter;
            ?>
                <div class="facture-container" id="<?= $factureId ?>">
                    <header class="facture-header">
                        <div>
                            <img src="R.jpeg" alt="Logo Maison des Hôtes" style="height: 80px;">
                        </div>
                        <div class="contact-details">
                            <h2>Maison des Hôtes</h2>
                            <p>adminunzgmail.com</p>
                            <p>+226 25 00 00 00</p>
                            <p>Koudougou, Burkina Faso</p>
                        </div>
                    </header>

                    <hr style="border: 1px solid #007bff;">

                    <section class="mb-3">
                        <h4>Facture n° <span style="color: #007bff;"><?= htmlspecialchars($row['id']) ?></span></h4>
                        <p>Date d’émission : <?= date('d/m/Y', strtotime($row['date_reservation'])) ?></p>
                    </section>

                    <section class="mb-3 user-info">
                        <h5>Client</h5>
                        <p><strong>Nom :</strong> <?= htmlspecialchars($row['nom']) ?></p>
                        <p><strong>Type d'utilisateur :</strong> <?= htmlspecialchars($row['type_utilisateur']) ?></p>
                        <p><strong>Prénom :</strong> <?= htmlspecialchars($row['prenom'] ?? '') ?></p>
                        <p><strong>Email :</strong> <?= htmlspecialchars($row['email']) ?></p>
                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($row['telephone'] ?? '') ?></p>
                        <p><strong>Adresse :</strong> <?= htmlspecialchars($row['adresse'] ?? '') ?></p>
                        <p><strong>Ville :</strong> <?= htmlspecialchars($row['ville'] ?? '') ?></p>
                        <p><strong>Pays :</strong> <?= htmlspecialchars($row['pays'] ?? '') ?></p>
                        <p><strong>Date de naissance :</strong> <?= !empty($row['date_naissance']) ? date('d/m/Y', strtotime($row['date_naissance'])) : '' ?></p>
                    </section>

                    <section class="mb-3">
                        <h5>Détails de la réservation</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Chambre</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Prix unitaire (FCFA)</th>
                                    <th>Quantité (nuits)</th>
                            
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dateDebut = new DateTime($row['date_debut'] ?? $row['date_reservation']);
                                $dateFin = new DateTime($row['date_fin'] ?? $row['date_reservation']);
                                $interval = $dateDebut->diff($dateFin);
                                $nuits = max($interval->days, 1);
                                $prixUnitaire = $row['prix'] ?? 7500;
                                $totalLigne = $prixUnitaire * $nuits;
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['numero_chambre']) ?></td>
                                    <td><?= $dateDebut->format('d/m/Y') ?></td>
                                    <td><?= $dateFin->format('d/m/Y') ?></td>
                                    <td><?= number_format($prixUnitaire, 0, ',', ' ') ?></td>
                                    <td><?= $nuits ?></td>
                            
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    <div class="total">
                        Montant total : <strong>................................. FCFA</strong>
                    </div>

                    <footer class="facture-footer">
                        <p>Merci pour votre confiance et votre réservation à la Maison des Hôtes.</p>
                        <p>Pour toute question, contactez-nous au +226 25 00 00 00 ou adminunzgmail.com</p>
                    </footer>

                    <button onclick="window.print()" class="btn btn-info no-print mb-4">🖨️ Imprimer cette facture</button>
                </div>
            <?php $counter++; endwhile; ?>

            <nav aria-label="Pagination" class="no-print">
                <ul class="pagination">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?= buildQueryString(['page' => $page - 1]) ?>" tabindex="-1">← Précédent</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= buildQueryString(['page' => $i]) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?= buildQueryString(['page' => $page + 1]) ?>">Suivant →</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
