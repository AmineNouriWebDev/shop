<?php
/**
 * Admin Topbar — header.php
 * Refonte Tailwind CSS + Heroicons SVG inline
 */
$current_route = $_GET['r'] ?? '';

// Titre de page selon la route
$page_titles = [
    ''                  => 'Tableau de bord',
    'home'              => 'Tableau de bord',
    'commandes'         => 'Commandes',
    'dcommande'         => 'Détail commande',
    'etat_commandes'    => 'États des commandes',
    'clients'           => 'Clients',
    'nclient'           => 'Nouveau client',
    'mclient'           => 'Modifier client',
    'produits'          => 'Produits',
    'nproduits'         => 'Nouveau produit',
    'mproduits'         => 'Modifier produit',
    'abonnements'       => 'Abonnements',
    'nabonnements'      => 'Nouvel abonnement',
    'mabonnements'      => 'Modifier abonnement',
    'categories_blog'   => 'Catégories',
    'ncategorie_blog'   => 'Nouvelle catégorie',
    'mcategorie_blog'   => 'Modifier catégorie',
    'marques'           => 'Marques',
    'nmarque'           => 'Nouvelle marque',
    'mMarque'           => 'Modifier marque',
    'sliders'           => 'Animations accueil',
    'nslider'           => 'Nouveau slider',
    'mslider'           => 'Modifier slider',
    'pages'             => 'Pages',
    'npage'             => 'Nouvelle page',
    'mpage'             => 'Modifier page',
    'bloc_accueil'      => 'Blocs accueil',
    'articles'          => 'Articles',
    'narticle'          => 'Nouvel article',
    'marticle'          => 'Modifier article',
    'messages'          => 'Messages',
    'optimisationSeo'   => 'Optimisation SEO',
    'setting'           => 'Configuration générale',
    'admins'            => 'Administrateurs',
    'social_network'    => 'Réseaux sociaux',
    'templatesemail'    => 'Modèles email',
    'moyens_paiement'   => 'Moyens de paiement',
    'fraislivraison'    => 'Frais de livraison',
    'facilitePaiement'  => 'Facilité paiement',
    'servicess'         => 'Services',
    'caracteristiques'  => 'Caractéristiques',
    'equipements'       => 'Équipements',
    'pagesIntrouvables' => 'Pages introuvables',
    'recherches'        => 'Recherches',
];
$page_title = $page_titles[$current_route] ?? ucfirst(str_replace('_', ' ', $current_route));
?>

<!-- ========================================
     TOPBAR
     ======================================== -->
<header class="admin-topbar" id="adminTopbar" role="banner" style="display:flex;align-items:center;justify-content:space-between;">

    <!-- Gauche : Hamburger + Titre -->
    <div class="admin-topbar-left" style="display:flex;align-items:center;gap:1rem;flex:0 0 auto;">

        <!-- Bouton hamburger / collapse sidebar -->
        <button type="button" class="admin-topbar-btn" id="sidebarToggle"
                onclick="toggleSidebar()" aria-label="Ouvrir/fermer le menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px;">
                <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75H12a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
            </svg>
        </button>

        <!-- Titre + breadcrumb -->
        <div>
            <div class="admin-page-title"><?php echo htmlspecialchars($page_title); ?></div>
            <div class="admin-breadcrumb">
                <a href="index.php">Accueil</a>
                <?php if ($current_route !== '' && $current_route !== 'home'): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:10px;height:10px;flex-shrink:0;">
                    <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo htmlspecialchars($page_title); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Droite : Notifications + Toggle dark + User menu -->
    <div class="admin-topbar-right" style="display:flex;align-items:center;gap:0.625rem;flex:0 0 auto;margin-left:auto;">

        <!-- Lien vers le site public -->
        <a href="../index.php" target="_blank" class="admin-topbar-btn" title="Voir le site public" style="text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z"/>
            </svg>
        </a>

        <!-- Notifications commandes -->
        <div style="position:relative;">
            <button type="button" class="admin-topbar-btn" id="notifBtn"
                    onclick="toggleDropdown('notifDropdown')" aria-label="Notifications">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd"/>
                </svg>
                <span class="notif-dot" id="notifDot" style="display:none;"></span>
            </button>

            <!-- Dropdown notifications -->
            <div class="admin-dropdown" id="notifDropdown">
                <div class="admin-dropdown-header">Notifications</div>
                <div id="notifList">
                    <div class="admin-empty-state" style="padding:1.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:32px;height:32px;color:#A89FC5;">
                            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd"/>
                        </svg>
                        <p style="font-size:0.8125rem;color:#A89FC5;margin:0;">Aucune notification</p>
                    </div>
                </div>
                <div style="border-top:1px solid var(--color-border);padding:0.625rem;">
                    <a href="index.php?r=commandes" style="display:block;text-align:center;font-size:0.8125rem;color:var(--color-primary);font-weight:600;text-decoration:none;padding:0.25rem;">
                        Voir toutes les commandes →
                    </a>
                </div>
            </div>
        </div>

        <!-- Toggle dark mode -->
        <button type="button" class="admin-topbar-btn admin-dark-toggle" id="darkToggle"
                onclick="toggleAdminDark()" aria-label="Basculer mode sombre" style="position:relative;">
            <!-- Soleil (light mode) -->
            <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z"/>
            </svg>
            <!-- Lune (dark mode) -->
            <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd"/>
            </svg>
        </button>

        <!-- Avatar / Menu utilisateur -->
        <div style="position:relative;">
            <button type="button" class="admin-topbar-btn" id="userMenuBtn"
                    onclick="toggleDropdown('userDropdown')" aria-label="Menu utilisateur"
                    style="width:auto;padding:0 0.5rem;gap:0.5rem;">
                <!-- Avatar initiales -->
                <div class="admin-avatar" style="width:32px;height:32px;font-size:0.75rem;">
                    <?php
                    $prenom_t = isset($_SESSION['editor_id']) ? prenomClt($_SESSION['editor_id']) : '';
                    $nom_t    = isset($_SESSION['editor_id']) ? nomClt($_SESSION['editor_id']) : '';
                    echo strtoupper(mb_substr($prenom_t, 0, 1) . mb_substr($nom_t, 0, 1));
                    ?>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:0.8125rem;font-weight:600;color:var(--color-text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:none;" class="d-md-block">
                        <?php echo htmlspecialchars(trim($prenom_t . ' ' . $nom_t)); ?>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;color:var(--color-text-muted);flex-shrink:0;">
                    <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd"/>
                </svg>
            </button>

            <!-- Dropdown user menu -->
            <div class="admin-dropdown" id="userDropdown" style="width:220px;">
                <div style="padding:1rem;border-bottom:1px solid var(--color-border);">
                    <div style="font-weight:700;font-size:0.9rem;color:var(--color-text-primary);">
                        <?php echo htmlspecialchars(trim($prenom_t . ' ' . $nom_t)); ?>
                    </div>
                    <div style="font-size:0.75rem;color:var(--color-text-muted);margin-top:2px;">Administrateur</div>
                </div>
                    <a href="index.php?r=setting" class="admin-dropdown-item" style="color:var(--color-text-primary);text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;color:var(--color-text-muted);flex-shrink:0;">
                            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd"/>
                        </svg>
                        <span style="font-size:0.875rem;">Paramètres</span>
                    </a>
                    <a href="logout.php" class="admin-dropdown-item" style="color:var(--color-error);text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;flex-shrink:0;">
                            <path fill-rule="evenodd" d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 0 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z" clip-rule="evenodd"/>
                        </svg>
                        <span style="font-size:0.875rem;">Déconnexion</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</header>