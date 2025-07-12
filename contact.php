<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="R.jpeg" type="image/png" />
  <title>Contactez-nous - Maison des Hôtes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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

    .contact-container {
      margin-top: 4rem;
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .contact-container.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .contact-header {
      background: linear-gradient(90deg, #0d47a1, #1565c0);
      color: white;
      padding: 2.5rem;
      border-radius: 15px 15px 0 0;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .contact-header h4 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    }

    .contact-header p {
      font-size: 1.2rem;
      font-weight: 400;
    }

    .contact-form {
      padding: 3rem;
      background: rgba(255, 255, 255, 0.98);
      border-radius: 0 0 15px 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .contact-form:hover {
      transform: translateY(-5px);
    }

    .form-control {
      border-radius: 8px;
      font-size: 1.1rem;
      padding: 0.8rem;
    }

    .form-control:focus {
      box-shadow: 0 0 8px rgba(40, 167, 69, 0.3);
      border-color: #28a745;
    }

    .btn-custom {
      background: linear-gradient(90deg, #28a745, #1a7c34);
      color: white;
      border: none;
      border-radius: 30px;
      padding: 1rem 2rem;
      font-weight: 600;
      font-size: 1.2rem;
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .btn-custom:hover {
      background: linear-gradient(90deg, #1a7c34, #28a745);
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .contact-info {
      background: rgba(255, 255, 255, 0.98);
      padding: 3rem;
      margin-top: 2rem;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .contact-info:hover {
      transform: translateY(-5px);
    }

    .contact-info h5 {
      font-size: 1.6rem;
      color: #28a745;
      font-weight: 600;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .contact-info p {
      font-size: 1.2rem;
      color: #333;
      margin-bottom: 1rem;
    }

    .fa-icon {
      color: #28a745;
      font-size: 1.2rem;
    }

    .btn-whatsapp {
      display: inline-flex;
      align-items: center;
      background: linear-gradient(90deg, #25D366, #1ebe57);
      color: white;
      padding: 0.8rem 1.5rem;
      border-radius: 30px;
      font-weight: 600;
      font-size: 1.1rem;
      text-decoration: none;
      margin-top: 1.5rem;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-whatsapp:hover {
      background: linear-gradient(90deg, #1ebe57, #25D366);
      transform: scale(1.05);
      text-decoration: none;
    }

    .btn-whatsapp i {
      font-size: 1.4rem;
      margin-right: 8px;
    }

    .liens-utiles ul {
      list-style-type: none;
      padding-left: 0;
      font-size: 1.1rem;
    }

    .liens-utiles ul li a {
      color: #28a745;
      text-decoration: none;
      transition: color 0.3s ease, text-decoration 0.3s ease;
    }

    .liens-utiles ul li a:hover {
      color: #1a7c34;
      text-decoration: underline;
    }

    .map-container {
      margin-top: 2rem;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
      .contact-container {
        margin-top: 2rem;
      }
      .contact-header {
        padding: 2rem;
      }
      .contact-header h4 {
        font-size: 1.6rem;
      }
      .contact-header p {
        font-size: 1rem;
      }
      .contact-form, .contact-info {
        padding: 2rem;
      }
      .form-control {
        font-size: 1rem;
      }
      .btn-custom, .btn-whatsapp {
        font-size: 1rem;
        padding: 0.8rem 1.5rem;
      }
      .contact-info h5 {
        font-size: 1.4rem;
      }
      .contact-info p {
        font-size: 1.1rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'navbar2.php'; ?>

  <div class="container contact-container">
    <!-- Message de remerciement -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
      <div class="alert alert-success text-center font-weight-bold" role="alert">
        <i class="fas fa-check-circle me-2"></i> Merci de nous avoir contactés ! Nous reviendrons vers vous très vite.
      </div>
    <?php endif; ?>

    <div class="row">
      <!-- Formulaire de contact -->
      <div class="col-md-7">
        <div class="contact-header" role="banner" aria-label="Centre d’aide">
          <h4><i class="fas fa-headset me-2"></i> Centre d’aide</h4>
          <p class="mb-0">
            Vous avez une question ? Écrivez-nous !<br>
            Ou contactez-nous directement sur WhatsApp au <strong>+226 55 89 87 78</strong>.
          </p>
        </div>

        <div class="contact-form">
          <form method="post" action="traitement_contact.php" id="contactForm">
            <div class="form-group">
              <label for="nom">Nom complet</label>
              <input type="text" class="form-control" id="nom" name="nom" required aria-label="Nom complet" />
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" name="message" rows="5" required aria-label="Message"></textarea>
            </div>
            <button type="submit" class="btn btn-custom">
              <i class="fas fa-paper-plane me-2"></i> Envoyer
            </button>
          </form>

          <!-- Lien WhatsApp -->
          <a href="https://wa.me/22655898778" target="_blank" class="btn-whatsapp" aria-label="Contacter via WhatsApp">
            <i class="fab fa-whatsapp"></i> Contactez-nous sur WhatsApp
          </a>
        </div>
      </div>

      <!-- Infos de contact -->
      <div class="col-md-5">
        <div class="contact-info">
          <h5><i class="fas fa-map-marker-alt fa-icon"></i> Adresse</h5>
          <p>Université Norbert Zongo, Koudougou, Burkina Faso</p>

          <h5><i class="fas fa-phone fa-icon"></i> Téléphone</h5>
          <p>+226 55 89 87 78</p>

          <h5><i class="fas fa-envelope fa-icon"></i> Email</h5>
          <p><a href="mailto:unz@gmail.com" class="text-decoration-none" style="color: #28a745;">unz@gmail.com</a></p>

          <h5><i class="fas fa-clock fa-icon"></i> Heures d'ouverture</h5>
          <p>Lundi - Vendredi : 08h00 - 17h30</p>

          <!-- Liens utiles -->
          <div class="liens-utiles mt-4">
            <h5><i class="fas fa-link fa-icon"></i> Liens utiles</h5>
            <ul>
              <li><a href="conditions_generales.php" aria-label="Conditions Générales d’Utilisation">Conditions Générales d’Utilisation</a></li>
              <li><a href="a_propos.php" aria-label="À propos de la Maison des Hôtes">À propos de la Maison des Hôtes</a></li>
              <li><a href="faq.php" aria-label="Foire aux Questions">Foire aux Questions</a></li>
            </ul>
          </div>
        </div>

        <!-- Google Maps -->
        <div class="map-container">
          <h5><i class="fas fa-map-marker-alt fa-icon"></i> Localisation</h5>
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.290350163727!2d-2.366615185138616!3d12.252143790945307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xe2f7b1682a4eaaf%3A0x381ec0b17e47a53e!2sUniversité%20Norbert%20Zongo!5e0!3m2!1sfr!2sbf!4v1686280712345!5m2!1sfr!2sbf" 
            width="100%" 
            height="250" 
            style="border:0;" 
            allowfullscreen 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade" 
            aria-label="Carte Google Maps de l’Université Norbert Zongo">
          </iframe>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('load', () => {
      document.querySelector('.contact-container').classList.add('visible');
      document.getElementById('contactForm').addEventListener('submit', function (e) {
        const nom = document.getElementById('nom').value.trim();
        const message = document.getElementById('message').value.trim();
        if (!nom || !message) {
          e.preventDefault();
          alert("Hey, n'oublie pas de remplir tous les champs avant d'envoyer !");
        }
      });
    });
  </script>

  <?php include 'footer.php'; ?>
</body>
</html>