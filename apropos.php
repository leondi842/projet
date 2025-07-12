<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="R.jpeg" type="image/png" />
  <title>À propos de nous - Maison des Hôtes</title>
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

    .header {
      background: linear-gradient(90deg, #0d47a1, #1565c0);
      color: white;
      padding: 3rem 2rem;
      text-align: center;
      border-bottom: 5px solid #28a745;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      position: relative;
      z-index: 1;
    }

    .header h1 {
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    }

    .header p {
      font-size: 1.2rem;
      font-weight: 400;
    }

    main {
      flex: 1;
      padding: 4rem 2rem;
      background: url('images/maison2.jpg') center/cover no-repeat fixed;
      position: relative;
    }

    main::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.98);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      padding: 3rem;
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease;
    }

    .container:hover {
      transform: translateY(-5px);
    }

    .reglement-image {
      width: 70%;
      max-width: 400px;
      height: auto;
      border-radius: 12px;
      margin: 0 auto 2rem auto;
      display: block;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .reglement-image:hover {
      transform: scale(1.05);
    }

    h4 {
      font-size: 1.9rem;
      color: #28a745;
      font-weight: 600;
      margin-top: 3rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    p {
      font-size: 1.2rem;
      color: #333;
      margin-bottom: 1.8rem;
      line-height: 1.8;
    }

    ol {
      margin-left: 2.5rem;
      margin-bottom: 1.8rem;
      font-size: 1.2rem;
      color: #333;
    }

    ol li {
      margin-bottom: 1rem;
      padding-left: 1.8rem;
      position: relative;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    ul {
      margin-left: 3rem;
      margin-bottom: 1rem;
      font-size: 1.1rem;
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
      font-size: 1.1rem;
    }

    .text-right {
      font-size: 1.1rem;
      color: #555;
      text-align: right;
      margin-top: 3rem;
      font-style: italic;
    }

    .btn-primary {
      background: linear-gradient(90deg, #0d47a1, #1565c0);
      border: none;
      border-radius: 30px;
      padding: 1rem 2rem;
      font-weight: 600;
      font-size: 1.2rem;
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
      background: linear-gradient(90deg, #1565c0, #0d47a1);
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .icon {
      color: #28a745;
      font-size: 1.2rem;
    }

    @media (max-width: 768px) {
      main {
        padding: 2rem 1rem;
      }
      .container {
        padding: 2rem;
      }
      .header h1 {
        font-size: 2.2rem;
      }
      .header p {
        font-size: 1rem;
      }
      h4 {
        font-size: 1.6rem;
      }
      p, ol {
        font-size: 1.1rem;
      }
      .reglement-image {
        width: 90%;
        max-width: 300px;
      }
      .btn-primary {
        font-size: 1rem;
        padding: 0.8rem 1.5rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'navbar2.php'; ?>

  <div class="header" role="banner" aria-label="En-tête À propos">
    <h1><i class="fas fa-home me-2"></i> À propos de la Maison des Hôtes</h1>
    <p>Bienvenue à l'Université Norbert ZONGO</p>
  </div>

  <main role="main" aria-label="À propos de la Maison des Hôtes">
    <div class="container">
      <img src="R.jpeg" alt="Logo de l’Université Norbert ZONGO" class="reglement-image">

      <p>
        La Maison des Hôtes de l’Université Norbert ZONGO est un lieu d’accueil pour les professeurs invités,
        les intervenants et les visiteurs. Pour garantir un séjour agréable à tous, un règlement intérieur
        est affiché et doit être respecté par tous les usagers.
      </p>

      <h4><i class="fas fa-scroll icon"></i> Règlement de la Maison</h4>
      <ol>
        <li><i class="fas fa-ban icon"></i> Interdiction de garer derrière les camions.</li>
        <li><i class="fas fa-clock icon"></i> Chambre conservée après 12h00 = nuit facturée.</li>
        <li><i class="fas fa-file-alt icon"></i> Remettre votre fiche remplie à la réception.</li>
        <li><i class="fas fa-smoking-ban icon"></i> Il est interdit de fumer dans les chambres.</li>
        <li><i class="fas fa-cash-register icon"></i> Clients partant avant 10h : payer la veille.</li>
        <li><i class="fas fa-door-open icon"></i> Visiteurs dehors à 22h max, présence du client requise.</li>
        <li><i class="fas fa-sink icon"></i> Lavabos = uniquement pour toilettes (pas de vaisselle).</li>
        <li><i class="fas fa-tools icon"></i> Ne touchez pas aux appareils sanitaires/électriques.</li>
        <li><i class="fas fa-exclamation-circle icon"></i> Signaler tout dysfonctionnement rapidement.</li>
        <li><i class="fas fa-plug icon"></i> Appareils électriques puissants non autorisés = interdits.</li>
        <li><i class="fas fa-key icon"></i> Laisser la clé au vigile avant de partir pour le nettoyage.</li>
        <li><i class="fas fa-ban icon"></i> Interdictions diverses :
          <ul>
            <li>Appareils de cuisson non autorisés</li>
            <li>Marchands ambulants ou étrangers dans les chambres</li>
            <li>Bruits après 22PEATh</li>
          </ul>
        </li>
      </ol>

      <p class="text-right font-italic">– La Gestionnaire</p>
    </div>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>