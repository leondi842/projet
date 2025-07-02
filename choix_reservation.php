<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Choix de réservation - Maison des Hôtes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Choisissez votre chambre et les dates</h2>
        <form action="reservation.php" method="get" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label for="chambre" class="form-label">Numéro de chambre</label>
                <input type="number" class="form-control" id="chambre" name="chambre" min="1" max="11" required>
            </div>

            <div class="mb-3">
                <label for="debut" class="form-label">Date de début</label>
                <input type="date" class="form-control" id="debut" name="debut" required>
            </div>

            <div class="mb-3">
                <label for="fin" class="form-label">Date de fin</label>
                <input type="date" class="form-control" id="fin" name="fin" required>
            </div>

            <button type="submit" class="btn btn-primary">Réserver</button>
        </form>
    </div>
</body>
</html>
