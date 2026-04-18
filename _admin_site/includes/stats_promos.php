<?php
/**
 * includes/stats_promos.php — Page Analytics des Promotions
 * Statistiques détaillées pour analyser la performance des promotions.
 */
?>
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config = { corePlugins: { preflight: false }, darkMode: 'class' }</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ── Stat Cards ── */
.promo-stat-card {
    background: var(--color-bg, #fff);
    border: 1px solid var(--color-border, #e2e8f0);
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: box-shadow 200ms, transform 200ms;
    position: relative;
    overflow: hidden;
}
.promo-stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.12); transform: translateY(-2px); }
.promo-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}
.promo-stat-card.purple::before { background: linear-gradient(90deg, #7C3AED, #A78BFA); }
.promo-stat-card.orange::before { background: linear-gradient(90deg, #F97316, #FBBF24); }
.promo-stat-card.green::before  { background: linear-gradient(90deg, #10B981, #34D399); }
.promo-stat-card.blue::before   { background: linear-gradient(90deg, #0EA5E9, #38BDF8); }
.promo-stat-card.rose::before   { background: linear-gradient(90deg, #F43F5E, #FB7185); }

.promo-stat-icon {
    width: 52px; height: 52px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; flex-shrink: 0;
}
.promo-stat-icon.purple { background: rgba(124,58,237,0.12); }
.promo-stat-icon.orange { background: rgba(249,115,22,0.12); }
.promo-stat-icon.green  { background: rgba(16,185,129,0.12); }
.promo-stat-icon.blue   { background: rgba(14,165,233,0.12); }
.promo-stat-icon.rose   { background: rgba(244,63,94,0.12); }

.promo-stat-value { font-size: 1.6rem; font-weight: 800; line-height: 1; margin-bottom: 4px; }
.promo-stat-label { font-size: 0.8rem; font-weight: 500; opacity: 0.65; }
.promo-stat-sub   { font-size: 0.75rem; margin-top: 4px; opacity: 0.55; }

/* ── Period Filter ── */
.period-btn {
    padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
    cursor: pointer; border: 1px solid rgba(0,0,0,0.15);
    background: transparent; color: inherit; transition: all 150ms;
}
.period-btn.active { background: var(--color-primary, #5A31F4); color: #fff; border-color: transparent; }
.period-btn:not(.active):hover { background: rgba(0,0,0,0.06); }

/* ── Photo thumb in tables ── */
.prod-thumb { width: 38px; height: 38px; border-radius: 8px; object-fit: cover; border: 1px solid var(--color-border, #e2e8f0); }

/* ── Badge ── */
.flash-badge { background: rgba(249,115,22,0.15); color: #c2410c; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; }
.classic-badge { background: rgba(14,165,233,0.15); color: #0369a1; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; }
.expiring-badge { background: rgba(244,63,94,0.15); color: #be123c; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; }
.ok-badge { background: rgba(16,185,129,0.15); color: #047857; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; }

/* ── Alert boxes ── */
.alert-box { border-radius: 10px; padding: 10px 16px; display: flex; align-items: flex-start; gap: 10px; margin-bottom: 1rem; border: 1px solid; }
.alert-box.warning { background: rgba(245,158,11,0.1); border-color: rgba(245,158,11,0.3); }
.alert-box.danger  { background: rgba(239,68,68,0.1);  border-color: rgba(239,68,68,0.3); }

/* ── Discount bar ── */
.discount-bar { height: 6px; border-radius: 3px; background: rgba(0,0,0,0.08); overflow: hidden; margin-top: 5px; }
.discount-bar-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg, #7C3AED, #A78BFA); }

/* ── Countdown ── */
.countdown-chip { font-family: monospace; background: rgba(239,68,68,0.1); color: #dc2626; padding: 2px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; }
</style>

<div style="padding: 1.5rem 1rem;">

    <!-- HEADER -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.6rem; font-weight: 800; letter-spacing: -0.03em;">
                📊 Statistiques des Promotions
            </h2>
            <p style="margin: 4px 0 0; opacity: 0.6; font-size: 0.875rem;">
                Analysez la performance de vos promotions pour prendre de meilleures décisions marketing.
            </p>
        </div>
        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <a href="index.php?r=promotions_articles" class="admin-btn admin-btn-ghost" style="font-size: 0.8rem;">
                🏷️ Gérer les promos
            </a>
            <div style="display: flex; gap: 4px; border: 1px solid var(--color-border); border-radius: 24px; padding: 3px;">
                <button class="period-btn active" data-period="7"   onclick="switchPeriod(7, this)">7j</button>
                <button class="period-btn"         data-period="30"  onclick="switchPeriod(30, this)">30j</button>
                <button class="period-btn"         data-period="90"  onclick="switchPeriod(90, this)">90j</button>
            </div>
        </div>
    </div>

    <!-- LOADING INDICATOR -->
    <div id="ps-loading" style="text-align: center; padding: 3rem; display: none;">
        <div class="tw-wrap">
            <div class="animate-spin mx-auto mb-3" style="width: 40px; height: 40px; border: 3px solid rgba(90,49,244,0.2); border-top-color: #5A31F4; border-radius: 50%;"></div>
            <p style="opacity: 0.5;">Chargement des statistiques...</p>
        </div>
    </div>

    <!-- ═══════════ KPI CARDS ═══════════ -->
    <div id="ps-kpis" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;"></div>

    <!-- ALERTES RAPIDES -->
    <div id="ps-alerts" style="margin-bottom: 2rem;"></div>

    <!-- ═══════════ Graphiques (2 colonnes) ═══════════ -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">

        <!-- Graphique CA Promo vs Total -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    📈 Évolution CA — Produits en Promo vs CA Total
                </div>
            </div>
            <div class="admin-card-body" style="position: relative; height: 300px;">
                <canvas id="chartPromoVsTotal"></canvas>
                <div id="chartPromoVsTotalEmpty" style="display:none; text-align:center; padding:2rem; opacity:0.5; font-size:0.875rem;">Pas de données sur cette période</div>
            </div>
        </div>

        <!-- Donut Flash vs Classique -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    🍩 Ventes Flash vs Classique
                </div>
            </div>
            <div class="admin-card-body" style="position: relative; height: 300px;">
                <canvas id="chartDonutFlash"></canvas>
                <div id="chartDonutEmpty" style="display:none; text-align:center; padding:2rem; opacity:0.5; font-size:0.875rem;">Aucune vente promo sur cette période</div>
            </div>
        </div>
    </div>

    <!-- ═══════════ Tableaux (2 colonnes) ═══════════ -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">

        <!-- TOP Produits en promo -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">🏆 Top produits en promotion (les mieux vendus)</div>
                <a href="index.php?r=promotions_articles" style="font-size: 0.75rem; color: var(--color-primary); text-decoration: none; font-weight: 600; white-space: nowrap;">Gérer →</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="admin-table" id="table-top-promos">
                    <thead>
                        <tr>
                            <th style="width: 44px;">#</th>
                            <th>Produit</th>
                            <th style="text-align:center;">Remise</th>
                            <th style="text-align:right;">Ventes</th>
                            <th style="text-align:right;">CA généré</th>
                            <th style="text-align:right;">Économies</th>
                            <th style="text-align:center;">Mode</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-top-promos">
                        <tr><td colspan="7" style="text-align:center; padding:2rem; opacity:0.5;">Chargement...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar droite : Expire bientôt & Promos sans vente -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- Expire bientôt -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-title" style="font-size: 0.875rem;">⏰ Expirent dans 48h</div>
                </div>
                <div id="list-expiring" style="padding: 0.5rem;">
                    <p style="text-align:center; padding:1rem; opacity:0.5; font-size:0.8rem;">Chargement...</p>
                </div>
            </div>

            <!-- Promos sans vente -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-title" style="font-size: 0.875rem;">⚠️ Sans vente depuis 7j</div>
                </div>
                <div id="list-nosale" style="padding: 0.5rem;">
                    <p style="text-align:center; padding:1rem; opacity:0.5; font-size:0.8rem;">Chargement...</p>
                </div>
            </div>

        </div>
    </div>

    <!-- CODES PROMO PERFORMANCE -->
    <div class="admin-card" style="margin-bottom: 2rem;">
        <div class="admin-card-header">
            <div class="admin-card-title">🎫 Performance des codes promo</div>
            <a href="index.php?r=codes_promo" style="font-size: 0.75rem; color: var(--color-primary); text-decoration: none; font-weight: 600;">Gérer →</a>
        </div>
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th style="text-align:center;">Remise</th>
                        <th style="text-align:center;">Utilisations</th>
                        <th style="text-align:center;">Expiration</th>
                        <th style="text-align:center;">Statut</th>
                    </tr>
                </thead>
                <tbody id="tbody-codes">
                    <tr><td colspan="5" style="text-align:center; padding:2rem; opacity:0.5;">Chargement...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.color = '#9B96BB';
    Chart.defaults.font.family = "'Inter', sans-serif";

    let currentPeriod = 7;
    let chartPromo = null;
    let chartDonut = null;

    // ─── Load stats ───
    function loadStats(period) {
        document.getElementById('ps-loading').style.display = 'block';

        fetch('api/promo_stats.php?period=' + period + '&_=' + Date.now())
            .then(r => r.json())
            .then(data => {
                document.getElementById('ps-loading').style.display = 'none';
                if (data.error) { console.error(data.error); return; }
                renderKPIs(data.kpis, period);
                renderAlerts(data.expiring_soon, data.no_sale_promos);
                renderTopPromos(data.top_promos);
                renderExpiring(data.expiring_soon);
                renderNoSale(data.no_sale_promos);
                renderCodes(data.codes_perf);
                renderChartLine(data.charts.ca_promo_vs_total);
                renderChartDonut(data.charts.donut_flash);
            })
            .catch(err => {
                document.getElementById('ps-loading').style.display = 'none';
                console.error(err);
            });
    }

    // ─── KPI Cards ───
    function renderKPIs(kpis, period) {
        const container = document.getElementById('ps-kpis');
        const tauxColor = kpis.taux_promo >= 30 ? '#10B981' : (kpis.taux_promo >= 10 ? '#F97316' : '#6B7280');
        container.innerHTML = `
            <div class="promo-stat-card purple">
                <div class="promo-stat-icon purple">🏷️</div>
                <div>
                    <div class="promo-stat-value" style="color:#7C3AED;">${kpis.promos_actives}</div>
                    <div class="promo-stat-label">Promotions actives</div>
                    <div class="promo-stat-sub">${kpis.flash_actifs} ventes flash</div>
                </div>
            </div>
            <div class="promo-stat-card orange">
                <div class="promo-stat-icon orange">⚡</div>
                <div>
                    <div class="promo-stat-value" style="color:#F97316;">${kpis.flash_actifs}</div>
                    <div class="promo-stat-label">Ventes Flash actives</div>
                </div>
            </div>
            <div class="promo-stat-card green">
                <div class="promo-stat-icon green">💰</div>
                <div>
                    <div class="promo-stat-value" style="color:#10B981; font-size:1.35rem;">${kpis.ca_promo_periode.toLocaleString('fr-FR', {minimumFractionDigits:3})} TND</div>
                    <div class="promo-stat-label">CA produits en promo (${period}j)</div>
                    <div class="promo-stat-sub" style="color:${tauxColor}; font-weight:600;">${kpis.taux_promo}% du CA total</div>
                </div>
            </div>
            <div class="promo-stat-card blue">
                <div class="promo-stat-icon blue">🎁</div>
                <div>
                    <div class="promo-stat-value" style="color:#0EA5E9; font-size:1.35rem;">${kpis.economies_clients.toLocaleString('fr-FR', {minimumFractionDigits:3})} TND</div>
                    <div class="promo-stat-label">Économies accordées (${period}j)</div>
                </div>
            </div>
            <div class="promo-stat-card rose">
                <div class="promo-stat-icon rose">🎫</div>
                <div>
                    <div class="promo-stat-value" style="color:#F43F5E;">${kpis.codes_promo_actifs}</div>
                    <div class="promo-stat-label">Codes promo actifs</div>
                </div>
            </div>
        `;
    }

    // ─── Alert boxes ───
    function renderAlerts(expiring, nosale) {
        const container = document.getElementById('ps-alerts');
        let html = '';
        if (expiring && expiring.length > 0) {
            html += `<div class="alert-box warning">
                <span style="font-size:1.25rem;">⏰</span>
                <div>
                    <strong>${expiring.length} promotion(s) expirent dans moins de 48h !</strong>
                    <div style="font-size:0.8rem; margin-top:4px; opacity:0.8;">
                        ${expiring.map(p => '<a href="index.php?r=mproduits&id='+p.id+'" style="color:inherit; font-weight:600;">'+p.titre+'</a>').join(', ')}
                    </div>
                </div>
            </div>`;
        }
        if (nosale && nosale.length > 0) {
            html += `<div class="alert-box danger">
                <span style="font-size:1.25rem;">⚠️</span>
                <div>
                    <strong>${nosale.length} promotion(s) sans aucune vente depuis 7 jours</strong> — Envisagez de les retirer ou d'augmenter la remise.
                    <div style="font-size:0.8rem; margin-top:4px; opacity:0.8;">
                        ${nosale.map(p => '<a href="index.php?r=mproduits&id='+p.id+'" style="color:inherit; font-weight:600;">'+p.titre+'</a>').join(', ')}
                    </div>
                </div>
            </div>`;
        }
        container.innerHTML = html;
    }

    // ─── Top Promos table ───
    function renderTopPromos(items) {
        const tbody = document.getElementById('tbody-top-promos');
        if (!items || items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:2rem; opacity:0.5;">Aucune vente de produits en promotion sur cette période</td></tr>';
            return;
        }
        tbody.innerHTML = items.map((p, i) => {
            const photo = p.photo ? `<img src="../media/products/${p.photo}" class="prod-thumb" alt="">` : '<div style="width:38px;height:38px;border-radius:8px;background:rgba(0,0,0,0.05);"></div>';
            const badge = p.is_flash ? '<span class="flash-badge">⚡ Flash</span>' : '<span class="classic-badge">🏷️ Promo</span>';
            const medal = i === 0 ? '🥇' : (i === 1 ? '🥈' : (i === 2 ? '🥉' : '#'+(i+1)));
            return `<tr>
                <td style="font-weight:700; text-align:center;">${medal}</td>
                <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                        ${photo}
                        <div>
                            <a href="index.php?r=mproduits&id=${p.id}" style="font-weight:600; font-size:0.875rem; color:inherit; text-decoration:none;">${p.titre}</a>
                            <div style="font-size:0.7rem; opacity:0.55; margin-top:2px;">
                                <s>${p.prix_vente.toFixed(3)} TND</s> → <strong style="color:#10B981;">${p.prix_promo.toFixed(3)} TND</strong>
                            </div>
                            <div class="discount-bar" style="width: 100px;">
                                <div class="discount-bar-fill" style="width:${p.remise_pct}%;"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td style="text-align:center;">
                    <span style="font-weight:800; font-size:1rem; color:#7C3AED;">-${p.remise_pct}%</span>
                </td>
                <td style="text-align:right; font-weight:700;">${p.qte_vendue} ventes</td>
                <td style="text-align:right; font-weight:700; color:#10B981;">${p.ca_genere.toFixed(3)} TND</td>
                <td style="text-align:right; color:#F97316;">${p.economies_donnees.toFixed(3)} TND</td>
                <td style="text-align:center;">${badge}</td>
            </tr>`;
        }).join('');
    }

    // ─── Expiring soon ───
    function renderExpiring(items) {
        const container = document.getElementById('list-expiring');
        if (!items || items.length === 0) {
            container.innerHTML = '<p style="text-align:center; padding:1rem; opacity:0.5; font-size:0.8rem;">✅ Aucune promo n\'expire dans les 48h</p>';
            return;
        }
        container.innerHTML = items.map(p => {
            const end = new Date(p.end_ts * 1000);
            const now = new Date();
            const rem = Math.max(0, Math.round((end - now) / 1000));
            const h = Math.floor(rem / 3600);
            const m = Math.floor((rem % 3600) / 60);
            return `<div style="display:flex; align-items:center; gap:8px; padding:8px; border-bottom:1px solid var(--color-border); last:border-0;">
                <img src="../media/products/${p.photo}" class="prod-thumb" alt="" onerror="this.style.display='none'">
                <div style="flex:1; min-width:0;">
                    <div style="font-size:0.8rem; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${p.titre}</div>
                    <span class="countdown-chip" data-end="${p.end_ts}">${h}h ${m}m restant</span>
                </div>
                <a href="index.php?r=promotions_articles" style="padding:4px 8px; font-size:0.7rem; background:var(--color-primary); color:#fff; border-radius:6px; text-decoration:none; white-space:nowrap;">Gérer</a>
            </div>`;
        }).join('');
        // Start countdown ticks
        startCountdowns();
    }

    // ─── No-sale promos ───
    function renderNoSale(items) {
        const container = document.getElementById('list-nosale');
        if (!items || items.length === 0) {
            container.innerHTML = '<p style="text-align:center; padding:1rem; opacity:0.5; font-size:0.8rem;">🎉 Toutes vos promos ont eu des ventes récentes !</p>';
            return;
        }
        container.innerHTML = items.map(p => {
            const badge = p.is_flash ? '<span class="flash-badge">⚡</span>' : '<span class="classic-badge">🏷️</span>';
            return `<div style="display:flex; align-items:center; gap:8px; padding:8px; border-bottom:1px solid var(--color-border);">
                <img src="../media/products/${p.photo}" class="prod-thumb" alt="" onerror="this.style.display='none'">
                <div style="flex:1; min-width:0;">
                    <div style="font-size:0.8rem; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${p.titre}</div>
                    <div style="font-size:0.7rem; margin-top:2px; opacity:0.6;">
                        ${badge} <s>${p.prix_vente.toFixed(3)}</s> → <strong>${p.prix_promo.toFixed(3)} TND</strong> (-${p.remise_pct}%)
                    </div>
                </div>
                <a href="index.php?r=promotions_articles&action=stop_promo&id=${p.id}" 
                   onclick="return confirm('Arrêter la promo de \\'${p.titre.replace(/'/g,"\\'")}\\' ?');"
                   style="padding:4px 8px; font-size:0.7rem; background:rgba(239,68,68,0.1); color:#dc2626; border-radius:6px; text-decoration:none; white-space:nowrap; border:1px solid rgba(239,68,68,0.2);">
                    Arrêter
                </a>
            </div>`;
        }).join('');
    }

    // ─── Codes promo performance ───
    function renderCodes(codes) {
        const tbody = document.getElementById('tbody-codes');
        if (!codes || codes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:1.5rem; opacity:0.5;">Aucun code promo créé</td></tr>';
            return;
        }
        tbody.innerHTML = codes.map(c => {
            const valeurTxt = c.type === 'percent' ? `-${c.valeur}%` : `-${parseFloat(c.valeur).toFixed(3)} TND`;
            const now = Date.now()/1000;
            const expired = c.expire_ts && c.expire_ts < now;
            const statusBadge = !c.etat ? '<span class="expiring-badge">Désactivé</span>'
                              : expired  ? '<span class="expiring-badge">Expiré</span>'
                              : '<span class="ok-badge">✓ Actif</span>';
            const expTxt = c.date_expiration ? new Date(c.expire_ts*1000).toLocaleDateString('fr-FR') : 'Illimitée';
            const usagesBar = c.nb_utilisations > 0 ? `<div title="${c.nb_utilisations} utilisations" style="display:inline-block; background:rgba(90,49,244,0.1); color:#5A31F4; font-weight:700; padding:2px 8px; border-radius:10px; font-size:0.8rem;">${c.nb_utilisations}×</div>` : '<span style="opacity:0.4;">0</span>';
            const libTxt = c.libelle ? `<br><small style="opacity:0.55; font-size:0.7rem;">${c.libelle}</small>` : '';
            return `<tr>
                <td><code style="font-weight:700; font-size:0.875rem; letter-spacing:0.05em;">${c.code}</code>${libTxt}</td>
                <td style="text-align:center; font-weight:700; font-size:0.875rem; color:#7C3AED;">${valeurTxt}</td>
                <td style="text-align:center;">${usagesBar}</td>
                <td style="text-align:center; font-size:0.8rem; opacity:0.7;">${expTxt}</td>
                <td style="text-align:center;">${statusBadge}</td>
            </tr>`;
        }).join('');
    }


    // ─── Chart CA Promo vs Total ───
    function renderChartLine(chartData) {
        const ctx = document.getElementById('chartPromoVsTotal');
        const emptyEl = document.getElementById('chartPromoVsTotalEmpty');
        if (chartPromo) { chartPromo.destroy(); chartPromo = null; }

        if (!chartData || !chartData.labels || chartData.labels.length === 0) {
            ctx.style.display = 'none'; emptyEl.style.display = 'block'; return;
        }
        ctx.style.display = 'block'; emptyEl.style.display = 'none';

        chartPromo = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'CA Total (TND)',
                        data: chartData.total,
                        borderColor: 'rgba(14,165,233,0.7)',
                        backgroundColor: 'rgba(14,165,233,0.08)',
                        borderWidth: 2, fill: true, tension: 0.4, pointRadius: 2, pointHoverRadius: 5,
                        borderDash: [4,3]
                    },
                    {
                        label: 'CA Produits Promo (TND)',
                        data: chartData.promo,
                        borderColor: '#7C3AED',
                        backgroundColor: 'rgba(124,58,237,0.15)',
                        borderWidth: 3, fill: true, tension: 0.4, pointRadius: 2, pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, font: { size: 11 } } },
                    tooltip: {
                        backgroundColor: 'rgba(15,10,40,0.92)', titleColor: '#fff', bodyColor: '#ddd',
                        padding: 12, cornerRadius: 10,
                        callbacks: { label: ctx => ` ${ctx.dataset.label}: ${parseFloat(ctx.raw).toFixed(3)} TND` }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { maxTicksLimit: 12 } },
                    y: { beginAtZero: true, border: { display: false }, grid: { color: 'rgba(107,95,160,0.1)' } }
                }
            }
        });
    }

    // ─── Chart Donut ───
    function renderChartDonut(donut) {
        const ctx = document.getElementById('chartDonutFlash');
        const emptyEl = document.getElementById('chartDonutEmpty');
        if (chartDonut) { chartDonut.destroy(); chartDonut = null; }

        const total = donut && donut.data ? donut.data.reduce((a,b) => a+b, 0) : 0;
        if (!donut || total === 0) {
            ctx.style.display = 'none'; emptyEl.style.display = 'block'; return;
        }
        ctx.style.display = 'block'; emptyEl.style.display = 'none';

        chartDonut = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: donut.labels,
                datasets: [{
                    data: donut.data,
                    backgroundColor: ['#F97316', '#7C3AED'],
                    borderWidth: 0, hoverOffset: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '72%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 12 } } },
                    tooltip: {
                        callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw} ventes` }
                    }
                }
            }
        });
    }

    // ─── Countdown ticks ───
    function startCountdowns() {
        setInterval(() => {
            document.querySelectorAll('.countdown-chip[data-end]').forEach(el => {
                const end = parseInt(el.getAttribute('data-end'));
                const rem = Math.max(0, Math.round(end - Date.now()/1000));
                if (rem === 0) { el.textContent = '⏰ Expiré!'; return; }
                const h = Math.floor(rem/3600);
                const m = Math.floor((rem%3600)/60);
                const s = rem % 60;
                el.textContent = `${h}h ${m}m ${s}s`;
            });
        }, 1000);
    }

    // ─── Period switch ───
    window.switchPeriod = function(period, btn) {
        currentPeriod = period;
        document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        // Bust cache pour forcer rechargement avec nouveau paramètre
        fetch('api/promo_stats.php?period=' + period + '&no_cache=1&_=' + Date.now(), { method: 'HEAD' }).catch(() => {});
        // Supprimer le cache côté PHP via paramètre
        loadStatsNoCache(period);
    };

    function loadStatsNoCache(period) {
        fetch('api/promo_stats.php?period=' + period + '&_=' + Date.now())
            .then(r => r.json())
            .then(data => {
                if (data.error) { console.error(data.error); return; }
                renderKPIs(data.kpis, period);
                renderAlerts(data.expiring_soon, data.no_sale_promos);
                renderTopPromos(data.top_promos);
                renderExpiring(data.expiring_soon);
                renderNoSale(data.no_sale_promos);
                renderCodes(data.codes_perf);
                renderChartLine(data.charts.ca_promo_vs_total);
                renderChartDonut(data.charts.donut_flash);
            });
    }

    // ─── Init ───
    loadStats(currentPeriod);
});
</script>
