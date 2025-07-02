<?php
session_start();
require_once 'connexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT nom, email, telephone, photo, role, annee_naissance FROM utilisateurs WHERE id = ?");
if (!$stmt) {
    die("Erreur préparation requête : " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: deconnexion.php");
    exit();
}

$user_name = $user['nom'] ?? 'Utilisateur';
$user_email = $user['email'] ?? 'Email non défini';
$user_phone = $user['telephone'] ?? 'Non renseigné';
$user_photo = $user['photo'] ?? null;
$user_birth_year = $user['annee_naissance'] ?? 'Non renseignée';

$stmt->close();

$photo_path = 'uploads/default_avatar.png';
if ($user_photo && file_exists("uploads/" . $user_photo)) {
    $photo_path = "uploads/" . $user_photo;
}

$flash_message = $_SESSION['flash_message'] ?? null;
$flash_type = $_SESSION['flash_type'] ?? 'info';
unset($_SESSION['flash_message'], $_SESSION['flash_type']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Profil Utilisateur - Maison des Hôtes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #e3f2fd;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-section {
            background-image: url('m5.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
            background-color: hsl(154, 80.70%, 44.70%);
        }

        .btn-group > * {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <?php if ($flash_message): ?>
        <div class="alert alert-<?= htmlspecialchars($flash_type) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flash_message) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="text-center bg-white p-4 profile-section text-white">
        <img src="<?= htmlspecialchars($photo_path) ?>" alt="Photo de profil" class="profile-photo mb-3" />
        <h2><?= htmlspecialchars($user_name) ?></h2>
        <p><strong>Email :</strong> <?= htmlspecialchars($user_email) ?></p>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($user_phone) ?></p>

        <?php if ($user_birth_year && $user_birth_year != 'Non renseignée'): ?>
            <p><strong>Année de naissance :</strong> <?= htmlspecialchars($user_birth_year) ?></p>
        <?php else: ?>
            <form method="POST" action="ajouter_naissance.php" class="form-inline justify-content-center mt-3">
                <label for="annee_naissance" class="mr-2">Année de naissance :</label>
                <input type="number" class="form-control mr-2" name="annee_naissance" id="annee_naissance" required min="1900" max="2100" />
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        <?php endif; ?>

        <div class="btn-group justify-content-center mt-4" role="group" aria-label="Actions utilisateur">
            <a href="modifier_compte.php" class="btn btn-warning">Modifier compte</a>

            <form action="upload_photo.php" method="POST" enctype="multipart/form-data" class="d-inline-block mb-0">
                <input type="file" name="photo" id="photo" accept="image/*" required style="display:none;" onchange="this.form.submit()" />
                <label for="photo" class="btn btn-success mb-0" style="cursor:pointer;">Changer photo</label>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
<?php include 'footer.php'; ?>
</html>
