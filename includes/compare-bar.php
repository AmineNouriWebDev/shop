<?php
/**
 * compare-bar.php — Barre de comparaison flottante
 * À inclure une seule fois dans le footer du site (avant </body>)
 */
?>
<!-- ══ BARRE DE COMPARAISON ══ -->
<div id="compare-bar" style="display:none;" aria-live="polite">
  <div id="compare-bar-inner">
    <div id="compare-slots">
      <!-- Les slots sont injectés en JS -->
    </div>
    <div id="compare-bar-actions">
      <span id="compare-count-label">0 produit(s)</span>
      <button id="compare-go-btn" onclick="compareGo()" disabled>
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 0-2-2V9m0 0h18"/></svg>
        Comparer
      </button>
      <button id="compare-clear-btn" onclick="compareClear()" title="Vider la sélection">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        Vider
      </button>
    </div>
  </div>
</div>

<!-- ══ MODAL DE COMPARAISON ══ -->
<div id="compare-modal" role="dialog" aria-modal="true" aria-label="Comparaison de produits" style="display:none;">
  <div id="compare-modal-backdrop" onclick="closeCompareModal()"></div>
  <div id="compare-modal-box">
    <div id="compare-modal-header">
      <h2>Comparaison de produits</h2>
      <button onclick="closeCompareModal()" id="compare-modal-close" aria-label="Fermer">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div id="compare-modal-content">
      <div id="compare-modal-loading">
        <div class="cmp-spinner"></div>
        <p>Chargement de la comparaison…</p>
      </div>
    </div>
  </div>
</div>

<style>
/* ═══════════════════════════════════════
   BARRE FLOTTANTE DE COMPARAISON
   ═══════════════════════════════════════ */
