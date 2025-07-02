<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connexion DB ici...

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $type = $_POST['type']; // 'professeur_invite' ou 'intervenant'

    // Vérifier le nombre de réservations existantes
    $stmt = $pdo->query("SELECT COUNT(*) FROM reservations");
    $nbReservations = $stmt->fetchColumn();

    if ($nbReservations >= 11) {
        echo "Désolé, toutes les chambres sont déjà réservées.";
        exit;
    }

    // Enregistrer la réservation
    $insert = $pdo->prepare("INSERT INTO reservations (nom, email, type_utilisateur) VALUES (?, ?, ?)");
    $insert->execute([$nom, $email, $type]);

    // Si c’est un professeur invité, on envoie un e-mail
    if ($type === 'professeur_invite') {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'leondima775@gmail.com';
            $mail->Password = 'mot_de_passe_app';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('leondima775@gmail.com', 'Maison des Hôtes');
            $mail->addAddress($email, $nom);
            $mail->isHTML(true);
            $mail->Subject = 'Votre réservation prioritaire est confirmée';
            $mail->Body = "
                <h3>Bonjour $nom,</h3>
                <p>Vous avez été priorisé en tant que professeur invité. Votre réservation est bien enregistrée.</p>
                <p>Merci pour votre confiance.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            echo "Erreur envoi e-mail : {$mail->ErrorInfo}";
        }
    }

    echo "Réservation enregistrée avec succès.";
}
?>
