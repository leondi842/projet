<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de la période</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Choisissez la période de réservation</h2>
        <form method="GET" action="liste_chambres_disponibles.php" class="bg-white p-4 shadow rounded">
            <div class="mb-3">
                <label>Date de début</label>
                <input type="date" name="debut" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Date de fin</label>
                <input type="date" name="fin" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Voir les chambres disponibles</button>
        </form>
    </div>
</body>
</html>
