<?php
include(__DIR__ . "/config.php");

// Récupérer tous les utilisateurs
$sql = "SELECT id, nom, prenom, email FROM utilisateurs ORDER BY nom, prenom";
$stmt = $conn->prepare($sql);
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Liste des Utilisateurs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 40px;
            color: #222;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        table {
            max-width: 800px;
            margin: auto;
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f0f8ff;
        }
        a.btn-view {
            padding: 7px 15px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s;
        }
        a.btn-view:hover {
            background: #1e7e34;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Liste des Utilisateurs</h1>

<?php if (!$utilisateurs): ?>
    <p style="text-align:center;">Aucun utilisateur trouvé.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th class="center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $user): ?>
                <tr>
                    <td><?= htmlspecialchars(strtoupper($user['nom'])) ?></td>
                    <td><?= htmlspecialchars(ucwords($user['prenom'])) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td class="center">
                        <a class="btn-view" href="facture.php?id=<?= (int)$user['id'] ?>" target="_blank">Voir Facture</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
