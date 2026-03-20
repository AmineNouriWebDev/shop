<?php
/**
 * includes/export_ventes.php
 * Page Admin — Export relevé mensuel des ventes en XLSX (via SheetJS côté client)
 */
?>
<div class="row">
    <div class="col-12">

        <!-- En-tête de page -->
        <div class="admin-card" style="margin-bottom:1.5rem;">
            <div class="admin-card-body" style="padding:1.5rem 2rem;">
                <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:0.875rem;">
                        <div style="width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,#5a31f4,#0ea5e9);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(90,49,244,0.35);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px;color:#fff;">
                                <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 0-1.5 0v2.25H4.5V16.5a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size:1.1rem;font-weight:700;color:var(--color-text-primary);">Export — Relevé mensuel des ventes</div>
                            <div style="font-size:0.8125rem;color:var(--color-text-secondary);margin-top:2px;">Choisissez un mois et exportez en fichier <strong>.xlsx</strong></div>
                        </div>
                    </div>
                    <!-- Compteur de mois disponibles -->
                    <div id="nb-mois-badge" style="display:none;font-size:0.8125rem;color:var(--color-text-secondary);background:rgba(90,49,244,0.08);border:1px solid rgba(90,49,244,0.18);border-radius:20px;padding:0.25rem 0.875rem;">
                        <span id="nb-mois-count">0</span> mois avec données
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="gap:0;">

            <!-- ── Colonne gauche : Sélection + Export ── -->
            <div class="col-md-5" style="padding-right:0.75rem;">
                <div class="admin-card">
                    <div class="admin-card-body" style="padding:1.75rem;">

                        <h6 style="font-size:0.875rem;font-weight:600;color:var(--color-text-primary);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;color:var(--color-primary);">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/>
                            </svg>
                            Sélectionner le mois
                        </h6>

                        <!-- Loader mois -->
                        <div id="loader-mois" style="text-align:center;padding:2rem;color:var(--color-text-secondary);font-size:0.875rem;">
                            <div style="width:24px;height:24px;border:2px solid rgba(90,49,244,0.2);border-top-color:#5a31f4;border-radius:50%;animation:spin 0.7s linear infinite;margin:0 auto 0.75rem;"></div>
                            Chargement des mois disponibles…
                        </div>

                        <!-- Sélecteur mois -->
                        <div id="mois-selector" style="display:none;">
                            <select id="select-mois" class="admin-input" style="margin-bottom:1.25rem;">
                                <option value="">— Choisissez un mois —</option>
                            </select>

                            <!-- Aperçu mois sélectionné -->
                            <div id="preview-mois" style="display:none;background:rgba(90,49,244,0.06);border:1px solid rgba(90,49,244,0.18);border-radius:0.625rem;padding:1rem;margin-bottom:1.25rem;">
                                <div style="font-size:0.8rem;color:var(--color-text-secondary);margin-bottom:0.5rem;">Aperçu du mois sélectionné</div>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.625rem;">
                                    <div>
                                        <div style="font-size:0.72rem;color:var(--color-text-secondary);">Commandes payées</div>
                                        <div id="prev-nb" style="font-size:1.1rem;font-weight:700;color:var(--color-primary);">—</div>
                                    </div>
                                    <div>
                                        <div style="font-size:0.72rem;color:var(--color-text-secondary);">Chiffre d'affaires</div>
                                        <div id="prev-ca" style="font-size:1.1rem;font-weight:700;color:#10b981;">—</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton Export -->
                            <button id="btn-export" class="admin-btn" style="width:100%;background:linear-gradient(135deg,#5a31f4,#0ea5e9);color:#fff;border:none;padding:0.875rem;border-radius:0.625rem;font-weight:700;font-size:0.9rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:all 0.2s;box-shadow:0 4px 16px rgba(90,49,244,0.3);" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 0-1.5 0v2.25H4.5V16.5a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
                                </svg>
                                <span id="btn-export-text">Générer & Télécharger .xlsx</span>
                            </button>

                            <!-- Message erreur / succès -->
                            <div id="export-msg" style="display:none;margin-top:0.875rem;padding:0.625rem 0.875rem;border-radius:0.5rem;font-size:0.8125rem;text-align:center;"></div>
                        </div>

                        <!-- Aucune donnée -->
                        <div id="no-data" style="display:none;padding:2rem;text-align:center;color:var(--color-text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:36px;height:36px;color:rgba(90,49,244,0.25);margin-bottom:0.75rem;">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd"/>
                            </svg>
                            <div style="font-size:0.875rem;">Aucun mois avec commandes payées.</div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ── Colonne droite : Info contenu du fichier ── -->
            <div class="col-md-7" style="padding-left:0.75rem;">
                <div class="admin-card" style="height:100%;">
                    <div class="admin-card-body" style="padding:1.75rem;">
                        <h6 style="font-size:0.875rem;font-weight:600;color:var(--color-text-primary);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;color:var(--color-primary);">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5A.75.75 0 0 0 12 9Z" clip-rule="evenodd"/>
                            </svg>
                            Contenu du fichier exporté
                        </h6>

                        <!-- Onglets XLSX -->
                        <?php
                        $sheets = [
                            ['icon' => '📊', 'color' => '#5a31f4', 'titre' => 'Onglet 1 — Résumé', 'desc' => 'KPIs clés du mois : nombre de commandes payées, chiffre d\'affaires total, panier moyen, frais de livraison, clients uniques.'],
                            ['icon' => '🛒', 'color' => '#10b981', 'titre' => 'Onglet 2 — Détail commandes', 'desc' => 'Liste complète de toutes les commandes payées : N°, date, client, email, téléphone, sous-total, livraison, total.'],
                            ['icon' => '🏆', 'color' => '#f59e0b', 'titre' => 'Onglet 3 — Top produits', 'desc' => 'Classement des produits les plus vendus : rang, nom, quantité vendue et revenu généré.'],
                            ['icon' => '📅', 'color' => '#0ea5e9', 'titre' => 'Onglet 4 — CA par jour', 'desc' => 'Évolution quotidienne du chiffre d\'affaires : date, nombre de commandes et CA de chaque journée.'],
                        ];
                        foreach ($sheets as $s): ?>
                        <div style="display:flex;gap:0.875rem;padding:0.875rem;margin-bottom:0.625rem;background:rgba(0,0,0,0.02);border-radius:0.625rem;border-left:3px solid <?= $s['color'] ?>;">
                            <div style="font-size:1.375rem;flex-shrink:0;line-height:1;"><?= $s['icon'] ?></div>
                            <div>
                                <div style="font-size:0.8125rem;font-weight:600;color:var(--color-text-primary);margin-bottom:2px;"><?= $s['titre'] ?></div>
                                <div style="font-size:0.775rem;color:var(--color-text-secondary);"><?= $s['desc'] ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <div style="margin-top:1rem;padding:0.75rem;background:rgba(16,185,129,0.06);border-radius:0.5rem;font-size:0.775rem;color:var(--color-text-secondary);display:flex;gap:0.5rem;align-items:flex-start;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;color:#10b981;flex-shrink:0;margin-top:1px;">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                            </svg>
                            Seules les commandes au statut <strong>payé</strong> sont incluses dans le rapport.
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.row -->

    </div>
