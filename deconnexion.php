<?php
session_start();

// Traitement si l'utilisateur confirme la déconnexion
if (isset($_POST['confirm']) && $_POST['confirm'] === 'oui') {
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    // Redirection vers la page d'accueil
    header("Location: index.php");
    exit();
}

// Si "Non", redirige selon le rôle
if (isset($_POST['confirm']) && $_POST['confirm'] === 'non') {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: accueil.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8" />
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Confirmation déconnexion</title>
    <style>



        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('m7.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .confirm-box {
            background: #0cbc73;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 30px hsla(0, 91.30%, 49.80%, 0.30);
            text-align: center;
            width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .confirm-box h2 {
            margin-bottom: 25px;
            color: #333;
        }

        button {
            margin: 0 10px;
            padding: 12px 28px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button.yes {
            background-color:#db2525;
            color: white;
        }

        button.yes:hover {
            background-color:hsl(9, 94.80%, 22.50%);
        }

        button.no {
            background-color: #ccc;
            color: #333;
        }

        button.no:hover {
            background-color: #bbb;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="confirm-box">
    <h2>Voulez-vous vraiment vous déconnecter ?</h2>
    <form method="POST" action="">
        <button type="submit" name="confirm" value="oui" class="yes">Oui, me déconnecter</button>
        <button type="submit" name="confirm" value="non" class="no">Non, rester connecté</button>
    </form>
</div>

</body>
</html>
