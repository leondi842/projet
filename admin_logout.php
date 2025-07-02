<?php
session_start();

// 🔧 Simule admin connecté pour les tests si session vide (à retirer en prod)
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'admin';
}

// 🔒 Vérifie si c’est bien un admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<h2 style='color:red; text-align:center;'>Accès refusé. Réservé à l'administrateur.</h2>";
    exit();
}

// ✅ Si l'admin confirme la déconnexion
if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
    header("Location: index.php");
    exit();
}

// ✅ Si l'admin décide de rester connecté
if (isset($_POST['action']) && $_POST['action'] === 'stay') {
    echo "<script>
        alert('Vous restez connecté 👍');
        window.location.href = 'admin_dashboard.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déconnexion - Admin</title>
    <style>
        body {
            background: linear-gradient(to right, #8EC5FC, #E0C3FC);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .logout-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 420px;
        }
        .logout-box h2 {
            color: #333;
            margin-bottom: 25px;
        }
        .logout-box form {
            margin-top: 20px;
        }
        button {
            padding: 12px 24px;
            font-size: 16px;
            margin: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .logout {
            background-color: #e63946;
            color: white;
        }
        .logout:hover {
            background-color: #c82333;
        }
        .stay {
            background-color: #4caf50;
            color: white;
        }
        .stay:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

<div class="logout-box">
    <h2>Voulez-vous vraiment vous déconnecter ?</h2>
    <form method="POST">
        <button type="submit" name="action" value="logout" class="logout">Oui, me déconnecter</button>
        <button type="submit" name="action" value="stay" class="stay">Non, retourner au tableau de bord</button>
    </form>
</div>

</body>
</html>
