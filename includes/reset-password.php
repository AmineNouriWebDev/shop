<?php if($valid_token): ?>
<div class="cx-card">
    <!-- Left: Promo -->
    <div class="cx-promo">
        <img src="media/site/<?php echo $logo; ?>" alt="" class="cx-promo-logo">
        <h2>Nouveau mot de passe</h2>
        <p>Veuillez choisir un nouveau mot de passe sécurisé pour votre compte.</p>
        <div class="mt-4">
            <i class="fas fa-lock fa-3x opacity-20"></i>
        </div>
    </div>

    <!-- Right: Form -->
    <div class="cx-form-panel text-left">
        <h1>Nouveau mot de passe</h1>
        <p class="cx-subtitle text-secondary">Saisissez votre nouveau mot de passe ci-dessous.</p>

        <?php if($erreur != ""): ?>
            <div class="cx-error">
                <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $erreur; ?>
            </div>
        <?php endif; ?>

        <form action="reset-password.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="reset">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email_q); ?>">
            
            <label class="cx-label" for="cx-pass">Nouveau mot de passe</label>
            <input class="cx-input" type="password" name="password" id="cx-pass" placeholder="••••••••" required>

            <label class="cx-label" for="cx-confirm">Confirmez le mot de passe</label>
            <input class="cx-input" type="password" name="confirm_password" id="cx-confirm" placeholder="••••••••" required>

            <?php if (!empty($cloudflare_site_key)): ?>
                <div class="cf-turnstile mb-3" data-sitekey="<?php echo $cloudflare_site_key; ?>"></div>
            <?php endif; ?>

            <button type="submit" class="cx-btn shadow-lg">
                <i class="fas fa-save mr-2"></i> Valider la modification
            </button>
        </form>

    </div>
</div>
<?php else: ?>
<div class="cx-card" style="grid-template-columns: 1fr;">
    <div class="cx-form-panel text-left" style="text-align: center; align-items: center;">
      <h1 style="text-align: center;">Lien invalide ou expiré</h1>
      <p class="cx-subtitle text-secondary" style="text-align: center;"><?php echo $erreur; ?></p>
      <div style="margin-top: 1rem;">
          <a href="<?php echo lienforget(); ?>" class="cx-btn shadow-lg" style="color: white; text-decoration: none;">
              Demander un nouveau lien
          </a>
      </div>
    </div>
</div>
<?php endif; ?>