<?php
// Récupérer l'ID de la chambre depuis l'URL
$chambre_id = isset($_GET['chambre_id']) ? intval($_GET['chambre_id']) : 0;

// Tableau de chambres en exemple (tu peux remplacer par une requête SQL plus tard)
$chambres = [
    1 => "Chambre 1 : Climatisée, Wi-Fi, Douche privée",
    2 => "Chambre 2 : Climatisée, Wi-Fi, Douche privée",
    3 => "Chambre 3 : Climatisée, Wi-Fi, Douche privée",
    4 => "Chambre 4 : Climatisée, Wi-Fi, Douche privée",
    5 => "Chambre 5 : Climatisée, Wi-Fi, Douche privée",
    6 => "Chambre 6 : Climatisée, Wi-Fi, Douche privée",
    7 => "Chambre 7 : Climatisée, Wi-Fi, Douche privée",
    8 => "Chambre 8 : Climatisée, Wi-Fi, Douche privée",
    9 => "Chambre 9 : Climatisée, Wi-Fi, Douche privée",
    10 => "Chambre 10 : Climatisée, Wi-Fi, Douche privée",
    11 => "Chambre 11 : Climatisée, Wi-Fi, Douche privée"
];


$chambre_info = $chambres[$chambre_id] ?? "Chambre introuvable";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Détails de la Chambre <?= $chambre_id ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
     <?php include 'navbar2.php'; ?>
  <div class="container py-5">
    <h1 class="mb-4">Détails de la Chambre <?= $chambre_id ?></h1>
    <div class="alert alert-info"><?= htmlspecialchars($chambre_info) ?></div>
    <a href="chambres.php" class="btn btn-success mt-3">← Retour à la galerie</a>
  </div>
</body>
 <?php include 'footer.php'; ?>
</html>