#compare-bar {
  position: fixed;
  bottom: 0; left: 0; right: 0;
  z-index: 9900;
  background: var(--shop-surface, #fff);
  border-top: 2px solid var(--shop-primary, #5A31F4);
  box-shadow: 0 -6px 32px rgba(90,49,244,.18);
  padding: 0.65rem 1rem;
  animation: slideUp 0.3s ease;
}
@keyframes slideUp {
  from { transform: translateY(100%); opacity:0; }
  to   { transform: translateY(0);    opacity:1; }
}
#compare-bar-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
}
#compare-slots {
  display: flex;
  gap: 0.5rem;
  flex: 1;
  flex-wrap: wrap;
}
.cmp-slot {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  background: color-mix(in srgb, var(--shop-primary,#5A31F4) 8%, transparent);
  border: 1.5px solid color-mix(in srgb, var(--shop-primary,#5A31F4) 25%, transparent);
  border-radius: 0.6rem;
  padding: 0.3rem 0.5rem;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--shop-text-primary, #120B2E);
  max-width: 160px;
  animation: fadeIn 0.2s ease;
}
@keyframes fadeIn { from { opacity:0; transform: scale(0.9); } to { opacity:1; transform: scale(1); } }
.cmp-slot-img {
  width: 30px; height: 30px;
  object-fit: contain; border-radius: 4px;
  background: #fff; flex-shrink: 0;
}
.cmp-slot-name {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  max-width: 90px;
}
.cmp-slot-remove {
  cursor: pointer;
  color: #9ca3af;
  flex-shrink: 0;
  background: none;
  border: none;
  line-height: 1;
  padding: 0;
  font-size: 1rem;
  font-weight: 700;
  transition: color 0.15s;
}
.cmp-slot-remove:hover { color: #ef4444; }
.cmp-slot-empty {
  border: 1.5px dashed var(--shop-border, #E0DEFF);
  background: transparent;
  color: #B0AABB;
  font-weight: 500;
  font-size: 0.75rem;
}
#compare-bar-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-shrink: 0;
}
#compare-count-label {
  font-size: 0.8rem;
  color: var(--shop-text-secondary, #6B6589);
  white-space: nowrap;
}
#compare-go-btn {
  display: inline-flex; align-items: center; gap: 0.35rem;
  padding: 0.45rem 1rem;
  background: var(--shop-primary, #5A31F4);
  color: #fff;
  border: none; border-radius: 0.55rem;
  font-size: 0.82rem; font-weight: 700;
  cursor: pointer; transition: 0.15s;
  white-space: nowrap;
}
#compare-go-btn:hover:not(:disabled) { background: var(--shop-primary-hover,#4A24E8); }
#compare-go-btn:disabled { background: #e5e7eb; color: #9ca3af; cursor: not-allowed; }
#compare-clear-btn {
  display: inline-flex; align-items: center; gap: 0.3rem;
  padding: 0.4rem 0.65rem;
  background: transparent;
  border: 1.5px solid var(--shop-border, #E0DEFF);
  border-radius: 0.55rem;
  font-size: 0.78rem; color: var(--shop-text-secondary,#6B6589);
  cursor: pointer; transition: 0.15s;
  white-space: nowrap;
}
#compare-clear-btn:hover { border-color: #ef4444; color: #ef4444; }

/* ═══════════════════════════════════════
   MODAL DE COMPARAISON
   ═══════════════════════════════════════ */
#compare-modal {
  position: fixed;
  inset: 0;
  z-index: 10000;
}
#compare-modal-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(18,11,46,0.55);
  backdrop-filter: blur(3px);
}
#compare-modal-box {
  position: absolute;
  inset: 6% 3%;
  background: var(--shop-surface, #fff);
  border-radius: 1.25rem;
  box-shadow: 0 24px 80px rgba(18,11,46,0.25);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: modalIn 0.28s ease;
}
@keyframes modalIn {
  from { opacity:0; transform: translateY(30px) scale(0.97); }
  to   { opacity:1; transform: translateY(0) scale(1); }
}
#compare-modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.5rem;
  border-bottom: 1.5px solid var(--shop-border, #E0DEFF);
  flex-shrink: 0;
}
#compare-modal-header h2 {
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--shop-text-primary, #120B2E);
  margin: 0;
}
#compare-modal-close {
  background: none; border: none;
  cursor: pointer;
  color: #9ca3af;
  padding: 0.25rem;
  border-radius: 0.375rem;
  transition: 0.15s;
  line-height: 1;
}
#compare-modal-close:hover { background: #fee2e2; color: #ef4444; }
#compare-modal-content {
  flex: 1;
  overflow: auto;
  padding: 1.25rem 1.5rem;
}
#compare-modal-loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 200px;
  gap: 1rem;
  color: var(--shop-text-secondary,#6B6589);
}
.cmp-spinner {
  width: 36px; height: 36px;
  border: 3px solid var(--shop-border,#E0DEFF);
  border-top-color: var(--shop-primary,#5A31F4);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Table de comparaison ── */
.cmp-table-wrap { overflow-x: auto; }
.cmp-table {
  width: 100%; border-collapse: separate; border-spacing: 0;
  font-size: 0.85rem;
  min-width: 480px;
}
.cmp-table th, .cmp-table td {
  padding: 0.65rem 0.85rem;
  border-bottom: 1px solid var(--shop-border,#E0DEFF);
  vertical-align: middle;
  text-align: center;
}
.cmp-table thead th {
  background: color-mix(in srgb, var(--shop-primary,#5A31F4) 6%, transparent);
  font-weight: 700;
  color: var(--shop-text-primary,#120B2E);
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
}
.cmp-table thead th:first-child {
  text-align: left;
  color: var(--shop-text-secondary,#6B6589);
  width: 160px;
  background: transparent;
}
.cmp-table tbody td:first-child {
  text-align: left;
  font-weight: 600;
  color: var(--shop-text-secondary,#6B6589);
  background: color-mix(in srgb, var(--shop-primary,#5A31F4) 3%, transparent);
}
.cmp-table tbody tr:last-child td { border-bottom: none; }
.cmp-prod-img {
  width: 90px; height: 90px;
  object-fit: contain;
  display: block; margin: 0 auto 0.5rem;
  border-radius: 0.5rem;
  background: #f8f7ff;
  padding: 4px;
}
.cmp-prod-name {
  font-size: 0.8rem; font-weight: 700;
  color: var(--shop-text-primary,#120B2E);
  text-decoration: none; display: block;
  margin-bottom: 0.25rem; line-height: 1.3;
}
.cmp-prod-name:hover { color: var(--shop-primary,#5A31F4); }
.cmp-price { font-size: 1rem; font-weight: 800; color: var(--shop-primary,#5A31F4); }
.cmp-price-old { font-size: 0.75rem; color: #B0AABB; text-decoration: line-through; }
.cmp-stock-ok  { color: #10B981; font-weight: 600; }
.cmp-stock-no  { color: #B0AABB; font-weight: 600; }
.cmp-btn-add {
  display: inline-flex; align-items: center; gap: 0.3rem;
  padding: 0.4rem 0.75rem;
  background: var(--shop-primary,#5A31F4);
  color: #fff; border: none; border-radius: 0.45rem;
  font-size: 0.78rem; font-weight: 700;
  cursor: pointer; transition: 0.15s;
  margin-top: 0.4rem;
}
.cmp-btn-add:hover { background: var(--shop-primary-hover,#4A24E8); }
.cmp-highlight { background: color-mix(in srgb,#10B981 10%, transparent) !important; }
.cmp-lowlight  { color: #B0AABB !important; }

/* Bouton Comparer sur les cards */
.btn-compare {
  display: inline-flex; align-items: center; gap: 0.3rem;
  padding: 0.4rem 0.55rem;
  background: transparent;
  border: 1.5px solid var(--shop-border, #E0DEFF);
  border-radius: 0.45rem;
  font-size: 0.78rem; font-weight: 600;
  color: var(--shop-text-secondary, #6B6589);
  cursor: pointer; transition: 0.15s;
  white-space: nowrap;
}
.btn-compare:hover,
.btn-compare.active {
  border-color: var(--shop-primary,#5A31F4);
  color: var(--shop-primary,#5A31F4);
  background: color-mix(in srgb, var(--shop-primary,#5A31F4) 8%, transparent);
}
.btn-compare.active {
  background: var(--shop-primary,#5A31F4);
  color: #fff;
}
/* overlay comparer */
.hp-card-overlay-btn.compare-ol {
  background: rgba(255,255,255,0.95);
  color: var(--shop-primary,#5A31F4);
  border: 1.5px solid var(--shop-primary,#5A31F4);
}
.hp-card-overlay-btn.compare-ol:hover,
.hp-card-overlay-btn.compare-ol.active {
  background: var(--shop-primary,#5A31F4);
  color: #fff;
}

@media (max-width: 576px) {
  #compare-modal-box { inset: 0; border-radius: 0; }
  #compare-bar-inner { gap: 0.5rem; }
  #compare-slots { display: none; }
}
</style>

<script>
/* ═══════════════════════════════════════════════
   MOTEUR DE COMPARAISON — offipro.net
   ═══════════════════════════════════════════════ */
(function () {
  'use strict';

  var MAX = 4;
  var COMPARE_KEY = 'offipro_compare';
  
  // Robust path handling for localhost or subfolder deployments
  var baseUrl = window.location.origin + window.location.pathname.split('/').slice(0, 2).join('/');
  if (!window.location.hostname.includes('.') && window.location.pathname.startsWith('/shop/')) {
    // We are likely on localhost/shop/
    baseUrl = window.location.origin + '/shop';
  } else if (window.location.hostname.includes('.') && !window.location.pathname.startsWith('/shop/')) {
    // We are likely on production root
    baseUrl = window.location.origin;
  }
  
  var compareEndpoint = baseUrl + '/includes/compare-data.php';

  console.log('Compare feature initialized. Endpoint:', compareEndpoint);

  /* ── State (IDs + titres + images) ── */
  var items = [];

  /* ── Persistance session via sessionStorage ── */
  function saveState() {
    try { sessionStorage.setItem(COMPARE_KEY, JSON.stringify(items)); } catch (e) {}
  }
  function loadState() {
    try { var s = sessionStorage.getItem(COMPARE_KEY); if (s) items = JSON.parse(s); } catch (e) {}
  }

  /* ── Ajouter / retirer un produit ── */
  window.compareToggle = function (id, name, imgSrc) {
    id = parseInt(id);
    var idx = items.findIndex(function (i) { return i.id === id; });
    if (idx > -1) {
      items.splice(idx, 1);
    } else {
      if (items.length >= MAX) {
        alert('Vous pouvez comparer au maximum ' + MAX + ' produits.');
        return;
      }
      items.push({ id: id, name: name, img: imgSrc });
    }
    saveState();
    renderBar();
    syncButtons();
  };

  /* ── Retirer par ID (depuis la barre) ── */
  window.compareRemove = function (id) {
    items = items.filter(function (i) { return i.id !== parseInt(id); });
    saveState();
    renderBar();
    syncButtons();
  };

  /* ── Vider tout ── */
  window.compareClear = function () {
    items = [];
    saveState();
    renderBar();
    syncButtons();
  };

  /* ── Lancer la comparaison ── */
  window.compareGo = function () {
    if (items.length < 2) { alert('Sélectionnez au moins 2 produits pour comparer.'); return; }
    openCompareModal();
  };

  /* ── Rendu de la barre ── */
  function renderBar() {
    var bar = document.getElementById('compare-bar');
    var slots = document.getElementById('compare-slots');
    var goBtn = document.getElementById('compare-go-btn');
    var label = document.getElementById('compare-count-label');
    if (!bar) return;

    if (items.length === 0) {
      bar.style.display = 'none';
      return;
    }
    bar.style.display = 'block';
    label.textContent = items.length + ' produit' + (items.length > 1 ? 's' : '') + ' sélectionné' + (items.length > 1 ? 's' : '');
    goBtn.disabled = items.length < 2;

    var html = '';
    for (var i = 0; i < items.length; i++) {
      html += '<div class="cmp-slot">'
        + '<img class="cmp-slot-img" src="' + escHtml(items[i].img) + '" alt="">'
        + '<span class="cmp-slot-name" title="' + escHtml(items[i].name) + '">' + escHtml(items[i].name) + '</span>'
        + '<button class="cmp-slot-remove" onclick="compareRemove(' + items[i].id + ')" title="Retirer" aria-label="Retirer ' + escHtml(items[i].name) + '">&times;</button>'
        + '</div>';
    }
    /* Slots vides */
    for (var j = items.length; j < 2; j++) {
      html += '<div class="cmp-slot cmp-slot-empty">+ Ajouter</div>';
    }
    slots.innerHTML = html;
  }

  /* ── Synchroniser l'état actif des boutons Comparer ── */
  function syncButtons() {
    document.querySelectorAll('[data-compare-id]').forEach(function (btn) {
      var id = parseInt(btn.getAttribute('data-compare-id'));
      var isActive = items.some(function (i) { return i.id === id; });
      btn.classList.toggle('active', isActive);
      btn.title = isActive ? 'Retirer de la comparaison' : 'Comparer';
      /* Texte du bouton overlay ou des cards bout */
      var span = btn.querySelector('.cmp-btn-txt');
      if (span) span.textContent = isActive ? 'Comparé ✓' : 'Comparer';
    });
  }

  /* ── Modal ── */
  function openCompareModal() {
    var modal = document.getElementById('compare-modal');
    var content = document.getElementById('compare-modal-content');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    content.innerHTML = '<div id="compare-modal-loading"><div class="cmp-spinner"></div><p>Chargement…</p></div>';

    var ids = items.map(function (i) { return i.id; }).join(',');
    var fd = new FormData();
    fd.append('ids', ids);
    fetch(compareEndpoint, { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.error) { content.innerHTML = '<p style="color:#ef4444">' + escHtml(data.error) + '</p>'; return; }
        content.innerHTML = buildCompareTable(data.products);
      })
      .catch(function () {
        content.innerHTML = '<p style="color:#ef4444">Erreur lors du chargement.</p>';
      });
  }

  window.closeCompareModal = function () {
    document.getElementById('compare-modal').style.display = 'none';
    document.body.style.overflow = '';
  };

  /* ── Construction du tableau de comparaison ── */
  function buildCompareTable(products) {
    if (!products || products.length === 0) return '<p>Aucun produit trouvé.</p>';

    /* Collecter tous les labels de specs */
    var allSpecs = [];
    products.forEach(function (p) {
      Object.keys(p.specs || {}).forEach(function (label) {
        if (allSpecs.indexOf(label) === -1) allSpecs.push(label);
      });
    });

    var h = '<div class="cmp-table-wrap"><table class="cmp-table"><thead><tr><th>Critère</th>';
    products.forEach(function (p) {
      h += '<th>'
        + '<img class="cmp-prod-img" src="' + escHtml(p.image) + '" alt="">'
        + '<a href="' + escHtml(p.lien) + '" class="cmp-prod-name">' + escHtml(p.titre) + '</a>'
        + '</th>';
    });
    h += '</tr></thead><tbody>';

    /* Ligne Prix */
    h += '<tr><td>Prix</td>';
    products.forEach(function (p) {
      h += '<td><span class="cmp-price">' + escHtml(p.prix) + '</span>';
      if (p.prix_old) h += '<br><span class="cmp-price-old">' + escHtml(p.prix_old) + '</span>';
      h += '</td>';
    });
    h += '</tr>';

    /* Ligne Stock */
    h += '<tr><td>Disponibilité</td>';
    products.forEach(function (p) {
      h += '<td><span class="' + (p.in_stock ? 'cmp-stock-ok' : 'cmp-stock-no') + '">'
        + escHtml(p.stock) + '</span></td>';
    });
    h += '</tr>';

    /* Lignes Specs */
    allSpecs.forEach(function (label) {
      /* Trouver la valeur max pour highlight */
      var vals = products.map(function (p) { return parseFloat((p.specs[label] || '').replace(/[^0-9.]/g, '')) || null; });
      var maxVal = Math.max.apply(null, vals.filter(function (v) { return v !== null; }));

      h += '<tr><td>' + escHtml(label) + '</td>';
      products.forEach(function (p, i) {
        var val = p.specs[label] || '<span class="cmp-lowlight">—</span>';
        var cls = '';
        if (vals[i] !== null && vals[i] === maxVal && vals.filter(function (v) { return v === maxVal; }).length < products.length) {
          cls = ' class="cmp-highlight"';
        }
        h += '<td' + cls + '>' + val + '</td>';
      });
      h += '</tr>';
    });

    /* Ligne Panier */
    h += '<tr><td>Action</td>';
    products.forEach(function (p) {
      h += '<td>';
      if (p.in_stock) {
        h += '<button class="cmp-btn-add" onclick="addToCart(' + p.id + ',1)">'
          + '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>'
          + ' Panier</button>';
      } else {
        h += '<span class="cmp-stock-no">Rupture</span>';
      }
      h += '</td>';
    });
    h += '</tr>';

    h += '</tbody></table></div>';
    return h;
  }

  function escHtml(s) {
    if (!s) return '';
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  /* ── Fermer modal avec Echap ── */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeCompareModal();
  });

  /* ── Init ── */
  loadState();
  document.addEventListener('DOMContentLoaded', function () {
    renderBar();
    syncButtons();
  });
  /* Aussi au cas où le DOM est déjà chargé (AJAX pages) */
  if (document.readyState !== 'loading') {
    renderBar();
    syncButtons();
  }

  /* Exposer pour ré-sync après injection AJAX de nouvelles cards */
  window.compareSyncButtons = syncButtons;

})();
</script>
