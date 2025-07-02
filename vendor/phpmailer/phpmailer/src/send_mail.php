<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configuration SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // Serveur SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'leondima775@gmail.com';  // Ton adresse mail
    $mail->Password   = 'sqem iauo vxvm petq';        // Mot de passe application
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Destinataire
    $mail->setFrom('tonadresse@gmail.com', 'Maison des Hôtes');
    $mail->addAddress($email_utilisateur); // par exemple : $_POST['email']

    // Contenu du mail
    $mail->isHTML(true);
    $mail->Subject = 'Confirmation de réservation';
    $mail->Body    = "Bonjour $nom_utilisateur,<br><br>
    Votre réservation à la Maison des Hôtes a bien été enregistrée.<br>
    Dates : du $date_debut au $date_fin<br><br>
    Merci de votre confiance !";

    $mail->send();
    echo 'E-mail envoyé avec succès !';
} catch (Exception $e) {
    echo "Erreur lors de l’envoi du mail : {$mail->ErrorInfo}";
}
?>