</div>

<!-- ── SheetJS CDN ── -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
#btn-export:not(:disabled):hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(90,49,244,0.45); }
#btn-export:disabled { opacity: 0.55; cursor: not-allowed; transform: none !important; }
</style>

<script>
(function() {
    const apiBase = 'api/export_ventes_data.php';
    const selectEl   = document.getElementById('select-mois');
    const btnExport  = document.getElementById('btn-export');
    const btnText    = document.getElementById('btn-export-text');
    const msgEl      = document.getElementById('export-msg');
    const prevNb     = document.getElementById('prev-nb');
    const prevCa     = document.getElementById('prev-ca');
    const previewEl  = document.getElementById('preview-mois');
    const badgeEl    = document.getElementById('nb-mois-badge');
    const badgeCount = document.getElementById('nb-mois-count');

    let moisData = []; // cache de la liste des mois

    // ── 1. Charger la liste des mois disponibles ──
    fetch(apiBase + '?mode=mois')
        .then(r => r.json())
        .then(liste => {
            document.getElementById('loader-mois').style.display = 'none';

            if (!liste || liste.length === 0) {
                document.getElementById('no-data').style.display = 'block';
                return;
            }

            moisData = liste;
            document.getElementById('mois-selector').style.display = 'block';
            badgeEl.style.display = 'inline-flex';
            badgeCount.textContent = liste.length;

            liste.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.value;
                opt.textContent = m.label + ' (' + m.nb + ' cmd' + (m.nb > 1 ? 's' : '') + ' — ' + parseFloat(m.ca).toLocaleString('fr-FR', {minimumFractionDigits:3}) + ' TND)';
                opt.dataset.nb = m.nb;
                opt.dataset.ca = m.ca;
                selectEl.appendChild(opt);
            });
        })
        .catch(() => {
            document.getElementById('loader-mois').innerHTML = '<span style="color:#ef4444;">Erreur de chargement des mois.</span>';
        });

    // ── 2. Mise à jour de l'aperçu lors du changement de mois ──
    selectEl.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if (!this.value) {
            previewEl.style.display = 'none';
            btnExport.disabled = true;
            return;
        }
        prevNb.textContent = opt.dataset.nb;
        prevCa.textContent = parseFloat(opt.dataset.ca).toLocaleString('fr-FR', {minimumFractionDigits:3}) + ' TND';
        previewEl.style.display = 'block';
        btnExport.disabled = false;
        msgEl.style.display = 'none';
    });

    // ── 3. Export XLSX ──
    btnExport.addEventListener('click', function() {
        if (!selectEl.value) return;
        const [annee, mois] = selectEl.value.split('-');
        const moisLabel = selectEl.options[selectEl.selectedIndex].text.split('(')[0].trim();

        btnExport.disabled = true;
        btnText.textContent = 'Génération en cours…';

        fetch(apiBase + '?mois=' + mois + '&annee=' + annee)
            .then(r => r.json())
            .then(data => {
                if (data.error) throw new Error(data.error);
                generateXLSX(data, moisLabel);
                showMsg('✅ Fichier téléchargé avec succès.', 'success');
            })
            .catch(err => {
                showMsg('❌ Erreur : ' + err.message, 'error');
            })
            .finally(() => {
                btnExport.disabled = false;
                btnText.textContent = 'Générer & Télécharger .xlsx';
            });
    });

    // ── 4. Génération du fichier XLSX via SheetJS ──
    function generateXLSX(data, moisLabel) {
        const wb = XLSX.utils.book_new();

        // ─ Onglet 1 : Résumé ─
        const resumeRows = [
            ['Relevé mensuel des ventes — ' + data.label],
            ['Généré le : ' + new Date().toLocaleDateString('fr-FR')],
            [],
            ['Indicateur', 'Valeur'],
        ];
        Object.entries(data.resume).forEach(([k, v]) => resumeRows.push([k, v]));
        const wsResume = XLSX.utils.aoa_to_sheet(resumeRows);
        // Style titre (largeur colonnes)
        wsResume['!cols'] = [{wch: 35}, {wch: 20}];
        wsResume['!merges'] = [{s:{r:0,c:0}, e:{r:0,c:1}}];
        XLSX.utils.book_append_sheet(wb, wsResume, '📊 Résumé');

        // ─ Onglet 2 : Commandes ─
        if (data.commandes.length > 0) {
            const wsCmds = XLSX.utils.json_to_sheet(data.commandes);
            wsCmds['!cols'] = [
                {wch:14},{wch:12},{wch:22},{wch:28},{wch:14},
                {wch:16},{wch:16},{wch:14},{wch:18}
            ];
            XLSX.utils.book_append_sheet(wb, wsCmds, '🛒 Commandes');
        } else {
            const emptySheet = XLSX.utils.aoa_to_sheet([['Aucune commande payée pour ce mois.']]);
            XLSX.utils.book_append_sheet(wb, emptySheet, '🛒 Commandes');
        }

        // ─ Onglet 3 : Top Produits ─
        if (data.top_produits.length > 0) {
            const wsTop = XLSX.utils.json_to_sheet(data.top_produits);
            wsTop['!cols'] = [{wch:6},{wch:40},{wch:18},{wch:16}];
            XLSX.utils.book_append_sheet(wb, wsTop, '🏆 Top Produits');
        } else {
            XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet([['Aucune donnée.']]), '🏆 Top Produits');
        }

        // ─ Onglet 4 : CA par jour ─
        if (data.par_jour.length > 0) {
            const wsJour = XLSX.utils.json_to_sheet(data.par_jour);
            wsJour['!cols'] = [{wch:14},{wch:18},{wch:20}];
            XLSX.utils.book_append_sheet(wb, wsJour, '📅 CA par jour');
        } else {
            XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet([['Aucune donnée.']]), '📅 CA par jour');
        }

        // ─ Téléchargement ─
        const filename = 'releve_ventes_' + data.annee + '-' + String(data.mois).padStart(2,'0') + '.xlsx';
        XLSX.writeFile(wb, filename);
    }

    function showMsg(text, type) {
        msgEl.textContent = text;
        msgEl.style.display = 'block';
        msgEl.style.background = type === 'success' ? 'rgba(16,185,129,0.1)' : 'rgba(239,68,68,0.1)';
        msgEl.style.color = type === 'success' ? '#059669' : '#dc2626';
        msgEl.style.border = '1px solid ' + (type === 'success' ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)');
    }
})();
</script>
