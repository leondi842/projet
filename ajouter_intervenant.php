<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: accueil.php');
    exit();
}

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include(__DIR__ . "/config.php");

// Générer un token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier le token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Erreur : token CSRF invalide.";
    } else {
        $nom = filter_var($_POST['nom'] ?? '', FILTER_SANITIZE_STRING);
        $prenom = filter_var($_POST['prenom'] ?? '', FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $telephone = filter_var($_POST['telephone'] ?? '', FILTER_SANITIZE_STRING);
        $type_utilisateur = 'intervenant';
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $cnib = filter_var($_POST['cnib'] ?? '', FILTER_SANITIZE_STRING);
        $annee_naissance = filter_var($_POST['annee_naissance'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $fonction = filter_var($_POST['fonction'] ?? '', FILTER_SANITIZE_STRING);
        $etablissement = filter_var($_POST['etablissement'] ?? '', FILTER_SANITIZE_STRING);
        $pays = filter_var($_POST['pays'] ?? '', FILTER_SANITIZE_STRING);
        $photo = 'default.jpg';
        $role = 'enseignant_invite';

        // Validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Erreur : adresse email invalide.";
        } elseif (!preg_match('/^\+?\d{10,15}$/', $telephone)) {
            $message = "Erreur : numéro de téléphone invalide.";
        } elseif (strlen($mot_de_passe) < 8) {
            $message = "Erreur : le mot de passe doit contenir au moins 8 caractères.";
        } elseif ($annee_naissance && ($annee_naissance < 1900 || $annee_naissance > 2025)) {
            $message = "Erreur : année de naissance invalide (1900-2025).";
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO utilisateurs 
                    (nom, prenom, email, mot_de_passe, telephone, role, type_utilisateur, cnib, photo, annee_naissance, fonction, etablissement, pays) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe_hache, $telephone, $role, $type_utilisateur, $cnib, $photo, $annee_naissance, $fonction, $etablissement, $pays])) {
                    // Envoi de l'email avec PHPMailer
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'leondima775@gmail.com';
                    $mail->Password = 'sqem iauo vxvm petq'; // Remplace par un mot de passe d'application valide
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('leondima775@gmail.com', 'Maison des Hôtes');
                    $mail->addAddress($email);
                    $mail->Subject = 'Vos identifiants pour la Maison des Hôtes';
                    $mail->Body = "Bonjour $prenom $nom,\n\nVotre compte de professeur invité a été créé avec succès. Voici vos identifiants pour vous connecter à la plateforme de la Maison des Hôtes :\n\nEmail : $email\nMot de passe : $mot_de_passe\n\nConnectez-vous ici : http://localhost/maison_des_hotes/inscription_connexion.php\n\nCordialement,\nMaison des Hôtes - Université Norbert Zongo";
                    $mail->AltBody = "Bonjour $prenom $nom,\n\nVotre compte de professeur invité a été créé avec succès. Voici vos identifiants :\n\nEmail : $email\nMot de passe : $mot_de_passe\n\nConnectez-vous ici : http://localhost/maison_des_hotes/inscription_connexion.php\n\nCordialement,\nMaison des Hôtes - Université Norbert Zongo";

                    $mail->send();
                    $message = "Professeur invité ajouté avec succès et email envoyé !";
                } else {
                    $message = "Erreur lors de l'ajout.";
                }
            } catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
            } catch (Exception $e) {
                $message = "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/R.jpeg" type="image/png" />
    <title>Ajouter un Professeur Invité</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #bbdefb, #90caf9);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #333;
            position: relative;
            overflow-x: hidden;

            
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('m2.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.08;
            z-index: -1;
            animation: subtlePulse 10s ease-in-out infinite;
        }
        @keyframes subtlePulse {
            0%, 100% { opacity: 0.08; }
            50% { opacity: 0.12; }
        }
        .container {
            max-width: 750px;
            margin: 3rem auto;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .container.visible {
            opacity: 1;
            transform: translateY(0);
        }
        h2 {
            font-size: 2.6rem;
            color: #003399;
            text-align: center;
            font-weight: 700;
            margin-bottom: 2.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
            transition: all 0.3s ease;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #2E8B57;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }
        .form-control {
            padding-left: 40px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background: #f8f9fa;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        .form-control:focus {
            border-color: #2E8B57;
            box-shadow: 0 0 8px rgba(46, 139, 87, 0.4);
            background: #fff;
        }
        .btn-success {
            background: linear-gradient(90deg, #2E8B57, #1a7c34);
            border: none;
            border-radius: 30px;
            padding: 0.9rem 2.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }
        .btn-success:hover {
            background: linear-gradient(90deg, #1a7c34, #2E8B57);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(46, 139, 87, 0.4);
        }
        .btn-secondary {
            background: linear-gradient(90deg, #003399, #0d47a1);
            border: none;
            border-radius: 30px;
            padding: 0.9rem 2.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(90deg, #0d47a1, #003399);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 51, 153, 0.4);
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 2rem;
            padding: 1.2rem;
            font-size: 1rem;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media (max-width: 768px) {
            .container {
                margin: 1.5rem;
                padding: 2rem;
            }
            h2 {
                font-size: 2rem;
            }
            .form-control {
                font-size: 0.95rem;
                padding-left: 35px;
            }
            .form-group i {
                left: 12px;
                font-size: 1rem;
            }
            .btn-success, .btn-secondary {
                padding: 0.8rem 2rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar1.php'; ?>

    <div class="container my-5 visible" role="main" aria-label="Ajouter un professeur invité">
        <h2><i class="fas fa-user-plus mr-2"></i> Ajouter un Professeur Invité</h2>
        <?php if ($message): ?>
            <div class="alert alert-<?= strpos($message, 'Erreur') === false ? 'success' : 'danger' ?>" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="add_professeur_invite.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <div class="form-group">
                <label for="nom">Nom</label>
                <i class="fas fa-user"></i>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom" required aria-label="Nom du professeur invité">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <i class="fas fa-user"></i>
                <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Entrez le prénom" required aria-label="Prénom du professeur invité">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l’email" required aria-label="Adresse email">
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <i class="fas fa-phone"></i>
                <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Entrez le numéro de téléphone" required aria-label="Numéro de téléphone">
            </div>
            <div class="form-group">
                <label for="cnib">CNIB</label>
                <i class="fas fa-id-card"></i>
                <input type="text" name="cnib" id="cnib" class="form-control" placeholder="Entrez le numéro CNIB" required aria-label="Numéro CNIB">
            </div>
            <div class="form-group">
                <label for="annee_naissance">Année de naissance</label>
                <i class="fas fa-calendar-alt"></i>
                <input type="number" name="annee_naissance" id="annee_naissance" class="form-control" placeholder="Entrez l’année de naissance" min="1900" max="2025" aria-label="Année de naissance">
            </div>
            <div class="form-group">
                <label for="fonction">Fonction</label>
                <i class="fas fa-briefcase"></i>
                <input type="text" name="fonction" id="fonction" class="form-control" placeholder="Entrez la fonction" aria-label="Fonction du professeur invité">
            </div>
            <div class="form-group">
                <label for="etablissement">Établissement</label>
                <i class="fas fa-university"></i>
                <input type="text" name="etablissement" id="etablissement" class="form-control" placeholder="Entrez l’établissement" aria-label="Établissement">
            </div>
            <div class="form-group">
                <label for="pays">Pays</label>
                <i class="fas fa-globe"></i>
                <input type="text" name="pays" id="pays" class="form-control" placeholder="Entrez le pays" aria-label="Pays">
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <i class="fas fa-lock"></i>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" placeholder="Entrez le mot de passe" required aria-label="Mot de passe">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-2"></i> Enregistrer</button>
                <a href="admin_clients.php" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i> Retour</a>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            document.querySelector('.container').classList.add('visible');
        });
    </script>
</body>
</html>