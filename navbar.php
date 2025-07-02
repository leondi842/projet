<?php
// Assure-toi que session_start() est appelé avant d'inclure ce fichier
$nom_utilisateur = $_SESSION['nom_utilisateur'] ?? 'Invité';
?>

<!-- Google Fonts & Material Icons -->
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    header {
        font-family: 'Roboto', sans-serif;
        background-color: #03dac6; /* Vert turquoise */
        padding: 10px 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .logo {
        font-size: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo img {
        height: 32px;
    }

    nav {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    nav a {
        color: white;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 4px;
        transition: background-color 0.3s;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    nav a:hover {
        background-color: #009e8c; /* plus foncé pour hover */
    }

    .material-icons {
        font-size: 18px;
    }

    .burger {
        display: none;
        flex-direction: column;
        cursor: pointer;
    }

    .burger div {
        width: 25px;
        height: 3px;
        background-color: white;
        margin: 4px;
        border-radius: 2px;
    }

    .welcome-msg {
        margin-left: 20px;
        font-weight: 500;
        font-size: 14px;
        opacity: 0.9;
    }

    @media screen and (max-width: 768px) {
        nav {
            display: none;
            flex-direction: column;
            background-color: #02c4b3; /* version foncée pour mobile */
            position: absolute;
            top: 60px;
            right: 20px;
            width: 220px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            padding: 10px;
            z-index: 100;
        }

        nav.active {
            display: flex;
        }

        .burger {
            display: flex;
        }
    }
</style>

<header>
    <div class="logo">
        <img src="R.jpeg" alt="Logo UNZ" />
        Maison des Hôtes
    </div>

    <div class="burger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <nav id="navbar-links">
        <a href="accueil.php"><span class="material-icons">dashboard</span> Accueil</a>
        <a href="reservation.php"><span class="material-icons">event_available</span> Réserver</a>
        <a href="mes_reservations.php"><span class="material-icons">list_alt</span> Mes réservations</a>
        <a href="profil.php"><span class="material-icons">person</span> Profil</a>
        <a href="deconnexion.php"><span class="material-icons">logout</span> Déconnexion</a>
    </nav>
</header>

<script>
    function toggleMenu() {
        document.getElementById('navbar-links').classList.toggle('active');
    }
</script>
