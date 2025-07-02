<?php
// Connexion
$host = "localhost";
$user = "root";
$password = "";
$dbname = "maison_des_hotes";
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Échec connexion : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    $moyen_paiement = $_POST["moyen_paiement"];

    $stmt = $conn->prepare("UPDATE reservations SET date_debut = ?, date_fin = ?, moyen_paiement = ? WHERE id = ?");
    if (!$stmt) {
        die("Erreur prepare : " . $conn->error);
    }

    $stmt->bind_param("sssi", $date_debut, $date_fin, $moyen_paiement, $id);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success text-center'>✅ Réservation mise à jour avec succès !</div>";
    } else {
        $message = "<div class='alert alert-danger text-center'>❌ Erreur lors de la mise à jour : " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- HTML Bootstrap -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include 'navbar.php'; ?>

<!-- ✅ FORMULAIRE -->
<div class="container mt-5">
    <?php if (!empty($message)) echo $message; ?>

    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Modifier une Réservation</h3>
        </div>
        <div class="card-body">
            <form action="modifier_reservation.php" method="POST" class="row g-3">

                <input type="hidden" name="id" value="1"> <!-- ID à modifier -->

                <div class="col-md-6">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="moyen_paiement" class="form-label">Moyen de reservation</label>
                    <select name="moyen_paiement" id="moyen_paiement" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="Orange Money">Orange Money</option>
                        <option value="Moov Money">Moov Money</option>
                        <option value="Coris">Coris</option>
                    </select>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success px-5">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>
