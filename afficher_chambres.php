<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Récupérer le type d'utilisateur
$sql_user = $conn->prepare("SELECT type_utilisateur FROM utilisateurs WHERE id = ?");
$sql_user->bind_param("i", $user_id);
$sql_user->execute();
$result_user = $sql_user->get_result();
$user = $result_user->fetch_assoc();
$type_utilisateur = $user['type_utilisateur']; // intervenant ou prof_invite

// Récupérer et valider les dates
$debut = $_POST['debut'] ?? null;
$fin = $_POST['fin'] ?? null;

function valide_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

if (!$debut || !$fin || !valide_date($debut) || !valide_date($fin) || $debut > $fin) {
    die("Dates invalides ou mal saisies. Merci de recommencer.");
}

// Récupérer toutes les chambres
$sql_chambres = "SELECT * FROM chambres";
$result_chambres = $conn->query($sql_chambres);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Disponibilité des Chambres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Chambres disponibles du <span class="text-primary"><?= htmlspecialchars($debut) ?></span> au <span class="text-primary"><?= htmlspecialchars($fin) ?></span></h2>

    <table class="table table-bordered bg-white shadow rounded">
        <thead class="table-primary">
            <tr>
                <th>Numéro</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while($chambre = $result_chambres->fetch_assoc()): 
            $numero = $chambre['numero'];

            // Vérifier si cette chambre est déjà réservée pendant la période
            $stmt_res = $conn->prepare("SELECT * FROM reservations 
                WHERE numero_chambre = ? AND date_debut < ? AND date_fin > ?");
            $stmt_res->bind_param("sss", $numero, $fin, $debut);
            $stmt_res->execute();
            $res = $stmt_res->get_result();

            $disponible = $res->num_rows === 0;
            ?>
            <tr class="<?= $disponible ? 'table-success' : 'table-danger' ?>">
                <td><?= "MH-" . htmlspecialchars($numero) ?></td> <!-- Ici le format MH-0 -->
                <td><?= htmlspecialchars($chambre['description']) ?></td>
                <td>
                    <span class="badge <?= $disponible ? 'bg-success' : 'bg-danger' ?>">
                        <?= $disponible ? 'Disponible' : 'Indisponible' ?>
                    </span>
                </td>
                <td>
                    <?php if ($disponible): ?>
                        <?php if ($type_utilisateur === 'intervenant'): ?>
                            <a href="paiement.php?chambre=<?= urlencode($numero) ?>&debut=<?= urlencode($debut) ?>&fin=<?= urlencode($fin) ?>" class="btn btn-warning btn-sm">
                                Réserver & Payer
                            </a>
                        <?php else: ?>
                            <a href="reservation.php?chambre=<?= urlencode($numero) ?>&debut=<?= urlencode($debut) ?>&fin=<?= urlencode($fin) ?>" class="btn btn-success btn-sm">
                                Réserver Gratuitement
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-white">Réservation impossible</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Légende -->
    <div class="mt-4">
        <h5>Légende :</h5>
        <p>
            <span class="badge bg-success">Disponible</span> : Chambre libre pour les dates choisies<br>
            <span class="badge bg-danger">Indisponible</span> : Chambre déjà réservée sur cette période
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>

<?php $conn->close(); ?>
