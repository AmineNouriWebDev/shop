<?php
include("include.php");

$titre = "Configurateur Système de Surveillance";
$title_page = "Créer votre kit de vidéosurveillance sur mesure | Offipro";
$description_page = "Composez votre système de caméras personnalisé. Choisissez votre enregistreur, vos caméras et accessoires étape par étape.";

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
      
      /* ── Kit selection cards ─────────────────────────────────────────── */
      #conf-kits-view { width: 100%; text-align: center; }
      #conf-kits-container {
          display: grid;
          /* Desktop: 2+ cards per row; Mobile: 1 per row */
          grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
          gap: 1rem;
          width: 100%;
          max-width: 700px;
          margin: 0 auto;
      }
      @media (max-width: 640px) {
          #conf-kits-container {
              grid-template-columns: 1fr; /* 1 card per row on mobile */
          }
      }
      .kit-card {
          cursor: pointer;
          border: 2px solid var(--shop-border);
          border-radius: 1rem;
          padding: 1.1rem 1.25rem;
          text-align: left;
          transition: all 220ms ease;
          background: var(--shop-surface);
          display: flex;
          flex-direction: row;
          align-items: center;
          gap: 1rem;
          min-height: 80px;
      }
      @media (min-width: 641px) {
          .kit-card {
              flex-direction: column;
              text-align: center;
              align-items: center;
              min-height: 160px;
              padding: 1.25rem 1rem;
          }
      }
      .kit-card:hover {
          border-color: var(--shop-primary);
          background: color-mix(in srgb, var(--shop-primary) 4%, var(--shop-surface));
          transform: translateY(-2px);
          box-shadow: 0 10px 22px rgba(0,0,0,0.07);
      }
      .kit-icon {
          width: 52px;
          height: 52px;
          flex-shrink: 0;
          border-radius: 50%;
          background: color-mix(in srgb, var(--shop-primary) 10%, transparent);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--shop-primary);
          font-size: 1.4rem;
      }
      @media (min-width: 641px) {
          .kit-icon { margin-bottom: 0.5rem; }
      }
      .kit-icon img { max-width: 30px; max-height: 30px; object-fit: contain; }
      .kit-text { flex: 1; min-width: 0; text-align: left; }
      @media (min-width: 641px) { .kit-text { text-align: center; } }
      .kit-title {
          font-size: 0.9rem;
          font-weight: 700;
          line-height: 1.3;
          color: var(--shop-text-primary);
          margin: 0 0 0.2rem;
      }
      .kit-desc {
          font-size: 0.75rem;
          color: var(--shop-text-secondary);
          line-height: 1.35;
          margin: 0;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
      }

      /* ── Main App Layout ─────────────────────────────────────────────── */
      #conf-app { width: 100%; display: none; }
      .layout-row { display: flex; flex-direction: column; gap: 1.5rem; width: 100%; }
      @media (min-width: 768px) {
          .layout-row { flex-direction: row; align-items: flex-start; justify-content: center; }
      }
      .flex-col-force { display: flex; flex-direction: column !important; }

      /* ── Timeline ────────────────────────────────────────────────────── */
      .steps-indicator { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem; width: 100%; }
      .step-dot { display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 600; color: var(--shop-text-secondary); opacity: 0.5; transition: all 300ms ease; }
      .step-dot.active { opacity: 1; color: var(--shop-primary); }
      .step-dot.completed { opacity: 1; color: #10b981; }
      .step-dot-circle { width: 24px; height: 24px; border-radius: 50%; background: var(--shop-bg-alt); display: flex; align-items: center; justify-content: center; border: 1px solid var(--shop-border); }
      .step-dot.active .step-dot-circle { background: var(--shop-primary); color: white; border-color: var(--shop-primary); }
      .step-dot.completed .step-dot-circle { background: #10b981; color: white; border-color: #10b981; }
      .step-separator { height: 1px; width: 20px; background: var(--shop-border); }

      /* ── Product List Item — responsive ──────────────────────────── */
      .conf-list-item {
          border-bottom: 1px solid var(--shop-border);
          padding: 0.65rem 0;
          transition: background 200ms ease;
          width: 100%;
      }
      .conf-list-item:last-child { border-bottom: none; }
      .conf-list-item.selected {
          background: color-mix(in srgb, var(--shop-primary) 4%, transparent);
          border-radius: 0.5rem;
          padding-left: 0.4rem;
          padding-right: 0.4rem;
      }

      /* Desktop: single row [img] [name] [price+btn] */
      @media (min-width: 641px) {
          .conf-list-item {
              display: flex;
              align-items: center;
              gap: 0.7rem;
          }
          .cli-name { flex: 1; min-width: 0; }
          .cli-actions { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
      }

      /* Mobile: 2-row layout */
      @media (max-width: 640px) {
          .conf-list-item { display: flex; flex-direction: column; gap: 0; padding: 0.75rem 0; }
          .cli-row1 { display: flex; align-items: center; gap: 0.6rem; width: 100%; }
          .cli-name  { flex: 1; min-width: 0; }
          .cli-actions {
              display: flex;
              align-items: center;
              justify-content: center;
              gap: 0.5rem;
              width: 100%;
              margin-top: 0.5rem;
              padding-left: calc(48px + 0.6rem); /* align under name */
          }
          #conf-app .cx-btn { font-size: 0.82rem; padding: 0.38rem 0.9rem; }
      }

      .conf-list-img-wrap {
          height: 48px; width: 48px;
          flex-shrink: 0;
          background: white;
          border-radius: 0.5rem;
          display: flex; align-items: center; justify-content: center;
          padding: 0.25rem;
          border: 1px solid var(--shop-border);
      }
      .conf-list-img-wrap img { max-height: 100%; max-width: 100%; object-fit: contain; }

      .price-block {
          background: var(--shop-bg-alt);
          color: var(--shop-primary);
          font-weight: 700;
          padding: 0.3rem 0.5rem;
          border-radius: 0.5rem;
          white-space: nowrap;
          font-size: 0.82rem;
          border: 1px solid var(--shop-border);
          flex-shrink: 0;
      }

      /* ── Buttons ─────────────────────────────────────────────────────── */
      .cx-btn {
        display: inline-flex; justify-content: center; align-items: center; gap: 0.4rem;
        padding: 0.5rem 1rem;
        background: var(--shop-primary); color: white;
        border: none; border-radius: 0.6rem;
        font-weight: 600; font-size: 0.85rem; cursor: pointer;
        transition: all 200ms ease;
        white-space: nowrap;
      }
      .cx-btn:hover:not(:disabled) { background: var(--shop-primary-hover); transform: translateY(-1px); box-shadow: 0 4px 15px color-mix(in srgb, var(--shop-primary) 30%, transparent); color: white; }
      .cx-btn:disabled { opacity: 0.5; cursor: not-allowed; }
      .cx-btn.selected-btn { background: #ef4444; }
      .cx-btn.selected-btn:hover:not(:disabled) { background: #dc2626; }

      .cx-btn-outline {
        display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        background: transparent; color: var(--shop-text-primary);
        border: 1.5px solid var(--shop-border); border-radius: 0.75rem;
        font-weight: 600; font-size: 0.9rem; cursor: pointer;
        transition: all 200ms ease;
      }
      .cx-btn-outline:hover { border-color: var(--shop-text-primary); background: var(--shop-bg-alt); }

      .conf-qty-btn { width: 28px; height: 28px; border-radius: 0.4rem; border: none; background: var(--shop-primary); color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 150ms ease; font-size: 1rem; flex-shrink: 0; }
      .conf-qty-btn:hover { background: var(--shop-primary-hover); }
      .conf-qty-val { font-size: 0.88rem; font-weight: 700; min-width: 24px; text-align: center; }

      /* Desktop: 2-line clamp */
      .product-title {
          font-size: 0.84rem;
          line-height: 1.35;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
          color: var(--shop-text-primary);
          font-weight: 600;
      }
      /* Mobile: on 2 rows max but full width — no forced single line */
      @media (max-width: 640px) {
          .product-title {
              font-size: 0.82rem;
              -webkit-line-clamp: 2;
          }
      }

      .step-container { display: none; animation: fadeIn 300ms ease; }
      .step-container.active { display: block; }
      @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

      /* Mobile: h1 compact single line */
      .conf-h1 {
          font-size: clamp(1.1rem, 5vw, 1.5rem);
          font-weight: 700;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          margin-bottom: 0.4rem;
      }
      .summary-item { border-left: 3px solid var(--shop-border); padding-left: 1rem; margin-bottom: 1rem; }
      .summary-item.filled { border-left-color: var(--shop-primary); }
      .summary-item.missing { border-left-color: #ef4444; }
      .summary-item-title { font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--shop-text-secondary); margin-bottom: 0.25rem; }
    </style>
</head>
<body>
	<?php include('includes/feedback.php');?>
	<?php include('includes/header-tw.php');?>
	
    <main class="cx-wrap">
        <!-- 1. SÉLECTION DU KIT -->
        <div id="conf-kits-view" style="margin-bottom: 4rem;">
            <h1 class="conf-h1">Configurez votre système</h1>
            <p class="text-gray-500 text-sm mb-6">Choisissez votre point de départ.</p>
            
            <div id="conf-kits-container">
                <!-- Injecté par JS -->
            </div>
        </div>

        <!-- 2. WIZARD DU CONFIGURATEUR -->
        <div id="conf-app">
            
            <!-- Indicateur des étapes -->
            <div id="conf-steps-indicator" class="steps-indicator">
                <!-- Injecté par JS -->
            </div>

            <!-- Bouton pour recommencer -->
            <div style="display: flex; justify-content: center; margin-bottom: 2rem;">
                <button class="text-xs text-gray-500 hover:text-[var(--shop-primary)] flex items-center gap-1 font-medium bg-gray-100 px-3 py-1.5 rounded-full transition-colors" onclick="window.location.reload()" style="display: flex; align-items: center; gap: 0.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Changer de système
                </button>
            </div>

            <!-- Layout 2 colonnes (Left: Configurator, Right: Summary) -->
            <div class="layout-row">
                
                <!-- BLOC GAUCHE : CHOIX PRODUITS -->
                <div class="flex-1 w-full max-w-3xl">
                    <div id="conf-steps-content" class="rounded-xl p-4 md:p-6 shadow-sm mb-6" style="background: var(--shop-surface); border: 1px solid var(--shop-border);">
                        <!-- Injecté par JS -->
                    </div>

                    <!-- Navigation Bas de page -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-top: 1.5rem;">
                        <button id="btn-prev" class="cx-btn-outline" style="display:none; align-items: center; gap: 0.5rem;" onclick="window.confPrevStep()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            Retour
                        </button>
                        
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-left: auto;">
                            <button id="btn-skip" class="text-gray-500 hover:text-gray-800 font-medium px-4 py-2 underline text-sm" onclick="window.confNextStep()">
                                Ignorer cette étape
                            </button>
                            <button id="btn-next" class="cx-btn" style="display: flex; align-items: center; gap: 0.5rem;" onclick="window.confNextStep()">
                                Suivant
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- BLOC DROIT : RÉSUMÉ -->
                <div class="w-full shrink-0 sticky top-[100px]" style="max-width: 350px;">
                    <div class="rounded-xl p-5 shadow-sm flex-col-force" style="background: var(--shop-surface); border: 1px solid var(--shop-border);">
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2 shrink-0 pb-3" style="border-bottom: 1px solid var(--shop-border);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            Résumé du système
                        </h3>
                        
                        <div id="conf-summary-items" class="flex-1 w-full max-h-[50vh] overflow-y-auto pr-2" style="scrollbar-width: thin;">
                            <!-- Injecté par JS -->
                        </div>

                        <!-- Règles et Avertissements -->
                        <div id="conf-warnings" class="shrink-0 mt-4 text-sm font-medium w-full"></div>

                        <div class="shrink-0 pt-4 mt-4 w-full" style="border-top: 1px solid var(--shop-border);">
                            <div class="text-lg font-bold mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Total estimé</span>
                                <span id="conf-total-price" class="text-xl" style="color: var(--shop-primary); margin-left: 1rem;">0.000 TND</span>
                            </div>
                            
                            <div id="conf-force-checkout-wrapper" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="checkbox" id="conf-force-checkbox" class="mt-1 w-4 h-4 text-[var(--shop-primary)] rounded focus:ring-[var(--shop-primary)]">
                                    <span class="text-xs text-red-800 leading-tight">Je confirme ma configuration incomplète.</span>
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

        document.addEventListener('DOMContentLoaded', function() {
            const state = {
                kitId: null,
                steps: [],
                currentIndex: 0,
                selectedItems: {}, // { productId: { quantity: 1, stepId: X, data: {} } }
            };

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

            // INIT
            fetch('ajax_configurateur.php?action=get_kits')
                .then(r => r.json())
                .then(data => {
                    if(data.status === 'success') {
                        if(data.kits.length === 0) {
                            DOM.loader.innerHTML = '<p class="text-red-500">Aucun système disponible pour le moment.</p>';
                            return;
                        }
                        
                        let html = '';
                        data.kits.forEach(kit => {
                            let iconHtml = '';
                            if (kit.photo && kit.photo.trim() !== '') {
                                if (kit.photo.includes('fa-') || kit.photo.startsWith('fa ')) {
                                    iconHtml = `<i class="${kit.photo}" style="font-size:1.5rem;"></i>`;
                                } else {
                                    iconHtml = `<img src="media/products/${kit.photo}" alt="${kit.titre}">`;
                                }
                            } else {
                                // Default SVGs based on title hint
                                iconHtml = kit.titre.toLowerCase().includes('wifi') || kit.titre.toLowerCase().includes('ip')
                                    ? '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>'
                                    : '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>';
                            }
                            
                            html += `
                            <div class="kit-card" onclick="window.confSelectKit(${kit.id})">
                                <div class="kit-icon">${iconHtml}</div>
                                <div class="kit-text">
                                    <div class="kit-title">${kit.titre}</div>
                                    ${kit.description ? `<p class="kit-desc">${kit.description}</p>` : ''}
                                </div>
                            </div>
                            `;
                        });
                        DOM.kitsContainer.innerHTML = html;
                        DOM.loader.style.display = 'none';
                        DOM.kitsView.style.display = 'block';
                    }
                });

            window.confSelectKit = function(id) {
                state.kitId = id;
                DOM.kitsView.style.display = 'none';
                DOM.loader.style.display = 'flex';
                DOM.loaderText.innerText = 'Chargement...';

                fetch('ajax_configurateur.php?action=get_steps&kit_id=' + id)
                    .then(r => r.json())
                    .then(data => {
                        if(data.status === 'success') {
                            state.steps = data.steps;
                            if(state.steps.length > 0) {
                                buildApp();
                                DOM.loader.style.display = 'none';
                                DOM.app.style.display = 'block'; // block to show the container
                                updateView();
                            } else {
                                DOM.loader.innerHTML = '<p class="text-red-500">Ce kit ne contient aucune étape.</p>';
                            }
                        } else {
                            DOM.loader.innerHTML = `<p class="text-red-500">Erreur: ${data.message}</p>`;
                        }
                    });
            };

            function buildApp() {
                DOM.stepsContent.innerHTML = state.steps.map((step, index) => {
                    let productsHtml = '';
                    if(step.produits.length === 0) {
                        productsHtml = `<div class="text-center py-6 text-gray-400 bg-gray-50 rounded-lg border border-dashed border-gray-300">Aucun produit disponible.</div>`;
                    } else {
                        productsHtml = step.produits.map(p => {
                            const productUrl = `${BASE_URL}produit/${p.link}/`;
                            return `
                            <div class="conf-list-item" id="card-${p.id}">
                                <div class="cli-row1">
                                    <a href="${productUrl}" target="_blank" class="conf-list-img-wrap" title="Voir la fiche produit">
                                        <img src="${p.photo}" alt="${p.titre}" loading="lazy">
                                    </a>
                                    <div class="cli-name">
                                        <h4 class="product-title" title="${p.titre}">${p.titre}</h4>
                                    </div>
                                </div>
                                <div class="cli-actions" id="action-${p.id}">
                                    <div class="price-block">${p.prix_formate}</div>
                                    <button class="cx-btn"
                                            style="padding: 0.4rem 0.8rem; font-size: 0.8rem;"
                                            onclick='window.confToggleItem(${JSON.stringify(p).replace(/'/g, "&#39;")}, ${step.id})'>
                                        Choisir
                                    </button>
                                </div>
                            </div>
                            `;
                        }).join('');
                    }

                    return `
                    <div class="step-container" id="step-content-${index}">
                        <div class="mb-4 pb-2 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">${step.titre}</h2>
                            <p class="text-xs text-gray-500 mt-1">${step.obligatoire ? '<span class="text-red-500 font-bold">* Étape obligatoire</span>' : 'Étape optionnelle'}</p>
                        </div>
                        
                        <div class="flex-col-force">
                            ${productsHtml}
                        </div>
                    </div>
                    `;
                }).join('');
            }

            function updateView() {
                // Steps Indicator Update
                let indicatorHtml = '';
                state.steps.forEach((step, idx) => {
                    let statusClass = '';
                    if (idx < state.currentIndex) statusClass = 'completed';
                    else if (idx === state.currentIndex) statusClass = 'active';

                    indicatorHtml += `
                        <div class="step-dot ${statusClass}">
                            <div class="step-dot-circle">${idx + 1}</div>
                            <span class="hidden sm:inline">${step.titre}</span>
                        </div>
                    `;
                    if (idx < state.steps.length - 1) {
                        indicatorHtml += `<div class="step-separator"></div>`;
                    }
                });
                DOM.stepsIndicator.innerHTML = indicatorHtml;

                // Wizard Update
                document.querySelectorAll('.step-container').forEach((el, idx) => {
                    if(idx === state.currentIndex) el.classList.add('active');
                    else el.classList.remove('active');
                });

                DOM.btnPrev.style.display = state.currentIndex === 0 ? 'none' : 'inline-flex';

                if(state.currentIndex === state.steps.length - 1) {
                    DOM.btnNext.style.display = 'none';
                    DOM.btnSkip.style.display = 'none';
                    DOM.addToCartBtn.style.display = 'flex';
                } else {
                    DOM.btnNext.style.display = 'inline-flex';
                    DOM.btnSkip.style.display = 'inline-flex';
                    if(state.currentIndex !== state.steps.length - 1) DOM.addToCartBtn.style.display = 'none';
                }

                refreshCardsState();
                renderSummary();
            }

            function refreshCardsState() {
                const currentStepId = state.steps[state.currentIndex].id;
                
                state.steps[state.currentIndex].produits.forEach(p => {
                    const card = document.getElementById(`card-${p.id}`);
                    const actionContainer = document.getElementById(`action-${p.id}`);
                    if(!card || !actionContainer) return;

                    const isSelected = !!state.selectedItems[p.id];
                    const productUrl = `${BASE_URL}produit/${p.link}/`;
                    
                    if(isSelected) {
                        card.classList.add('selected');
                        const qty = state.selectedItems[p.id].quantity;
                        actionContainer.innerHTML = `
                            <div class="price-block">${p.prix_formate}</div>
                            <div style="display:flex; align-items:center; gap:4px;">
                                <div style="display:flex; align-items:center; background:var(--shop-bg-base); border:1.5px solid var(--shop-primary); border-radius:6px; overflow:hidden; height:30px;">
                                    <button class="conf-qty-btn" style="border-radius:0; height:100%; width:22px; background:transparent; color:var(--shop-text-primary);" onclick="window.confUpdateQty(${p.id}, -1)">−</button>
                                    <span class="conf-qty-val" style="font-size:0.82rem; color:var(--shop-text-primary);">${qty}</span>
                                    <button class="conf-qty-btn" style="border-radius:0; height:100%; width:22px; background:transparent; color:var(--shop-text-primary);" onclick="window.confUpdateQty(${p.id}, 1)">+</button>
                                </div>
                                <button style="height:30px; width:30px; border:1.5px solid #ef4444; color:#ef4444; background:transparent; border-radius:6px; font-weight:bold; font-size:1rem; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0;"
                                        onclick='window.confToggleItem(${JSON.stringify(p).replace(/'/g, "&#39;")}, ${currentStepId})'>
                                    ✕
                                </button>
                            </div>
                        `;
                    } else {
                        card.classList.remove('selected');
                        actionContainer.innerHTML = `
                            <div class="price-block">${p.prix_formate}</div>
                            <button class="cx-btn"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.8rem;"
                                    onclick='window.confToggleItem(${JSON.stringify(p).replace(/'/g, "&#39;")}, ${currentStepId})'>
                                Choisir
                            </button>
                        `;
                    }
                });
            }

            function renderSummary() {
                let total = 0;
                let html = '';
                let recorderChannels = 0;
                let totalCameras = 0;
                let missingObligatory = false;

                const RECORDER_ROLES = ['dvr', 'nvr'];
                const CAMERA_ROLES   = ['camera_filaire', 'camera_wifi'];

                // Parcourir toutes les étapes pour afficher la liste complète
                state.steps.forEach(step => {
                    const itemsInStep = Object.values(state.selectedItems).filter(item => String(item.stepId) === String(step.id));
                    const stepRole = step.role || '';
                    
                    if(itemsInStep.length > 0) {
                        // Rempli
                        html += `<div class="summary-item filled">
                                    <div class="summary-item-title">${step.titre}</div>`;
                        itemsInStep.forEach(item => {
                            const p = item.data;
                            total += p.prix * item.quantity;
                            
                            // Logique DVR/NVR via RÔLE (plus via le titre)
                            if(RECORDER_ROLES.includes(stepRole)) {
                                for(const [key, val] of Object.entries(p.caracteristiques)) {
                                    const kl = key.toLowerCase();
                                    if(kl.includes('canal') || kl.includes('voie') || kl.includes('channel') || kl.includes('ch')) {
                                        const n = parseInt(val);
                                        if(!isNaN(n)) recorderChannels = Math.max(recorderChannels, n);
                                    }
                                }
                                if(recorderChannels === 0) {
                                    const match = p.titre.match(/(\d+)\s*(canaux|voies?|ch\b|port)/i);
                                    if(match) recorderChannels = Math.max(recorderChannels, parseInt(match[1]));
                                }
                            }
                            if(CAMERA_ROLES.includes(stepRole)) {
                                totalCameras += item.quantity;
                            }

                            html += `
                            <div class="flex justify-between items-start gap-2 mt-1 group">
                                <div class="text-sm font-medium leading-tight flex-1" title="${p.titre}">${item.quantity}x ${p.titre}</div>
                                <button class="shrink-0 text-gray-400 hover:text-red-500 transition-colors" title="Retirer" onclick="window.confRemoveItem(${p.id})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            `;
                        });
                        html += `</div>`;
                    } else {
                        // Vide
                        const isMissing = step.obligatoire && state.currentIndex >= state.steps.findIndex(s => s.id === step.id);
                        if(isMissing) missingObligatory = true;
                        
                        html += `<div class="summary-item ${isMissing ? 'missing' : ''}">
                                    <div class="summary-item-title ${isMissing ? 'text-red-500' : ''}">${step.titre} ${step.obligatoire ? '*' : ''}</div>
                                    <div class="text-xs text-gray-400 italic">${isMissing ? 'Requis - Veuillez sélectionner un produit' : 'Non sélectionné'}</div>
                                 </div>`;
                    }
                });

                DOM.summaryItems.innerHTML = html;
                DOM.totalPrice.innerHTML = total.toFixed(3).replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' TND';

                let warningHtml = '';
                let hasBlockingError = false;

                if(recorderChannels > 0 && totalCameras > recorderChannels) {
                    warningHtml += `
                    <div class="bg-amber-50 border border-amber-200 p-3 rounded-lg flex items-start gap-2 mb-2 text-amber-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mt-0.5 shrink-0"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        <span class="text-xs"><strong>Incompatibilité :</strong> ${totalCameras} caméra(s) sélectionnée(s) mais votre enregistreur ne supporte que <strong>${recorderChannels} canaux</strong>.</span>
                    </div>`;
                    hasBlockingError = true;
                }

                if(missingObligatory && state.currentIndex === state.steps.length - 1) {
                    warningHtml += `
                    <div class="bg-red-50 border border-red-200 p-3 rounded-lg flex items-start gap-2 mb-2 text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span class="text-xs">Certaines étapes obligatoires (*) sont manquantes.</span>
                    </div>`;
                    hasBlockingError = true;
                }

                DOM.warnings.innerHTML = warningHtml;

                // Logique d'activation du bouton Ajouter au panier
                if(state.currentIndex === state.steps.length - 1) {
                    if(Object.keys(state.selectedItems).length === 0) {
                        DOM.addToCartBtn.disabled = true;
                        DOM.forceWrapper.classList.add('hidden');
                    } else if(hasBlockingError) {
                        DOM.addToCartBtn.disabled = !DOM.forceCheckbox.checked;
                        DOM.forceWrapper.classList.remove('hidden');
                    } else {
                        DOM.addToCartBtn.disabled = false;
                        DOM.forceWrapper.classList.add('hidden');
                        DOM.forceCheckbox.checked = false; // Reset
                    }
                }
            }

            DOM.forceCheckbox.addEventListener('change', renderSummary);

            window.confNextStep = function() {
                if(state.currentIndex < state.steps.length - 1) {
                    state.currentIndex++;
                    updateView();
                    window.scrollTo({ top: document.getElementById('conf-app').offsetTop - 50, behavior: 'smooth' });
                }
            };

            window.confPrevStep = function() {
                if(state.currentIndex > 0) {
                    state.currentIndex--;
                    updateView();
                    window.scrollTo({ top: document.getElementById('conf-app').offsetTop - 50, behavior: 'smooth' });
                }
            };

            window.confToggleItem = function(product, stepId) {
                if(state.selectedItems[product.id]) {
                    delete state.selectedItems[product.id];
                } else {
                    const step = state.steps.find(s => s.id === stepId);
                    const stepRole = step ? (step.role || '') : '';
                    const SINGLE_CHOICE = ['dvr', 'nvr', 'hdd', 'switch'];
                    
                    // Remplacement automatique pour rôles à choix unique
                    if(SINGLE_CHOICE.includes(stepRole)) {
                        Object.keys(state.selectedItems).forEach(id => {
                            if(state.selectedItems[id].stepId === stepId) {
                                delete state.selectedItems[id];
                            }
                        });
                    }

                    state.selectedItems[product.id] = { quantity: 1, stepId: stepId, data: product };
                    
                    // Avancement automatique pour les rôles à sélection unique
                    if(SINGLE_CHOICE.includes(stepRole)) {
                        setTimeout(() => window.confNextStep(), 350);
                    }
                }
                refreshCardsState();
                renderSummary();
            };

            window.confUpdateQty = function(productId, delta) {
                if(state.selectedItems[productId]) {
                    state.selectedItems[productId].quantity += delta;
                    if(state.selectedItems[productId].quantity <= 0) {
                        delete state.selectedItems[productId];
                    }
                    refreshCardsState();
                    renderSummary();
                }
            };

            window.confRemoveItem = function(productId) {
                if(state.selectedItems[productId]) {
                    delete state.selectedItems[productId];
                    refreshCardsState();
                    renderSummary();
                }
            };

            DOM.addToCartBtn.addEventListener('click', function() {
                if(this.disabled) return;
                const items = Object.values(state.selectedItems);
                if(items.length === 0) return;

                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Ajout en cours...';
                this.disabled = true;

                let index = 0;
                function processNext() {
                    if (index >= items.length) {
                        window.location.href = '<?php echo lienPanier(); ?>';
                        return;
                    }
                    const item = items[index];
                    $.ajax({
                        url: 'includes/cart.php',
                        type: 'GET',
                        data: 'id_produit=' + item.data.id + '&quantity=' + item.quantity + '&action=add',
                        dataType: "json",
                        success: function(data) {
                            index++;
                            processNext();
                        },
                        error: function() {
                            alert("Erreur lors de l'ajout de : " + item.data.titre);
                            DOM.addToCartBtn.innerHTML = originalText;
                            DOM.addToCartBtn.disabled = false;
                        }
                    });
                }
                processNext();
            });
        });
    </script>
</body>
</html>
