<?php
session_start();

// Vérification que l'admin est connecté
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Erreur BDD : " . $conn->connect_error);
}

$sql = "SELECT id, nom, message, date_envoi FROM messages_contact ORDER BY date_envoi DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages reçus - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .bi-envelope {
            font-size: 1.5rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>
<?php include 'navbar1.php'; ?>
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top">
            <h3 class="mb-0"><i class="bi bi-envelope"></i> Messages des utilisateurs</h3>
        </div>
        <div class="card-body">

            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="bi bi-person-circle"></i> Nom</th>
                                <th><i class="bi bi-chat-left-text"></i> Message</th>
                                <th><i class="bi bi-clock"></i> Date d'envoi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nom']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($row['date_envoi'])) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle-fill"></i> Aucun message reçu pour le moment.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>

<?php $conn->close(); ?>
