/**
 * ============================================================
 * SHOP — Dark Mode Manager
 * ============================================================
 * ⚠️  Ce script doit être chargé en PREMIER dans <head>
 *     (avant tout CSS, avant tout autre script)
 *     pour éviter le FOUC (Flash of Unstyled Content).
 *
 * Usage HTML :
 *   <script src="dist/js/dark-mode.js"></script>  ← dans <head>
 *   <button id="dark-mode-toggle" onclick="window.__toggleTheme()">...</button>
 * ============================================================
 */

(function () {
    'use strict';

    var STORAGE_KEY = 'shop-color-scheme';
    var TRANSITION_CLASS = 'theme-transitioning';
    var TRANSITION_DURATION = 300; // ms — doit correspondre au CSS

    var root = document.documentElement;

    // ── Lire la préférence stockée ou la préférence système ──
    function getPreference() {
        var stored = localStorage.getItem(STORAGE_KEY);
        if (stored === 'dark' || stored === 'light') return stored;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // ── Appliquer le thème au <html> ──
    function applyTheme(theme, animate) {
        if (animate) {
            root.classList.add(TRANSITION_CLASS);
            setTimeout(function () {
                root.classList.remove(TRANSITION_CLASS);
            }, TRANSITION_DURATION);
        }

        if (theme === 'dark') {
            root.classList.add('dark');
        } else {
            root.classList.remove('dark');
        }

        root.setAttribute('data-theme', theme);
        updateMetaTheme(theme);
    }

    // ── Mettre à jour la meta theme-color (barre navigateur mobile) ──
    function updateMetaTheme(theme) {
        var meta = document.querySelector('meta[name="theme-color"]');
        if (!meta) {
            meta = document.createElement('meta');
            meta.name = 'theme-color';
            document.head.appendChild(meta);
        }
        meta.content = theme === 'dark' ? '#0D0B1A' : '#5A31F4';
    }

    // ── Mettre à jour l'UI du bouton toggle ──
    function updateToggleUI(theme) {
        var btn = document.getElementById('dark-mode-toggle');
        if (!btn) return;

        btn.setAttribute('aria-label',
            theme === 'dark' ? 'Passer en mode clair' : 'Passer en mode sombre'
        );
        btn.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        btn.setAttribute('data-theme', theme);
    }

    // ── API publique ──
    window.__setTheme = function (theme) {
        if (theme !== 'dark' && theme !== 'light') return;
        localStorage.setItem(STORAGE_KEY, theme);
        applyTheme(theme, true);
        updateToggleUI(theme);
        // Émettre un événement custom pour que d'autres scripts puissent réagir
        document.dispatchEvent(new CustomEvent('shop:themechange', {
            detail: { theme: theme },
            bubbles: true
        }));
    };

    window.__toggleTheme = function () {
        var current = root.getAttribute('data-theme') || getPreference();
        window.__setTheme(current === 'dark' ? 'light' : 'dark');
    };

    window.__getTheme = function () {
        return root.getAttribute('data-theme') || getPreference();
    };

    // ── Appliquer immédiatement (SANS animation au chargement) ──
    applyTheme(getPreference(), false);

    // ── Sync avec la préférence système si l'utilisateur n'a pas choisi manuellement ──
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
        if (!localStorage.getItem(STORAGE_KEY)) {
            applyTheme(e.matches ? 'dark' : 'light', true);
            updateToggleUI(e.matches ? 'dark' : 'light');
        }
    });

    // ── Mettre à jour l'UI du toggle une fois le DOM disponible ──
    document.addEventListener('DOMContentLoaded', function () {
        updateToggleUI(getPreference());
    });

})();
