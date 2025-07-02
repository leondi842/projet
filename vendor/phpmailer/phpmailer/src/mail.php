<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Config SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // SMTP de Gmail
    $mail->SMTPAuth   = true;
    $mail->Username   = 'leondima775@gmailcom'; // Ton adresse Gmail
    $mail->Password   = 'exmk gkls xxcl ypcj'; // Mot de passe d’application Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Destinataire et expéditeur
    $mail->setFrom('tonemail@gmail.com', 'Maison des Hôtes');
    $mail->addAddress('destinataire@example.com', 'Nom du Destinataire');

    // Contenu du message
    $mail->isHTML(true);
    $mail->Subject = 'Confirmation de votre réservation';
    $mail->Body    = 'Bonjour,<br>Votre réservation à la Maison des Hôtes est confirmée !<br><strong>Merci de votre confiance.</strong>';

    $mail->send();
    echo 'Message envoyé avec succès !';
} catch (Exception $e) {
    echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
}
?>
