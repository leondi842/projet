<?php
include(__DIR__ . "/config.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $type_utilisateur = "intervenant";
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $cnib = $_POST['cnib'];
    $annee_naissance = $_POST['annee_naissance'];
    $fonction = $_POST['fonction'];
    $etablissement = $_POST['etablissement'];
    $pays = $_POST['pays'];
    $photo = 'default.jpg';
    $role = 'user';

    $stmt = $conn->prepare("INSERT INTO utilisateurs 
        (nom, prenom, email, mot_de_passe, telephone, role, type_utilisateur, cnib, photo, annee_naissance, fonction, etablissement, pays) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe, $telephone, $role, $type_utilisateur, $cnib, $photo, $annee_naissance, $fonction, $etablissement, $pays])) {
        $message = "Intervenant ajouté avec succès !";
    } else {
        $message = "Erreur lors de l'ajout.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Visiteur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        .page-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-wrap {
            flex: 1;
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>
<div class="page-container">
    <?php include 'navbar1.php'; ?>

    <div class="container mt-5 content-wrap">
        <h2>Ajouter un Visiteur</h2>

        <?php if ($message): ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nom :</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Prénom :</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Téléphone :</label>
                <input type="text" name="telephone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>CNIB :</label>
                <input type="text" name="cnib" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Année de naissance :</label>
                <input type="number" name="annee_naissance" class="form-control">
            </div>
            <div class="form-group">
                <label>Fonction :</label>
                <input type="text" name="fonction" class="form-control">
            </div>
            <div class="form-group">
                <label>Établissement :</label>
                <input type="text" name="etablissement" class="form-control">
            </div>
            <div class="form-group">
                <label>Pays :</label>
                <input type="text" name="pays" class="form-control">
            </div>
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="mot_de_passe" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="admin_clients.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</div>
</body>
</html>
