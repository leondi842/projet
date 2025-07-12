<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="R.jpeg" type="image/png" />
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
      margin: 3rem auto;
      padding: 2.5rem;
      background: rgba(255, 255, 255, 0.98);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .container.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .header {
      background: linear-gradient(90deg, #003399, #0d47a1);
      padding: 2rem;
      border-radius: 15px;
      text-align: center;
      margin-bottom: 2rem;
      position: relative;
      overflow: hidden;
    }

    .header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('images/maison2.jpg') center/cover no-repeat;
      opacity: 0.2;
      z-index: 0;
    }

    .header h2 {
      font-size: 2.8rem;
      color: #ffffff;
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      position: relative;
      z-index: 1;
    }

    .header p.text-muted {
      font-size: 1.3rem;
      color: #e3f2fd;
      position: relative;
      z-index: 1;
      margin-bottom: 0;
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
      background: linear-gradient(90deg, #2E8B57, #1a7c34);
      border-radius: 15px 15px 0 0;
      padding: 1rem;
      transition: background 0.3s ease;
    }

    .card-header button {
      color: #ffffff;
      font-weight: 600;
      font-size: 1.2rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 12px;
      width: 100%;
      text-align: left;
      transition: color 0.3s ease;
    }

    .card-header button:hover {
      color: #FFD700;
    }

    .card-body {
      background: #ffffff;
      color: #333;
      padding: 1.5rem;
      font-size: 1.1rem;
      line-height: 1.6;
      border-radius: 0 0 15px 15px;
    }

    .faq-icon {
      color: #FFD700;
      font-size: 1.3rem;
      transition: transform 0.3s ease;
    }

    .card-header button:hover .faq-icon {
      transform: scale(1.2);
    }

    .card.guide {
      border-left: 5px solid #2E8B57;
      background: #f8f9fa;
      border-radius: 15px;
    }

    .card.guide .card-header {
      background: linear-gradient(90deg, #003399, #0d47a1);
      color: #ffffff;
    }

    .card.guide .card-body {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .guide-icon {
      width: 60px;
      height: 60px;
      object-fit: contain;
    }

    .btn-container {
      text-align: center;
      margin-top: 2.5rem;
    }

    .btn-success, .btn-secondary {
      font-weight: 600;
      border-radius: 30px;
      padding: 0.9rem 2.5rem;
      font-size: 1.2rem;
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    }

    .btn-success {
      background: linear-gradient(90deg, #2E8B57, #1a7c34);
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-success:hover {
      background: linear-gradient(90deg, #1a7c34, #2E8B57);
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-secondary {
      background: linear-gradient(90deg, #003399, #0d47a1);
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary:hover {
      background: linear-gradient(90deg, #0d47a1, #003399);
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .faq-item h4 {
      font-size: 1.3rem;
      color: #2E8B57;
      margin-bottom: 1rem;
    }

    .faq-item p {
      font-size: 1.1rem;
      line-height: 1.6;
    }

    .faq-item a {
      color: #003399;
      text-decoration: none;
      font-weight: 500;
    }

    .faq-item a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .container {
        margin: 1.5rem;
        padding: 2rem;
      }
      .header h2 {
        font-size: 2.2rem;
      }
      .header p.text-muted {
        font-size: 1.1rem;
      }
      .card-header button {
        font-size: 1.1rem;
      }
      .card-body {
        font-size: 1rem;
      }
      .guide-icon {
        width: 50px;
        height: 50px;
      }
      .btn-success, .btn-secondary {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'navbar2.php'; ?>

  <!-- Contenu principal -->
  <div class="container my-5" role="main" aria-label="Foire aux questions">
    <div class="header">
      <h2><i class="fas fa-question-circle mr-2"></i> Foire Aux Questions (FAQ)</h2>
      <p class="text-muted">Réponses aux questions fréquentes pour une réservation simplifiée</p>
    </div>

    <!-- FAQ -->
    <div class="accordion" id="faqAccordion">
      <!-- 1 -->
      <div class="card">
        <div class="card-header" id="faq1">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" aria-label="Comment créer un compte utilisateur">
              <i class="fas fa-user-plus faq-icon"></i> Comment créer un compte utilisateur ?
            </button>
          </h5>
        </div>
        <div id="collapse1" class="collapse show" data-parent="#faqAccordion">
          <div class="card-body">
            Cliquez sur “S'inscrire” dans le menu principal, remplissez vos informations (nom, e-mail, mot de passe, etc.), puis validez votre inscription.
          </div>
        </div>
      </div>

      <!-- 2 -->
      <div class="card">
        <div class="card-header" id="faq2">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2" aria-label="Comment réserver une chambre">
              <i class="fas fa-bed faq-icon"></i> Comment réserver une chambre ?
            </button>
          </h5>
        </div>
        <div id="collapse2" class="collapse" data-parent="#faqAccordion">
          <div class="card-body">
            Connectez-vous, accédez à “Nos chambres”, sélectionnez une chambre disponible et vos dates, puis confirmez avec votre code unique (<tt>code_semaine</tt>).
          </div>
        </div>
      </div>

      <!-- 3 -->
      <div class="card">
        <div class="card-header" id="faq3">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3" aria-label="Confirmation par e-mail">
              <i class="fas fa-envelope faq-icon"></i> Est-ce que je reçois un e-mail après réservation ?
            </button>
          </h5>
        </div>
        <div id="collapse3" class="collapse" data-parent="#faqAccordion">
          <div class="card-body">
            Oui, un e-mail de confirmation est envoyé après validation de votre réservation. Vérifiez votre dossier de spams si nécessaire.
          </div>
        </div>
      </div>
    </div>

    <!-- Guide -->
    <div class="card my-5 guide shadow-sm">
      <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-book mr-2"></i> Guide d'utilisation</h5>
      </div>
      <div class="card-body">
        <img src="R.jpeg" alt="Icône PDF" class="guide-icon" />
        <div>
          <p>Ce guide vous explique comment :</p>
          <ul>
            <li>Créer un compte utilisateur</li>
            <li>Réserver une chambre</li>
            <li>Vérifier la disponibilité des chambres</li>
            <li>Comprendre les statuts (invité, intervenant)</li>
          </ul>
          <div class="faq-item">
            <h4><i class="fas fa-home mr-2"></i> L’annexe de la Maison des Hôtes est-elle disponible ?</h4>
            <p><i class="fas fa-check-circle mr-2"></i> Oui, l’annexe est réservable et offre les mêmes commodités : climatisation, Wi-Fi, douche privée.</p>
            <p><i class="fas fa-arrow-right mr-2"></i> Contactez l’administration via la <a href="contact.php">page de contact</a> pour réserver l’annexe.</p>
          </div>
          <a href="Guide_utilisation_Maison_des_Hotes_UNZ.pdf" class="btn btn-success mt-3" download aria-label="Télécharger le guide d’utilisation">
            <i class="fas fa-download mr-2"></i> Télécharger le Guide (PDF)
          </a>
        </div>
      </div>
    </div>

    <div class="btn-container">
      <a href="index.php" class="btn btn-secondary" aria-label="Retour à l’accueil">
        <i class="fas fa-arrow-left mr-2"></i> Retour à l’accueil
      </a>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('load', () => {
      document.querySelector('.container').classList.add('visible');
    });
  </script>
</body>
</html>