<?php
require 'vendor/autoload.php';
include(__DIR__ . "/config.php");

use Dompdf\Dompdf;

$id_utilisateur = $_GET['id'] ?? null;
if (!$id_utilisateur) {
    echo "Utilisateur non spécifié.";
    exit;
}

$sql = "SELECT f.id, u.email, f.numero_chambre, f.montant, f.moyen_paiement, f.date_reservation 
        FROM reservations f 
        JOIN utilisateurs u ON f.utilisateur_id = u.id 
        WHERE u.id = :id_utilisateur
        ORDER BY f.date_reservation DESC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
$stmt->execute();
$factures = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<style>
    body { font-family: DejaVu Sans, sans-serif; }
    h1 { text-align: center; color: #007bff; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #333; padding: 8px; text-align: left; }
    th { background-color: #007bff; color: white; }
</style>

<h1>Fiche des Factures</h1>

<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Chambre</th>
            <th>Montant</th>
            <th>Moyen de paiement</th>
            <th>Date de réservation</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($factures as $facture): ?>
        <tr>
            <td><?= $facture['email'] ?></td>
            <td><?= $facture['numero_chambre'] ?></td>
            <td><?= number_format($facture['montant'], 0, ',', ' ') ?> FCFA</td>
            <td><?= $facture['moyen_paiement'] ?></td>
            <td><?= date('d/m/Y', strtotime($facture['date_reservation'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$html = ob_get_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("facture_utilisateur_$id_utilisateur.pdf", ["Attachment" => false]);
exit;
?>
