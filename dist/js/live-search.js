/**
 * ============================================================
 * SHOP — Live Search 2026
 * ============================================================
 * • Debounced AJAX to /ajax/search.php
 * • Keyboard navigation (↑ ↓ Enter Escape)
 * • Works on desktop + mobile search inputs
 * • No jQuery dependency — pure vanilla JS
 * • Accessible: ARIA live region, role="listbox"
 * ============================================================
 */
(function () {
    'use strict';

    const SEARCH_ENDPOINT = 'ajax/search.php';
    const DEBOUNCE_MS = 300;
    const MIN_CHARS = 2;

    /* ─── State ──────────────────────────────────────────── */
    let debounceTimer = null;
    let activeIdx = -1;
    let lastQuery = '';
    let abortController = null;

    /* ─── Utility: debounce ──────────────────────────────── */
    function debounce(fn, ms) {
        return function (...args) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fn.apply(this, args), ms);
        };
    }

    /* ─── Highlight matching text ───────────────────────── */
    function highlight(text, query) {
        if (!query) return text;
        const safe = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${safe})`, 'gi');
        return text.replace(regex, '<mark style="background:color-mix(in srgb,var(--shop-primary,#5A31F4) 20%,transparent);color:inherit;padding:0 1px;border-radius:2px;">$1</mark>');
    }

    /* ─── Build dropdown HTML ────────────────────────────── */
    function buildDropdown(data, query) {
        const { results, total, search_url } = data;

        if (!results || results.length === 0) {
            return `
        <div class="ls-empty" role="option" aria-selected="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <span>Aucun résultat pour <strong>${query}</strong></span>
        </div>`;
        }

        const items = results.map((p, i) => `
      <a href="${p.url}" class="ls-item" role="option" data-idx="${i}" tabindex="-1">
        <div class="ls-item-img">
          <img src="${p.photo}" alt="" loading="lazy" onerror="this.style.display='none'">
        </div>
        <div class="ls-item-info">
          <div class="ls-item-title">${highlight(p.titre, query)}</div>
          <div class="ls-item-price">
            <span class="ls-price-main">${p.prix} DT</span>
            ${p.prix_barre ? `<span class="ls-price-old">${p.prix_barre} DT</span>` : ''}
            ${p.promo ? '<span class="ls-price-badge">Promo</span>' : ''}
          </div>
        </div>
        <svg class="ls-item-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
      </a>`).join('');

        const footer = total > results.length
            ? `<a href="${search_url}" class="ls-footer">
           Voir les ${total} résultats pour "<strong>${query}</strong>"
           <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
         </a>`
            : `<a href="${search_url}" class="ls-footer">
           Voir tous les résultats
           <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
         </a>`;

        return items + footer;
    }

    /* ─── Show/hide dropdown ─────────────────────────────── */
    function showDropdown(dropdown, content) {
        dropdown.innerHTML = content;
        dropdown.removeAttribute('hidden');
        dropdown.setAttribute('aria-expanded', 'true');
        activeIdx = -1;
    }

    function hideDropdown(dropdown) {
        dropdown.setAttribute('hidden', '');
        dropdown.setAttribute('aria-expanded', 'false');
        activeIdx = -1;
    }

    /* ─── Loading state ──────────────────────────────────── */
    function showLoader(dropdown) {
        dropdown.innerHTML = `
      <div class="ls-loading" role="status">
        <div class="ls-spinner"></div>
        <span>Recherche...</span>
      </div>`;
        dropdown.removeAttribute('hidden');
    }

    /* ─── Keyboard navigation ───────────────────────────── */
    function handleKeydown(e, dropdown, input) {
        if (dropdown.hasAttribute('hidden')) return;

        const items = Array.from(dropdown.querySelectorAll('.ls-item, .ls-footer'));
        if (!items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIdx = Math.min(activeIdx + 1, items.length - 1);
            items[activeIdx].focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (activeIdx <= 0) {
                activeIdx = -1;
                input.focus();
            } else {
                activeIdx--;
                items[activeIdx].focus();
            }
        } else if (e.key === 'Escape') {
            hideDropdown(dropdown);
            input.focus();
        } else if (e.key === 'Enter' && activeIdx >= 0) {
            items[activeIdx].click();
        }
    }

    /* ─── Fetch results ──────────────────────────────────── */
    async function fetchResults(query, dropdown, basePath) {
        if (abortController) abortController.abort();
        abortController = new AbortController();

        showLoader(dropdown);

        try {
            const url = `${basePath}${SEARCH_ENDPOINT}?q=${encodeURIComponent(query)}&limit=8`;
            const response = await fetch(url, {
                signal: abortController.signal,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();
            showDropdown(dropdown, buildDropdown(data, query));

        } catch (err) {
            if (err.name === 'AbortError') return; // cancelled, ignore
            showDropdown(dropdown, `
        <div class="ls-empty">
          <span>Erreur lors de la recherche. Réessayez.</span>
        </div>`);
        }
    }

    /* ─── Bootstrap one search instance ─────────────────── */
    function initSearch(form, basePath) {
        const input = form.querySelector('input[name="recherche"]');
        if (!input) return;

        // Create wrapper (for relative positioning of dropdown)
        const wrapper = document.createElement('div');
        wrapper.className = 'ls-wrapper';
        form.parentNode.insertBefore(wrapper, form);
        wrapper.appendChild(form);

        // Create dropdown
        const dropdown = document.createElement('div');
        dropdown.className = 'ls-dropdown';
        dropdown.id = 'ls-' + Math.random().toString(36).slice(2);
        dropdown.setAttribute('role', 'listbox');
        dropdown.setAttribute('aria-label', 'Résultats de recherche');
        dropdown.setAttribute('hidden', '');
        wrapper.appendChild(dropdown);

        // ARIA on input
        input.setAttribute('autocomplete', 'off');
        input.setAttribute('aria-autocomplete', 'list');
        input.setAttribute('aria-controls', dropdown.id);
        input.setAttribute('aria-expanded', 'false');

        // Input handler (debounced)
        const debouncedFetch = debounce(function () {
            const q = input.value.trim();
            if (q === lastQuery) return;
            lastQuery = q;

            if (q.length < MIN_CHARS) {
                hideDropdown(dropdown);
                return;
            }
            fetchResults(q, dropdown, basePath);
        }, DEBOUNCE_MS);

        input.addEventListener('input', debouncedFetch);

        // Show cached results when re-focusing (if query hasn't changed)
        input.addEventListener('focus', function () {
            if (input.value.trim().length >= MIN_CHARS && !dropdown.hasAttribute('hidden')) {
                // already showing, do nothing
            } else if (input.value.trim().length >= MIN_CHARS) {
                debouncedFetch();
            }
        });

        // Keyboard nav on input
        input.addEventListener('keydown', function (e) {
            handleKeydown(e, dropdown, input);
            // Also close on Tab
            if (e.key === 'Tab') hideDropdown(dropdown);
        });

        // Keyboard nav on dropdown items
        dropdown.addEventListener('keydown', function (e) {
            handleKeydown(e, dropdown, input);
        });

        // Click outside → close
        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target)) hideDropdown(dropdown);
        });

        // Prevent form submit closing dropdown before navigation
        form.addEventListener('submit', function () {
            hideDropdown(dropdown);
        });
    }

    /* ─── Detect base path ───────────────────────────────── */
    function getBasePath() {
        if (window.__shopBasePath) return window.__shopBasePath;
        // Fallback: derive from current URL up to /shop/
        const m = window.location.href.match(/^(https?:\/\/.+?\/shop\/)/i);
        return m ? m[1] : '/shop/';
    }

    /* ─── Init on DOM ready ──────────────────────────────── */
    function init() {
        const basePath = getBasePath();

        // Desktop search form
        const desktopForm = document.querySelector('.sh-search');
        if (desktopForm) initSearch(desktopForm, basePath);

        // Mobile search form
        const mobileForm = document.querySelector('.sh-mobile-search');
        if (mobileForm) initSearch(mobileForm, basePath);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
