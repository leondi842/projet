<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sidebar toggle with icons</title>

  <!-- Font Awesome CDN -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background: #1976d2;
      color: white;
      padding: 20px;
      box-sizing: border-box;
      transition: transform 0.3s ease;
      transform: translateX(0);
      z-index: 1000;
    }

    .sidebar.closed {
      transform: translateX(-100%);
    }

    .toggle-btn {
      position: fixed;
      top: 20px;
      left: 20px;
      background: #1976d2;
      border: none;
      color: white;
      padding: 10px 15px;
      cursor: pointer;
      font-size: 18px;
      border-radius: 4px;
      z-index: 1100;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    .content.expanded {
      margin-left: 0;
    }

    nav a {
      display: block;
      color: white;
      text-decoration: none;
      margin-bottom: 15px;
      font-size: 16px;
    }

    nav a:hover {
      text-decoration: underline;
    }

    nav a i {
      margin-right: 10px;
      width: 18px;
      text-align: center;
    }

    /* Barre blanche horizontale */
    .separator {
      border: none;
      height: 1px;
      background-color: white;
      margin: 15px 0;
      opacity: 0.6;
    }

    .sidebar img {
      width: 80px;
      display: block;
      margin: 0 auto 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body>

  <div class="sidebar closed" id="sidebar">
    <img src="R.jpeg" alt="Logo Université Norbert ZONGO" />
    <h2>Maison Hôtes</h2>
    <hr class="separator" />
    <nav>
      <a href="admin_dashboard.php"><i class="fas fa-home"></i> Accueil</a>
      <a href="admin_reservations.php"><i class="fas fa-calendar-check"></i> Réservations</a>
      <a href="admin_factures.php"><i class="fas fa-file-invoice"></i> Factures</a>
      <a href="admin_clients.php"><i class="fas fa-users"></i> Utilisateurs</a>
      <a href="admin_consultation.php"><i class="fas fa-eye"></i> Consultés</a>
      <a href="admin_messages.php"><i class="fas fa-bell"></i> Notifications</a>
      <a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </nav>
  </div>

  <button class="toggle-btn" id="toggleBtn" aria-label="Ouvrir / Fermer menu">☰ Menu</button>

  <div class="content expanded" id="content">
    <h1>Bienvenue dans le tableau de bord</h1>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleBtn');
    const content = document.getElementById('content');

    function openSidebar() {
      sidebar.classList.remove('closed');
      content.classList.remove('expanded');
    }

    function closeSidebar() {
      sidebar.classList.add('closed');
      content.classList.add('expanded');
    }

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (sidebar.classList.contains('closed')) {
        openSidebar();
      } else {
        closeSidebar();
      }
    });

    // Fermer sidebar au clic sur lien
    sidebar.querySelectorAll('nav a').forEach(link => {
      link.addEventListener('click', () => {
        closeSidebar();
      });
    });

    // Fermer si clic hors sidebar
    document.addEventListener('click', (e) => {
      if (!sidebar.classList.contains('closed') &&
          !sidebar.contains(e.target) &&
          !toggleBtn.contains(e.target)) {
        closeSidebar();
      }
    });

    // Empêcher la fermeture si clic à l'intérieur
    sidebar.addEventListener('click', e => {
      e.stopPropagation();
    });
  </script>

</body>
</html>
