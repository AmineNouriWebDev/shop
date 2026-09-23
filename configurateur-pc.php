<?php
include("include.php");

$titre = "Configurateur PC";
$title_page = "Configurateur PC sur mesure – Assemblez votre PC en ligne | " . (isset($nom_site) ? $nom_site : 'Offipro');
$description_page = "Composez votre PC sur mesure étape par étape. Choisissez votre processeur, votre carte mère, votre RAM, votre stockage et bien plus encore.";

// Base URL pour les liens produits
$base_url = rtrim($chemin_absolu, '/') . '/';
?>
<!DOCTYPE html>
<html lang="fr" class="">
<head>
	<?php include('includes/script-header.php');?>
    <style>
      *, *::before, *::after{box-sizing:border-box;}
      body{margin:0;font-family:'Inter',system-ui,sans-serif;background:var(--shop-bg-base);color:var(--shop-text-primary);min-height:100vh;display:flex;flex-direction:column;}

      .cx-wrap { flex:1; padding: 2rem 1rem; width: 100%; max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; }

      /* Kit selection cards */
      #conf-kits-view { width: 100%; text-align: center; }
      #conf-kits-container {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
          gap: 1rem;
          width: 100%;
          max-width: 800px;
          margin: 0 auto;
      }
      @media (max-width: 640px) { #conf-kits-container { grid-template-columns: 1fr; } }
      .kit-card {
          cursor: pointer; border: 2px solid var(--shop-border); border-radius: 1rem;
          padding: 1.1rem 1.25rem; text-align: left; transition: all 220ms ease;
          background: var(--shop-surface); display: flex; flex-direction: row;
          align-items: center; gap: 1rem; min-height: 80px;
      }
      @media (min-width: 641px) {
          .kit-card { flex-direction: column; text-align: center; align-items: center; min-height: 160px; padding: 1.5rem 1rem; }
      }
      .kit-card:hover { border-color: var(--shop-primary); background: color-mix(in srgb, var(--shop-primary) 4%, var(--shop-surface)); transform: translateY(-2px); box-shadow: 0 10px 22px rgba(0,0,0,0.07); }
      .kit-icon { width: 56px; height: 56px; flex-shrink: 0; border-radius: 50%; background: color-mix(in srgb, var(--shop-primary) 10%, transparent); display: flex; align-items: center; justify-content: center; color: var(--shop-primary); font-size: 1.5rem; }
      @media (min-width: 641px) { .kit-icon { margin-bottom: 0.5rem; } }
      .kit-icon img { max-width: 32px; max-height: 32px; object-fit: contain; }
      .kit-text { flex: 1; min-width: 0; text-align: left; }
      @media (min-width: 641px) { .kit-text { text-align: center; } }
      .kit-title { font-size: 0.95rem; font-weight: 700; line-height: 1.3; color: var(--shop-text-primary); margin: 0 0 0.2rem; }
      .kit-desc { font-size: 0.75rem; color: var(--shop-text-secondary); line-height: 1.35; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

      /* Main App Layout */
      #conf-app { width: 100%; display: none; }
      .layout-row { display: flex; flex-direction: column; gap: 1.5rem; width: 100%; }
      @media (min-width: 768px) { .layout-row { flex-direction: row; align-items: flex-start; justify-content: center; } }
      .flex-col-force { display: flex; flex-direction: column !important; }

      /* Timeline */
      .steps-indicator { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem; width: 100%; }
      .step-dot { display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 600; color: var(--shop-text-secondary); opacity: 0.5; transition: all 300ms ease; }
      .step-dot.active { opacity: 1; color: var(--shop-primary); }
      .step-dot.completed { opacity: 1; color: #10b981; }
      .step-dot-circle { width: 24px; height: 24px; border-radius: 50%; background: var(--shop-bg-alt); display: flex; align-items: center; justify-content: center; border: 1px solid var(--shop-border); font-size: 0.7rem; }
      .step-dot.active .step-dot-circle { background: var(--shop-primary); color: white; border-color: var(--shop-primary); }
      .step-dot.completed .step-dot-circle { background: #10b981; color: white; border-color: #10b981; }
      .step-separator { height: 1px; width: 20px; background: var(--shop-border); }

      /* Product List Item */
      .conf-list-item { border-bottom: 1px solid var(--shop-border); padding: 0.65rem 0; transition: background 200ms ease; width: 100%; }
      .conf-list-item:last-child { border-bottom: none; }
      .conf-list-item.selected { background: color-mix(in srgb, var(--shop-primary) 4%, transparent); border-radius: 0.5rem; padding-left: 0.4rem; padding-right: 0.4rem; }
      @media (min-width: 641px) {
          .conf-list-item { display: flex; align-items: center; gap: 1rem; justify-content: space-between; }
          .cli-row1 { display: flex; align-items: center; gap: 1rem; flex: 1; min-width: 0; }
          .cli-name { flex: 1; min-width: 0; }
          .cli-actions { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
      }
      @media (max-width: 640px) {
          .conf-list-item { display: flex; flex-direction: column; gap: 0; padding: 0.75rem 0; }
          .cli-row1 { display: flex; align-items: center; gap: 0.6rem; width: 100%; }
          .cli-name { flex: 1; min-width: 0; }
          .cli-actions { display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; margin-top: 0.5rem; padding-left: calc(48px + 0.6rem); }
          #conf-app .cx-btn { font-size: 0.82rem; padding: 0.38rem 0.9rem; }
      }
      .conf-list-img-wrap { height: 48px; width: 48px; flex-shrink: 0; background: white; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; padding: 0.25rem; border: 1px solid var(--shop-border); }
      .conf-list-img-wrap img { max-height: 100%; max-width: 100%; object-fit: contain; }
      .price-block { background: var(--shop-bg-alt); color: var(--shop-primary); font-weight: 700; padding: 0.3rem 0.5rem; border-radius: 0.5rem; white-space: nowrap; font-size: 0.82rem; border: 1px solid var(--shop-border); flex-shrink: 0; }

      /* Spec badges */
      .spec-badge { display: inline-block; background: var(--shop-bg-alt); color: var(--shop-text-secondary); border: 1px solid var(--shop-border); border-radius: 4px; font-size: 0.68rem; padding: 1px 5px; margin: 1px 2px 0 0; white-space: nowrap; }

      /* Buttons */
      .cx-btn { display: inline-flex; justify-content: center; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: var(--shop-primary); color: white; border: none; border-radius: 0.6rem; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 200ms ease; white-space: nowrap; }
      .cx-btn:hover:not(:disabled) { background: var(--shop-primary-hover); transform: translateY(-1px); box-shadow: 0 4px 15px color-mix(in srgb, var(--shop-primary) 30%, transparent); color: white; }
      .cx-btn:disabled { opacity: 0.5; cursor: not-allowed; }
      .cx-btn.selected-btn { background: #ef4444; }
      .cx-btn.selected-btn:hover:not(:disabled) { background: #dc2626; }
      .cx-btn-outline { display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.6rem 1.2rem; background: transparent; color: var(--shop-text-primary); border: 1.5px solid var(--shop-border); border-radius: 0.75rem; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 200ms ease; }
      .cx-btn-outline:hover { border-color: var(--shop-text-primary); background: var(--shop-bg-alt); }
      .conf-qty-btn { width: 28px; height: 28px; border-radius: 0.4rem; border: none; background: var(--shop-primary); color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 150ms ease; font-size: 1rem; flex-shrink: 0; }
      .conf-qty-btn:hover { background: var(--shop-primary-hover); }
      .conf-qty-val { font-size: 0.88rem; font-weight: 700; min-width: 24px; text-align: center; }
      .product-title { font-size: 0.84rem; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: var(--shop-text-primary); font-weight: 600; }
      .step-container { display: none; animation: fadeIn 300ms ease; }
      .step-container.active { display: block; }
      @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

      .summary-item { border-left: 3px solid var(--shop-border); padding-left: 1rem; margin-bottom: 1rem; }
      .summary-item.filled { border-left-color: var(--shop-primary); }
      .summary-item.missing { border-left-color: #ef4444; }
      .summary-item-title { font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--shop-text-secondary); margin-bottom: 0.25rem; }

      /* Installation Fee Card */
      .conf-frais-card { display: flex; align-items: center; gap: 1.25rem; padding: 1.25rem; background: white; border: 2px solid var(--shop-border); border-radius: 1rem; cursor: pointer; transition: all 250ms ease; margin: 1rem auto; width: 100%; max-width: 500px; }
      .conf-frais-card:hover { border-color: var(--shop-primary); background: color-mix(in srgb, var(--shop-primary) 2%, white); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
      .conf-frais-card.selected { border-color: var(--shop-primary); background: color-mix(in srgb, var(--shop-primary) 5%, white); }
      .conf-frais-icon { width: 54px; height: 54px; border-radius: 12px; background: color-mix(in srgb, var(--shop-primary) 10%, transparent); display: flex; align-items: center; justify-content: center; color: var(--shop-primary); font-size: 1.5rem; flex-shrink: 0; }
      .conf-frais-body { flex: 1; min-width: 0; }
      .conf-frais-label { font-weight: 700; font-size: 1rem; color: var(--shop-text-primary); margin-bottom: 0.15rem; }
      .conf-frais-amount { font-weight: 600; color: var(--shop-primary); font-size: 0.95rem; }
      .conf-frais-card.selected .cx-btn { background: #ef4444; }

      /* PC Hero Banner */
      .pc-hero { width: 100%; background: linear-gradient(135deg, color-mix(in srgb, var(--shop-primary) 8%, var(--shop-bg-base)), var(--shop-bg-base)); border: 1px solid var(--shop-border); border-radius: 1.25rem; padding: 2rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }
      .pc-hero-icon { width: 64px; height: 64px; border-radius: 16px; background: var(--shop-primary); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.8rem; flex-shrink: 0; }
      .pc-hero-text h1 { margin: 0 0 0.3rem; font-size: clamp(1.1rem, 4vw, 1.5rem); font-weight: 800; }
      .pc-hero-text p { margin: 0; font-size: 0.85rem; color: var(--shop-text-secondary); }
    </style>
</head>
<body>
	<?php include('includes/feedback.php');?>
	<?php include('includes/header-tw.php');?>

    <main class="cx-wrap">

        <!-- Hero Banner PC -->
        <div class="pc-hero">
            <div class="pc-hero-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </div>
            <div class="pc-hero-text">
                <h1>Configurateur PC sur mesure</h1>
                <p>Assemblez votre PC composant par composant, étape par étape. Compatibilité vérifiée automatiquement.</p>
            </div>
        </div>

        <!-- 1. SELECTION DU KIT -->
        <div id="conf-kits-view" style="margin-bottom: 4rem; width:100%;">
            <p class="text-gray-500 text-sm mb-6" style="margin-top:0;">Choisissez le type de configuration souhaitée.</p>
            <div id="conf-kits-container"></div>
        </div>

        <!-- 2. WIZARD -->
        <div id="conf-app">
            <div id="conf-steps-indicator" class="steps-indicator"></div>

            <div style="display: flex; justify-content: center; margin-bottom: 2rem;">
                <button class="text-xs text-gray-500 hover:text-[var(--shop-primary)] flex items-center gap-1 font-medium bg-gray-100 px-3 py-1.5 rounded-full transition-colors" onclick="window.location.reload()" style="display: flex; align-items: center; gap: 0.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Recommencer
                </button>
            </div>

            <div class="layout-row">
                <!-- GAUCHE : Composants -->
                <div class="flex-1 w-full max-w-3xl">
                    <div id="conf-steps-content" class="rounded-xl p-4 md:p-6 shadow-sm mb-6" style="background: var(--shop-surface); border: 1px solid var(--shop-border);"></div>

                    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-top: 1.5rem;">
                        <button id="btn-prev" class="cx-btn-outline" style="display:none; align-items: center; gap: 0.5rem;" onclick="window.confPrevStep()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            Retour
                        </button>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-left: auto;">
                            <button id="btn-skip" class="text-gray-500 hover:text-gray-800 font-medium px-4 py-2 underline text-sm" onclick="window.confNextStep()">Ignorer cette étape</button>
                            <button id="btn-next" class="cx-btn" style="display: flex; align-items: center; gap: 0.5rem;" onclick="window.confNextStep()">
                                Suivant
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- DROITE : Résumé -->
                <div class="w-full shrink-0 sticky top-[100px]" style="max-width: 360px;">
                    <div class="rounded-xl p-5 shadow-sm flex-col-force" style="background: var(--shop-surface); border: 1px solid var(--shop-border);">
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2 shrink-0 pb-3" style="border-bottom: 1px solid var(--shop-border);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            Ma configuration PC
                        </h3>
                        <div id="conf-summary-items" class="flex-1 w-full max-h-[50vh] overflow-y-auto pr-2" style="scrollbar-width: thin;"></div>
                        <div id="conf-warnings" class="shrink-0 mt-4 text-sm font-medium w-full"></div>
                        <div class="shrink-0 pt-4 mt-4 w-full" style="border-top: 1px solid var(--shop-border);">
                            <div class="text-lg font-bold mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Total estimé</span>
                                <span id="conf-total-price" class="text-xl" style="color: var(--shop-primary); margin-left: 1rem;">0.000 TND</span>
                            </div>
                            <div id="conf-force-checkout-wrapper" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="checkbox" id="conf-force-checkbox" class="mt-1 w-4 h-4 text-[var(--shop-primary)] rounded focus:ring-[var(--shop-primary)]">
                                    <span class="text-xs text-red-800 leading-tight">Je confirme ma configuration incomplète et souhaite continuer.</span>
                                </label>
                            </div>
                            <button id="conf-add-to-cart" class="w-full cx-btn" style="display:none;" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loader -->
        <div id="conf-loader" class="flex flex-col items-center justify-center py-32">
            <i class="fa fa-spinner fa-spin fa-3x text-[var(--shop-primary)] mb-4"></i>
            <p class="text-gray-500 font-medium" id="conf-loader-text">Chargement...</p>
        </div>

    </main>

    <?php include('includes/footer-tw.php');?>
 	<?php include('includes/script-footer.php');?>

    <script>
        const BASE_URL = '<?php echo $base_url; ?>';
        const PC_SPEC_KEYS = ['socket', 'chipset', 'format', 'ddr', 'frequence', 'capacite', 'interface', 'puissance', 'connecteur', 'vitesse', 'type'];

        document.addEventListener('DOMContentLoaded', function() {
            const state = { kitId: null, steps: [], currentIndex: 0, selectedItems: {}, selectedFrais: {} };

            const DOM = {
                loader: document.getElementById('conf-loader'),
                loaderText: document.getElementById('conf-loader-text'),
                kitsView: document.getElementById('conf-kits-view'),
                kitsContainer: document.getElementById('conf-kits-container'),
                app: document.getElementById('conf-app'),
                stepsIndicator: document.getElementById('conf-steps-indicator'),
                stepsContent: document.getElementById('conf-steps-content'),
                summaryItems: document.getElementById('conf-summary-items'),
                totalPrice: document.getElementById('conf-total-price'),
                addToCartBtn: document.getElementById('conf-add-to-cart'),
                warnings: document.getElementById('conf-warnings'),
                btnPrev: document.getElementById('btn-prev'),
                btnNext: document.getElementById('btn-next'),
                btnSkip: document.getElementById('btn-skip'),
                forceWrapper: document.getElementById('conf-force-checkout-wrapper'),
                forceCheckbox: document.getElementById('conf-force-checkbox')
            };

            function nettoyerTitre(t) { return t.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"').replace(/&#039;/g, "'"); }

            function getSpecBadges(carac) {
                let badges = '';
                for (const [key, val] of Object.entries(carac)) {
                    const kl = key.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                    if (PC_SPEC_KEYS.some(sk => kl.includes(sk))) {
                        badges += `<span class="spec-badge">${val}</span>`;
                    }
                }
                return badges;
            }

            // Load kits
            fetch('ajax_configurateur.php?action=get_kits')
                .then(r => r.json())
                .then(data => {
                    if (data.status !== 'success') { DOM.loader.innerHTML = '<p class="text-red-500">Erreur de chargement.</p>'; return; }

                    let kits = data.kits;
                    const pcKit = kits.find(k => k.titre === '__PC_BUILDER__');

                    if (!pcKit) {
                        DOM.loader.innerHTML = '<p class="text-gray-500 text-center py-8">Le configurateur PC n\'est pas encore configuré. Rendez-vous dans l\'administration pour ajouter des étapes.</p>';
                        return;
                    }

                    // On sélectionne directement le kit PC (qui masque les kits caméra de fait)
                    DOM.kitsView.style.display = 'none';
                    window.confSelectKit(pcKit.id);

                    const pcIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>`;

                    DOM.kitsContainer.innerHTML = display.map(kit => {
                        let iconHtml = kit.photo && kit.photo.trim()
                            ? (kit.photo.includes('fa-') || kit.photo.startsWith('fa ') ? `<i class="${kit.photo}" style="font-size:1.6rem;"></i>` : `<img src="media/products/${kit.photo}" alt="${kit.titre}">`)
                            : pcIcon;
                        return `<div class="kit-card" onclick="window.confSelectKit(${kit.id})">
                            <div class="kit-icon">${iconHtml}</div>
                            <div class="kit-text">
                                <div class="kit-title">${nettoyerTitre(kit.titre)}</div>
                                ${kit.description ? `<p class="kit-desc">${nettoyerTitre(kit.description)}</p>` : ''}
                            </div>
                        </div>`;
                    }).join('');

                    DOM.loader.style.display = 'none';
                    DOM.kitsView.style.display = 'block';
                })
                .catch(() => { DOM.loader.innerHTML = '<p class="text-red-500">Erreur réseau.</p>'; });

            window.confSelectKit = function(id) {
                state.kitId = id;
                DOM.kitsView.style.display = 'none';
                DOM.loader.style.display = 'flex';
                DOM.loaderText.innerText = 'Chargement des composants...';

                fetch('ajax_configurateur.php?action=get_steps&kit_id=' + id)
                    .then(r => r.json())
                    .then(data => {
                        if (data.status === 'success' && data.steps.length > 0) {
                            state.steps = data.steps;
                            buildApp();
                            DOM.loader.style.display = 'none';
                            DOM.app.style.display = 'block';
                            updateView();
                        } else {
                            DOM.loader.innerHTML = '<p class="text-red-500">Ce kit ne contient aucune étape. Configurez les étapes dans l\'administration.</p>';
                        }
                    });
            };

            function buildApp() {
                DOM.stepsContent.innerHTML = state.steps.map((step, index) => {
                    let productsHtml = '';

                    if (step.role === 'frais_installation') {
                        const m = step.montant_fixe || 0;
                        productsHtml = `<div id="frais-card-${step.id}" class="conf-frais-card" onclick="window.confToggleFrais(${step.id}, ${m})">
                            <div class="conf-frais-icon"><i class="fa fa-wrench"></i></div>
                            <div class="conf-frais-body">
                                <div class="conf-frais-label">${step.titre}</div>
                                <div class="conf-frais-amount">${m.toFixed(3)} DT TTC</div>
                            </div>
                            <div class="conf-frais-action" id="frais-action-${step.id}"><button class="cx-btn">Ajouter</button></div>
                        </div>`;
                    } else if (step.produits.length === 0) {
                        productsHtml = `<div class="text-center py-6 text-gray-400 bg-gray-50 rounded-lg border border-dashed border-gray-300">Aucun produit disponible pour cette étape.</div>`;
                    } else {
                        productsHtml = step.produits.map(p => {
                            const productUrl = `${BASE_URL}produit/${p.link}/`;
                            const specBadges = getSpecBadges(p.caracteristiques);
                            return `<div class="conf-list-item" id="card-${p.id}">
                                <div class="cli-row1">
                                    <a href="${productUrl}" target="_blank" class="conf-list-img-wrap" title="Voir la fiche produit">
                                        <img src="${p.photo}" alt="${p.titre}" loading="lazy">
                                    </a>
                                    <div class="cli-name">
                                        <h4 class="product-title" title="${p.titre}">${p.titre}</h4>
                                        ${p.stock == 2 ? `<div style="margin-top:4px; margin-bottom:2px;"><span class="spec-badge" style="background:#fffbeb; color:#d97706; border-color:#fde68a;">⏳ Sur commande</span></div>` : ''}
                                        ${specBadges ? `<div style="margin-top:3px;">${specBadges}</div>` : ''}
                                    </div>
                                </div>
                                <div class="cli-actions" id="action-${p.id}">
                                    <div class="price-block">${p.prix_formate}</div>
                                    <button class="cx-btn" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;"
                                            onclick='window.confToggleItem(${JSON.stringify(p).replace(/'/g, "&#39;")}, ${step.id})'>Choisir</button>
                                </div>
                            </div>`;
                        }).join('');
                    }

                    return `<div class="step-container" id="step-content-${index}">
                        <div class="mb-4 pb-2 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">${step.titre}</h2>
                            <p class="text-xs text-gray-500 mt-1">${step.obligatoire ? '<span class="text-red-500 font-bold">* Etape obligatoire</span>' : 'Etape optionnelle'}</p>
                        </div>
                        <div class="flex-col-force">${productsHtml}</div>
                    </div>`;
                }).join('');
            }

            function updateView() {
                DOM.stepsIndicator.innerHTML = state.steps.map((step, idx) => {
                    const cls = idx < state.currentIndex ? 'completed' : (idx === state.currentIndex ? 'active' : '');
                    return `<div class="step-dot ${cls}"><div class="step-dot-circle">${idx + 1}</div><span class="hidden sm:inline">${step.titre}</span></div>${idx < state.steps.length - 1 ? '<div class="step-separator"></div>' : ''}`;
                }).join('');

                document.querySelectorAll('.step-container').forEach((el, idx) => {
                    el.classList.toggle('active', idx === state.currentIndex);
                });

                DOM.btnPrev.style.display = state.currentIndex === 0 ? 'none' : 'inline-flex';
                const isLast = state.currentIndex === state.steps.length - 1;
                DOM.btnNext.style.display = isLast ? 'none' : 'inline-flex';
                DOM.btnSkip.style.display = isLast ? 'none' : 'inline-flex';
                DOM.addToCartBtn.style.display = isLast ? 'flex' : 'none';

                refreshCardsState();
                renderSummary();
            }

            function refreshCardsState() {
                const currentStep = state.steps[state.currentIndex];
                if (!currentStep) return;
                const sid = currentStep.id;

                (currentStep.produits || []).forEach(p => {
                    const card = document.getElementById(`card-${p.id}`);
                    const ac = document.getElementById(`action-${p.id}`);
                    if (!card || !ac) return;
                    const sel = !!state.selectedItems[p.id];
                    card.classList.toggle('selected', sel);
                    if (sel) {
                        const qty = state.selectedItems[p.id].quantity;
                        ac.innerHTML = `<div class="price-block">${p.prix_formate}</div>
                            <div style="display:flex;align-items:center;gap:4px;">
                                <div style="display:flex;align-items:center;background:var(--shop-bg-base);border:1.5px solid var(--shop-primary);border-radius:6px;overflow:hidden;height:30px;">
                                    <button class="conf-qty-btn" style="border-radius:0;height:100%;width:22px;background:transparent;color:var(--shop-text-primary);" onclick="window.confUpdateQty(${p.id},-1)">−</button>
                                    <span class="conf-qty-val" style="font-size:0.82rem;color:var(--shop-text-primary);">${qty}</span>
                                    <button class="conf-qty-btn" style="border-radius:0;height:100%;width:22px;background:transparent;color:var(--shop-text-primary);" onclick="window.confUpdateQty(${p.id},1)">+</button>
                                </div>
                                <button style="height:30px;width:30px;border:1.5px solid #ef4444;color:#ef4444;background:transparent;border-radius:6px;font-weight:bold;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;"
                                        onclick='window.confToggleItem(${JSON.stringify(p).replace(/'/g, "&#39;")},${sid})'>✕</button>
                            </div>`;
                    } else {
                        ac.innerHTML = `<div class="price-block">${p.prix_formate}</div>
                            <button class="cx-btn" style="padding:0.4rem 0.8rem;font-size:0.8rem;"
                                    onclick='window.confToggleItem(${JSON.stringify(p).replace(/'/g, "&#39;")},${sid})'>Choisir</button>`;
                    }
                });

                if (currentStep.role === 'frais_installation') {
                    const card = document.getElementById(`frais-card-${sid}`);
                    const ac = document.getElementById(`frais-action-${sid}`);
                    if (card && ac) {
                        const sel = !!state.selectedFrais[sid];
                        card.classList.toggle('selected', sel);
                        ac.innerHTML = sel ? `<button class="cx-btn selected-btn">Retirer</button>` : `<button class="cx-btn">Ajouter</button>`;
                    }
                }
            }

            function renderSummary() {
                let total = 0, html = '', missingObl = false;

                state.steps.forEach(step => {
                    const items = Object.values(state.selectedItems).filter(it => String(it.stepId) === String(step.id));
                    const frais = state.selectedFrais[step.id];

                    if (items.length > 0 || frais) {
                        html += `<div class="summary-item filled"><div class="summary-item-title">${step.titre}</div>`;
                        items.forEach(it => {
                            const p = it.data;
                            total += p.prix * it.quantity;
                            html += `<div class="flex justify-between items-start gap-2 mt-1 group">
                                <div class="text-sm font-medium leading-tight flex-1" title="${p.titre}">${it.quantity}x ${p.titre}</div>
                                <button class="shrink-0 text-gray-400 hover:text-red-500 transition-colors" title="Retirer" onclick="window.confRemoveItem(${p.id})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>`;
                        });
                        if (frais) {
                            total += frais.montant;
                            html += `<div class="text-sm font-medium mt-1">Service d'installation</div>`;
                        }
                        html += `</div>`;
                    } else {
                        const isMissing = step.obligatoire && state.currentIndex >= state.steps.findIndex(s => s.id === step.id);
                        if (isMissing) missingObl = true;
                        html += `<div class="summary-item ${isMissing ? 'missing' : ''}">
                            <div class="summary-item-title ${isMissing ? 'text-red-500' : ''}">${step.titre}${step.obligatoire ? ' *' : ''}</div>
                            <div class="text-xs text-gray-400 italic">${isMissing ? 'Requis' : 'Non selectionnee'}</div>
                        </div>`;
                    }
                });

                DOM.summaryItems.innerHTML = html;
                DOM.totalPrice.innerHTML = total.toFixed(3).replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' TND';

                let warn = '', blocking = false;
                if (missingObl && state.currentIndex === state.steps.length - 1) {
                    warn = `<div class="bg-red-50 border border-red-200 p-3 rounded-lg flex items-start gap-2 mb-2 text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span class="text-xs">Certains composants obligatoires (*) ne sont pas selectionnes.</span>
                    </div>`;
                    blocking = true;
                }
                DOM.warnings.innerHTML = warn;

                if (state.currentIndex === state.steps.length - 1) {
                    if (Object.keys(state.selectedItems).length === 0) {
                        DOM.addToCartBtn.disabled = true; DOM.forceWrapper.classList.add('hidden');
                    } else if (blocking) {
                        DOM.addToCartBtn.disabled = !DOM.forceCheckbox.checked; DOM.forceWrapper.classList.remove('hidden');
                    } else {
                        DOM.addToCartBtn.disabled = false; DOM.forceWrapper.classList.add('hidden'); DOM.forceCheckbox.checked = false;
                    }
                }
            }

            DOM.forceCheckbox.addEventListener('change', renderSummary);

            window.confNextStep = function() {
                if (state.currentIndex < state.steps.length - 1) { state.currentIndex++; updateView(); window.scrollTo({ top: document.getElementById('conf-app').offsetTop - 50, behavior: 'smooth' }); }
            };
            window.confPrevStep = function() {
                if (state.currentIndex > 0) { state.currentIndex--; updateView(); window.scrollTo({ top: document.getElementById('conf-app').offsetTop - 50, behavior: 'smooth' }); }
            };

            window.confToggleItem = function(product, stepId) {
                if (state.selectedItems[product.id]) {
                    delete state.selectedItems[product.id];
                } else {
                    const step = state.steps.find(s => s.id === stepId);
                    const role = step ? (step.role || '') : '';
                    const SINGLE = ['dvr', 'nvr', 'hdd', 'switch', 'cpu', 'motherboard', 'ram', 'psu', 'case', 'gpu', 'cooling'];
                    if (SINGLE.includes(role)) {
                        Object.keys(state.selectedItems).forEach(id => { if (state.selectedItems[id].stepId === stepId) delete state.selectedItems[id]; });
                    }
                    state.selectedItems[product.id] = { quantity: 1, stepId: stepId, data: product };
                    if (SINGLE.includes(role)) setTimeout(() => window.confNextStep(), 350);
                }
                refreshCardsState(); renderSummary();
            };

            window.confUpdateQty = function(pid, delta) {
                if (state.selectedItems[pid]) {
                    state.selectedItems[pid].quantity += delta;
                    if (state.selectedItems[pid].quantity <= 0) delete state.selectedItems[pid];
                    refreshCardsState(); renderSummary();
                }
            };

            window.confToggleFrais = function(stepId, montant) {
                if (state.selectedFrais[stepId]) {
                    delete state.selectedFrais[stepId];
                } else {
                    state.selectedFrais[stepId] = { montant: parseFloat(montant) };
                }
                refreshCardsState(); renderSummary();
            };

            window.confRemoveItem = function(pid) {
                if (state.selectedItems[pid]) { delete state.selectedItems[pid]; refreshCardsState(); renderSummary(); }
            };

            DOM.addToCartBtn.addEventListener('click', function() {
                if (this.disabled) return;
                const allItems = [
                    ...Object.values(state.selectedItems),
                    ...Object.entries(state.selectedFrais).map(([sid, d]) => {
                        const step = state.steps.find(s => String(s.id) === String(sid));
                        return { isFrais: true, data: { id: 1, titre: step ? step.titre : "Frais d'installation", prix: d.montant }, quantity: 1 };
                    })
                ];
                if (allItems.length === 0) return;
                const orig = this.innerHTML;
                this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Ajout en cours...';
                this.disabled = true;
                let i = 0;
                const next = () => {
                    if (i >= allItems.length) { window.location.href = '<?php echo lienPanier(); ?>'; return; }
                    const it = allItems[i];
                    let url = 'includes/cart.php?action=add&id_produit=' + it.data.id + '&quantity=' + it.quantity;
                    if (it.isFrais) url += '&vprice=' + it.data.prix + '&vname=' + encodeURIComponent(it.data.titre);
                    $.ajax({ url, type: 'GET', dataType: 'json', success: () => { i++; next(); }, error: () => { alert("Erreur : " + it.data.titre); DOM.addToCartBtn.innerHTML = orig; DOM.addToCartBtn.disabled = false; } });
                };
                next();
            });
        });
    </script>
</body>
</html>
