<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maison des Hôtes – UNZ</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- Google Fonts (Roboto) -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: #f5f5f5;
    }

    footer {
      background: linear-gradient(135deg, #1565c0, #0d47a1);
      color: white;
      padding: 40px 20px 20px;
      font-size: 15px;
      box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.2);
    }

    .footer-container {
      max-width: 1300px;
      margin: auto;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 30px;
    }

    .footer-section {
      flex: 1 1 250px;
      animation: slideUp 0.6s ease-out forwards;
      opacity: 0;
      transform: translateY(20px);
    }

    .footer-section:nth-child(2) { animation-delay: 0.2s; }
    .footer-section:nth-child(3) { animation-delay: 0.4s; }
    .footer-section:nth-child(4) { animation-delay: 0.6s; }

    .footer-section h3,
    .footer-section h4 {
      margin-bottom: 15px;
      font-size: 20px;
      border-left: 4px solid #28a745;
      padding-left: 12px;
      color: #e3f2fd;
    }

    .footer-section a {
      color: #bbdefb;
      text-decoration: none;
      margin-left: 10px;
      transition: 0.3s ease;
    }

    .footer-section a:hover {
      color: #28a745;
      transform: translateX(5px);
    }

    .footer-section ul {
      list-style: none;
      padding: 0;
    }

    .footer-section li {
      margin-bottom: 12px;
      display: flex;
      align-items: center;
    }

    .footer-section i {
      color: #28a745;
      min-width: 22px;
      font-size: 18px;
    }

    .footer-contact span {
      margin-left: 10px;
      font-size: 14px;
      color: #bbdefb;
    }

    .footer-section p {
      font-size: 14px;
      color: #bbdefb;
      line-height: 1.8;
    }

    .footer-newsletter form {
      display: flex;
      gap: 10px;
    }

    .footer-newsletter input {
      flex: 1;
      padding: 8px 12px;
      border-radius: 4px;
      border: none;
      font-size: 14px;
    }

    .footer-newsletter button {
      padding: 8px 14px;
      border: none;
      border-radius: 4px;
      background-color: #28a745;
      color: white;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .footer-newsletter button:hover {
      background-color: #1e7e34;
    }

    .footer-scroll {
      overflow: hidden;
      white-space: nowrap;
      position: relative;
      height: 30px;
      margin-top: 25px;
    }

    .footer-scroll p {
      position: absolute;
      animation: scrollText 12s linear infinite;
      color: #e3f2fd;
      font-size: 14px;
      font-weight: 500;
    }

    .footer-bottom {
      margin-top: 20px;
      text-align: center;
      font-size: 13px;
      color: #bbdefb;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      padding-top: 15px;
      position: relative;
    }

    .back-to-top {
      position: absolute;
      right: 15px;
      top: -10px;
      color: #28a745;
      font-size: 20px;
      transition: 0.3s ease;
    }

    .back-to-top:hover {
      transform: translateY(-4px);
      color: white;
    }

    @keyframes scrollText {
      0% { left: 100%; }
      100% { left: -100%; }
    }

    @keyframes slideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media screen and (max-width: 768px) {
      .footer-container {
        flex-direction: column;
        text-align: center;
      }

      .footer-section {
        margin-bottom: 20px;
      }

      .footer-newsletter form {
        flex-direction: column;
      }

      .footer-newsletter input,
      .footer-newsletter button {
        width: 100%;
      }

      .back-to-top {
        position: relative;
        display: block;
        margin-top: 10px;
        top: 0;
      }
    }
  </style>
</head>
<body>

<!-- TON FOOTER -->
<footer role="contentinfo" aria-label="Pied de page Maison des Hôtes">
  <div class="footer-container">
    
    <!-- À propos -->
    <div class="footer-section footer-about">
      <h3><i class="fas fa-building"></i> <a href="apropos.php">À propos</a></h3>
      
    </div>

    <!-- Liens utiles -->
    <div class="footer-section footer-links">
      <h4><i class="fas fa-link"></i> Liens utiles</h4>
      <ul>
        <li><i class="fas fa-globe"></i><a href="https://unz.bf/" target="_blank">Site UNZ</a></li>
        <li><i class="fab fa-whatsapp"></i><a href="https://wa.me/22655898778" target="_blank">WhatsApp</a></li>
        <li><i class="fab fa-facebook"></i><a href="https://facebook.com/unz" target="_blank">Facebook</a></li>
        <li><i class="fab fa-twitter"></i><a href="https://twitter.com/unz" target="_blank">Twitter</a></li>
      </ul>
    </div>

    <!-- Contact -->
    <div class="footer-section footer-contact">
      <h4><i class="fas fa-envelope-open-text"></i> <a href="contact.php">Contactez-nous</a></h4>
      <ul>
        <li><i class="fas fa-envelope"></i><a href="mailto:unz@gmail.com">unz@gmail.com</a></li>
        <li><i class="fas fa-phone-alt"></i><span>+226 55 89 87 78</span></li>
        <li><i class="fas fa-map-marker-alt"></i><span>Koudougou, Burkina Faso</span></li>
      </ul>
    </div>

    
  <!-- Texte défilant -->
  <div class="footer-scroll">
    <p>© 2025 UNZ – Projet réalisé par un étudiant en Informatique lors d’un stage à la DSI – Merci pour votre visite !</p>
  </div>

  <!-- Bas de page -->
  <div class="footer-bottom">
    Développé pour l’Université Norbert Zongo – Tous droits réservés
    <a href="#" class="back-to-top" title="Retour en haut"><i class="fas fa-chevron-up"></i></a>
  </div>
</footer>

</body>
</html>
