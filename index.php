<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="R.jpeg" type="image/png" />
  <title>Maison des Hôtes - Accueil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- MUI (Material UI) CDN -->
  <link href="https://cdn.jsdelivr.net/npm/@mui/material@5.13.7/dist/material.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #bbdefb 0%, #90caf9 100%);
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      overflow-x: hidden;
    }

    header {
      background: linear-gradient(90deg, #28a745, #1a7c34);
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    header h2 {
      margin: 0;
      font-size: 1.8rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    header nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-size: 1.1rem;
      font-weight: 500;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    header nav a:hover {
      color: #e3f2fd;
      transform: scale(1.05);
    }

    main.container {
      flex: 1;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .marquee {
      overflow: hidden;
      white-space: nowrap;
      font-size: 2rem;
      font-weight: 700;
      color: #0d47a1;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      margin-bottom: 20px;
      text-align: center;
      animation: marqueeAnim 15s linear infinite;
    }

    @keyframes marqueeAnim {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }

    .marquee-img-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .marquee-img {
      height: 50px;
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.1); }
    }

    .content-container {
      display: flex;
      flex-direction: column;
      gap: 30px;
      align-items: center;
    }

    @media (min-width: 768px) {
      .content-container {
        flex-direction: row;
        justify-content: space-between;
      }
    }

    .carousel-container {
      width: 100%;
      max-width: 600px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      background: white;
      position: relative;
      transition: transform 0.3s ease;
    }

    .carousel-container:hover {
      transform: translateY(-5px);
    }

    .carousel-slide {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .carousel-slide img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      flex-shrink: 0;
      border-radius: 15px;
    }

    .carousel-buttons {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }

    .carousel-btn {
      background: rgba(13, 71, 161, 0.8);
      border: none;
      color: white;
      font-size: 1.8rem;
      padding: 10px;
      cursor: pointer;
      border-radius: 50%;
      margin: 0 15px;
      transition: background 0.3s ease;
    }

    .carousel-btn:hover {
      background: #0d47a1;
    }

    .video-header {
      width: 100%;
      max-width: 500px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .video-header video {
      width: 100%;
      height: auto;
      border-radius: 15px;
    }

    footer {
      background: linear-gradient(90deg, #0d47a1, #1565c0);
      color: white;
      padding: 30px;
      text-align: center;
      box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.2);
    }

    footer nav a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-size: 1.1rem;
      transition: color 0.3s ease;
    }

    footer nav a:hover {
      color: #bbdefb;
    }

    .btn-primary {
      display: inline-block;
      margin-top: 30px;
      background: #28a745;
      color: white;
      padding: 12px 30px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: 600;
      font-size: 1.2rem;
      transition: background 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:hover {
      background: #1a7c34;
      transform: scale(1.05);
    }

    @media (max-width: 767px) {
      header h2 {
        font-size: 1.4rem;
      }

      .marquee {
        font-size: 1.5rem;
      }

      .carousel-slide img {
        height: 200px;
      }

      .carousel-btn {
        font-size: 1.4rem;
        padding: 8px;
      }

      .btn-primary {
        width: 80%;
        font-size: 1rem;
      }
    }
  </style>
</head>

<body>
  <?php include 'navbar2.php'; ?>

  <header>
    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
      <h2 aria-label="Maison des Hôtes">
        <span class="material-icons" style="vertical-align: middle;">hotel</span> Maison des Hôtes
      </h2>
      <div class="marquee-img-container">
        <img src="R.jpeg" alt="Logo UNZ" class="marquee-img" />
        <span style="font-weight: 500; color: white;">UNZ</span>
      </div>
    </div>
  </header>

  <main class="container">
    <h1 class="marquee">Bienvenue à la Maison des Hôtes de l'Université Norbert Zongo</h1>

    <div class="content-container">
      <!-- Carrousel principal -->
      <div class="carousel-container" role="region" aria-label="Carrousel des chambres">
        <div class="carousel-slide" id="carousel-slide">
          <img src="logi.jpg" alt="Chambre moderne" />
          <img src="logo5.jpg" alt="Chambre standard" />
          <img src="logo4.jpg" alt="Chambre deluxe" />
          <img src="m5.jpg" alt="Chambre avec vue" />
          <img src="m7.jpg" alt="Chambre double" />
          <img src="unz.png" alt="Façade UNZ" />
          <img src="maison1.jpg" alt="Chambre simple" />
          <img src="m1.jpg" alt="Chambre premium" />
          <img src="m2.jpg" alt="Chambre exécutive" />
          <img src="m3.jpg" alt="Chambre familiale" />
          <img src="m4.jpg" alt="Chambre confort" />
          <img src="m5.jpg" alt="Chambre luxe" />
          <img src="op.png" alt="Chambre économique" />
        </div>
        <div class="carousel-buttons">
          <button class="carousel-btn" id="prev" aria-label="Image précédente">❮</button>
          <button class="carousel-btn" id="next" aria-label="Image suivante">❯</button>
        </div>
      </div>

      <!-- Deuxième carrousel -->
      <div class="carousel-container" role="region" aria-label="Carrousel des photos">
        <div class="carousel-slide" id="carousel-slide2">
          <img src="logo3.jpg" alt="Salle de réunion" />
          <img src="IMg_5886.jpg" alt="Restaurant" />
          <img src="lo.jpg" alt="Piscine" />
          <img src="IMg_5887.jpg" alt="Jardin" />
          <img src="IMg_5885.jpg" alt="Salle de conférence" />
          <img src="IMg_5882.jpg" alt="Espace détente" />
          <img src="IMg_5883.jpg" alt="Terrasse" />
          <img src="systeme.png" alt="Système de réservation" />
          <img src="ima.png" alt="Vue extérieure" />
        </div>
        <div class="carousel-buttons">
          <button class="carousel-btn" id="prev2" aria-label="Image précédente">❮</button>
          <button class="carousel-btn" id="next2" aria-label="Image suivante">❯</button>
        </div>
      </div>
    </div>

    <a href="chambres.php" class="btn-primary" id="btnChambres" role="button" aria-label="Voir les chambres disponibles">Voir les chambres disponibles</a>
  </main>

  <footer>
    <div class="video-header">
      <video autoplay muted loop aria-label="Vidéo de présentation">
        <source src="video.mp4" type="video/mp4" />
        Votre navigateur ne supporte pas la lecture vidéo.
      </video>
    </div>
    <nav>
      <a href="apropos.php" aria-label="À propos">À propos</a>
      <a href="contact.php" aria-label="Contact">Contact</a>
      <a href="terms.php" aria-label="Conditions d'utilisation">Conditions</a>
    </nav>
  </footer>

  <script>
    // Carrousel principal
    const carouselSlide = document.getElementById('carousel-slide');
    const images = carouselSlide.querySelectorAll('img');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    let counter = 0;

    function updateCarousel() {
      const size = carouselSlide.clientWidth;
      carouselSlide.style.transform = `translateX(${-counter * size}px)`;
    }

    nextBtn.addEventListener('click', () => {
      counter = (counter + 1) % images.length;
      updateCarousel();
    });

    prevBtn.addEventListener('click', () => {
      counter = (counter - 1 + images.length) % images.length;
      updateCarousel();
    });

    setInterval(() => {
      counter = (counter + 1) % images.length;
      updateCarousel();
    }, 5000);

    // Deuxième carrousel
    const carouselSlide2 = document.getElementById('carousel-slide2');
    const images2 = carouselSlide2.querySelectorAll('img');
    const prevBtn2 = document.getElementById('prev2');
    const nextBtn2 = document.getElementById('next2');
    let counter2 = 0;

    function updateCarousel2() {
      const size = carouselSlide2.clientWidth;
      carouselSlide2.style.transform = `translateX(${-counter2 * size}px)`;
    }

    nextBtn2.addEventListener('click', () => {
      counter2 = (counter2 + 1) % images2.length;
      updateCarousel2();
    });

    prevBtn2.addEventListener('click', () => {
      counter2 = (counter2 - 1 + images2.length) % images2.length;
      updateCarousel2();
    });

    setInterval(() => {
      counter2 = (counter2 + 1) % images2.length;
      updateCarousel2();
    }, 4000);

    window.addEventListener('resize', () => {
      updateCarousel();
      updateCarousel2();
    });

    // Hover bouton
    const btn = document.getElementById('btnChambres');
    btn.addEventListener('mouseenter', () => {
      btn.textContent = "Découvrir nos chambres !";
    });
    btn.addEventListener('mouseleave', () => {
      btn.textContent = "Voir les chambres disponibles";
    });
  </script>

  <?php include 'footer.php'; ?>
</body>
</html>