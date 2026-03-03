<aside class="left-sidebar">

            <!-- Sidebar scroll-->

            <div class="scroll-sidebar" >

                <!-- User profile -->

                <div class="user-profile">

                    <!-- User profile image -->

                    <div class="profile-img"> <img src="../assets/images/users/profile.png" alt="user" />

                        <!-- this is blinking heartbit-->

                        <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>

                    </div>

                    <!-- User profile text-->

                    <div class="profile-text">

                        <h5><?php echo nomClt($_SESSION['editor_id'])." ".prenomClt($_SESSION['editor_id'])?></h5>

                        <a href="index.php?r=setting" class="" data-toggle="" role="" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>

                        <a href="logout.php" class="" data-toggle="tooltip" title="Déconnexion"><i class="mdi mdi-power"></i></a>

                    </div>

                </div>

                <!-- End User profile text-->

                <!-- Sidebar navigation-->

                <nav class="sidebar-nav">

                    <ul id="sidebarnav">

                        <li class="nav-devider"></li>

                                                 

                       <li class="nav-small-cap">Menu</li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Gestion contenus</span></a>

                            <ul aria-expanded="false" class="collapse">

                                <li><a href="index.php?r=pages">Listes des pages </a></li>

                                <li><a href="index.php?r=npage">Nouvelle page</a></li>

                                <li><a href="index.php?r=bloc_accueil">Blocs accueil</a></li>

                            </ul>

                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-folder-multiple"></i><span class="hide-menu">Sections</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=listeSection">Liste sections</a></li>
                              
                              <li><a href="index.php?r=services">Services</a></li>

                            </ul>

                        </li> 

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-folder-multiple-image"></i><span class="hide-menu">Medias</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=sliders">Animation Acceuil</a></li>

                              <li><a href="index.php?r=nslider">Nouvelle image animation</a></li>

                            </ul>

                        </li> 
                        
                        <hr>


						<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file-tree"></i><span class="hide-menu">Gestion catégories</span></a>
						
							<ul aria-expanded="false" class="collapse">   
							
								<li><a href="index.php?r=categories_blog">Listes des catégorie</a></li>  
								
								<li><a href="index.php?r=ncategorie_blog">Nouvelle catégorie</a></li>   

							</ul>       

						</li>
 	
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-memory"></i><span class="hide-menu">Gestion des caractéristiques</span></a> 
							
							<ul aria-expanded="false" class="collapse">
							
								<li><a href="index.php?r=caracteristiques">Listes des caractéristiques</a></li> 
								
								<li><a href="index.php?r=ncaracteristiques">Ajouter une caractéristique</a></li>   
							
							</ul>	
						
						</li> 

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-circle"></i><span class="hide-menu">Clients</span></a>
                            
                            <ul aria-expanded="false" class="collapse">
                                
                              <li><a href="index.php?r=clients">Listes des clients</a></li>
                              
                              <li><a href="index.php?r=nclient">Ajouter un client</a></li>
                              
                            </ul>
                        
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cards"></i><span class="hide-menu">Gestion produits</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=produits">Listes des produits</a></li>
                              
                              <li><a href="index.php?r=nproduits">Ajouter un produit</a></li>

                            </ul>

                        </li> 

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cards"></i><span class="hide-menu">Gestion des applications</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=applications">Listes des applications</a></li>
                              
                              <li><a href="index.php?r=napplications">Ajouter une application</a></li>

                            </ul>

                        </li> 
 	
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-box-shadow"></i><span class="hide-menu">Gestion marques</span></a> 
							
							<ul aria-expanded="false" class="collapse">
							
								<li><a href="index.php?r=marques">Listes des marques</a></li> 
								
								<li><a href="index.php?r=nmarque">Ajouter une marque</a></li>   
							
							</ul>	
						
						</li> 
						
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-credit-card-alt"></i><span class="hide-menu">Ventes</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=commandes">Liste des commandes</a></li>
                              
                              <li><a href="index.php?r=etat_commandes">Gestion états commandes</a></li>

                            </ul>

                        </li> 
                        
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Gestion des moyens de paiement</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=moyens_paiement">Moyens de paiement</a></li>

                            </ul>

                        </li>
                        
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-truck"></i><span class="hide-menu">Gestion des frais de livraison</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=fraislivraison">Liste des frais de livraison</a></li>

                            </ul>

                        </li>
                        
                        <hr>
                        
                         
                        <li> <a class="waves-effect waves-dark" href="index.php?r=optimisationSeo" aria-expanded="false"><i class="fa fa-yoast"></i><span class="hide-menu">Optimisations Seo</span></a> </li>
                        
                        <hr>
                        
                         
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-message"></i><span class="hide-menu">Gestion messages</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=messages">Listes des messages</a></li>

                              <li><a href="index.php?r=pagesIntrouvables">Listes des pages introuvables </a></li>

                            </ul>

                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Paramètres</span></a>

                            <ul aria-expanded="false" class="collapse">

                              <li><a href="index.php?r=admins">Administrateurs</a></li>

                              <li><a href="index.php?r=nadmin">Ajouter un administrateur</a></li>

                              <li><a href="index.php?r=setting">Config générale</a></li>

                              <li><a href="index.php?r=icones">Liste des icones</a></li>
							  
							  <li><a href="index.php?r=templatesemail">Modèles Email</a></li>

                              <li><a href="index.php?r=social_network">Réseaux sociaux</a></li>

                              <li><a href="index.php?r=nsocial_network">Ajouter un réseau social</a></li>

                            </ul>

                        </li>  

                                                

                    </ul>

                </nav>

                <!-- End Sidebar navigation -->

            </div>

            <!-- End Sidebar scroll-->

        </aside>