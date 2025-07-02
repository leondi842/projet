<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Accueil - Maison des Hôtes</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
   
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #333;

            background-image: url('ima.png'); /* Image d’arrière-plan */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            background-color: rgba(0, 0, 0, 0.3); /* filtre sombre (optionnel) */
            background-blend-mode: overlay;
        }

        nav {
            background-color:#0dda85;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px hsla(145, 95.70%, 45.70%, 0.87);
        }

        nav .logo {
            font-size: 1.7rem;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #bbdefb;
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 2.8rem;
            color: #1976d2;
            margin-bottom: 0.5rem;
        }

        p {
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 2rem;
        }

        .btn {
            background-color: #1976d2;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            margin: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px #05f70d;
        }

        .btn:hover {
            background-color: #1565c0;
        }

        @media (max-width: 600px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }
            nav ul {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
                margin-top: 1rem;
            }
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main>
    <h1><span class="material-icons" style="font-size: 2.5rem; vertical-align: middle;">home</span> Bienvenue à la Maison des Hôtes</h1>
    <p>Gérez vos réservations facilement et en toute sécurité</p>

    <a href="reservation.php" class="btn"><span class="material-icons" style="vertical-align: middle;">calendar_month</span> Réserver une chambre</a>
    <a href="mes_reservations.php" class="btn"><span class="material-icons" style="vertical-align: middle;">assignment</span> Mes réservations</a>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
