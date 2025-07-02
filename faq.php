<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/R.jpeg" type="image/png" />
  <title>FAQ - Maison des Hôtes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    }

    .container {
      max-width: 900px;
      margin: 2rem auto;
      padding: 2rem;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    h2 {
      font-size: 2.5rem;
      color: #0d47a1;
      margin-bottom: 1.5rem;
      text-align: center;
      font-weight: 700;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    p.text-muted {
      font-size: 1.2rem;
      color: #555;
      text-align: center;
      margin-bottom: 2rem;
    }

    .card {
      border: none;
      margin-bottom: 1.5rem;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-header {
      background: linear-gradient(90deg, #28a745, #1a7c34);
      border-radius: 15px 15px 0 0;
      padding: 1rem;
    }

    .card-header button {
      color: #e3f2fd;
      font-weight: 600;
      font-size: 1.1rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
      text-align: left;
    }

    .card-header button:hover {
      color: #bbdefb;
    }

    .card-body {
      background: #ffffff;
      color: #333;
      padding: 1.5rem;
      font-size: 1rem;
      line-height: 1.6;
    }

    .faq-icon {
      margin-right: 12px;
      color: #28a745;
      font-size: 1.2rem;
    }

    .card.guide {
      border-left: 5px solid #28a745;
      background: #ffffff;
      border-radius: 15px;
    }

    .card.guide .card-header {
      background: linear-gradient(90deg, #0d47a1, #1565c0);
      color: #e3f2fd;
    }

    .btn-container {
      text-align: center;
      margin-top: 2rem;
    }

    .btn-success, .btn-secondary {
      font-weight: 600;
      border-radius: 30px;
      padding: 0.8rem 2rem;
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    }

    .btn-success {
      background: linear-gradient(90deg, #28a745, #1a7c34);
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-success:hover {
      background: linear-gradient(90deg, #1a7c34, #28a745);
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-secondary {
      background: linear-gradient(90deg, #0d47a1, #1565c0);
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary:hover {
      background: linear-gradient(90deg, #1565c0, #0d47a1);
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .phpmailer-logo {
      height: 40px;
      margin-left: 10px;
      vertical-align: middle;
    }

    @media (max-width: 768px) {
      .container {
        margin: 1rem;
        padding: 1.5rem;
      }
      h2 {
        font-size: 2rem;
      }
      p.text-muted {
        font-size: 1rem;
      }
      .card-header button {
        font-size: 1rem;
      }
      .card-body {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
 <?php include 'navbar2.php'; ?>

  <!-- Contenu principal -->
  <div class="container my-5" role="main" aria-label="Foire aux questions">
    <h2><i class="fas fa-question-circle text-info"></i> Foire Aux Questions (FAQ)</h2>
    <p class="text-muted">Vous avez des questions ? Voici les réponses aux plus fréquentes.</p>

    <!-- FAQ -->
    <div class="accordion" id="faqAccordion">
      <!-- 1 -->
      <div class="card">
        <div class="card-header" id="faq1">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
              <i class="fas fa-user-plus faq-icon"></i> Comment créer un compte utilisateur ?
            </button>
          </h5>
        </div>
        <div id="collapse1" class="collapse show" data-parent="#faqAccordion">
          <div class="card-body">
            Cliquez sur “S'inscrire” dans le menu principal, remplissez vos informations (nom, e-mail, mot de passe etc), puis validez.
          </div>
        </div>
      </div>

      <!-- 2 -->
      <div class="card">
        <div class="card-header" id="faq2">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
              <i class="fas fa-bed faq-icon"></i> Comment réserver une chambre ?
            </button>
          </h5>
        </div>
        <div id="collapse2" class="collapse" data-parent="#faqAccordion">
          <div class="card-body">
            Connectez-vous, sélectionnez une chambre disponible dans “Nos chambres”, choisissez vos dates, et confirmez avec votre code_semaine.
          </div>
        </div>
      </div>

      <!-- 3 -->
      <div class="card">
        <div class="card-header" id="faq3">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
              <i class="fas fa-envelope faq-icon"></i> Est-ce que je reçois un e-mail après réservation ?
            </button>
          </h5>
        </div>
        <div id="collapse3" class="collapse" data-parent="#faqAccordion">
          <div class="card-body">
            Oui, une confirmation est envoyée à votre e-mail après validation de la réservation. Vérifiez vos spams si nécessaire.
        
          </div>
        </div>
      </div>
    </div>

    <!-- Guide -->
    <div class="card my-5 guide shadow-sm">
      <div class="card-header">
        <h5 class="mb-0">📘 Guide d'utilisation</h5>
      </div>
      <div class="card-body">
        <p>Ce guide vous explique comment :</p>
        <ul>
          <li>Créer un compte utilisateur</li>
          <li>Réserver une chambre</li>
          <li>Voir la disponibilité des chambres</li>
          <li>Comprendre les types de statuts (invité, intervenant)</li>
        </ul>
        <a href="Guide_utilisation_Maison_des_Hotes_UNZ.pdf" class="btn btn-success mt-3" download aria-label="Télécharger le guide d’utilisation">
          <i class="fas fa-download"></i> Télécharger le Guide (PDF)
        </a>
      </div>
    </div>

    <div class="btn-container">
      <a href="index.php" class="btn btn-secondary" aria-label="Retour à l’accueil">
        <i class="fas fa-arrow-left"></i> Retour à l'accueil
      </a>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>