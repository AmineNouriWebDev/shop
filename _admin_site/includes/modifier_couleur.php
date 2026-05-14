<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$data = null;
if($id > 0){
    $res = executeRequete("SELECT * FROM `couleurs` WHERE `id`='$id'");
    $data = mysqli_fetch_assoc($res);
}
if(!$data){ phpToastRedirect('Couleur introuvable.','index.php?r=couleurs','error'); exit; }

if(isset($_POST['action']) && $_POST['action'] == 'mod'){
    $nom   = formReception($_POST['nom']);
    $code  = formReception($_POST['code']);
    $ordre = (int)($_POST['ordre'] ?? 0);
    executeRequete("UPDATE `couleurs` SET `nom`='$nom',`code`='$code',`code_hexa`='$code',`ordre`='$ordre' WHERE `id`='$id'");
    phpToastRedirect('Couleur modifiée avec succès.', 'index.php?r=couleurs', 'success');
}
?>
<div class="row">
  <div class="col-12">
    <div class="admin-card">
      <div class="admin-card-header">
        <div class="admin-card-title">Modifier la couleur : <?php echo htmlspecialchars($data['nom']); ?></div>
      </div>
      <div class="admin-card-body">
        <form method="POST">
          <input type="hidden" name="action" value="mod">
          <div class="form-group mb-3">
            <label class="fw-semibold">Nom de la couleur <span class="text-danger">*</span></label>
            <input type="text" name="nom" class="admin-input" value="<?php echo htmlspecialchars($data['nom']); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label class="fw-semibold">Code couleur (hexadécimal) <span class="text-danger">*</span></label>
            <div class="d-flex align-items-center gap-2">
              <input type="color" id="colorPicker" value="<?php echo htmlspecialchars($data['code']); ?>" style="width:48px;height:42px;padding:2px;border:1.5px solid #e5e7eb;border-radius:0.5rem;cursor:pointer;">
              <input type="text" name="code" id="colorText" value="<?php echo htmlspecialchars($data['code']); ?>" class="admin-input" placeholder="#RRGGBB" style="max-width:160px;" oninput="document.getElementById('colorPicker').value=this.value">
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="fw-semibold">Ordre d'affichage</label>
            <input type="number" name="ordre" class="admin-input" value="<?php echo (int)$data['ordre']; ?>" min="0" style="max-width:120px;">
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
            <a href="index.php?r=couleurs" class="admin-btn admin-btn-ghost">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
document.getElementById('colorPicker').addEventListener('input', function(){
    document.getElementById('colorText').value = this.value;
});
</script>
