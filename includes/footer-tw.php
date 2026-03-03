<?php
/**
 * footer-tw.php — Tailwind Footer (Phase 5)
 * Replaces legacy Bootstrap footer.php
 */
?>
<style>
/* ── Footer Variables & Base ─────────────────────────── */
.ft-root {
  background: var(--shop-bg-alt);
  border-top: 1px solid var(--shop-border);
  font-family: 'Inter', system-ui, sans-serif;
  color: var(--shop-text-secondary);
  margin-top: auto;
}

/* ── Main grid ───────────────────────────────────────── */
.ft-grid {
  max-width: 1400px;
  margin: 0 auto;
  padding: 3rem 1.5rem 2rem;
  display: grid;
  grid-template-columns: 1.4fr 1fr 1fr 1fr;
  gap: 2.5rem;
}
@media (max-width: 1023px) { .ft-grid { grid-template-columns: 1fr 1fr; gap: 2rem; } }
@media (max-width: 600px)  { .ft-grid { grid-template-columns: 1fr; gap: 1.5rem; } }

/* ── Column headings ─────────────────────────────────── */
.ft-heading {
  font-size: 0.8125rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--shop-text-primary);
  margin: 0 0 1rem;
}

/* ── Logo column ─────────────────────────────────────── */
.ft-logo   { display: block; margin-bottom: 1rem; }
.ft-logo img { max-height: 44px; width: auto; }
.ft-desc   { font-size: 0.8125rem; line-height: 1.6; margin-bottom: 1.25rem; }

/* ── Social icons ────────────────────────────────────── */
.ft-social { display: flex; gap: 0.625rem; flex-wrap: wrap; }
.ft-social a {
  display: flex; align-items: center; justify-content: center;
  width: 36px; height: 36px;
  border-radius: 0.625rem;
  border: 1px solid var(--shop-border);
  background: var(--shop-surface);
  transition: border-color 150ms ease, transform 150ms ease, box-shadow 150ms ease;
  overflow: hidden;
}
.ft-social a:hover {
  border-color: var(--shop-primary);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px color-mix(in srgb, var(--shop-primary) 20%, transparent);
}
.ft-social img { width: 22px; height: 22px; object-fit: contain; }

/* ── Nav links ───────────────────────────────────────── */
.ft-links   { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; }
.ft-links a {
  font-size: 0.875rem;
  color: var(--shop-text-secondary);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  transition: color 150ms ease, padding-left 150ms ease;
}
.ft-links a::before {
  content: '';
  display: inline-block;
  width: 5px; height: 5px;
  border-radius: 50%;
  background: var(--shop-primary);
  opacity: 0;
  flex-shrink: 0;
  transition: opacity 150ms ease;
}
.ft-links a:hover { color: var(--shop-primary); padding-left: 4px; }
.ft-links a:hover::before { opacity: 1; }

/* ── Contact items ───────────────────────────────────── */
.ft-contact { display: flex; flex-direction: column; gap: 0.75rem; }
.ft-contact-item {
  display: flex; align-items: center; gap: 0.625rem;
  font-size: 0.875rem;
  color: var(--shop-text-secondary);
  text-decoration: none;
  transition: color 150ms ease;
}
.ft-contact-item:hover { color: var(--shop-primary); text-decoration: none; }
.ft-contact-icon {
  width: 34px; height: 34px;
  display: flex; align-items: center; justify-content: center;
  background: color-mix(in srgb, var(--shop-primary) 10%, transparent);
  color: var(--shop-primary);
  border-radius: 0.5rem;
  flex-shrink: 0;
}

/* ── Bottom bar ──────────────────────────────────────── */
.ft-bottom {
  border-top: 1px solid var(--shop-border);
  max-width: 1400px;
  margin: 0 auto;
  padding: 1.25rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 0.75rem;
}
.ft-copyright {
  font-size: 0.8rem;
  color: var(--shop-text-disabled);
}
.ft-copyright a {
  color: var(--shop-primary);
  font-weight: 600;
  text-decoration: none;
}
.ft-copyright a:hover { text-decoration: underline; }
.ft-payment img {
  max-height: 28px;
  opacity: 0.75;
  filter: grayscale(20%);
  transition: opacity 200ms ease;
}
.ft-payment img:hover { opacity: 1; }

