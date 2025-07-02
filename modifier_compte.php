<?php
session_start();
require_once 'connexion.php';

// CSRF Token generation and validation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération utilisateur
$stmt = $conn->prepare("SELECT nom, prenom, email, mot_de_passe, telephone, fonction, etablissement, pays FROM utilisateurs WHERE id = ?");
if (!$stmt) {
    die("Erreur dans la requête SQL : " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: deconnexion.php");
    exit();
}

$user_nom = $user['nom'] ?? '';
$user_prenom = $user['prenom'] ?? '';
$user_email = $user['email'] ?? '';
$user_telephone = $user['telephone'] ?? '';
$user_mot_de_passe = $user['mot_de_passe'] ?? '';
$user_fonction = $user['fonction'] ?? '';
$user_etablissement = $user['etablissement'] ?? '';
$user_pays = $user['pays'] ?? '';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité. Veuillez réessayer.");
    }

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $fonction = trim($_POST['fonction']);
    $etablissement = trim($_POST['etablissement']);
    $pays = trim($_POST['pays']);

    // Validation serveur
    if (empty($nom)) {
        $errors['nom'] = "Le nom est obligatoire.";
    }
    if (empty($prenom)) {
        $errors['prenom'] = "Le prénom est obligatoire.";
    }
    if (empty($email)) {
        $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }
    if (!empty($mot_de_passe) && strlen($mot_de_passe) < 6) {
        $errors['mot_de_passe'] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    // Si tout est ok, update la BDD
    if (empty($errors)) {
        if (!empty($mot_de_passe)) {
            $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        } else {
            $mot_de_passe_hash = $user_mot_de_passe;
        }

        $update_stmt = $conn->prepare("UPDATE utilisateurs 
            SET nom = ?, prenom = ?, email = ?, telephone = ?, mot_de_passe = ?, fonction = ?, etablissement = ?, pays = ? 
            WHERE id = ?");
        if (!$update_stmt) {
            die("Erreur préparation mise à jour : " . $conn->error);
        }
        $update_stmt->bind_param("ssssssssi", $nom, $prenom, $email, $telephone, $mot_de_passe_hash, $fonction, $etablissement, $pays, $user_id);

        if ($update_stmt->execute()) {
            $success = "Profil mis à jour avec succès.";
            $user_nom = $nom;
            $user_prenom = $prenom;
            $user_email = $email;
            $user_telephone = $telephone;
            $user_mot_de_passe = $mot_de_passe_hash;
            $user_fonction = $fonction;
            $user_etablissement = $etablissement;
            $user_pays = $pays;
        } else {
            $errors['global'] = "Erreur lors de la mise à jour : " . $update_stmt->error;
        }
        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Modifier compte - Maison des Hôtes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.15);
            transition: box-shadow 0.3s ease-in-out;
        }
        .form-container:hover {
            box-shadow: 0 6px 20px rgb(0 0 0 / 0.2);
        }
        .error-text {
            color: #dc3545;
            font-size: 0.9em;
        }
        .btn-primary {
            background-color: #0069d9;
            border-color: #0062cc;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #004085;
            border-color: #003768;
        }
        .navbar {
            background-color: #007bff !important;
        }
        .navbar .navbar-brand,
        .navbar .nav-link {
            color: white !important;
        }
        .navbar .nav-link.active {
            font-weight: 600;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>


<div class="container form-container">
    <h2 class="mb-4 text-primary font-weight-bold">Modifier votre compte</h2>

    <?php if (!empty($errors['global'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errors['global']) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="" novalidate onsubmit="return confirmUpdate();" id="profileForm">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" />

        <div class="form-group">
            <label for="nom">Nom <span class="text-danger">*</span></label>
            <input type="text" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>" id="nom" name="nom" 
                   value="<?= htmlspecialchars($user_nom) ?>" required autofocus placeholder="Votre nom">
            <?php if (isset($errors['nom'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['nom']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom <span class="text-danger">*</span></label>
            <input type="text" class="form-control <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>" id="prenom" name="prenom" 
                   value="<?= htmlspecialchars($user_prenom) ?>" required placeholder="Votre prénom">
            <?php if (isset($errors['prenom'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['prenom']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" 
                   value="<?= htmlspecialchars($user_email) ?>" required placeholder="exemple@domaine.com">
            <?php if (isset($errors['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" pattern="[0-9+]{6,15}" class="form-control" id="telephone" name="telephone" 
                   value="<?= htmlspecialchars($user_telephone) ?>" placeholder="+226 70 00 00 00">
            <small class="form-text text-muted">Format international recommandé</small>
        </div>

        <div class="form-group">
            <label for="fonction">Fonction</label>
            <input type="text" class="form-control" id="fonction" name="fonction" 
                   value="<?= htmlspecialchars($user_fonction) ?>" placeholder="Votre fonction">
        </div>

        <div class="form-group">
            <label for="etablissement">Établissement</label>
            <input type="text" class="form-control" id="etablissement" name="etablissement" 
                   value="<?= htmlspecialchars($user_etablissement) ?>" placeholder="Votre établissement">
        </div>

        <div class="form-group">
            <label for="pays">Pays</label>
            <input type="text" class="form-control" id="pays" name="pays" 
                   value="<?= htmlspecialchars($user_pays) ?>" placeholder="Votre pays">
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" class="form-control <?= isset($errors['mot_de_passe']) ? 'is-invalid' : '' ?>" id="mot_de_passe" name="mot_de_passe" placeholder="Nouveau mot de passe">
            <?php if (isset($errors['mot_de_passe'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['mot_de_passe']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Modifier</button>
    </form>
</div>

<script>
    // Confirmation avant soumission
    function confirmUpdate() {
        // Basic JS validation example (optional)
        const nom = document.getElementById('nom').value.trim();
        const prenom = document.getElementById('prenom').value.trim();
        const email = document.getElementById('email').value.trim();
        const mot_de_passe = document.getElementById('mot_de_passe').value;

        if (!nom || !prenom || !email) {
            alert('Merci de remplir les champs obligatoires : Nom, Prénom, Email.');
            return false;
        }
        if (mot_de_passe && mot_de_passe.length < 6) {
            alert('Le mot de passe doit contenir au moins 6 caractères.');
            return false;
        }
        return confirm('Confirmez-vous la modification de votre profil ?');
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>
