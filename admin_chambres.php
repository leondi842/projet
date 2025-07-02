<?php
// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "maison_des_hotes");

if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

// Récupération des chambres
$result = $mysqli->query("SELECT numero, description, statut FROM chambres");

if (!$result) {
    die("Erreur de requête : " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Admin - Liste des Chambres</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
</head>
<body>

<!-- ✅ Barre de navigation Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">🏠 Admin Maison des Hôtes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard_admin.php">🏠 Accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_chambres.php">🛏️ Chambres</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_reservations.php">📅 Réservations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">🚪 Déconnexion</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
    <h2>🛏️ Liste des Chambres</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Description</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= htmlspecialchars($row['numero']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['statut']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="consultation_admin.php" class="btn btn-secondary">⬅ Retour</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
