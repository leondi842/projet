<!-- Google Fonts & Material Icons -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  header {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(90deg,hsl(129, 96.50%, 44.30%), #1a7c34);
    padding: 15px 30px;
    color: #e3f2fd;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }

  .logo {
    font-size: 1.8rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #e3f2fd;
    transition: transform 0.3s ease;
  }

  .logo:hover {
    transform: scale(1.05);
  }

  nav {
    display: flex;
    gap: 20px;
    align-items: center;
  }

  nav a {
    color: #e3f2fd;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
  }

  nav a:hover {
    background-color: #bbdefb;
    color: #1a7c34;
    transform: scale(1.05);
  }

  .material-icons {
    font-size: 20px;
    color: #e3f2fd;
  }

  nav a:hover .material-icons {
    color: #1a7c34;
  }

  .burger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    padding: 5px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .burger div {
    width: 30px;
    height: 4px;
    background-color: #e3f2fd;
    margin: 5px 0;
    border-radius: 2px;
    transition: all 0.3s ease;
  }

  .burger.active div:nth-child(1) {
    transform: rotate(45deg) translate(7px, 7px);
  }

  .burger.active div:nth-child(2) {
    opacity: 0;
  }

  .burger.active div:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
  }

  @media screen and (max-width: 768px) {
    nav {
      display: none;
      flex-direction: column;
      background: linear-gradient(90deg, #1a7c34, #28a745);
      position: absolute;
      top: 70px;
      right: 20px;
      width: 250px;
      border-radius: 10px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
      padding: 15px;
      animation: slideDown 0.3s ease-in-out;
    }

    nav.active {
      display: flex;
    }

    .burger {
      display: flex;
    }

    .burger:hover {
      background-color: #bbdefb;
    }

    .burger:hover div {
      background-color: #1a7c34;
    }
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<header role="banner" aria-label="Barre de navigation Maison des Hôtes">
  <div class="logo" aria-label="Logo Maison des Hôtes">
    <span class="material-icons">home</span> Maison des Hôtes
  </div>
  <div class="burger" onclick="toggleMenu()" aria-label="Ouvrir le menu" role="button">
    <div></div>
    <div></div>
    <div></div>
  </div>
  <nav id="navbar-links" role="navigation">
    <a href="index.html" aria-label="Page d'accueil"><span class="material-icons">home</span>Accueil</a>
    <a href="chambres.php" aria-label="Nos chambres"><span class="material-icons">meeting_room</span>Nos chambres</a>
    <a href="faq.php" aria-label="Foire aux questions"><span class="material-icons">help_outline</span>FAQ</a>
    <a href="inscription_connexion.php" aria-label="Inscription"><span class="material-icons">person_add</span>S'inscrire</a>
    <a href="inscription_connexion.php?connexion" aria-label="Connexion"><span class="material-icons">login</span>Se connecter</a>
    
  </nav>
</header>

<script>
  function toggleMenu() {
    const nav = document.getElementById('navbar-links');
    const burger = document.querySelector('.burger');
    nav.classList.toggle('active');
    burger.classList.toggle('active');
  }
</script>