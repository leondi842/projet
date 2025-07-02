<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=maison_des_hotes', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification du token dans l'URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Rechercher le token valide
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ? AND expiry > NOW()');
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // Mise à jour du mot de passe
                $stmt = $pdo->prepare('UPDATE utilisateurs SET mot_de_passe = ? WHERE email = ?');
                $stmt->execute([$password, $reset['email']]);

                // Suppression du token
                $stmt = $pdo->prepare('DELETE FROM password_resets WHERE token = ?');
                $stmt->execute([$token]);

                $message = "Mot de passe réinitialisé avec succès ✅<br><a href='index.php'>Se connecter</a>";
                $success = true;
            } else {
                $message = "Le mot de passe ne peut pas être vide.";
                $success = false;
            }
        }
    } else {
        $message = "❌ Lien invalide ou expiré.";
        $success = false;
    }
} else {
    $message = "❌ Token manquant dans l'URL.";
    $success = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-center mb-4">🔐 Réinitialiser le mot de passe</h3>

    <?php if (!empty($message)): ?>
        <div class="alert <?= isset($success) && $success ? 'alert-success' : 'alert-danger' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <?php if (isset($reset) && $reset && empty($success)): ?>
        <form method="POST">
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" class="form-control" name="password" required minlength="6">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Réinitialiser</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
