<?php

session_start();

include("includes/include.php");

include("includes/security.php");

?> 

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="">

	<meta http-equiv="Content-Language" content="ar">

    <!-- Favicon icon -->

    <title>Tableau de bord</title>

    <?php include("includes/scripts.php"); ?>
    <style>
        
    .sidebar-nav>ul>li.active>a {
        background: #e9ecef!important;
    }
        
    </style>

</head>



<body class="fix-header fix-sidebar card-no-border admin-layout" id="adminBody">

    <!-- ============================================================== -->

    <!-- Preloader - style you can find in spinners.css -->

    <!-- ============================================================== -->

    <!-- Preloader admin -->
    <div class="preloader" id="adminPreloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- ============================================================== -->

    <!-- Main wrapper - style you can find in pages.scss -->

    <!-- ============================================================== -->

    <div id="main-wrapper">

        <!-- ============================================================== -->

        <!-- Topbar header - style you can find in pages.scss -->

        <!-- ============================================================== -->

        <?php include("includes/header.php");?>

        <!-- ============================================================== -->

        <!-- End Topbar header -->

        <!-- ============================================================== -->

        <!-- ============================================================== -->

        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <!-- ============================================================== -->

        <?php include("includes/left.php");?>

        <!-- ============================================================== -->

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- ============================================================== -->

        <!-- CONTENU PRINCIPAL -->
        <main class="admin-content" id="adminContent">

            <div class="container-fluid" style="padding:0;">

              <?php



			switch ($_GET['r'] ?? ''){

			 case "pages" : 

			 include("includes/fonctions/fction_pages.php"); 
			 include("includes/pages.php");

			 break;

			 case "npage" : 

			 include("includes/fonctions/fction_pages.php"); 

			 include("includes/ajouter_page.php");

			 break;

			 case "mpage" : 

			 include("includes/fonctions/fction_pages.php"); 

			 include("includes/modifier_page.php");

			 break;

			 case "sectionpage" : 

			 include("includes/fonctions/fction_pages.php"); 

			 include("includes/section_page.php");

			 break;

			 case "commandes" : 

			 include("includes/fonctions/fction_clients.php"); 

			 include("includes/fonctions/fction_commandes.php"); 

			 include("includes/fonctions/fction_produits.php");   

             include("includes/fonctions/fction_emails.php"); 

			 include("includes/commandes.php");

			 break;

			 case "dcommande" : 

			 include("includes/fonctions/fction_clients.php"); 

			 include("includes/fonctions/fction_commandes.php");

			 include("includes/fonctions/fction_produits.php");  

             include("includes/fonctions/fction_emails.php"); 

			 include("includes/details_commande.php");

			 break;

			 case "services" : 

			 include("includes/fonctions/fction_services.php"); 

			 include("includes/services.php");

			 break;
			 
			 case "nservice" : 

			 include("includes/fonctions/fction_services.php"); 

			 include("includes/ajouter_service.php");

			 break;
			 
			 case "mservice" : 

			 include("includes/fonctions/fction_services.php"); 

			 include("includes/modifier_service.php");

			 break;

			 case "addproduitssimilaire" :

			 include("includes/fonctions/fction_produits.php");
			 
			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/add_produits_similaire.php");

			 break;

			 case "pagesIntrouvables" :

			 include("includes/pages_introuvables.php");

			 break;

			 case "addproduit" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/fonctions/fction_produits.php");

			 include("includes/add_produit.php");

			 break;

			 case "addproduits" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/fonctions/fction_produits.php");

			 include("includes/add_produits.php");

			 break;

			 case "editproduits" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/fonctions/fction_produits.php");

			 include("includes/edit_produits.php");

			 break;

			 case "addSectionContent" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/add_section_content.php");

			 break;

			 case "editSectionContent" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/edit_section_content.php");

			 break;

			 case "bloc_accueil" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/bloc_accueil.php");

			 break;

			 case "mbloc_accueil" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/modifier_bloc_accueil.php");

			 break;

			 case "nbloc_accueil" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/ajouter_bloc_accueil.php");

			 break; 

			 case "applications" :

			 include("includes/fonctions/fction_applications.php"); 

			 include("includes/applications.php");

			 break;

			 case "mapplications" :

			 include("includes/fonctions/fction_applications.php"); 

			 include("includes/modifier_application.php");

			 break;

			 case "napplications" :

			 include("includes/fonctions/fction_applications.php"); 

			 include("includes/ajouter_application.php");

			 break; 

			 case "icones" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/icones.php");

			 break;

			 case "micones" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/modifier_icone.php");

			 break;

			 case "nicones" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/ajouter_icone.php");

			 break; 

			 case "listeSection" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/liste_sections.php");

			 break;

			 case "mlisteSection" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/modifier_liste_sections.php");

			 break;

			 case "nlisteSection" :

			 include("includes/fonctions/fction_bloc_accueil.php"); 

			 include("includes/ajouter_liste_sections.php");

			 break; 

			 case "sliders" : 

			 include("includes/fonctions/fction_sliders.php"); 

			 include("includes/sliders.php");

			 break;

			 case "nslider" : 

			 include("includes/fonctions/fction_sliders.php"); 

			 include("includes/ajouter_slider.php");

			 break;

			 case "mslider" : 

			 include("includes/fonctions/fction_sliders.php"); 

			 include("includes/modifier_slider.php");

			 break;
			 
			 case "fichesTechniques" :

			 include("includes/fonctions/fction_produits.php");  

			 include("includes/fichesTechniques.php");

			 break;
			 
			 case "facilitePaiement" :

			 include("includes/fonctions/fction_produits.php");  

			 include("includes/facilitePaiement.php");

			 break;

			 case "villes" : 

			 include("includes/fonctions/fction_villes.php"); 

			 include("includes/villes.php");

			 break;

			 case "nvilles" : 

			 include("includes/fonctions/fction_villes.php"); 

			 include("includes/ajouter_villes.php");

			 break;

			 case "mvilles" : 

			 include("includes/fonctions/fction_villes.php"); 

			 include("includes/modifier_villes.php");

			 break;

			 case "equipements" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/equipements.php");

			 break;

			 case "nequipements" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/ajouter_equipements.php");

			 break;

			 case "mequipements" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/modifier_equipements.php");

			 break;

			 case "produits" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/produits.php");

			 break;

			 case "nproduits" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/ajouter_produits.php");

			 break;

			 case "mproduits" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/modifier_produits.php");

			 break;

			 case "categoriesMarques" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/categories_marques.php");

			 break;  

			 case "abonnements" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/abonnements.php");

			 break;

			 case "nabonnements" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/ajouter_abonnements.php");

			 break;

			 case "mabonnements" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/modifier_abonnements.php");

			 break;

			 case "caracteristiques" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/caracteristiques.php");

			 break;

			 case "valeurcaracteristiques" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/valeurs_caracteristique.php");

			 break;

			 case "ncaracteristiques" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/ajouter_caracteristiques.php");

			 break;

			 case "mcaracteristiques" : 

			 include("includes/fonctions/fction_produits.php"); 

			 include("includes/modifier_caracteristiques.php");

			 break;

			 case "etablissements" : 

			 include("includes/fonctions/fction_etablissements.php"); 

			 include("includes/etablissements.php");

			 break;

			 case "netablissement" : 

			 include("includes/fonctions/fction_etablissements.php"); 

			 include("includes/ajouter_etablissement.php");

			 break;

			 case "metablissement" : 

			 include("includes/fonctions/fction_etablissements.php"); 

			 include("includes/modifier_etablissement.php");

			 break;

			 case "points_forts" : 

			 include("includes/fonctions/fction_points_forts.php"); 

			 include("includes/points_forts.php");

			 break;

			 case "npointfort" : 

			 include("includes/fonctions/fction_points_forts.php"); 

			 include("includes/ajouter_point_fort.php");

			 break;

			 case "mpointfort" : 

			 include("includes/fonctions/fction_points_forts.php"); 

			 include("includes/modifier_point_fort.php");

			 break;


			 case "etat_commandes" :
			     
			 include("includes/fonctions/fction_commandes.php");
			 
			 include("includes/etat_commandes.php");
			 
			 break;
			 
			 case "netatcommande" : 
			     
			 include("includes/fonctions/fction_commandes.php");
			 
			 include("includes/ajouter_etat_commande.php");
			 
			 break;
			 
			 case "metatcommande" : 
			     
			 include("includes/fonctions/fction_commandes.php");
			 
			 include("includes/modifier_etat_commande.php");
			 
			 break;
			 
             
             case "clients" : 
                 
			 include("includes/fonctions/fction_clients.php");
			 
			 include("includes/client.php");
			 
			 break;

			 case "nclient" : 
			     
			 include("includes/fonctions/fction_clients.php"); 
			 
			 include("includes/ajouter_client.php");
			 
			 break;

			 case "mclient" : 
			     
			 include("includes/fonctions/fction_clients.php"); 
			 
			 include("includes/modifier_client.php");
			 
			 break;


			 case "evenements" : 

			 include("includes/fonctions/fction_evenements.php"); 

			 include("includes/evenements.php");

			 break;

			 case "nevenement" : 

			 include("includes/fonctions/fction_evenements.php"); 

			 include("includes/ajouter_evenement.php");

			 break;

			 case "mevenemnts" : 

			 include("includes/fonctions/fction_evenements.php"); 

			 include("includes/modifier_evenement.php");

			 break;

			 case "categories_blog" : 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/categories_blog.php");

			 break;

			 case "ncategorie_blog" : 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/ajouter_categorie_blog.php");

			 break;		

			 case "mcategorie_blog" : 

			 include("includes/fonctions/fction_blogs.php");

			 include("includes/modifier_categorie_blog.php");

			 break;

			 case "articles" : 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/articles.php");

			 break;

			 case "narticle" : 

			 include("includes/fonctions/fction_blogs.php"); 

			 include("includes/ajouter_article.php");

			 break;		

			 case "marticle" : 

			 include("includes/fonctions/fction_blogs.php");

			 include("includes/modifier_article.php");

			 break;	
			 case "marques" :

			 include("includes/fonctions/fction_produits.php");  

			 include("includes/marques.php");

			 break;
			 
			 case "nmarque" :

			 include("includes/fonctions/fction_produits.php");  

			 include("includes/ajouter_marque.php");

			 break;
			 
			 case "mMarque" :

			 include("includes/fonctions/fction_produits.php");  

			 include("includes/modifier_marque.php");

			 break;			 

			 case "setting" : 

			 include("includes/setting.php");

			 break;

             case "social_network" : 

			 include("includes/fonctions/fction_social_network.php"); 

			 include("includes/social_network.php");

			 break;  

             case "nsocial_network" : 

			 include("includes/fonctions/fction_social_network.php"); 

			 include("includes/ajouter_social_network.php");

			 break;

			 case "msocial_network" : 

			 include("includes/fonctions/fction_social_network.php");  

			 include("includes/modifier_social_network.php");

			 break; 
			 
			 case "recherches" :

			 include("includes/fonctions/fction_recherches.php");  

			 include("includes/recherches.php");

			 break; 

			 case "messages" :

			 include("includes/fonctions/fction_messages.php");  

			 include("includes/messages.php");

			 break;  

             case "dmessage":

			 include("includes/fonctions/fction_messages.php"); 

			 include("includes/detail_message.php");

			 break; 

			 case "admins" : 

			 include("includes/admins.php");

			 break;  

             case "nadmin" : 

			 include("includes/ajouter_admin.php");

			 break;

			 case "madmin" : 

			 include("includes/modifier_admin.php");

			 break; 

             case "templatesemail" :

             include("includes/fonctions/fction_emails.php"); 

			 include("includes/templates_email.php");

			 break;  

             case "mtemplateemail" : 

			 include("includes/fonctions/fction_emails.php"); 

			 include("includes/modifier_template_email.php");

			 break;	

			 case "moyens_paiement" : 
			 
			 include("includes/fonctions/fction_moyens_paiement.php");
			 
			 include("includes/moyens_paiement.php");
			 
			 break;
			 
			 case "nmoyenpaiement" :
			 
			 include("includes/fonctions/fction_moyens_paiement.php");
			 
			 include("includes/ajouter_moyen_paiement.php");
			 
			 break;
			 
			 case "mmoyenpaiement" : 
			 
			 include("includes/fonctions/fction_moyens_paiement.php");
			 
			 include("includes/modifier_moyen_paiement.php");
			 
			 break;	

			 case "fraislivraison" : 
			 
			 include("includes/fonctions/fction_moyens_paiement.php");
			 
			 include("includes/frais_livraison.php");
			 
			 break;
			 
			 case "nfraislivraison" :
			 
			 include("includes/fonctions/fction_moyens_paiement.php");
			 
			 include("includes/ajouter_frais_livraison.php");
			 
			 break;
			 
			 case "mfraislivraison" : 
			 
			 include("includes/fonctions/fction_moyens_paiement.php");
			 
			 include("includes/modifier_frais_livraison.php");
			 
			 break;	
			 
			 case "optimisationSeo" : 
			 
			 include("includes/optimisation_seo.php");
			 
			 break;		 

			 default : 

			 include("includes/home.php");

			 }

			?>

                <?php //include("includes/home.php"); ?>

            </div>

            <!-- ============================================================== -->

            <!-- End Container fluid  -->

            </div><!-- end container-fluid -->

            <?php include("includes/footer.php"); ?>

        </main><!-- end admin-content -->

    </div><!-- end main-wrapper -->

    <!-- ============================================================== -->

    <!-- End Wrapper -->

    <!-- ============================================================== -->

    <!-- ============================================================== -->

    <!-- All Jquery -->

    <!-- ============================================================== -->

    <?php include("includes/scripts_footer.php"); ?>

</body>



</html>