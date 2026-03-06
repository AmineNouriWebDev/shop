<div style="padding: 1rem 0;">

    <!-- Ligne 1 : Welcome & Actions Rapides -->
    <div class="tw-section" style="padding-top: 0; padding-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 class="section-title" style="font-size: 1.75rem;">Bienvenue sur votre tableau de bord</h1>
                <p class="section-subtitle" style="font-size: 0.95rem; margin-top: 0.25rem;">Voici un résumé de l'activité de votre boutique.</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="index.php?r=nproduits" class="admin-btn admin-btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 16px; height: 16px;">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
                    </svg>
                    Nouveau Produit
                </a>
                <a href="index.php?r=commandes" class="admin-btn admin-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 16px; height: 16px;">
                        <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"/>
                    </svg>
                    Voir les commandes
                </a>
            </div>
        </div>
    </div>

    <!-- Ligne 2 : KPI Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <!-- KPI 1 : CA Mois -->
        <div class="kpi-card" style="animation-delay: 0.1s;">
            <div class="kpi-icon-wrap" style="background: var(--color-primary-light); color: var(--color-primary);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px; height: 24px;">
                    <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 19.125V4.875Zm3.375 1.125a.75.75 0 0 0 0 1.5h14.25a.75.75 0 0 0 0-1.5H4.875ZM3 9.375c0-.414.336-.75.75-.75h16.5c.414 0 .75.336.75.75v8.25c0 .414-.336.75-.75.75H3.75a.75.75 0 0 1-.75-.75v-8.25Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <div class="kpi-value" id="kpi-ca">0 <span style="font-size:1rem;color:var(--color-text-muted);">TND</span></div>
                <div class="kpi-label">Chiffre d'affaires ce mois</div>
            </div>
        </div>

        <!-- KPI 2 : Commandes Jour -->
        <div class="kpi-card" style="animation-delay: 0.2s;">
            <div class="kpi-icon-wrap" style="background: var(--color-success-light); color: var(--color-success);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px; height: 24px;">
                    <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <div class="kpi-value" id="kpi-cmd-jour">0</div>
                <div class="kpi-label">Commandes aujourd'hui</div>
                <div class="kpi-trend neutral" id="kpi-cmd-total" style="font-size:0.65rem;">Total: 0</div>
            </div>
        </div>

        <!-- KPI 3 : Clients Actifs -->
        <div class="kpi-card" style="animation-delay: 0.3s;">
            <div class="kpi-icon-wrap" style="background: var(--color-info-light); color: var(--color-info);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px; height: 24px;">
                    <path d="M11.625 16.5a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                    <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6 16.5c.66 0 1.277-.19 1.797-.518l1.048 1.048a.75.75 0 0 0 1.06-1.06l-1.047-1.048A3.375 3.375 0 1 0 11.625 18Z" clip-rule="evenodd"/>
                    <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                </svg>
            </div>
            <div>
                <div class="kpi-value" id="kpi-clients">0</div>
                <div class="kpi-label">Clients Inscrits</div>
            </div>
        </div>

        <!-- KPI 4 : Produits Actifs -->
        <div class="kpi-card" style="animation-delay: 0.4s;">
            <div class="kpi-icon-wrap" style="background: var(--color-warning-light); color: var(--color-warning);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px; height: 24px;">
                    <path fill-rule="evenodd" d="M3 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 5.25Zm0 4.5A.75.75 0 0 1 3.75 9h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 9.75Zm0 4.5a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Zm0 4.5a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <div class="kpi-value" id="kpi-produits">0</div>
                <div class="kpi-label">Produits Actifs</div>
            </div>
        </div>

    </div>

    <!-- Ligne 3 : Charts & Activité -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        
        <!-- Graphique Ventes 30j -->
        <div class="admin-card" style="animation-delay: 0.5s;">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
                        <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd"/>
                    </svg>
                    Évolution du Chiffre d'Affaires (30 derniers jours)
                </div>
            </div>
            <div class="admin-card-body" style="position: relative; height: 320px;">
                <canvas id="chartVentes30j"></canvas>
            </div>
        </div>

        <!-- Répartition Statuts / Top Produits -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Chart Statuts -->
            <div class="admin-card" style="animation-delay: 0.6s;">
                <div class="admin-card-header">
                    <div class="admin-card-title">Répartition par Statut</div>
                </div>
                <div class="admin-card-body" style="position: relative; height: 180px;">
                    <canvas id="chartStatuts"></canvas>
                </div>
            </div>
            
            <!-- Top Produits (mini) -->
            <div class="admin-card" style="animation-delay: 0.7s; flex: 1;">
                <div class="admin-card-header">
                    <div class="admin-card-title">Produits Populaires</div>
                    <a href="index.php?r=produits" style="font-size: 0.75rem; color: var(--color-primary); text-decoration: none; font-weight: 600;">Voir tout</a>
                </div>
                <div class="admin-card-body" style="padding: 0;">
                    <div id="topProduitsList" style="display: flex; flex-direction: column;">
                        <!-- JS injected -->
                        <div style="padding: 1.5rem; text-align: center; color: var(--color-text-muted); font-size: 0.8125rem;">Chargement...</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Ligne 4 : Tableaux Récents -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">

        <!-- Dernières Commandes -->
        <div class="admin-card" style="animation-delay: 0.8s;">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
                        <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25Z"/>
                    </svg>
                    Dernières Commandes
                </div>
                <a href="index.php?r=commandes" class="admin-btn admin-btn-sm admin-btn-ghost">Toutes les commandes</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableRecentCommandes">
                        <tr><td colspan="6" style="text-align:center;color:var(--color-text-muted);">Chargement...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Derniers Messages -->
        <div class="admin-card" style="animation-delay: 0.9s;">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
                        <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97Z" clip-rule="evenodd"/>
                    </svg>
                    Derniers Messages
                </div>
            </div>
            <div class="admin-card-body" style="padding: 1rem;">
                <div id="listRecentMessages" style="display: flex; flex-direction: column; gap: 0;">
                    <div style="text-align:center;color:var(--color-text-muted);">Chargement...</div>
                </div>
                <div style="margin-top: 1rem; text-align: center;">
                    <a href="index.php?r=messages" style="font-size: 0.75rem; color: var(--color-primary); text-decoration: none; font-weight: 600;">Voir tous les messages</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ============================================================
     GESTION DU DASHBOARD EN JS (Fetch API + Chart.js)
     ============================================================ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Style commun Chart.js base sur le CSS existant (les tokens dark adapteront ca idealement, mais pour faire simple on rend opaque/transparent avec les variables)
    Chart.defaults.color = '#9B96BB';
    Chart.defaults.font.family = "'Inter', sans-serif";

    function getStatusBadgeClass(id_etat) {
        // Adapté aux libellés typiques : 1: attente, 2: confirmé, 3: expédié, 4: livré, 5: annulé
        if(id_etat == 1) return 'pending';
        if(id_etat == 2) return 'confirmed';
        if(id_etat == 3) return 'shipped';
        if(id_etat == 4) return 'delivered';
        if(id_etat == 5) return 'cancelled';
        return 'confirmed';
    }

    // Appel à l'API unique
    fetch('api/dashboard.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Erreur API Dashboard: ", data.error);
                return;
            }

            // --- 1. POPULATE KPIs ---
            document.getElementById('kpi-ca').innerHTML = (data.kpis.ca_mois || 0) + ' <span style="font-size:1rem;color:var(--color-text-muted);">TND</span>';
            document.getElementById('kpi-cmd-jour').textContent = data.kpis.commandes_jour || 0;
            document.getElementById('kpi-cmd-total').textContent = 'Total historique: ' + (data.kpis.total_commandes || 0);
            document.getElementById('kpi-clients').textContent = data.kpis.clients_actifs || 0;
            document.getElementById('kpi-produits').textContent = data.kpis.produits_actifs || 0;

            // --- 2. DERNIERES COMMANDES ---
            const tbodyCmd = document.getElementById('tableRecentCommandes');
            tbodyCmd.innerHTML = '';
            if (data.recent_commandes && data.recent_commandes.length > 0) {
                data.recent_commandes.forEach(cmd => {
                    const badgeCls = getStatusBadgeClass(cmd.id_etat);
                    tbodyCmd.innerHTML += `
                        <tr>
                            <td style="font-weight:600;">#${cmd.id}</td>
                            <td>${cmd.client}</td>
                            <td style="color:var(--color-text-muted);font-size:0.8125rem;">${cmd.date}</td>
                            <td style="font-weight:700;">${cmd.total} TND</td>
                            <td><span class="status-badge ${badgeCls}">${cmd.etat}</span></td>
                            <td style="text-align: right;">
                                <a href="index.php?r=dcommande&id=${cmd.id}" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding:0.2rem 0.5rem;font-size:0.75rem;">Voir</a>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbodyCmd.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:2rem;">Aucune commande trouvée</td></tr>';
            }

            // --- 3. TOP PRODUITS ---
            const divTop = document.getElementById('topProduitsList');
            divTop.innerHTML = '';
            if (data.top_produits && data.top_produits.length > 0) {
                data.top_produits.forEach(p => {
                    divTop.innerHTML += `
                        <div style="display:flex;align-items:center;gap:1rem;padding:0.75rem 1.25rem;border-bottom:1px solid var(--color-border);transition:background 150ms;">
                            <img src="../media/produits/${p.photo}" alt="Produit" style="width:40px;height:40px;object-fit:cover;border-radius:0.5rem;border:1px solid var(--color-border);">
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:0.8125rem;font-weight:600;color:var(--color-text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${p.titre}</div>
                                <div style="font-size:0.75rem;color:var(--color-text-muted);margin-top:2px;">${p.qte_vendue} ventes</div>
                            </div>
                            <div style="font-size:0.8125rem;font-weight:700;color:var(--color-primary);">${p.revenu} TND</div>
                        </div>
                    `;
                });
            } else {
                divTop.innerHTML = '<div style="padding: 1.5rem; text-align: center; color: var(--color-text-muted); font-size: 0.8125rem;">Aucune donnée</div>';
            }

            // --- 4. DERNIERS MESSAGES ---
            const divMsg = document.getElementById('listRecentMessages');
            divMsg.innerHTML = '';
            if (data.recent_messages && data.recent_messages.length > 0) {
                data.recent_messages.forEach(msg => {
                    divMsg.innerHTML += `
                        <a href="index.php?r=messages" class="timeline-item" style="text-decoration:none;">
                            <div class="timeline-dot" style="background:var(--color-info-light);color:var(--color-info);">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;"><path fill-rule="evenodd" d="M17.834 6.166a8.25 8.25 0 1 0-11.668 11.668l-2.6 2.6a.75.75 0 0 0 1.061 1.06l2.6-2.6a8.25 8.25 0 1 0 10.607-12.728Z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="timeline-content">
                                <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:0.125rem;">
                                    <div style="font-size:0.8125rem;font-weight:600;color:var(--color-text-primary);">${msg.expediteur}</div>
                                    <div style="font-size:0.7rem;color:var(--color-text-muted);">${msg.date}</div>
                                </div>
                                <div style="font-size:0.8rem;color:var(--color-text-muted);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${msg.sujet}</div>
                            </div>
                        </a>
                    `;
                });
            } else {
                divMsg.innerHTML = '<div style="text-align:center;color:var(--color-text-muted);font-size:0.8125rem;padding:1rem;">Aucun message</div>';
            }

            // --- 5. CHART VENTES 30J ---
            const ctx30j = document.getElementById('chartVentes30j');
            if (ctx30j && data.charts.ventes_30j) {
                new Chart(ctx30j, {
                    type: 'line',
                    data: {
                        labels: data.charts.ventes_30j.labels,
                        datasets: [{
                            label: 'Chiffre d\'Affaires (TND)',
                            data: data.charts.ventes_30j.data,
                            borderColor: '#5A31F4',
                            backgroundColor: 'rgba(90, 49, 244, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4, // courbe lisse
                            pointRadius: 2,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(28, 25, 48, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { maxTicksLimit: 10 }
                            },
                            y: {
                                beginAtZero: true,
                                border: { display: false },
                                grid: { color: 'rgba(107, 95, 160, 0.1)' }
                            }
                        }
                    }
                });
            }

            // --- 6. CHART STATUTS ---
            const ctxStatuts = document.getElementById('chartStatuts');
            if (ctxStatuts && data.charts.repartition_statuts) {
                new Chart(ctxStatuts, {
                    type: 'doughnut',
                    data: {
                        labels: data.charts.repartition_statuts.labels,
                        datasets: [{
                            data: data.charts.repartition_statuts.data,
                            backgroundColor: [
                                '#10B981', // Delivered (Success)
                                '#5A31F4', // Shipped (Primary)
                                '#0EA5E9', // Confirmed (Info)
                                '#F59E0B', // Pending (Warning)
                                '#EF4444'  // Cancelled (Error)
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 10,
                                    usePointStyle: true,
                                    font: { size: 11 }
                                }
                            }
                        }
                    }
                });
            }

        })
        .catch(err => console.error("Erreur de récupération dashboard:", err));

});
</script>
