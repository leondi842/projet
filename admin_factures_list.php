<?php
// admin/admin_factures_list.php
include '../config.php';
include 'admin_header.php';
?>

<div class="container py-5">
  <h2 class="text-center mb-4">📄 Liste des Factures</h2>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Période</th>
            <th>Montant</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            // On récupère toutes les réservations avec leur ID, dates et montant
            $stmt = $conn->query("SELECT id, date_debut, date_fin, montant FROM reservations ORDER BY date_debut DESC");
            while ($r = $stmt->fetch(PDO::FETCH_ASSOC)): 
          ?>
            <tr>
              <td><?= htmlspecialchars($r['id']) ?></td>
              <td>
                <span class="badge bg-info text-dark">
                  <?= htmlspecialchars($r['date_debut']) ?>
                </span>
                →
                <span class="badge bg-info text-dark">
                  <?= htmlspecialchars($r['date_fin']) ?>
                </span>
              </td>
              <td>
                <span class="fw-bold">
                  <?= number_format($r['montant'], 0, '', ' ') ?> FCFA
                </span>
              </td>
              <td class="text-center">
                <a 
                  href="admin_factures.php?id=<?= urlencode($r['id']) ?>" 
                  class="btn btn-sm btn-primary"
                  target="_blank"
                >
                  <i class="bi bi-printer-fill"></i> Imprimer
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="text-center mt-4">
    <a href="admin_dashboard.php" class="btn btn-secondary">
      ← Retour au tableau de bord
    </a>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
