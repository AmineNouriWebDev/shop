

		<div class="cx-card">
    <!-- Left: Promo -->
    <div class="cx-promo">
        <img src="media/site/<?php echo $logo; ?>" alt="" class="cx-promo-logo">
        <h2>Mot de passe oublié ?</h2>
        <p>Pas de panique ! Saisissez votre e-mail pour recevoir vos identifiants.</p>
        <div class="mt-4">
            <i class="fas fa-key fa-3x opacity-20"></i>
        </div>
    </div>

    <!-- Right: Form -->
    <div class="cx-form-panel text-left">
        <h1>Récupération</h1>
        <p class="cx-subtitle text-secondary">Un e-mail de réinitialisation vous sera envoyé.</p>

        <?php if($erreur != ""): ?>
            <div class="cx-error">
                <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $erreur; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo lienforget();?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="forget">
            
            <label class="cx-label" for="cx-email">Adresse e-mail</label>
            <input class="cx-input" type="email" name="login" id="cx-email" placeholder="votre@email.com" required autocomplete="email">

            <?php if (!empty($cloudflare_site_key)): ?>
                <div class="cf-turnstile mb-3" data-sitekey="<?php echo $cloudflare_site_key; ?>"></div>
            <?php endif; ?>

            <button type="submit" class="cx-btn shadow-lg">
                <i class="fas fa-paper-plane mr-2"></i> Envoyer 
            </button>
        </form>

        <div class="cx-footer-links">
            <a href="<?php echo lienConnexion(); ?>">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
            </a>
        </div>
    </div>
</div>