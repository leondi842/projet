<?php
session_start();
include(__DIR__ . "/config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: accueil.php");
    exit();
}

$clientsParPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $clientsParPage;

// Total des utilisateurs
$totalStmt = $conn->prepare("SELECT COUNT(*) FROM utilisateurs");
$totalStmt->execute();
$totalClients = $totalStmt->fetchColumn();
$totalPages = ceil($totalClients / $clientsParPage);

// Récupération des utilisateurs
$sql = "SELECT id, nom, prenom, email, telephone, cnib, matricule FROM utilisateurs ORDER BY id ASC LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $clientsParPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>


body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('n.png'); /* ton image */
    background-size: cover;
    background-position: center;
    opacity: 0.1; /* ajustable pour la transparence */
    z-index: -1;
}


        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        th { background-color: rgb(47, 0, 255); color: white; }
        .pagination a {
            color: rgb(47, 0, 255);
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: rgb(47, 0, 255);
            color: white;
            border: 1px solid rgb(47, 0, 255);
        }
        .pagination a.disabled {
            color: #aaa;
            pointer-events: none;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<?php include 'navbar1.php'; ?>

<div class="mb-4">
    <a href="ajouter_intervenant.php" class="btn btn-primary">+ Créer un INvité</a>
</div>

<?php if (count($clients) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>CNIB</th>
            <th>Matricule</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['id']) ?></td>
                <td><?= htmlspecialchars($client['nom']) ?></td>
                <td><?= htmlspecialchars($client['prenom']) ?></td>
                <td><?= htmlspecialchars($client['email']) ?></td>
                <td><?= htmlspecialchars($client['telephone']) ?></td>
                <td><?= htmlspecialchars($client['cnib']) ?></td>
                <td><?= htmlspecialchars($client['matricule']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination mt-4">
        <a href="?page=<?= max(1, $page - 1) ?>" class="<?= ($page <= 1) ? 'disabled' : '' ?>">Précédent</a>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <a href="?page=<?= min($totalPages, $page + 1) ?>" class="<?= ($page >= $totalPages) ? 'disabled' : '' ?>">Suivant</a>
    </div>

<?php else: ?>
    <p>Aucun utilisateur trouvé.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
</body>
</html>
