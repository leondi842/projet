<?php
$mysqli = new mysqli("localhost", "root", "", "maison_des_hotes");

// Vérification de la connexion à la base de données
if ($mysqli->connect_error) {
    die(": " . $mysqli->connect_error);
} else {
    echo ".<br>";
}

// MODIFICATION chambre
$modifMessage = "";
if (isset($_POST['modifier'])) {
    $numero_old = $mysqli->real_escape_string($_POST['numero_old']); // ancien numéro
    $numero = $mysqli->real_escape_string($_POST['numero']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $statut = $mysqli->real_escape_string($_POST['statut']);

    // Vérifier si nouveau numéro existe déjà (différent de l'ancien)
    $check = $mysqli->query("SELECT * FROM chambres WHERE numero = '$numero' AND numero != '$numero_old'");
    if ($check->num_rows > 0) {
        $modifMessage = "<div class='alert alert-warning'>⚠️ Ce numéro de chambre existe déjà !</div>";
    } else {
        $update = $mysqli->query("UPDATE chambres SET numero='$numero', description='$description', statut='$statut' WHERE numero='$numero_old'");
        if ($update) {
            $modifMessage = "<div class='alert alert-success'>✅ Chambre modifiée avec succès !</div>";
        } else {
            $modifMessage = "<div class='alert alert-danger'>❌ Erreur : " . $mysqli->error . "</div>";
        }
    }
}

// Récupération données chambre à modifier
$editData = null;
if (isset($_GET['edit'])) {
    $editNumero = $mysqli->real_escape_string($_GET['edit']);
    $resEdit = $mysqli->query("SELECT * FROM chambres WHERE numero = '$editNumero'");
    if ($resEdit && $resEdit->num_rows > 0) {
        $editData = $resEdit->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="R.jpeg" type="image/png" />
  <title>Espace Consultation Admin - Maison des Hôtes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }


body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('n.png'); /* ton image */
    background-size: cover;
    background-position: center;
    opacity: 0.1; /* ajustable pour la transparence */
    z-index: -1;
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
      padding: 4rem 2rem;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.98);
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      padding: 3rem;
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .container.visible {
      opacity: 1;
      transform: translateY(0);
    }

    h3 {
      font-size: 2.2rem;
      color: #0d47a1;
      font-weight: 700;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    h5 {
      font-size: 1.6rem;
      color: #28a745;
      font-weight: 600;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .nav-tabs {
      border-bottom: 2px solid #28a745;
    }

    .nav-tabs .nav-link {
      color: #333;
      font-weight: 500;
      border: none;
      border-radius: 10px 10px 0 0;
      padding: 1rem 1.5rem;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
      background-color: #e6f4ea;
      color: #28a745;
    }

    .nav-tabs .nav-link.active {
      background-color: #28a745;
      color: white;
      font-weight: 600;
    }

    .table {
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .table th {
      background: #0d47a1;
      color: white;
      font-weight: 600;
    }

    .table td {
      font-size: 1.1rem;
      vertical-align: middle;
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

    .btn-primary, .btn-success, .btn-warning, .btn-secondary {
      border-radius: 20px;
      font-weight: 600;
      padding: 0.6rem 1.2rem;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-primary {
      background: linear-gradient(90deg, #0d47a1, #1565c0);
      border: none;
    }

    .btn-primary:hover {
      background: linear-gradient(90deg, #1565c0, #0d47a1);
      transform: scale(1.05);
    }

    .btn-success {
      background: linear-gradient(90deg, #28a745, #1a7c34);
      border: none;
    }

    .btn-success:hover {
      background: linear-gradient(90deg, #1a7c34, #28a745);
      transform: scale(1.05);
    }

    .btn-warning {
      background: linear-gradient(90deg, #f0ad4e, #ec971f);
      border: none;
    }

    .btn-warning:hover {
      background: linear-gradient(90deg, #ec971f, #f0ad4e);
      transform: scale(1.05);
    }

    .btn-secondary {
      background: linear-gradient(90deg, #6c757d, #5a6268);
      border: none;
    }

    .btn-secondary:hover {
      background: linear-gradient(90deg, #5a6268, #6c757d);
      transform: scale(1.05);
    }

    .form-ajout {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .form-ajout.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .alert {
      border-radius: 8px;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    @media (max-width: 768px) {
      main {
        padding: 2rem 1rem;
      }
      .container {
        padding: 2rem;
      }
      h3 {
        font-size: 1.8rem;
      }
      h5 {
        font-size: 1.4rem;
      }
      .form-control, .table td {
        font-size: 1rem;
      }
      .btn-primary, .btn-success, .btn-warning, .btn-secondary {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'navbar1.php'; ?>

  <main role="main" aria-label="Espace Consultation Admin">
    <div class="container mt-4" id="consultationContainer">
      <h3><i class="fas fa-desktop me-2"></i> Espace Consultation Admin</h3>

      <ul class="nav nav-tabs" id="consultationTabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#clients" aria-label="Liste des clients"><i class="fas fa-users me-1"></i> Clients</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#chambres" aria-label="Liste des chambres"><i class="fas fa-bed me-1"></i> Chambres</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reservations" aria-label="Liste des réservations"><i class="fas fa-calendar-alt me-1"></i> Réservations</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#factures" aria-label="Liste des factures"><i class="fas fa-file-invoice me-1"></i> Factures</a></li>
      </ul>

      <div class="tab-content mt-3">
        <!-- Clients -->
        <div class="tab-pane fade show active" id="clients" role="tabpanel">
          <h5><i class="fas fa-users me-2"></i> Liste des clients</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Téléphone</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $res = $mysqli->query("SELECT nom, email, telephone FROM utilisateurs");
              if (!$res) {
                  echo "<tr><td colspan='3' class='text-danger'>❌ Erreur : " . htmlspecialchars($mysqli->error) . "</td></tr>";
              } else {
                  while ($row = $res->fetch_assoc()) {
                      echo "<tr>
                              <td>" . htmlspecialchars($row['nom']) . "</td>
                              <td>" . htmlspecialchars($row['email']) . "</td>
                              <td>" . htmlspecialchars($row['telephone']) . "</td>
                            </tr>";
                  }
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Chambres -->
        <div class="tab-pane fade" id="chambres" role="tabpanel">
          <h5><i class="fas fa-bed me-2"></i> Liste des chambres</h5>

          <!-- Affichage message modification -->
          <?php if ($modifMessage): ?>
            <div class="alert alert-info" role="alert">
              <i class="fas fa-info-circle me-2"></i> <?php echo htmlspecialchars($modifMessage); ?>
            </div>
          <?php endif; ?>

          <!-- Formulaire modification visible si édition -->
          <?php if ($editData): ?>
            <div class="mb-4">
              <h6><i class="fas fa-edit me-2"></i> Modifier la chambre #<?php echo htmlspecialchars($editData['numero']); ?></h6>
              <form method="post">
                <input type="hidden" name="numero_old" value="<?php echo htmlspecialchars($editData['numero']); ?>">
                <div class="form-group">
                  <label for="numero">Numéro :</label>
                  <input type="text" name="numero" id="numero" class="form-control" required value="<?php echo htmlspecialchars($editData['numero']); ?>" aria-label="Numéro de la chambre" />
                </div>
                <div class="form-group">
                  <label for="description">Description :</label>
                  <input type="text" name="description" id="description" class="form-control" required value="<?php echo htmlspecialchars($editData['description']); ?>" aria-label="Description de la chambre" />
                </div>
                <div class="form-group">
                  <label for="statut">Statut :</label>
                  <select name="statut" id="statut" class="form-control" required aria-label="Statut de la chambre">
                    <option value="Disponible" <?php if ($editData['statut'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
                    <option value="Occupée" <?php if ($editData['statut'] == 'Occupée') echo 'selected'; ?>>Occupée</option>
                    <option value="Réservée" <?php if ($editData['statut'] == 'Réservée') echo 'selected'; ?>>Réservée</option>
                  </select>
                </div>
                <button type="submit" name="modifier" class="btn btn-warning mt-2"><i class="fas fa-save me-1"></i> Enregistrer la modification</button>
                <a href="?tab=chambres" class="btn btn-secondary mt-2"><i class="fas fa-times me-1"></i> Annuler</a>
              </form>
            </div>
          <?php else: ?>

            <!-- Bouton pour afficher le formulaire ajout -->
            <button class="btn btn-primary mb-3" onclick="toggleFormAjout()" aria-label="Ajouter une chambre">
              <i class="fas fa-plus me-1"></i> Ajouter une chambre
            </button>

            <!-- Formulaire ajout caché par défaut -->
            <div id="form-ajout" class="form-ajout mb-4" style="display:none;">
              <form method="post">
                <div class="form-group">
                  <label for="numero_ajout">Numéro :</label>
                  <input type="text" name="numero" id="numero_ajout" class="form-control" required aria-label="Numéro de la chambre" />
                </div>
                <div class="form-group">
                  <label for="description_ajout">Description :</label>
                  <input type="text" name="description" id="description_ajout" class="form-control" required aria-label="Description de la chambre" />
                </div>
                <div class="form-group">
                  <label for="statut_ajout">Statut :</label>
                  <select name="statut" id="statut_ajout" class="form-control" required aria-label="Statut de la chambre">
                    <option value="Disponible">Disponible</option>
                    <option value="Occupée">Occupée</option>
                    <option value="Réservée">Réservée</option>
                  </select>
                </div>
                <button type="submit" name="ajouter" class="btn btn-success mt-2"><i class="fas fa-check me-1"></i> Enregistrer</button>
              </form>
            </div>

            <?php
            // Ajout chambre
            if (isset($_POST['ajouter'])) {
                $numero = $mysqli->real_escape_string($_POST['numero']);
                $description = $mysqli->real_escape_string($_POST['description']);
                $statut = $mysqli->real_escape_string($_POST['statut']);

                $check = $mysqli->query("SELECT * FROM chambres WHERE numero = '$numero'");
                if ($check->num_rows > 0) {
                    echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation-triangle me-2'></i> Ce numéro de chambre existe déjà !</div>";
                } else {
                    $insert = $mysqli->query("INSERT INTO chambres (numero, description, statut) VALUES ('$numero', '$description', '$statut')");
                    if ($insert) {
                        echo "<div class='alert alert-success' role='alert'><i class='fas fa-check-circle me-2'></i> Chambre ajoutée avec succès !</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'><i class='fas fa-times-circle me-2'></i> Erreur : " . htmlspecialchars($mysqli->error) . "</div>";
                    }
                }
            }
            ?>
          <?php endif; ?>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Numéro</th>
                <th scope="col">Description</th>
                <th scope="col">Statut</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $res = $mysqli->query("SELECT numero, description, statut FROM chambres");
              if (!$res) {
                  echo "<tr><td colspan='4' class='text-danger'>❌ Erreur : " . htmlspecialchars($mysqli->error) . "</td></tr>";
              } else {
                  while ($row = $res->fetch_assoc()) {
                      echo "<tr>
                              <td>" . htmlspecialchars($row['numero']) . "</td>
                              <td>" . htmlspecialchars($row['description']) . "</td>
                              <td>" . htmlspecialchars($row['statut']) . "</td>
                              <td>
                                <a href='?edit=" . urlencode($row['numero']) . "&tab=chambres#chambres' class='btn btn-sm btn-warning'><i class='fas fa-edit me-1'></i> Modifier</a>
                              </td>
                            </tr>";
                  }
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Réservations -->
        <div class="tab-pane fade" id="reservations" role="tabpanel">
          <h5><i class="fas fa-calendar-alt me-2"></i> Liste des réservations</h5>

          <!-- Formulaire de recherche -->
          <form method="GET" class="mb-3">
            <div class="row g-2">
              <div class="col-md-3">
                <input type="text" name="search_numero" class="form-control" placeholder="Numéro de chambre" 
                       value="<?php echo isset($_GET['search_numero']) ? htmlspecialchars($_GET['search_numero']) : ''; ?>" aria-label="Numéro de chambre" />
              </div>
              <div class="col-md-3">
                <input type="text" name="search_nom" class="form-control" placeholder="Nom du client"
                       value="<?php echo isset($_GET['search_nom']) ? htmlspecialchars($_GET['search_nom']) : ''; ?>" aria-label="Nom du client" />
              </div>
              <div class="col-md-3">
                <input type="date" name="search_date" class="form-control"
                       value="<?php echo isset($_GET['search_date']) ? htmlspecialchars($_GET['search_date']) : ''; ?>" aria-label="Date de réservation" />
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Rechercher</button>
              </div>
            </div>
          </form>

          <!-- Tableau des résultats -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Client</th>
                <th scope="col">Chambre</th>
                <th scope="col">Début</th>
                <th scope="col">Fin</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $conditions = [];
              if (!empty($_GET['search_numero'])) {
                  $numero = $mysqli->real_escape_string($_GET['search_numero']);
                  $conditions[] = "r.numero_chambre LIKE '%$numero%'";
              }
              if (!empty($_GET['search_nom'])) {
                  $nom = $mysqli->real_escape_string($_GET['search_nom']);
                  $conditions[] = "(u.nom LIKE '%$nom%' OR u.prenom LIKE '%$nom%')";
              }
              if (!empty($_GET['search_date'])) {
                  $date = $mysqli->real_escape_string($_GET['search_date']);
                  $conditions[] = "'$date' BETWEEN r.date_debut AND r.date_fin";
              }

              $whereClause = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";

              $res = $mysqli->query("SELECT u.nom, u.prenom, r.numero_chambre, r.date_debut, r.date_fin 
                                     FROM reservations r 
                                     JOIN utilisateurs u ON r.utilisateur_id = u.id
                                     $whereClause");

              if (!$res) {
                  echo "<tr><td colspan='4' class='text-danger'>❌ Erreur : " . htmlspecialchars($mysqli->error) . "</td></tr>";
              } elseif ($res->num_rows === 0) {
                  echo "<tr><td colspan='4'>Aucune réservation trouvée.</td></tr>";
              } else {
                  while ($row = $res->fetch_assoc()) {
                      $client = htmlspecialchars($row['prenom'] . ' ' . $row['nom']);
                      echo "<tr>
                              <td>$client</td>
                              <td>" . htmlspecialchars($row['numero_chambre']) . "</td>
                              <td>" . htmlspecialchars($row['date_debut']) . "</td>
                              <td>" . htmlspecialchars($row['date_fin']) . "</td>
                            </tr>";
                  }
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Factures -->
        <div class="tab-pane fade" id="factures" role="tabpanel">
          <h5><i class="fas fa-file-invoice me-2"></i> Liste des factures</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Client</th>
                <th scope="col">Montant</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $res = $mysqli->query("SELECT u.nom, f.montant, f.date_facture 
                                     FROM factures f 
                                     JOIN utilisateurs u ON f.utilisateur_id = u.id");
              if (!$res) {
                  echo "<tr><td colspan='3' class='text-danger'>❌ Erreur : " . htmlspecialchars($mysqli->error) . "</td></tr>";
              } else {
                  while ($row = $res->fetch_assoc()) {
                      echo "<tr>
                              <td>" . htmlspecialchars($row['nom']) . "</td>
                              <td>" . htmlspecialchars($row['montant']) . "</td>
                              <td>" . htmlspecialchars($row['date_facture']) . "</td>
                            </tr>";
                  }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Animation d’apparition du conteneur
    window.addEventListener('load', () => {
      document.getElementById('consultationContainer').classList.add('visible');
    });

    // Gestion de l’onglet actif
    document.addEventListener('DOMContentLoaded', () => {
      const hash = window.location.hash;
      if (hash) {
        const tab = new bootstrap.Tab(document.querySelector(`.nav-link[href="${hash}"]`));
        tab.show();
      }

      document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('shown.bs.tab', e => {
          window.location.hash = e.target.getAttribute('href');
        });
      });
    });

    // Afficher/masquer le formulaire d’ajout avec animation
    function toggleFormAjout() {
      const form = document.getElementById('form-ajout');
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
      if (form.style.display === 'block') {
        setTimeout(() => form.classList.add('visible'), 10);
      } else {
        form.classList.remove('visible');
      }
    }
  </script>

  <?php include 'footer.php'; ?>
</body>
</html>