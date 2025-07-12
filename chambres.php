<?php
// Toujours tout en haut, sans espace ni ligne vide
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['type'] = $_SESSION['type'] ?? 'invité';
$type_user = $_SESSION['type'];
$suggestion = $type_user === 'invité'
    ? "Vous pouvez réserver n’importe quelle chambre gratuitement !"
    : "En tant qu’intervenant, le tarif est de 7500 FCFA/nuit.";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="R.jpeg" type="image/png" />
  <title>Galerie des Chambres - Maison des Hôtes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #bbdefb, #90caf9);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      color: #333;
      position: relative;
    }

    .hero {
      background: linear-gradient(rgba(40, 167, 69, 0.8), rgba(26, 124, 52, 0.8)), url('images_chambres/banner.jpg') center/cover no-repeat;
      color: #e3f2fd;
      padding: 100px 0;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .hero img {
      height: 100px;
      border-radius: 12px;
      margin-bottom: 15px;
    }

    .alert-info {
      background: rgba(255, 255, 255, 0.95);
      color: #0d47a1;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      font-weight: 500;
      padding: 1.5rem;
      max-width: 800px;
      margin: 2rem auto;
    }

    .chambres-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .chambres-scroll {
      display: flex;
      overflow-x: auto;
      gap: 1.5rem;
      padding-bottom: 1rem;
      scroll-behavior: smooth;
      scrollbar-width: thin;
      scrollbar-color: #28a745 #e3f2fd;
    }

    .chambres-scroll::-webkit-scrollbar {
      height: 8px;
    }

    .chambres-scroll::-webkit-scrollbar-track {
      background: #e3f2fd;
      border-radius: 4px;
    }

    .chambres-scroll::-webkit-scrollbar-thumb {
      background: #28a745;
      border-radius: 4px;
    }

    .chambre-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      min-width: 300px;
      max-width: 300px;
      flex: 0 0 auto;
    }

    .chambre-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .chambre-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .chambre-card .card-body {
      padding: 1.5rem;
    }

    .chambre-card h5 {
      font-size: 1.6rem;
      color: #0d47a1;
      margin-bottom: 1rem;
    }

    .chambre-card p {
      font-size: 1rem;
      color: #555;
      margin-bottom: 1.5rem;
    }

    .chambre-card .btn {
      background: linear-gradient(90deg, #28a745, #1a7c34);
      color: white;
      border: none;
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .chambre-card .btn:hover {
      background: linear-gradient(90deg, #1a7c34, #28a745);
      transform: scale(1.05);
    }

    .videos-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .videos-container video {
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
      .hero {
        padding: 60px 0;
      }

      .hero img {
        margin-bottom: 10px;
      }

      .chambre-card {
        min-width: 250px;
      }

      .videos-container video {
        height: 200px;
      }
    }
  </style>
</head>
<body>

  <?php include 'navbar2.php'; ?>

  <!-- Hero Section avec logo -->
  <div class="hero" role="banner" aria-label="Section principale">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
      <img src="R.jpeg" alt="Logo Maison des Hôtes" />
      <div class="text-center text-md-start">
        <h1>Bienvenue à la Maison des Hôtes</h1>
        <p>Explorez nos chambres confortables, modernes et connectées</p>
      </div>
    </div>
  </div>

  <!-- Suggestion -->
  <div class="alert alert-info text-center mx-4 my-4" role="alert" aria-label="Suggestion pour l’utilisateur">
    <i class="fas fa-info-circle me-2"></i><?= htmlspecialchars($suggestion) ?>
  </div>

  <!-- Défilement Horizontal des Chambres -->
  <div class="chambres-container">
    <h2 class="text-center mb-5">Nos Chambres</h2>
    <div class="chambres-scroll">
      <?php for ($i = 1; $i <= 10; $i++): ?>
      <div class="chambre-card" role="region" aria-label="Chambre <?= $i ?>">
        <img src="IMAé.jpg" alt="Chambre <?= $i ?>" />
        <div class="card-body">
          <h5>Chambre <?= $i ?></h5>
          <p>Climatisée, Wi-Fi, Douche privée</p>
          <a href="chambre_details.php?chambre_id=<?= $i ?>" class="btn" aria-label="Voir la chambre <?= $i ?>">Voir</a>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>

  <!-- Vidéos de Présentation -->
  <div class="videos-container">
    <h3 class="text-center mb-4">Découvrez la Maison des Hôtes en Vidéo</h3>
    <div class="row justify-content-center">
      <div class="col-md-6 mb-4">
        <video autoplay muted loop playsinline class="w-100" aria-label="Vidéo de présentation 1">
          <source src="video1.mp4" type="video/mp4" />
          Votre navigateur ne supporte pas la lecture de la vidéo.
        </video>
      </div>
      <div class="col-md-6 mb-4">
        <video autoplay muted loop playsinline class="w-100" aria-label="Vidéo de présentation 2">
          <source src="videos/video.mp4" type="video/mp4" />
          Votre navigateur ne supporte pas la lecture de la vidéo.
        </video>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
