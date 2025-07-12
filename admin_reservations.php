<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: accueil.php');
    exit();
}

// Connexion BDD
$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Pagination
$limite = 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'],1) : 1;
$debut = ($page - 1) * $limite;

// Récupération des filtres (sécurisés)
$searchNom = isset($_GET['search_nom']) ? $conn->real_escape_string(trim($_GET['search_nom'])) : '';
$searchChambre = isset($_GET['search_chambre']) ? $conn->real_escape_string(trim($_GET['search_chambre'])) : '';
$searchDate = isset($_GET['search_date']) ? $conn->real_escape_string(trim($_GET['search_date'])) : '';

// Construction de la clause WHERE
$whereClauses = [];

if ($searchNom !== '') {
    $whereClauses[] = "(u.nom LIKE '%$searchNom%' OR u.prenom LIKE '%$searchNom%')";
}
if ($searchChambre !== '') {
    $whereClauses[] = "r.numero_chambre LIKE '%$searchChambre%'";
}
if ($searchDate !== '') {
    $whereClauses[] = "r.date_reservation LIKE '$searchDate%'";
}

$whereSQL = '';
if (count($whereClauses) > 0) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Total de lignes filtré
$totalReq = $conn->query("SELECT COUNT(*) AS total FROM reservations r JOIN utilisateurs u ON r.utilisateur_id = u.id $whereSQL");
$total = $totalReq->fetch_assoc()['total'];
$pagesTotales = ceil($total / $limite);

// Requête filtrée et paginée, ajout de u.type_utilisateur
$sql = "SELECT r.id, u.nom, u.prenom, u.email, r.numero_chambre, r.date_reservation, r.statut, u.type_utilisateur
        FROM reservations r
        JOIN utilisateurs u ON r.utilisateur_id = u.id
        $whereSQL
        ORDER BY r.date_reservation DESC
        LIMIT $debut, $limite";

$result = $conn->query($sql);

// Traitement des actions POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];
    $id = (int)$_POST['id'];

    if ($action === 'confirmer') {
        $conn->query("UPDATE reservations SET statut='confirmée' WHERE id=$id");
    } elseif ($action === 'rejeter') {
        $conn->query("UPDATE reservations SET statut='rejetée' WHERE id=$id");
    } elseif ($action === 'supprimer') {
        $conn->query("DELETE FROM reservations WHERE id=$id");
    }

    $params = $_GET;
    header("Location: admin_reservations.php?" . http_build_query($params));
    exit();
}

// Génération CSV (optionnel)
$etatData = [];
$reqEtat = $conn->query("SELECT statut, COUNT(*) as total FROM reservations GROUP BY statut");
while ($row = $reqEtat->fetch_assoc()) {
    $etatData[] = [$row['statut'], $row['total']];
}

$csvFile = fopen("etat_reservations.csv", "w");
fputcsv($csvFile, ['statut', 'total']);
foreach ($etatData as $ligne) {
    fputcsv($csvFile, $ligne);
}
fclose($csvFile);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Réservations Admin</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('logo.jpg');
    background-size: cover;
    background-position: center;
    opacity: 0.1;
    z-index: -1;
}
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f4f4f4;
    padding: 20px;
}
h1 {
    color: #2c3e50;
}
a.btn-new-reservation {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 20px;
    background: #2980b9;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    transition: background 0.3s;
}
a.btn-new-reservation:hover {
    background: #21618c;
}
form#searchForm {
    margin-bottom: 20px;
    background: #fff;
    padding: 15px;
    box-shadow: 0 0 8px #ccc;
    border-radius: 8px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
form#searchForm input[type="text"],
form#searchForm input[type="date"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    flex: 1 1 200px;
}
form#searchForm button {
    background: #3498db;
    color: white;
    border: none;
    padding: 9px 15px;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s;
}
form#searchForm button:hover {
    background: #2980b9;
}
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 0 10px #ccc;
    margin-bottom: 20px;
}
th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}
th {
    background: #3498db;
    color: white;
}
tr:nth-child(even) {
    background: #eef7fb;
}
.btn {
    padding: 5px 10px;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}
.btn-suppr {
    background: #e67e22;
}
.btn-confirm {
    background: #2ecc71;
}
.btn-danger {
    background: #c0392b;
}
.pagination {
    text-align: center;
    margin-top: 15px;
}
.pagination a {
    padding: 8px 12px;
    margin: 2px;
    border: 1px solid #ccc;
    background: white;
    text-decoration: none;
    color: #3498db;
}
.pagination a.active {
    font-weight: bold;
    background: #3498db;
    color: white;
}
.diagramme {
    text-align: center;
    margin-top: 30px;
}
    </style>
</head>
<body>
<?php include 'navbar1.php'; ?>

<h1>Liste des Réservations</h1>

<a href="export_reservations.php" class="btn btn-new-reservation">+ Télécharger Excel des Réservations</a>

<form id="searchForm" method="get" action="admin_reservations.php">
    <input type="text" name="search_nom" placeholder="Nom ou prénom" value="<?= htmlspecialchars($searchNom) ?>">
    <input type="text" name="search_chambre" placeholder="Numéro de chambre" value="<?= htmlspecialchars($searchChambre) ?>">
    <input type="date" name="search_date" value="<?= htmlspecialchars($searchDate) ?>">
    <button type="submit">Rechercher</button>
    <button type="button" onclick="window.location='admin_reservations.php';">Réinitialiser</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom complet</th>
            <th>Email</th>
            <th>Chambre</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Professeur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nom'] . ' ' . $row['prenom']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['numero_chambre']) ?></td>
                <td><?= htmlspecialchars($row['date_reservation']) ?></td>
                <td><?= htmlspecialchars($row['statut']) ?></td>
                <td><?= ($row['type_utilisateur'] === 'professeur invité') ? '1' : '0' ?></td>
                <td>
                    <form method="post" style="display:inline">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="action" value="confirmer">
                        <button class="btn btn-confirm" type="submit">Confirmer</button>
                    </form>
                    <form method="post" style="display:inline" onsubmit="return confirm('Rejeter cette réservation ?')">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="action" value="rejeter">
                        <button class="btn btn-suppr" type="submit">Rejeter</button>
                    </form>
                    <form method="post" style="display:inline" onsubmit="return confirm('Supprimer définitivement ?')">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="action" value="supprimer">
                        <button class="btn btn-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="8">Aucune réservation trouvée.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php
    $params = $_GET;
    for ($i = 1; $i <= $pagesTotales; $i++):
        $params['page'] = $i;
        $url = 'admin_reservations.php?' . http_build_query($params);
    ?>
        <a href="<?= $url ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

<div class="diagramme">
    <h2>État des Réservations</h2>
    <canvas id="etatReservationsChart" width="500" height="400"></canvas>
</div>

<script>
    const etatLabels = <?= json_encode(array_column($etatData, 0)) ?>;
    const etatCounts = <?= json_encode(array_column($etatData, 1)) ?>;

    const ctx = document.getElementById('etatReservationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: etatLabels,
            datasets: [{
                label: 'Nombre de réservations',
                data: etatCounts,
                backgroundColor: [
                    '#3498db',
                    '#2ecc71',
                    '#e67e22',
                    '#f1c40f',
                    '#9b59b6',
                    '#c0392b'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: false }
            }
        }
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
