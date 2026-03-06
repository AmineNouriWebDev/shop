<?php
/**
 * Admin Sidebar — left.php
 * Refonte Tailwind CSS + Heroicons SVG inline
 * Palette : dark violet sidebar (#1E1646)
 */

// Récupérer l'état actif du menu
$current_route = $_GET['r'] ?? '';

// Helper : classe active pour les items
function navActive($route, $current) {
    return $route === $current ? ' active' : '';
}

// Helper : classe active pour groupes (sous-menus)
function navGroupOpen($routes, $current) {
    return in_array($current, $routes) ? ' open' : '';
}
function navGroupActive($routes, $current) {
    return in_array($current, $routes) ? ' active' : '';
}
?>
<!-- Overlay mobile -->
<div class="admin-sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ========================================
     SIDEBAR
     ======================================== -->
<aside class="admin-sidebar" id="adminSidebar" aria-label="Navigation administration">

    <!-- Logo + Nom du site -->
    <a href="index.php" class="admin-sidebar-logo">
        <!-- Icône / Logo -->
        <?php if(!empty($favicon)): ?>
        <img src="../media/site/<?php echo htmlspecialchars($favicon); ?>" alt="Logo" style="width:32px;height:32px;object-fit:contain;flex-shrink:0;border-radius:6px;">
        <?php else: ?>
        <!-- Icône générique si pas de favicon -->
        <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#5A31F4,#0EA5E9);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:white">
                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
            </svg>
        </div>
        <?php endif; ?>
        <span class="admin-sidebar-logo-text"><?php echo htmlspecialchars($nom_site ?? 'Admin'); ?></span>
    </a>

    <!-- Navigation -->
    <nav class="admin-sidebar-nav" id="adminSidebarNav">

        <!-- ─── TABLEAU DE BORD ─── -->
        <div class="admin-nav-section">Principal</div>

        <a href="index.php" class="admin-nav-item<?php echo navActive('', $current_route); navActive('home', $current_route); ?>
            <?php echo ($current_route === '' || $current_route === 'home') ? ' active' : ''; ?>">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
            </svg>
            <span class="admin-nav-item-text">Tableau de bord</span>
        </a>

        <!-- ─── CATALOGUE ─── -->
        <div class="admin-nav-section" style="margin-top:0.5rem;">Catalogue</div>

        <!-- Gestion produits -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['produits','nproduits','mproduits','addproduit','addproduits','editproduits','addproduitssimilaire'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-produits', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
            </svg>
            <span class="admin-nav-item-text">Produits</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['produits','nproduits','mproduits','addproduit','addproduits','editproduits','addproduitssimilaire'], $current_route); ?>" id="submenu-produits">
            <a href="index.php?r=produits" class="admin-subnav-item<?php echo navActive('produits', $current_route); ?>">Liste des produits</a>
            <a href="index.php?r=nproduits" class="admin-subnav-item<?php echo navActive('nproduits', $current_route); ?>">Ajouter un produit</a>
        </div>

        <!-- Abonnements -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['abonnements','nabonnements','mabonnements'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-abonnements', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/>
            </svg>
            <span class="admin-nav-item-text">Abonnements</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['abonnements','nabonnements','mabonnements'], $current_route); ?>" id="submenu-abonnements">
            <a href="index.php?r=abonnements" class="admin-subnav-item<?php echo navActive('abonnements', $current_route); ?>">Liste des abonnements</a>
            <a href="index.php?r=nabonnements" class="admin-subnav-item<?php echo navActive('nabonnements', $current_route); ?>">Ajouter un abonnement</a>
        </div>

        <!-- Catégories / Marques -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['categories_blog','ncategorie_blog','mcategorie_blog','marques','nmarque','mMarque','categoriesMarques','caracteristiques','ncaracteristiques','mcaracteristiques'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-categ', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.608a18.166 18.166 0 0 0 5.198-3.86 3.398 3.398 0 0 0-.608-5.198L11.27 3.24a3 3 0 0 0-2.12-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd"/>
            </svg>
            <span class="admin-nav-item-text">Catégories & Marques</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['categories_blog','ncategorie_blog','mcategorie_blog','marques','nmarque','mMarque','categoriesMarques','caracteristiques','ncaracteristiques','mcaracteristiques'], $current_route); ?>" id="submenu-categ">
            <a href="index.php?r=categories_blog" class="admin-subnav-item<?php echo navActive('categories_blog', $current_route); ?>">Catégories</a>
            <a href="index.php?r=ncategorie_blog" class="admin-subnav-item<?php echo navActive('ncategorie_blog', $current_route); ?>">Nouvelle catégorie</a>
            <a href="index.php?r=marques" class="admin-subnav-item<?php echo navActive('marques', $current_route); ?>">Marques</a>
            <a href="index.php?r=nmarque" class="admin-subnav-item<?php echo navActive('nmarque', $current_route); ?>">Nouvelle marque</a>
            <a href="index.php?r=caracteristiques" class="admin-subnav-item<?php echo navActive('caracteristiques', $current_route); ?>">Caractéristiques</a>
        </div>

        <!-- ─── VENTES ─── -->
        <div class="admin-nav-section" style="margin-top:0.5rem;">Ventes</div>

        <!-- Commandes -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['commandes','dcommande','etat_commandes','netatcommande','metatcommande'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-cmds', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"/>
            </svg>
            <span class="admin-nav-item-text">Commandes</span>
            <span class="admin-nav-badge" id="badge-commandes" style="display:none;">0</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['commandes','dcommande','etat_commandes','netatcommande','metatcommande'], $current_route); ?>" id="submenu-cmds">
            <a href="index.php?r=commandes" class="admin-subnav-item<?php echo navActive('commandes', $current_route); ?>">Liste des commandes</a>
            <a href="index.php?r=etat_commandes" class="admin-subnav-item<?php echo navActive('etat_commandes', $current_route); ?>">États des commandes</a>
        </div>

        <!-- Paiement & Livraison -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['moyens_paiement','fraislivraison','facilitePaiement'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-paiement', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z"/>
                <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd"/>
            </svg>
            <span class="admin-nav-item-text">Paiement & Livraison</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['moyens_paiement','fraislivraison','facilitePaiement'], $current_route); ?>" id="submenu-paiement">
            <a href="index.php?r=moyens_paiement" class="admin-subnav-item<?php echo navActive('moyens_paiement', $current_route); ?>">Moyens de paiement</a>
            <a href="index.php?r=fraislivraison" class="admin-subnav-item<?php echo navActive('fraislivraison', $current_route); ?>">Frais de livraison</a>
            <a href="index.php?r=facilitePaiement" class="admin-subnav-item<?php echo navActive('facilitePaiement', $current_route); ?>">Facilité paiement</a>
        </div>

        <!-- ─── CLIENTS ─── -->
        <div class="admin-nav-section" style="margin-top:0.5rem;">Clients</div>

        <button type="button" class="admin-nav-item<?php echo navGroupActive(['clients','nclient','mclient'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-clients', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"/>
            </svg>
            <span class="admin-nav-item-text">Clients</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['clients','nclient','mclient'], $current_route); ?>" id="submenu-clients">
            <a href="index.php?r=clients" class="admin-subnav-item<?php echo navActive('clients', $current_route); ?>">Liste des clients</a>
            <a href="index.php?r=nclient" class="admin-subnav-item<?php echo navActive('nclient', $current_route); ?>">Ajouter un client</a>
        </div>

        <!-- ─── CONTENU ─── -->
        <div class="admin-nav-section" style="margin-top:0.5rem;">Contenu</div>

        <!-- Pages -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['pages','npage','mpage','sectionpage','bloc_accueil','mbloc_accueil','nbloc_accueil'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-pages', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"/>
                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/>
            </svg>
            <span class="admin-nav-item-text">Pages & Blocs</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['pages','npage','mpage','sectionpage','bloc_accueil','mbloc_accueil','nbloc_accueil'], $current_route); ?>" id="submenu-pages">
            <a href="index.php?r=pages" class="admin-subnav-item<?php echo navActive('pages', $current_route); ?>">Liste des pages</a>
            <a href="index.php?r=npage" class="admin-subnav-item<?php echo navActive('npage', $current_route); ?>">Nouvelle page</a>
            <a href="index.php?r=bloc_accueil" class="admin-subnav-item<?php echo navActive('bloc_accueil', $current_route); ?>">Blocs accueil</a>
        </div>

        <!-- Médias -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['sliders','nslider','mslider'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-medias', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd"/>
            </svg>
            <span class="admin-nav-item-text">Médias & Sliders</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['sliders','nslider','mslider'], $current_route); ?>" id="submenu-medias">
            <a href="index.php?r=sliders" class="admin-subnav-item<?php echo navActive('sliders', $current_route); ?>">Animations accueil</a>
            <a href="index.php?r=nslider" class="admin-subnav-item<?php echo navActive('nslider', $current_route); ?>">Nouvelle image</a>
        </div>

        <!-- Articles & Blog -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['articles','narticle','marticle'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-blog', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z"/>
            </svg>
            <span class="admin-nav-item-text">Articles & Blog</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['articles','narticle','marticle'], $current_route); ?>" id="submenu-blog">
            <a href="index.php?r=articles" class="admin-subnav-item<?php echo navActive('articles', $current_route); ?>">Liste des articles</a>
            <a href="index.php?r=narticle" class="admin-subnav-item<?php echo navActive('narticle', $current_route); ?>">Nouvel article</a>
        </div>

        <!-- ─── SYSTÈME ─── -->
        <div class="admin-nav-section" style="margin-top:0.5rem;">Système</div>

        <!-- Messages -->
        <a href="index.php?r=messages" class="admin-nav-item<?php echo navActive('messages', $current_route); ?>">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97Z" clip-rule="evenodd"/>
            </svg>
            <span class="admin-nav-item-text">Messages</span>
            <span class="admin-nav-badge" id="badge-messages" style="display:none;">0</span>
        </a>

        <!-- SEO -->
        <a href="index.php?r=optimisationSeo" class="admin-nav-item<?php echo navActive('optimisationSeo', $current_route); ?>">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd"/>
            </svg>
            <span class="admin-nav-item-text">Optimisation SEO</span>
        </a>

        <!-- Paramètres -->
        <button type="button" class="admin-nav-item<?php echo navGroupActive(['setting','admins','nadmin','social_network','nsocial_network','msocial_network','templatesemail'], $current_route); ?>"
                onclick="toggleSubmenu('submenu-settings', this)">
            <svg class="admin-nav-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd"/>
            </svg>
            <span class="admin-nav-item-text">Paramètres</span>
            <svg class="admin-nav-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="admin-nav-submenu<?php echo navGroupOpen(['setting','admins','nadmin','social_network','nsocial_network','msocial_network','templatesemail'], $current_route); ?>" id="submenu-settings">
            <a href="index.php?r=setting" class="admin-subnav-item<?php echo navActive('setting', $current_route); ?>">Config générale</a>
            <a href="index.php?r=admins" class="admin-subnav-item<?php echo navActive('admins', $current_route); ?>">Administrateurs</a>
            <a href="index.php?r=social_network" class="admin-subnav-item<?php echo navActive('social_network', $current_route); ?>">Réseaux sociaux</a>
            <a href="index.php?r=templatesemail" class="admin-subnav-item<?php echo navActive('templatesemail', $current_route); ?>">Modèles email</a>
        </div>

    </nav>

    <!-- Footer sidebar — Profil admin + déconnexion -->
    <div class="admin-sidebar-footer">
        <!-- Avatar initiales -->
        <div class="admin-avatar">
            <?php
            $prenom = '';
            $nom = '';
            if (isset($_SESSION['editor_id'])) {
                $prenom = prenomClt($_SESSION['editor_id']);
                $nom = nomClt($_SESSION['editor_id']);
            }
            echo strtoupper(mb_substr($prenom, 0, 1) . mb_substr($nom, 0, 1));
            ?>
        </div>
        <!-- Infos admin -->
        <div class="admin-sidebar-logo-text" style="flex:1;min-width:0;">
            <div style="font-size:0.8125rem;font-weight:600;color:#fff;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                <?php echo htmlspecialchars(trim($prenom . ' ' . $nom)); ?>
            </div>
            <div style="font-size:0.7rem;color:#A89FC5;margin-top:1px;">Administrateur</div>
        </div>
        <!-- Bouton déconnexion -->
        <a href="logout.php" title="Déconnexion"
           style="width:30px;height:30px;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#A89FC5;transition:all 200ms;text-decoration:none;flex-shrink:0;"
           onmouseover="this.style.color='#F43F5E';this.style.background='rgba(244,63,94,0.1)'"
           onmouseout="this.style.color='#A89FC5';this.style.background='transparent'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                <path fill-rule="evenodd" d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 0 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z" clip-rule="evenodd"/>
            </svg>
        </a>
    </div>

</aside>