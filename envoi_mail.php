<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assurez-vous que PHPMailer est installé via Composer

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Méthode non autorisée");
}

if (!empty($_POST['website'])) {
    die("Spam détecté !");
}

$name    = htmlspecialchars(trim($_POST['name'] ?? ''));
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

if (!$name || !$email || !$subject || !$message) {
    die("Tous les champs sont obligatoires.");
}

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'leondima775@gmail.com';         // Ton email Gmail
    $mail->Password   = 'sqem iauo vxvm petq';           // Mot de passe d'application
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('leondima775@gmail.com', 'Maison des Hôtes');
    $mail->addAddress($email, $name); // Vers l’utilisateur

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = "
        <h3>Bonjour $name,</h3>
        <p>$message</p>
        <p>Merci pour votre confiance.</p>
    ";

    $mail->send();

    echo "
    <!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <title>Confirmation</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='bg-light d-flex justify-content-center align-items-center vh-100'>
        <div class='card shadow p-4' style='width: 100%; max-width: 500px;'>
            <div class='alert alert-success text-center' role='alert'>
                ✅ <strong>Réservation confirmée et e-mail envoyé avec succès !</strong>
            </div>
            <div class='text-center'>
                <a href='contact.html' class='btn btn-primary'>Retour</a>
            </div>
        </div>
    </body>
    </html>";
} catch (Exception $e) {
    echo "Erreur lors de l'envoi du mail : " . $mail->ErrorInfo;
}
