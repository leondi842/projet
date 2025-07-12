<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: accueil.php');
    exit();
}

require_once 'config.php';
$message = "";
$ajout_succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom']);
    $prenom  = trim($_POST['prenom']);
    $email   = trim($_POST['email']);
    $mdp     = trim($_POST['mot_de_passe']);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($mdp)) {
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, 'professeur_invite')");
            $stmt->execute([$nom, $prenom, $email, $mdp_hash]);
            $ajout_succes = true;
        } catch (PDOException $e) {
            $message = "❌ Erreur lors de l'ajout.";
        }
    } else {
        $message = "⚠️ Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Ajout Professeur</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <?php if ($ajout_succes): ?>
                <div class="alert alert-success text-center" role="alert">
                    ✅ Professeur invité ajouté avec succès !
                </div>
                <div class="d-flex justify-content-center">
                    <a href="admin_dashboard.php" class="btn btn-primary">
                        ⬅ Retour au tableau de bord
                    </a>
                </div>
            <?php else: ?>

                <

            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper (optionnel si tu veux les composants bootstrap interactifs) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
