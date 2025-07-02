<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['user_role'] === 'admin' ? 'admin_dashboard.php' : 'accueil.php'));
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$message = "";
$show_connexion = isset($_GET['connexion']) ? true : false;

function clean_input($data) {
    return htmlspecialchars(trim($data));
}

// INSCRIPTION
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'inscription') {
    $nom = clean_input($_POST['nom'] ?? '');
    $prenom = clean_input($_POST['prenom'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $telephone = clean_input($_POST['telephone'] ?? '');
    $cnib = clean_input($_POST['cnib'] ?? '');
    $matricule = clean_input($_POST['matricule'] ?? '');
    $mdp_raw = $_POST['mot_de_passe'] ?? '';

    if (!$nom || !$prenom || !$email || !$telephone || !$cnib || !$matricule || !$mdp_raw) {
        $message = "<div class='alert alert-danger'>Tous les champs sont obligatoires.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Email invalide.</div>";
    } else {
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "<div class='alert alert-danger'>Email déjà utilisé !</div>";
        } else {
            $mdp = password_hash($mdp_raw, PASSWORD_DEFAULT);
            $role = ($email === 'adminunz@gmail.com') ? 'admin' : 'user';

            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, role, cnib, matricule) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $nom, $prenom, $email, $mdp, $telephone, $role, $cnib, $matricule);

            if ($stmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?connexion=1&inscription=ok");
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Erreur lors de l'inscription : " . $conn->error . "</div>";
            }
        }
        $stmt->close();
    }
    $show_connexion = true;
}

// CONNEXION
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'connexion') {
    $email = clean_input($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';

    if (!$email || !$mdp) {
        $message = "<div class='alert alert-danger'>Email et mot de passe sont requis.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Email invalide.</div>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($mdp, $user['mot_de_passe'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                header("Location: " . ($user['role'] === 'admin' ? 'admin_dashboard.php' : 'accueil.php'));
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Mot de passe incorrect.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Email non trouvé.</div>";
        }
        $stmt->close();
    }
    $show_connexion = true;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="R.jpeg" type="image/png" />
  <title>Connexion / Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    html, body { height: 100%; }
    body {
      display: flex;
      flex-direction: column;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    main { flex: 1; }
    .form-card {
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      background: white;
      padding: 2rem 2.5rem;
      margin-top: 1.5rem;
      transition: transform 0.3s ease;
    }
    .form-card:hover { transform: translateY(-5px); }
    h2 { font-weight: 700; color: #000DFF; margin-bottom: 1.5rem; }
    .toggle-link {
      cursor: pointer;
      font-weight: 600;
      color: #6B73FF;
      text-decoration: underline;
    }
    .btn-primary { background-color: #000DFF; border: none; }
    .btn-primary:hover { background-color: #4e59ff; }
    .btn-success { background-color: #6B73FF; border: none; }
    .btn-success:hover { background-color: #424ef5; }
    label { font-weight: 600; color: #222; }
    .form-label.required::after { content: "*"; color: red; margin-left: 0.25em; }
    .form-logo { max-width: 150px; }
    .right-image {
      max-width: 100%;
      border-radius: 1rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .welcome-message {
      text-align: center;
      font-weight: 600;
      font-size: 1.2rem;
      color: #222;
      background-color: rgba(255, 255, 255, 0.85);
      padding: 1rem 1.5rem;
      border-radius: 0.8rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
      .right-image { display: none; }
    }
  </style>
</head>
<body>

<?php include 'navbar2.php'; ?>

<main class="container py-5">
  <div class="row justify-content-center align-items-start g-4">
    <div class="col-md-6 col-lg-5">
      <div class="welcome-message">Bienvenue ! Prêt à réserver votre chambre ?<br>Créez votre compte ou connectez-vous pour commencer.</div>
      <div class="mb-4 text-center"><img src="R.jpeg" alt="Logo" class="form-logo" /></div>

      <!-- Connexion -->
      <form id="form-connexion" method="POST" class="form-card" style="<?= $show_connexion ? '' : 'display:none;' ?>" novalidate>
        <h2 class="text-center">Connexion</h2>
        <?php if ($message && $show_connexion): echo $message; endif; ?>
        <input type="hidden" name="action" value="connexion" />
        <div class="mb-3"><label class="form-label required">Email</label><input type="email" name="email" class="form-control" required /></div>
        <div class="mb-3"><label class="form-label required">Mot de passe</label><input type="password" name="mot_de_passe" class="form-control" required /></div>
        <div class="d-flex justify-content-end mb-3"><a href="forgot_password.php" class="text-danger fw-bold text-decoration-none">Mot de passe oublié ?</a></div>
        <button type="submit" class="btn btn-primary w-100 py-2">Se connecter</button>
        <div class="text-center mt-3"><span class="toggle-link" onclick="toggleForm(false)">Pas encore inscrit ? Inscris-toi ici</span></div>
      </form>

      <!-- Inscription -->
      <form id="form-inscription" method="POST" class="form-card" style="<?= $show_connexion ? 'display:none;' : '' ?>" novalidate>
        <h2 class="text-center">Inscription</h2>
        <?php if ($message && !$show_connexion): echo $message; endif; ?>
        <input type="hidden" name="action" value="inscription" />
        <div class="mb-3"><label class="form-label required">Nom</label><input type="text" name="nom" class="form-control" required /></div>
        <div class="mb-3"><label class="form-label required">Prénom</label><input type="text" name="prenom" class="form-control" required /></div>
        <div class="mb-3"><label class="form-label required">Email</label><input type="email" name="email" class="form-control" required /></div>
        <div class="mb-3"><label class="form-label required">Téléphone</label><input type="text" name="telephone" class="form-control" required /></div>
        <div class="mb-3"><label class="form-label required">CNIB</label><input type="text" name="cnib" class="form-control" required /></div>
        <div class="mb-3"><label class="form-label required">Matricule</label><input type="text" name="matricule" class="form-control" required /></div>
        <div class="mb-3"><label class="form-label required">Mot de passe</label><input type="password" name="mot_de_passe" class="form-control" required /></div>
        <button type="submit" class="btn btn-success w-100 py-2">S'inscrire</button>
        <div class="text-center mt-3"><span class="toggle-link" onclick="toggleForm(true)">Déjà inscrit ? Connecte-toi ici</span></div>
      </form>
    </div>

    <!-- Image à droite -->
    <div class="col-md-6 d-none d-md-block text-center">
      <img src="presi.jpg" alt="Illustration" class="right-image" />
    </div>
  </div>
</main>

<script>
  function toggleForm(showConnexion) {
    document.getElementById('form-connexion').style.display = showConnexion ? 'block' : 'none';
    document.getElementById('form-inscription').style.display = showConnexion ? 'none' : 'block';
  }

  window.onload = function () {
    toggleForm(<?= $show_connexion ? 'true' : 'false' ?>);
  };
</script>

<?php include 'footer.php'; ?>
</body>
</html>
