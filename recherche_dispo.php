<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$debut = $_POST['debut'] ?? '';
$fin = $_POST['fin'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Recherche de disponibilité</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap + icônes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Flatpickr (datepicker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.css">

    <style>

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('presi2.jpg'); /* ton image */
    background-size: cover;
    background-position: center;
    opacity: 0.1; /* ajustable pour la transparence */
    z-index: -1;
}


        body {
            background-image: url('ima.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-bottom: 100px;
        }

        .form-section {
            max-width: 800px;
            margin: auto;
            margin-top: 40px;
            padding: 0 20px;
        }

        .form-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-primary {
            font-weight: bold;
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        footer.footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #212529;
            color: white;
            padding: 15px 0;
            text-align: center;
            z-index: 100;
        }

        @media screen and (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .btn-primary {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container form-section">
    <div class="form-container">
        <h2 class="mb-4 text-center"><i class="bi bi-search"></i> Rechercher une chambre</h2>

        <form method="post" action="afficher_chambres.php">
            <div class="mb-3">
                <label for="debut" class="form-label">Date de début</label>
                <input type="text" id="debut" name="debut" class="form-control" required>
                <small id="debutJour" class="text-muted"></small>
            </div>
            <div class="mb-3">
                <label for="fin" class="form-label">Date de fin</label>
                <input type="text" id="fin" name="fin" class="form-control" required>
                <small id="finJour" class="text-muted"></small>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-calendar-check"></i> Vérifier la disponibilité
                </button>
            </div>
        </form>

        <div class="text-center mt-3">
            <i class="bi bi-shield-lock text-success"></i> Vos données sont protégées
        </div>
    </div>
</div>

<!-- JS Bootstrap + Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const options = {
            dateFormat: "Y-m-d",
            locale: "fr",
            minDate: "today"
        };

        flatpickr("#debut", {
            ...options,
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    const date = selectedDates[0];
                    const optionsFr = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    document.getElementById("debutJour").textContent = "→ " + date.toLocaleDateString('fr-FR', optionsFr);
                }
            }
        });

        flatpickr("#fin", {
            ...options,
            onChange: function(selectedDates) {
                const debutVal = document.getElementById("debut").value;
                if (selectedDates.length > 0) {
                    const date = selectedDates[0];
                    const finVal = date.toISOString().split('T')[0];

                    if (finVal < debutVal) {
                        alert("La date de fin ne peut pas être avant la date de début !");
                        document.getElementById("fin").value = "";
                        document.getElementById("finJour").textContent = "";
                    } else {
                        const optionsFr = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        document.getElementById("finJour").textContent = "→ " + date.toLocaleDateString('fr-FR', optionsFr);
                    }
                }
            }
        });
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>
