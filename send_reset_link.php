


<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$pdo = new PDO('mysql:host=localhost;dbname=maison_des_hotes', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

        $stmt = $pdo->prepare('INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)');
        $stmt->execute([$email, $token, $expiry]);

        $resetLink = "http://localhost/maison_des_hotes_unz/reset_password.php?token=$token";

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // exemple
        $mail->SMTPAuth = true;
        $mail->Username = 'leondima775@gmail.com';
        $mail->Password = 'sqem iauo vxvm petq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('leondima775@gmail.com', 'Maison des Hôtes');
        $mail->addAddress($email);
        $mail->Subject = 'Lien de réinitialisation';
        $mail->Body = "Clique ici pour réinitialiser ton mot de passe :\n$resetLink";

        $mail->send();
        echo "✅ Lien envoyé.";
    } else {
        echo "❌ Email introuvable.";
    }
}
?>
