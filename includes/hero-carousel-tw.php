<?php
/**
 * ============================================================
 * SHOP — Hero Carousel 2026 (Tailwind — remplace header.php)
 * ============================================================
 * Remplace le Bootstrap carousel de header.php.
 * Données alimentées depuis la table `sliders` via l'admin.
 * Fonctions utilisées : photoSliderSite(), lienSlider()
 * Usage : <?php include('includes/hero-carousel-tw.php'); ?>
 * ============================================================
 */

// Fetch sliders from DB
$slider_items = [];
$req_sliders  = "SELECT * FROM `sliders` WHERE `etat` = '1' ORDER BY `ordre`";
$res_sliders  = executeRequete($req_sliders);
while ($sl = mysqli_fetch_array($res_sliders)) {
    $slider_items[] = $sl;
}
$slider_count = count($slider_items);
?>

<?php if ($slider_count > 0): ?>
<!-- ═══════════════════════════════════════════════════════
     HERO CAROUSEL — Futuristic 2026
     ═══════════════════════════════════════════════════════ -->
<style>
  /* ── Carousel wrapper ── */
  .sh-hero {
    position: relative;
    overflow: hidden;
    background: var(--shop-bg-alt-dark, #0D0B1A);
    /* Force dark bg so slides always look good */
  }
  html.dark .sh-hero { background: #0D0B1A; }

  /* ── Slides track ── */
  .sh-hero-track {
    display: flex;
    transition: transform 650ms cubic-bezier(0.77, 0, 0.175, 1);
    will-change: transform;
  }

  /* ── Single slide ── */
  .sh-hero-slide {
    min-width: 100%;
    position: relative;
    overflow: hidden;
  }
  .sh-hero-slide img {
    width: 100%;
    height: clamp(320px, 52vw, 640px);
    object-fit: cover;
    object-position: center;
    display: block;
    transition: transform 8000ms ease;
  }
  .sh-hero-slide.is-active img {
    transform: scale(1.04);
  }

  /* ── Gradient overlay ── */
  .sh-hero-overlay {
    position: absolute;
    inset: 0;
    pointer-events: none;
    /* Left-to-right gradient for text contrast */
    background:
      linear-gradient(to right, rgba(13,11,26,0.65) 0%, rgba(13,11,26,0.15) 55%, transparent 100%),
      linear-gradient(to top, rgba(13,11,26,0.5) 0%, transparent 40%);
  }

  /* ── Slide content (optional title/badge from admin) ── */
  .sh-slide-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: clamp(1.5rem, 4vw, 3rem) clamp(1.5rem, 6vw, 5rem);
    z-index: 3;
  }

  /* ── Navigation arrows ── */
  .sh-hero-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 250ms ease;
  }
  .sh-hero-btn:hover {
    background: var(--shop-primary, #5A31F4);
    border-color: var(--shop-primary, #5A31F4);
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 0 20px rgba(90, 49, 244, 0.5);
  }
  .sh-hero-btn-prev { left: 1.25rem; }
  .sh-hero-btn-next { right: 1.25rem; }

  @media (min-width: 768px) {
    .sh-hero-btn { width: 54px; height: 54px; }
    .sh-hero-btn-prev { left: 2rem; }
    .sh-hero-btn-next { right: 2rem; }
  }

  /* ── Dots navigation ── */
  .sh-hero-dots {
    position: absolute;
    bottom: 1.25rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }
  .sh-hero-dot {
    width: 8px;
    height: 8px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.4);
    cursor: pointer;
    transition: all 300ms ease;
    border: none;
    padding: 0;
  }
  .sh-hero-dot.is-active {
    width: 28px;
    background: white;
    box-shadow: 0 0 8px rgba(90, 49, 244, 0.6);
  }

  /* ── Progress bar ── */
  .sh-hero-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: var(--shop-primary, #5A31F4);
    z-index: 10;
    transform-origin: left;
    animation: sh-progress 4000ms linear;
  }
  @keyframes sh-progress {
    from { width: 0%; }
    to   { width: 100%; }
  }

  /* ── Futuristic corner decorators ── */
  .sh-hero-corner {
    position: absolute;
    z-index: 4;
    width: 40px;
    height: 40px;
    opacity: 0.6;
  }
  .sh-hero-corner-tl { top: 16px; left: 16px; border-top: 2px solid var(--shop-primary); border-left: 2px solid var(--shop-primary); }
  .sh-hero-corner-tr { top: 16px; right: 16px; border-top: 2px solid var(--shop-primary); border-right: 2px solid var(--shop-primary); }
  .sh-hero-corner-bl { bottom: 16px; left: 16px; border-bottom: 2px solid var(--shop-primary); border-left: 2px solid var(--shop-primary); }
  .sh-hero-corner-br { bottom: 16px; right: 16px; border-bottom: 2px solid var(--shop-primary); border-right: 2px solid var(--shop-primary); }

  /* ── Slide counter ── */
  .sh-slide-counter {
    position: absolute;
    top: 1.25rem;
    right: 1.5rem;
    z-index: 10;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: rgba(255,255,255,0.7);
    font-family: 'Inter', monospace;
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
  }
  .sh-slide-counter .current {
    font-size: 1.125rem;
    color: white;
  }
</style>

<div class="sh-hero" id="sh-hero" role="region" aria-label="Diaporama principal">

  <!-- Corner decorators -->
  <div class="sh-hero-corner sh-hero-corner-tl"></div>
  <div class="sh-hero-corner sh-hero-corner-tr"></div>
  <div class="sh-hero-corner sh-hero-corner-bl"></div>
  <div class="sh-hero-corner sh-hero-corner-br"></div>

  <!-- Slide counter -->
  <div class="sh-slide-counter" aria-live="polite">
    <span class="current" id="sh-cur">1</span>
    <span>/</span>
    <span><?php echo $slider_count; ?></span>
  </div>

  <!-- Slides -->
  <div class="sh-hero-track" id="sh-track">
    <?php foreach ($slider_items as $i => $sl): ?>
      <div class="sh-hero-slide <?php echo ($i === 0 ? 'is-active' : ''); ?>" data-index="<?php echo $i; ?>">
        <a href="<?php echo lienSlider($sl['id']); ?>" tabindex="-1">
          <img
            src="<?php echo photoSliderSite($sl['id']); ?>"
            alt="<?php echo htmlspecialchars($sl['titre'] ?? 'Slide '.($i+1)); ?>"
            <?php echo ($i === 0 ? 'loading="eager"' : 'loading="lazy"'); ?>
          >
        </a>
        <div class="sh-hero-overlay"></div>
        <!-- Slide link overlay for entire slide to be clickable -->
        <a href="<?php echo lienSlider($sl['id']); ?>" class="sh-hero-slide-link" aria-label="Voir la promotion <?php echo $i+1; ?>"
           style="position:absolute; inset:0; z-index:2;"></a>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Prev / Next -->
  <?php if ($slider_count > 1): ?>
    <button class="sh-hero-btn sh-hero-btn-prev" id="sh-prev" aria-label="Slide précédent">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button class="sh-hero-btn sh-hero-btn-next" id="sh-next" aria-label="Slide suivant">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
  <?php endif; ?>

  <!-- Dots -->
  <?php if ($slider_count > 1): ?>
    <div class="sh-hero-dots" role="tablist" aria-label="Navigation des slides">
      <?php for ($d = 0; $d < $slider_count; $d++): ?>
        <button
          class="sh-hero-dot <?php echo ($d === 0 ? 'is-active' : ''); ?>"
          data-dot="<?php echo $d; ?>"
          role="tab"
          aria-selected="<?php echo ($d === 0 ? 'true' : 'false'); ?>"
          aria-label="Slide <?php echo $d + 1; ?>"
        ></button>
      <?php endfor; ?>
    </div>
  <?php endif; ?>

  <!-- Progress bar -->
  <div class="sh-hero-progress" id="sh-progress"></div>

</div>

<!-- ── Hero Carousel JavaScript ── -->
<script>
(function() {
  var TOTAL    = <?php echo $slider_count; ?>;
  var DELAY    = 4000;
  var current  = 0;
  var timer    = null;
  var isRunning= true;

  var track    = document.getElementById('sh-track');
  var prevBtn  = document.getElementById('sh-prev');
  var nextBtn  = document.getElementById('sh-next');
  var counter  = document.getElementById('sh-cur');
  var progress = document.getElementById('sh-progress');
  var dots     = document.querySelectorAll('.sh-hero-dot');
  var slides   = document.querySelectorAll('.sh-hero-slide');

  function goTo(idx) {
    // Clamp
    idx = ((idx % TOTAL) + TOTAL) % TOTAL;

    // Update slide classes
    slides[current].classList.remove('is-active');
    slides[idx].classList.add('is-active');

    // Move track
    track.style.transform = 'translateX(-' + (idx * 100) + '%)';

    // Update dots
    dots.forEach(function(d, i) {
      d.classList.toggle('is-active', i === idx);
      d.setAttribute('aria-selected', i === idx ? 'true' : 'false');
    });

    // Update counter
    if (counter) counter.textContent = idx + 1;

    // Reset progress bar
    if (progress) {
      progress.style.animation = 'none';
      progress.offsetHeight; // reflow
      progress.style.animation = 'sh-progress ' + DELAY + 'ms linear';
    }

    current = idx;
  }

  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  function startAuto() {
    if (TOTAL <= 1) return;
    clearInterval(timer);
    timer = setInterval(next, DELAY);
    isRunning = true;
  }

  function pauseAuto() {
    clearInterval(timer);
    isRunning = false;
  }

  // Bind buttons
  if (prevBtn) prevBtn.addEventListener('click', function() { prev(); startAuto(); });
  if (nextBtn) nextBtn.addEventListener('click', function() { next(); startAuto(); });

  // Bind dots
  dots.forEach(function(dot) {
    dot.addEventListener('click', function() {
      goTo(parseInt(this.getAttribute('data-dot')));
      startAuto();
    });
  });

  // Pause on hover
  var hero = document.getElementById('sh-hero');
  if (hero) {
    hero.addEventListener('mouseenter', pauseAuto);
    hero.addEventListener('mouseleave', startAuto);
  }

  // Touch/swipe support
  var touchStartX = 0;
  if (hero) {
    hero.addEventListener('touchstart', function(e) {
      touchStartX = e.touches[0].clientX;
    }, { passive: true });
    hero.addEventListener('touchend', function(e) {
      var diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) {
        if (diff > 0) next(); else prev();
        startAuto();
      }
    }, { passive: true });
  }

  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft')  { prev(); startAuto(); }
    if (e.key === 'ArrowRight') { next(); startAuto(); }
  });

  // Init auto
  if (TOTAL > 1) {
    startAuto();
    // Start progress animation on first slide
    if (progress) {
      progress.style.animation = 'sh-progress ' + DELAY + 'ms linear';
    }
  }

  // Pause when tab is hidden
  document.addEventListener('visibilitychange', function() {
    if (document.hidden) pauseAuto(); else if (TOTAL > 1) startAuto();
  });
})();
</script>

<?php else: ?>
<!-- No sliders configured -->
<div style="height: 4rem;"></div>
<?php endif; ?>
