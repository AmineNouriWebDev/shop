<?php
/* ── Auto-create table if not exists ── */
executeRequete("CREATE TABLE IF NOT EXISTS `couleurs` (
    `id`     INT(11) NOT NULL AUTO_INCREMENT,
    `nom`    VARCHAR(100) NOT NULL,
    `code`   VARCHAR(20)  NOT NULL DEFAULT '#000000',
    `ordre`  INT(11)      NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

/* ── Delete ── */
if(isset($_GET['supprimer']) && $_GET['supprimer'] != ''){
    executeRequete("DELETE FROM `couleurs` WHERE `id`='".(int)$_GET['supprimer']."'");
    phpToastRedirect('Couleur supprimée.', 'index.php?r=couleurs', 'success');
}

$res = executeRequete("SELECT * FROM `couleurs` ORDER BY `ordre`, `nom`");
?>
<div class="row">
  <div class="col-12">
    <div class="admin-card">
      <div class="admin-card-header d-flex align-items-center justify-content-between">
        <div class="admin-card-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem;height:1.5rem;color:var(--color-primary);">
            <circle cx="12" cy="12" r="10" fill="none" stroke-width="1.5"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12a5 5 0 0 1 10 0"/>
          </svg>
          Couleurs disponibles
        </div>
        <a href="index.php?r=ncouleur" class="admin-btn admin-btn-primary">+ Ajouter une couleur</a>
      </div>
      <div class="admin-card-body">
        <table class="admin-table w-100">
          <thead>
            <tr>
              <th style="width:60px;">Aperçu</th>
              <th>Nom</th>
              <th>Code</th>
              <th style="width:120px;">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while($c = mysqli_fetch_assoc($res)): ?>
            <tr>
              <td>
                <span style="display:inline-block;width:32px;height:32px;border-radius:50%;background:<?php echo htmlspecialchars($c['code']); ?>;border:2px solid #e5e7eb;vertical-align:middle;"></span>
              </td>
              <td><?php echo htmlspecialchars($c['nom']); ?></td>
              <td><code><?php echo htmlspecialchars($c['code']); ?></code></td>
              <td>
                <a href="index.php?r=mcouleur&id=<?php echo $c['id']; ?>" class="admin-btn admin-btn-ghost" style="font-size:0.75rem;padding:0.25rem 0.6rem;">Modifier</a>
                <a href="javascript:void(0);" class="admin-btn admin-btn-danger" style="font-size:0.75rem;padding:0.25rem 0.6rem;" onclick="confirmGlobalDelete('index.php?r=couleurs&supprimer=<?php echo $c['id']; ?>')">Supprimer</a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
