<?php
session_start();

// Si l'utilisateur a cliqué sur "oui" pour se déconnecter
if (isset($_GET['logout']) && $_GET['logout'] === 'yes') {
    // Détruit toutes les variables de session
    $_SESSION = [];

    // Supprime le cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Termine la session
    session_destroy();

    // Redirige vers la page d'accueil
    header("Location: index.php");
    exit();
} else {
    // Si l'utilisateur accède à ce fichier sans "logout=yes", redirection simple
    header("Location: dashboard.php");
    exit();
}
