<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link rel="icon" href="R.jpeg" type="image/png" />
  <link rel="icon" href="images/R.jpeg" type="image/png" />
  <title>Conditions Générales d'Utilisation - Maison des Hôtes</title>
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

    main {
      flex: 1;
      padding: 3rem 2rem;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.97);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      padding: 3rem;
      transition: transform 0.3s ease;
    }

    .container:hover {
      transform: translateY(-5px);
    }

    h1 {
      font-size: 2.5rem;
      color: #0d47a1;
      font-weight: 700;
      text-align: center;
      margin-bottom: 2rem;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    h2 {
      font-size: 1.8rem;
      color: #28a745;
      font-weight: 600;
      margin-top: 2.5rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    p {
      font-size: 1.1rem;
      color: #333;
      margin-bottom: 1.5rem;
      line-height: 1.7;
    }

    ul {
      margin-left: 2rem;
      margin-bottom: 1.5rem;
      font-size: 1.1rem;
      color: #333;
    }

    ul li {
      margin-bottom: 0.8rem;
      position: relative;
      padding-left: 1.5rem;
    }

    ul li::before {
      content: '\f058'; /* Font Awesome circle-check */
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      color: #28a745;
      position: absolute;
      left: 0;
    }

    .last-updated {
      font-size: 1rem;
      color: #555;
      text-align: center;
      margin-top: 3rem;
      font-style: italic;
    }

    .contact-link {
      color: #28a745;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .contact-link:hover {
      color: #1a7c34;
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      main {
        padding: 2rem 1rem;
      }
      .container {
        padding: 2rem;
      }
      h1 {
        font-size: 2rem;
      }
      h2 {
        font-size: 1.5rem;
      }
      p, ul {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
 <?php include 'navbar2.php'; ?>                                                                                                                           

  <main role="main" aria-label="Conditions Générales d'Utilisation">
    <div class="container">
      <h1><i class="fas fa-file-alt"></i> Conditions Générales d’Utilisation (CGU)</h1>

      <p>Bienvenue sur la plateforme de réservation en ligne de la <strong>Maison des Hôtes</strong> de l’Université Norbert ZONGO. En utilisant ce site, vous acceptez les présentes Conditions Générales d’Utilisation.</p>

      <h2><i class="fas fa-info-circle"></i> 1. Objet</h2>
      <p>La présente plateforme permet aux enseignants invités et intervenants de réserver des chambres à la Maison des Hôtes de manière simple, rapide et sécurisée.</p>

      <h2><i class="fas fa-user-check"></i> 2. Accès au service</h2>
      <p>L’accès est réservé aux utilisateurs autorisés, notamment :</p>
      <ul>
        <li>Les enseignants invités de l’université (réservations gratuites)</li>
        <li>Les intervenants externes (réservations payantes, selon les règles en vigueur)</li>
      </ul>

      <h2><i class="fas fa-desktop"></i> 3. Utilisation de la plateforme</h2>
      <p>Les utilisateurs s’engagent à fournir des informations exactes lors de la réservation. Toute tentative de fraude, de double réservation ou de mauvaise utilisation peut entraîner une suspension du compte ou l’annulation des réservations.</p>

      <h2><i class="fas fa-shield-alt"></i> 4. Protection des données</h2>
      <p>Les informations personnelles (nom, email, etc.) sont utilisées uniquement pour la gestion des réservations. Elles sont protégées et ne seront jamais partagées sans consentement.</p>

      <h2><i class="fas fa-exclamation-triangle"></i> 5. Responsabilité</h2>
      <p>Bien que nous fassions tout notre possible pour assurer un service fiable, l’Université ne peut être tenue responsable en cas d’interruption du service, d’erreur technique ou de perte de données liée à une mauvaise manipulation par l’utilisateur.</p>

      <h2><i class="fas fa-edit"></i> 6. Modifications des CGU</h2>
      <p>Ces conditions peuvent être mises à jour à tout moment. Les utilisateurs seront informés des changements importants via la plateforme.</p>

      <h2><i class="fas fa-envelope"></i> 7. Contact</h2>
      <p>Pour toute question ou réclamation, vous pouvez nous contacter à l’adresse suivante : <a href="mailto:unz@gmail.com" class="contact-link">unz@gmail.com</a></p>

      <p class="last-updated">Dernière mise à jour : Juin 2025</p>
    </div>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>