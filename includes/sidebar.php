<?php
// Modern sidebar implementation for the website
// This will be included in the pages where a sidebar is needed
?>

<div class="modern-sidebar-container">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="modern-sidebar" id="modernSidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <a href="<?php echo lienAccueil(); ?>">
                    <img src="media/site/<?php echo $logo; ?>" alt="Logo" class="sidebar-logo">
                </a>
            </div>
            <button type="button" class="sidebar-close" id="sidebarClose">
                <i class="fa fa-times"></i>
            </button>
        </div>
        
        <div class="sidebar-body">
            <div class="sidebar-search mb-4">
                <form action="<?php echo lienRecherche(); ?>" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="recherche" placeholder="Rechercher..." value="<?php if ((isset($_POST['action']) && $_POST['action'] == 'search')){ echo $_POST['recherche']; } else { echo  ''; }  ?>">
                        <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
                    </div>
                    <input type="hidden" name="action" value="search">
                </form>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="sidebar-menu">
                    <?php
                    // Categories with dropdown
                    $requete2 = "SELECT * FROM `categories_blog` WHERE`etat` = '1' AND `idparent`='0' ORDER BY `ordre`";
                    $resultat2 = executeRequete($requete2);
                    
                    while($data2 = mysqli_fetch_array($resultat2)) {
                        $requete3 = "SELECT * FROM `categories_blog` WHERE `etat` = '1' AND  `idparent`='".$data2['id']."' ORDER BY `ordre`";
                        $resultat3 = executeRequete($requete3);
                        $num3 = mysqli_num_rows($resultat3);
                    ?>
                    <li class="sidebar-item <?php if($num3){ ?>has-submenu<?php } ?>">
                        <a href="<?php echo lienCategories($data2['link']); ?>" class="sidebar-link">
                            <?php echo afficheChamp1($data2['titre']); ?>
                            <?php if($num3){ ?><span class="submenu-arrow"><i class="fa fa-angle-down"></i></span><?php } ?>
                        </a>
                        
                        <?php if($num3){ ?>
                        <ul class="submenu">
                            <?php while($data3 = mysqli_fetch_array($resultat3)) { ?>
                            <li class="submenu-item">
                                <a href="<?php echo lienCategorieEquipements($data3['link']); ?>" class="submenu-link">
                                    <?php echo afficheChamp1($data3['titre']); ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                    
                    <?php
                    // Menu items with dropdown
                    $requete1 = "SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='0' ORDER BY `ordre`";
                    $resultat1 = executeRequete($requete1);
                    
                    while($data1 = mysqli_fetch_array($resultat1)) {
                        $requete2 = "SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='".$data1['id']."' ORDER BY `ordre`";
                        $resultat2 = executeRequete($requete2);
                        $num2 = mysqli_num_rows($resultat2);
                    ?>
                    <li class="sidebar-item <?php if($num2){ ?>has-submenu<?php } ?>">
                        <a href="<?php echo lienContenu($data1['id']); ?>" class="sidebar-link">
                            <?php echo mb_convert_encoding(titrePage($data1['id']), 'ISO-8859-1', 'UTF-8'); ?>
                            <?php if($num2){ ?><span class="submenu-arrow"><i class="fa fa-angle-down"></i></span><?php } ?>
                        </a>
                        
                        <?php if($num2){ ?>
                        <ul class="submenu">
                            <?php while($data2 = mysqli_fetch_array($resultat2)) { ?>
                            <li class="submenu-item">
                                <a href="<?php echo lienContenu($data2['id']); ?>" class="submenu-link">
                                    <?php echo mb_convert_encoding(titrePage($data2['id']), 'ISO-8859-1', 'UTF-8'); ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        
        <div class="sidebar-footer">
            <div class="sidebar-social">
                <a href="#" class="social-link"><i class="fa fa-facebook"></i></a>
                <a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fa fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fa fa-linkedin"></i></a>
            </div>
            <?php if(isset($_SESSION['id_client'])) { ?>
            <a href="deconnexion.php" class="btn btn-logout"><i class="fa fa-sign-out"></i> Déconnexion</a>
            <?php } else { ?>
            <a href="connexion.php" class="btn btn-login"><i class="fa fa-user"></i> Connexion</a>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Sidebar Toggle Button for Mobile -->
<button type="button" class="sidebar-toggle" id="sidebarToggle">
    <i class="fa fa-bars"></i>
</button>