/* ── Scroll-to-top ───────────────────────────────────── */
#scrollUP {
  position: fixed;
  bottom: 5rem;
  right: 1.5rem;
  width: 44px; height: 44px;
  background: var(--shop-primary);
  color: white;
  border-radius: 0.875rem;
  display: none; /* jQuery handles fadeIn display: block */
  box-shadow: 0 4px 20px color-mix(in srgb, var(--shop-primary) 40%, transparent);
  text-decoration: none;
  z-index: 8000;
  border: none;
  cursor: pointer;
  transition: transform 200ms ease, box-shadow 200ms ease, background 200ms ease;
}
#scrollUP:hover {
  background: var(--shop-primary-hover);
  transform: translateY(-3px);
  box-shadow: 0 8px 24px color-mix(in srgb, var(--shop-primary) 45%, transparent);
}
#scrollUP svg {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>

<footer class="ft-root">

  <!-- Main grid -->
  <div class="ft-grid">

    <!-- Col 1: Logo + Social -->
    <div>
      <a href="<?php echo lienAccueil(); ?>" class="ft-logo">
        <img src="media/site/<?php echo $logo; ?>" alt="<?php echo htmlspecialchars($nom_site ?? 'Shop'); ?>">
      </a>
      <p class="ft-desc">
        <?php echo htmlspecialchars($description_site ?? "Votre expert en téléphonie et High-tech."); ?>
      </p>
      <div class="ft-social">
        <?php
          $req_sn = "SELECT * FROM `social_network` WHERE `etat` = '1' ORDER BY `ordre`";
          $res_sn = executeRequete($req_sn);
          while ($sn = mysqli_fetch_array($res_sn)):
        ?>
          <a href="<?php echo lienSocialNetwork($sn['id']); ?>" target="_blank" rel="noopener" title="Réseau social">
            <img src="<?php echo photoSocialNetworkSite($sn['id']); ?>" alt="">
          </a>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- Col 2: Informations -->
    <div>
      <h3 class="ft-heading">Informations</h3>
      <ul class="ft-links">
        <li><a href="<?php echo lienContenu(2); ?>">À propos de nous</a></li>
        <li><a href="<?php echo lienContenu(3); ?>">Liste des chaînes</a></li>
        <li><a href="<?php echo lienContenu(8); ?>">Aide</a></li>
        <li><a href="<?php echo lienContact(); ?>">Contactez-nous</a></li>
      </ul>
    </div>

    <!-- Col 3: Boutique (top categories from DB) -->
    <div>
      <h3 class="ft-heading">Boutique</h3>
      <ul class="ft-links">
        <?php
          $req_ft = "SELECT * FROM `categories_blog` WHERE `etat` = '1' AND `idparent` = '0' AND `titre` NOT LIKE '%Promo%' AND `titre` NOT LIKE '%IPTV%' ORDER BY `ordre` LIMIT 5";
          $res_ft = executeRequete($req_ft);
          while ($cat_ft = mysqli_fetch_array($res_ft)):
        ?>
          <li><a href="<?php echo lienCategories($cat_ft['link']); ?>"><?php echo htmlspecialchars($cat_ft['titre']); ?></a></li>
        <?php endwhile; ?>
      </ul>
    </div>

    <!-- Col 4: Service clients -->
    <div>
      <h3 class="ft-heading">Service clients</h3>
      <div class="ft-contact">
        <?php if (!empty($gsm)): ?>
          <a href="tel:<?php echo $gsm; ?>" class="ft-contact-item">
            <span class="ft-contact-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.76 16z"/></svg>
            </span>
            <?php echo htmlspecialchars($gsm); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($email_contact)): ?>
          <a href="mailto:<?php echo $email_contact; ?>" class="ft-contact-item">
            <span class="ft-contact-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </span>
            <?php echo htmlspecialchars($email_contact); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($adresse)): ?>
          <span class="ft-contact-item">
            <span class="ft-contact-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </span>
            <?php echo htmlspecialchars($adresse); ?>
          </span>
        <?php endif; ?>
      </div>
    </div>

  </div><!-- /.ft-grid -->

  <!-- Bottom bar -->
  <div class="ft-bottom">
    <p class="ft-copyright">
      <?php echo $copyright ?? ''; ?>
      — Développé par <a href="https://maxsolving.com" target="_blank" rel="noopener">maxsolving</a>
    </p>
    <div class="ft-payment">
      <img src="dist/img/payment-card.png" alt="Méthodes de paiement acceptées">
    </div>
  </div>

</footer>

<!-- Scroll to top button -->
<button id="scrollUP" title="Retour en haut" aria-label="Retour en haut">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
</button>
