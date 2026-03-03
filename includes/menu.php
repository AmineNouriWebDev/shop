	

<div class="search-section mt-4 "><!--d-lg-none d-sm-block-->
            	    <div class="container" style="max-width: 1400px;">
            	        
            		    <div class=" d-flex align-items-center justify-content-between">
            		        
			                <a class="navbar-brand" href="<?php echo lienAccueil();?>"><img src="media/site/<?php echo $logo;?>" class="logo-navbar" style="max-width:120px"></a>
            		        <div class="d-flex justify-content-end w-75">
                			    <form action="<?php echo lienRecherche(); ?>" method="POST" class="w-100 pr-3 d-none d-lg-block d-xl-block d-xxl-block">
                					    <div class="input-group">
                    		                <input type="text" class="form-control" name="recherche" placeholder="Rechercher..." value="<?php if ((isset($_POST['action']) && $_POST['action'] == 'search')){ echo $_POST['recherche']; } else { echo  ''; }  ?>" aria-label="Text input with dropdown button">
                    		                <button type="submit" class="input-group-text"><i class="fa fa-search pe-4"></i></button>
                		                </div>
                                            <input type="hidden" name="action" value="search">
                		        </form>
                		        <a href="<?php echo lienPanier(); ?>" class="cart-nav d-flex align-items-center justify-content-end" style="width:170px"><img src="dist/img/cart.png" class="img-fluid mr-2 border-right pr-2" style="object-fit:contain">  <div> VOTRE PANIER <br> <span id="blocDepartementsPanier" style="color: #e7206a;font-weight: 600;"><?php  if ($nbArticles) echo ''.$nbArticles.''; else echo '0'; ?></span> produit(s)</div></a>
            		        </div>
            		    </div>
            	    </div>
            	</div>
	
	
	<!---------------- Nav-bar ----------------------->
	
	
	<nav class="navbar navbar-expand-lg navbar-light ">
		
		<div class="container justify-content-end align-items-center" style="max-width: 1400px;">
		    
		    
            <div class="search-section w-75 d-lg-none d-sm-block">
                <form action="<?php echo lienRecherche(); ?>" method="POST" class="w-100 pr-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="recherche" placeholder="Rechercher..." value="<?php if ((isset($_POST['action']) && $_POST['action'] == 'search')){ echo $_POST['recherche']; } else { echo  ''; }  ?>" aria-label="Text input with dropdown button">
                        <button type="submit" class="input-group-text"><i class="fa fa-search pe-4"></i></button>
                    </div>
                    <input type="hidden" name="action" value="search">
                </form>
            </div>

			<button class="navbar-toggler m-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<!-- Sidebar Toggle Button for Mobile -->
			<button type="button" class="sidebar-toggle d-lg-none" id="sidebarToggle">
				<i class="fa fa-bars"></i>
			</button>
			
    			<div class="collapse navbar-collapse" id="navbarSupportedContent">
    
    				<ul class="navbar-nav ml-auto">
    					
    				<?php
    
    		           $requete2 ="SELECT * FROM `categories_blog` WHERE`etat` = '1' AND `idparent`='0' ORDER BY `ordre`";
    
    	               $resultat2 = executeRequete($requete2);
    				   
    					   
    	               while($data2 = mysqli_fetch_array($resultat2)) {
    
    					    $requete3 ="SELECT * FROM `categories_blog` WHERE `etat` = '1' AND  `idparent`='".$data2['id']."' ORDER BY `ordre`";
    
    	                    $resultat3 = executeRequete($requete3);
    
    	                    $num3     = mysqli_num_rows($resultat3);
    		        ?>
    		        	<li class="nav-item <?php if($num3){ ?>dropdown<?php } ?>">
    
    						<a class="nav-link <?php if($num3){ ?>dropdown-toggle<?php } ?>" href="<?php echo lienCategories($data2['link']); ?>" data-bs-toggle="dropdownHover" id="navbarDropdown" data-bs-trigger="hover"  aria-haspopup="true"> <!-- <?php if($num3){ ?>id="navbarDropdown<?php echo $data2['id']; ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"<?php } ?> -->
    						    <?php echo afficheChamp1($data2['titre']); ?> <?php if($num3){ ?><i class="fa fa-angle-down"></i><span class="sr-only">(current)</span><?php } ?>
    						</a>
                            <?php if($num3){ ?><i class="fa fa-angle-down"></i><?php } ?>
                               <?php if($num3){ ?>
    
    							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    
                                <?php  while($data3 = mysqli_fetch_array($resultat3)) { ?>
    
    							    <a class="dropdown-item" href="<?php echo lienCategorieEquipements($data3['link']); ?>"><?php echo afficheChamp1($data3['titre']); ?></a>
    
                                <?php } ?>
    
    							</div>
    
                                <?php } ?>
    
    					</li>
    					
    					
                        <?php } ?>
    				
    				    
    				<?php
    
    		           $requete1 ="SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='0' ORDER BY `ordre`";
    
    	               $resultat1 = executeRequete($requete1);
    				   
    					   
    	               while($data1 = mysqli_fetch_array($resultat1)) {
    
    					    $requete2 ="SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='".$data1['id']."' ORDER BY `ordre`";
    
    	                    $resultat2 = executeRequete($requete2);
    
    	                    $num2      = mysqli_num_rows($resultat2);
    		        ?>
    		        	<li class="nav-item <?php if($num2){ ?>dropdown<?php } ?>">
    
    						<a class="nav-link <?php if($num2){ ?>dropdown-toggle<?php } ?>" <?php if(stylePage($data1['id'])){ echo "style='".stylePage($data1['id'])."'"; } ?> href="<?php if(link_externePage($data1['id']) !='' ) echo link_externePage($data1['id']);else echo lienContenu($data1['id']); ?>" >
    						    <?php echo titrePage($data1['id']); ?> 
    						    <?php if($num2){ ?><i class="fa fa-angle-down"></i><span class="sr-only">(current)</span><?php } ?>
    						</a>
                            <?php if($num2){ ?><i class="fa fa-angle-down"></i><?php } ?>
                               <?php if($num2){ ?>
    
    							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    
                                <?php  while($data2 = mysqli_fetch_array($resultat2)) { ?>
    
    							    <a class="dropdown-item" href="<?php if(link_externePage($data2['id']) !='' ) echo link_externePage($data2['id']);else echo lienContenu($data2['id']); ?>"><?php echo titrePage($data2['id']); ?></a>
    
                                <?php } ?>
    
    							</div>
    
                                <?php } ?>
    
    					</li>
    					
    					
                    <?php } ?>
    				
    				</ul>
    				
    				<?php if(isset($_SESSION['client_id'])) {?>
    				<a href="<?php echo lienCompte(); ?>" class="btn btn-acces"><img src="dist/img/customer-feedback.png" /> Mon compte </a>
    				<a href="<?php echo lienDeconnexion(); ?>" class="p-2 logout"><i class="fa fa-power-off"></i></a>
    				<?php } else { ?>
    				<a href="<?php echo lienConnexion(); ?>" class="btn btn-acces ml-lg-2"><img src="dist/img/customer-feedback.png" /> Accès clients </a>
    				<?php } ?>
    			</div>
    			
		</div>
	</nav>
	<!---------------- Fin Nav-bar ------------------>
	
	<script type="text/javascript">
    $(document).ready(function () {
        var url = window.location;
        $('ul.navbar-nav a[href="'+ url +'"]').parent().addClass('active');
        $('ul.navbar-nav a').filter(function() {
             return this.href == url;
        }).parent().addClass('active');
    });
    $(document).ready(function() {

        $('.dropdown').mouseenter(function() {
            $(this).addClass('show')
            $(this).children('.dropdown-menu').addClass('show');
        });
    
        $('.dropdown').mouseleave(function() {
            $(this).removeClass('show');
            $(this).children('.dropdown-menu').removeClass('show');
        });
    });
    /*$(document).ready(function() {
        $('.dropdown').bind('touchstart', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $(this).children('.dropdown-menu').toggleClass('show');
        });
    });*/
	</script>
	
	