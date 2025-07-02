<?php
session_start();

// Vérifie que l'utilisateur est admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: accueil.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Requête pour récupérer les visiteurs (intervenants)
$visiteurs = $conn->query("SELECT id, nom, prenom, email FROM utilisateurs WHERE type_utilisateur = 'intervenant'");
if (!$visiteurs) {
    die("Erreur SQL visiteurs : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Nouvelle réservation - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

  <h2 class="mb-4">Ajouter une réservation pour un visiteur</h2>

  <form method="POST" action="traitement_reservation_admin.php" class="card p-4 shadow-sm">

    <div class="mb-3">
      <label class="form-label">Visiteur</label>
      <select name="utilisateur_id" class="form-select" required>
        <option value="">-- Sélectionne un visiteur --</option>
        <?php while ($v = $visiteurs->fetch_assoc()): ?>
          <option value="<?= htmlspecialchars($v['id']) ?>">
            <?= htmlspecialchars($v['nom'] . ' ' . $v['prenom']) ?> (<?= htmlspecialchars($v['email']) ?>)
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label" for="numero_chambre">Numéro de chambre</label>
      <input
        type="text"
        name="numero_chambre"
        id="numero_chambre"
        class="form-control"
        placeholder="Entrez le numéro de la chambre"
        required
      >
    </div>

    <div class="mb-3">
      <label class="form-label" for="date_debut">Date début</label>
      <input type="date" name="date_debut" id="date_debut" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label" for="date_fin">Date fin</label>
      <input type="date" name="date_fin" id="date_fin" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer la réservation</button>
  </form>

</body>
</html>

<?php
$conn->close();
?>
