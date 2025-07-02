<?php
// --- Récupération des données pour les graphiques ---
$conn = new mysqli("localhost", "root", "", "maison_des_hotes");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Données des réservations mensuelles
$mois = ["Jan", "Fév", "Mars", "Avr", "Mai", "Juin"];
$donneesReservations = [];
foreach ($mois as $i => $m) {
    $monthNumber = $i + 1;
    $sql = "SELECT COUNT(*) as total FROM reservations WHERE MONTH(date_reservation) = $monthNumber";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $donneesReservations[] = $row['total'];
}

// Chambres disponibles vs occupées
$sqlDispo = "SELECT COUNT(*) as dispo FROM chambres WHERE statut = 'disponible'";
$sqlOccupe = "SELECT COUNT(*) as occupe FROM chambres WHERE statut = 'occupee'";
$resDispo = $conn->query($sqlDispo)->fetch_assoc();
$resOccupe = $conn->query($sqlOccupe)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Dashboard Administrateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            margin: 0;
            background-color: #717e8a;
            color: hsl(210, 95.3%, 50.4%);
            transition: background-color 0.5s ease, color 0.5s ease;
            font-family: 'Segoe UI', sans-serif;
        }

        .dark-mode {
            background-color:rgb(52, 53, 54) !important;
            color:rgb(230, 223, 223) !important;
        }

        .dark-mode .card {
            background-color:hsl(227, 94.40%, 51.40%);
            color: #fff;
        }

        .container {
            flex: 1;
            max-width: 900px;
            margin-top: 3rem;
            margin-bottom: 3rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        #profilePic {
            width: 45px;
            height: 45px;
            background: #c2c3d4;
            border-radius: 50%;
            cursor: pointer;
        }

        #dropdownMenu {
            display: none;
            position: absolute;
            right: 20px;
            top: 60px;
            min-width: 160px;
            z-index: 1000;
        }

        #dropdownMenu.show {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            border-radius: 15px;
        }

        .btn {
            border-radius: 50px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            width: 100%;
            margin-top: auto;
            font-size: 0.9rem;
            color: #999;
        }

        @media (max-width: 768px) {
            .header h4 {
                margin-bottom: 10px;
            }

            .card .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
<?php include 'navbar1.php'; ?>

<div class="container">
    <div class="header">
        <div class="d-flex align-items-center position-relative">
            <button id="toggleDarkMode" class="btn btn-sm btn-outline-secondary mr-3">🌙 Mode Sombre</button>
            <div class="dropdown">
                <div id="profilePic" title="Profil"></div>
                <div id="dropdownMenu" class="bg-white shadow rounded">
                    <!-- Menu dropdown -->
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-center mb-4">Tableau de bord administrateur</h2>

    <div class="row text-center">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title">📅 Réservations</h4>
                    <p>Confirmez, annulez et supprimez les réservations.</p>
                    <a href="admin_reservations.php" class="btn btn-primary">Accéder</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title">👥 Utilisateurs</h4>
                    <p>Voir la liste des clients.</p>
                    <a href="admin_clients.php" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION STATISTIQUES -->
    <h3 class="text-center mt-5 mb-4">📊 Statistiques</h3>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">📈 Réservations par Mois</h5>
                    <canvas id="chartReservations"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">🏨 Chambres (Disponibles vs Occupées)</h5>
                    <canvas id="chartChambres"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const profilePic = document.getElementById("profilePic");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const toggleDarkBtn = document.getElementById("toggleDarkMode");

    profilePic.addEventListener("click", () => {
        dropdownMenu.classList.toggle("show");
    });

    document.addEventListener("click", event => {
        if (!profilePic.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove("show");
        }
    });

    function toggleDarkMode() {
        document.body.classList.toggle("dark-mode");
        const isDark = document.body.classList.contains("dark-mode");
        localStorage.setItem("dark-mode", isDark ? "on" : "off");
        toggleDarkBtn.textContent = isDark ? "☀️ Mode Clair" : "🌙 Mode Sombre";
    }

    toggleDarkBtn.addEventListener("click", toggleDarkMode);

    const heure = new Date().getHours();
    const darkPref = localStorage.getItem("dark-mode");
    if ((heure >= 18 || heure < 6) && darkPref !== "off") {
        document.body.classList.add("dark-mode");
        toggleDarkBtn.textContent = "☀️ Mode Clair";
    }
    if (darkPref === "on") {
        document.body.classList.add("dark-mode");
        toggleDarkBtn.textContent = "☀️ Mode Clair";
    }

    // --- Graphiques Chart.js ---
    const chart1 = new Chart(document.getElementById('chartReservations').getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($mois); ?>,
            datasets: [{
                label: 'Nombre de Réservations',
                data: <?php echo json_encode($donneesReservations); ?>,
                backgroundColor: 'rgba(0, 123, 255, 0.7)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    const chart2 = new Chart(document.getElementById('chartChambres').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Disponibles', 'Occupées'],
            datasets: [{
                data: [<?php echo $resDispo['dispo']; ?>, <?php echo $resOccupe['occupe']; ?>],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
</body>
</html>
