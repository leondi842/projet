<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion BDD
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérification de session
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$utilisateur_id = $_SESSION['user_id'];

// Vérification des paramètres GET
if (!isset($_GET['chambre'], $_GET['debut'], $_GET['fin'])) {
    header("Location: recherche_dispo.php");
    exit();
}

$numero_chambre = $_GET['chambre'];
$date_debut = $_GET['debut'];
$date_fin = $_GET['fin'];

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_reservation = date('Y-m-d H:i:s');
    $moyen_paiement = NULL;
    $montant = 0;

    // Récupération email + nom
    $stmt = $conn->prepare("SELECT nom, email FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $utilisateur_id);
    $stmt->execute();
    $stmt->bind_result($nom_utilisateur, $email_utilisateur);
    $stmt->fetch();
    $stmt->close();

    // Insertion de la réservation
    $sql_insert = $conn->prepare("INSERT INTO reservations (utilisateur_id, numero_chambre, date_debut, date_fin, date_reservation, moyen_paiement, montant) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql_insert->bind_param("iissssi", $utilisateur_id, $numero_chambre, $date_debut, $date_fin, $date_reservation, $moyen_paiement, $montant);

    if ($sql_insert->execute()) {
        // Envoi de l’e-mail
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'leondima775@gmail.com'; // Ton adresse
            $mail->Password   = 'sqem iauo vxvm petq';    // Mot de passe d'application
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('leondima775@gmail.com', 'Maison des Hôtes');
            $mail->addAddress($email_utilisateur, $nom_utilisateur);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre réservation';
            $mail->Body    = "
                <h2>Bonjour $nom_utilisateur,</h2>
                <p>Votre réservation a bien été enregistrée :</p>
                <ul>
                    <li><strong>Chambre :</strong> n° $numero_chambre</li>
                    <li><strong>Du :</strong> $date_debut</li>
                    <li><strong>Au :</strong> $date_fin</li>
                </ul>
                <p>Merci d’avoir utilisé notre plateforme.<br><em>Université Norbert Zongo</em></p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi du mail : " . $mail->ErrorInfo);
        }

        // Redirection vers page de confirmation
        header("Location: confirmation_reservation.php?chambre=$numero_chambre&debut=$date_debut&fin=$date_fin");
        exit();
    } else {
        echo "Erreur lors de la réservation : " . $conn->error;
        exit();
    }
}
?>

<!-- Formulaire d’affichage -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation de Chambre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<?php include 'navbar.php'; ?>


<div class="container my-5">
    <h2 class="mb-4 text-center">Réserver la chambre n°<?= htmlspecialchars($numero_chambre) ?></h2>
    <form method="POST" class="bg-white p-4 shadow rounded mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label class="form-label">Date de début</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($date_debut) ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Date de fin</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($date_fin) ?>" disabled>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-primary" onclick="confirmerReservation()">Confirmer la réservation</button>
            <a href="recherche_dispo.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<footer class="bg-primary text-white text-center py-3 mt-auto">
    &copy; <?= date('Y') ?> Maison des Hôtes - Université Norbert Zongo
</footer>

<script>
function confirmerReservation() {
    Swal.fire({
        title: 'Confirmation',
        text: "Souhaitez-vous vraiment réserver cette chambre ?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, confirmer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelector('form').submit();
        }
    });
}
</script>

</body>
<?php include 'footer.php'; ?>
</html>
