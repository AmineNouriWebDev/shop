<?php
/* ── Auto-create table ── */
executeRequete("CREATE TABLE IF NOT EXISTS `couleurs` (
    `id`     INT(11) NOT NULL AUTO_INCREMENT,
    `nom`    VARCHAR(100) NOT NULL,
    `code`   VARCHAR(20)  NOT NULL DEFAULT '#000000',
    `ordre`  INT(11)      NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

if(isset($_POST['action']) && $_POST['action'] == 'ajt'){
    $nom   = formReception($_POST['nom']);
    $code  = formReception($_POST['code']);
    $ordre = (int)($_POST['ordre'] ?? 0);
    executeRequete("INSERT INTO `couleurs` (`nom`,`code`,`code_hexa`,`ordre`) VALUES ('$nom','$code','$code','$ordre')");
    phpToastRedirect('Couleur ajoutée avec succès.', 'index.php?r=couleurs', 'success');
}
?>
<div class="row">
  <div class="col-12">
    <div class="admin-card">
      <div class="admin-card-header">
        <div class="admin-card-title">Ajouter une couleur</div>
      </div>
      <div class="admin-card-body">
        <form method="POST">
          <input type="hidden" name="action" value="ajt">
          <div class="form-group mb-3">
            <label class="fw-semibold">Nom de la couleur <span class="text-danger">*</span></label>
            <input type="text" name="nom" class="admin-input" placeholder="ex: Rouge, Bleu Nuit..." required>
          </div>
          <div class="form-group mb-3">
            <label class="fw-semibold">Code couleur (hexadécimal) <span class="text-danger">*</span></label>
            <div class="d-flex align-items-center gap-2">
              <input type="color" name="code" id="colorPicker" value="#000000" style="width:48px;height:42px;padding:2px;border:1.5px solid #e5e7eb;border-radius:0.5rem;cursor:pointer;">
              <input type="text" id="colorText" name="code_display" value="#000000" class="admin-input" placeholder="#RRGGBB" style="max-width:160px;" oninput="document.getElementById('colorPicker').value=this.value">
            </div>
            <small class="text-muted">Cliquez sur l'icône pour ouvrir le sélecteur de couleur.</small>
          </div>
          <div class="form-group mb-3">
            <label class="fw-semibold">Ordre d'affichage</label>
            <input type="number" name="ordre" class="admin-input" value="0" min="0" style="max-width:120px;">
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
document.querySelector('form').addEventListener('submit', function(){
    // Sync the text field value to the hidden code field before submit
    var txt = document.getElementById('colorText').value.trim();
    var picker = document.getElementById('colorPicker');
    // We use the text input as the real value, copy it to the picker name
    var inputs = this.querySelectorAll('input[name="code_display"]');
    inputs.forEach(function(i){ i.name = 'code'; });
    var pickerInputs = this.querySelectorAll('input[type="color"]');
    pickerInputs.forEach(function(i){ i.disabled = true; });
});
</script>
