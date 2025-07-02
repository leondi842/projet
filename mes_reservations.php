<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$utilisateur_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison_des_hotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Compter total réservations
$count_sql = "SELECT COUNT(*) as total FROM reservations WHERE utilisateur_id = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $utilisateur_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Récupérer les réservations paginées
$sql = "SELECT r.id, r.numero_chambre, r.date_debut, r.date_fin, r.date_reservation, r.statut, c.description 
        FROM reservations r 
        JOIN chambres c ON r.numero_chambre = c.numero 
        WHERE r.utilisateur_id = ? 
        ORDER BY r.date_reservation DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $utilisateur_id, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="R.jpeg" type="image/png" />
    <title>Mes réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style1.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container my-5">
    <div class="mui-card">
        <h2 class="mui-title">Mes réservations</h2>

        <?php if ($result->num_rows == 0): ?>
            <p class="alert alert-info">Tu n'as aucune réservation pour le moment.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-hover" id="reservationsTable">
                    <thead class="text-center">
                        <tr>
                            <th>Numéro chambre</th>
                            <th>Description</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Date réservation</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($res = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($res['numero_chambre']) ?></td>
                                <td><?= htmlspecialchars($res['description']) ?></td>
                                <td><?= htmlspecialchars($res['date_debut']) ?></td>
                                <td><?= htmlspecialchars($res['date_fin']) ?></td>
                                <td><?= htmlspecialchars($res['date_reservation']) ?></td>
                                <td class="text-center statut-cell">
                                    <?php if ($res['statut'] === 'confirmée'): ?>
                                        <span class="badge bg-success px-3 py-2">Confirmée</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark px-3 py-2">En attente</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="modifier_reservation.php?id=<?= $res['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <button class="btn btn-danger btn-sm btn-annuler" data-id="<?= $res['id'] ?>">Annuler</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
              <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= $page - 1 ?>">Précédent</a>
                </li>
                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);
                for ($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                      <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant</a>
                </li>
              </ul>
            </nav>
        <?php endif; ?>

        <a href="recherche_dispo.php" class="btn btn-mui btn-mui-primary mt-4">Nouvelle réservation</a>
    </div>
</div>

<!-- Modal confirmation annulation -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="confirmModalLabel">Confirmer l'annulation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Es-tu sûr de vouloir annuler cette réservation ? Cette action est irréversible.
      </div>
      <div class="modal-footer border-0">
        <form id="annulerForm" method="POST" action="" class="m-0">
            <input type="hidden" name="id" id="reservationIdToCancel" value="" />
            <button type="submit" class="btn btn-danger">Confirmer l'annulation</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="toastAnnulation" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">Réservation annulée avec succès !</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const annulerForm = document.getElementById('annulerForm');
    const reservationIdInput = document.getElementById('reservationIdToCancel');

    document.querySelectorAll('.btn-annuler').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            reservationIdInput.value = id;
            annulerForm.action = `annuler_reservation.php?id=${id}`;
            confirmModal.show();
        });
    });

    <?php if (isset($_GET['annule']) && $_GET['annule'] == 'success'): ?>
    const toastEl = document.getElementById('toastAnnulation');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
    <?php endif; ?>
</script>

<?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>

